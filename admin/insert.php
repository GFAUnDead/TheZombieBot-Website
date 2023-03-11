<!DOCTYPE html>
<html>
<head>
    <title>Add Command</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="menu">
		<button onclick="location.href='index.php'">Home</button>
		<button onclick="location.href='insert.php'">Add Command</button>
		<button onclick="location.href='update.php'">Update Command</button>
	</div>
    <div class="container">
        <h1>Add Command</h1>
        <form method="POST" action="">
            <label for="command">Command:</label>
            <input type="text" name="command" placeholder="Enter command">
            <label for="message">Message:</label>
            <input type="text" name="message" placeholder="Enter message">
            <label for="userlevel">User Level:</label>
            <select name="userlevel">
                <option value="1">Caster</option>
                <option value="2">Mods</option>
                <option value="3">VIPs</option>
                <option value="4">Everyone</option>
            </select>
            <input type="submit" value="Add">
        </form>

        <?php
        include('db_connect.php');

        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the input values from the form
            $command = $_POST['command'];
            $message = $_POST['message'];
            $userlevel = $_POST['userlevel'];

            // Insert the entry into the database
            $query = "INSERT INTO commands (command, message, userlevel) VALUES ('$command', '$message', '$userlevel')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<p class='success'>Command '$command' has been added!</p>";
            } else {
                echo "<p class='error'>There was an error adding the command.</p>";
            }
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
