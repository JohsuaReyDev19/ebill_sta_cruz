<!-- Contact Information -->
<div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="slideHorz">
    <h5 class="multisteps-form__title text-primary"><i class="fa-solid fa-address-book fa-sm mr-2"></i>Contact Information</h5>
    <hr>
    <div class="multisteps-form__content">
        <div class="row">
            <div class="col-sm-6 col-12">
                <!-- Profile Picture Upload Card -->
                <div class="card mb-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Profile Picture</h6>
                    </div>
                    <div class="card-body">
                        <!-- Image Preview -->
                        <div class="form-group mb-3">
                            <p class="text-center">Current Profile Picture</p>
                            <div class="row mb-3 d-flex justify-content-center align-items-center">
                                <div class="col-sm-12 col-10 d-flex justify-content-center align-items-center">
                                    <div class="image-preview-container" style="width: 280px; height: 280px; overflow: hidden;">
                                        <img class="img-fluid rounded" id="profilePreview" src="../upload/profile/<?= $profile ?>" alt="Profile Picture Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input form-control" id="profileUpload" name="profile" aria-describedby="inputuploadAddon" accept="image/png, image/gif, image/jpeg">
                                        <label class="custom-file-label" id="profileLabel" for="profileUpload"><?= $profile ?></label>
                                    </div>
                                    <hr>
                                    <!-- Capture Button -->
                                    <button class="btn btn-secondary w-100" id="openCameraBtn" type="button"><i class="fa-solid fa-camera mr-2"></i>Open Camera</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-12">
                <!-- Contact Card -->
                <div class="card mb-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Contact</h6>
                    </div>
                    <div class="card-body">
                        <!-- Contact No -->
                        <div class="form-group mb-3">
                            <label class="form-label">Contact No.</label>
                            <input type="text" class="form-control" id="contactInput" name="contact_no" value="<?= $contact_no ?>" required>
                            <div class="invalid-feedback">Please enter concessionaire's contact no.</div>
                        </div>
                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" value="<?= $email ?>" required>
                            <div class="invalid-feedback">Please enter concessionaire's email.</div>
                        </div>
                    </div>
                </div>
                <!-- Camera Preview Card (Initially hidden) -->
                <div id="cameraCard" class="card mb-3 shadow" style="display: none;">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="card-title mb-0">Camera Preview</h6>
                    </div>
                    <div class="card-body">
                        <div id="cameraContainer">
                            <video class="align-self-center" id="cameraFeed" width="100%" height="180" autoplay></video>
                            <button class="btn btn-success mt-2 w-100" id="captureBtn" type="button">Capture</button>
                            <canvas id="canvas" style="display: none;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="button-row d-flex justify-content-end mt-4">
            <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i class="fa-solid fa-chevron-left mr-2"></i>Previous Form</button>
            <button class="btn btn-success ml-2" type="button" title="Send" id="updateBtn"><i class="fa-solid fa-floppy-disk mr-2"></i>Save</button>
        </div>
    </div>
</div>