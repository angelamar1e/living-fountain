<?php

include('connection.php');
include('queries.php');

$deliverers = get_employee_info("D");
$washers = get_employee_info("W");
$refillers = get_employee_info("R");
<<<<<<< HEAD
$date = date("Y-m-d");
=======

$date = date("M-d-Y");
>>>>>>> 7a55874cb2d8cd1e11995c7ba49b380d46493f43

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
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 vh-100">
                <?php include('navbar.html'); ?>
            </div>
            <div class="col-10 vh-100">
                <div class="row mt-3">
                    <div class="m-1 col-6 d-flex align-items-end">
                        <h1 class="display-1 m-0" id="sales_page_label">Salary</h1>
                    </div>
                    <!-- displaying current date -->
                    <div class="col d-flex justify-content-center align-items-end">
                        <h3 class="display-6 m-0">Date: <span class="h2"><?php echo $date; ?></span></h2>
                    </div>
                </div>
            
                <div class="row m-2 p-3 border rounded border-dark">
                    <div class="col">
                        <!-- label for employee type Deliverer -->
                        <div class="row">
                            <h2 id="deliverer_type" class="emp_type">Deliverers</h2>
                        </div>
                        <!-- table to display salary information for deliverers -->
                        <div class="row">
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
                                        <div class="row d-flex justify-content-center">
                                            <h3 id="emp_name" class="emp_name w-50 text-center"><?php echo $deliverer['employee_name']; ?></h3>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <table class="w-75 text-center emp_salary">
                                                <tr class="border bordered">
                                                    <td class="p-1">Qty. Delivered</td>
                                                    <td class="p-1"><?php echo $qty_delivered?></td>
                                                </tr>
                                                <tr class="border bordered">
                                                    <td class="p-1">Salary</td>
                                                    <td class="p-1">₱<?php echo $salary ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                <?php }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <!-- label for employee type Refiller -->
                            <div class="row">
                                <h2 id="deliverer_type" class="emp_type">Refillers</h2>
                            </div>
                            <!-- table to display salary information for refillers -->
                            <div class="row">
                                <?php
                                    if (mysqli_num_rows($refillers) > 0) {
                                        while($refiller = mysqli_fetch_assoc($refillers)) {
                                ?>
                                            <div class="row d-flex justify-content-center">
                                                <h3 id="emp_name" class="emp_name w-50 text-center"><?php echo $refiller['employee_name']; ?></h3>
                                            </div>
                                            <div class="row d-flex justify-content-center">
                                                <table class="w-75 text-center emp_salary">
                                                    <tr class="border bordered">
                                                        <td class="p-1">Salary</td>
                                                        <td class="p-1">₱<?php echo $others_salary ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                    <?php }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <!-- label for employee type Washers -->
                            <div class="row mt-5">
                                <h2 id="deliverer_type" class="emp_type">Washers</h2>
                            </div>
                            <!-- table to display salary information for washers -->
                            <div class="row">
                                <?php
                                    if (mysqli_num_rows($washers) > 0) {
                                        while($washer = mysqli_fetch_assoc($washers)) {
                                ?>
                                            <div class="row d-flex justify-content-center">
                                                <h3 id="emp_name" class="emp_name w-50 text-center"><?php echo $washer['employee_name']; ?></h3>
                                            </div>
                                            <div class="row d-flex justify-content-center">
                                                <table class="w-75 text-center emp_salary">
                                                    <tr class="border bordered">
                                                        <td class="p-1">Salary</td>
                                                        <td class="p-1">₱<?php echo $others_salary ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                    <?php }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>