<!-- Add -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-success" id="myModalLabel">
                        <i class="fas fa-plus fa-sm"></i> Add New Price Matrix
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
                            <label class="control-label modal-label" for="classification_id">Classification</label>
                            <select class="form-control custom-select" name="classification_id" id="classification_id" required>
                                <option value="" selected disabled>Select classification</option>
                                <?php
                                $sqlFetchActType = "SELECT * FROM classification_settings WHERE deleted = 0";
                                $resultFetchActType = $con->query($sqlFetchActType);

                                if ($resultFetchActType->num_rows > 0) {
                                    while ($rowFetchActType = $resultFetchActType->fetch_assoc()) {
                                        $classification_id = $rowFetchActType['classification_id'];
                                        $classification = $rowFetchActType['classification'];
                                        echo "<option value='$classification_id'>$classification</option>";
                                    }
                                } else {
                                    echo "<option value='none' selected disabled>No Classification available</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a Classification.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="meter_size_id">Meter Size</label>
                            <select class="form-control custom-select" name="meter_size_id" id="meter_size_id" required>
                                <option value="" selected disabled>Select Meter Size</option>
                                <?php
                                $sqlFetchActType = "SELECT * FROM meter_size_settings WHERE deleted = 0";
                                $resultFetchActType = $con->query($sqlFetchActType);

                                if ($resultFetchActType->num_rows > 0) {
                                    while ($rowFetchActType = $resultFetchActType->fetch_assoc()) {
                                        $meter_size_id = $rowFetchActType['meter_size_id'];
                                        $meter_size = $rowFetchActType['meter_size'];
                                        echo "<option value='$meter_size_id'>$meter_size</option>";
                                    }
                                } else {
                                    echo "<option value='none' selected disabled>No Meter Size available</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid Meter Size.
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label modal-label" for="price_per_cubic_meter">Minimum Price (1 - 10 Cubic Meters)</label>
                            <input type="number" id="price_per_cubic_meter" name="price_per_cubic_meter" class="form-control" required>
                            <div class="invalid-feedback">
                                Please input a valid Minimum Price.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer col-12 px-4">
                    <button type="button" class="btn btn-outline-secondary col-12 col-sm-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-success col-12 col-sm-3" id="addPriceMatrix">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
