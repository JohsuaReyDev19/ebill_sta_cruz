<!-- Add -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-success" id="myModalLabel">
                        <i class="fas fa-plus fa-sm"></i> Add New Billing Schedule
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
                            <label class="control-label modal-label" for="reading_date">Reading Date</label>
                            <input class="form-control" id="reading_date" name="reading_date" type="date" required>
                            <div class="invalid-feedback">
                                Please input a valid reading date.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="date_covered_from">Date Covered From</label>
                            <input type="date" id="date_covered_from" name="date_covered_from" class="form-control" required>
                            <div class="invalid-feedback">
                                Please input a valid date.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="date_covered_to">Date Covered To</label>
                            <input type="date" id="date_covered_to" name="date_covered_to" class="form-control" required>
                            <div class="invalid-feedback">
                                Please input a valid date.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="date_due">Due Date</label>
                            <input type="date" id="date_due" name="date_due" class="form-control" required>
                            <div class="invalid-feedback">
                                Please input a valid due date.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="date_disconnection">Disconnection Date</label>
                            <input type="date" id="date_disconnection" name="date_disconnection" class="form-control" required>
                            <div class="invalid-feedback">
                                Please input a valid disconnection date.
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="date_disconnection">Zone Book</label>
                            <select class="form-control"
                                    name="zonebook_id"
                                    id="zonebook_id"
                                    required>
                                    
                                <option value="" selected disabled>Select zone/book</option>
                                <?php
                                    require '../db/dbconn.php';

                                    $query = "SELECT zonebook_id, zonebook 
                                            FROM zonebook_settings 
                                            WHERE deleted = 0 
                                            ORDER BY zonebook ASC";

                                    $result = mysqli_query($con, $query);

                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="'.htmlspecialchars($row['zonebook']).'">'
                                                    . htmlspecialchars($row['zonebook']) .
                                                '</option>';
                                        }
                                    }
                                ?>
                                <option value="0">Accounts with no Zone/Book Assigned</option>

                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer col-12 px-4">
                    <button type="button" class="btn btn-outline-secondary col-12 col-sm-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-success col-12 col-sm-3" id="addBillingSchedule">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
