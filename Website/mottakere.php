
<?php
$mysqli = new mysqli("fdb12.awardspace.net", "username", "password", "database");

$results = $mysqli->query("SELECT * FROM SkamEpost");

if ($results->num_rows > 0) {
    // output data of each row
    while($row = $results->fetch_assoc()) {
        echo $row["Epost"] . ",";
    }
} else {
    echo "0 results";
}
$mysqli->close();

?>
