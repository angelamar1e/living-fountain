<?php
 include('alert.php');
 include('connection.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="helper_functions.js"></script>
</head>
<body>
<table >
        <tr>
            <th>ID</th>
            <th>Block</th>
            <th>Lot</th>
            <th>Phase</th>
            <th>Date</th>
            
        </tr>
<?php
 global $conn;
 
 $query = "SELECT id,block, lot, phase, MAX(date) AS last_order
            FROM orders
            GROUP BY id,block, lot, phase
            ORDER BY last_order DESC;";

$all_records = $conn->query($query);

if ($all_records->num_rows > 0) {
    while ($record = $all_records->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $record['id']; ?></td>
        <td><?php echo $record['block']; ?></td>
        <td><?php echo $record['lot']; ?></td>
        <td><?php echo $record['phase']; ?></td>
        <td><?php echo $record['date']; ?></td>
        <td><?php echo $record['last_order']; ?></td>
    </tr>
<?php
    }
} else {
    echo '<tr><td colspan="6">No records found</td></tr>';
}

// Close the database connection
$conn->close();

?>

</table>
</body>
</html>


