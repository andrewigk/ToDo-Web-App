<?php
session_start();

require_once ('../database/db_credentials.php');
require_once ('../database/database.php');
$db = db_connect();

if($_SERVER['REQUEST_METHOD'] == 'POST') {      
    $username = $_POST['login'];
    $password = $_POST['pass'];
    $sql = "SELECT * FROM Users WHERE Name=? AND Password=?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) == 1) {
        // Login successful
        // Setting session variable to store the currently logged in user's id 
        $row = mysqli_fetch_assoc($result);
        // Session variable user_id can now be referenced until session destroyed to access current user's ID 
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['user_name'] = $row['Name'];
        header("Location: dashboard.php");
        db_disconnect($db);
        exit;
    } else {
        // Login failed
        header("Location: ../server/login.php?error=login_failed");
        db_disconnect($db);
        exit;
    }
} else {
    header("Location: login.php");
    db_disconnect($db);
    exit;
}
?>
