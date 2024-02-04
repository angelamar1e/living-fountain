<?php

include('connection.php');

// forms simple select query (SELECT cols FROM table)
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

// forms select query with where clause (SELECT cols FROM table WHERE condition)
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

// select unique records using 1 col
function select_distinct($col, $table){
    global $conn;
    $query = "SELECT DISTINCT $col
    FROM $table";
    $result = mysqli_query($conn, $query);
    return $result;
}

// finds out if a record exists in the customer table, by counting matching records 
function is_existing($blk, $lot, $ph){
    global $conn;
    $query = "SELECT COUNT(*) as 'count'
    FROM customers
    WHERE block = $blk AND lot = $lot AND phase = $ph";
    $result = mysqli_query($conn, $query);
    $count = mysqli_fetch_array($result,MYSQLI_ASSOC);
    return $count['count'];
}

// query to add new customer
function add_new_customer($blk, $lot, $ph){
    global $conn;
    $query = "INSERT INTO customers (block, lot, phase) VALUES ($blk, $lot, $ph)";
    $result = mysqli_query($conn, $query);
    return $result;
}

// query to add new order
function add_order($blk, $lot, $ph, $type, $qty, $deliverer){
    global $conn;
    $date = date("Y-m-d");
    $query = "INSERT INTO orders (block, lot, phase, date, product_code, quantity, deliverer_id) 
    VALUES ($blk, $lot, $ph, '$date','$type', $qty, $deliverer)";
    $result = mysqli_query($conn, $query);
    compute_price(); 
    return $result;
}

// query to compute price, and update records with price not set (used everytime an order is added or updated)
function compute_price(){
    global $conn;
    $query = "UPDATE orders o
    JOIN products p ON o.product_code = p.code
    SET o.price = quantity * p.price";
    $result = mysqli_query($conn, $query);
    return $result;
}

// query to retrieve orders on a particular date
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

// updates status of an order
function update_status($code, $id){
    global $conn;
    $query = "UPDATE orders
            SET status = '$code'
            WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return $result;
}

// retrieves a specific order (used to display initial values of order to be updated)
function get_order($id){
    global $conn;
    $query = "SELECT block, lot, phase, p.code as 'prod_code', product_desc as 'product', quantity, o.price, deliverer_id, employee_name as 'deliverer', s.code as 'code', s.status_desc as 'status'
                FROM orders o
                LEFT JOIN products p ON o.product_code = p.code
                LEFT JOIN employees e ON o.deliverer_id = e.id
                LEFT JOIN order_status s ON o.status = s.code
                WHERE o.id = $id";
    $result = mysqli_query($conn, $query);
    return $result;
}

// updates the order
function update_order($id, $blk, $lot, $ph, $type, $qty, $deliverer){
    global $conn;
    $query = "UPDATE orders
            SET block = $blk, lot = $lot, phase = $ph, product_code = '$type', quantity = $qty, deliverer_id = $deliverer
            WHERE id = $id";
    $result = mysqli_query($conn, $query);
    compute_price();
    return $result;
}

// deletes order
function delete_order($id){
    global $conn;
    $query = "DELETE FROM orders
            WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return $result;
}

// function to get unpaid records
function get_unpaid_records($date) {
    global $conn;
    $query = "SELECT * FROM orders WHERE date = '$date' AND status = 'D'";
    $result = mysqli_query($conn, $query);
    return $result;
}

// function to get weekly revenue
function get_weekly_revenue($start_date, $end_date) {
    global $conn;
    $query = "SELECT SUM(price) as weekly_revenue FROM orders WHERE date BETWEEN '$start_date' AND '$end_date' AND status = 'PD'";
    $result = mysqli_query($conn, $query);
    return $result;
}

// function to get monthly revenue
function get_monthly_revenue($month, $year) {
    global $conn;
    $query = "SELECT SUM(price) as monthly_revenue FROM orders WHERE MONTH(date) = $month AND YEAR(date) = $year AND payment = 'PD'";
    $result = mysqli_query($conn, $query);
    return $result;
}

?>