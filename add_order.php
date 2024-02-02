<?php
    include('connection.php');
    include('queries.php');
    include("alerts.php");

    // receives data from order_form 
    $blk = trim($_REQUEST['blk']);
    $lot = trim($_REQUEST['lot']);
    $ph = trim($_REQUEST['ph']);
    $type = trim($_REQUEST['prod_type']);
    $qty = trim($_REQUEST['qty']);
    $deliverer = trim($_REQUEST['deliverer']);

    // checks if customer is existing
    $existing_cust = is_existing($blk, $lot, $ph);

    // if the customer is new, address is added to customers table first, then their order is recorded
    // (because of foreign key constraint)
    if ($existing_cust == 0){
        if(add_new_customer($blk, $lot, $ph) and add_order($blk, $lot, $ph, $type, $qty, $deliverer)){
            alert_redirect("New customer and transaction recorded successfully.","sales.php");
        }
        else{
            alert_redirect("Error: '. mysqli_error($conn) . '","sales.php");
        };
    }
    else{
        if(add_order($blk, $lot, $ph, $type, $qty, $deliverer)){
            alert_redirect("Transaction recorded successfully.","sales.php");
        }
        else{
            alert_redirect("Error: '. mysqli_error($conn) . '","sales.php");
        };
    }
?>