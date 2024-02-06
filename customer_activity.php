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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Block <?php echo $block," Lot ", $lot," Phase ", $phase ?></title>
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
                <div class="col-2 vh-100"><?php include('navbar.html'); ?></div>
                <div class="col-10 vh-100 mt-5 d-flex flex-column align-items-center">
                    <?php
                    if (mysqli_num_rows($orders) > 0) { ?>
                        <div class="row w-75">
                            <div class="col">
                                <h2 class="display-5" id="order_history_label">Order History</h2>
                            </div>
                            <div class="col d-flex justify-content-center">
                                <div class="col d-flex justify-content-center align-items-end">
                                    <h5 class="h-50 address_label">Block <span class="addr_label"><?php echo $block ?></span></h4>
                                </div>
                                <div class="col d-flex justify-content-center align-items-end">
                                    <h5 class="h-50 address_label">Lot <?php echo $lot ?></h4>
                                </div>
                                <div class="col d-flex justify-content-center align-items-end">
                                    <h5 class="h-50 address_label">Phase <?php echo $phase ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row p-3 w-75 border rounded border-dark">
                            <table class="table m-0 table-bordered text-center">
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
                        </div>
                            <!-- display total amount of orders of specific customer -->
                            <div class="row m-3 w-75" id="total_amount_section">
                                <div class="col text-right">
                                    <h4 class="total_label" id="total_label">Total Amount of Orders: </h3>
                                </div>
                                <div class="col-6">
                                    <h4 class="total_amount" id="total_amount">₱<?php echo $total_amount; ?></h3>
                                </div>
                            </div>
                     <?php }
                    else { ?>
                        <div class="row w-75">
                            <div class="col">
                                <h2 id="order_history_label">Order History</h2>
                            </div>
                            <div class="col d-flex justify-content-center">
                                <div class="col d-flex justify-content-center align-items-center">
                                    <h5 class="h-50 address_label">Block <span class="addr_label"><?php echo $block ?></span></h4>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center">
                                    <h5 class="h-50 address_label">Lot <?php echo $lot ?></h4>
                                </div>
                                <div class="col d-flex justify-content-center align-items-center">
                                    <h5 class="h-50 address_label">Phase <?php echo $phase ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center p-3 w-75 border rounded border-dark">
                            <h5>No transactions were recorded for this customer. </h5>
                        </div>
                        <?php }   ?>
                </div>
            </div>
        </div>
    </body>
    </html>