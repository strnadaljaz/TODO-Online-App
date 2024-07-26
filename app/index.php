<?php
session_start();
include_once("../login_register/connection.php");

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login_register/login.php");
    exit();
}

$username = $_SESSION['username'] ?? null;
$error = '';
$tasks = [];

// Handle logout
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../login_register/login.php"); // Redirect to the login page after logout
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["operation"])) {
        $operation = $_POST["operation"];
        $task = $_POST["task"] ?? '';

        // Get the user id
        $stmt = $con->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        if ($operation == "add" && !empty($task)) {
            $stmt = $con->prepare("INSERT INTO tasks (task, user_id) VALUES (?, ?)");
            $stmt->bind_param("si", $task, $user_id);
            $stmt->execute();
        } elseif ($operation == "del" && !empty($task)) {
            $stmt = $con->prepare("DELETE FROM tasks WHERE task = ? AND user_id = ?");
            $stmt->bind_param("si", $task, $user_id);
            $stmt->execute();
        } else {
            $error = "Invalid request!";
        }
    }
}

// Fetch tasks at start
if ($username) {
    $stmt = $con->prepare("SELECT task FROM tasks WHERE user_id = (SELECT user_id FROM users WHERE username = ?)");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row['task'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-container">
        <header class="navbar">
            <div class="navbar-content">
                <h1 class="navbar-brand">Task Manager</h1>
                <form action="" method="POST" id="logout-form" class="logout-form">
                    <button type="submit" name="logout" class="logout-button">Logout</button>
                </form>
            </div>
        </header>

        <main class="content-container">
            <section class="main-content">
                <?php if ($error): ?>
                    <div class="error-message" role="alert"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="" method="POST" class="task-form">
                    <input type="text" name="task" required placeholder="Enter a new task" aria-label="New Task" class="task-input">
                    <button type="submit" name="operation" value="add" class="add-button">Add Task</button>
                </form>

                <ul class="task-list" id="task_list" aria-label="Task List">
                    <?php foreach ($tasks as $task): ?>
                        <li class="task-item">
                            <span><?php echo htmlspecialchars($task); ?></span>
                            <form action="" method="POST" class="delete-form">
                                <input type="hidden" name="task" value="<?php echo htmlspecialchars($task); ?>">
                                <button type="submit" name="operation" value="del" class="delete-button">Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </main>
    </div>
</body>
</html>
