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
    if (!empty($username) && !empty($email) && !empty($password)) {
        $email = trim($email);
        $password = trim($password);
        $username=trim($username);

        // Check if the user exists in the database
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND username='$username'";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 1) {
            // User found, redirect to login page
            echo '<script>alert("Already a user! Please Login");</script>';
            echo '<script>window.location.href = "index.html";</script>'; 
            
            exit();
        } else {
            // Insert the new user into the database
            $insert_sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            if ($conn->query($insert_sql) === TRUE) {
                echo '<script>window.localStorage.setItem("username", "' . $username . '");';
                echo 'window.location.href = "index.html?success=true";</script>';

                exit(); // Make sure to stop execution after redirection
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        }
    } else {
        // Missing email or password
        echo "Please enter both email and password.";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="signup.css">
<title>Sign Up</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Sign Up</h2>
        <label class="font" for="username">Username:</label>
        <input  class="box" type="text" id="username" name="username" placeholder="enter username" required><br>
        <label class="font" for="email" >Email:</label>
        <input type="email" id="email" name="email" placeholder="enter mail" required><br>
        <label class="font" for="password" >Password:</label>
        <input type="password" id="password" placeholder="must be of 8 character" name="password" pattern=".{8,}" title="Password must be at least 8 characters long" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
