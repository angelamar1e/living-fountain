<?php

include('connection.php');
include('queries.php');

$deliverers = get_employee_info("D");
$washers = get_employee_info("W");
$refillers = get_employee_info("R");

$date = date("Y-m-d");

// sum up the qty ordered for the current day
$qty_count = sum_qty($date);

// to change salary according to qty sold
if ($qty_count > 50 and $qty_count < 100){
    $deliverer_base_salary = 350;
}
else if ($qty_count > 100){
    $deliverer_base_salary = 450;
    $others_salary = 500;
}
else{
    $deliverer_base_salary = 250;
    $others_salary = 350;
}

// additional amount for deliverers per reg gallon delivered
$additional_amount = get_additional();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="salary.css">
</head>
<style>
    .emp_type {
            font-size: 20px; /* Adjust the font size for employee types */
            padding: 5px; /* Add padding for employee types */
            margin-bottom: 5px; /* Adjust the margin between employee types */
        }

        .emp_info {
            margin-bottom: 10px; /* Adjust the margin between employee information */
        }

        td, table {
            width: 50%;
            border-collapse: collapse;
            border: 2px solid black;
        }

        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
</style>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vh-100">
                <?php include('navbar.html'); ?>
            </div>

        
        <div class="col-10">
            <h1>Salary</h1>
        
   

    <div class="row mb-3">
        <div class="col-6 text-left">
            <!-- Displaying current date -->
            <h2>Date: <?php echo $date; ?></h2>
            <div class="row">
                <div class="col-6 d-flex align-items-baseline">
                    <form id="dateForm" method="get" action="salary.php">
                        <!-- Your form content goes here -->
                    </form>
                </div>
            </div>
        </div>   

    

    <!-- Label for employee type Deliverer -->
    <h2 id="deliverer_type" class="emp_type">Deliverers</h2>
    
    <div class="row border rounded border-dark">
    <!-- table to display salary information for deliverers -->
    <?php 
        if (mysqli_num_rows($deliverers) > 0) {
            while($deliverer = mysqli_fetch_assoc($deliverers)) { 
                // retrieving qty delivered per deliverer id
                $id = $deliverer['id']; 
                $qty_delivered = count_qty_delivered($id, $date);
                // count reg gallon delivered per deliverer id to add to salary
                $reg_gallon_delivered = count_reg_gallon($id, $date);
                $salary = $deliverer_base_salary + ($reg_gallon_delivered * $additional_amount);
    ?>
            
                <h3 id="emp_name" class="emp_name"><?php echo $deliverer['employee_name']; ?></h3>



                <!-- table to display salary information for deliverers -->
                <table class="emp_salary">
                    <tr>
                        <td>Qty. Delivered</td>
                        <td><?php echo $qty_delivered?></td>
                    </tr>   
                    <tr>
                        <td>Salary</td>
                        <td><?php echo $salary ?></td>
                    </tr>
                </table>
            </div>
        <?php }
        }
    ?>
</div>


    <!-- label for employee type Refiller -->
    <h2 id="deliverer_type" class="emp_type">Refillers</h2>

    <div class="row border rounded border-dark mb-3">
    <!-- table to display salary information for refillers -->
    <?php 
        if (mysqli_num_rows($refillers) > 0) {
            while($refiller = mysqli_fetch_assoc($refillers)) {          
    ?>
                <h3 id="emp_name" class="emp_name"><?php echo $refiller['employee_name']; ?></h3>
                <table class="emp_salary">
                    <tr>
                        <td>Salary</td>
                        <td><?php echo $others_salary ?></td>
                    </tr>
                </table>
</div>
        <?php }
        }
    ?>

        <!-- label for employee type Washers -->
        <h2 id="deliverer_type" class="emp_type">Washers</h2>

        <div class="row border rounded border-dark mb-3">
        <!-- table to display salary information for washers -->
        <?php 
            if (mysqli_num_rows($washers) > 0) {
                while($washer = mysqli_fetch_assoc($washers)) {          
        ?>
                    <h3 id="emp_name" class="emp_name"><?php echo $washer['employee_name']; ?></h3>
                    <table class="emp_salary">
                        <tr>
                            <td>Salary</td>
                            <td><?php echo $others_salary ?></td>
                        </tr>
                    </table>
    </div>
</div>
        </div>
        </div>
            <?php }
            }
        ?>
</body>
</html>