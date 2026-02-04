<!-- Add -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-success" id="myModalLabel">
                        <i class="fas fa-plus fa-sm"></i> Add New Service Status
                    </h4>
                </div>
                <div class="row float-right mr-2">
                    <button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="container-fluid">
                        
                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="service_status">Service Status</label>
                            <input class="form-control" id="service_status" name="service_status" type="text" required>
                            <div class="invalid-feedback">
                                Please input a valid service status.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="service_status_remarks">Service Status Remarks</label>
                            <textarea id="service_status_remarks" name="service_status_remarks" class="form-control"></textarea>
                            <div class="invalid-feedback">
                                Please input a valid service status remarks.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer col-12 px-4">
                    <button type="button" class="btn btn-outline-secondary col-12 col-sm-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-success col-12 col-sm-3" id="addServiceStatus">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
