<?php
$servername = "the-artist-harbour.cl64o2auodev.eu-north-1.rds.amazonaws.com";
$username = "admin";
$password = "password2025";
$dbname = "artist_harbour_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["first_name"] . "</td></tr>";
    }

    echo "</table>";
} else {
    echo "No records found!";
}

$conn->close();
?>