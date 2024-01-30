<?php
    include("connection.php");
    include("queries.php");
    $all_products = select(array("code","product_desc"), "products");
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
            <label for="lot"> Lot</label>
            <label for="ph">Phase</label><br>
            <select id="prod_type" name="prod_type" required>
                <!-- default option, hints no selection -->
                <option value="" selected disabled hidden>Select</option>
                <!-- fetching each prop type to be set as options, value is id but text displayed is the desc -->
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
            <input type="text" id="lot" name="lot">
            <input type="text" id="ph" name="phase">
        </form>
    </body>
</html>