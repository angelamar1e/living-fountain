<?php

include('connection.php');

// forms simple select query (SELECT cols FROM table)
function select($cols, $table){
    global $conn;
    $select = "SELECT ";
    $select .= count($cols) > 1 ? implode(", ",$cols) : implode($cols);
    $query = "$select
    FROM $table";
    $result = mysqli_query($conn, $query);
    return $result;
}

// forms select query with where clause (SELECT cols FROM table WHERE condition)
function select_where($cols, $table, $condition){
    global $conn;
    $select = "SELECT ";
    $select .= count($cols) > 1 ? implode(", ",$cols) : implode($cols);
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

include('connection.php');

// Function to search for customers based on block, lot, and phase
function searchCustomers($blk, $lot, $ph) {
    global $conn;

    // Validate input values
    $blk = mysqli_real_escape_string($conn, $blk);
    $lot = mysqli_real_escape_string($conn, $lot);
    $ph = mysqli_real_escape_string($conn, $ph);
}

// Function to get all transactions for a specific customer based on block, lot, and phase
function getCustomerTransactions($block, $lot, $phase) {
    global $conn;

    // Validate input values
    $block = mysqli_real_escape_string($conn, $block);
    $lot = mysqli_real_escape_string($conn, $lot);
    $phase = mysqli_real_escape_string($conn, $phase);

    // Perform the transactions query using JOIN
    $query = "SELECT orders.*, 
                     products.product_desc,
                     employees.employee_name as deliverer,
                     order_status.code as status
              FROM orders
              LEFT JOIN products ON orders.product_code = products.code
              LEFT JOIN employees ON orders.deliverer_id = employees.id
              LEFT JOIN order_status ON orders.status = order_status.code
              WHERE orders.block = '$block' AND orders.lot = '$lot' AND orders.phase = '$phase'";
}
// gets employee information
function get_employee_info($code){
    global $conn;
    $query = "SELECT e.id, employee_name, emp_type_desc as 'employee_type'
            FROM employees e
            JOIN employee_types et ON e.emp_type_code = et.code
            WHERE emp_type_code = '$code'";
    $result = mysqli_query($conn, $query);
    return $result;
}


// to sum up the qty ordered for the current day 
function sum_qty($date){
    global $conn;
    $query = "SELECT SUM(quantity) as 'qty'
            FROM orders
            WHERE date = '$date'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while($qty = mysqli_fetch_assoc($result)) {
            $qty_sum = $qty['qty'];
        }
    } 
    return $qty_sum;
}

// to count qty delivered by each deliverer 
function count_qty_delivered($id, $date){
    global $conn;
    $query = "SELECT COUNT(*) as 'qty'
            FROM orders
            WHERE deliverer_id = '$id' AND date = '$date'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while($qty = mysqli_fetch_assoc($result)) {
            $qty_delivered = $qty['qty'];
        }
    } 
    return $qty_delivered;
}

// to count regular gallons delivered by each deliverer
function count_reg_gallon($id, $date){
    global $conn;
    $query = "SELECT SUM(quantity) as 'qty'
            FROM orders
            WHERE deliverer_id = '$id' AND date = '$date' AND product_code = 'R'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while($qty = mysqli_fetch_assoc($result)) {
            $qty_delivered = $qty['qty'];
        }
    } 
    return $qty_delivered;
}

// get the amount additional for every reg gallon delivered
function get_additional(){
    global $conn;
    $query = "SELECT amount
            FROM salary_types
            WHERE id = 4";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while($additional = mysqli_fetch_assoc($result)) {
            $amount = $additional['amount'];
        }
    } 
    return $amount;
}

// get the total amount of orders from a given customer
function compute_total($block, $lot, $phase){
    global $conn;
    $query = "SELECT SUM(price) as 'amount'
            FROM orders
            WHERE block = $block AND lot = $lot AND phase = $phase";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while($total = mysqli_fetch_assoc($result)) {
            $amount = $total['amount'];
        }
    } 
    return $amount;
}

// to search for customers based on block, lot, or phase
function search_customers($conditions) {
    global $conn;
    $query = "SELECT * FROM customers WHERE ";
    $query .= count($conditions) > 1 ? implode("AND ", $conditions) : implode($conditions);
    $result = mysqli_query($conn, $query);
    return $result;
}

// to retrieve orders of a particular customer
function customer_orders($block, $lot, $phase){
    global $conn;
    $query = "SELECT date, product_desc as 'product', quantity, o.price, employee_name as 'deliverer', s.status_desc as 'status'
                FROM orders o
                LEFT JOIN products p ON o.product_code = p.code
                LEFT JOIN employees e ON o.deliverer_id = e.id
                LEFT JOIN order_status s ON o.status = s.code
                WHERE block = $block AND lot = $lot AND phase = $phase";
    $result = mysqli_query($conn, $query);
    return $result;
}

// function to get unpaid records
function get_unpaid_records($date) {
    global $conn;
    $query = "SELECT o.id, block, lot, phase, product_desc as 'product', quantity, o.price, employee_name as 'deliverer', s.code as 'code', s.status_desc as 'status'
                FROM orders o
                LEFT JOIN products p ON o.product_code = p.code
                LEFT JOIN employees e ON o.deliverer_id = e.id
                LEFT JOIN order_status s ON o.status = s.code
                WHERE date = '$date' AND o.status = 'D'";
    $result = mysqli_query($conn, $query);
    return $result;
}

// function to get weekly revenue
function get_weekly_revenue() {
    global $conn;
    $query = "SELECT YEAR(date) AS year, MIN(date) AS start_date, MAX(date) AS end_date,  SUM(price) AS weekly_revenue
    FROM orders
    GROUP BY YEAR(date), WEEK(date)
    ORDER BY YEAR(date), WEEK(date);";
    
    $result = mysqli_query($conn, $query);
    return $result;
}

// function to get monthly revenue
function get_monthly_revenue() {
    global $conn;
    $query = "SELECT MONTHNAME(date) as 'month', YEAR(date) as 'year', SUM(price) as 'monthly_revenue'
    FROM orders
    GROUP BY MONTH(date), YEAR(date)";
    $result = mysqli_query($conn, $query);
    return $result;
}

?>
