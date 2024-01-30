<?php
    include("connection.php");
    include("queries.php");
    $all_products = select(array("code","product_desc"), "products");
    $all_deliverers = select_where(array("id","employee_name"),"employees","emp_type_code = 'D'");
?>

<!DOCTYPE html>
<html lang=en>
    <body>
        <form>
            <h3>Customer</h3>
            <label for="blk">Block</label>
            <label for="lot"> Lot</label>
            <label for="ph"> Phase</label><br>
            <input type="text" id="blk" name="block">
            <input type="text" id="lot" name="lot">
            <input type="text" id="ph" name="phase">

            <h3>Order</h3>
            <label for="type">Type</label>
            <label for="lot"> Quantity</label>
            <label for="ph"> Deliverer</label><br>
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
            <input type="text" id="qty" name="qty">
            <select id="deliverer" name="deliverer" required>
                <!-- default option, hints no selection -->
                <option value="" selected disabled hidden>Select</option>
                <!-- fetching each deliverer to be set as options, value is id but text displayed is the desc -->
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
        </form>
    </body>
</html>