<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="price-matrix-settings"></div>

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
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-tags fa-sm mr-2"></i>Price Matrix</h1>
                    </div>

                    <hr>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">List of Price Matrix</h6>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                        <div class="col-12 col-md-4 float-right mx-0 px-0">
                                            <a data-toggle="modal" data-target="#addNew" class="btn btn-success shadow-sm w-100 h-100"><i class="fa-solid fa-plus mr-1"></i>Add Price Matrix</a>
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
                                                    <th scope="col">Meter Size</th>
                                                    <th scope="col">Minimum Price (1 - 10 cubic meters)</th>
                                                    <th scope="col">Action</th>                             
                                                   
                                                </tr>
                                            </thead>
                                            
                                            <tbody>

                                            <?php
                                                require '../db/dbconn.php';

                                                $display_price_matrix = "  
                                                                            SELECT pm.*, cs.classification, mss.meter_size
                                                                            FROM price_matrix pm
                                                                            INNER JOIN classification_settings cs ON pm.classification_id = cs.classification_id
                                                                            INNER JOIN meter_size_settings mss ON pm.meter_size_id = mss.meter_size_id
                                                                            WHERE pm.deleted = 0
                                                                        ";
                                                $sqlQuery = mysqli_query($con, $display_price_matrix) or die(mysqli_error($con));

                                                $counter = 1;

                                                while($row = mysqli_fetch_array($sqlQuery)) {
                                                    // Fetch all fields into variables
                                                    $price_matrix_id = $row['price_matrix_id'];
                                                    $classification_id_selected = $row['classification_id'];
                                                    $classification = $row['classification'];
                                                    $meter_size_id_selected = $row['meter_size_id'];
                                                    $meter_size = $row['meter_size'];
                                                    $price_per_cubic_meter = $row['price_per_cubic_meter'];
                                                    
                                            ?>

                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo htmlspecialchars($classification); ?></td>
                                                    <td><?php echo htmlspecialchars($meter_size); ?></td>
                                                    <td><?php echo htmlspecialchars($price_per_cubic_meter); ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_<?php echo $price_matrix_id; ?>"><i class="fa-solid fa-edit"></i></a>
                                                        <a href="#" class="btn btn-sm btn-danger delete-price-matrix-btn"
                                                           data-price-matrix-id="<?php echo $price_matrix_id; ?>"
                                                           data-price-matrix-classification="<?php echo htmlspecialchars($classification); ?>"
                                                           data-price-matrix-meter-size="<?php echo htmlspecialchars($meter_size); ?>">
                                                           <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $counter++;
                                                    include('modal/price_matrix_edit_modal.php');
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include('modal/price_matrix_add_modal.php'); ?>
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

    <!-- Add Price Matrix -->
    <script>
        $('#addPriceMatrix').on('click', function(e) {
            e.preventDefault();

            var formData = $('#addNew form');
            const classificationId = $('#classification_id').val();
            const meterSizeId = $('#meter_size_id').val();
            const pricePerCubic = parseFloat($('#price_per_cubic_meter').val());

            const requiredFields = formData.find('[required], select');
            let fieldsAreValid = true;

            // Reset validation styles
            $('.form-control').removeClass('is-invalid');

            requiredFields.each(function () {
                if ($(this).val() === null || $(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    fieldsAreValid = false;
                }
            });

            // Check for invalid or zero/negative price
            if (isNaN(pricePerCubic) || pricePerCubic <= 0) {
                $('#price_per_cubic_meter').addClass('is-invalid');
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Price',
                    text: 'Minimum price must be greater than 0.'
                });
                return;
            }

            if (!fieldsAreValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please fill-up the required fields.'
                });
                return;
            }

            // Check for existing price matrix
            $.ajax({
                url: 'action/check_price_matrix.php',
                type: 'POST',
                data: {
                    classification_id: classificationId,
                    meter_size_id: meterSizeId
                },
                success: function(response) {
                    if (response === 'exists') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Duplicate Entry',
                            text: 'This price matrix already exists.'
                        });
                    } else if (response === 'not_exists') {
                        // Submit form via AJAX
                        $.ajax({
                            url: 'action/add_price_matrix.php',
                            type: 'POST',
                            data: formData.serialize(),
                            success: function(response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Price Matrix added successfully!',
                                        confirmButtonText: 'OK'
                                    }).then(() => location.reload());
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed to add Price Matrix!',
                                        text: 'Please try again later.'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An unexpected error occurred.'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Unexpected response. Please try again.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to check existing price matrix.'
                    });
                }
            });
        });
    </script>

    <!-- Edit Price Matrix -->
    <script>
        $(document).ready(function () {
            const showSweetAlert = (icon, title, message) => {
                Swal.fire({ icon, title, text: message });
            };

            $(document).on('click', '[id^="updatePriceMatrix_"]', function (e) {
                e.preventDefault();

                const idParts = $(this).attr('id').split('_');
                const priceMatrixId = idParts[1];
                const formData = $(`#updateForm_${priceMatrixId}`);
                const modalDiv = $(`#edit_${priceMatrixId}`);

                let fieldsAreValid = true;
                const requiredFields = modalDiv.find(':input[required]');

                $('.form-control').removeClass('is-invalid');

                requiredFields.each(function () {
                    if (
                        ($(this).is('select') && $(this).val() === null) ||
                        ($(this).is('input') && $(this).val().trim() === '')
                    ) {
                        $(this).addClass('is-invalid');
                        fieldsAreValid = false;
                    }
                });

                const classificationId = $(`#classification_id_${priceMatrixId}`).val();
                const meterSizeId = $(`#meter_size_id_${priceMatrixId}`).val();
                const minPrice = parseFloat($(`#price_per_cubic_meter_${priceMatrixId}`).val());

                // Check if price is valid
                if (minPrice <= 0 || isNaN(minPrice)) {
                    $(`#price_per_cubic_meter_${priceMatrixId}`).addClass('is-invalid');
                    showSweetAlert('warning', 'Invalid Price', 'Minimum price must be greater than 0.');
                    return;
                }

                if (!fieldsAreValid) {
                    showSweetAlert('warning', 'Oops!', 'Please fill-up the required fields.');
                    return;
                }

                // Check for duplicate matrix (excluding current record)
                $.ajax({
                    url: 'action/check_price_matrix_existence.php',
                    type: 'POST',
                    data: {
                        classification_id: classificationId,
                        meter_size_id: meterSizeId,
                        exclude_id: priceMatrixId
                    },
                    success: function (response) {
                        if (response === 'exists') {
                            showSweetAlert('warning', 'Duplicate Entry', 'This price matrix already exists.');
                            $('.form-control').addClass('is-invalid');
                        } else if (response === 'not_exists') {
                            // Submit update
                            $.ajax({
                                url: 'action/update_price_matrix.php',
                                type: 'POST',
                                data: formData.serialize(),
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire('Success!', response.message, 'success').then(() => location.reload());
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    showSweetAlert('error', 'Error', 'Failed to update price matrix. Please try again.');
                                }
                            });
                        } else {
                            showSweetAlert('error', 'Error', 'Unexpected server response.');
                        }
                    },
                    error: function () {
                        showSweetAlert('error', 'Error', 'Failed to check for duplicate price matrix.');
                    }
                });
            });
        });
    </script>

    <!-- Delete Price Matrix -->
    <script>
        $(document).ready(function() {
            // Function for deleting event
            $('.delete-price-matrix-btn').on('click', function(e) {
                e.preventDefault();

                var deleteButton = $(this);
                var priceMatrixId = deleteButton.data('price-matrix-id');
                var priceMatrixClassification = decodeURIComponent(deleteButton.data('price-matrix-classification'));
                var priceMatrixMeterSize = decodeURIComponent(deleteButton.data('price-matrix-meter-size'));

                Swal.fire({
                    title: 'Delete Price Matrix',
                    html: "You are about to delete the following Price Matrix:<br><br>" +
                          "<strong>Classification:</strong> " + priceMatrixClassification + "<br>" +
                          "<strong>Meter Size:</strong> " + priceMatrixMeterSize + "<br>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'action/delete_price_matrix.php',
                            type: 'POST',
                            data: {
                                price_matrix_id: priceMatrixId
                            },
                            success: function(response) {
                                if (response.trim() === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        'Price Matrix has been deleted.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete Price Matrix.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete Price Matrix.',
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