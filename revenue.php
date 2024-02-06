<?php
    include("connection.php");
    include("queries.php");
    include("alerts.php");
    
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
    <link rel="stylesheet" href="revenue.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        td, table {
            width: 50%;
            border-collapse: collapse;
            border: 2px solid black;
        }
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vh-100">
                <?php include('navbar.html'); ?>
            </div>
        
        <div class="col-10">
            <h1 id="revenue_page_label" class = "text-primary">Revenue</h1>
    
    <div class="row mt-2">
    <!-- Tabs for Weekly and Monthly Revenue -->
    <ul>
        <li><a href="?weekly">Weekly Revenue</a></li>
        <li><a href="?monthly">Monthly Revenue</a></li>
    </ul>
    </div>

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
            </div>
        </div>
    </div>
</body>
</html>
