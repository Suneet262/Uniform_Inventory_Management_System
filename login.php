<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Validate the form data (you can add more validation if required)
    if (empty($email) || empty($password)) {
        $error = "Please fill in all the fields.";
    } else {
        // TODO: Perform login and database operations
        
        // Assuming you have a database table named "users" with columns: id, name, email, password
        $conn = mysqli_connect('localhost', 'root', '','user_authentication_02');
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        // Check if the user exists and the entered details are correct
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) {
            // User exists and details are correct, login successful
            // You can add further code or redirection if needed
            
            mysqli_close($conn);
            
            // echo "Login Successful";
            $success = "Login successful!";
            header("Location: home.html");
            exit();
        } else {
            // Invalid login credentials
            header("Location: login.html");
            // echo "Invalid Login Credentials.";
            $error = "Invalid Login Credentials.";
        }
        
        mysqli_close($conn);
    }
}
?>

<!-- Your login HTML code here -->
