<form id="addUserForm" enctype="multipart/form-data">

<div class="container">

    <!-- PERSONAL INFO CARD -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Personal Information
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Suffix</label>
                    <input type="text" name="suffix_name" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <!-- ACCOUNT INFO CARD -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            Account Information
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Account Type</label>
                    <select name="accountType" class="form-select">
                        <option value="Staff" selected>Staff</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Position *</label>
                    <input type="text" name="position" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Contact No *</label>
                    <input type="text" name="contact_no" class="form-control" required>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
            </div>
        </div>
    </div>

    <!-- PROFILE IMAGE CARD -->
<div class="card mb-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Profile Picture</h6>
                    </div>
                    <div class="card-body">
                        <!-- Image Preview -->
                        <div class="form-group mb-3">
                            <p class="text-center">Preview</p>
                            <div class="row mb-3 d-flex justify-content-center align-items-center">
                                <div class="col-sm-12 col-10 d-flex justify-content-center align-items-center">
                                    <div class="image-preview-container" style="width: 280px; height: 280px; overflow: hidden;">
                                        <img class="img-fluid rounded" id="profilePreview" src="../img/avatar.png" alt="Profile Picture Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control" id="profileUpload" name="profile" aria-describedby="inputuploadAddon" accept="image/png, image/gif, image/jpeg" required>
                                        <label class="custom-file-label" id="profileLabel" for="profileUpload">Choose an image</label>
                                    </div>
                                    <hr>
                                    <!-- Capture Button -->
                                    <button class="btn btn-secondary w-100" id="openCameraBtn" type="button"><i class="fa-solid fa-camera mr-2"></i>Open Camera</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- PERMISSIONS CARD -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            Permissions
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="concessionaires" value="1">
                        <label class="form-check-label">Concessionaires</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="billing_system" value="1">
                        <label class="form-check-label">Billing System</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="collecting_system" value="1">
                        <label class="form-check-label">Collecting System</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="accounting_system" value="1">
                        <label class="form-check-label">Accounting System</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="manage_user" value="1">
                        <label class="form-check-label">Manage Users</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="system_settings" value="1">
                        <label class="form-check-label">System Settings</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SUBMIT -->
    <div class="text-end mb-5">
        <button type="submit" class="btn btn-success px-5 w-100">
            Update Now
        </button>
        <a href="users-active.php?title=Manage Active Users" class="btn btn-secondary mb-0 w-100 mt-2">Cancel</a>
    </div>

</div>
</form>
