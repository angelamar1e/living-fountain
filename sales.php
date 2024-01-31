<?php
    include("order-form.php");
    include('alerts.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="helper-functions.js"></script>
</head>
<body>
    <form id="dateForm" method="get" action="sales.php">
        <label for="date">Select Date:</label>
        <input type="date" id="date" name="date">
        <!-- Add a hidden submit button to trigger form submission -->
        <input type="submit">
    </form>

    <?php
        if(isset($_REQUEST['date'])){
            $date = $_REQUEST['date'];
            $all_records = all_orders($date);
            redirect();
        }
        else{
            $date = date("Y-m-d");
            $all_records = all_orders($date);
        }
    ?>

    <div id="table_container">
    <table id=all_records>
        <tr>
            <th>Block</th>
            <th>Lot</th>
            <th>Phase</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Deliverer</th>
            <th>Status</th>
        </tr>
        <?php
            if (mysqli_num_rows($all_records) > 0) {
                while($record = mysqli_fetch_assoc($all_records)) { ?>
                    <tr>
                        <td><?php echo $record['block']; ?> </td>
                        <td><?php echo $record['lot']; ?> </td>
                        <td><?php echo $record['phase']; ?> </td>
                        <td><?php echo $record['product']; ?> </td>
                        <td><?php echo $record['quantity']; ?> </td>
                        <td><?php echo $record['price']; ?> </td>
                        <td><?php echo $record['deliverer']; ?> </td>
                        <td><?php echo $record['status']; ?> </td>
                    <tr>
        <?php
                }
            }
            else { ?>
                <tr>
                    <td colspan="8">No records found</td>
                </tr>
            <?php 
            } ?>
    </table>
</body>
</html>