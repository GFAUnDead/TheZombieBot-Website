<!DOCTYPE html>
<html>
<head>
	<title>Games Played - Insert</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" href="../../images/logo.png" type="image/png" />
</head>
<body>
	<header>
		<div class="header-title">
			<h1>Games Played</h1>
		</div>
		<div class="menu">
			<button onclick="location.href='index.php'">Home</button>
			<button onclick="location.href='insert.php'">Add Game</button>
			<button onclick="location.href='update.php'">Update Game</button>
		</div>
	</header>

    <div class="container">
		<h2>Add a Game to the Database:</h2>
		<form method="post" action="">
			<label for="game">Game Name:</label>
			<input type="text" id="game" name="game" required>
			<input type="submit" value="Add Game">
		</form>

		<?php
			// Connect to the database
			include('db_connect.php');

			// Check if the form has been submitted
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$game = $_POST["game"];
				
				// Insert the game name into the table
				$sql = "INSERT INTO games (game) VALUES ('$game')";
				
				if ($conn->query($sql) === TRUE) {
					echo "<p>The game '$game' has been added to the database.</p>";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				// Close the database connection
				$conn->close();
			}
		?>
	</div>
</body>
</html>