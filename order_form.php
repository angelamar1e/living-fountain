<?php
    include("connection.php");
    include("queries.php");

    // queries records
    $all_products = select(array("code","product_desc"), "products");
    $all_deliverers = select_where(array("id","employee_name"),"employees","emp_type_code = 'D'");
?>

<!DOCTYPE html>
<html lang=en>
    <head>
    </head>
    <body>
        <!-- form proceeds to add_order.php after submission -->
        <form action="add_order.php" method="post">
            <!-- customer info -->
            <h3>Customer</h3>
            <label for="blk">Block</label>
            <label for="lot"> Lot</label>
            <label for="ph"> Phase</label><br>
            <!-- inputs for block, lot, phase -->
            <input type="text" id="blk" name="blk" required>
            <input type="text" id="lot" name="lot" required>
            <input type="text" id="ph" name="ph" required>

            <!-- order info -->
            <h3>Order</h3>
            <label for="type">Type</label>
            <label for="qty"> Quantity</label>
            <label for="deliverer"> Deliverer</label><br>
            
            <!-- dropdown for product type -->
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

            <!-- input for quantity -->
            <input type="text" id="qty" name="qty" required>

            <!-- dropdown for deliverer -->
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

            <!-- submit button -->
            <input type="submit" id="submit" name="submit">
        </form>
    </body>
</html>