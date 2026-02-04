<!-- Add -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-success" id="myModalLabel">
                        <i class="fas fa-plus fa-sm"></i> Add New Zone/Book
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
                            <label class="control-label modal-label" for="zonebook">Zone/Book</label>
                            <input class="form-control" id="zonebook" name="zonebook" type="text" required>
                            <div class="invalid-feedback">
                                Please input a valid zone/book.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="zonebook_remarks">Zone/Book Remarks</label>
                            <textarea id="zonebook_remarks" name="zonebook_remarks" class="form-control" required></textarea>
                            <div class="invalid-feedback">
                                Please input a valid remarks.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer col-12 px-4">
                    <button type="button" class="btn btn-outline-secondary col-12 col-sm-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-success col-12 col-sm-3" id="addZoneBook">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
