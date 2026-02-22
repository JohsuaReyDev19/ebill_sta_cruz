<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="concessionaires"></div>

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
                    <?php
                        require '../db/dbconn.php';
                        require '../config.php';

                        $concessionaires_id = openssl_decrypt($_GET['id'], 'aes-256-cbc', $encryptionKey, 0, $iv);

                        $display_concessionaires = "
                                                    SELECT 
                                                        CONCAT(
                                                            ct.last_name, ', ',
                                                            ct.first_name, ' ',
                                                            ct.middle_name, 
                                                            CASE 
                                                                WHEN ct.suffix_name != 'NA' THEN CONCAT(' ', ct.suffix_name)
                                                                ELSE ''
                                                            END
                                                        ) AS full_name
                                                    FROM `concessionaires` ct
                                                    WHERE ct.deleted = 0 
                                                      AND ct.concessionaires_id = '$concessionaires_id';
                                                    ";

                        $sqlQuery = mysqli_query($con, $display_concessionaires) or die(mysqli_error($con));

                        while($row = mysqli_fetch_array($sqlQuery)) {
                            $full_name = $row['full_name'];
                        }
                                
                    ?>

                    <!-- Page Heading -->
                    

                    <!-- <hr> -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">List of Accounts of <?= ucwords(strtolower($full_name)) ?></h6>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                        <a href="concessionaires.php?title=Concessionaires" class="btn btn-secondary mb-0 shadow-sm mr-2"><i class="fas fa-circle-chevron-left mr-2"></i>Back</a>
                                        <div class="col-12 col-md-4 float-right mx-0 px-0">
                                            <a href="edit-concessionaires-new-accounts-meters.php?title=New Account&concessionaire_id=<?php echo urlencode($_GET['id']); ?>" class="btn btn-success shadow-sm w-100 h-100"><i class="fa-solid fa-plus mr-1"></i>Add Account</a>
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
                                                    <!-- <th scope="col">Id</th>                               -->
                                                    <th scope="col">Account No</th>                                        
                                                    <th scope="col">Account Type</th>                                        
                                                    <th scope="col">Meter No</th>                                         
                                                    <th scope="col">Meter</th>                                         
                                                    <th scope="col">Classification</th>   
                                                    <th scope="col">status</th>                      
                                                    <th scope="col" style="text-align: center   ;">Action</th>                         
                                                </tr>
                                            </thead>
                                            
                                            <tbody id="consTable">

                                            <?php
                                                require '../db/dbconn.php';
                                                include './function/formatFractionString.php';
                                                require '../config.php';

                                                $display_account = "
                                                                        SELECT mt.* , act.account_type, cst.classification, mst.meter_size, mbs.meter_brand, zs.zonebook, service_status_id
                                                                        FROM `meters` mt
                                                                        INNER JOIN `account_type_settings` act ON act.account_type_id = mt.account_type_id
                                                                        INNER JOIN `classification_settings` cst ON cst.classification_id = mt.classification_id
                                                                        INNER JOIN `meter_size_settings` mst ON mst.meter_size_id = mt.meter_size_id
                                                                        INNER JOIN `meter_brand_settings` mbs ON mbs.meter_brand_id = mt.meter_brand_id
                                                                        LEFT JOIN `zonebook_settings` zs ON zs.zonebook_id = mt.zonebook_id
                                                                        WHERE mt.concessionaires_id = '$concessionaires_id' AND mt.deleted = 0
                                                                    ";
                                                $sqlQuery = mysqli_query($con, $display_account) or die(mysqli_error($con));

                                                $counter = 1;

                                                while($row = mysqli_fetch_array($sqlQuery)) {
                                                    // Fetch all fields into variables
                                                    $meters_id = $row['meters_id'];
                                                    $account_no = $row['account_no'];
                                                    $account_type_id_selected = $row['account_type_id'];
                                                    $classification_id_selected = $row['classification_id'];
                                                    $meter_no = $row['meter_no'];
                                                    $meter_size_id_selected = $row['meter_size_id'];
                                                    $meter_brand_id_selected = $row['meter_brand_id'];
                                                    $zonebook_id_selected = $row['zonebook_id'];
                                                    $status = $row['service_status_id'];
                                                    $date_applied = $row['date_applied'];

                                                    $account_type = $row['account_type'];
                                                    $classification = $row['classification'];
                                                    $meter_size = $row['meter_size'];
                                                    $meter_brand = $row['meter_brand'];
                                                    $zonebook = $row['zonebook'];

                                                    $encryptedData = openssl_encrypt($meters_id, 'aes-256-cbc', $encryptionKey, 0, $iv);
                                            ?>

                                                <tr>
                                                    <td><?= $counter; ?></td>
                                                    <!-- <td><?= $meters_id ?></td> -->
                                                    <td><?= htmlspecialchars($account_no); ?></td>
                                                    <td><?= htmlspecialchars($account_type); ?></td>
                                                    <td><?= htmlspecialchars($meter_no); ?></td>
                                                    <td><?= htmlspecialchars($meter_brand) . " " . formatFractionString($meter_size); ?></td>
                                                    <td><?= htmlspecialchars($classification); ?></td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                            $stats = htmlspecialchars($status); 
                                                            if($stats == "0"){
                                                                echo '<span style="background-color: red; color: white; padding: 5px; border-radius: 10px;">Disconnected</span>';
                                                            }elseif($stats == "1"){
                                                                
                                                                echo '<span style="background-color: green; color: white; padding: 5px; border-radius: 10px;">Active</span>';
                                                            }else{
                                                                echo '<span style="background-color: orange; color: white; padding: 5px; border-radius: 10px;">Temporary Disconnected</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#edit_<?php echo $meters_id; ?>"><i class="fa-solid fa-edit"></i> 
                                                        Edit Account
                                                    </a>

                                                        <a href="edit-concessionaires-accounts-change-meters.php?title=Account Meter Info&concessionaire_id=<?php echo urlencode($_GET['id']); ?>&meters_id=<?php echo urlencode($encryptedData);
                                                        ?>" class="btn btn-sm btn-success shadow-sm"><i class="fa-solid fa-gauge-simple"></i> Change Meter</a>
                                                        <button class="btn btn-sm btn-warning shadow-sm change-status-btn"
                                                            data-meter-id="<?php echo $meters_id; ?>"
                                                            data-meter-name="<?php echo htmlspecialchars($full_name); ?>">
                                                            Change Status
                                                        </button>
                                                        
                                                    </td>
                                                </tr>
                                                <?php
                                                    $counter++;
                                                   include('modal/account_edit_modal.php');
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include('modal/account_add_modal.php'); ?>
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

    <script>
        $(document).ready(function () {
            $(document).on('change', '.add-hose-checkbox', function () {
                const modal = $(this).closest('.modal');
                const hoseInput = modal.find('.hose-length-input');

                if ($(this).is(':checked')) {
                    hoseInput.prop('disabled', false).prop('required', true);
                } else {
                    hoseInput.prop('disabled', true).prop('required', false).val('');
                }
            });
        });
    </script>

    <!-- Add Account -->
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

            $('#addAccount').on('click', function(e) {
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
                        url: 'action/add_account.php', // URL to submit the form data
                        type: 'POST',
                        data: formData.serialize(), // Serialize form data
                        success: function(response) {
                            // Handle the success response
                            console.log(response); // Output response to console (for debugging)
                            if (response === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Account added successfully!',
                                    showConfirmButton: true, // Show OK button
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to add account!',
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
                                title: 'Failed to add account',
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

    <script>
    document.addEventListener("click", function(e) {

            if (e.target.classList.contains("change-status-btn")) {

            let meterId = e.target.dataset.meterId;
            let meterName = e.target.dataset.meterName;

            Swal.fire({
                title: `Change Status for ${meterName}`,
                input: 'select',
                inputOptions: {
                    1: 'Active / Re-connection',
                    0: 'Disconnection',
                    2: 'Temporary Disconnected'
                },
                inputPlaceholder: 'Select a status',
                showCancelButton: true,
                confirmButtonText: 'Apply',
                cancelButtonText: 'Cancel',
                preConfirm: (value) => {

                    let description = '';

                    if (value == 0) description = 'Re-connection';
                    if (value == 1) description = 'Disconnection';
                    if (value == 2) description = 'Temporary Disconnection';

                    if (!description) {
                        Swal.showValidationMessage("Please select a status.");
                        return false;
                    }

                    // Fetch rate first
                    return fetch("action/get-rates-charge.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "description=" + encodeURIComponent(description)
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status !== "success") {
                            throw new Error("Rate not found.");
                        }

                        let rate = parseFloat(data.rate).toFixed(2);

                        return {
                            status: value,
                            description: description,
                            rate: rate
                        };
                    })
                    .catch(error => {
                        Swal.showValidationMessage(error.message);
                    });
                }

            }).then((result) => {

                if (!result.isConfirmed) return;

                let { status, description, rate } = result.value;

                // 1️⃣ Add charge
                $.ajax({
                    url: 'action/add_other_material.php',
                    method: 'POST',
                    data:{
                        meters_id: meterId,
                        units_included: "Status Connectivity",
                        units: "0",
                        quantity: "1",
                        price_per_unit: rate,
                        remarks: `${description} Charge`,
                    },
                    dataType: 'json',
                    success: function (response) {

                        if (response.status !== 'success') {
                            Swal.fire('Error', 'Unable to add charge.', 'error');
                            return;
                        }

                        // 2️⃣ Update status
                        fetch("action/delete-account.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: "meters_id=" + meterId + "&status=" + status
                        })
                        .then(response => response.json())
                        .then(data => {

                            if (data.status === "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: `₱${rate} charge added and status updated successfully.`
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Warning', data.message, 'warning');
                            }

                        });

                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong while saving.', 'error');
                    }
                });

            });
        }
    });
    </script>




<script>
        $(document).ready(function () {
            $('#addOtherMaterialBtn').on('click', function (e) {
                e.preventDefault();

                const form = $('#addOtherMaterialForm');
                const requiredFields = form.find('[required]');
                let isValid = true;

                // Remove old validation styles
                form.find('.form-control, .custom-select').removeClass('is-invalid');

                // Basic required field check
                requiredFields.each(function () {
                    if ($(this).val() === '' || $(this).val() === null) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    }
                });

                // Numeric quantity validation
                const quantity = parseFloat($('#quantityInput').val());
                if (isNaN(quantity) || quantity <= 0) {
                    $('#quantityInput').addClass('is-invalid');
                    isValid = false;
                }

                // Price validation
                const priceText = $('#priceLabel').text().replace(/[₱,]/g, '');
                const price = parseFloat(priceText);
                if (isNaN(price) || price <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing or Invalid Price',
                        text: 'Please select a material with valid pricing.'
                    });
                    return;
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Fields',
                        text: 'Please complete all required fields before submitting.'
                    });
                    return;
                }

                // Submit via AJAX
                $.ajax({
                    url: 'action/add_other_material.php',
                    method: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Material Added',
                                text: response.message
                            }).then(() => {
                                $('#addNewMaterials').modal('hide'); // 
                                form[0].reset();
                                $('#unitsLabel').text('—');
                                $('#priceLabel').text('—');
                                $('#subtotalLabel').text('₱0.00');
                                $('#unitsInput').val('');
                                $('#priceInput').val('');

                                // Reload the table if available
                                if ($.fn.DataTable.isDataTable('#otherBillingTable')) {
                                    $('#otherBillingTable').DataTable().ajax.reload(null, false); // or true if you want to go to first page
                                }
                            });
                        } else {
                            Swal.fire('Error', response.message || 'Unable to add material.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'An unexpected error occurred while saving.', 'error');
                    }
                });
            });
        });
    </script>


    <!-- Edit Account -->
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
            $(document).on('click', '[id^="updateAccount_"]', function(e) {
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
                        url: 'action/update_account.php', // URL to submit the form data
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