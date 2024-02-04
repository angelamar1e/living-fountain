<?php

include('connection.php');
include('queries.php');

$deliverers = get_employee_info("D");
$washers = get_employee_info("W");
$refillers = get_employee_info("R");

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
    <!-- displaying current date -->
    <h1>Date: <?php echo $date; ?></h1>
    
    <!-- label for employee type Deliverer -->
    <h2 id="deliverer_type" class="emp_type">Deliverers</h2>
    
    <!-- table to display salary information for deliverers -->
    <?php 
        if (mysqli_num_rows($deliverers) > 0) {
            while($deliverer = mysqli_fetch_assoc($deliverers)) { 
                // retrieving qty delivered per deliverer id
                $id = $deliverer['id']; 
                $qty_delivered = get_qty_delivered($id, $date);             
    ?>
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
    ?>

    <!-- label for employee type Refiller -->
    <h2 id="deliverer_type" class="emp_type">Refillers</h2>

    <!-- table to display salary information for refillers -->
    <?php 
        if (mysqli_num_rows($refillers) > 0) {
            while($refiller = mysqli_fetch_assoc($refillers)) {          
    ?>
                <h3 id="emp_name" class="emp_name"><?php echo $refiller['employee_name']; ?></h3>
                <table class="emp_salary">
                    <tr>
                        <td>Salary</td>
                        <td></td>
                    </tr>
                </table>
        <?php }
        }
    ?>

        <!-- label for employee type Washers -->
        <h2 id="deliverer_type" class="emp_type">Washers</h2>

        <!-- table to display salary information for washers -->
        <?php 
            if (mysqli_num_rows($washers) > 0) {
                while($washer = mysqli_fetch_assoc($washers)) {          
        ?>
                    <h3 id="emp_name" class="emp_name"><?php echo $washer['employee_name']; ?></h3>
                    <table class="emp_salary">
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