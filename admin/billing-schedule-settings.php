<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="billing-schedule-settings"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include './include/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './include/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-calendar-check fa-sm mr-2"></i>Billing Schedule Settings</h1>
                    </div>

                    <hr>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">List of Billing Schedule</h6>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                        <div class="col-12 col-md-4 float-right mx-0 px-0">
                                            <a data-toggle="modal" data-target="#addNew" class="btn btn-success shadow-sm w-100 h-100"><i class="fa-solid fa-plus mr-1"></i>Add Billing Schedule</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered nowrap" id="myTable" width="100%" cellspacing="0">
                                            <thead class="">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Billing Schedule</th>
                                                    <th scope="col">Reading Date</th>
                                                    <th scope="col">Date Covered (From - To)</th>
                                                    <th scope="col">Date Due</th>
                                                    <th scope="col">Date Disconnection</th>
                                                    <th scope="col">Active</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require '../db/dbconn.php';

                                                // Fetch billing schedules from the database
                                                $query = "
                                                    SELECT 
                                                        billing_schedule_id, 
                                                        reading_date, 
                                                        date_covered_from, 
                                                        date_covered_to, 
                                                        date_due, 
                                                        date_disconnection, 
                                                        set_active 
                                                    FROM billing_schedule_settings 
                                                    WHERE deleted = 0
                                                    ORDER BY reading_date DESC
                                                ";
                                                $result = mysqli_query($con, $query) or die(mysqli_error($con));

                                                $counter = 1;

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $billing_schedule_id = $row['billing_schedule_id'];
                                                    $reading_date = $row['reading_date'];
                                                    $date_covered_from = $row['date_covered_from'];
                                                    $date_covered_to = $row['date_covered_to'];
                                                    $date_due = $row['date_due'];
                                                    $date_disconnection = $row['date_disconnection'];
                                                    $set_active = $row['set_active'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo htmlspecialchars(date('F Y', strtotime($date_due))); ?></td>
                                                    <td><?php echo htmlspecialchars(date('F d, Y', strtotime($reading_date))); ?></td>
                                                    <td>
                                                        <?php echo htmlspecialchars(date('F d, Y', strtotime($date_covered_from))); ?> - 
                                                        <?php echo htmlspecialchars(date('F d, Y', strtotime($date_covered_to))); ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars(date('F d, Y', strtotime($date_due))); ?></td>
                                                    <td><?php echo htmlspecialchars(date('F d, Y', strtotime($date_disconnection))); ?></td>
                                                    <td class="text-center">
                                                        <?php if ($set_active == 1): ?>
                                                            <span class="badge badge-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_<?php echo $billing_schedule_id; ?>">
                                                            <i class="fa-solid fa-edit"></i>
                                                        </a>
                                                        <?php if ($set_active == 1) { ?>
                                                            <a 
                                                                href="#" 
                                                                class="btn btn-sm btn-secondary disabled" 
                                                                data-schedule-id="<?php echo $billing_schedule_id; ?>" 
                                                                data-schedule-due="<?php echo htmlspecialchars(date('F Y', strtotime($date_due))); ?>" 
                                                                data-schedule-from="<?php echo htmlspecialchars(date('F Y', strtotime($date_covered_from))); ?>" 
                                                                data-schedule-to="<?php echo htmlspecialchars(date('F Y', strtotime($date_covered_to))); ?>" 
                                                                data-schedule-disconnection="<?php echo htmlspecialchars(date('F Y', strtotime($date_disconnection))); ?>">
                                                                <i class="fa-solid fa-check"></i> Set Active
                                                            </a>
                                                            <a 
                                                                href="#" 
                                                                class="btn btn-sm btn-danger disabled" 
                                                                data-schedule-id="<?php echo $billing_schedule_id; ?>" 
                                                                data-schedule-due="<?php echo htmlspecialchars(date('F Y', strtotime($date_due))); ?>" 
                                                                data-schedule-from="<?php echo htmlspecialchars(date('F Y', strtotime($date_covered_from))); ?>" 
                                                                data-schedule-to="<?php echo htmlspecialchars(date('F Y', strtotime($date_covered_to))); ?>" 
                                                                data-schedule-disconnection="<?php echo htmlspecialchars(date('F Y', strtotime($date_disconnection))); ?>">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a>
                                                        <?php }else{ ?>
                                                            <a 
                                                                href="#" 
                                                                class="btn btn-sm btn-success set-active-btn" 
                                                                data-schedule-id="<?php echo $billing_schedule_id; ?>" 
                                                                data-schedule-due="<?php echo htmlspecialchars(date('F Y', strtotime($date_due))); ?>" 
                                                                data-schedule-from="<?php echo htmlspecialchars(date('F Y', strtotime($date_covered_from))); ?>" 
                                                                data-schedule-to="<?php echo htmlspecialchars(date('F Y', strtotime($date_covered_to))); ?>" 
                                                                data-schedule-disconnection="<?php echo htmlspecialchars(date('F Y', strtotime($date_disconnection))); ?>">
                                                                <i class="fa-solid fa-check"></i> Set Active
                                                            </a>
                                                            <a 
                                                                href="#" 
                                                                class="btn btn-sm btn-danger delete-billing-btn" 
                                                                data-schedule-id="<?php echo $billing_schedule_id; ?>" 
                                                                data-schedule-reading="<?php echo htmlspecialchars(date('F Y', strtotime($reading_date))); ?>" 
                                                                data-schedule-due="<?php echo htmlspecialchars(date('F Y', strtotime($date_due))); ?>" 
                                                                data-schedule-from="<?php echo htmlspecialchars(date('F Y', strtotime($date_covered_from))); ?>" 
                                                                data-schedule-to="<?php echo htmlspecialchars(date('F Y', strtotime($date_covered_to))); ?>" 
                                                                data-schedule-disconnection="<?php echo htmlspecialchars(date('F Y', strtotime($date_disconnection))); ?>">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $counter++;
                                                    include('modal/billingschedule_edit_modal.php');
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php include('modal/billingschedule_add_modal.php'); ?>
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
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include './include/logout_modal.php'; ?>

    <?php include './include/script.php'; ?>

    <script>
        $(document).ready(function(){
            //inialize datatable
            $('#myTable').DataTable({
                scrollX: true
            })
        });
    </script>

    <!-- Add Billiing Schedule -->
    <script>
        $(document).ready(function() {
            // Function to show SweetAlert2 warning message
            const showWarningMessage = (message) => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: message
                });
            };

            $('#addBillingSchedule').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                var formData = $('#addNew form'); // Select the form element

                const requiredFields = formData.find('[required], select');
                let fieldsAreValid = false; // Initialize as false

                // Remove existing error classes
                $('.form-control').removeClass('is-invalid');

                requiredFields.each(function() {
                    // Check if the element is a select and it doesn't have a selected value
                    if ($(this).is('select') && $(this).val() === null) {
                        fieldsAreValid = false; // Set to false if any required select field doesn't have a value
                        showWarningMessage('Please fill-up the required fields.');
                        $(this).addClass('is-invalid'); // Add red border to missing field
                    }
                    // Check if the element is empty
                    else if ($(this).val().trim() === '') {
                        fieldsAreValid = false; // Set to false if any required field is empty
                        showWarningMessage('Please fill-up the required fields.');
                        $(this).addClass('is-invalid'); // Add red border to missing field
                    } else {
                        fieldsAreValid = true;
                        $(this).removeClass('is-invalid'); // Remove red border if field is filled
                    }
                });

                if (fieldsAreValid) {
                    $.ajax({
                        url: 'action/add_billing_schedule.php',
                        type: 'POST',
                        data: formData.serialize(),
                        success: function(response) {
                            if (response === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Billing Schedule added successfully!',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to add Billing Schedule!',
                                    text: 'Please try again later.',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to add Billing Schedule',
                                text: 'Please try again later.',
                                showConfirmButton: true,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    </script>

    <!-- Set Active -->
    <script>
        $(document).ready(function () {
            // Handle Set Active button click
            $('.set-active-btn').on('click', function (e) {
                e.preventDefault();

                var deleteButton = $(this);

                // Get data from button
                var scheduleID = deleteButton.data('schedule-id');
                var scheduleDue = deleteButton.data('schedule-due');
                var scheduleFrom = deleteButton.data('schedule-from');
                var scheduleTo = deleteButton.data('schedule-to');
                var scheduleDisconnection = deleteButton.data('schedule-disconnection');

                // Confirm activation using SweetAlert2
                Swal.fire({
                    title: 'Set Active Billing Schedule',
                    html: `You are about to activate the following billing schedule:<br><br>
                           <strong>Date Due:</strong> ${scheduleDue}<br>
                           <strong>Date Covered:</strong> ${scheduleFrom} - ${scheduleTo}<br>
                           <strong>Disconnection Date:</strong> ${scheduleDisconnection}<br><br>
                           This will deactivate any other active schedules.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, activate!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'action/set_active_schedule.php',
                            type: 'POST',
                            data: {
                                schedule_id: scheduleID
                            },
                            success: function (response) {
                                if (response.trim() === 'success') {
                                    Swal.fire(
                                        'Activated!',
                                        'The schedule has been set as active.',
                                        'success'
                                    ).then(() => {
                                        location.reload(); // Reload the page to update the button states
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to set the schedule as active.',
                                        'error'
                                    );
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while setting the schedule as active.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

    <!-- Edit Billing Schedule -->
    <script>
        $(document).ready(function() {
            // Function to show SweetAlert2 messages
            const showSweetAlert = (icon, title, message) => {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: message
                });
            };

            // Delegate click event handling to a parent element
            $(document).on('click', '[id^="updateBillingSchedule_"]', function(e) {
                e.preventDefault(); // Prevent default form submission
                var userID = $(this).attr('id').split('_')[1]; // Extract event ID
                var formData = $('#updateForm_' + userID); // Get the form data
                var modalDiv = $('#edit_' + userID);

                let fieldsAreValid = true; // Initialize as true
                // const requiredFields = formData.find('[required]'); // Select required fields
                const requiredFields = modalDiv.find(':input[required]'); // Select required fields

                // Remove existing error classes
                $('.form-control').removeClass('is-invalid');

                requiredFields.each(function() {
                    // Check if the element is a select and it doesn't have a selected value
                    if ($(this).is('select') && $(this).val() === null) {
                        fieldsAreValid = false; // Set to false if any required select field doesn't have a value
                        showSweetAlert('warning', 'Oops!', 'Please fill-up the required fields.');
                        $(this).addClass('is-invalid'); // Add red border to missing field
                    }
                    // Check if the element is empty
                    else if ($(this).val().trim() === '') {
                        fieldsAreValid = false; // Set to false if any required field is empty or null
                        showSweetAlert('warning', 'Oops!', 'Please fill-up the required fields.');
                        $(this).addClass('is-invalid'); // Add red border to missing field
                    } else {
                        $(this).removeClass('is-invalid'); // Remove red border if field is filled
                    }
                });
                
                if (fieldsAreValid) {
                    $.ajax({
                        url: 'action/update_billing_schedule.php', // URL to submit the form data
                        type: 'POST',
                        data: formData.serialize(), // Form data to be submitted
                        dataType: 'json',
                        success: function(response) {
                            // Handle the success response
                            console.log(response); // Output response to console (for debugging)
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Success!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            console.error(xhr.responseText); // Output error response to console (for debugging)
                            showSweetAlert('error', 'Error', 'Failed to update Billing Schedule. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>

    <!-- Delete Billing Schedule -->
    <script>
        $(document).ready(function() {
            // Function for deleting event
            $('.delete-billing-btn').on('click', function(e) {
                e.preventDefault();

                var deleteButton = $(this);
                // Get data from button
                var scheduleID = deleteButton.data('schedule-id');
                var scheduleReading = deleteButton.data('schedule-reading');
                var scheduleDue = deleteButton.data('schedule-due');
                var scheduleFrom = deleteButton.data('schedule-from');
                var scheduleTo = deleteButton.data('schedule-to');
                var scheduleDisconnection = deleteButton.data('schedule-disconnection');

                Swal.fire({
                    title: 'Delete Billing Schedule',
                    html: "You are about to delete the following billing schedule:<br><br>" +
                          "<strong>Reading Date:</strong> " + scheduleReading + "<br>" +
                          "<strong>Date Covered:</strong> From " + scheduleFrom + "- To " + scheduleTo + "<br>" +
                          "<strong>Due Date:</strong> " + scheduleDue + "<br>" +
                          "<strong>Disconnection Date:</strong> " + scheduleDisconnection + "<br>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'action/delete_billing_schedule.php',
                            type: 'POST',
                            data: {
                                billing_schedule_id: scheduleID
                            },
                            success: function(response) {
                                if (response.trim() === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        'Billing schedule has been deleted.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete billing schedule.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete billing schedule.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>