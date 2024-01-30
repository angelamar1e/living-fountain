<?php
    include("connection.php");
    include("queries.php");
    $all_products = select(array("code","product_desc"), "products");
    $all_deliverers = select_where(array("id","employee_name"),"employees","emp_type_code = 'D'");
?>

<!DOCTYPE html>
<html lang=en>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    </head>
    <body>
        <form>
            <h3>Customer</h3>
            <label for="blk">Block</label>
            <label for="lot"> Lot</label>
            <label for="ph"> Phase</label><br>
            <input type="text" list="blk">
            <datalist id="blk" name="block" required>
                <!-- default option, hints no selection -->
                <option value="" selected disabled hidden>Select</option>
                <!-- fetching each prop type to be set as options, value is code but text displayed is the desc -->
                <?php 
                    $unique_blocks = select_distinct("block","customers");
                    while($block = mysqli_fetch_array($unique_blocks,MYSQLI_ASSOC)):;
                ?> 
                    <option value="<?php echo $block['block'];?>">
                        <?php echo $block['block']; ?>
                    </option>
                <?php
                    endwhile;
                ?>
            </datalist>
            <input type="text" list="lot">
            <datalist id="lot" name="lot" required>
                <!-- default option, hints no selection -->
                <option value="" selected disabled hidden>Select</option>
                <!-- fetching each prop type to be set as options, value is code but text displayed is the desc -->
                <?php 
                    $unique_lots = select_distinct("lot","customers");
                    while($lot = mysqli_fetch_array($unique_lots,MYSQLI_ASSOC)):;
                ?> 
                    <option value="<?php echo $lot['lot'];?>">
                        <?php echo $lot['lot']; ?>
                    </option>
                <?php
                    endwhile;
                ?>
            </datalist>
            <input type="text" list="ph">
            <datalist id="ph" name="phase" required>
                <!-- default option, hints no selection -->
                <option value="" selected disabled hidden>Select</option>
                <!-- fetching each prop type to be set as options, value is code but text displayed is the desc -->
                <?php 
                    $unique_phases = select_distinct("phase","customers");
                    while($phase = mysqli_fetch_array($unique_phases,MYSQLI_ASSOC)):;
                ?> 
                    <option value="<?php echo $phase['phase'];?>">
                        <?php echo $phase['phase']; ?>
                    </option>
                <?php
                    endwhile;
                ?>
            </datalist>

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
        <script>
            $(document).ready(function () {
                //change selectboxes to selectize mode to be searchable
                $("select").select2();
            });
        </script>
    </body>
</html>