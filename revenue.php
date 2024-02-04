<?php
    include("connection.php");
    include("queries.php");
    include("alerts.php");
    
// handling dateForm submission and processing orders

    if (isset($_REQUEST['weekly_tab'])) {
        // Display Weekly Revenue
        $start_date = date('Y-m-d', strtotime('last Monday'));
        $end_date = date('Y-m-d', strtotime('this Sunday'));
        $weekly_revenue = get_weekly_revenue($start_date, $end_date);
    } elseif (isset($_REQUEST['monthly_tab'])) {
        // Display Monthly Revenue
        $month = date('m');
        $year = date('Y');
        $monthly_revenue = get_monthly_revenue($month, $year);
    }

?>