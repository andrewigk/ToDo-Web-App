<?php

session_start();
// This function creates rows in table format using the data queried from the current user.
function displayTasks() {
    $currentUserId = $_SESSION['user_id']; 

    require_once('../database/db_credentials.php');
    require_once('../database/database.php');
    $db = db_connect();

    // Query to select all tasks for the current user
    $sql = "SELECT * FROM Tasks WHERE UserId = $currentUserId";

    // Execute the query
    $result = mysqli_query($db, $sql);

    // Check if the query was successful
    if ($result) {
        
        echo "<table>";
    
        echo "<tr align='left'><th>Complete</th><th>Name</th><th>Tag (optional)</th><th>Details</th></tr>";
    
        
        // Fetch the tasks from the result set. Function generates rows based on the query
        while ($task = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>
        <form method='POST' action='update_task_status.php'>
            <input type='hidden' name='taskId' value='{$task['Id']}'>
            <input type='checkbox' name='complete' value='1' " . ($task['Complete'] ? 'checked' : '') . " onchange='this.form.submit()'>
        </form>
      </td>";

            echo "<td class='taskCell'>" . $task['Name'] . "</td>";
            echo "<td class='tagCell'>" . ($task['Tag'] ?? 'N/A') . "</td>";
            echo "<td class='detailCell'><button id='expandButton' class='detailButton' data-task-id='{$task['Id']}'>Expand</button></td>";
            echo "</tr>";

        }
        echo "</table>";
    } else {
        // Error handling: display an error message or redirect
        echo "Failed to retrieve tasks.";
    }

    // Close the database connection
    db_disconnect($db); 
} 
// This function performs a similar task as displayTasks, but simply gets the data about tasks and stores it in an associative array for future use.
function getTasks()
{
    //getting current user_id based on its session
    $currentUserId = $_SESSION['user_id'];

    // Our database connection code
    require_once ('../database/db_credentials.php');
    require_once ('../database/database.php');
    $db = db_connect();

    // Query to select the task with the specified ID for the current user
    $sql = "SELECT * FROM Tasks WHERE UserId = $currentUserId";

    // Execute the query
    $result = mysqli_query($db, $sql);

    // Check if the query was successful and if a task was found
    if ($result) {


        $tasks = []; // Initialize an empty array to store tasks

        while ($task = mysqli_fetch_assoc($result)){
            $taskId = $task['Id'];
            $tasks[$task['Id']] = $task; // Store task with ID as key


        }
    // Free the result set
    mysqli_free_result($result);

    // Close the database connection
    db_disconnect($db);

    return $tasks; // Return the associative array of tasks
    } else {
    // Query failed
    db_disconnect($db);
    return null;
    }
}

// Function displays the username of the current session user
function displayUsername(){
       // Check if session variable is set
    if (!isset($_SESSION['user_name'])) {
        echo "Session variable not set.";
        return;
    }
    $currentUserName = $_SESSION['user_name'];
    echo "<p class='welcomeMessage'>Welcome back, " . $currentUserName . "</p>";    // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Will Hergott, Andrew Kim, and Paulo Gomes">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="../js/dashboard.js" defer></script>
    <title>Dashboard</title>
</head>

<body>
    <?php
    include "header.php";
    displayUsername();
    include "search_bar.php";
    ?>

    <div class="taskcontainer">
        <h1>Dashboard</h1>
        <button class="addTask" onclick="openPopup()">Add New Task</button>
        <hr>
        <!-- Calling displayTasks() to generate table, then calling getTasks() to store the row data into associative array -->
        <?php displayTasks();
        $tasks = getTasks(); 
        ?>
        
        <!-- This is the form for adding a new task. It is hidden by default, then CSS properties changed to display when button is clicked. -->
        <form id="taskForm" action="create_task.php" method="POST" onsubmit="return validate();">
        <div id="newTask" class="newTask" onmousedown="startDrag(event)">
                <h2>Add A New Task</h2>
                <div class="textfield2">
                    <label for="taskName">Task Name</label><br>
                    <input type="text" name="taskName" id="taskName" size="30" class="taskfield"
                        placeholder="E.g. Book an appointment at 5PM for...">
                </div>
                <div class="textfield2">
                    <label for="tag">Tag</label><br>
                    <input type="text" name="tag" id="tag" size="30" class="taskfield"
                        placeholder="E.g School, Work...">
                </div>
                <div class="textfield2">
                    <label for="description">Description</label><br>
                    <textarea name="description" id="description" class="taskfield" cols="33" rows="8" class="taskfield"
                        maxlength="500" placeholder="Enter a description here... (Maximum 500 characters)"></textarea>
                </div>
                <button type="submit" name="submit">Add</button>
                <button onclick="closePopup()">Close</button>
        </div>
        </form>
    </div>
    <!-- This is the form for expanding details about a task. It is hidden by default, then CSS properties changed to display when button is clicked. -->
    <div class="taskcontainerExpand">
    <!-- This script stores the php associative array of tasks into a JS object, then calls the function that sends task ID to required HTML content -->
    <script> 
        var tasks = <?php echo json_encode($tasks); ?>;
        document.addEventListener('DOMContentLoaded', function() {
        sendTaskID(tasks);
        });
    </script>
    <form id="taskExpandForm" action="" method="POST" onmousedown="startDragExpand(event)">
        <div id="expandTask" class="expandTask">
            <h2>Task Details</h2>
            <div class="textfield2">
                <label for="taskName">Task Name</label><br>
                <input type="text" name="taskName2" id="expandName" size="30" class="taskfield">
            </div>
            <div class="textfield2">
                <label for="tag">Tag</label><br>
                <input type="text" name="tag2" id="expandTag"  size="30" maxlength="50" class="taskfield" placeholder="E.g School, Work...">
            </div>
            <div class="textfield2">
                    <label for="description">Description</label><br>
                    <textarea name="description2" id="expandDesc" class="taskfield" cols="33" rows="8" class="taskfield"
                        maxlength="500" placeholder="Enter a description here... (Maximum 500 characters)"></textarea>
            </div>  
            <input type="hidden" name="taskId" id="updateTaskId" value="">
            <button type="submit">Save Edits</button>
    </form>
    <form id="ExpandTaskDelete" action="" method="POST" onsubmit="">
            <input type="hidden" name="taskId" id="deleteTaskId" value="">
            <button type="submit">Delete</button>
    </form>
            <button onclick="closePopupExpand()">Close</button>
        </div> 
    </div>

    <?php include('footer.php') ?>

</body>

</html>