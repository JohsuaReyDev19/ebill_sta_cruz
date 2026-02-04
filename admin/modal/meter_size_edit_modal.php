<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $meter_size_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $meter_size_id; ?>" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-primary" id="myModalLabel_<?php echo $meter_size_id; ?>">
                        <i class="fas fa-pen-to-square fa-sm"></i> Edit Meter Size
                    </h4>
                </div>
                <div class="row float-right mr-2"><button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            </div>
            <form method="POST" id="updateForm_<?php echo $meter_size_id; ?>">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" name="meter_size_id" value="<?php echo $meter_size_id; ?>" required>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="meter_size_<?php echo $meter_size_id; ?>">Meter Size</label>
                            </div>
                            <div class="col-12">
                                <input class="form-control" id="meter_size_<?php echo $meter_size_id; ?>" name="meter_size" type="text" required value="<?php echo $meter_size; ?>">
                                <div class="invalid-feedback">
                                    Please input a valid Meter Size.
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="unit_price_<?php echo $meter_size_id; ?>">Unit Price</label>
                            </div>
                            <div class="col-12">
                                <input class="form-control" id="unit_price_<?php echo $meter_size_id; ?>" name="unit_price" type="number" required value="<?php echo $unit_price; ?>">
                                <div class="invalid-feedback">
                                    Please input a valid Unit Price.
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="meter_size_remarks_<?php echo $meter_size_id; ?>">Meter Size Remarks</label>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" id="meter_size_remarks_<?php echo $meter_size_id; ?>" name="meter_size_remarks"><?php echo $meter_size_remarks; ?></textarea>
                                <div class="invalid-feedback">
                                    Please input a valid Meter Size Remarks.
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-primary" id="updateMeterSize_<?php echo $meter_size_id; ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
   