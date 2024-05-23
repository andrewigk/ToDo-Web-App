<?php
require_once('../database/db_credentials.php');
require_once('../database/database.php');

$db = db_connect();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//check if the id is set in the URL
if (!isset ($_GET['id'])) {
    header("Location: dashboard.php"); //go to dashboard.php
    exit; //exit the script after going back to dashboard.php
}
$taskId = $_GET['id']; //getting Task ID from the URL (we get this from the expand button)

if($_SERVER['REQUEST_METHOD'] == 'POST'   ) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['taskName2'];
    $tag = $_POST['tag2'];
    $description = $_POST['description2'];
    
    // SQL query to update the task
    $sql = "UPDATE tasks SET Name = ?, Tag = ?, Description = ? WHERE id = ? AND userid = ?";
    
    // Prepare the SQL statement
    $stmt = mysqli_prepare($db, $sql);
    
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sssii", $name, $tag, $description, $taskId, $user_id);
    
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    
    // Check if the affected row from the update is equal to 1, then redirect user accordingly
    if (mysqli_stmt_affected_rows($stmt) == 1) {
        // Task updated successfully
        echo "Success";
        header("Location: dashboard.php");
    } else {
        // Error updating task or task not found
        echo "Fail";
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
?>