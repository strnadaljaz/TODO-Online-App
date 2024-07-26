<?php
session_start();
include_once("connection.php");
include_once("functions.php"); // Include the functions.php file

// Handle form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if username exists
    $stmt = $con->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Use plain username here
    $stmt->execute();
    $result = $stmt->get_result();
    $usernameExists = $result->num_rows > 0;

    $check_username = checkUsername($username);

    if (!$usernameExists && $password == $confirm_password && $check_username == "") {
        // Hash the password for security
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare and execute the query to insert the plain username and hashed password
        $query = $con->prepare("INSERT INTO users (username, user_password) VALUES (?, ?)");
        $query->bind_param("ss", $username, $password_hashed);
        $query->execute();

        header("Location: login.php");
        exit;
    } else {
        if ($usernameExists) {
            $error = "Username is taken!";
        } elseif ($password != $confirm_password) {
            $error = "Passwords do not match.";
        } elseif ($check_username != "") {
            $error = $check_username;
        } else {
            $error = "Please enter some valid information.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do Sign Up</title>
    <link rel="stylesheet" href="sign_up_style.css">
</head>
<body>
    <div id="container">
        <div id="sign_up_div">
            <h1>SIGN UP</h1>
            <?php
            if ($error) {
                echo "<p style='color: red;'>$error</p>";
            }
            ?>
            <form action="" method="POST">
                <label>Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>

                <label>Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>

                <label>Confirm password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

                <button id="sign_up_submit" type="submit">Submit</button>
                <label for="login_link">Already have an account?</label>
                <a href="login.php">Click here to login</a>
            </form>
        </div>
    </div>
</body>
</html>
