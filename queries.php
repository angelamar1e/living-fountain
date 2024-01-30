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

?>