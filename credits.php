<?php
    include ("connection.php");
    include("queries.php");
    include("alerts");

    //marking deliveries as paid or delivered
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['mark_paid'])) {
            $order_id = $POST['order_id'];
            mark_paid($order_id);
            refresh();
    } else if (isset($_POST['mark_delivered'])) {
        $order_id = $POST['order_id'];
        mark_paid($order_id);
        refresh();
    }
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
<<<<<<< HEAD

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
                                <form method = "post" action = "">
                                    <input type = "text" value = "<?php echo $record['id'];?>" name = "order_id" style = "display:none">
                                    <button type="submit" name = "mark_delivered"> Mark as Delivered</button>
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
                      
=======
>>>>>>> parent of 47aeab1 (HTML Form to filter records by date)
