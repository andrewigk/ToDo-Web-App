<?php

require_once('db_credentials.php'); //getting credentials from file db_credentials.php

function db_connect() { //function to connect your form to your database
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME); //connecting to the database using variables from db_credentials.php
    confirm_db_connect(); //if connection fail, it will show a message
    return $connection;
}

function db_disconnect($connection) { //function to disconnect the form from the database
    if(isset($connection)) { //check if the form/ page is connected
        mysqli_close($connection);
    }
}

function confirm_db_connect() { //function to show database connection failed in case conection fail.
    if(mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}

function confirm_result_set($result_set) {  //check query
    if (!$result_set) {
    	exit("Database query failed.");
    }
}

?>