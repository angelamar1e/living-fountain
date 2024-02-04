<?php
    include('connection.php');
    include('queries.php');

    // display the total amount of order of specific customers from the search bar
    if (isset($_GET['block']) and isset($_GET['lot']) and isset($_GET['phase'])) {
        $block = $_GET['block'];
        $lot = $_GET['lot'];
        $phase = $_GET['phase'];

        $total_amount = compute_total($block,$lot,$phase);
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
        <!-- display total amount of orders of specific customer -->
        <div class="total_amount_section" id="total_amount_section">
            <h3 class="total_label" id="total_label">Total Amount of Orders</h3>
            <h3 class="total_amount" id="total_amount"><?php echo $total_amount; ?></h3>
        </div>
    </body>
    </html>