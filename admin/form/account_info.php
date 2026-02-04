<!-- Personal Information -->
<div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="slideHorz">
    <h5 class="multisteps-form__title text-primary"><i class="fa-solid fa-file-invoice fa-sm mr-2"></i>Account Information</h5>
    <hr>
    <div class="multisteps-form__content">
        <div class="row d-flex align-items-stretch">
            <div class="col-sm-6 col-12 d-flex">
                <!-- Account Card -->
                <div class="card mb-3 shadow flex-fill">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Account</h6>
                    </div>
                    <div class="card-body">
                        <!-- Account No -->
                        <div class="form-group mb-3">
                            <label class="form-label" for="account_no">Account No. <span class="text-primary">*</span></label>
                            <input type="text" class="form-control" name="account_no" required>
                            <div class="invalid-feedback">Please enter concessionare's account no.</div>
                        </div>
                        <!-- Account Type -->
                        <div class="form-group mb-3">
                            <label class="form-label">Account Type</label>

                            <select class="form-control custom-select" name="account_type" id="account_type" required>
                                <option value="" selected disabled>-- Select account type --</option>
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
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12 d-flex">
                <!-- Classification Card -->
                <div class="card mb-3 shadow flex-fill">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Classification</h6>
                    </div>
                    <div class="card-body">
                        <!-- Classification -->
                        <div class="form-group mb-3">
                            <label class="form-label">Classification</label>

                            <select class="form-control custom-select" name="classification" id="classification" required>
                                <option value="" selected disabled>-- Select classification --</option>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-12">
                <!-- Meter -->
                <div class="card mb-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Meter</h6>
                    </div>
                    <div class="card-body">
                        <!-- Meter No -->
                        <div class="form-group mb-3">
                            <label class="form-label">Meter No.</label>
                            <input type="text" class="form-control" name="meter_no" required>
                            <div class="invalid-feedback">Please enter concessionaire's meter no.</div>
                        </div>
                        <!-- Meter Size -->
                        <div class="form-group mb-3">
                            <label class="form-label">Meter Size.</label>

                            <select class="form-control custom-select" name="meter_size" id="meter_size" required>
                                <option value="" selected disabled>-- Select meter size --</option>
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
                            <label class="form-label">Meter Brand</label>
                            
                            <select class="form-control custom-select" name="meter_brand" id="meter_brand" required>
                                <option value="" selected disabled>-- Select meter brand --</option>
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
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-12">
                <!-- Meter -->
                <div class="card mb-3 shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="card-title mb-0">Boundary</h6>
                    </div>
                    <div class="card-body">
                        <!-- Zone/Book -->
                        <div class="form-group mb-3">
                            <label class="form-label">Zone/Book</label>
                            
                            <select class="form-control custom-select" name="zonebook" id="zonebook" required>
                                <option value="" selected disabled>-- Select zone/book --</option>
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
                            <label class="form-label">Date Applied</label>
                            <input type="date" class="form-control" name="date_applied" required>
                            <div class="invalid-feedback">Please enter concessionaire's date applied.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="button-row d-flex justify-content-end mt-4">
            <?php 
                include './include/nextBtn.php'
            ?>
        </div>
    </div>
</div>
