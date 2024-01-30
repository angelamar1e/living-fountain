<?php

include('connection.php');

function select($cols, $table){
    global $conn;
    $select = "SELECT ";
    $col_count = 0;
    // fetching column names from array passed
    foreach ($cols as $col) {
        $col_count += 1;
        if ($col_count > 1){
            $select .= ", ";
        }
        $select .= $col;
    }
    $query = "$select
    FROM $table
    ORDER BY $cols[0]";
    $result = mysqli_query($conn, $query);
    return $result;
}

function select_where($cols, $table, $condition){
    global $conn;
    $select = "SELECT ";
    $col_count = 0;
    // fetching column names from array passed
    foreach ($cols as $col) {
        $col_count += 1;
        if ($col_count > 1){
            $select .= ", ";
        }
        $select .= $col;
    }
    $query = "$select
    FROM $table
    WHERE $condition";
    $result = mysqli_query($conn, $query);
    return $result;
}

function select_distinct($col, $table){
    global $conn;
    $query = "SELECT DISTINCT $col
    FROM $table
    ORDER BY $col ASC";
    $result = mysqli_query($conn, $query);
    return $result;
}

function is_existing($blk, $lot, $ph){
    global $conn;
    $query = "SELECT COUNT(*) as 'count'
    FROM customers
    WHERE block = $blk AND lot = $lot AND phase = $ph";
    $result = mysqli_query($conn, $query);
    $count = mysqli_fetch_array($result,MYSQLI_ASSOC);
    return $count['count'];
}

function add_new_customer($blk, $lot, $ph){
    global $conn;
    $query = "INSERT INTO customers (block, lot, phase) VALUES ($blk, $lot, $ph)";
    $result = mysqli_query($conn, $query);
    return $result;
}

function add_order($blk, $lot, $ph, $type, $qty, $deliverer){
    global $conn;
    $date = date("Y-m-d");
    $query = "INSERT INTO orders (block, lot, phase, date, product_code, quantity, deliverer_id) 
    VALUES ($blk, $lot, $ph, '$date','$type', $qty, $deliverer)";
    $result = mysqli_query($conn, $query);
    compute_price();
    return $result;
}

function compute_price(){
    global $conn;
    $query = "UPDATE orders o
    JOIN products p ON o.product_code = p.code
    SET o.price = quantity * p.price";
    $result = mysqli_query($conn, $query);
    return $result;
}

?>