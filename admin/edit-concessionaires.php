<!DOCTYPE html>
<html>          
    <?php include './include/head.php'; ?>
<body id="page-top">
    <div class="d-none" id="edit-concessionaires"></div>

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
                            <!-- <h1 class="h3 mb-0 text-primary"><i class="fas fa-edit fa-sm mr-2"></i>Edit Concessionaire</h1> -->
                            <!-- <a href="concessionaires.php" class="btn btn-secondary mb-0"><i class="fas fa-circle-chevron-left mr-2"></i>Cancel</a> -->
                        </div>

                        <!-- <hr class="bg-primary"> -->

                        <div class="row">
                            <div class="col-12 col-lg-20 ml-auto mr-auto mb-4">
                                <div class="multisteps-form__progress">
                                    <button disabled class="multisteps-form__progress-btn js-active" type="button" title="Personal Info">Personal Information</button>
                                    <button disabled class="multisteps-form__progress-btn" type="button" title="Address Info">Address Information</button>
                                    <button disabled class="multisteps-form__progress-btn" type="button" title="Contact Info">Contact Information</button>
                                </div>
                            </div>
                        </div>

                        <?php
                        require '../db/dbconn.php';
                        require '../config.php';

                        $concessionaires_id = openssl_decrypt($_GET['id'], 'aes-256-cbc', $encryptionKey, 0, $iv);

                        $display_concessionaires = "SELECT ct.* FROM `concessionaires` ct 
                                                    WHERE ct.deleted = 0 
                                                    AND ct.concessionaires_id = '$concessionaires_id'";

                        $sqlQuery = mysqli_query($con, $display_concessionaires) or die(mysqli_error($con));

                        if ($row = mysqli_fetch_array($sqlQuery)) {
                            $concessionaires_id = $row['concessionaires_id'];
                            $same_address = $row['same_address'];

                            $home_citytownmunicipality_id = $row['home_citytownmunicipality_id'];
                            $home_barangay_id = $row['home_barangay_id'];
                            $home_sitio = $row['home_sitio'];
                            $home_street = $row['home_street'];
                            $home_housebuilding_no = $row['home_housebuilding_no'];

                            $billing_citytownmunicipality_id = $row['billing_citytownmunicipality_id'];
                            $billing_barangay_id = $row['billing_barangay_id'];
                            $billing_sitio = $row['billing_sitio'];
                            $billing_street = $row['billing_street'];
                            $billing_housebuilding_no = $row['billing_housebuilding_no'];

                            $profile = $row['profile'];
                            $contact_no = $row['contact_no'];
                            $email = $row['email'];

                            // Check if this is an institution
                            $is_institution = $row['is_institution'];

                            if ($is_institution == 1) {
                                // Organization fields
                                $institution_name = $row['institution_name'];
                                $institution_description = $row['institution_description'];

                                // Set personal fields to empty since not applicable
                                $last_name = $first_name = $middle_name = $suffix_name = $gender = "";
                            } else {
                                // Person fields
                                $last_name = $row['last_name'];
                                $first_name = $row['first_name'];
                                $middle_name = $row['middle_name'];
                                $suffix_name = $row['suffix_name'];
                                $gender = $row['gender'];
                                $discount = $row['discount'];

                                $institution_name = $institution_description = "";
                            }
                        }
                        ?>
                                        
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="content w-100">
                                    <!--content inner-->
                                    <div class="content__inner">
                                        <!--multisteps-form-->
                                        <div class="multisteps-form">
                                            <!--form panels-->
                                            <div class="row">
                                                <div class="col-12 m-auto" id="editFormContainer">
                                                    <form class="multisteps-form__form" id="editForm">

                                                        <input type="hidden" name="concessionaire_id" value="<?= $concessionaires_id ?>">
                                                        <!-- Personal  Information-->
                                                        <?php include 'form-edit/personal_info.php'; ?>

                                                        <!-- Address Information -->
                                                        <?php include 'form-edit/address_info.php'; ?>

                                                        <!-- Contact Information -->
                                                        <?php include 'form-edit/contact_info.php'; ?>
                                                        
                                                    </form>
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
    
    <script  src="../js/multiform.js"></script>

    <script>
        $(document).ready(function () {
            $('#isOrganization').on('change', function () {
                if ($(this).is(':checked')) {
                    // Hide Name & Gender, show Institution
                    $('#nameGenderRow').addClass('d-none');
                    $('#institutionRow').removeClass('d-none');

                    $('input[name="last_name"], input[name="first_name"], input[name="middle_name"], select[name="gender"], select[name="suffix_name"]')
                        .prop('disabled', true)
                        .prop('required', false)
                        .removeClass('is-invalid');

                    $('textarea[name="institution_name"], textarea[name="institution_description"]')
                        .prop('disabled', false)
                        .prop('required', true);

                } else {
                    // Show Name & Gender, hide Institution
                    $('#nameGenderRow').removeClass('d-none');
                    $('#institutionRow').addClass('d-none');

                    $('input[name="last_name"], input[name="first_name"], input[name="middle_name"], select[name="gender"], select[name="suffix_name"]')
                        .prop('disabled', false);

                    $('input[name="last_name"], input[name="first_name"], select[name="gender"]')
                        .prop('required', true);

                    $('textarea[name="institution_name"], textarea[name="institution_description"]')
                        .prop('disabled', true)
                        .prop('required', false)
                        .removeClass('is-invalid');
                }
            });

            // Trigger on page load if checkbox already checked
            if ($('#isOrganization').is(':checked')) {
                $('#isOrganization').trigger('change');
            }

            $('#sameAddressCheck').change(function () {
                if ($(this).is(':checked')) {
                    updateBillingAddress();
                    $('#billing_barangay').html($('#home_barangay').html()).val($('#home_barangay').val());
                    $('#billing_citytown').html($('#home_citytown').html()).val($('#home_citytown').val());
                    disableBillingFields(true);
                } else {
                    disableBillingFields(false);
                    clearBillingFields();
                }
            });

            $('input[name="home_house_no"], input[name="home_street"], input[name="home_sitio"]').on('input change', function () {
                if ($('#sameAddressCheck').is(':checked')) {
                    updateBillingAddress();
                }
            });

            $('#home_barangay').on('input change', function () {
                if ($('#sameAddressCheck').is(':checked')) {
                    $('#billing_barangay').html($('#home_barangay').html()).val($('#home_barangay').val()).trigger('change');
                }
            });

            $('#home_citytown').on('input change', function () {
                if ($('#sameAddressCheck').is(':checked')) {
                    $('#billing_citytown').html($('#home_citytown').html()).val($('#home_citytown').val()).trigger('change');
                }
            });

            function updateBillingAddress() {
                $('input[name="billing_house_no"]').val($('input[name="home_house_no"]').val());
                $('input[name="billing_street"]').val($('input[name="home_street"]').val());
                $('input[name="billing_sitio"]').val($('input[name="home_sitio"]').val());
            }

            function disableBillingFields(disable) {
                $('input[name="billing_house_no"]').prop('readonly', disable);
                $('input[name="billing_street"]').prop('readonly', disable);
                $('input[name="billing_sitio"]').prop('readonly', disable);

                if (disable) {
                    $('#billing_barangay, #billing_citytown')
                        .addClass('readonly-select')
                        .attr('tabindex', '-1');
                } else {
                    $('#billing_barangay, #billing_citytown')
                        .removeClass('readonly-select')
                        .removeAttr('tabindex');
                }
            }

            function clearBillingFields() {
                $('input[name="billing_house_no"]').val('');
                $('input[name="billing_street"]').val('');
                $('input[name="billing_sitio"]').val('');
            }

            function populateBarangays(citytownId, barangaySelectId, selectedBarangayId = null) {
                if (citytownId) {
                    $.ajax({
                        url: 'action/fetch_barangays.php',
                        method: 'POST',
                        data: { citytown_id: citytownId },
                        dataType: 'json',
                        success: function (response) {
                            $(barangaySelectId).empty().append('<option value="" selected disabled>-- Select Barangay --</option>');
                            if (response.length > 0) {
                                $.each(response, function (index, barangay) {
                                    let selected = (selectedBarangayId && barangay.barangay_id == selectedBarangayId) ? 'selected' : '';
                                    $(barangaySelectId).append('<option value="' + barangay.barangay_id + '" ' + selected + '>' + barangay.barangay_name + '</option>');
                                });
                            } else {
                                $(barangaySelectId).append('<option value="none" disabled>No Barangay available</option>');
                            }
                        }
                    });
                } else {
                    $(barangaySelectId).empty().append('<option value="" selected disabled>-- Select Barangay --</option>');
                }
            }

            $('#home_citytown').change(function () {
                var citytownId = $(this).val();
                var preSelectedHomeBarangayId = $('#home_barangay').data('selected-barangay');
                populateBarangays(citytownId, '#home_barangay', preSelectedHomeBarangayId);
            });

            $('#billing_citytown').change(function () {
                var citytownId = $(this).val();
                var preSelectedHomeBarangayId = $('#billing_barangay').data('selected-barangay');
                populateBarangays(citytownId, '#billing_barangay', preSelectedHomeBarangayId);
            });

            if ($('#home_citytown').val()) {
                $('#home_citytown').change();
            }
            if ($('#billing_citytown').val()) {
                $('#billing_citytown').change();
            }

            if ($('#sameAddressCheck').is(':checked')) {
                $('#sameAddressCheck').trigger('change');
            }

            // Limit Contact Input
            function limitContactInputLength(event) {
                var inputValue = event.target.value.replace(/\D/g, '');
                if (inputValue.length > 12) {
                    inputValue = inputValue.slice(0, 12);
                }
                event.target.value = inputValue;
            }
            var contactInput = document.getElementById('contactInput');
            if (contactInput) {
                contactInput.addEventListener('input', limitContactInputLength);
            }
        });
    </script>

    <script>
        // Open camera function
        document.getElementById('openCameraBtn').addEventListener('click', function() {
            const cameraCard = document.getElementById('cameraCard');
            const cameraFeed = document.getElementById('cameraFeed');

            // Show the camera card and start the video stream
            cameraCard.style.display = 'block';
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((stream) => {
                    cameraFeed.srcObject = stream;
                })
                .catch((err) => {
                    alert('Error accessing camera: ' + err.message);
                });
        });

        // Capture image function
        document.getElementById('captureBtn').addEventListener('click', function() {
            const canvas = document.getElementById('canvas');
            const cameraFeed = document.getElementById('cameraFeed');
            const context = canvas.getContext('2d');
            
            // Set canvas size to the video feed dimensions
            canvas.width = cameraFeed.videoWidth;
            canvas.height = cameraFeed.videoHeight;
            context.drawImage(cameraFeed, 0, 0, canvas.width, canvas.height);

            // Convert canvas to image URL
            const imageUrl = canvas.toDataURL('image/png');
            document.getElementById('profilePreview').src = imageUrl;

            // Stop the video stream after capturing
            cameraFeed.srcObject.getTracks().forEach(track => track.stop());
            
            // Hide the camera card after capturing
            document.getElementById('cameraCard').style.display = 'none';
        });
    </script>

    <script>
        $(document).ready(function() {
            let profileValid = true;

            const showWarningMessage = (message) => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: message
                });
            };

            $('#profileUpload').on('change', function() {
                const fileInput = $(this)[0];
                const file = fileInput.files[0];

                if (file) {
                    $('#profileLabel').text(file.name);
                    profileValid = true;

                    const allowedTypes = ['image/png', 'image/jpeg', 'image/webp', 'image/gif'];
                    if (allowedTypes.includes(file.type)) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#profilePreview').attr('src', e.target.result);
                            $('input[name="profile"]').removeClass('input-error');
                            $('.custom-file-label[for="profileUpload"]').removeClass('input-error');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        showWarningMessage('Please select a valid image file (PNG, JPG, WEBP, GIF).');
                        profileValid = false;
                        $('#profileUpload').val('');
                        $('input[name="profile"]').addClass('input-error');
                        $('.custom-file-label[for="profileUpload"]').addClass('input-error');
                    }
                }
            });

            $('#updateBtn').on('click', function(e) {
                e.preventDefault();

                const formDiv = $('#editFormContainer form');
                const formData = new FormData($('#editForm')[0]);
                const requiredFields = formDiv.find('[required]');

                let fieldsAreValid = true;

                $('.form-control').removeClass('is-invalid');
                $('.form-control').removeClass('input-error');

                requiredFields.each(function() {
                    if ($(this).is('select')) {
                        if (!$(this).val() || $(this).val().trim() === "") {
                            fieldsAreValid = false;
                            showWarningMessage('Please fill-up the required fields.');
                            $(this).addClass('is-invalid');
                        }
                    } else {
                        if ($(this).val().trim() === '') {
                            fieldsAreValid = false;
                            showWarningMessage('Please fill-up the required fields.');
                            $(this).addClass('is-invalid');
                        }
                    }
                });

                if (fieldsAreValid) {
                    if (!profileValid) {
                        showWarningMessage('Please upload a valid profile picture.');
                        $('input[name="profile"]').addClass('input-error');
                        $('.custom-file-label[for="profileUpload"]').addClass('input-error');
                        return;
                    }

                    // let description = 'Change Name';
                    // // Fetch rate first
                    // return fetch("action/get-rates-charge.php", {
                    //     method: "POST",
                    //     headers: {
                    //         "Content-Type": "application/x-www-form-urlencoded"
                    //     },
                    //     body: "description=" + encodeURIComponent(description)
                    // })
                    // .then(response => response.json())
                    // .then(data => {

                    //     if (data.status !== "success") {
                    //         throw new Error("Rate not found.");
                    //     }

                    //     let rate = parseFloat(data.rate).toFixed(2);

                    //     return {
                    //         status: value,
                    //         description: description,
                    //         rate: rate
                    //     };
                    // })

                    // $.ajax({
                    //     url: 'action/add_other_material.php',
                    //     method: 'POST',
                    //     data:{
                    //         meters_id: meterId,
                    //         units_included: "Change Name",
                    //         units: "0",
                    //         quantity: "1",
                    //         price_per_unit: rate,
                    //         remarks: `${description} Charge`,
                    //     }
                    // });
                    $.ajax({
                        url: 'action/update_concessionaire.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            try {
                                const jsonResponse = JSON.parse(response);
                                if (jsonResponse.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: jsonResponse.message,
                                        showConfirmButton: true,
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = 'concessionaires.php';
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed to update Concessionaire!',
                                        text: jsonResponse.message || 'Please try again later.',
                                        showConfirmButton: true,
                                        confirmButtonText: 'OK'
                                    });
                                }
                            } catch (e) {
                                console.error('Invalid JSON response:', response);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Unexpected response!',
                                    text: 'An error occurred. Please try again later.',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to update Concessionaire',
                                text: 'Please try again later.',
                                showConfirmButton: true,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>