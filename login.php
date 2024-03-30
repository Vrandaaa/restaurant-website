<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "cherish_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username=$_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Validate form data (you might want to add more robust validation)
    if (!empty($email) && !empty($password)) {
        // Trim whitespace
        $username=trim($username);
        $email = trim($email);
        $password = trim($password);

        // Check if the user exists in the database
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND username='$username'";

        $result = $conn->query($sql);
        
        if ($result->num_rows==1) {
            // User found, check password
            
            echo '<script>alert("Login Successful!");';
            echo 'window.localStorage.setItem("email", "' . $email . '");'; 
            echo 'window.localStorage.setItem("username", "' . $username . '");';
            echo 'window.location.href = "index.html";</script>';
            exit();}
            
        
         else {
            // User not found, show signup message and redirect to signup page
            echo '<script>alert("You are not logged in, please sign up.");</script>';
            echo '<script>window.location.href = "signup.php";</script>';
            exit(); // Stop execution after redirection
        }
    } else {
        // Missing email or password
        echo "Please enter both email and password.";
    }
}
?>

