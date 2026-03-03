<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="zonebook-settings"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include './include/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './include/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-chart-area fa-sm mr-2"></i>Zone/Book Settings</h1>
                    </div>

                    <hr> -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center">

                                    <!-- Title -->
                                    <div class="col-12 col-md-6 d-flex align-items-center px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">
                                            List of Barangay
                                        </h6>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-12 col-md-6 d-flex justify-content-md-end px-0">
                                        <div class="d-flex gap-2">

                                            <button class="btn btn-secondary mr-2" data-toggle="modal" data-target="#zonebookListModal">
                                                View ZoneBook
                                            </button>

                                            <a data-toggle="modal"
                                            data-target="#addNew"
                                            class="btn btn-success shadow-sm">
                                                <i class="fa-solid fa-plus mr-1"></i>
                                                Add Barangay
                                            </a>

                                        </div>
                                    </div>

                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered nowrap" id="myTable" width="100%" cellspacing="0">
                                            <thead class="">
                                                <tr>
                                                  
                                                    <th scope="col">#</th>                                        
                                                    <th scope="col">Barangay</th>
                                                    <th scope="col">Zone</th>                                              
                                                    <th scope="col">Action</th>                             
                                                   
                                                </tr>
                                            </thead>
                                            
                                            <tbody>

                                            <?php
                                                require '../db/dbconn.php';

                                                $display_barangay = "
                                                    SELECT 
                                                        b.barangay_id,
                                                        b.barangay,
                                                        COALESCE(GROUP_CONCAT(DISTINCT z.zonebook ORDER BY z.zonebook SEPARATOR ', '), 'No Zone') AS zones,
                                                        m.citytownmunicipality
                                                    FROM barangay_settings b

                                                    LEFT JOIN zonebook_barangay zb 
                                                        ON b.barangay_id = zb.barangay_id
                                                        AND zb.deleted = 0

                                                    LEFT JOIN zonebook_settings z 
                                                        ON zb.zonebook_id = z.zonebook_id
                                                        AND z.deleted = 0

                                                    LEFT JOIN citytownmunicipality_settings m 
                                                        ON b.citytownmunicipality_id = m.citytownmunicipality_id
                                                        AND m.deleted = 0

                                                    WHERE b.deleted = 0
                                                    GROUP BY b.barangay_id, b.barangay, m.citytownmunicipality
                                                ";

                                                $sqlQuery = mysqli_query($con, $display_barangay) or die(mysqli_error($con));

                                                $counter = 1;

                                                while($row = mysqli_fetch_assoc($sqlQuery)) {

                                                    $barangay_id = $row['barangay_id'];
                                                    $barangay = $row['barangay'];
                                                    $zone = $row['zones']; // ✅ FIXED HERE
                                                    $municipality = $row['citytownmunicipality'];
                                                ?>
                                                <tr style="color: black;">
                                                    <td><?= $counter++; ?></td>
                                                    <td><?= htmlspecialchars($barangay); ?></td>
                                                    <td><?= htmlspecialchars($zone); ?></td>
                                                    <td>
                                                        <button class="btn btn-success btn-sm add-zone-btn"
                                                            data-id="<?= $barangay_id ?>"
                                                            data-name="<?= htmlspecialchars($barangay); ?>"
                                                            data-toggle="modal"
                                                            data-target="#addZoneModal">
                                                            Add Zone
                                                        </button>

                                                        <button class="btn btn-primary btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#edit_<?= $barangay_id ?>">
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-danger btn-sm delete-Barangay-btn"
                                                            data-barangay-id="<?= $barangay_id ?>"
                                                            data-barangay-name="<?= $barangay ?>"
                                                            data-barangay-remarks="<?= $municipality ?>">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <?php
                                                include('modal/Barangay_edit_modal.php');
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include('modal/Barangay_add_modal.php'); ?>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include './include/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <div class="modal fade" id="addZoneModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="addZoneForm">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Zone to Barangay</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="barangay_id" id="modal_barangay_id">
                    <div class="form-group">
                        <label>Select Zone(s)</label>
                        <select name="zonebook_id[]" class="form-control" multiple required>
                            <?php
                            $zones = mysqli_query($con, "SELECT * FROM zonebook_settings WHERE deleted = 0");
                            while($z = mysqli_fetch_assoc($zones)){
                                echo '<option value="'.$z['zonebook_id'].'">'.htmlspecialchars($z['zonebook']).'</option>';
                            }
                            ?>
                        </select>
                        <small class="text-muted">You can select multiple zones using holding CTR.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

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

<div class="modal fade" id="addZonebookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">
            <form id="addZonebookForm">

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus mr-1"></i> Add Zone/Book
                    </h5>
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



    <!-- Zone/Book List Modal -->
        <div class="modal fade" id="zonebookListModal" tabindex="-1" role="dialog" aria-labelledby="zonebookListLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document"> <!-- modal-xl for large table -->
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold text-primary" id="zonebookListLabel">
                            List of Zone/Book
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <!-- Top Buttons -->
                        <div class="d-flex justify-content-end mb-3">
                            <a href="manage-barangay.php?title=Manage Barangay" 
                            class="btn btn-secondary shadow-sm mr-2">
                                <i class="fa-solid fa-arrow-left mr-2"></i>Back
                            </a>

                            <a data-toggle="modal" data-target="#addNew" 
                            class="btn btn-success shadow-sm">
                                <i class="fa-solid fa-plus mr-1"></i>Add Zone/Book
                            </a>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" id="myTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Zone/Book</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                    require '../db/dbconn.php';

                                    $display_zonebook = "SELECT * FROM zonebook_settings WHERE deleted = 0";
                                    $sqlQuery = mysqli_query($con, $display_zonebook) or die(mysqli_error($con));

                                    $counter = 1;

                                    while($row = mysqli_fetch_array($sqlQuery)) {

                                        $zonebook_id = $row['zonebook_id'];
                                        $zonebook = $row['zonebook'];
                                        $zonebook_remarks = $row['zonebook_remarks'];
                                ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo htmlspecialchars($zonebook); ?></td>
                                        <td><?php echo htmlspecialchars($zonebook_remarks); ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-primary"
                                            data-toggle="modal"
                                            data-target="#edit_<?php echo $zonebook_id; ?>">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>

                                            <a href="#"
                                            class="btn btn-sm btn-danger delete-zonebook-btn"
                                            data-zonebook-id="<?php echo $zonebook_id; ?>"
                                            data-barangay-name="<?php echo htmlspecialchars($zonebook); ?>"
                                            data-barangay-remarks="<?php echo htmlspecialchars($zonebook_remarks); ?>">
                                            <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php
                                        $counter++;
                                        include('modal/zonebook_edit_modal.php');
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include './include/logout_modal.php'; ?>

    <?php include './include/script.php'; ?>
<script>
$(document).ready(function(){

    // Add Zonebook
    $("#addZonebookForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "action/add_zonebook.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res){
                if(res.status === "success"){
                    Swal.fire("Success!", res.message, "success")
                        .then(()=> location.reload());
                } else {
                    Swal.fire("Error!", res.message, "error");
                }
            },
            error: function(xhr){
                Swal.fire("Error!", "Something went wrong. Try again.", "error");
            }
        });
    });

    // Edit Zonebook: populate modal
    $(document).on("click", ".editZonebookBtn", function(){
        $("#editZonebookId").val($(this).data("id"));
        $("#editZonebookName").val($(this).data("name"));
        $("#editZonebookRemarks").val($(this).data("remarks"));
    });

    // Update Zonebook
    $("#editZonebookForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "action/update_zonebook.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res){
                if(res.status === "success"){
                    Swal.fire("Updated!", res.message, "success")
                        .then(()=> location.reload());
                } else {
                    Swal.fire("Error!", res.message, "error");
                }
            },
            error: function(){
                Swal.fire("Error!", "Update failed. Try again.", "error");
            }
        });
    });

    // Delete Zonebook
    $(document).on("click", ".deleteZonebookBtn", function(){
        let id = $(this).data("id");
        let name = $(this).data("name");

        Swal.fire({
            title: "Are you sure?",
            text: "Delete zone: " + name + "?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result)=>{
            if(result.isConfirmed){
                $.post("action/delete_zonebook.php", {zonebook_id: id}, function(res){
                    if(res.status === "success"){
                        Swal.fire("Deleted!", res.message, "success")
                            .then(()=> location.reload());
                    } else {
                        Swal.fire("Error!", res.message, "error");
                    }
                }, "json");
            }
        });
    });

});
</script>
    <script>
        $(document).ready(function(){
            //inialize datatable
            $('#myTable').DataTable({
                scrollX: true
            })
        });

        $(document).on("click", ".add-zone-btn", function() {
            let barangayId = $(this).data("id");
            $("#modal_barangay_id").val(barangayId);
        });
    </script>


    <!-- script for add zone per barangay -->
    <script>
    $("#addZoneForm").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "action/process_addZone.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(res){
                if(res === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Added!',
                        text: res.message || 'Zone added successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // reload after success
                    });
                }
            }
        });
    });
    </script>

    <!-- Add Zone/Book-->
    <script>
        $('#zonebookListModal').on('shown.bs.modal', function () {
    $('#myTable').DataTable().columns.adjust().draw();
});
$(document).ready(function () {

    const showWarningMessage = (message) => {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: message
        });
    };

    $('#addBarangay').on('click', function (e) {
        e.preventDefault();

        const form = $('#addNew form');
        const requiredFields = form.find('[required]');
        let fieldsAreValid = true;

        // Clear validation styles
        requiredFields.removeClass('is-invalid');

        requiredFields.each(function () {
            if (!$(this).val() || $(this).val().trim() === '') {
                fieldsAreValid = false;
                $(this).addClass('is-invalid');
            }
        });

        if (!fieldsAreValid) {
            showWarningMessage('Please fill-up the required fields.');
            return;
        }

        $.ajax({
            url: 'action/add_barangay.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json', // ✅ IMPORTANT
            success: function (res) {

                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Barangay added successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => location.reload());

                } else if (res.status === 'exists') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Entry',
                        text: 'Barangay already exists!'
                    });

                } else if (res.status === 'empty') {
                    showWarningMessage('All fields are required.');

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to add Barangay',
                        text: 'Please try again later.'
                    });
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong.'
                });
            }
        });
    });

});
</script>



    <!-- Delete Zone/Book -->
    <script>
$(document).ready(function () {

    

    // Use event delegation (FIX FOR PAGINATION)
    $('#myTable').on('click', '.delete-Barangay-btn', function (e) {
        e.preventDefault();

        var deleteButton = $(this);
        var barangayID = deleteButton.data('barangay-id');
        var barangayName = decodeURIComponent(deleteButton.data('barangay-name'));
        var municipality = decodeURIComponent(deleteButton.data('barangay-remarks'));

        Swal.fire({
            title: 'Delete Barangay',
            html: "You are about to delete:<br><br>" +
                  "<strong>Barangay:</strong> " + barangayName + "<br>" +
                  "<strong>Municipality:</strong> " + municipality + "<br>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: 'action/delete_barangay.php',
                    type: 'POST',
                    data: { zonebook_id: barangayID },
                    success: function (response) {

                        if (response.trim() === 'success') {

                            Swal.fire(
                                'Deleted!',
                                'Barangay has been deleted.',
                                'success'
                            ).then(() => {

                                // REMOVE ROW WITHOUT RELOAD (better)
                                location.reload();
                                    

                            });

                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to delete Barangay.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    });

});
</script>


   <script>
$(document).ready(function() {

    const showSweetAlert = (icon, title, message) => {
        Swal.fire({
            icon: icon,
            title: title,
            text: message
        });
    };

    $(document).on('click', '[id^="updateBarangay_"]', function(e) {
        e.preventDefault();

        let userID  = $(this).attr('id').split('_')[1];
        let form    = $('#updateForm_' + userID);
        let modal   = $('#edit_' + userID);

        let fieldsAreValid = true;

        // Remove old validation styles
        modal.find('.form-control').removeClass('is-invalid');

        // Validate required fields
        modal.find(':input[required]').each(function() {

            // MULTIPLE SELECT validation
            if ($(this).is('select[multiple]')) {
                if (!$(this).val() || $(this).val().length === 0) {
                    fieldsAreValid = false;
                    $(this).addClass('is-invalid');
                }
            }

            // NORMAL SELECT validation
            else if ($(this).is('select')) {
                if (!$(this).val()) {
                    fieldsAreValid = false;
                    $(this).addClass('is-invalid');
                }
            }

            // INPUT validation
            else if ($(this).val().trim() === '') {
                fieldsAreValid = false;
                $(this).addClass('is-invalid');
            }
        });

        if (!fieldsAreValid) {
            showSweetAlert('warning', 'Oops!', 'Please fill-up the required fields.');
            return;
        }

        // AJAX SUBMIT
        $.ajax({
            url: 'action/update_Barangay.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {

                if (response.status === 'success') {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    });

                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                showSweetAlert(
                    'error',
                    'Server Error',
                    'Failed to update Barangay. Please try again later.'
                );
            }
        });

    });

});
</script>

</body>

</html>