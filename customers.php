<?php
 include('alerts.php');
 include('connection.php');
 include('queries.php');
 include('navbar.html');

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

    <!-- Search bar for customer details -->
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="blk">Block</label>
    <input type="text" id="blk" name="blk">
    
    <label for="lot">Lot</label>
    <input type="text" id="lot" name="lot">
    
    <label for="ph">Phase</label>
    <input type="text" id="ph" name="ph">

    <input type="submit" value="Search">
    </form>
    <br>
</body>
</html>
<?php
// handle customer search logic
    $conditions = [];
    // Check each value and add conditions if they are not empty
    if (isset($_REQUEST['blk']) or isset($_REQUEST['blk']) or isset($_REQUEST['blk'])){
        if (!empty($_REQUEST['blk'])) {
            $blk = $_REQUEST['blk'];
            $conditions[] = "block = " . $blk . " ";
        }
        if (!empty($_REQUEST['lot'])) {
            $lot = $_REQUEST['lot'];
            $conditions[] = "lot = " . $lot . " ";
        }
        if (!empty($_REQUEST['ph'])) {
            $ph = $_REQUEST['ph'];
            $conditions[] = "phase = " . $ph . "";
        }

        // query to search matching records
        $search_results = search_customers($conditions);

        // displaying matching records
        if (mysqli_num_rows($search_results) > 0) { ?>
            <table>
                <tr>
                    <th>Block</th>
                    <th>Lot</th>
                    <th>Phase</th>
                </tr>
                <?php
                while($record = mysqli_fetch_assoc($search_results)) { 
                    $block = $record['block'];
                    $lot = $record['lot'];
                    $phase = $record['phase']; ?>
                    <tr onclick="location.href='customer_activity.php?block=<?php echo $block; ?>&lot=<?php echo $lot; ?>&phase=<?php echo $phase; ?>'">
                        <td><?php echo $block; ?> </td>
                        <td><?php echo $lot; ?> </td>
                        <td><?php echo $phase; ?> </td>
                    </tr>
                <?php
                } ?>
                </table>
 <?php }
        else { ?>
        <h4>No customers found. </h4>
    <?php }   
    } 
    else { ?>
        <table id="last_ordered_table">
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
    <?php 
    } ?>