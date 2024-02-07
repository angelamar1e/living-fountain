<?php
    include('alerts.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <script src="helper_functions.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
        font-family: 'CustomFont';
        src: url('fonts/FontsFree-Net-SFProText-Medium-1.ttf');
        }

        /* Define font stack */
        .custom-font {
            font-family: 'CustomFont', Arial, sans-serif; /* Use the custom font with fallbacks */
        }
        #edit:hover, #delete:hover {
        background-color: #0056b3 !important; 
        }
    </style>
</head>
<body class="custom-font">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-2 vh-100">
                <?php include('navigation.html'); ?>
            </div>
            
            <div class="mt-3 col-10 vh-100">
                <h1 class="display-3 m-0 text-primary" id="sales_page_label" style="color: #353a41;">Sales</h1><br>
            <?php 
                include("order_form.php");
                // if the dateForm is changed, records for the date is queried -->
                if(isset($_REQUEST['date'])){
                    $date = $_REQUEST['date'];
                    $all_records = all_orders($date);
                }
                // default is orders of the current day
                else{
                    $date = date("Y-m-d");
                    $all_records = all_orders($date);
                }
            ?>
            <div class="row mt-4">
                <div class="col-7">
                    <h2 class="display-6 text-primary" id="order_records_label" style="color: #353a41";>Order Records <span class="h3 p-1 rounded-3 text-primary">• <?php ; echo date_format(date_create($date),"M-d-Y");?></span></h2>
                </div>
                <!-- form to filter orders to be displayed by date -->
                <div class="col-5 d-flex align-items-end">
                    <div class="row d-flex justify-content-end">
                        <div class="col-6 d-flex justify-content-end p-0 h-50">
                            <form id="dateForm" method="get" action="sales.php">
                                <p class="h4 p-1 rounded-3 text-primary"><label for="date">Filter by date:</label></h5>
                        </div>
                            <div class="col-6 mt-2"><input type="date" id="date" name="date"></div>
                                <!-- hidden submit button to trigger form submission using js -->
                                <input type="submit" style="display:none">
                            </form>
                    </div>
                </div>
            </div>
            <?php
                // to retrieve updated status
                if(isset($_REQUEST['order_id']) and isset($_REQUEST['status'])){
                    $status = $_REQUEST['status'];
                    $id = $_REQUEST['order_id'];
                    update_status($status,$id);
                    refresh();
                }
                // determines if delete process is started
                if(isset($_GET['delete'])){
                    $id = $_GET['id'];
                    $delete_result = delete_order($id);
                    delete_alerts($delete_result);
                }
                $revenue = select_where(array("SUM(price) as 'revenue'"),"orders","date = '$date'");
                if (mysqli_num_rows($revenue) > 0) {
                    while($record = mysqli_fetch_assoc($revenue)) {
                        $current_revenue = $record['revenue'];
                    }
                }
            ?>
            
            <div class="row m-2 h-auto border rounded border-dark p-3 justify-content-center overflow-scroll" style="max-height:70vh;">
                <?php
                    // loops through the query result to display into a table
                    if (mysqli_num_rows($all_records) > 0) { ?>
                    <div id="revenue_section" class="row w-100 d-flex text-center">
                                <div style="width:18%;" class="col-3 d-flex p-0 align-items-center">
                                    <h3 id="revenue_label" class="h3 revenue_label text-primary">Revenue: </h3>
                                </div>
                                <div class="col-3 p-0 d-flex align-items-center ">
                                    <h3 id="revenue_amt" class="revenue_amt m-0 text-primary">₱<?php echo $current_revenue;?></h3>
                                </div>
                            </div>
                        <div class="row h-25" id="table_container">
                            <table class="table table-bordered text-white bg-primary" id=all_records>
                                <tr class="text-center">
                                    <th class = "text-white bg-primary">Block</th>
                                    <th class = "text-white bg-primary">Lot</th>
                                    <th class = "text-white bg-primary">Phase</th>
                                    <th class = "text-white bg-primary">Product</th>
                                    <th class = "text-white bg-primary">Quantity</th>
                                    <th class = "text-white bg-primary">Price</th>
                                    <th class = "text-white bg-primary">Deliverer</th>
                                    <th class = "text-white bg-primary">Status</th>
                                </tr>
                                <?php
                                while($record = mysqli_fetch_assoc($all_records)) { ?>
                                    <tr class="text-center">
                                        <td><?php echo $record['block']; ?> </td>
                                        <td><?php echo $record['lot']; ?> </td>
                                        <td><?php echo $record['phase']; ?> </td>
                                        <td><?php echo $record['product']; ?> </td>
                                        <td><?php echo $record['quantity']; ?> </td>
                                        <td><?php echo $record['price']; ?> </td>
                                        <td><?php echo $record['deliverer']; ?> </td>
                                        <!-- form to update status as it is changed by user -->
                                        <td>
                                            <form method="post" action="" class="status_select" id="status_select" name="status_select">
                                                <input type="text" value="<?php echo $record['id']; ?>" id="order_id" name="order_id" style="display:none">
                                                <select class="status" id="status" name="status">
                                                    <!-- reflects the status saved in the database -->
                                                    <option value="<?php echo $record['code'];?>" selected disabled hidden><?php echo $record['status']; ?></option>
                                                    <!-- fetching each status to be set as options, value stored in db is code but text displayed is the desc -->
                                                    <?php
                                                        $all_status = select(array("code","status_desc"),"order_status");
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
                                    <!-- action buttons -->
                                        <div class="row">
                                            <td style="width:30%;">
                                                <!-- edit button leads to a url with the id of the specific order -->
                                                <button id="edit" class= "bg-primary text-white" onclick="window.location.href='edit_order.php?id=<?php echo $record['id']; ?>'">Edit</button>
                                                <button id="delete" class= "bg-primary text-white"  onclick="confirm_delete_order(<?php echo $record['id']; ?>)">Delete</button>
                                            </td
                                        </div>
                                    </tr>
                                <?php
                                } ?>
                            </table>
                        </div>
                    <?php
                    }
                    else { ?>
                        <tr>
                            <td colspan="8">No sales recorded. </td>
                        </tr>
                    <?php
                    }
                    ?>
                </div>
                </div>
            </div>
        </div>
    <!-- call to script, triggers automatic form submission -->
    <script src="helper_functions.js"></script>
</body>
</html>
