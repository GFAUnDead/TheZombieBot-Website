<!DOCTYPE html>
<html>
<head>
    <title>Games Played Database</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="../../images/logo.png" type="image/png" />
</head>
<body>
    <header>
        <div class="header-title">
            <h1>Games Played Database</h1>
        </div>
        <div class="menu">
            <button onclick="location.href='../index.php'">BACK</button>
            <button onclick="location.href='index.php'">Home</button>
            <button onclick="location.href='insert.php'">Add Game</button>
            <button onclick="location.href='update.php'">Update Game</button>
        </div>
    </header>

    <div class="container">
        <h2>Viewing all available games on this page:</h2>
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
            $entries_per_page = 30;
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
</body>
</html>
