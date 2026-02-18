<!-- Add -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-success" id="myModalLabel">
                        <i class="fas fa-plus fa-sm"></i> Add New Meter Size
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
                            <label class="control-label modal-label" for="meter_size">Meter Size</label>
                            <input class="form-control" id="meter_size" name="meter_size" type="text" required>
                            <div class="invalid-feedback">
                                Please input a valid Meter Size.
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="meter_brand">Meter Brand</label>
                            <select name="meter_brand" id="meter_brand_id" class="form-control mt-2" required>
                                <option value="" selected disabled>Select Meter Brand</option>
                                <?php
                                require '../db/dbconn.php';

                                // Fetch meter brands
                                $query = "SELECT meter_brand_id, meter_brand 
                                        FROM meter_brand_settings 
                                        WHERE deleted = 0 
                                        ORDER BY meter_brand ASC";
                                $result = mysqli_query($con, $query);

                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="'. htmlspecialchars($row['meter_brand']) .'">' 
                                            . htmlspecialchars($row['meter_brand']) 
                                            . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="unit_price">Unit Price</label>
                            <input class="form-control" id="unit_price" name="unit_price" type="number" required>
                            <div class="invalid-feedback">
                                Please input a valid Unit Price.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="meter_size_remarks">Meter Size Remarks</label>
                            <textarea id="meter_size_remarks" name="meter_size_remarks" class="form-control"></textarea>
                            <div class="invalid-feedback">
                                Please input a valid Meter Size remarks.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer col-12 px-4">
                    <button type="button" class="btn btn-outline-secondary col-12 col-sm-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-success col-12 col-sm-3" id="addMeterSize">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
