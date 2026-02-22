<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="classification-settings"></div>

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
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-i-cursor fa-sm mr-2"></i>Classification Settings</h1>
                    </div>

                    <hr> -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">List of Classification</h6>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                        <div class="d-flex col-12 col-md-9 float-right mx-0 px-0">
                                            <a href="manage-price-metrix.php?title=Manage Price Matrix" class="btn btn-secondary shadow-sm w-50 h-100 mr-2">
                                               < Back
                                            </a>
                                            <a data-toggle="modal" data-target="#addNew" class="btn btn-success shadow-sm w-100 h-100"><i class="fa-solid fa-plus mr-1"></i>Add Classification</a>
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
                                                    <th scope="col">Classification</th>                                        
                                                    <th scope="col">Classification Remarks</th>                                               
                                                    <th scope="col">Action</th>                             
                                                   
                                                </tr>
                                            </thead>
                                            
                                            <tbody>

                                            <?php
                                                require '../db/dbconn.php';

                                                $display_classification = "SELECT * FROM classification_settings WHERE deleted = 0";
                                                $sqlQuery = mysqli_query($con, $display_classification) or die(mysqli_error($con));

                                                $counter = 1;

                                                while($row = mysqli_fetch_array($sqlQuery)) {
                                                    // Fetch all fields into variables
                                                    $classification_id = $row['classification_id'];
                                                    $classification = $row['classification'];
                                                    $classification_remarks = $row['classification_remarks'];
                                                    
                                            ?>

                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo htmlspecialchars($classification); ?></td>
                                                    <td><?php echo htmlspecialchars($classification_remarks); ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_<?php echo $classification_id; ?>"><i class="fa-solid fa-edit"></i></a>
                                                        <a href="#" class="btn btn-sm btn-danger delete-classification-btn"
                                                           data-classification-id="<?php echo $classification_id; ?>"
                                                           data-classification-name="<?php echo htmlspecialchars($classification); ?>"
                                                           data-classification-remarks="<?php echo htmlspecialchars($classification_remarks); ?>">
                                                           <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $counter++;
                                                   include('modal/classification_edit_modal.php');
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include('modal/classification_add_modal.php'); ?>
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

    <!-- Add Classification Status-->
    <script>
$(document).ready(function () {

    const showWarningMessage = (message) => {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: message
        });
    };

    $('#addClassification').on('click', function (e) {
        e.preventDefault();

        const form = $('#addNew form');
        const requiredFields = form.find('[required]');
        let fieldsAreValid = true;

        // Clear validation styles
        $('.form-control').removeClass('is-invalid');

        // ✅ REQUIRED FIELD VALIDATION
        requiredFields.each(function () {
            if ($(this).val().trim() === '') {
                fieldsAreValid = false;
                $(this).addClass('is-invalid');
            }
        });

        if (!fieldsAreValid) {
            showWarningMessage('Please fill-up the required fields.');
            return;
        }

        // 🚀 AJAX SUBMISSION
        $.ajax({
            url: 'action/add_classification.php',
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
                console.log(response);

                if (response === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Classification added successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => location.reload());

                } else if (response === 'exists') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'Classification already exists!',
                        confirmButtonText: 'OK'
                    });

                } else if (response === 'empty') {
                    showWarningMessage('All fields are required.');

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to add Classification',
                        text: 'Please try again later.',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

});
</script>


    <!-- Delete Classification Status -->
    <script>
        $(document).ready(function() {
            // Function for deleting event
            $('.delete-classification-btn').on('click', function(e) {
                e.preventDefault();

                var deleteButton = $(this);
                var classificationID = deleteButton.data('classification-id');
                var classificationName = decodeURIComponent(deleteButton.data('classification-name'));
                var classificationRemarks = decodeURIComponent(deleteButton.data('classification-remarks'));

                Swal.fire({
                    title: 'Delete Classification',
                    html: "You are about to delete the following classification:<br><br>" +
                          "<strong>Classification:</strong> " + classificationName + "<br>" +
                          "<strong>Classification Remarks:</strong> " + classificationRemarks + "<br>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'action/delete_classification.php',
                            type: 'POST',
                            data: {
                                classification_id: classificationID
                            },
                            success: function(response) {
                                if (response.trim() === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        'Classification has been deleted.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete classification.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete classification.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

    <!-- Edit Classification Status -->
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
            $(document).on('click', '[id^="updateClassification_"]', function(e) {
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
                        url: 'action/update_classification.php', // URL to submit the form data
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
                            showSweetAlert('error', 'Error', 'Failed to update user. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>