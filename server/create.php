<?php

session_start(); // Start the session

// Getting access to the database
require_once('../database/db_credentials.php');
require_once('../database/database.php');
$db = db_connect();

// Handle form values sent by new.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $uName = $_POST['login'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];

    $sql = "INSERT INTO Users (Name, Email, Password) VALUES ('$uName','$email','$pass')";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    confirm_result_set($result); // Check database query

    // Check if the query was successful
    if ($result) {
        // Registration successful, grab the ID and Name of the user
        $userID = mysqli_insert_id($db); // Get the ID of the last inserted row
        $userName = $uName; // Get the Name of the user

        // Set session variables
        $_SESSION['user_id'] = $userID;
        $_SESSION['user_name'] = $userName;

        // Redirect to the dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        // Error handling: display an error message or redirect to the registration page with an error parameter
        header("Location: register.php?error=registration_failed");
        exit;
    }
} else {
    header("Location: register.php");
}

db_disconnect($db);
?>