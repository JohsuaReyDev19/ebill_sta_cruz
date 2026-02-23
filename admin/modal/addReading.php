<div class="modal fade" id="addReading" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-success">
                    <i class="fas fa-plus"></i> Add Reading Schedule
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="POST" id="readingFormSchedule">

                <div class="modal-body">

                    <!-- ================= INPUT SECTION ================= -->
                    <div class="d-flex flex-wrap">
                        <input type="hidden" name="billing_schedule_id" id="billing_schedule_id">
                        <div class="form-group col-md-3">
                            <label>Reading Date</label>
                            <input type="date" name="reading_date" id="reading_date" class="form-control" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Covered From</label>
                            <input type="date" name="date_covered_from" id="date_covered_from" class="form-control" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Covered To</label>
                            <input type="date" name="date_covered_to" id="date_covered_to" class="form-control" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Zone Book</label>
                            <select name="zonebook_id" class="form-control" required>
                                <option value="" disabled selected>Select zone/book</option>
                                <?php
                                require '../db/dbconn.php';
                                $query = "SELECT zonebook_id, zonebook 
                                          FROM zonebook_settings 
                                          WHERE deleted = 0 
                                          ORDER BY zonebook ASC";
                                $result = mysqli_query($con, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['zonebook_id'] . '">' 
                                            . $row['zonebook'] . 
                                         '</option>';
                                }
                                ?>
                                <option value="0">Accounts with no Zone/Book Assigned</option>
                            </select>
                        </div>

                    </div>

                    <div class="text-right mb-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success btn-sm" id="addRowBtn">
                            Add to List
                        </button>
                    </div>

                    <hr>

                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-bordered table-sm text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>Reading Date</th>
                                    <th>Covered From</th>
                                    <th>Covered To</th>
                                    <th>Zone Book</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody id="readingTableBody">
                                <!-- Rows will appear here -->
                            </tbody>
                        </table>
                    </div>

                </div>  
            </form>

        </div>
    </div>
</div>
