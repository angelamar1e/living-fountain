<?php
 include('alerts.php');
 include('connection.php');
 include('queries.php');

 $all_customers = select(array("*"),"customers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Activity</title>
    <script src="helper_functions.js"></script>
</head>
<body>
    <h1 id="label_customer_page">Customer Activity</h1>
    <table>
        <tr>
            <th>Block</th>
            <th>Lot</th>
            <th>Phase</th>
            <th>Last Ordered Date</th>
        </tr>
    <?php
        if ($all_customers->num_rows > 0) {
            while ($record = $all_customers->fetch_assoc()) { 
                $block = $record['block'];
                $lot = $record['lot'];
                $phase = $record['phase']?>
            <tr>
                <td><?php echo $block; ?></td>
                <td><?php echo $lot; ?></td>
                <td><?php echo $phase; ?></td>
            <?php
                $last_ordered_dates = select_where(array("MAX(date) as 'last_order'"),"orders","block = $block and lot = $lot and phase = $phase");
                if ($last_ordered_dates->num_rows > 0){
                    while ($last_ordered_date = $last_ordered_dates->fetch_assoc()) {
                        $date = $last_ordered_date['last_order'];
                    } ?>
                <td><?php echo $date; ?></td>
            </tr>
        <?php
                }   
            }
        }
        else {
            echo '<tr><td colspan="6">No records found</td></tr>';
        } ?>
        </table>

        <?php
        // display the total amount of order of specific customers from the search bar
        if (isset($_POST['block']) and isset($_POST['lot']) and isset($_POST['phase'])) {
            $block = $_POST['block'];
            $lot = $_POST['lot'];
            $phase = $_POST['phase'];

            $amount = select_where(array("SUM(price) as total_amount"), "orders", "block = $block AND lot = $lot AND phase = $phase");

            if(mysqli_num_rows($amount) > 0){
                while($records = mysqli_fetch_assoc($amount)){
                    $total_amount = $records['total_amount'];
                }
            }
        }
        ?>

        <!-- display total amount of orders of specific customer -->
        <div class="total_amount_section" id="total_amount_section">
            <h3 class="total_label" id="total_label">Total Amount of Orders</h3>
            <h3 class="total_amount" id="total_amount"><?php if(isset($total_amount)) ? echo $total_amount : echo ''; ?></h3>
        </div>
</body>
</html>


