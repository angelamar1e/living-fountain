<?php
    include("connection.php");
    include("queries.php");
    include("alerts.php");
    include('navbar.html');
    
// retrieve weekly and monthly revenue
$weekly_revenue = get_weekly_revenue();
$monthly_revenue = get_monthly_revenue();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue</title>
    <script src="helper_functions.js"></script>
    <style>
        td, table {
            width: 10%;
            border-collapse: collapse;
            border: 1px solid black;
        }
        td {
            padding: 5%;
        }
    </style>
</head>
<body>
    <h1 id="revenue_page_label">Revenue</h1>
    <!-- Tabs for Weekly and Monthly Revenue -->
    <ul>
        <li><a href="?weekly">Weekly Revenue</a></li>
        <li><a href="?monthly">Monthly Revenue</a></li>
    </ul>

    <!-- Display Weekly Revenue -->
    <?php 
    if (isset($_GET['weekly'])){ 
        if (mysqli_num_rows($weekly_revenue) > 0) {
            while ($record = mysqli_fetch_assoc($weekly_revenue)) { 
                $start_date = $record['start_date'];
                $end_date = $record['end_date']; ?>
                <!-- displaying each week -->
                <h3 id="date_display" class="date_display"><?php echo $start_date ." to ". $end_date; ?></h3>
                <table id="weekly_revenue_table">
                    <tr>
                        <td>Revenue </td>
                        <td>₱<?php echo $record['weekly_revenue']; ?></td>
                    </tr>
                </table>
        <?php
            }
        }
        else { ?>
            <h3>No records found. </h3>
        <?php 
        }
    } ?>

    <!-- Display Monthly Revenue -->
    <?php 
    if (isset($_GET['monthly'])){ 
        if (mysqli_num_rows($monthly_revenue) > 0) {
            while ($record = mysqli_fetch_assoc($monthly_revenue)) { 
                $month = $record['month'];
                $year = $record['year']; ?>
                <!-- displaying each month -->
                <h3 id="month_display" class="month_display"><?php echo $month ." ". $year; ?></h3>
                <table id="monthly_revenue_table">
                    <tr>
                        <td>Revenue </td>
                        <td>₱<?php echo $record['monthly_revenue']; ?></td>
                    </tr>
                </table>
        <?php
            }
        }
        else { ?>
            <h3>No records found. </h3>
        <?php 
        }
    } ?>

</body>
</html>
