<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="orderonline.css">
    <title>Order Online</title>
    <style>
        /* CSS for centering the link */
        .center-link {
            text-align: center;
            margin-top: 20px; /* Adjust margin as needed */
        }
    </style>
</head>
<body>
    <header>
        <h1>Order placed successfully</h1>
    </header>
    <div class="center-link">
        <a href="index.html">Go back to home page</a>
    </div>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $city = $_POST["city"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $price = $_POST["price"];
    $item = $_POST["item"];
    $cookingRequest = isset($_POST["cookingRequest"]) ? $_POST["cookingRequest"] : "";
    $noCutlery = isset($_POST["noCutlery"]) ? "Yes" : "No";

    // Validate and sanitize the data (you can add more validation if needed)
    // For demonstration purpose, let's just check if required fields are not empty
    if (empty($name) || empty($city) || empty($address) || empty($phone) || empty($email) || empty($price) || empty($item)) {
        // Handle empty fields error
        echo "Please fill in all the required fields.";
    } else {
        // Connect to your database (you need to replace these placeholders with your actual database credentials)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cherish_db";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO orders (name, city, address, phone, email, price, item, cooking_request, no_cutlery, payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'COD')");
        $stmt->bind_param("sssssssss", $name, $city, $address, $phone, $email, $price, $item, $cookingRequest, $noCutlery);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "Order placed successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    // Handle case when form is not submitted
    echo "Form submission error: Method not allowed.";
}
?>
</body>
</html>
