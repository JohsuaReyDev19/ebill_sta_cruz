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
                        $meters_id = openssl_decrypt($_GET['meters_id'], 'aes-256-cbc', $encryptionKey, 0, $iv);

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


                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">Account Meter Info of <?php echo $full_name; ?></h6>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <?php
                                        require '../db/dbconn.php';
                                        include './function/formatFractionString.php';
                                        require '../config.php';

                                        $display_account = "
                                                                SELECT mt.* , act.account_type, cst.classification, mst.meter_size, mbs.meter_brand, zs.zonebook
                                                                FROM `meters` mt
                                                                INNER JOIN `account_type_settings` act ON act.account_type_id = mt.account_type_id
                                                                INNER JOIN `classification_settings` cst ON cst.classification_id = mt.classification_id
                                                                INNER JOIN `meter_size_settings` mst ON mst.meter_size_id = mt.meter_size_id
                                                                INNER JOIN `meter_brand_settings` mbs ON mbs.meter_brand_id = mt.meter_brand_id
                                                                INNER JOIN `zonebook_settings` zs ON zs.zonebook_id = mt.zonebook_id
                                                                WHERE mt.meters_id = '$meters_id' AND mt.deleted = 0
                                                            ";
                                        $sqlQuery = mysqli_query($con, $display_account) or die(mysqli_error($con));

                                        while($row = mysqli_fetch_array($sqlQuery)) {
                                            // Fetch all 
                                            $account_no = $row['account_no'];
                                            $account_type_id_selected = $row['account_type_id'];
                                            $classification_id_selected = $row['classification_id'];
                                            $meter_no = $row['meter_no'];
                                            $meter_size_id_selected = $row['meter_size_id'];
                                            $meter_brand_id_selected = $row['meter_brand_id'];
                                            $zonebook_id_selected = $row['zonebook_id'];
                                            $date_applied = $row['date_applied'];

                                            $account_type = $row['account_type'];
                                            $classification = $row['classification'];
                                            $meter_size = $row['meter_size'];
                                            $meter_brand = $row['meter_brand'];
                                            $zonebook = $row['zonebook'];
                                        }
                                    ?>
                                    <div class="row">
                                        <!-- Left Column: Account and Current Meter Info -->
                                        <div class="col-lg-5 col-12 mb-4">
                                            <div class="card border-left-primary shadow">
                                                <div class="card-body">
                                                    <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-info-circle mr-2"></i>Current Account Info</h6>
                                                    <div class=""><strong>Concessionaire Name:</strong> <?= htmlspecialchars($full_name); ?></div>
                                                    <div class=""><strong>Account No:</strong> <?= htmlspecialchars($account_no); ?></div>
                                                    <div class=""><strong>Account Type:</strong> <?= htmlspecialchars($account_type); ?></div>
                                                    <div class=""><strong>Classification:</strong> <?= htmlspecialchars($classification); ?></div>
                                                    <div class=""><strong>Zonebook:</strong> <?= htmlspecialchars($zonebook); ?></div>
                                                    <hr>
                                                    <!-- Info alert about additional charges -->
                                                    <div class="alert alert-primary" role="alert">
                                                        <p class="font-italic">
                                                            <strong>Note:</strong> Changing the meter (<strong>Meter Size</strong> or <strong>Meter Brand</strong>) will incur additional charges to the concessionaire. 
                                                            The additional charge will depend on the <strong>Unit Price</strong> of the newly selected <strong>Meter Size</strong>.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column: Pricing Breakdown Table -->
                                        <div class="col-lg-7 col-12 mb-4">
                                            <div class="card border-left-success shadow">
                                                <div class="card-body">
                                                    <h6 class="font-weight-bold text-success mb-3"><i class="fas fa-gauge-simple mr-2"></i>Account Change Charges</h6>
                                                    
                                                    <div class="">
                                                        <form method="POST" id="changeMeterForm">
                                                            <input type="hidden" name="meters_id" value="<?php echo $meters_id; ?>" required>       

                                                            <!-- Meter Size -->
                                                            <div class="form-group">
                                                                <label class="control-label modal-label">Meter Size.</label>
                                                                <select class="form-control custom-select" name="meter_size" id="meter_size" required>
                                                                    <option value="" selected disabled>-- Select meter size --</option>
                                                                    <?php
                                                                    $sqlFetchMeterSize = "SELECT * FROM meter_size_settings WHERE deleted = 0";
                                                                    $resultFetchMeterSize = $con->query($sqlFetchMeterSize);

                                                                    if ($resultFetchMeterSize->num_rows > 0) {
                                                                        while ($rowFetchMeterSize = $resultFetchMeterSize->fetch_assoc()) {
                                                                            $meter_size_id = $rowFetchMeterSize['meter_size_id'];
                                                                            $meter_size = $rowFetchMeterSize['meter_size'];
                                                                            $selected = ($meter_size_id == $meter_size_id_selected) ? 'selected' : '';

                                                                            echo "<option value='$meter_size_id' $selected>$meter_size</option>";
                                                                        }
                                                                    } else {
                                                                        echo "<option value='none' selected disabled>No Meter Size available</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="invalid-feedback">Please select meter size.</div>
                                                            </div>

                                                            <!-- Meter Brand-->
                                                            <div class="form-group">
                                                                <label class="control-label modal-label">Meter Brand</label>
                                                                <select class="form-control custom-select" name="meter_brand" id="meter_brand" required>
                                                                    <option value="" selected disabled>-- Select meter brand --</option>
                                                                    <?php
                                                                    $sqlFetchMeterBrand = "SELECT * FROM meter_brand_settings WHERE deleted = 0";
                                                                    $resultFetchMeterBrand = $con->query($sqlFetchMeterBrand);

                                                                    if ($resultFetchMeterBrand->num_rows > 0) {
                                                                        while ($rowFetchMeterBrand = $resultFetchMeterBrand->fetch_assoc()) {
                                                                            $meter_brand_id = $rowFetchMeterBrand['meter_brand_id'];
                                                                            $meter_brand = $rowFetchMeterBrand['meter_brand'];
                                                                            $selected = ($meter_brand_id == $meter_brand_id_selected) ? 'selected' : '';

                                                                            echo "<option value='$meter_brand_id' $selected>$meter_brand</option>";
                                                                        }
                                                                    } else {
                                                                        echo "<option value='none' selected disabled>No Meter Brand available</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="invalid-feedback">Please select meter brand.</div>
                                                            </div>

                                                            <!-- Meter No -->
                                                            <div class="form-group">
                                                                <label class="control-label modal-label">Meter No.</label>
                                                                <input type="text" class="form-control" name="meter_no" value="<?= $meter_no ?>" id="meter_no" required>
                                                                <div class="invalid-feedback">Please enter concessionaire's meter no.</div>
                                                            </div>

                                                            <!-- Remarks -->
                                                            <div class="form-group">
                                                                <label class="control-label modal-label">Remarks (Optional)</label>
                                                                <textarea class="form-control" name="remarks" id="remarks"></textarea>
                                                                <div class="invalid-feedback">Please input a valid remarks.</div>
                                                            </div>

                                                            <div class="form-group text-right mb-0">
                                                                <a href="edit-concessionaires-accounts.php?title=Concessionaires&id=<?php echo urlencode($_GET['concessionaire_id']); ?>" class="btn btn-secondary mb-0 shadow-sm"><i class="fas fa-circle-chevron-left mr-2"></i>Back</a>
                                                                <button type="submit" name="submit" class="btn btn-success shadow-sm" id="changeMeterBtn">Update Meter</button>
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

            $('#changeMeterBtn').on('click', function (e) {
                e.preventDefault();
                const form = $('#changeMeterForm');
                const requiredFields = form.find('[required]');
                let isValid = true;

                $('.form-control').removeClass('is-invalid');

                requiredFields.each(function () {
                    if ($(this).val() === '' || $(this).val() === null) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                        Swal.fire('Incomplete Fields', 'Please fill out all required fields.', 'warning');
                    }
                });

                if (isValid) {
                    $.ajax({
                        url: 'action/change_meter.php',
                        type: 'POST',
                        data: form.serialize(),
                        dataType: 'json',
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Meter Updated',
                                    text: response.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                    showConfirmButton: true
                                }).then(() => {
                                    // Disable form after creation
                                    $('#changeMeterForm').find('input, select, textarea, button').prop('disabled', true);
                                    // Redirect to profile with dynamic ID
                                    window.location.href = 'edit-concessionaires-accounts.php?id=' + encodeURIComponent(concessionaireId);
                                });
                            } else if (response.status === 'nochange') {
                                Swal.fire('No Changes', response.message, 'info');
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