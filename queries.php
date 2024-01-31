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
    FROM $table";
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
    FROM $table";
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

function all_orders($date){
    global $conn;
    $query = "SELECT o.id, block, lot, phase, product_desc as 'product', quantity, o.price, employee_name as 'deliverer', s.code as 'code', s.status_desc as 'status'
                FROM orders o
                LEFT JOIN products p ON o.product_code = p.code
                LEFT JOIN employees e ON o.deliverer_id = e.id
                LEFT JOIN order_status s ON o.status = s.code
                WHERE date = '$date'";
    $result = mysqli_query($conn, $query);
    return $result;
}

function update_status($code, $id){
    global $conn;
    $query = "UPDATE orders
            SET status = '$code'
            WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return $result;
}

?>