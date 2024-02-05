<?php
    include("connection.php");
    include("queries.php");
    include("alerts.php");
    
// Fetch the result from the mysqli_result object for weekly revenue
$total_weekly_revenue = 0;
if (isset($weekly_revenue)) {
    $weekly_row = mysqli_fetch_assoc($weekly_revenue);
    $total_weekly_revenue = $weekly_row ? $weekly_row['weekly_revenue'] : 0;
}

// Fetch the result from the mysqli_result object for monthly revenue
$monthly_rows = array();
if (isset($monthly_revenue)) {
    while ($row = mysqli_fetch_assoc($monthly_revenue)) {
        $monthly_rows[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Page</title>
    <script src="helper_functions.js"></script>
</head>
<body>

    <!-- Tabs for Weekly and Monthly Revenue -->
    <ul>
        <li><a href="?weekly_tab">Weekly Revenue</a></li>
        <li><a href="?monthly_tab">Monthly Revenue</a></li>
    </ul>

       <!-- Display Weekly Revenue -->
       <?php if (isset($weekly_revenue)): ?>
        <div id="weekly_revenue">
            <h2>Weekly Revenue</h2>
            <p>Total Weekly Revenue: $<?php echo $total_weekly_revenue; ?></p>
            <!-- Weekly revenue report content -->
        </div>
    <?php endif; ?>

    <!-- Display Monthly Revenue -->
    <?php if (isset($monthly_revenue)): ?>
        <div id="monthly_revenue">
        <h2>Monthly Revenue</h2>
            <table border="1">
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Total Monthly Revenue</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($monthly_revenue)): ?>
                    <tr>
                        <td><?php echo $row['year']; ?></td>
                        <td><?php echo $row['month']; ?></td>
                        <td>$<?php echo $row['monthly_revenue']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <!-- Monthly revenue report content -->
        </div>
    <?php endif; ?>
    
    <script src="helper_functions.js"></script>

</body>
</html>
