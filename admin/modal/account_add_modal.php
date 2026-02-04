<!-- Add -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-success" id="myModalLabel">
                        <i class="fas fa-plus fa-sm"></i> Add New Account
                    </h4>
                </div>
                <div class="row float-right mr-2">
                    <button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="container-fluid">

                        <input type="hidden" value="<?= $concessionaires_id ?>" name="concessionaires_id">

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="account_no">Account No</label>
                            <input class="form-control" id="account_no" name="account_no" type="text" required>
                            <div class="invalid-feedback">
                                Please input a valid account no.
                            </div>
                        </div>

                        <!-- Account Type -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Account Type</label>

                            <select class="form-control custom-select" name="account_type" id="account_type" required>
                                <option value="" selected disabled>Select account type</option>
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

                        <!-- Classification -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Classification</label>

                            <select class="form-control custom-select" name="classification" id="classification" required>
                                <option value="" selected disabled>Select classification</option>
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

                        <!-- Meter No -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Meter No.</label>
                            <input type="text" class="form-control" name="meter_no" required>
                            <div class="invalid-feedback">Please enter concessionaire's meter no.</div>
                        </div>

                        <!-- Meter Size -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Meter Size.</label>

                            <select class="form-control custom-select" name="meter_size" id="meter_size" required>
                                <option value="" selected disabled>Select meter size</option>
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
                            <label class="control-label modal-label">Meter Brand</label>
                            
                            <select class="form-control custom-select" name="meter_brand" id="meter_brand" required>
                                <option value="" selected disabled>Select meter brand</option>
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

                        <!-- Zone/Book -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Zone/Book</label>
                            
                            <select class="form-control custom-select" name="zonebook" id="zonebook" required>
                                <option value="" selected disabled>Select zone/book</option>
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
                            <label class="control-label modal-label">Date Applied</label>
                            <input type="date" class="form-control" name="date_applied" required>
                            <div class="invalid-feedback">Please enter concessionaire's date applied.</div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer col-12 px-4">
                    <button type="button" class="btn btn-outline-secondary col-12 col-sm-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-success col-12 col-sm-3" id="addAccount">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>