<?php
    include("connection.php");
    include("queries.php");
    $all_products = select(array("code","product_desc"), "products");
    $all_deliverers = select_where(array("id","employee_name"),"employees","emp_type_code = 'D'");
?>

<!DOCTYPE html>
<html lang=en>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    </head>
    <body>
        <form action="add_order.php" method="post">
            <h3>Customer</h3>
            <label for="blk">Block</label>
            <label for="lot"> Lot</label>
            <label for="ph"> Phase</label><br>
            <input type="text" id="blk" name="blk" required>
            <input type="text" id="lot" name="lot" required>
            <input type="text" id="ph" name="ph" required>

            <h3>Order</h3>
            <label for="type">Type</label>
            <label for="qty"> Quantity</label>
            <label for="deliverer"> Deliverer</label><br>
            <select id="prod_type" name="prod_type" required>
                <!-- default option, hints no selection -->
                <option value="" selected disabled hidden>Select</option>
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
            <input type="text" id="qty" name="qty" required>
            <select id="deliverer" name="deliverer" required>
                <!-- default option, hints no selection -->
                <option value="" selected disabled hidden>Select</option>
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
            <input type="submit" id="submit" name="submit">
        </form>
    </body>
</html>