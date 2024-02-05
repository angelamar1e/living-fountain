<?php
include('connection.php');
include('queries.php');

// handle customer logic
    $conditions = [];
    // Check each value and add conditions if they are not empty
    if (!empty($_REQUEST['blk'])) {
        $blk = $_REQUEST['blk'];
        $conditions[] = "block = " . $blk . " ";
    }
    if (!empty($_REQUEST['lot'])) {
        $lot = $_REQUEST['lot'];
        $conditions[] = "lot = " . $lot . " ";
    }
    if (!empty($_REQUEST['ph'])) {
        $ph = $_REQUEST['ph'];
        $conditions[] = "phase = " . $ph . "";
    }

    $search_results = search_customers($conditions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Transactions</title>
    <style>
        /* Add your CSS styles here */
        table {
            border-collapse: collapse;
            width: 50%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <!-- Search bar for customer details -->
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="blk">Block</label>
        <input type="text" id="blk" name="blk">
        
        <label for="lot">Lot</label>
        <input type="text" id="lot" name="lot">
        
        <label for="ph">Phase</label>
        <input type="text" id="ph" name="ph">

        <input type="submit" value="Search">
    </form>

    <!-- Display search results -->
    <table>
    <tr>
        <th>Block</th>
        <th>Lot</th>
        <th>Phase</th>
    </tr>
    <?php
        if (mysqli_num_rows($search_results) > 0) {
            while($record = mysqli_fetch_assoc($search_results)) { ?>
                <tr>
                    <td><?php echo $record['block']; ?> </td>
                    <td><?php echo $record['lot']; ?> </td>
                    <td><?php echo $record['phase']; ?> </td>
                </tr>
            <?php
            }
        } ?>
    </table>


    <h2>Customer Transactions</h2>

    <h3>Customer Details</h3>
    <p>Block: <?php echo $blk; ?>, Lot: <?php echo $lot; ?>, Phase: <?php echo $ph; ?></p>

    <h3>Transactions</h3>
    <?php if (!$customer_transactions) {
        echo '<p>Error fetching transactions: ' . mysqli_error($conn) . '</p>';
    } elseif (mysqli_num_rows($customer_transactions) > 0) { ?>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Deliverer</th>
                <th>Status</th>
            </tr>
            <?php while ($transaction = mysqli_fetch_assoc($customer_transactions)) { ?>
                <tr>
                    <td><?php echo $transaction['id']; ?></td>
                    <td><?php echo $transaction['product']; ?></td>
                    <td><?php echo $transaction['quantity']; ?></td>
                    <td><?php echo $transaction['price']; ?></td>
                    <td><?php echo $transaction['deliverer']; ?></td>
                    <td><?php echo $transaction['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No transactions found for this customer.</p>
    <?php } ?>
</body>
</html>
