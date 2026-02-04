<!-- Edit -->
<div class="modal fade" id="edit_<?php echo $billing_schedule_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $billing_schedule_id; ?>" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-primary" id="myModalLabel_<?php echo $billing_schedule_id; ?>">
                        <i class="fas fa-pen-to-square fa-sm"></i> Edit Billing Schedule
                    </h4>
                </div>
                <div class="row float-right mr-2"><button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            </div>
            <form method="POST" id="updateForm_<?php echo $billing_schedule_id; ?>">
                <div class="modal-body">
                    <div class="container-fluid">

                        <input type="hidden" name="billing_schedule_id" value="<?php echo $billing_schedule_id; ?>" required>

                        <div class="row form-group mb-3">
                            <label class="control-label modal-label" for="reading_date_<?php echo $billing_schedule_id; ?>">Reading Date</label>
                            <input class="form-control" id="reading_date_<?php echo $billing_schedule_id; ?>" name="reading_date" type="date" value="<?php echo $reading_date; ?>" required>
                            <div class="invalid-feedback">
                                Please input a valid reading date.
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <label class="control-label modal-label" for="date_covered_from_<?php echo $billing_schedule_id; ?>">Date Covered From</label>
                            <input type="date" id="date_covered_from_<?php echo $billing_schedule_id; ?>" name="date_covered_from" class="form-control" value="<?php echo $date_covered_from; ?>" required>
                            <div class="invalid-feedback">
                                Please input a valid date.
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <label class="control-label modal-label" for="date_covered_to_<?php echo $billing_schedule_id; ?>">Date Covered To</label>
                            <input type="date" id="date_covered_to_<?php echo $billing_schedule_id; ?>" name="date_covered_to" class="form-control" value="<?php echo $date_covered_to; ?>" required>
                            <div class="invalid-feedback">
                                Please input a valid date.
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <label class="control-label modal-label" for="date_due_<?php echo $billing_schedule_id; ?>">Due Date</label>
                            <input type="date" id="date_due_<?php echo $billing_schedule_id; ?>" name="date_due" class="form-control" value="<?php echo $date_due; ?>" required>
                            <div class="invalid-feedback">
                                Please input a valid due date.
                            </div>
                        </div>

                        <div class="row form-group mb-3">
                            <label class="control-label modal-label" for="date_disconnection_<?php echo $billing_schedule_id; ?>">Disconnection Date</label>
                            <input type="date" id="date_disconnection_<?php echo $billing_schedule_id; ?>" name="date_disconnection" class="form-control" value="<?php echo $date_disconnection; ?>" required>
                            <div class="invalid-feedback">
                                Please input a valid disconnection date.
                            </div>
                        </div>

                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-primary" id="updateBillingSchedule_<?php echo $billing_schedule_id; ?>">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
   