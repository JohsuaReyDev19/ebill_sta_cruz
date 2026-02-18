

<!-- HTML Form -->
<form id="addUserForm" method="POST" enctype="multipart/form-data">

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
                    <input type="text" name="first_name" class="form-control" required value="<?= htmlspecialchars($user['first_name']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="<?= htmlspecialchars($user['middle_name']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" required value="<?= htmlspecialchars($user['last_name']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Suffix</label>
                    <input type="text" name="suffix_name" class="form-control" value="<?= htmlspecialchars($user['suffix_name']) ?>">
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
                    <select class="form-control custom-select" name="accountType">
                        <option value="Staff" <?= $user['role']==2?'selected':'' ?>>Staff</option>
                        <option value="Admin" <?= $user['role']==1?'selected':'' ?>>Admin</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Position *</label>
                    <input type="text" name="position" class="form-control" required value="<?= htmlspecialchars($user['position'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Contact No *</label>
                    <input type="text" name="contact_no" class="form-control" required value="<?= htmlspecialchars($user['contact_no'] ?? '') ?>">
                </div>
                <div class="col-md-12 mt-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
                </div>
                <div class="col-md-6 mt-3" hidden>
                    <label class="form-label">Username *</label>
                    <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($user['username']) ?>">
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
            <p class="text-center">Preview</p>
            <div class="row mb-3 d-flex justify-content-center align-items-center">
                <div class="col-sm-12 col-10 d-flex justify-content-center align-items-center">
                    <div class="image-preview-container" style="width: 280px; height: 280px; overflow: hidden;">
                        <img class="img-fluid rounded" id="profilePreview" src="<?= htmlspecialchars($user['profile'] ?? '../img/avatar.png') ?>" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-12">
                    <input type="file" class="custom-file-input form-control" id="profileUpload" name="profile" accept="image/png, image/gif, image/jpeg">
                    <label class="custom-file-label" id="profileLabel" for="profileUpload">Choose an image</label>
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
                <?php
                $permissions = [
                    'concessionaires'=>'Concessionaires',
                    'billing_system'=>'Billing System',
                    'collecting_system'=>'Collecting System',
                    'accounting_system'=>'Accounting System',
                    'manage_user'=>'Manage Users',
                    'system_settings'=>'System Settings'
                ];
                foreach ($permissions as $key=>$label) {
                    $checked = $user[$key]==1 ? 'checked' : '';
                    echo '<div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="'.$key.'" value="1" '.$checked.'>
                                <label class="form-check-label">'.$label.'</label>
                            </div>
                          </div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- SUBMIT -->
    <div class="text-end mb-5">
        <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
        <button type="submit" class="btn btn-success px-5 w-100">Update Now</button>
        <a href="users-active.php?title=Manage Users" class="btn btn-secondary w-100 mt-2">Cancel</a>
    </div>

</div>
</form>
