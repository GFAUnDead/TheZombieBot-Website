<!DOCTYPE html>
<html>
<head>
	<title>Command Database</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" href="../images/logo.png" type="image/png" />
</head>
<body>
	<header>
		<div class="header-title">
			<h1>Command Database</h1>
		</div>
		<div class="menu">
			<button onclick="location.href='index.php'">Home</button>
			<button onclick="location.href='insert.php'">Add Command</button>
			<button onclick="location.href='update.php'">Update Command</button>
		</div>
	</header>

	<div class="container">
	    <h2>Viewing all available commands on this page:</h2>
	        <?php
				// Connect to the database
				include('db_connect.php');
				
				$conn = new mysqli($servername, $username, $password, $dbname);
				if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
				}
				
				// Retrieve the data from the table
				$sql = "SELECT * FROM commands WHERE command LIKE '%" . $_GET['search'] . "%' ORDER BY userlevel DESC";
				$result = $conn->query($sql);
				
				// Determine how many entries to display per page
				$entries_per_page = 10;
				$page = isset($_GET['page']) ? $_GET['page'] : 1;
				$start = ($page - 1) * $entries_per_page;
				$total_entries = $result->num_rows;
				$total_pages = ceil($total_entries / $entries_per_page);
				
				// Display the search bar and the table of entries
				echo "<form method='GET' action=''>";
				echo "<input type='text' name='search' placeholder='Search for command'>";
				echo "<input type='submit' value='Search'>";
				echo "</form>";
				
				echo "<table>";
				echo "<tr><th>Command</th><th>Message</th><th>User Level</th></tr>";
				
				while ($row = mysqli_fetch_assoc($result)) {
    			$command = $row['command'];
    			$message = $row['message'];
    			$userlevel = $row['userlevel'];
				
    			// Convert the userlevel value to its corresponding text value
    			switch ($userlevel) {
        		case 1:
            	$userlevel_text = 'Caster';
            	break;
        		case 2:
            	$userlevel_text = 'Mods';
            	break;
        		case 3:
            	$userlevel_text = 'VIPs';
            	break;
        		case 4:
            	$userlevel_text = 'Everyone';
            	break;
        		default:
            	$userlevel_text = 'Unknown';
            	break;
    			}
				
    			// Display the table row with the data
    			echo "<tr><td>$command</td><td>$message</td><td>$userlevel_text</td></tr>";
				}
				
				echo "</table>";
				
				// Display the pagination links
				echo "<div>";
				echo "Page " . $page . " of " . $total_pages . ": ";
				for ($i = 1; $i <= $total_pages; $i++) {
				if ($i == $page) {
				echo $i . " ";
				} else {
				echo "<a href='?page=" . $i . "&search=" . $_GET['search'] . "'>" . $i . "</a> ";
				}
				}
				echo "</div>";
								
				$conn->close();										
				?>
		
	</div>
</body>
</html>
