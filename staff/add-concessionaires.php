<!DOCTYPE html>
<html>          
    <?php include './include/head.php'; ?>
<body id="page-top">
    <div class="d-none" id="add-concessionaires"></div>

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
                            <!-- <h1 class="h3 mb-0 text-primary"><i class="fas fa-plus fa-sm mr-2"></i>Add Concessionaire</h1> -->
                            <a href="concessionaires.php?title=Concessionaires" class="btn btn-secondary mb-0"><i class="fas fa-circle-chevron-left mr-2"></i>Cancel</a>
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

                        <!-- Content Row -->
                                        
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="content w-100">
                                    <!--content inner-->
                                    <div class="content__inner">
                                        <!--multisteps-form-->
                                        <div class="multisteps-form">
                                            <!--form panels-->
                                            <div class="row">
                                                <div class="col-12 m-auto" id="addNew">
                                                    <form class="multisteps-form__form" id="AddForm">

                                                        <!-- Personal  Information-->
                                                        <?php include 'form/personal_info.php'; ?>

                                                        <!-- Address Information -->
                                                        <?php include 'form/address_info.php'; ?>

                                                        <!-- Contact Information -->
                                                        <?php include 'form/contact_info.php'; ?>
                                                        
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
        $(document).ready(function() {
            $('#isOrganization').on('change', function () {
                if ($(this).is(':checked')) {
                    // Hide Name & Gender, show Institution
                    $('#nameGenderRow').addClass('d-none');
                    $('#institutionRow').removeClass('d-none');

                    // Disable Name/Gender inputs and remove required
                    $('input[name="last_name"], input[name="first_name"], input[name="middle_name"], select[name="gender"]')
                        .prop('disabled', true)
                        .prop('required', false)
                        .removeClass('is-invalid');

                    // Enable and require Institution Name
                    $('textarea[name="institution_name"]')
                        .prop('disabled', false)
                        .prop('required', true);

                    // Enable and require Institution Description
                    $('textarea[name="institution_description"]')
                        .prop('disabled', false)
                        .prop('required', true);

                } else {
                    // Show Name & Gender, hide Institution
                    $('#nameGenderRow').removeClass('d-none');
                    $('#institutionRow').addClass('d-none');

                    // Enable Name/Gender inputs
                    $('input[name="last_name"], input[name="first_name"], input[name="middle_name"], select[name="gender"]')
                        .prop('disabled', false);

                    // Add required back to necessary fields
                    $('input[name="last_name"], input[name="first_name"], select[name="gender"]')
                        .prop('required', true);

                    // Disable Institution Name
                    $('textarea[name="institution_name"]')
                        .prop('disabled', true)
                        .prop('required', false)
                        .removeClass('is-invalid');

                    // Disable and require Institution Description
                    $('textarea[name="institution_description"]')
                        .prop('disabled', true)
                        .prop('required', false)
                        .removeClass('is-invalid');
                }
            });

            // Listen for changes to the checkbox
            $('#sameAddressCheck').change(function() {
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

            // Listen for input changes in home address fields
            $('input[name="home_house_no"], input[name="home_street"], input[name="home_sitio"]').on('input change', function() {
                if ($('#sameAddressCheck').is(':checked')) {
                    updateBillingAddress();
                }
            });

            // Listen for input changes in home address fields
            $('#home_barangay').on('input change', function() {
                if ($('#sameAddressCheck').is(':checked')) {
                    $('#billing_barangay').html($('#home_barangay').html()).val($('#home_barangay').val()).trigger('change');
                }
            });

            // Listen for input changes in home address fields
            $('#home_citytown').on('input change', function() {
                if ($('#sameAddressCheck').is(':checked')) {
                    $('#billing_citytown').html($('#home_citytown').html()).val($('#home_citytown').val()).trigger('change');
                }
            });

            // Function to auto-populate billing fields with home address values
            function updateBillingAddress() {
                $('input[name="billing_house_no"]').val($('input[name="home_house_no"]').val());
                $('input[name="billing_street"]').val($('input[name="home_street"]').val());
                $('input[name="billing_sitio"]').val($('input[name="home_sitio"]').val());
            }

            // Function to disable or enable billing address fields
            function disableBillingFields(disable) {
                $('input[name="billing_house_no"]').prop('readonly', disable);
                $('input[name="billing_street"]').prop('readonly', disable);
                $('input[name="billing_sitio"]').prop('readonly', disable);

                if (disable) {
                    $('#billing_barangay, #billing_citytown')
                        .addClass('readonly-select')
                        .attr('tabindex', '-1'); // Add tabindex -1 when disabled
                } else {
                    $('#billing_barangay, #billing_citytown')
                        .removeClass('readonly-select')
                        .removeAttr('tabindex'); // Remove tabindex when enabled
                }
            }

            // Function to clear billing address fields
            function clearBillingFields() {
                $('input[name="billing_house_no"]').val('');
                $('input[name="billing_street"]').val('');
                $('input[name="billing_sitio"]').val('');
            }

            // Refactor: Populate barangay based on selected city/town/municipality
            function populateBarangays(citytownId, barangaySelectId) {
                if (citytownId) {
                    $.ajax({
                        url: 'action/fetch_barangays.php', // Endpoint to handle the request
                        method: 'POST',
                        data: { citytown_id: citytownId },
                        dataType: 'json',
                        success: function(response) {
                            $(barangaySelectId).empty().append('<option value="" selected disabled>-- Select Barangay --</option>');
                            if (response.length > 0) {
                                $.each(response, function(index, barangay) {
                                    $(barangaySelectId).append('<option value="' + barangay.barangay_id + '">' + barangay.barangay_name + '</option>');
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

            // Populate barangay for home city/town/municipality
            $('#home_citytown').change(function() {
                var citytownId = $(this).val();
                populateBarangays(citytownId, '#home_barangay');
            });

            // Populate barangay for billing city/town/municipality
            $('#billing_citytown').change(function() {
                var citytownId = $(this).val();
                populateBarangays(citytownId, '#billing_barangay');
            });

            // Input Element for Contact Number
            function limitContactInputLength(event) {
                // Remove non-digit characters
                var inputValue = event.target.value.replace(/\D/g, '');

                // Limit the length to 12 digits
                if (inputValue.length > 12) {
                    inputValue = inputValue.slice(0, 12);
                }

                // Update the input value
                event.target.value = inputValue;
            }

            // Apply the function to the input element
            var contactInput = document.getElementById('contactInput');
            contactInput.addEventListener('input', limitContactInputLength);
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
            // Variable to track if the profile picture is changed
            let profileValid = false;

            // Function to show SweetAlert2 warning message
            const showWarningMessage = (message) => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: message
                });
            };

            // Function to handle file input change event for profile picture
            $('#profileUpload').on('change', function() {
                const fileInput = $(this)[0];
                const file = fileInput.files[0];

                if (file) {
                    // Update the label text with the selected file name
                    $('#profileLabel').text(file.name);

                    // Set profileValid to true when a new profile picture is selected
                    profileValid = true;

                    // Check if the file type is allowed
                    const allowedTypes = ['image/png', 'image/jpeg', 'image/webp', 'image/gif'];
                    if (allowedTypes.includes(file.type)) {
                        // Read the selected file and display the preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#profilePreview').attr('src', e.target.result); // Set image source to preview element
                            $('input[name="profile"]').removeClass('input-error');
                            $('.custom-file-label[for="profileUpload"]').removeClass('input-error');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        // Show warning message for invalid file type
                        showWarningMessage('Please select a valid image file (PNG, JPG, WEBP, GIF).');
                        profileValid = false;
                        $('#profileUpload').val(''); // Clear the file input
                        $('input[name="profile"]').addClass('input-error');
                        $('.custom-file-label[for="profileUpload"]').addClass('input-error');
                    }
                }
            });

            // Function to handle form submission
            $('#accomplishBtn').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                const formDiv = $('#addNew form');
                const formData = new FormData($('#AddForm')[0]);
                const requiredFields = formDiv.find('[required]');

                let fieldsAreValid = true; // Initialize as true

                // Remove existing error classes
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

                    $.ajax({
                        url: 'action/add_concessionaire.php',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            try {
                                const jsonResponse = JSON.parse(response); // Parse the JSON response
                                if (jsonResponse.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: jsonResponse.message, // Display message from the response
                                        showConfirmButton: true,
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // Redirect to concessionaires.php on success
                                        window.location.href = 'concessionaires.php';
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed to add Concessionaire!',
                                        text: jsonResponse.message || 'Please try again later.',
                                        showConfirmButton: true,
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        // location.reload();
                                    });
                                }
                            } catch (e) {
                                // Handle JSON parsing error or unexpected response format
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
                            console.error(xhr.responseText); // Output error response to console
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to add Concessionaire',
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