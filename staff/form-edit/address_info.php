<!-- Address Information -->
<div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="slideHorz">
    <h5 class="multisteps-form__title text-primary"><i class="fa-solid fa-location-dot fa-sm mr-2"></i>Address Information</h5>
    <hr>
    <div class="multisteps-form__content">
        <div class="row">
            <div class="col-sm-6 col-12">
                <!-- Home Address Card -->
                <div class="card mb-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Home Address</h6>
                    </div>
                    <div class="card-body">
                        <!-- City/Town -->
                        <div class="form-group mb-3">
                            <label class="form-label">City/Town/Municipality <span class="text-primary">*</span></label>
                            <select class="form-control custom-select" name="home_citytown" id="home_citytown" required>
                                <option value="" selected disabled>-- Select City/Town/Municipality --</option>
                                <?php
                                require '../db/dbconn.php';
                                $sqlFetchCity = "SELECT * FROM citytownmunicipality_settings WHERE deleted = 0";
                                $resultFetchCity = $con->query($sqlFetchCity);

                                if ($resultFetchCity->num_rows > 0) {
                                    while ($rowFetchCity = $resultFetchCity->fetch_assoc()) {
                                        $citytownmunicipality_id = $rowFetchCity['citytownmunicipality_id'];
                                        $citytownmunicipality = $rowFetchCity['citytownmunicipality'];

                                        // Check if the current city/town ID matches the selected one
                                        $selected = ($citytownmunicipality_id == $home_citytownmunicipality_id) ? 'selected' : '';

                                        echo "<option value='$citytownmunicipality_id' $selected>$citytownmunicipality</option>";
                                    }
                                } else {
                                    echo "<option value='none' selected disabled>No City/Town/Municipality available</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please enter concessionaire's city or town.</div>
                        </div>
                        <!-- Barangay -->
                        <div class="form-group mb-3">
                            <label class="form-label">Barangay <span class="text-primary">*</span></label>
                            <select class="form-control custom-select" name="home_barangay" id="home_barangay" data-selected-barangay="<?= $home_barangay_id ?>" required>
                                <option value="" selected disabled>-- Select Barangay --</option>
                            </select>
                            <div class="invalid-feedback">Please enter concessionaire's barangay.</div>
                        </div>
                        <!-- Sitio -->
                        <div class="form-group mb-3">
                            <label class="form-label">Sitio (Optional)</label>
                            <input type="text" class="form-control" name="home_sitio" value="<?= $home_sitio ?>">
                            <div class="invalid-feedback">Please enter a valid sitio.</div>
                        </div>
                        <!-- Street -->
                        <div class="form-group mb-3">
                            <label class="form-label">Street (Optional)</label>
                            <input type="text" class="form-control" name="home_street" value="<?= $home_street ?>">
                            <div class="invalid-feedback">Please enter a valid street.</div>
                        </div>
                        <!-- House No./Building No. -->
                        <div class="form-group mb-3">
                            <label class="form-label">House No./Building No. <span class="text-primary">*</span></label>
                            <input type="text" class="form-control" name="home_house_no" value="<?= $home_housebuilding_no ?>" required>
                            <div class="invalid-feedback">Please enter concessionaire's house/building number.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12">
                <!-- Billing Address Card -->
                <div class="card mb-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Billing Address</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" name="sameAddressCheck" type="checkbox" value="yes" <?= $same_address == 'yes' ? 'checked' : ''; ?> id="sameAddressCheck">
                                <label class="form-check-label" for="sameAddressCheck">
                                    Same as Home Address
                                </label>
                            </div>
                        </div>
                        <hr>
                        <!-- City/Town -->
                        <div class="form-group mb-3">
                            <label class="form-label">City/Town/Municipality <span class="text-primary">*</span></label>
                            <select class="form-control custom-select" name="billing_citytown" id="billing_citytown" required>
                                <option value="" selected disabled>-- Select City/Town/Municipality --</option>
                                <?php
                                require '../db/dbconn.php';
                                $sqlFetchCity = "SELECT * FROM citytownmunicipality_settings WHERE deleted = 0";
                                $resultFetchCity = $con->query($sqlFetchCity);

                                if ($resultFetchCity->num_rows > 0) {
                                    while ($rowFetchCity = $resultFetchCity->fetch_assoc()) {
                                        $citytownmunicipality_id = $rowFetchCity['citytownmunicipality_id'];
                                        $citytownmunicipality = $rowFetchCity['citytownmunicipality'];

                                        // Check if the current city/town ID matches the selected one
                                        $selected = ($citytownmunicipality_id == $billing_citytownmunicipality_id) ? 'selected' : '';

                                        echo "<option value='$citytownmunicipality_id' $selected>$citytownmunicipality</option>";
                                    }
                                } else {
                                    echo "<option value='none' selected disabled>No City/Town/Municipality available</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please enter concessionaire's city or town.</div>
                        </div>
                        <!-- Barangay -->
                        <div class="form-group mb-3">
                            <label class="form-label">Barangay <span class="text-primary">*</span></label>
                            <select class="form-control custom-select" name="billing_barangay" id="billing_barangay" data-selected-barangay="<?= $billing_barangay_id ?>" required>
                                <option value="" selected disabled>-- Select Barangay --</option>
                            </select>
                            <div class="invalid-feedback">Please enter concessionaire's barangay.</div>
                        </div>
                        <!-- Sitio -->
                        <div class="form-group mb-3">
                            <label class="form-label">Sitio (Optional)</label>
                            <input type="text" class="form-control" name="billing_sitio">
                            <div class="invalid-feedback">Please enter a valid sitio.</div>
                        </div>
                        <!-- Street -->
                        <div class="form-group mb-3">
                            <label class="form-label">Street (Optional)</label>
                            <input type="text" class="form-control" name="billing_street">
                            <div class="invalid-feedback">Please enter a valid street.</div>
                        </div>
                        <!-- House No./Building No. -->
                        <div class="form-group mb-3">
                            <label class="form-label">House No./Building No. <span class="text-primary">*</span></label>
                            <input type="text" class="form-control" name="billing_house_no" required>
                            <div class="invalid-feedback">Please enter concessionaire's house/building number.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="button-row d-flex justify-content-end mt-4">
            <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i class="fa-solid fa-chevron-left mr-2"></i>Previous Form</button>
            <button class="btn btn-primary ml-2 js-btn-next" type="button" title="Next">Next Form<i class="fa-solid fa-chevron-right ml-2"></i></button>
        </div>
    </div>
</div>