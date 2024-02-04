<?php
include('connection.php');
include('queries.php');

// Handle customer search logic
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve values from the URL
    $blk = isset($_GET['blk']) ? trim($_GET['blk']) : "";
    $lot = isset($_GET['lot']) ? trim($_GET['lot']) : "";
    $ph = isset($_GET['ph']) ? trim($_GET['ph']) : "";

    // Use the variables $blk, $lot, $ph to perform the search
    $search_results = searchCustomers($blk, $lot, $ph);
}

// Retrieve customer details from the URL or form submission
$block = isset($_REQUEST['block']) ? trim($_REQUEST['block']) : '';
$lot = isset($_REQUEST['lot']) ? trim($_REQUEST['lot']) : '';
$phase = isset($_REQUEST['phase']) ? trim($_REQUEST['phase']) : '';

// Fetch all transactions related to the customer
$customer_transactions = get_customer_transactions($block, $lot, $phase);
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
            width: 100%;
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
    <?php
    if (isset($search_results)) {
        // Display search results here
        foreach ($search_results as $result) {
            // Display each result
            echo "<p>Block: {$result['block']}, Lot: {$result['lot']}, Phase: {$result['phase']}</p>";
        }
    }
    ?>

    <h2>Customer Transactions</h2>

    <h3>Customer Details</h3>
    <p>Block: <?php echo $block; ?>, Lot: <?php echo $lot; ?>, Phase: <?php echo $phase; ?></p>

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
