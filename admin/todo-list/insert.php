<!DOCTYPE html>
<html>
<head>
	<title>To Do List - Insert</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" href="../../images/logo.png" type="image/png" />
</head>
<body>
	<header>
		<div class="header-title">
			<h1>To Do List</h1>
		</div>
		<div class="menu">
			<button onclick="location.href='../index.php'">BACK</button>
			<button onclick="location.href='index.php'">Home</button>
			<button onclick="location.href='insert.php'">New</button>
            <button onclick="location.href='update.php'">Update</button>
            <button onclick="location.href='completed.php'">Done</button>
			<button onclick="location.href='remove.php'">Delete</button>
		</div>
	</header>

    <div class="container">
        <br>
            <?php
                // Check if the API key was submitted via a form
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Retrieve the API key from the form data
                $api_key = $_POST['api_key'];

                // Connect to the database
                $servername = "(REDACTED)";
                $username = "(REDACTED)";
                $password = "(REDACTED)";
                $dbname = "(REDACTED)";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check if the connection is successful
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare the SQL statement to retrieve the channel name and username for the given API key
                $stmt = $conn->prepare("SELECT channelname FROM allowed_users WHERE api_key = ?");
                $stmt->bind_param("s", $api_key);

                // Execute the SQL statement
                $stmt->execute();

                // Bind the result to variables
                $stmt->bind_result($channelname);

                // Fetch the result
                $stmt->fetch();

                // Close the statement
                $stmt->close();

                // Close the database connection
                $conn->close();

                // Check if the provided API key is valid and retrieve the channel name from the database
                if (empty($channelname)) {
                    // Return an error message if the API key is not valid
                    echo "Invalid API key.";
                    exit();
                }
                } else {
                    // Display the form to get the API key from the user
                    echo '<form method="post">';
                    echo '<label for="api_key">API Key:</label>';
                    echo '<input type="text" id="api_key" name="api_key">';
                    echo '<input type="submit" value="Submit">';
                    echo '</form>';
                    exit();
                }
            
                // Check if the form to add a task was submitted
                if (isset($_POST['todo_text'])) {
                    // Connect to the database
                    $servername = "(REDACTED)";
                    $username = "(REDACTED)";
                    $password = "(REDACTED)";
                    $dbname = "(REDACTED)";
    
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check if the connection is successful
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
    
                    // Prepare the SQL statement to insert the task into the database
                    $stmt = $conn->prepare("INSERT INTO todos (user_id, todo_text, completed) VALUES ((SELECT id FROM users WHERE name=?), ?, false)");
                    $stmt->bind_param("ss", $channelname, $_POST['todo_text']);
    
                    // Execute the SQL statement
                    if ($stmt->execute()) {
                        // Display a success message to the user
                        echo "Task added successfully!";
                    } else {
                        // If the SQL statement fails, display an error message to the user
                        echo "An error occurred while adding the task. Please try again later.";
                    }
    
                    // Close the statement
                    $stmt->close();
            
                    // Close the database connection
                    $conn->close();
                }
                // Check if the user has submitted the form to add a new task
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Retrieve the task text from the form data
                    $task_text = $_POST['task_text'];
    
                // Connect to the database
                include('db_connect.php');
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
    
                // Prepare the SQL statement to insert the task into the database
                $sql = "INSERT INTO todos (user_id, todo_text, completed) VALUES ((SELECT id FROM users WHERE name='$channelname'), ?, false)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $task_text);
    
                // Execute the SQL statement
                if ($stmt->execute()) {
                        echo "Task added successfully.";
                } else {
                    echo "An error occurred while adding the task.";
                }
    
                // Close the statement and the database connection
                $stmt->close();
                $conn->close();
            }
            ?>
	</div>
</body>
</html>