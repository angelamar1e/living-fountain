<?php
 
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
 
 //query to display recent orders descending 
 $query = "SELECT id,block, lot, phase, MAX(date) AS last_order
            FROM orders
            GROUP BY id,block, lot, phase
            ORDER BY last_order DESC;";

$all_records = $conn->query($query);

if ($all_records->num_rows > 0) {
    while ($record = $all_records->fetch_assoc()) {
?>
<!-- dispaly the query -->
    <tr>
        <td><?php echo $record['id']; ?></td>
        <td><?php echo $record['block']; ?></td>
        <td><?php echo $record['lot']; ?></td>
        <td><?php echo $record['phase']; ?></td>
        <td><?php echo $record['last_order']; ?></td>
    </tr>
<?php
    }
} else {
    echo '<tr><td colspan="6">No records found</td></tr>';
}

// display the total amount of order of specific customers from the search bar
if (isset($_POST['block']) and isset($_POST['lot']) and isset($_POST['phase'])) {
    $block = $_POST['block'];
    $lot = $_POST['lot'];
    $phase = $_POST['phase'];

}

$amount = select_where(array("SUM(price) as total_amount"), "orders", 
"block = '$block' AND lot = '$lot' AND phase = '$phase'");

if(mysqli_num_rows($amount) > 0){
    while($records = mysqli_fetch_assoc($amount)){
        $total_amount = $records['total_amount'];
    }
}

// Close the database connection
$conn->close();

?>

</table>

<!-- display total amount of orders of specific customer -->
<div class="total_amount_section" id="total_amount_section">
    <h3 class="total_label" id="total_label">Total Amount of Orders</h3>
    <h3 class="total_amount" id="total_amount"><?php echo $total_amount ?></h3>


</div>
</body>
</html>


