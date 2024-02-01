<?php 
include('connection.php');
include('queries.php');
include('alerts.php');

// gets the id of the transaction to be edited from the url
$id = $_REQUEST['id'];
$record = get_order($id);
$all_products = select(array("code","product_desc"), "products");
$all_deliverers = select_where(array("id","employee_name"),"employees","emp_type_code = 'D'");

if (mysqli_num_rows($record) > 0) {
    while($order = mysqli_fetch_assoc($record)) { 
        $order_info = $order;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blk = trim($_REQUEST['blk']);
    $lot = trim($_REQUEST['lot']);
    $ph = trim($_REQUEST['ph']);
    $type = trim($_REQUEST['prod_type']);
    $qty = trim($_REQUEST['qty']);
    $deliverer = trim($_REQUEST['deliverer']);

    $existing_cust = is_existing($blk, $lot, $ph);

    if ($existing_cust == 0){
        if(add_new_customer($blk, $lot, $ph) and update_order($id, $blk, $lot, $ph, $type, $qty, $deliverer)){
            alert_redirect("New customer and transaction recorded successfully.","sales.php");
        }
        else{
            alert_redirect("Error: '. mysqli_error($conn) . '","sales.php");
        };
    }
    else{
        if(update_order($id, $blk, $lot, $ph, $type, $qty, $deliverer)){
            alert_redirect("Transaction recorded successfully.","sales.php");
        }
        else{
            alert_redirect("Error: '. mysqli_error($conn) . '","sales.php");
        };
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?php echo $id?></title>
</head>
<body>
    
    <form action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $id ?>" method="post">
        <!-- customer info -->
        <h3>Customer</h3>
        <label for="blk">Block</label>
        <label for="lot"> Lot</label>
        <label for="ph"> Phase</label><br>
        <!-- inputs for blk, lot, phase -->
        <input type="text" id="blk" name="blk" value="<?php echo $order_info['block'];?>" required>
        <input type="text" id="lot" name="lot" value="<?php echo $order_info['lot'];?>" required>
        <input type="text" id="ph" name="ph" value="<?php echo $order_info['phase'];?>" required>

        <!-- order info -->
        <h3>Order</h3>
        <label for="type">Type</label>
        <label for="qty"> Quantity</label>
        <label for="deliverer"> Deliverer</label><br>

        <!-- dropdown for product type -->
        <select id="prod_type" name="prod_type" required>
            <!-- default option, reflects the selection before editing -->
            <option value="<?php echo $order_info['prod_code']?>" selected hidden><?php echo $order_info['product']?></option>
            <!-- fetching each prop type to be set as options, value is code but text displayed is the desc -->
            <?php 
                while($product = mysqli_fetch_array($all_products,MYSQLI_ASSOC)):;
            ?> 
                <option value="<?php echo $product['code'];?>">
                    <?php echo $product['product_desc']; ?>
                </option>
            <?php
                endwhile;
            ?>
        </select>

        <!-- input for quantity -->
        <input type="text" id="qty" name="qty" value="<?php echo $order_info['quantity']?>"required>

        <!-- dropdown for deliverer -->
        <select id="deliverer" name="deliverer" required>
            <!-- default option, hints no selection -->
            <option value="<?php echo $order_info['deliverer_id']?>" selected hidden><?php echo $order_info['deliverer']?></option>
            <!-- fetching each deliverer to be set as options, value is id but text display is name -->
            <?php 
                while($deliverer = mysqli_fetch_array($all_deliverers,MYSQLI_ASSOC)):;
            ?> 
                <option value="<?php echo $deliverer['id'];?>">
                    <?php echo $deliverer['employee_name']; ?>
                </option>
            <?php
                endwhile;
            ?>
        </select>

        <!-- submit button -->
        <input type="submit" id="submit" name="submit">
    </form>
</body>
</html>
