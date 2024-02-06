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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
        font-family: 'CustomFont';
        src: url('fonts/FontsFree-Net-SFProText-Medium-1.ttf');
        }

        /* Define font stack */
        .custom-font {
        font-family: 'CustomFont', Arial, sans-serif; /* Use the custom font with fallbacks */
        }

        div a {
            font-size: larger;
            text-decoration: none;
            color: aliceblue;
        }

        div .tab:hover {
            background-color: #ffffffa4;
            font-size: x-large;
            div a {
                color:rgb(32, 175, 241);
            }
        }

    </style>
</head>
<body class="custom-font">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vh-100"><?php include('navbar.html'); ?></div>
            <div class="col-10 vh-100">
                <div class="row mt-3">
                    <h1 class="display-4" id="revenue_page_label">Revenue</h1>
                </div>
                <!-- Tabs for Weekly and Monthly Revenue -->
                <div class="row d-flex justify-content-center ">
                        <div style="background-color:rgb(32, 175, 241);" class="col-4 m-2 text-center d-flex justify-content-center align-items-center border rounded tab">
                            <a href="?weekly">Weekly Revenue</a>
                        </div>
                        <div style="background-color:rgb(32, 175, 241);" class="col-4 m-2 text-center d-flex justify-content-center align-items-center border rounded tab">
                            <a href="?monthly">Monthly Revenue</a>
                        </div>
                </div>
                <!-- Display Weekly Revenue -->
                <?php
                if (isset($_GET['weekly'])){ ?>
                    <div class="row mt-2 text-center">
                        <h2>Weekly Revenue</h2>
                    </div>
                    <div style="max-height:60vh;" class="row p-1 d-flex flex-row overflow-scroll justify-content-center">
                        <?php
                        if (mysqli_num_rows($weekly_revenue) > 0) {
                            while ($record = mysqli_fetch_assoc($weekly_revenue)) {
                                $start_date = $record['start_date'];
                                $start_date = date_format(date_create($start_date),"M d Y");
                                $end_date = $record['end_date'];
                                $end_date = date_format(date_create($end_date),"M d Y"); ?>
                                <!-- displaying each week -->
                                <div class="row w-75 border m-2 rounded border-dark text-center justify-content-center over">
                                    <h5 id="date_display" class="row m-0 w-50 p-2 align-items-center date_display"><?php echo $start_date ." to ". $end_date; ?></h3>
                                    <div class="col-3 d-flex align-items-center">
                                        <table id="weekly_revenue_table">
                                            <tr>
                                                <td><h3 class="m-0">₱<?php echo $record['weekly_revenue']; ?></h3></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        else { ?>
                            <h3>No records found. </h3>
                        <?php
                        } ?>
                    </div>
            <?php }?>
                <!-- Display Monthly Revenue -->
                <?php
                if (isset($_GET['monthly'])){ ?>
                    <div class="row mt-2 text-center">
                        <h2>Monthly Revenue</h2>
                    </div>
                <div style="max-height:60vh;" class="row p-1 d-flex flex-row overflow-scroll justify-content-center">
                    <?php
                        if (mysqli_num_rows($monthly_revenue) > 0) {
                            while ($record = mysqli_fetch_assoc($monthly_revenue)) {
                                $month = $record['month'];
                                $year = $record['year']; ?>
                                <!-- displaying each month -->
                                <div class="row w-75 border m-2 rounded border-dark text-center justify-content-center">
                                    <h3 id="month_display" class="row m-0 w-50 p-2 align-items-center justify-content-center month_display"><?php echo $month ." ". $year; ?></h3>
                                    <div class="col-3 d-flex align-items-center">
                                        <table id="monthly_revenue_table">
                                            <tr>
                                                <td><h3 class="m-0">₱<?php echo $record['monthly_revenue']; ?></h3></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
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
    </div>
</body>
</html>