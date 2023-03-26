<!DOCTYPE html>
<html>
<head>
	<title>Games Played - Update</title>
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
		<h2>Update Game in the Database:</h2>
		<?php
			// Connect to the database
			include('db_connect.php');
			
			// Check if the form has been submitted
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// Get the game id and new game name from the form
				$id = $_POST["id"];
				$game = $_POST["game"];
				
				// Prepare and execute the update statement
				$stmt = $conn->prepare("UPDATE games SET game=? WHERE id=?");
				$stmt->bind_param("si", $game, $id);
				$stmt->execute();
				
				// Check if the update was successful and display appropriate message
				if ($stmt->affected_rows > 0) {
					echo "Game updated successfully.";
				} else {
					echo "Error updating game: " . $stmt->error;
				}
				
				$stmt->close();
			} else {
				// If the form has not been submitted, display the form to select the game to update
				// Retrieve the list of games from the database
				$sql = "SELECT * FROM games ORDER BY game";
				$result = $conn->query($sql);
				
				// Display the form to select the game to update
				echo "<form method='POST' action=''>";
				echo "<label for='id'>Select game:</label>";
				echo "<select name='id'>";
				
				while ($row = mysqli_fetch_assoc($result)) {
					$id = $row['id'];
					$game = $row['game'];
					
					echo "<option value='$id'>$game</option>";
				}
				
				echo "</select>";
				echo "<br><br>";
				echo "<label for='game'>New game name:</label>";
				echo "<input type='text' name='game'>";
				echo "<br><br>";
				echo "<input type='submit' value='Update'>";
				echo "</form>";
			}
			
			$conn->close();
		?>
	</div>
</body>
</html>