<?php
require '../db/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['load_current_reading'])) {

    header('Content-Type: application/json');

    $sql = "SELECT 
                reading_date,
                date_covered_from,
                date_covered_to,
                date_due,
                date_disconnection
            FROM billing_schedule_settings
            WHERE deleted = 0
              AND set_active = 1
            LIMIT 1";

    $result = $con->query($sql);

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'success' => true,
            'data' => [
                'reading_date'       => date('F j, Y', strtotime($row['reading_date'])),
                'date_covered_from'  => date('F j, Y', strtotime($row['date_covered_from'])),
                'date_covered_to'    => date('F j, Y', strtotime($row['date_covered_to'])),
                'date_due'           => date('F j, Y', strtotime($row['date_due'])),
                'date_disconnection' => date('F j, Y', strtotime($row['date_disconnection']))
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No active billing schedule found'
        ]);
    }

    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="index"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <div class="">
            <?php include './include/sidebar.php'; ?>
        </div>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './include/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-tachometer-alt mr-2"></i>Dashboard</h1>
                    </div> -->

                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="font-weight-bold text-primary text-uppercase mb-1">
                                                Hello, <span class=""><?= $_SESSION['fullname']; ?>!</span></div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">Welcome to e-Billing System.</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-house-flood-water text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-12 d-flex mb-3 mb-sm-3 mt-0 ">
						    <div class="card flex-fill border-left-primary">
						        <div class="card-body">
                                    <div id="billing_schedule_id" class="font-weight-bold text-primary mb-1">
                                        Current Billing Cycle
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm">
                                            <p class="card-text text-dark m-0">Reading Date:</p>
                                            <span class="text-primary font-weight-bold" id="readingDate">—</span>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <p class="card-text text-dark m-0">Covered From:</p>
                                            <span class="text-primary font-weight-bold" id="coveredFrom">—</span>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <p class="card-text text-dark m-0">Covered To:</p>
                                            <span class="text-primary font-weight-bold" id="coveredTo">—</span>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <p class="card-text text-dark m-0">Due Date:</p>
                                            <span class="text-primary font-weight-bold" id="dueDate">—</span>
                                        </div>

                                        <div class="col-12 col-sm">
                                            <p class="card-text text-dark m-0">Disconnection Date:</p>
                                            <span class="text-primary font-weight-bold" id="disconnectionDate">—</span>
                                        </div>
                                    </div>

                                </div>

						    </div>
						</div>	
                    </div>
                    <div class="row">
                        
                        <?php
                            require '../db/dbconn.php';

                            $sql = "
                                    SELECT * 
                                    FROM concessionaires
                                    WHERE deleted = 0
                                ";

                            $result = mysqli_query($con, $sql);
                            $total_concessionaire = mysqli_num_rows($result);
                        ?>
                        
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Concessionaires</div>
                                            <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $total_concessionaire ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-users text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php

                            require '../db/dbconn.php';

                            $sql = "
                                    SELECT * 
                                    FROM meters
                                    WHERE deleted = 0
                                ";

                            $result = mysqli_query($con, $sql);
                            $total_account = mysqli_num_rows($result);
                        ?>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Accounts</div>
                                            <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $total_account ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-gauge text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            require '../db/dbconn.php';

                            // Fetch the active billing schedule details
                            $sql = "
                                SELECT reading_date, date_due 
                                FROM billing_schedule_settings
                                WHERE set_active = 1 AND deleted = 0
                                LIMIT 1
                            ";

                            $result = mysqli_query($con, $sql);
                            $active_due_date = null;
                            $reading_month_year = null;
                            $days_remaining = null;

                            if ($row = mysqli_fetch_assoc($result)) {
                                $active_due_date = $row['date_due'];
                                $reading_date = $row['reading_date'];

                                // Get the month and year from the reading date
                                $reading_month_year = $reading_date ? date('F Y', strtotime($reading_date)) : null;

                                // Calculate days remaining
                                $current_date = new DateTime();
                                $due_date = new DateTime($active_due_date);
                                $interval = $current_date->diff($due_date);
                                $days_remaining = $interval->days;

                                // Check if the due date is in the future or past
                                if ($due_date < $current_date) {
                                    $days_remaining = null; // Due date is past
                                }
                            }
                            ?>

                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Active Billing Schedule
                                                </div>
                                                <div class="m-0">
                                                    <p class="h6 mb-0 font-weight-bold text-gray-800">
                                                        <?= $reading_month_year ? "Billing Schedule: $reading_month_year" : 'No Reading Date Available' ?>
                                                    </p>
                                                </div>
                                                <div class="mb-0">
                                                    <p class="h6 mb-0 font-weight-bold text-gray-800">
                                                        <?= $active_due_date ? "Due Date: " . date('F d, Y', strtotime($active_due_date)) : 'No Active Due Date' ?>
                                                    </p>
                                                </div>
                                                <?php if ($days_remaining !== null): ?>
                                                    <div class="text-sm font-weight-light text-gray-700">
                                                        <small class="m-0 font-italic">
                                                            <?= $days_remaining ?> day<?= $days_remaining > 1 ? 's' : '' ?> remaining
                                                        </small>
                                                    </div>
                                                <?php elseif ($active_due_date): ?>
                                                    <div class="text-sm font-weight-light text-danger">
                                                        <small class="m-0 font-italic">
                                                            Due date has passed
                                                        </small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa-solid fa-calendar-check text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- account status indicator -->
                            <?php 
                                include "include/accountStatus.php";
                            ?>

                        
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include './include/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
   
    <a class="scroll-to-top rounded-circle bg-primary" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include './include/logout_modal.php'; ?>

    <?php include './include/script.php'; ?>
    
    <script>
$(document).ready(function () {

    console.log('jQuery loaded ');

    // 🔥 AUTO LOAD ON PAGE READY
    loadCurrentReading();

    function loadCurrentReading() {

        $.ajax({
            url: window.location.href, // same PHP file
            type: 'POST',
            dataType: 'json',
            data: { load_current_reading: 1 }, // flag only

            beforeSend: function () {
                console.log('Loading current reading...');
            },

            success: function (response) {
                console.log('AJAX response:', response);

                if (response.success === true) {
                    $('#readingDate').text(response.data.reading_date);
                    $('#coveredFrom').text(response.data.date_covered_from);
                    $('#coveredTo').text(response.data.date_covered_to);
                    $('#dueDate').text(response.data.date_due);
                    $('#disconnectionDate').text(response.data.date_disconnection);
                } else {
                    clearCurrentReading();
                    console.warn(response.message);
                }
            },

            error: function (xhr) {
                console.error('AJAX ERROR:', xhr.responseText);
                clearCurrentReading();
            }
        });
    }

    function clearCurrentReading() {
        $('#readingDate, #coveredFrom, #coveredTo, #dueDate, #disconnectionDate')
            .text('—');
    }

});
</script>



    </body>

</html>