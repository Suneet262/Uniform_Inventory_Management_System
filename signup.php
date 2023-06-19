<?php
// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = '';

// Create database
$database = 'user_authentication_02';
$conn = mysqli_connect($hostname, $username, $password);
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully.";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}
mysqli_close($conn);

// Establish connection to the database
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
)";
if (mysqli_query($conn, $sql)) {
    echo "Table created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
mysqli_close($conn);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    
    // Validate the form data (you can add more validation if required)
    if (empty($name) || empty($email) || empty($password)) {
        $error = "Please fill in all the fields.";
    }else {
        // TODO: Perform signup and database operations
        
        // Assuming you have a database table named "users" with columns: id, name, email, password
        $conn = mysqli_connect('localhost', 'root', '','user_authentication_02');

        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        // Check if the user already exists
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            // User already exists, verify the details
            $row = mysqli_fetch_assoc($result);
            
            if ($row['name'] === $name && $row['password'] === $password) {
                // User verified, display message
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                echo "User Already Exists. Please proceed to login.";
                header("Location: login.html");
                exit();
            } else {
                // User exists, but details do not match
                $error = "User Already Exists with different details.";
            }
            
            // Redirect to login page
            echo "User Already Exists. Please proceed to login.";
            header("Location: login.html");
            exit();
        } else {
            // User does not exist, proceed with signup
            $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                // Signup successful
                // You can add further code or redirection if needed
                echo "Account successfully created";
                header("Location:home.php");
                
                mysqli_close($conn);
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
        
        // mysqli_close($conn);
    }
}

?>

<!-- Your signup HTML code here -->