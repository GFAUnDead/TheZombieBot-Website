<!DOCTYPE html>
<html>
<head>
	<title>To Do List Database</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" href="../../images/logo.png" type="image/png" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<header>
		<div class="header-title">
			<h1>To Do List Database</h1>
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
				// Check if the API key is specified in the URL
                if (isset($_GET['api'])) {
                    // Retrieve the API key from the URL
                    $api_key = $_GET['api'];
                } else {
                    // Return an error message if the API key is not specified in the URL
                    echo "API key is required.";
                    exit();
                }

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

                // Connect to the database
                include('db_connect.php');
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve the data from the table for the specified channel name and channel owner
                $sql = "SELECT todo_text FROM todos WHERE channel_id IN (SELECT id FROM channels WHERE name='". $_GET[channel] ."')";
                $result = $conn->query($sql);
				
                // Display text for user
                echo "<h2>Viewing all available tasks on this page for $_GET[channel]:</h2>\r\n";
                // Display the search bar and the table of entries
                echo "<form method='GET' action=''>\r\n";
                echo "<input type='text' name='search' id='search' placeholder='Search for your tasks'>\r\n";
                echo "</form>\r\n";

                echo "<table>\r\n";
                echo "<tr><th>To Do List</th></tr>\r\n";

                while ($row = mysqli_fetch_assoc($result)) {
                    $todo_text = $row['todo_text'];
                
                    // Display the table row with the data
                    echo "<tr><td>$todo_text</td></tr>\r\n";
                }

                echo "</table>";

                $conn->close();									
				?>
	</div>
</body>
</html>
