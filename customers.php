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
    <link rel="stylesheet" href="customers.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>
    .label-customer-page {
    color: #275385; 
    font-family: Arial, sans-serif;
    font-weight: bold;
    }
</style>
<body>
    <style>
        @font-face {
        font-family: 'CustomFont';
        src: url('fonts/FontsFree-Net-SFProText-Medium-1.ttf');
        }

        /* Define font stack */
        .custom-font {
        font-family: 'CustomFont', Arial, sans-serif; /* Use the custom font with fallbacks */
        }
    </style>
</head>
<body class="custom-font">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vh-100">
                <?php include('navigation.html'); ?>
            </div>
            <div class="col-10 vh-100 overflow-scroll">
                <div class="row mt-3 d-flex justify-content-center align-items-center">
                    <div class="col-5">
                        <div class="row p-0 h-50">
                            <div class="p-0 d-flex justify-content-center align-items-center">
                                <h1 class="display-6 h-50" id="label_customer_page">Customer Activity</h1>
                            </div>
                        </div>
                    </div>
                    <!-- Search bar for customer details -->
                    <div class="col-5">
                        <div class="row d-flex justify-content-end align-items-center">
                            <div class="col-2 m-1 p-0 text-center"><label for="blk">Block</label></div>
                            <div class="col-2 m-1 p-0 text-center"><label for="lot">Lot</label></div>
                            <div class="col-2 m-1 p-0 text-center"><label for="ph">Phase</label></div>
                        </div>
                        <div class="row d-flex justify-content-end align-items-center">
                            <div class="col-2 m-1 p-0 d-flex justify-content-center align-items-center">
                                <form class="w-100" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input class="w-100" type="text" id="blk" name="blk">
                                </div>
                                <div class="col-2 p-0 m-1 d-flex justify-content-center align-items-center"><input class="w-100" type="text" id="lot" name="lot"></div>
                                <div class="col-2 m-1 p-0 d-flex justify-content-center align-items-center"><input class="w-100" type="text" id="ph" name="ph"></div>
                            </div>
                        </div>
                        <div class="col d-flex align-items-end">
                            <div class="row">
                                <div class="col"> <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-magnifying-glass"></i> Search </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                
                <div class="row d-flex justify-content-center"> 
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
                                <div class="row w-75">
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
                                            <tr class="text-center" style="cursor:pointer;" onclick="location.href='customer_activity.php?block=<?php echo $block; ?>&lot=<?php echo $lot; ?>&phase=<?php echo $phase; ?>'">
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
                                        <div class="row mt-5 text-center">
                                            <h4>No customers found. </h4>
                                        </div>
                                <?php }   
                                } 
                                else { ?>
                                    <div class="row mt-4 w-75">
                                        <div class="col">
                                            <table class="table table-bordered" id="last_ordered_table">
                                                <tr class="text-center">
                                                    <th>Block</th>
                                                    <th>Lot</th>
                                                    <th>Phase</th>
                                                    <th>Last Ordered Date <i class="far fa-calendar"></i></th>
                                                </tr>
                                            <?php
                                                if ($all_customers->num_rows > 0) {
                                                    while ($record = $all_customers->fetch_assoc()) {
                                                        $block = $record['block'];
                                                        $lot = $record['lot'];
                                                        $phase = $record['phase'];?>
                                                    <tr class="text-center" style="cursor:pointer;" onclick="location.href='customer_activity.php?block=<?php echo $block; ?>&lot=<?php echo $lot; ?>&phase=<?php echo $phase; ?>'">
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
                                                else { ?>
                                                    <div class="row mt-5 text-center">
                                                        <h4>No customers found. </h4>
                                                    </div>
                                                <?
                                                } ?>
                                            </table>
                                <?php }
                            } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
