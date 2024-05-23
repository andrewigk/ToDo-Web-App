<?php
require_once ('../database/db_credentials.php');
require_once ('../database/database.php');

$db = db_connect();

//check if the id is set in the URL
if (!isset ($_GET['id'])) {
    header("Location: dashboard.php"); //go to dashboard.php
    exit; //exit the script after going back to dashboard.php
}
$taskId = $_GET['id']; //getting Task ID from the URL (we get this from the expand button)

//check if delete request was posted/requested by the form.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql = "DELETE FROM tasks WHERE id ='$taskId'";
    $result = mysqli_query($db, $sql);

    header("Location: dashboard.php");

}
?>