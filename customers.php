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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vh-100">
                <?php include('navbar.html'); ?>
            </div>
            <div class="col-10 vh-100 overflow-scroll">
                <div class="row p-3">
                    <h1 id="label_customer_page">Customer Activity</h1>
                </div>
                <!-- Search bar for customer details -->
                <div class="row d-flex justify-content-center">
                        <div class="row">
                            <div class="col-2 text-center"><label for="blk">Block</label></div>
                            <div class="col-2 text-center"><label for="lot">Lot</label></div>
                            <div class="col-2 text-center"><label for="ph">Phase</label></div>
                        </div>
                        <div class="row">
                            <div class="col-2 d-flex text-center">
                                <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input class="w-50" type="text" id="blk" name="blk">
                            </div>
                            <div class="col-2 d-flex justify-content-center"><input class="w-50" type="text" id="lot" name="lot"></div>
                            <div class="col-2 d-flex justify-content-center"><input class="w-50" type="text" id="ph" name="ph"></div>
                     
                            <div class="col-2">
                                <input type="submit" value="Search">
                            </div>
                                </form>
                        </div>
                            
                        
                <br>
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
                        <div class="row">
                            <table class="mt-4 table table-bordered">
                                <tr class="text-center">
                                    <th>Block</th>
                                    <th>Lot</th>
                                    <th>Phase</th>
                                </tr>
                                <?php
                                while($record = mysqli_fetch_assoc($search_results)) {
                                    $block = $record['block'];
                                    $lot = $record['lot'];
                                    $phase = $record['phase']; ?>
                                    <tr class="text-center" onclick="location.href='customer_activity.php?block=<?php echo $block; ?>&lot=<?php echo $lot; ?>&phase=<?php echo $phase; ?>'">
                                        <td><?php echo $block; ?> </td>
                                        <td><?php echo $lot; ?> </td>
                                        <td><?php echo $phase; ?> </td>
                                    </tr>
                                <?php
                                } ?>
                                </table>
                        </div>
                        <?php }
                                else { ?>
                                <h4>No customers found. </h4>
                        <?php }   
                        } 
                        else { ?>
                            <div class="row mt-4">
                                <div class="col">
                                    <table class="table table-bordered" id="last_ordered_table">
                                        <tr class="text-center">
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
                                            <tr class="text-center" onclick="location.href='customer_activity.php?block=<?php echo $block; ?>&lot=<?php echo $lot; ?>&phase=<?php echo $phase; ?>'">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php 
                } ?>
        </div>
    </div>
</body>
</html>