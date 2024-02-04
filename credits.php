<?php
    include ("connection.php");
    include("queries.php");
    include("alerts.php");

    //marking deliveries as paid or delivered
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];
    
        if ($status == 'Delivered' || $status == 'Paid and Delivered') {
            mark_paid($order_id);
        }
    
        refresh();
    }
    

// fetch credit records for displayed date
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
    $credit_records = get_unpaid_records($date);
} else {
    $date = date('Y-m-d');
    $credit_records = get_unpaid_records($date);
}

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
    <form id = "dateForm" method = "get" action = "credits.php">
        <label for = "date">Select Date: </label>
        <input type = "date" id = "date" name = "date">
        <input type = "submit" style = "display:none">
    </form>

    <!-- Display selected or default date -->
    <span><h3>Date: <?php echo $date;?></h3></span>

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
                if(mysqli_num_rows($credit_records) > 0) {
                    while($record = mysqli_fetch_assoc($credit_records)) {
            ?>

                        <tr>
                            <td><?php echo $record['block'];?></td>
                            <td><?php echo $record['lot'];?></td>
                            <td><?php echo $record['phase'];?></td>
                            <td><?php echo $record['product'];?></td>
                            <td><?php echo $record['quantity'];?></td>
                            <td><?php echo $record['price'];?></td>
                            <td><?php echo $record['deliverer'];?></td>
                            <td>
                                <!-- form to mark as paid or deliverd -->
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
            ?>
                <tr>
                    <td colspan="8">No credit records found</td>
                </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <!-- Call to script, triggers automatic form submission -->
    <script src="helper_functions.js"></script>
</body>
</html>
                      
