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
                if ($_SERVER['REQUEST_METHOD'] == 'POST');
                // Retrieve the API key from the form data
                $api_key = $_POST['api_key'];

                // Connect to the database that stores the API keys
                $api_servername = "(REDACTED)";
                $api_username = "(REDACTED)";
                $api_password = "(REDACTED)";
                $api_dbname = "(REDACTED)";
                $api_conn = new mysqli($api_servername, $api_username, $api_password, $api_dbname);

                // Check if the connection is successful
                if ($api_conn->connect_error) {
                    die("API Connection failed: " . $api_conn->connect_error);
                }

                // Prepare the SQL statement to retrieve the channel name and username for the given API key
                $stmt = $api_conn->prepare("SELECT channelname FROM allowed_users WHERE api_key = ?");
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
                $api_conn->close();

                // Check if the provided API key is valid and retrieve the channel name from the database
                if (empty($channelname)) {
                    // Return an error message if the API key is not valid
                    echo "Invalid API key.";
                exit();
                } else {
                // Display the form to get the API key from the user
                if ($_SERVER['REQUEST_METHOD'] == 'GET' || (isset($_POST['api_key']) && !$api_key_valid));
                echo '<form method="post">';
                echo '<label for="api_key">API Key:</label>';
                echo '<input type="text" id="api_key" name="api_key">';
                echo '<input type="submit" value="Submit">';
                echo '</form>';
                exit();
                }
        ?>
	</div>
</body>
</html>