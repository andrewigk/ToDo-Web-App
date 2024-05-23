<?php
    // search bar cant be empty
    session_start();
    
    
    // Enable error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        returnToDashboard();
    }

    function returnToDashboard() {
        header("Location: dashboard.php");
    }

    function displaySearchResults() {
        $currentUserId = $_SESSION['user_id']; 
        require_once('../database/db_credentials.php');
        require_once('../database/database.php');
        $db = db_connect();

        
    
        if (isset($_GET['searchQuery'])) {
            $searchQuery = $_GET['searchQuery'];

            $_SESSION['last_search'] = $searchQuery;

        } else {
            $searchQuery = $_SESSION['last_search'];
        }
        $sql = "SELECT * FROM Tasks WHERE UserId = $currentUserId AND Tag LIKE '$searchQuery'";
    
        // Execute the query
        $result = mysqli_query($db, $sql);

        // Check if the query was successful
        if ($result) {
            
            echo "<table>";

            echo "<tr align='left'><th>Complete</th><th>Name</th><th>Tag</th></tr>";

            
            // Fetch the tasks from the result set. Function generates rows based on the query
            while ($task = mysqli_fetch_assoc($result)) {
                echo "<tr align='left'>";
                echo "<td>
                        <form class='searchCheckBoxContainer' method='POST' action='update_search_task.php'>
                            <input type='hidden' name='taskId' value='{$task['Id']}'>
                            <input type='checkbox' name='complete' value='1' " . ($task['Complete'] ? 'checked' : '') . " onchange='this.form.submit()'>
                        </form>
                    </td>";

                echo "<td class='taskCell'>" . $task['Name'] . "</td>";
                echo "<td class='tagCell'>" . ($task['Tag'] ?? 'N/A') . "</td>";
                echo "</tr>";

            }
            echo "</table>";
    }
        db_disconnect($db);
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">

    <title>Search Results</title>
</head>
<body>
    <h1  class="searchResultsHeader">Search Results</h1>
    <div class="searchResultsContainer">
        <?php echo displaySearchResults() ?>
    </div>
    <form method="post">
        <input type="hidden" name="returnToDashboard" value="1">
        <button type="submit">Back to Home</button>
    </form>
</body>
</html>