<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['complete'])) {
        $checked = 1;
    } else {
        // Checkbox not checked
        $checked = 0;
    }

    $taskId = $_POST['taskId']; // Set taskId to 0 if not set

    // echo "Checked?: $checked";

    require_once('../database/db_credentials.php');
    require_once('../database/database.php');
    $db = db_connect();

    $userId = $_SESSION['user_id'];
    // Update the task status in the database
    $sql = "UPDATE Tasks SET Complete = $checked WHERE Id = $taskId AND UserId = $userId";

    if (mysqli_query($db, $sql)) {
        // Task updated successfully
        header("Location: dashboard.php");
        //echo "SQL: $sql";
    } else {
        // Error updating task
        echo "Error updating task: " . mysqli_error($db);
    }

    db_disconnect($db);
} else {
    // Invalid request method or missing parameters
    http_response_code(400);
    echo "Bad request";
}
?>
