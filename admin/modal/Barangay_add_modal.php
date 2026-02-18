<div class="modal fade" id="addNew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Add Barangay</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form>
                <div class="modal-body">

                    <!-- Barangay -->
                    <div class="form-group">
                        <label>Barangay</label>
                        <input type="text" name="barangay" class="form-control" required>
                    </div>

                    <!-- Zone -->
                    <div class="form-group">
                        <label>Zone</label>
                        <select name="zonebook_id" class="form-control" required>
                            <option value="">Select Zone</option>
                            <?php
                            $zoneQuery = mysqli_query($con, "
                                SELECT * FROM zonebook_settings 
                                WHERE deleted = 0
                            ");
                            while($z = mysqli_fetch_assoc($zoneQuery)){
                                echo "<option value='{$z['zonebook_id']}'>{$z['zonebook']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Municipality -->
                    <div class="form-group">
                        <label>Municipality</label>
                        <select name="citytownmunicipality_id" class="form-control" required>
                            <option value="">Select Municipality</option>
                            <?php
                            $res = mysqli_query($con, "
                                SELECT * FROM citytownmunicipality_settings 
                                WHERE deleted = 0
                            ");
                            while($m = mysqli_fetch_assoc($res)){
                                echo "<option value='{$m['citytownmunicipality_id']}'>{$m['citytownmunicipality']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" id="addBarangay">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
