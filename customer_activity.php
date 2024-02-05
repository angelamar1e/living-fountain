<?php
    include('connection.php');
    include('queries.php');

    // display the total amount of order of specific customers from the search bar
    if (isset($_GET['block']) and isset($_GET['lot']) and isset($_GET['phase'])) {
        $block = $_GET['block'];
        $lot = $_GET['lot'];
        $phase = $_GET['phase'];

        $total_amount = compute_total($block,$lot,$phase);
        $orders = customer_orders($block,$lot,$phase);
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Block <?php echo $block," Lot ", $lot," Phase ", $phase ?></title>
    </head>
    <body>
        <?php
        if (mysqli_num_rows($orders) > 0) { ?>
            <h3 class="address_label">Block: <?php echo $block ?></h3>
            <h3 class="address_label">Lot: <?php echo $lot ?></h3>
            <h3 class="address_label">Phase: <?php echo $phase ?></h3>
            <h2 id="order_history_label">Order History</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Deliverer</th>
                    <th>Status</th>
                </tr>
                <?php
                while($record = mysqli_fetch_assoc($orders)) { ?>
                    <tr>
                        <td><?php echo $record['date'];?> </td>
                        <td><?php echo $record['product'];?> </td>
                        <td><?php echo $record['quantity'];?> </td>
                        <td><?php echo $record['price'];?> </td>
                        <td><?php echo $record['deliverer'];?> </td>
                        <td><?php echo $record['status'];?> </td>
                        </tr>
                <?php
                } ?>
                </table>

                <!-- display total amount of orders of specific customer -->
                <div class="total_amount_section" id="total_amount_section">
                    <h3 class="total_label" id="total_label">Total Amount of Orders</h3>
                    <h3 class="total_amount" id="total_amount"><?php echo $total_amount; ?></h3>
                </div>
 <?php }
        else { ?>
        <h4>No transactions were recorded for this customer. </h4>
    <?php }   ?>
    </body>
    </html>