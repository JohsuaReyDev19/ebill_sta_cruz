<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="zonebook-settings"></div>

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
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-chart-area fa-sm mr-2"></i>Zone/Book Settings</h1>
                    </div>

                    <hr> -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">List of Barangay</h6>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                        <div class="col-12 col-md-4 float-right mx-0 px-0">
                                            <a data-toggle="modal" data-target="#addNew" class="btn btn-success shadow-sm w-100 h-100"><i class="fa-solid fa-plus mr-1"></i>Add Barangay</a>
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
                                                    <th scope="col">Barangay</th>
                                                    <th scope="col">Zone</th>                                        
                                                    <th scope="col">Municipality</th>                                               
                                                    <th scope="col">Action</th>                             
                                                   
                                                </tr>
                                            </thead>
                                            
                                            <tbody>

                                            <?php
                                                require '../db/dbconn.php';

                                                $display_barangay = "
                                                    SELECT 
                                                        b.barangay_id,
                                                        b.barangay,
                                                        b.zonebook_id,
                                                        z.zonebook,
                                                        m.citytownmunicipality
                                                    FROM barangay_settings b
                                                    LEFT JOIN zonebook_settings z 
                                                        ON b.zonebook_id = z.zonebook_id
                                                        AND z.deleted = 0
                                                    LEFT JOIN citytownmunicipality_settings m 
                                                        ON b.citytownmunicipality_id = m.citytownmunicipality_id
                                                        AND m.deleted = 0
                                                    WHERE b.deleted = 0
                                                ";

                                                $sqlQuery = mysqli_query($con, $display_barangay) or die(mysqli_error($con));

                                                $counter = 1;

                                                while($row = mysqli_fetch_assoc($sqlQuery)) {

                                                    $barangay_id = $row['barangay_id'];
                                                    $barangay = $row['barangay'];
                                                    $zone = $row['zonebook']; // ✅ This shows the zone name, not the ID
                                                    $municipality = $row['citytownmunicipality'];
                                                ?>
                                                <tr style="color: black;">
                                                    <td><?= $counter++; ?></td>
                                                    <td><?= htmlspecialchars($barangay); ?></td>
                                                    <td><?= htmlspecialchars($zone); ?></td>
                                                    <td><?= htmlspecialchars($municipality); ?></td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_<?= $barangay_id ?>">Edit</button>
                                                        
                                                        <button class="btn btn-danger btn-sm delete-Barangay-btn"
                                                            data-barangay-id="<?= $barangay_id ?>"
                                                            data-barangay-name="<?= htmlspecialchars($barangay); ?>"
                                                            data-zone-name="<?= htmlspecialchars($zone); ?>"
                                                            data-municipality-name="<?= htmlspecialchars($municipality); ?>">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <?php
                                                include('modal/Barangay_edit_modal.php');
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include('modal/Barangay_add_modal.php'); ?>
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

    <!-- Add Zone/Book-->
    <script>
$(document).ready(function () {

    const showWarningMessage = (message) => {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: message
        });
    };

    $('#addBarangay').on('click', function (e) {
        e.preventDefault();

        const form = $('#addNew form');
        const requiredFields = form.find('[required]');
        let fieldsAreValid = true;

        // Clear validation styles
        requiredFields.removeClass('is-invalid');

        requiredFields.each(function () {
            if (!$(this).val() || $(this).val().trim() === '') {
                fieldsAreValid = false;
                $(this).addClass('is-invalid');
            }
        });

        if (!fieldsAreValid) {
            showWarningMessage('Please fill-up the required fields.');
            return;
        }

        $.ajax({
            url: 'action/add_barangay.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json', // ✅ IMPORTANT
            success: function (res) {

                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Barangay added successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => location.reload());

                } else if (res.status === 'exists') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'Barangay already exists!'
                    });

                } else if (res.status === 'empty') {
                    showWarningMessage('All fields are required.');

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to add Barangay',
                        text: 'Please try again later.'
                    });
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong.'
                });
            }
        });
    });

});
</script>



    <!-- Delete Zone/Book -->
    <script>
$(document).ready(function () {

    

    // Use event delegation (FIX FOR PAGINATION)
    $('#myTable').on('click', '.delete-Barangay-btn', function (e) {
        e.preventDefault();

        var deleteButton = $(this);
        var barangayID = deleteButton.data('barangay-id');
        var barangayName = decodeURIComponent(deleteButton.data('barangay-name'));
        var municipality = decodeURIComponent(deleteButton.data('barangay-remarks'));

        Swal.fire({
            title: 'Delete Barangay',
            html: "You are about to delete:<br><br>" +
                  "<strong>Barangay:</strong> " + barangayName + "<br>" +
                  "<strong>Municipality:</strong> " + municipality + "<br>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: 'action/delete_barangay.php',
                    type: 'POST',
                    data: { zonebook_id: barangayID },
                    success: function (response) {

                        if (response.trim() === 'success') {

                            Swal.fire(
                                'Deleted!',
                                'Barangay has been deleted.',
                                'success'
                            ).then(() => {

                                // REMOVE ROW WITHOUT RELOAD (better)
                                table
                                    .row(deleteButton.closest('tr'))
                                    .remove()
                                    .draw(false);
                                    

                            });

                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to delete Barangay.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    });

});
</script>


    <!-- Edit Zone/Book -->
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
            $(document).on('click', '[id^="updateBarangay_"]', function(e) {
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
                        url: 'action/update_Barangay.php', // URL to submit the form data
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
                            showSweetAlert('error', 'Error', 'Failed to update Barangay. Please try again later.');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>