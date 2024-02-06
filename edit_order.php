<?php 
include('connection.php');
include('queries.php');
include('alerts.php');

// gets the id of the transaction to be edited from the url
$id = $_REQUEST['id'];

// fetching records from the database using query functions
$record = get_order($id);
$all_products = select(array("code","product_desc"), "products");
$all_deliverers = select_where(array("id","employee_name"),"employees","emp_type_code = 'D'");

if (mysqli_num_rows($record) > 0) {
    while($order = mysqli_fetch_assoc($record)) { 
        $order_info = $order;
    }
}

// fetching the submitted data from edit form, queries to update order info
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
    </style>
</head>
<body class="custom-font">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vh-100">
                <?php include('navbar.html'); ?>
            </div>
            <div class="col-10 vh-100">
                <div class="row mt-3">
                    <h2>Editing Order #<?php echo $id?></h2>
                </div>
                <!-- form is processed in the same page -->
                <form action="<?php echo $_SERVER['PHP_SELF']?>?id=<?php echo $id ?>" method="post">
                    <!-- customer info -->
                    <div class="row d-flex justify-content-center">
                        <div class="row mt-3 text-center">
                            <h4>Customer Information</h3>
                        </div>
                        <div class="row d-flex justify-content-center border rounded border-dark p-3 w-50">
                            <div class="row text-center justify-content-center">
                                <div class="col-2"><label for="blk">Block</label></div>
                                <div class="col-2"><label for="lot"> Lot</label></div>
                                <div class="col-2"><label for="ph"> Phase</label><br></div>
                            </div>
                            <!-- inputs for block, lot, phase -->
                            <div class="row justify-content-center">
                                <div class="col-2"><input type="text" class="w-100" id="blk" name="blk" value="<?php echo $order_info['block'];?>" required></div>
                                <div class="col-2"><input type="text" class="w-100" id="lot" name="lot" value="<?php echo $order_info['lot'];?>" required></div>
                                <div class="col-2"><input type="text" class="w-100" id="ph" name="ph" value="<?php echo $order_info['phase'];?>" required></div>
                            </div>
                        </div>
                    </div>
                    <!-- order info -->
                    <div class="row d-flex justify-content-center">
                        <div class="row mt-4 text-center">
                            <h4>Order Information</h4>
                        </div>
                        <div class="row d-flex justify-content-center border rounded border-dark p-3 w-75">
                            <div class="row p-0 text-center justify-content-center">
                                <div class="col-5"><label for="type">Type</label></div>
                                <div class="col-3"><label for="qty"> Quantity</label></div>
                                <div class="col-4"><label for="deliverer"> Deliverer</label><br></div>
                            </div>
                            <div class="row p-0 justify-content-center">
                                <!-- dropdown for product type -->
                                <div class="col-5 d-flex justify-content-center p-0">
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
                                </div>
                                <!-- input for quantity -->
                                <div class="col-3 d-flex justify-content-center"><input class="w-50" type="text" id="qty" name="qty" value="<?php echo $order_info['quantity']?>"required></div>
                                <!-- dropdown for deliverer -->
                                <div class="col-4 d-flex justify-content-center">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- submit button -->
                    <div class="row d-flex justify-content-center mt-3"><input style="width:10%;" type="submit" id="submit" name="submit"></div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
