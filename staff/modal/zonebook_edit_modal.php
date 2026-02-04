<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $zonebook_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $zonebook_id; ?>" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-primary" id="myModalLabel_<?php echo $zonebook_id; ?>">
                        <i class="fas fa-pen-to-square fa-sm"></i> Edit Zone/Book
                    </h4>
                </div>
                <div class="row float-right mr-2"><button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            </div>
            <form method="POST" id="updateForm_<?php echo $zonebook_id; ?>">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" name="zonebook_id" value="<?php echo $zonebook_id; ?>" required>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="zonebook_<?php echo $zonebook_id; ?>">Zone/Book</label>
                            </div>
                            <div class="col-12">
                                <input class="form-control" id="zonebook_<?php echo $zonebook_id; ?>" name="zonebook" type="text" required value="<?php echo $zonebook; ?>">
                                <div class="invalid-feedback">
                                    Please input a valid Zone/Book.
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <div class="col-12">
                                <label class="control-label modal-label" for="zonebook_remarks_<?php echo $zonebook_id; ?>">Zone/Book Remarks</label>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" id="zonebook_remarks_<?php echo $zonebook_id; ?>" name="zonebook_remarks" required><?php echo $zonebook_remarks; ?></textarea>
                                <div class="invalid-feedback">
                                    Please input a valid Zone/Book Remarks.
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-primary" id="updateZoneBook_<?php echo $zonebook_id; ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
   