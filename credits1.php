<?php
include("connection.php");
include("queries.php");

// Marking delivered or paid and delivered
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    if ($status == 'Paid and Delivered') {
        pd_Del($order_id);
    } elseif ($status == 'Delivered') {
        del($order_id);
    }

    refresh();
}

// Fetch credit records for delivered but unpaid based on the displayed date
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
} else {
    $date = date('Y-m-d');
}

// Get delivered but unpaid records for the selected or default date
$unpaid_records = get_unpaid_records($date);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credits</title>
    <script src="helper_functions.js"></script>
</head>
<body>

    <!-- Form to filter credit records by date -->
    <form id="dateForm" method="get" action="credits1.php">
        <label for="date">Select Date: </label>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        <input type="submit" style="display:none">
    </form>

    <!-- Display selected or default date -->
    <span><h3>Date: <?php echo $date; ?></h3></span>

    <div id="table_container">
        <table id="credit_records">
            <tr>
                <th>Block</th>
                <th>Lot</th>
                <th>Phase</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Deliverer</th>
                <th>Action</th>
            </tr>
            <?php
            if (is_object($unpaid_records)) {
                if (mysqli_num_rows($unpaid_records) > 0) {
                    // Records found
                    while ($record = mysqli_fetch_assoc($delivered_unpaid_records)) {
                        ?>
                        <tr>
                            <td><?php echo $record['block']; ?></td>
                            <td><?php echo $record['lot']; ?></td>
                            <td><?php echo $record['phase']; ?></td>
                            <td><?php echo $record['product_code']; ?></td>
                            <td><?php echo $record['quantity']; ?></td>
                            <td><?php echo $record['price']; ?></td>
                            <td><?php echo $record['deliverer_id']; ?></td>
                            <td>
                                <!-- Form to mark as delivered or paid and delivered -->
                                <form method="post" action="credits.php">
                                    <input type="text" value="<?php echo $record['id']; ?>" name="order_id" style="display:none">
                                    <!-- Dropdown for status -->
                                    <select name="status">
                                        <option value="Delivered">Delivered</option>
                                        <option value="Paid and Delivered">Paid and Delivered</option>
                                    </select>
                                    <button type="submit" name="update_status">Update Status</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // No records found
                    echo "<tr><td colspan='8'>No credit records found</td></tr>";
                }
            } else {
                // $delivered_unpaid_records is not a valid mysqli_result object
                echo "Error: Query did not return a valid result set.";
            }
            ?>
        </table>
    </div>
    <!-- Call to script, triggers automatic form submission -->
    <script src="helper_functions.js"></script>
</body>
</html>
