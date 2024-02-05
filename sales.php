<?php
    include('navbar.html');
    include('alerts.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <link rel="stylesheet" href="./sales.css" />
    <script src="helper_functions.js"></script>
</head>
<body>
    <img class="bg-image" alt="" src="./public/bg-image.png"/>
        <h1 id="sales_page_label">Sales</h1>
    <?php 
        include("order_form.php");
    ?>
    <h2 id="order_records_label">Order Records</h2>
    <!-- form to filter orders to be displayed by date -->
    <form id="dateForm" method="get" action="sales.php">
        <label for="date">Filter orders to display by date:</label>
        <input type="date" id="date" name="date">
        <!-- hidden submit button to trigger form submission using js -->
        <input type="submit" style="display:none">
    </form>

    <!-- if the dateForm is changed, records for the date is queried -->
    <?php
        if(isset($_REQUEST['date'])){
            $date = $_REQUEST['date'];
            $all_records = all_orders($date);
        }
        // default is orders of the current day 
        else{ 
            $date = date("Y-m-d");
            $all_records = all_orders($date);
        }

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

    <!-- date display -->
    <span><h3>Date: <?php echo $date;?></h3></span>

    <?php
        // loops through the query result to display into a table
        if (mysqli_num_rows($all_records) > 0) { ?>
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
                        <th>Edit / Delete</th>
                    </tr>
                    <?php
                    while($record = mysqli_fetch_assoc($all_records)) { ?>
                        <tr>
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
                <div id="revenue_section" class="revenue_section">
                    <h3 id="revenue_label" class="revenue_label">Revenue</h3>
                    <h3 id="revenue_amt" class="revenue_amt"><?php echo $current_revenue;?></h3>
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
    <!-- call to script, triggers automatic form submission -->
    <script src="helper_functions.js"></script>
</body>
</html>
