<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $service_status_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $service_status_id; ?>" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-primary" id="myModalLabel_<?php echo $service_status_id; ?>">
                        <i class="fas fa-pen-to-square fa-sm"></i> Edit Service Status
                    </h4>
                </div>
                <div class="row float-right mr-2"><button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            </div>
            <form method="POST" id="updateForm_<?php echo $service_status_id; ?>">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" name="service_status_id" value="<?php echo $service_status_id; ?>" required>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="service_status_<?php echo $service_status_id; ?>">Service Status</label>
                            </div>
                            <div class="col-12">
                                <input class="form-control" id="service_status_<?php echo $service_status_id; ?>" name="service_status" type="text" required value="<?php echo $service_status; ?>">
                                <div class="invalid-feedback">
                                    Please input a valid Service Status.
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="service_status_remarks_<?php echo $service_status_id; ?>">Service Status Remarks</label>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" id="service_status_remarks_<?php echo $service_status_id; ?>" name="service_status_remarks"><?php echo $service_status_remarks; ?></textarea>
                                <div class="invalid-feedback">
                                    Please input a valid Service Status Remarks.
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-primary" id="updateServiceStatus_<?php echo $service_status_id; ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
   