<?php
session_start();
require_once('../database/db_credentials.php');
require_once('../database/database.php');
$db = db_connect();

// Check if server request is post and if submit button is clicked on Add Task form
if($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['submit']) ) {
    $user_id = $_SESSION['user_id'];
    var_dump($_SESSION['user_id']);
    $name = $_POST['taskName'];
    $tag = $_POST['tag'];   
    $description = $_POST['description'];
    $sql = "INSERT INTO Tasks (UserId, Name, Tag, Description, Complete) VALUES (?, ?, ?, ?, 0)";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $name, $tag, $description);
    mysqli_stmt_execute($stmt);
    // Check if the affected row from the insert is equal to 1, then redirect user accordingly
    if(mysqli_stmt_affected_rows($stmt) == 1) {
        // Task inserted successfully
        header("Location: dashboard.php");
    } else {
        // Error inserting task
        header("Location: dashboard.php");
        
    }

    // Close the prepared statement
mysqli_stmt_close($stmt);
}
// Will refresh the dashboard page whether a task is inserted or not, to hide the pop up window
else {
    header("Location: dashboard.php");
}

db_disconnect($db);