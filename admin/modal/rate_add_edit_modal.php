

<!-- Add Rate Modal -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fa fa-plus"></i> Add Discount Rate
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <form id="addRateForm">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text"
                               name="description"
                               class="form-control"
                               placeholder="Enter rate description"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Rate</label>
                        <input type="number"
                               step="0.01"
                               name="rate"
                               class="form-control"
                               placeholder="Enter rate amount"
                               required>
                        <!-- <small class="text-muted">
                            Example: 10.00 or 15.50
                        </small> -->
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button"
                            class="btn btn-success"
                            id="addRate">
                        Save Rate
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- edit modal -->

<div class="modal fade" id="editRateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Rate</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <form id="editRateForm">

                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text"
                               name="description"
                               id="edit_description"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Rate</label>
                        <input type="number"
                               step="0.01"
                               name="rate"
                               id="edit_rate"
                               class="form-control"
                               required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">Cancel</button>

                    <button type="button"
                            class="btn btn-primary"
                            id="updateRateBtn">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>