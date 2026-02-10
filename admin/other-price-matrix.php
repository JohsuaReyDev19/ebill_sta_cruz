<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="meter-brand-settings"></div>

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
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-chart-area fa-sm mr-2"></i>Other Rates</h1>
                    </div>

                    <hr> -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">List of Rate</h6>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                        <div class="col-12 col-md-4 float-right mx-0 px-0">
                                            <a data-toggle="modal" data-target="#addNew" class="btn btn-success shadow-sm w-100 h-100"><i class="fa-solid fa-plus mr-1"></i>Add Rate</a>
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
                                                    <th scope="col">Description</th>                                        
                                                    <th scope="col">Rates</th>                                               
                                                    <th scope="col">Action</th>                             
                                                </tr>
                                            </thead>
                                            
                                            <tbody style="color: black; font-size: 13px;">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                         <?php include 'modal/rate_add_edit_modal.php'; ?>

                         <!-- Edit Rate Modal -->

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
document.addEventListener("DOMContentLoaded", function () {

    const checkboxes = document.querySelectorAll('.charge-checkbox');
    const totalDisplay = document.getElementById('totalCharge');

    function calculateTotal() {
        let total = 0;

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                let value = parseFloat(checkbox.value);

                // If discount (0.20), subtract 20%
                if (checkbox.id === "pwd" || checkbox.id === "senior") {
                    total -= total * value;
                } else {
                    total += value;
                }
            }
        });

        totalDisplay.innerText = total.toFixed(2);
    }

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', calculateTotal);
    });

});
</script>


    <script>
    $(document).ready(function(){

        $('#myTable').DataTable({
            scrollX: true,
            ajax: {
                url: 'action/fetch_rates.php',
                type: 'GET'
            }
        });

    });
    </script>

    <!-- Add Meter Brand -->
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

            $('#addRate').on('click', function(e) {
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
                    // If department doesn't exist, proceed with form submission
                    $.ajax({
                        url: 'action/add_rate.php', // URL to submit the form data
                        type: 'POST',
                        data: formData.serialize(), // Serialize form data
                        success: function(response) {
                            // Handle the success response
                            console.log(response); // Output response to console (for debugging)
                            if (response === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Rate added successfully!',
                                    showConfirmButton: true, // Show OK button
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            }else if(response === 'exists'){
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Duplicate Entry',
                                    text: 'Rate Type already exists!',
                                    confirmButtonText: 'OK'
                                });
                            }else if(response === 'empty'){
                                showWarningMessage('All fields are required.');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to add  Rate!',
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
                            console.error(xhr.responseText); // Output error response to console (for debugging)
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to add rate',
                                text: 'Please try again later.',
                                showConfirmButton: true, // Show OK button
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

    <!-- update scipt -->
     <script>
        $(document).ready(function () {

            // UPDATE RATE
            $(document).on('click', '.update-rate-btn', function (e) {
                e.preventDefault();

                var form = $(this).closest('form');

                $.ajax({
                    url: 'action/update_rate.php',
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {

                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }

                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong.'
                        });
                    }
                });
            });

        });
        </script>


<!-- abot delete script -->
 <script>
$(document).ready(function () {

    $(document).on('click', '.delete-rate-btn', function (e) {
        e.preventDefault();

        var id = $(this).data('id');
        var description = $(this).data('description');

        Swal.fire({
            title: 'Delete Rate?',
            html: "You are about to delete:<br><strong>" + description + "</strong>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: 'action/delete_rate.php',
                    type: 'POST',
                    data: { id: id },
                    success: function (response) {

                        if (response.trim() === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Rate has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'Delete failed.', 'error');
                        }

                    }
                });

            }
        });

    });

});
</script>

<!-- for edit modal -->
<script>
$(document).ready(function(){

    // OPEN EDIT MODAL
    $(document).on('click', '.edit-rate-btn', function(){

        var id = $(this).data('id');
        var description = $(this).data('description');
        var rate = $(this).data('rate');

        $('#edit_id').val(id);
        $('#edit_description').val(description);
        $('#edit_rate').val(rate);

        $('#editRateModal').modal('show');
    });

});
</script>


<!-- funciton script for update -->
<script>
    $('.btn-secondary').click(function () {
        $('#editRateModal').modal('hide');
    });
$(document).ready(function(){

    $('#updateRateBtn').on('click', function(){

        $.ajax({
            url: 'action/update_rate.php',
            type: 'POST',
            data: $('#editRateForm').serialize(),
            dataType: 'json',
            success: function(response){

                if(response.status === 'success'){
                    Swal.fire('Updated!', response.message, 'success')
                    .then(() => {
                        $('#editRateModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload(null, false);
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }

            }
        });

    });

});
</script>


</body>

</html>