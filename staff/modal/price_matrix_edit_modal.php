<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $price_matrix_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $price_matrix_id; ?>" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-primary" id="myModalLabel_<?php echo $price_matrix_id; ?>">
                        <i class="fas fa-pen-to-square fa-sm"></i> Edit Price Matrix
                    </h4>
                </div>
                <div class="row float-right mr-2"><button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            </div>
            <form method="POST" id="updateForm_<?php echo $price_matrix_id; ?>">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" name="price_matrix_id" value="<?php echo $price_matrix_id; ?>" required>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="classification_id_<?php echo $price_matrix_id; ?>">Classification</label>
                            </div>
                            <div class="col-12">
                                <select class="form-control custom-select" name="classification_id" id="classification_id_<?php echo $price_matrix_id; ?>" required>
	                                <option value="" selected disabled>Select classification</option>
	                                <?php
	                                $sqlFetchActType = "SELECT * FROM classification_settings WHERE deleted = 0";
	                                $resultFetchActType = $con->query($sqlFetchActType);

	                                if ($resultFetchActType->num_rows > 0) {
	                                    while ($rowFetchActType = $resultFetchActType->fetch_assoc()) {
	                                        $classification_id = $rowFetchActType['classification_id'];
	                                        $classification = $rowFetchActType['classification'];
	                                        
	                                        $selected = ($classification_id == $classification_id_selected) ? 'selected' : '';

	                                        echo "<option value='$classification_id' $selected>$classification</option>";
	                                    }
	                                } else {
	                                     echo "<option value='none' selected disabled>No Classification available</option>";
	                                }
	                                ?>
	                            </select>
                                <div class="invalid-feedback">
                                    Please select a Classification.
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="meter_size_id_<?php echo $price_matrix_id; ?>">Meter Size</label>
                            </div>
                            <div class="col-12">
                                <select class="form-control custom-select" name="meter_size_id" id="meter_size_id_<?php echo $price_matrix_id; ?>" required>
	                                <option value="" selected disabled>Select Meter Size</option>
	                                <?php
	                                $sqlFetchActType = "SELECT * FROM meter_size_settings WHERE deleted = 0";
	                                $resultFetchActType = $con->query($sqlFetchActType);

	                                if ($resultFetchActType->num_rows > 0) {
	                                    while ($rowFetchActType = $resultFetchActType->fetch_assoc()) {
	                                        $meter_size_id = $rowFetchActType['meter_size_id'];
	                                        $meter_size = $rowFetchActType['meter_size'];
	                                        
	                                        $selected = ($meter_size_id == $meter_size_id_selected) ? 'selected' : '';

	                                        echo "<option value='$meter_size_id' $selected>$meter_size</option>";
	                                    }
	                                } else {
	                                     echo "<option value='none' selected disabled>No Meter Size available</option>";
	                                }
	                                ?>
	                            </select>
                                <div class="invalid-feedback">
                                    Please select a valid Meter Size.
                                </div>
                            </div>
                        </div>

                         <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="price_per_cubic_meter_<?php echo $price_matrix_id; ?>">Minimum Price (1 - 10 Cubic Meters)</label>
                            </div>
                            <div class="col-12">
                                <input type="number" id="price_per_cubic_meter_<?php echo $price_matrix_id; ?>" name="price_per_cubic_meter" class="form-control" value="<?php echo $price_per_cubic_meter; ?>" required>
	                            <div class="invalid-feedback">
	                                Please input a valid Minimum Price.
	                            </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-primary" id="updatePriceMatrix_<?php echo $price_matrix_id; ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
   