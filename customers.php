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
                $phase = $record['phase'];?>
            <tr onclick="location.href='customer_activity.php?block=<?php echo $block; ?>&lot=<?php echo $lot; ?>&phase=<?php echo $phase; ?>'">
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
</body>
</html>