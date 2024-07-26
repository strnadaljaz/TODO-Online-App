<?php
session_start();
include_once("connection.php");
include_once("functions.php");

// Handle form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $_SESSION['username'] = $username;

    // Prepare statement to check if the username exists
    $stmt = $con->prepare("SELECT user_password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Use plain username here
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        // Get the stored hashed password
        $password_hashed = $row['user_password'];
        if (password_verify($password, $password_hashed)) {
            header("Location: ../app/index.php");
            exit;
        } else {
            $error = "Wrong password!";
        }
    } else {
        $error = "Username doesn't exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Login</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div id="container">
        <div id="login_div">
            <h1>LOGIN</h1>
            <?php
            if ($error) {
                echo "<p style='color: red;'>$error</p>";
            }
            ?>
            <form action="" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                
                <button id="login_submit" type="submit">Submit</button>
                <label for="sign_up_link">Don't have an account?</label>
                <a href="sign_up.php">Click here to sign up</a>
            </form>
        </div>
    </div>
</body>
</html>
