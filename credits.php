<?php
include("connection.php");
include("queries.php");
include("alerts.php");
include('navbar.html');

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
    <script src="helper_functions.js"></script>
</head>
<body>
    <h1 id="credits_page_label">Credits</h1>
     <?php
        if (mysqli_num_rows($dates_with_credit) > 0) {
            while ($record = mysqli_fetch_assoc($dates_with_credit)) { 
                $date = $record['date']; ?>
                <!-- displaying each date -->
                <h1 id="date_display" class="date_display"><?php echo $date; ?></h1>
                <!-- displaying a table for credits per date -->
                <div id="table_container">
                    <table id="credit_records">
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
                    $unpaid_records = get_unpaid_records($date);
                    if (mysqli_num_rows($unpaid_records) > 0) {
                    // Records found
                        while ($record = mysqli_fetch_assoc($unpaid_records)) { ?>
                            <tr>
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
                        </table>
                        </div>
                            <?php
                        }
                } else {
                    // No records found
                    echo "<tr><td colspan='8'>No credit records found</td></tr>";
                }
            }
        }
    ?>
    <!-- Call to script, triggers automatic form submission -->
    <script src="helper_functions.js"></script>
</body>
</html>
