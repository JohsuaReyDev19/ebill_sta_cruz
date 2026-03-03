<div class="modal fade" id="edit_<?= $barangay_id ?>" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <!-- modal-lg = wider, scrollable body -->

        <div class="modal-content shadow rounded-3">

            <form id="updateForm_<?= $barangay_id ?>">

                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">
                        <i class="fa-solid fa-edit mr-2"></i>
                        Edit Zones for <?= htmlspecialchars($barangay, ENT_QUOTES) ?>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 py-4">

                    <input type="hidden" name="barangay_id" value="<?= $barangay_id ?>">

                    <!-- Hidden Barangay Name (optional) -->
                    <div class="form-group" hidden>
                        <label>Barangay</label>
                        <input type="text"
                               name="barangay"
                               value="<?= htmlspecialchars($barangay, ENT_QUOTES) ?>"
                               class="form-control"
                               required>
                    </div>

                    <?php
                    $assignedZones = [];
                    $getZones = mysqli_query($con, "
                        SELECT zonebook_id 
                        FROM zonebook_barangay 
                        WHERE barangay_id = '$barangay_id' 
                        AND deleted = 0
                    ");
                    while($az = mysqli_fetch_assoc($getZones)){
                        $assignedZones[] = $az['zonebook_id'];
                    }
                    ?>

                    <!-- Zone Multi-Select -->
                    <div class="form-group">
                        <label class="font-weight-bold mb-2">Select Zone(s)</label>
                        <select name="zonebook_id[]" 
                                class="form-control zone-select"
                                multiple 
                                required 
                                style="min-height: 200px;"> 
                            <!-- taller select for better UX -->

                            <?php
                            $zoneQuery = mysqli_query($con, "
                                SELECT * FROM zonebook_settings 
                                WHERE deleted = 0
                                ORDER BY zonebook ASC
                            ");

                            while($z = mysqli_fetch_assoc($zoneQuery)){
                                $selected = in_array($z['zonebook_id'], $assignedZones) ? 'selected' : '';
                                echo '<option value="'.htmlspecialchars($z['zonebook_id']).'" '.$selected.'>'
                                        .htmlspecialchars($z['zonebook'], ENT_QUOTES).
                                     '</option>';
                            }
                            ?>
                        </select>
                        <small class="text-muted">You can search and select multiple zones.</small>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-primary" id="updateBarangay_<?= $barangay_id ?>">
                        <i class="fa-solid fa-save mr-1"></i> Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>