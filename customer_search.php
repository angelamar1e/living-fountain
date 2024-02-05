<?php
include('connection.php');
include('queries.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Transactions</title>
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
</body>
</html>

<?php
    // handle customer search logic
    $conditions = [];
    // Check each value and add conditions if they are not empty
    if (isset($_REQUEST['blk']) or isset($_REQUEST['blk']) or isset($_REQUEST['blk'])){
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

        // query to search matching records
        $search_results = search_customers($conditions);

        // displaying matching records
        if (mysqli_num_rows($search_results) > 0) { ?>
            <table>
                <tr>
                    <th>Block</th>
                    <th>Lot</th>
                    <th>Phase</th>
                </tr>
                <?php
                while($record = mysqli_fetch_assoc($search_results)) { ?>
                    <tr>
                        <td><?php echo $record['block']; ?> </td>
                        <td><?php echo $record['lot']; ?> </td>
                        <td><?php echo $record['phase']; ?> </td>
                    </tr>
                <?php
                }
        }
        else { ?>
        <h4>No customers found. </h4>
    <?php }   
    } ?>
            </table>
