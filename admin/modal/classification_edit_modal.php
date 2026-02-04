<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $classification_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $classification_id; ?>" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-primary" id="myModalLabel_<?php echo $classification_id; ?>">
                        <i class="fas fa-pen-to-square fa-sm"></i> Edit Classification
                    </h4>
                </div>
                <div class="row float-right mr-2"><button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            </div>
            <form method="POST" id="updateForm_<?php echo $classification_id; ?>">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" name="classification_id" value="<?php echo $classification_id; ?>" required>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="classification_<?php echo $classification_id; ?>">Classification</label>
                            </div>
                            <div class="col-12">
                                <input class="form-control" id="classification_<?php echo $classification_id; ?>" name="classification" type="text" required value="<?php echo $classification; ?>">
                                <div class="invalid-feedback">
                                    Please input a valid Classification.
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="classification_remarks_<?php echo $classification_id; ?>">Classification Remarks</label>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" id="classification_remarks_<?php echo $classification_id; ?>" name="classification_remarks"><?php echo $classification_remarks; ?></textarea>
                                <div class="invalid-feedback">
                                    Please input a valid Classification Remarks.
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-primary" id="updateClassification_<?php echo $classification_id; ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
   