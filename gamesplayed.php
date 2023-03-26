<!DOCTYPE HTML>
<html>
	<head>
		<title>TheZombiesBot</title>
		<meta charset="utf-8" />
		<link rel="icon" href="./images/logo.png" type="image/png" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="./assets/css/main.css" />
	</head>
	<body class="is-preload">

			<section id="header">
				<header>
					<span class="image avatar"><a href="https://thezombiebot.xyz/"><img src="./images/logo.png" alt="GFAUnDead Logo" /></a></span>
					<h1 id="logo">TheZombiesBot</h1>
					<h5>The one stop bot for gfaUnDead</h5>
				</header>
				<nav id="nav">
					<ul>
						<li><a href="./index.php" target="_self">Commands</a></li>
						<li><a href="./mods.php" target="_self">Mod Commands</a></li>
						<li><a href="./werewolf.php" target="_self">WereWolf Commands</a></li>
						<li><a href="#games" target="_self">Games Played</a></li>
						<li><a href="https://gfaundead.stream" target="_blank">Main Website</a></li>
					</ul>
				</nav>
				<footer>
					<ul class="icons">
						<li><a href="https://www.facebook.com/GFAUnDead/" target="_blank" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
						<li><a href="https://twitter.com/GFAUnDead" target="_blank" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="https://www.instagram.com/GFAUnDead/" target="_blank" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="https://github.com/GFAUnDead" target="_blank" class="icon brands fa-github"><span class="label">Github</span></a></li>
						<li><a href="mailto:contact@gfaundead.stream" target="_blank" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
					</ul>
				</footer>
			</section>

			<div id="wrapper">
					<div id="main">
							<section id="about">
								<div class="container">
									<header class="major">
										<h2>TheZombiesBot</h2>
										<p>What is TheZombiesBot?<br>
											It is the Twitch Chat Bot built by gfaUnDead.<br>
											This bot helps with moderation and chat interactions!</p>
									</header>
									<p></p>
								</div>
							</section>

							<section id="games">
								<div class="container">
									<h3>GAMES PLAYED ON STREAM</h3>
																		<?php
									    // Connect to the database
									    $servername = "(REDACTED)";
									    $username = "(REDACTED)";
									    $password = "(REDACTED)";
									    $dbname = "(REDACTED)";
									
									    $conn = new mysqli($servername, $username, $password, $dbname);
									    if ($conn->connect_error) {
									        die("Connection failed: " . $conn->connect_error);
									    }
									
									    // Retrieve the data from the table
									    $search = isset($_GET['search']) ? $_GET['search'] : '';
									    $sql = "SELECT * FROM games WHERE game LIKE '%" . $search . "%' ORDER BY game ASC";
									    $result = $conn->query($sql);
									
									    // Determine how many entries to display per page
									    $entries_per_page = 15;
									    $page = isset($_GET['page']) ? $_GET['page'] : 1;
									    $start = ($page - 1) * $entries_per_page;
									
									    // Count the total number of entries
									    $count_sql = "SELECT COUNT(*) FROM games WHERE id LIKE '%" . $search . "%'";
									    $count_result = $conn->query($count_sql);
									    $total_entries = $count_result->fetch_row()[0];
									
									    $total_pages = ceil($total_entries / $entries_per_page);
									
									    // Display the search bar and the table of entries
									    echo "<form method='GET' action=''>";
									    echo "<input type='text' name='search' placeholder='Search for game'>";
									    echo "</form>";
									    echo "<table>";
									    echo "<tr><td colspan='2'>Total games played on stream: $total_entries</td></tr>";
									    echo "<tr><th>Game</th></tr>";
									
									    // Fetch and display the entries for the current page
									    $sql .= " LIMIT $start, $entries_per_page";
									    $result = $conn->query($sql);
									    while ($row = mysqli_fetch_assoc($result)) {
									        $id = $row['id'];
									        $game = $row['game'];
									
									        // Display the table row with the data
									        echo "<tr><td>$game</td></tr>";
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
							</section>

					<section id="footer">
						<div class="container">
							<ul class="copyright">
								<strong>Copyright &copy; 2023. All rights reserved gfaUnDead</strong>
							</ul>
						</div>
					</section>
			    </div>
			</div>
		<!-- Scripts -->
			<script src="./assets/js/jquery.min.js"></script>
			<script src="./assets/js/jquery.scrollex.min.js"></script>
			<script src="./assets/js/jquery.scrolly.min.js"></script>
			<script src="./assets/js/browser.min.js"></script>
			<script src="./assets/js/breakpoints.min.js"></script>
			<script src="./assets/js/util.js"></script>
			<script src="./assets/js/main.js"></script>
	</body>
</html>