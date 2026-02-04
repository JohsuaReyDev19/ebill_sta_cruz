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

                        $concessionaires_id = openssl_decrypt($_GET['concessionaire_id'], 'aes-256-cbc', $encryptionKey, 0, $iv);
                        $meters_id = "";

                        $display_account_info = "
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

                        $sqlQuery = mysqli_query($con, $display_account_info) or die(mysqli_error($con));

                        while($row = mysqli_fetch_array($sqlQuery)) {
                            $full_name = $row['full_name'];
                        }
                                
                    ?>

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-plus fa-sm mr-2"></i>New Account & Meter of <?php echo $full_name; ?></h1>
                        <a href="edit-concessionaires-accounts.php?id=<?php echo urlencode($_GET['concessionaire_id']); ?>" class="btn btn-secondary mb-0 shadow-sm"><i class="fas fa-circle-chevron-left mr-2"></i>Back</a>
                    </div>

                    <hr>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">New Account</h6>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Left Column: Account and Current Meter Info -->
                                        <div class="col-lg-5 col-12 mb-4">
                                            <div class="card border-left-primary shadow">
                                                <div class="card-body">
                                                    <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-info-circle mr-2"></i>New Account Info</h6>

                                                    <div class=""><strong>Concessionaire Name:</strong> <?= htmlspecialchars($full_name); ?></div>

                                                    <hr>

                                                    <!-- Info alert about charges -->
                                                    <div class="alert alert-primary" role="alert">
                                                        <p class="font-italic">
                                                            <strong>Note:</strong> Opening new account will incur charges to the concessionaire. 
                                                            The initial charge will depend on the <strong>Unit Price</strong> of the selected <strong>Meter Size</strong>.
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column: Pricing Breakdown Table -->
                                        <div class="col-lg-7 col-12 mb-4">
                                            <div class="card border-left-success shadow">
                                                <div class="card-body">
                                                    <h6 class="font-weight-bold text-success mb-3"><i class="fas fa-gauge-simple mr-2"></i>New Account</h6>
                                                    
                                                    <div class="">
                                                        <form method="POST" id="newAccountForm">
	                                                        <input type="hidden" name="concessionaires_id" value="<?php echo $concessionaires_id; ?>" required>

	                                                        <div class="form-group mb-3">
									                            <label class="control-label modal-label" for="account_no">Account No</label>
									                            <input class="form-control form-control-sm" id="account_no" name="account_no" type="text" required>
									                            <div class="invalid-feedback">
									                                Please input a valid account no.
									                            </div>
									                        </div>

									                        <!-- Account Type -->
									                        <div class="form-group mb-3">
									                            <label class="control-label modal-label">Account Type</label>

									                            <select class="form-control custom-select custom-select-sm" name="account_type" id="account_type" required>
									                                <option value="" selected disabled>Select account type</option>
									                                <?php
									                                $sqlFetchActType = "SELECT * FROM account_type_settings WHERE deleted = 0";
									                                $resultFetchActType = $con->query($sqlFetchActType);

									                                if ($resultFetchActType->num_rows > 0) {
									                                    while ($rowFetchActType = $resultFetchActType->fetch_assoc()) {
									                                        $account_type_id = $rowFetchActType['account_type_id'];
									                                        $account_type = $rowFetchActType['account_type'];
									                                        echo "<option value='$account_type_id'>$account_type</option>";
									                                    }
									                                } else {
									                                    echo "<option value='none' selected disabled>No Account Type available</option>";
									                                }
									                                ?>
									                            </select>

									                            <div class="invalid-feedback">Please select account type.</div>
									                        </div>

									                        <!-- Classification -->
									                        <div class="form-group mb-3">
									                            <label class="control-label modal-label">Classification</label>

									                            <select class="form-control custom-select custom-select-sm" name="classification" id="classification" required>
									                                <option value="" selected disabled>Select classification</option>
									                                <?php
									                                $sqlFetchClassification = "SELECT * FROM classification_settings WHERE deleted = 0";
									                                $resultFetchClassification = $con->query($sqlFetchClassification);

									                                if ($resultFetchClassification->num_rows > 0) {
									                                    while ($rowFetchClassification = $resultFetchClassification->fetch_assoc()) {
									                                        $classification_id = $rowFetchClassification['classification_id'];
									                                        $classification = $rowFetchClassification['classification'];
									                                        echo "<option value='$classification_id'>$classification</option>";
									                                    }
									                                } else {
									                                    echo "<option value='none' selected disabled>No Classification available</option>";
									                                }
									                                ?>
									                            </select>

									                            <div class="invalid-feedback">Please select classification.</div>
									                        </div>

									                        <!-- Meter Size -->
									                        <div class="form-group mb-3">
									                            <label class="control-label modal-label">Meter Size.</label>

									                            <select class="form-control custom-select custom-select-sm" name="meter_size" id="meter_size" required>
									                                <option value="" selected disabled>Select meter size</option>
									                                <?php
									                                $sqlFetchMeterSize = "SELECT * FROM meter_size_settings WHERE deleted = 0";
									                                $resultFetchMeterSize = $con->query($sqlFetchMeterSize);

									                                if ($resultFetchMeterSize->num_rows > 0) {
									                                    while ($rowFetchMeterSize = $resultFetchMeterSize->fetch_assoc()) {
									                                        $meter_size_id = $rowFetchMeterSize['meter_size_id'];
									                                        $meter_size = $rowFetchMeterSize['meter_size'];
									                                        echo "<option value='$meter_size_id'>$meter_size</option>";
									                                    }
									                                } else {
									                                    echo "<option value='none' selected disabled>No Meter Size available</option>";
									                                }
									                                ?>
									                            </select>

									                            <div class="invalid-feedback">Please select meter size.</div>
									                        </div>

									                        <!-- Meter Brand-->
									                        <div class="form-group mb-3">
									                            <label class="control-label modal-label">Meter Brand</label>
									                            
									                            <select class="form-control custom-select custom-select-sm" name="meter_brand" id="meter_brand" required>
									                                <option value="" selected disabled>Select meter brand</option>
									                                <?php
									                                $sqlFetchMeterBrand = "SELECT * FROM meter_brand_settings WHERE deleted = 0";
									                                $resultFetchMeterBrand = $con->query($sqlFetchMeterBrand);

									                                if ($resultFetchMeterBrand->num_rows > 0) {
									                                    while ($rowFetchMeterBrand = $resultFetchMeterBrand->fetch_assoc()) {
									                                        $meter_brand_id = $rowFetchMeterBrand['meter_brand_id'];
									                                        $meter_brand = $rowFetchMeterBrand['meter_brand'];
									                                        echo "<option value='$meter_brand_id'>$meter_brand</option>";
									                                    }
									                                } else {
									                                    echo "<option value='none' selected disabled>No Meter Brand available</option>";
									                                }
									                                ?>
									                            </select>

									                            <div class="invalid-feedback">Please select meter brand.</div>
									                        </div>

									                        <!-- Meter No -->
									                        <div class="form-group mb-3">
									                            <label class="control-label modal-label">Meter No.</label>
									                            <input type="text" class="form-control form-control-sm" name="meter_no" required>
									                            <div class="invalid-feedback">Please enter concessionaire's meter no.</div>
									                        </div>

									                        <!-- Zone/Book -->
									                        <div class="form-group mb-3">
									                            <label class="control-label modal-label">Zone/Book</label>
									                            
									                            <select class="form-control custom-select custom-select-sm" name="zonebook" id="zonebook">
									                                <option value="0" selected>Select zone/book</option>
									                                <?php
									                                $sqlFetchZoneBook = "SELECT * FROM zonebook_settings WHERE deleted = 0";
									                                $resultFetchZoneBook = $con->query($sqlFetchZoneBook);

									                                if ($resultFetchZoneBook->num_rows > 0) {
									                                    while ($rowFetchZoneBook = $resultFetchZoneBook->fetch_assoc()) {
									                                        $zonebook_id = $rowFetchZoneBook['zonebook_id'];
									                                        $zonebook = $rowFetchZoneBook['zonebook'];
									                                        echo "<option value='$zonebook_id'>$zonebook</option>";
									                                    }
									                                } else {
									                                    echo "<option value='none' selected disabled>No Zone/Book available</option>";
									                                }
									                                ?>
									                            </select>

									                            <div class="invalid-feedback">Please select zone/book.</div>
									                        </div>
									                        <!-- Date Applied -->
									                        <div class="form-group mb-3">
									                            <label class="control-label modal-label">Date Applied</label>
									                            <input type="date" class="form-control form-control-sm" name="date_applied" required>
									                            <div class="invalid-feedback">Please enter concessionaire's date applied.</div>
									                        </div>

	                                                        <div class="form-group text-right mb-0">
	                                                            <button type="submit" name="submit" class="btn btn-success shadow-sm" id="newMeterBtn">Save Account</button>
	                                                        </div>

	                                                    </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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
		$(document).ready(function () {
			// Get the concessionaire_id from PHP
	        const concessionaireId = <?php echo json_encode($_GET['concessionaire_id']); ?>;

		    $('#newMeterBtn').on('click', function (e) {
		        e.preventDefault();
		        const form = $('#newAccountForm');
		        const requiredFields = form.find('[required]');
		        let isValid = true;

		        $('.form-control, .custom-select').removeClass('is-invalid');

		        requiredFields.each(function () {
		            if ($(this).val() === '' || $(this).val() === null) {
		                isValid = false;
		                $(this).addClass('is-invalid');
		                Swal.fire('Incomplete Fields', 'Please fill out all required fields.', 'warning');
		            }
		        });

		        if (isValid) {
		            $.ajax({
		                url: 'action/add_account.php',
		                type: 'POST',
		                data: form.serialize(),
		                dataType: 'json',
		                success: function (response) {
		                    if (response.status === 'success') {
		                        Swal.fire({
	                                icon: 'success',
	                                title: 'Account Created',
	                                text: response.message,
	                                timer: 3000,
	                                timerProgressBar: true,
	                                allowOutsideClick: false,
	                                showConfirmButton: true
	                            }).then(() => {
	                            	// Disable form after creation
		                        	$('#newAccountForm').find('input, select, textarea, button').prop('disabled', true);
	                                // Redirect to profile with dynamic ID
	                                window.location.href = 'edit-concessionaires-accounts.php?id=' + encodeURIComponent(concessionaireId);
	                            });
		                    } else {
		                        Swal.fire('Error', response.message, 'error');
		                    }
		                },
		                error: function () {
		                    Swal.fire('Request Failed', 'Something went wrong. Please try again later.', 'error');
		                }
		            });
		        }
		    });
		});
	</script>

</body>

</html>