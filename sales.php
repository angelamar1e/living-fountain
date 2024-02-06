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
    <link rel="stylesheet" href="sales.css">
</head>
<body>


    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vh-100">
                <?php include('navbar.html'); ?>
            </div>
            
<<<<<<< HEAD
            <div class="col-10">
                <br>
                <h1 id="sales_page_label" class="text-primary">Sales</h1>
            <?php
                include("order_form.php");
            ?>
            <div class="row mt-4 ">
                <div class="col ">
                    <h2  class="text-white" id="order_records_label"> <span class="bg-primary p-1 rounded-3">Order Records • <small class="font-weight-italic"><?php echo date("M-d-Y");?></small></h2>
                </div>
                <!-- form to filter orders to be displayed by date -->
                <div class="col">
                    <div class="row ">
                        <div class="col-6 d-flex align-items-baseline">
                            <form id="dateForm" method="get" action="sales.php">
                                <h5><label  class="text-white" class="text-right" for="date"><span class="bg-primary p-2 rounded-3">Filter orders by date:</label></h5><br>
                        </div>
                            <div class="col-6"><input type="date" id="date" name="date"></div>
                                <!-- hidden submit button to trigger form submission using js -->
                                <input type="submit" style="display:none">
                            </form>
                    </div>
                </div>
            </div>
            <!-- if the dateForm is changed, records for the date is queried -->
            <?php
=======
            <div class="mt-3 col-10">
                <h1 class="display-1 m-0" id="sales_page_label">Sales</h1>
            <?php
                include("order_form.php");
                // if the dateForm is changed, records for the date is queried -->
>>>>>>> 7a55874cb2d8cd1e11995c7ba49b380d46493f43
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
                    <h2 class="display-6" id="order_records_label">Order Records • <span class="h2"><?php ; echo date_format(date_create($date),"M-d-Y");?></span></h2>
                </div>
                <!-- form to filter orders to be displayed by date -->
                <div class="col-5 d-flex align-items-end">
                    <div class="row d-flex justify-content-end">
                        <div class="col-6 d-flex justify-content-end p-0 h-50">
                            <form id="dateForm" method="get" action="sales.php">
                                <p class="h5"><label for="date">Filter by date:</label></h5>
                        </div>
                            <div class="col-6"><input type="date" id="date" name="date"></div>
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
            
            <div class="row h-auto border rounded border-dark p-3 justify-content-center overflow-scroll" style="max-height: 60vh;">
                <?php
                    // loops through the query result to display into a table
                    if (mysqli_num_rows($all_records) > 0) { ?>
                    <div id="revenue_section" class="row w-100 d-flex text-center">
                                <div style="width:20%;" class="col-3 d-flex p-0 align-items-center">
                                    <h3 id="revenue_label" class="display-6 revenue_label">Revenue: </h3>
                                </div>
                                <div class="col-3 p-0 d-flex align-items-center ">
                                    <h2 id="revenue_amt" class="revenue_amt m-0">₱<?php echo $current_revenue;?></h3>
                                </div>
                            </div>
                        <div class="row h-25" id="table_container">
                            <table class="table table-bordered" id=all_records>
                                <tr class="text-center">
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
                                        <td>
                                            <!-- edit button leads to a url with the id of the specific order -->
                                            <button id="edit" onclick="window.location.href='edit_order.php?id=<?php echo $record['id']; ?>'">Edit</button>
                                            <button id="delete" onclick="confirm_delete_order(<?php echo $record['id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                } ?>
                            </table>
                        </div>
                    <?php
                    }
                    else { ?>
                        <tr>
                            <td colspan = "8">No sales recorded.</td>
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
