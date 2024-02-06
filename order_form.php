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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="row text-center">
                    <h2 class="display-6" id="add_order_label">Add New Order</h2>
                </div>
                <div class="row border rounded border-dark p-3">
                        <div class="col-4">
                            <!-- form proceeds to add_order.php after submission -->
                            <form action="add_order.php" method="post">
                            <!-- customer info -->
                            <div class="row">
                                <h3>Customer</h3>
                            </div>
                            <div class="row">
                                <div class="col-4 text-center"><label for="blk">Block</label></div>
                                <div class="col-4 text-center"><label for="lot"> Lot</label></div>
                                <div class="col-4 text-center"><label for="ph"> Phase</label><br></div>
                            </div>
                            <!-- inputs for block, lot, phase -->
                            <div class="row">
                                <div class="col-4"><input  class="w-100" type="text" id="blk" name="blk" required></div>
                                <div class="col-4"><input  class="w-100" type="text" id="lot" name="lot" required></div>
                                <div class="col-4"><input class="w-100" type="text" id="ph" name="ph" required></div>
                            </div>
                        </div>
                        <div class="col-1 p-0"></div>
                        <!-- order info -->
                        <div class="col-5 p-0 align-items-center">
                            <div class="row">
                                <h3>Order</h3>
                            </div>
                            <div class="row">
                                <div class="col-5 text-center"><label for="type">Type</label></div>
                                <div class="col-3 text-center"><label for="qty"> Quantity</label></div>
                                <div class="col-4 text-center"><label for="deliverer"> Deliverer</label><br></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-5">
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
                                </div>
                                <div class="col-3 p-0 d-flex justify-content-center">
                                    <!-- input for quantity -->
                                    <input class="w-50" type="text" id="qty" name="qty" required>
                                </div>
                                <!-- dropdown for deliverer -->
                                <div class="col-4 p-0 d-flex justify-content-center">
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
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <!-- submit button -->
                            <input class="h-50" type="submit" id="submit" name="submit">
                        </div>
                        </form>
                </div>
        </div>
    </body>
</html>