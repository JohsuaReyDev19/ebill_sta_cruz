<div class="modal fade" id="edit_<?= $barangay_id ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Barangay</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form id="updateForm_<?= $barangay_id ?>">

                <div class="modal-body">

                    <input type="hidden" name="barangay_id" value="<?= $barangay_id ?>">

                    <!-- Barangay -->
                    <div class="form-group">
                        <label>Barangay</label>
                        <input type="text"
                               name="barangay"
                               value="<?= htmlspecialchars($barangay, ENT_QUOTES) ?>"
                               class="form-control"
                               required>
                    </div>

                    <!-- Zone -->
                    <div class="form-group">
                        <label>Zone</label>
                        <select name="zonebook_id" class="form-control" required>
                            <option value="">Select Zone</option>
                            <?php
                            $zoneQuery = mysqli_query($con, "SELECT * FROM zonebook_settings WHERE deleted = 0");
                            while($z = mysqli_fetch_assoc($zoneQuery)){
                                $selected = ($z['zonebook_id'] == $zonebook_id) ? 'selected' : '';
                                echo '<option value="'.htmlspecialchars($z['zonebook_id']).'" '.$selected.'>'
                                        .htmlspecialchars($z['zonebook'], ENT_QUOTES).
                                     '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Municipality -->
                    <div class="form-group">
                        <label>Municipality</label>
                        <select class="form-control" name="zonebook_id" id="zonebook_id_<?php echo $billing_schedule_id; ?>" required>
                            <option value="" disabled>Select zone/book</option>
                            <option value="0" <?php if($zonebook_id == 0) echo 'selected'; ?>>Accounts with no Zone/Book Assigned</option>

                            <?php
                                $zoneQuery = mysqli_query($con, "SELECT * FROM zonebook_settings WHERE deleted = 0 ORDER BY zonebook ASC");
                                while($z = mysqli_fetch_assoc($zoneQuery)){
                                    $selected = ($z['zonebook_id'] == $zonebook_id) ? 'selected' : '';
                                    echo "<option value='{$z['zonebook_id']}' $selected>{$z['zonebook']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary"
                            id="updateBarangay_<?= $barangay_id ?>">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
