<!DOCTYPE html>
<html>
<head>
    <title>Update Command</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="menu">
		<button onclick="location.href='index.php'">Home</button>
		<button onclick="location.href='insert.php'">Add Command</button>
		<button onclick="location.href='update.php'">Update Command</button>
	</div>
    <div class="container">
        <h1>Update Command</h1>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search for command">
            <input type="submit" value="Search">
        </form>

        <?php
        include('db_connect.php');

        // Check if a search has been made
        if (isset($_GET['search'])) {
            $search = $_GET['search'];

            // Get the data from the database
            $query = "SELECT * FROM commands WHERE command = '$search'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                echo "<p class='error'>The entry was not found.</p>";
            } else {
                // Display the form with the data
                $row = mysqli_fetch_assoc($result);
                echo "<form method='POST' action=''>";
                echo "<label for='command'>Command:</label>";
                echo "<input type='text' name='command' value='" . $row['command'] . "' readonly>";
                echo "<label for='message'>Message:</label>";
                echo "<input type='text' name='message' value='" . $row['message'] . "'>";
                echo "<label for='userlevel'>User Level:</label>";
                echo "<input type='text' name='userlevel' value='" . getUserLevel($row['userlevel']) . "'>";
                echo "<input type='submit' value='Update'>";
                echo "</form>";

                // Initialize variables
                $command = '';
                $message = '';
                $userlevel = '';
                $success = '';

                // Check if the form has been submitted
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get the input values from the form
                    $command = $_POST['command'];
                    $message = $_POST['message'];
                    $userlevel = $_POST['userlevel'];

                    // Update the entry in the database
                    $query = "UPDATE commands SET message = '$message', userlevel = '$userlevel' WHERE command = '$command'";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $success = "Command '$command' has been updated!";
                    } else {
                        $success = "There was an error updating the command.";
                    }
                }

                echo "<p class='success'>" . $success . "</p>";
            }
        }

        // Function to convert user level number to text
        function getUserLevel($level) {
            switch ($level) {
                case 1:
                    return "Caster";
                case 2:
                    return "Mods";
                case 3:
                    return "VIPs";
                case 4:
                    return "Everyone";
                default:
                    return "Unknown";
            }
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>
