<?php
    include('connection.php');
    include('queries.php');

    $blk = trim($_REQUEST['blk']);
    $lot = trim($_REQUEST['lot']);
    $ph = trim($_REQUEST['ph']);
    $type = trim($_REQUEST['prod_type']);
    $qty = trim($_REQUEST['qty']);
    $deliverer = trim($_REQUEST['deliverer']);

    $existing_cust = is_existing($blk, $lot, $ph);

    if ($existing_cust == 0){
        add_new_customer($blk, $lot, $ph);
        add_order($blk, $lot, $ph, $type, $qty, $deliverer);
    }
    else{
        add_order($blk, $lot, $ph, $type, $qty, $deliverer);
    }
?>