<?php
    include('connection.php');
    include('queries.php');

    $blk = trim($_REQUEST['blk']);
    $lot = trim($_REQUEST['lot']);
    $ph = trim($_REQUEST['ph']);

    $existing_cust = is_existing($blk, $lot, $ph);

    if ($existing_cust = 0){
        add_new_customer($blk, $lot, $ph);
    }
?>