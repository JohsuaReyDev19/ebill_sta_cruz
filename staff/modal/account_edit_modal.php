<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $meters_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $meters_id; ?>" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-primary" id="myModalLabel_<?php echo $meters_id; ?>">
                        <i class="fas fa-pen-to-square fa-sm"></i> Edit Account
                    </h4>
                </div>
                <div class="row float-right mr-2"><button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            </div>
            <form method="POST" id="updateForm_<?php echo $meters_id; ?>">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" name="meters_id" value="<?php echo $meters_id; ?>" required>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="account_no_<?php echo $meters_id; ?>">Account No</label>
                            </div>
                            <div class="col-12">
                                <input class="form-control" id="account_no_<?php echo $meters_id; ?>" name="account_no" type="text" required value="<?php echo $account_no; ?>">
                                <div class="invalid-feedback">
                                    Please input a valid account no.
                                </div>
                            </div>
                        </div>

                        <!-- Account Type -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Account Type</label>
                            <select class="form-control custom-select" name="account_type" id="account_type_<?php echo $meters_id; ?>" required>
                                <option value="" selected disabled>-- Select account type --</option>
                                <?php
                                $sqlFetchActType = "SELECT * FROM account_type_settings WHERE deleted = 0";
                                $resultFetchActType = $con->query($sqlFetchActType);

                                if ($resultFetchActType->num_rows > 0) {
                                    while ($rowFetchActType = $resultFetchActType->fetch_assoc()) {
                                        $account_type_id = $rowFetchActType['account_type_id'];
                                        $account_type = $rowFetchActType['account_type'];
                                        
                                        $selected = ($account_type_id == $account_type_id_selected) ? 'selected' : '';

                                        echo "<option value='$account_type_id' $selected>$account_type</option>";
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
                            <select class="form-control custom-select" name="classification" id="classification_<?php echo $meters_id; ?>" required>
                                <option value="" selected disabled>-- Select classification --</option>
                                <?php
                                $sqlFetchClassification = "SELECT * FROM classification_settings WHERE deleted = 0";
                                $resultFetchClassification = $con->query($sqlFetchClassification);

                                if ($resultFetchClassification->num_rows > 0) {
                                    while ($rowFetchClassification = $resultFetchClassification->fetch_assoc()) {
                                        $classification_id = $rowFetchClassification['classification_id'];
                                        $classification = $rowFetchClassification['classification'];
                                        $selected = ($classification_id == $classification_id_selected) ? 'selected' : '';

                                        echo "<option value='$classification_id' $selected>$classification</option>";
                                    }
                                } else {
                                    echo "<option value='none' selected disabled>No Classification available</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select classification.</div>
                        </div>

                        <!-- Zone/Book -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Zone/Book</label>
                            <select class="form-control custom-select" name="zonebook" id="zonebook_<?php echo $meters_id; ?>" required>
                                <option value="" selected disabled>-- Select zone/book --</option>
                                <?php
                                $sqlFetchZoneBook = "SELECT * FROM zonebook_settings WHERE deleted = 0";
                                $resultFetchZoneBook = $con->query($sqlFetchZoneBook);

                                if ($resultFetchZoneBook->num_rows > 0) {
                                    while ($rowFetchZoneBook = $resultFetchZoneBook->fetch_assoc()) {
                                        $zonebook_id = $rowFetchZoneBook['zonebook_id'];
                                        $zonebook = $rowFetchZoneBook['zonebook'];
                                        $selected = ($zonebook_id == $zonebook_id_selected) ? 'selected' : '';

                                        echo "<option value='$zonebook_id' $selected>$zonebook</option>";
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
                            <input type="date" class="form-control" name="date_applied" value="<?= $date_applied ?>" id="date_applied_<?php echo $meters_id; ?>" required>
                            <div class="invalid-feedback">Please enter concessionaire's date applied.</div>
                        </div>

                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-primary" id="updateAccount_<?php echo $meters_id; ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
   