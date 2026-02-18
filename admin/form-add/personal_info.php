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
                    <select class="form-control custom-select" name="accountType" id="accountType" required>
                        <option value="" selected disabled>-- select account --</option>
                        <option value="Staff">Staff</option>
                        <option value="Admin" disabled>Admin</option>
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
                <div class="col-md-12 mt-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <!-- <div class="col-md-6 mt-3">
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" class="form-control">
                </div> -->
            </div>
        </div>
    </div>

    <!-- PROFILE IMAGE CARD -->
<div class="card mb-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Profile Picture</h6>
                    </div>

                    <!-- Image Preview -->
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <p class="text-center">Preview</p>

                            <!-- Preview container -->
                            <div  class="row mb-3 d-flex justify-content-center align-items-center">
                                <div class="col-sm-12 col-10 d-flex justify-content-center align-items-center">
                                    <div class="image-preview-container" style="width: 280px; height: 280px; overflow: hidden;">
                                        <img class="img-fluid rounded" id="profilePreview" src="../img/avatar.png" alt="Profile Picture Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                            </div>

                            <!-- Camera Card (hidden by default) -->
                            <div class="card shadow-sm p-3" id="cameraCard" style="display:none; position: relative; max-width: 500px; margin: 20px auto;">
                                <video id="cameraFeed" autoplay playsinline style="width:100%; border-radius:8px;"></video>
                                <canvas id="canvas" style="display:none;"></canvas>
                                <div class="mt-2 d-flex justify-content-between">
                                    <button class="btn btn-success" id="captureBtn"><i class="fa-solid fa-check me-2"></i>Capture</button>
                                    <button class="btn btn-danger" id="closeCameraBtn"><i class="fa-solid fa-times me-2"></i>Close</button>
                                </div>
                            </div>
                            <hr>

                            <!-- File Upload + Open Camera -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input form-control" id="profileUpload" name="profile" accept="image/png, image/gif, image/jpeg" required>
                                        <label class="custom-file-label" id="profileLabel" for="profileUpload">Choose an image</label>
                                    </div>
                                    <button class="btn btn-secondary w-100" id="openCameraBtn" type="button"><i class="fa-solid fa-camera me-2"></i>Open Camera</button>
                                </div>
                            </div>
                        </div>
                    </div>
</div>

    <!-- PERMISSIONS CARD -->
<div class="card shadow-sm mb-4 mt-4">
    <div class="card-header bg-dark text-white">
        <i class="fas fa-lock me-2"></i> Permissions
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-lg-4 col-md-6">
                <div class="form-check form-check-lg">
                    <input class="form-check-input" type="checkbox" name="concessionaires" value="1" id="concessionaires">
                    <label class="form-check-label" for="concessionaires">
                        <i class="fas fa-store me-1"></i> Concessionaires
                    </label>
                </div>
                <div class="form-check form-check-lg">
                    <input class="form-check-input" type="checkbox" name="billing_system" value="1" id="billing_system">
                    <label class="form-check-label" for="billing_system">
                        <i class="fas fa-file-invoice-dollar me-1"></i> Billing System
                    </label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="form-check form-check-lg">
                    <input class="form-check-input" type="checkbox" name="collecting_system" value="1" id="collecting_system">
                    <label class="form-check-label" for="collecting_system">
                        <i class="fas fa-hand-holding-usd me-1"></i> Collecting System
                    </label>
                </div>
                <div class="form-check form-check-lg">
                    <input class="form-check-input" type="checkbox" name="accounting_system" value="1" id="accounting_system">
                    <label class="form-check-label" for="accounting_system">
                        <i class="fas fa-calculator me-1"></i> Accounting System
                    </label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="form-check form-check-lg">
                    <input class="form-check-input" type="checkbox" name="manage_user" value="1" id="manage_user">
                    <label class="form-check-label" for="manage_user">
                        <i class="fas fa-users-cog me-1"></i> Manage Users
                    </label>
                </div>
                <div class="form-check form-check-lg">
                    <input class="form-check-input" type="checkbox" name="system_settings" value="1" id="system_settings">
                    <label class="form-check-label" for="system_settings">
                        <i class="fas fa-cogs me-1"></i> System Settings
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- SUBMIT -->
    <div class="text-end mb-5">
        <button type="submit" class="btn btn-primary px-5 w-100">
            Add User
        </button>
        <a href="users-active.php?title=Manage Users" class="btn btn-secondary mb-0 w-100 mt-2">Cancel</a>
    </div>

</div>
</form>
