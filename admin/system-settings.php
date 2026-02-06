<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="system-settings"></div>

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
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-cog fa-sm mr-2"></i>System Settings</h1>
                    </div>

                    <hr> -->

                    <!-- Content Row -->
                    <div class="row">

                        <?php
                            // Include your database connection file
                            require '../db/dbconn.php';

                            // Fetch current settings from the database
                            $sql = "SELECT system_name, system_profile FROM system_settings WHERE settings_id = 1";
                            $result = $con->query($sql);

                            $currentSettings = null;
                            if ($result->num_rows > 0) {
                                $currentSettings = $result->fetch_assoc();
                            }

                            $con->close();
                        ?>

                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Profile Picture</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="px-3">
                                        <form id="systemProfileForm" method="POST" enctype="multipart/form-data">
                                            <div class="form-group mb-3">
                                                <p class="text-center">System Profile Picture</p>
                                                <div class="row mb-3 d-flex justify-content-center align-items-center">
                                                    <div class="col-sm-12 col-10 d-flex justify-content-center align-items-center">
                                                        <div class="image-preview-container" style="width: 280px; height: 280px; overflow: hidden;">
                                                            <img class="img-fluid rounded" id="systemProfilePreview" src="../img/<?= $currentSettings['system_profile']; ?>" alt="System Profile Picture Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input form-control" id="systemProfileUpload" name="system_profile" aria-describedby="inputuploadAddon" accept="image/png, image/gif, image/jpeg">
                                                            <label class="custom-file-label" id="systemProfileLabel" for="systemProfileUpload"><?= $currentSettings['system_profile']; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="button" class="btn btn-primary shadow-sm" id="updateSystemProfileBtn">Update Picture</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">System Name</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="px-3">
                                        <form id="systemNameForm" method="POST">
                                            <div class="form-group">
                                                <label for="systemName">System Name</label>
                                                <input type="text" class="form-control" id="systemName" name="system_name" value="<?php echo isset($currentSettings['system_name']) ? htmlspecialchars($currentSettings['system_name']) : ''; ?>" required>
                                                <div class="invalid-feedback">
                                                    Please input a valid System Name.
                                                </div>
                                            </div>
                                            <hr>
                                            <button type="button" class="btn btn-primary shadow-sm" id="updateSystemNameBtn">Update Name</button>
                                        </form>
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
        $(document).ready(function() {
            let profileValid = true;

            const showWarningMessage = (message) => {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: message
                });
            };

            $('#systemProfileUpload').on('change', function() {
                const fileInput = $(this)[0];
                const file = fileInput.files[0];

                if (file) {
                    $('#systemProfileLabel').text(file.name);
                    profileValid = true;

                    const allowedTypes = ['image/png', 'image/jpeg', 'image/webp', 'image/gif'];
                    if (allowedTypes.includes(file.type)) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#systemProfilePreview').attr('src', e.target.result);
                            $('input[name="system_profile"]').removeClass('input-error');
                            $('.custom-file-label[for="systemProfileLabel"]').removeClass('input-error');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        showWarningMessage('Please select a valid image file (PNG, JPG, WEBP, GIF).');
                        profileValid = false;
                        $('#systemProfilePreview').val('');
                        $('input[name="system_profile"]').addClass('input-error');
                        $('.custom-file-label[for="systemProfileLabel"]').addClass('input-error');
                    }
                }
            });

            // Update System Profile
            $('#updateSystemProfileBtn').on('click', function (e) {
                e.preventDefault();

                if (!profileValid) {
                    showWarningMessage('Please upload a valid profile picture.');
                    return;
                }

                const formData = new FormData($('#systemProfileForm')[0]);

                Swal.fire({
                    title: 'Updating...',
                    text: 'Uploading system profile picture',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: 'action/update_system_profile.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: res.message,
                                    timer: 1200,
                                    timerProgressBar: true,
                                    showConfirmButton: true
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        } catch (err) {
                            Swal.fire('Error', 'Unexpected response from server.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Upload failed. Please try again.', 'error');
                    }
                });
            });

            // Update System Name
            $('#updateSystemNameBtn').on('click', function (e) {
                e.preventDefault();

                const systemName = $('#systemName').val().trim();

                if (systemName === '') {
                    showWarningMessage('System name cannot be empty.');
                    $('#systemName').addClass('is-invalid');
                    return;
                }

                $('#systemName').removeClass('is-invalid');

                $.ajax({
                    url: 'action/update_system_name.php',
                    type: 'POST',
                    data: { system_name: systemName },
                    success: function (response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: res.message,
                                    timer: 1200,
                                    timerProgressBar: true,
                                    showConfirmButton: true
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        } catch (err) {
                            Swal.fire('Error', 'Unexpected response from server.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Update failed. Please try again.', 'error');
                    }
                });
            });

        });
    </script>

</body>

</html>