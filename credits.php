<?php
    include ("connection.php");
    include("queries.php");
    include("alerts");

    //marking deliveries as paid or delivered
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['mark_paid'])) {
            $order_id = $POST['order_id'];
            mark_paid($order_id);
            refresh();
    } else if (isset($_POST['mark_delivered'])) {
        $order_id = $POST['order_id'];
        mark_paid($order_id);
        refresh();
    }
}

// fetch credit records for displayed date
if (isset($_REQUEST['date'])) {
    $date = $_REQUEST['date'];
    $credit_records = get_unpaid_records($date);
} else {
    $date = date('Y-m-d');
    $credit_records = get_unpaid_records($date);
}

?>
