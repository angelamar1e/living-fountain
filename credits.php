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