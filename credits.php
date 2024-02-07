<?php
include("connection.php");
include("queries.php");
include("alerts.php");

// to retrieve updated status
if(isset($_REQUEST['order_id']) and isset($_REQUEST['status'])){
    $status = $_REQUEST['status'];
    $id = $_REQUEST['order_id'];
    update_status($status,$id);
    refresh();
}

$dates_with_credit = select_where(array("DISTINCT date"),"orders","status = 'D'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="credits.css">
    <style>
        /* Hover effect for table rows */
        table tr:hover {
            background-color: #d3dde6;
        }
        @font-face {
        font-family: 'CustomFont';
        src: url('fonts/FontsFree-Net-SFProText-Medium-1.ttf');
        }

        /* Define font stack */
        .custom-font {
            font-family: 'CustomFont', Arial, sans-serif; /* Use the custom font with fallbacks */
        }
    </style>
    <script src="helper_functions.js"></script>
</head>
<body class="custom-font">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-2 vh-100"><?php include('navigation.html'); ?></div>
            <div class="col-10 vh-100">
            <div class="row mt-3">
                <div class="m-1 col-6 d-flex align-items-end">
                <h1 class="display-3 m-0 text-primary" id="credits_page_label">Credits</h1>
                </div>
                 <div class="row d-flex justify-content-center">
                     <?php
                        if (mysqli_num_rows($dates_with_credit) > 0) {
                            while ($record = mysqli_fetch_assoc($dates_with_credit)) {
                                $date = date_create($record['date']);
                                $date = date_format($date,"M-d-Y"); ?>
                                <!-- displaying each date -->
                                <div class="col d-flex mt-3 justify-content-end align-items-end">
                        <span style="padding-right:2%; color: #007bff; font-weight: bold; font-size: 1.5rem;" class="h2"><i class="fa-regular fa-calendar"></i> <?php echo $date; ?></span>
                    </div>
                 </div>
                                <!-- displaying a table for credits per date -->
                                <div class="row justify-content-center">
                                    <div class="row p-3 border rounded border-dark">
                                    <table class="table table-bordered text-center m-0" id="credit_records">
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
                                        // Get delivered but unpaid records for the dates retrieved
                                        $date = $record['date'];
                                        $unpaid_records = get_unpaid_records($date);
                                        if (mysqli_num_rows($unpaid_records) > 0) {
                                        // Records found
                                            while ($record = mysqli_fetch_assoc($unpaid_records)) { ?>
                                                <tr class="hoverable">
                                                    <td><?php echo $record['block']; ?></td>
                                                    <td><?php echo $record['lot']; ?></td>
                                                    <td><?php echo $record['phase']; ?></td>
                                                    <td><?php echo $record['product']; ?></td>
                                                    <td><?php echo $record['quantity']; ?></td>
                                                    <td><?php echo $record['price']; ?></td>
                                                    <td><?php echo $record['deliverer']; ?></td>
                                                    <td>
                                                    <form method="post" action="" class="status_select" id="status_select" name="status_select">
                                                        <input type="text" value="<?php echo $record['id']; ?>" id="order_id" name="order_id" style="display:none">
                                                        <select class="status" id="status" name="status">
                                                            <!-- reflects the status saved in the database -->
                                                            <option value="<?php echo $record['code'];?>" selected disabled hidden><?php echo $record['status']; ?></option>
                                                            <!-- fetching each status to be set as options, value stored in db is code but text displayed is the desc -->
                                                            <?php
                                                                $all_status = select_where(array("code","status_desc"),"order_status","code = 'D' OR code = 'PD'");
                                                                while($status = mysqli_fetch_array($all_status,MYSQLI_ASSOC)):;
                                                            ?>
                                                                <option value="<?php echo $status['code'];?>">
                                                                    <?php echo $status['status_desc']; ?>
                                                                </option>
                                                            <?php
                                                                endwhile;
                                                            ?>
                                                        </select>
                                                        <!-- hidden submit button to trigger form submission using js -->
                                                        <input type="submit" style="display:none">
                                                    </form>
                                                    </td>
                                                </tr>
                                                <?php
                                            } ?>
                                            </table> 
                                </div> <?php
                            }
                        }
                            }
                        else { ?>
                            <div class="row w-75 border rounded border-dark p-3 mt-5 text-center">
                                <h4>No credits recorded. </h4>
                            </div>
                        <?php }
                                     ?>
                                     <!-- Call to script, triggers automatic form submission -->
                                     <script src="helper_functions.js"></script>
                 </div>
            </div>
        </div>
    </div>
</body>
</html>
