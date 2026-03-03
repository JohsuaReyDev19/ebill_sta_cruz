<!-- ZoneBook List Modal (Small Size) -->
<div class="modal fade" id="zonebookListModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <!-- modal-lg = smaller than xl, scrollable -->

        <div class="modal-content shadow-lg rounded-3">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-book mr-2"></i> Zone/Book List
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-4">

                <!-- Top Buttons -->
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-success shadow-sm" data-toggle="modal" data-target="#addZonebookModal">
                        <i class="fas fa-plus mr-1"></i> Add Zone/Book
                    </button>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="zonebookTable" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Zone/Book</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require '../db/dbconn.php';
                            $sql = "SELECT * FROM zonebook_settings WHERE deleted=0 ORDER BY zonebook ASC";
                            $result = mysqli_query($con, $sql);
                            $counter = 1;
                            while($row = mysqli_fetch_assoc($result)):
                                $zonebook_id = $row['zonebook_id'];
                                $zonebook = htmlspecialchars($row['zonebook'], ENT_QUOTES);
                                $remarks = htmlspecialchars($row['zonebook_remarks'], ENT_QUOTES);
                            ?>
                            <tr id="row_<?= $zonebook_id ?>">
                                <td><?= $counter++; ?></td>
                                <td><?= $zonebook ?></td>
                                <td><?= $remarks ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary editZonebookBtn" 
                                        data-id="<?= $zonebook_id ?>" 
                                        data-name="<?= $zonebook ?>" 
                                        data-remarks="<?= $remarks ?>" 
                                        data-toggle="modal" 
                                        data-target="#editZonebookModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger deleteZonebookBtn" 
                                        data-id="<?= $zonebook_id ?>" 
                                        data-name="<?= $zonebook ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addZonebookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">
            <form id="addZonebookForm">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-plus mr-1"></i> Add Zone/Book</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="form-group">
                        <label>Zone/Book Name</label>
                        <input type="text" name="zonebook" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" name="zonebook_remarks" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editZonebookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">
            <form id="editZonebookForm">
                <input type="hidden" name="zonebook_id" id="editZonebookId">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Edit Zone/Book</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="form-group">
                        <label>Zone/Book Name</label>
                        <input type="text" name="zonebook" id="editZonebookName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" name="zonebook_remarks" id="editZonebookRemarks" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>