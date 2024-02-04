<?php
 include('alerts.php');
 include('connection.php');
 include('queries.php');

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
            
            <th>Block</th>
            <th>Lot</th>
            <th>Phase</th>
            <th>Date</th>
            <th>product</th>
            <th>quantity</th>
            <th>price</th>
            <th>deliverer</th>
            
        </tr>

<?php
 global $conn;
 
 //query to display recent orders of unique customers descending 
 $query = "WITH ranked_orders AS (
    SELECT
        o.id,
        o.block,
        o.lot,
        o.phase,
        o.date,
        o.product_code,
        o.quantity,
        o.price,
        o.deliverer_id,
        p.product_desc,
        e.employee_name,
        ROW_NUMBER() OVER (PARTITION BY o.block, o.lot, o.phase ORDER BY o.date DESC) AS rn
    FROM
        orders o
    JOIN
        products p ON o.product_code = p.code
    LEFT JOIN
        employees e ON o.deliverer_id = e.id
)
SELECT
    block,
    lot,
    phase,
    MAX(date) AS last_order,
    product_desc AS product,
    quantity,
    price,
    employee_name AS deliverer
FROM
    ranked_orders
WHERE
    rn = 1
GROUP BY
    block, lot, phase;
";

$all_records = $conn->query($query);

if ($all_records->num_rows > 0) {
    while ($record = $all_records->fetch_assoc()) {
?>
<!-- dispaly the query -->
    <tr>
        <td><?php echo $record['block']; ?></td>
        <td><?php echo $record['lot']; ?></td>
        <td><?php echo $record['phase']; ?></td>
        <td><?php echo $record['last_order']; ?></td>
        <td><?php echo $record['product']; ?></td>
        <td><?php echo $record['quantity']; ?></td>
        <td><?php echo $record['price']; ?></td>
        <td><?php echo $record['deliverer']; ?></td>
        
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


