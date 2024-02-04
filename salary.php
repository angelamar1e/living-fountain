<?php

include('connection.php');
include('queries.php');

$deliverers = get_employee_info("D");
$washer = get_employee_info("W");
$refiller = get_employee_info("R");

$date = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary</title>
</head>
<body>
    <h1>Date: <?php echo $date; ?></h1>
    <h2 id="deliverer_type" class="emp_type">Deliverers</h2>
    <?php 
        if (mysqli_num_rows($deliverers) > 0) {
            while($deliverer = mysqli_fetch_assoc($deliverers)) { 
                $id = $deliverer['id']; 
                $qty_delivered = get_qty_delivered($id, $date); ?>
                <h3 id="emp_name" class="emp_name"><?php echo $deliverer['employee_name']; ?></h3>
                <table class="emp_salary">
                    <tr>
                        <td>Qty. Delivered</td>
                        <td><?php echo $qty_delivered?></td>
                    </tr>   
                    <tr>
                        <td>Salary</td>
                        <td></td>
                    </tr>
                </table>
        <?php }
        }

        if (mysqli_num_rows($deliverers) > 0) {
            while($deliverer = mysqli_fetch_assoc($deliverers)) { ?>
                <h2 id="emp_name" class="emp_name"><?php echo $deliverer['employee_name']; ?></h2>
                <table class="emp_salary">
                    <tr>
                        <td>Qty. Delivered</td>
                        <td></td>
                    </tr>   
                    <tr>
                        <td>Salary</td>
                        <td></td>
                    </tr>
                </table>
        <?php }
        }
    ?>
</body>
</html>