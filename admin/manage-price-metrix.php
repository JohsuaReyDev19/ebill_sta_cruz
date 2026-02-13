<?php
ob_start();
session_start();
require '../db/dbconn.php';

// =======================
// Handle Delete Price Matrix
// =======================
if (isset($_GET['delete_id'])) {
    $delete_id = (int) $_GET['delete_id'];

    $stmt = $con->prepare("DELETE FROM manage_price_matrix WHERE price_matrix_id=?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $_SESSION['flash_success'] = "Price Matrix deleted successfully!";
    } else {
        $_SESSION['flash_error'] = "Error deleting price matrix.";
    }

    $stmt->close();
    header("Location: manage-price-metrix.php");
    exit;
}

// =======================
// Handle Add Price Matrix
// =======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['classification_id']) && !isset($_POST['update_price_matrix'])) {
    $classification_id = $_POST['classification_id'];
    $minimum_price     = $_POST['minimum_price'];
    $meter_size_id     = $_POST['meter_size_id'];
    $charge_0          = $_POST['charge_0'];
    $charge_1          = $_POST['charge_1'];
    $charge_2          = $_POST['charge_2'];
    $charge_3          = $_POST['charge_3'];
    $charge_4          = $_POST['charge_4'];
    $charge_5          = $_POST['charge_5'];

    $size_name = $con->query("SELECT meter_size FROM meter_size_settings WHERE meter_size_id='$meter_size_id'")
        ->fetch_assoc()['meter_size'] ?? '';

    $classification_name = $con->query("SELECT classification FROM classification_settings WHERE classification_id='$classification_id'")
        ->fetch_assoc()['classification'] ?? '';

        $code = 0;
    if($classification_name == "RESIDENTIAL" || $classification_name == "GOVERNMENT"){
        $code = 1;
    }elseif($classification_name == "COMMERCIAL C"){
        $code = 2;
    }elseif($classification_name == "COMMERCIAL B"){
        $code = 3;
    }elseif($classification_name == "COMMERCIAL A"){
        $code = 4;
    }elseif($classification_name == "COMMERCIAL / INDUSTRIAL"){
        $code = 5;
    }

    // Check for duplicates
    $check_stmt = $con->prepare(
        "SELECT price_matrix_id FROM manage_price_matrix WHERE classification=? AND meter_size=?"
    );
    $check_stmt->bind_param("ss", $classification_name, $size_name);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION['flash_error'] = "This classification with the selected meter size already exists!";
    } else {
        $stmt = $con->prepare(
            "INSERT INTO manage_price_matrix
            (classification, minimum_price, meter_size, charge_0,
             charge_11_20, charge_21_30, charge_31_40,
             charge_41_50, charge_51_up)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sdsdddddd",
            $classification_name,
            $minimum_price,
            $size_name,
            $charge_0,
            $charge_1,
            $charge_2,
            $charge_3,
            $charge_4,
            $charge_5
        );

        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Price Matrix added successfully!";
        } else {
            $_SESSION['flash_error'] = "Error adding price matrix.";
        }

        $stmt->close();
    }

    $check_stmt->close();
    header("Location: manage-price-metrix.php");
    exit;
}

// =======================
// Handle Update Price Matrix
// =======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_price_matrix'])) {
    $id                = $_POST['price_matrix_id'];
    $classification_id = $_POST['classification_id'];
    $minimum_price     = $_POST['minimum_price'];
    $meter_size_id     = $_POST['meter_size_id'];
    $charge_0          = $_POST['charge_0'];
    $charge_1          = $_POST['charge_1'];
    $charge_2          = $_POST['charge_2'];
    $charge_3          = $_POST['charge_3'];
    $charge_4          = $_POST['charge_4'];
    $charge_5          = $_POST['charge_5'];

    $size_name = $con->query("SELECT meter_size FROM meter_size_settings WHERE meter_size_id='$meter_size_id'")
        ->fetch_assoc()['meter_size'] ?? '';

    $classification_name = $con->query("SELECT classification FROM classification_settings WHERE classification_id='$classification_id'")
        ->fetch_assoc()['classification'] ?? '';

    $stmt = $con->prepare(
        "UPDATE manage_price_matrix SET
        classification=?, minimum_price=?, meter_size=?,
        charge_0=?,
        charge_11_20=?, charge_21_30=?, charge_31_40=?,
        charge_41_50=?, charge_51_up=?
        WHERE price_matrix_id=?"
    );

    $stmt->bind_param(
        "sdsddddddi",
        $classification_name,
        $minimum_price,
        $size_name,
        $charge_0,
        $charge_1,
        $charge_2,
        $charge_3,
        $charge_4,
        $charge_5,
        $id
    );

    if ($stmt->execute()) {
        $_SESSION['flash_success'] = "Price Matrix updated successfully!";
    } else {
        $_SESSION['flash_error'] = "Error updating price matrix.";
    }

    $stmt->close();
    header("Location: manage-price-metrix.php");
    exit;
}

// =======================
// Fetch data
// =======================
$classification_data = $con->query(
    "SELECT classification_id, classification FROM classification_settings WHERE deleted=0"
)->fetch_all(MYSQLI_ASSOC);

$meter_size_data = $con->query(
    "SELECT meter_size_id, meter_size FROM meter_size_settings WHERE deleted=0"
)->fetch_all(MYSQLI_ASSOC);

$price_matrix_result = $con->query(
    "SELECT * FROM manage_price_matrix ORDER BY price_matrix_id ASC"
);
?>

<!DOCTYPE html>
<html lang="en">
<?php include './include/head.php'; ?>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <?php include './include/sidebar.php'; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php include './include/topbar.php'; ?>

            <div class="container-fluid">
                <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-tags fa-sm mr-2"></i>Manage Price Matrix</h1>
                </div> -->

                <?php if(isset($_SESSION['flash_success'])): ?>
                    <div class="alert alert-success" id="flashMessage">
                        <?= $_SESSION['flash_success']; ?>
                    </div>
                    <?php unset($_SESSION['flash_success']); ?>
                <?php elseif(isset($_SESSION['flash_error'])): ?>
                    <div class="alert alert-danger" id="flashMessage">
                        <?= $_SESSION['flash_error']; ?>
                    </div>
                    <?php unset($_SESSION['flash_error']); ?>
                <?php endif; ?>

                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-column flex-md-row">
                                <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                    <h6 class="font-weight-bold text-primary mb-0">List of Price Matrix</h6>
                                </div>
                                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                    <div class="col-12 col-md-4 float-right mx-0 px-0">
                                        <a data-toggle="modal" data-target="#addNew" class="btn btn-success shadow-sm w-100 h-100">
                                            <i class="fa-solid fa-plus mr-1"></i>Add Price Matrix
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered nowrap" id="myTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center align-middle">#</th>
                                                <th rowspan="2" class="text-center align-middle">Classification</th>
                                                <th rowspan="2" class="text-center align-middle">Minimum Price</th>
                                                <th rowspan="2" class="text-center align-middle">Meter Size</th>
                                                <th colspan="6" class="text-center">Commodity Charges</th>
                                                <th rowspan="2" class="text-center align-middle">Action</th>
                                            </tr>
                                            <tr style="font-size: 8px; color: black;">
                                                <th class="text-center">1-10</th>
                                                <th class="text-center">11-20</th>
                                                <th class="text-center">21-30</th>
                                                <th class="text-center">31-40</th>
                                                <th class="text-center">41-50</th>
                                                <th class="text-center">51 up</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php if($price_matrix_result->num_rows > 0): ?>
                                                <?php $count = 1; ?>
                                                <?php while($row = $price_matrix_result->fetch_assoc()): ?>
                                                    <tr class="text-center" style="font-size: small; color: black;">
                                                        <td><?= $count++; ?></td>
                                                        <td><?= htmlspecialchars($row['classification']); ?></td>
                                                        <td><?= number_format($row['minimum_price'], 2); ?></td>
                                                        <td><?= htmlspecialchars($row['meter_size']); ?></td>
                                                        <td><?= number_format($row['charge_0'], 2); ?></td>
                                                        <td><?= number_format($row['charge_11_20'], 2); ?></td>
                                                        <td><?= number_format($row['charge_21_30'], 2); ?></td>
                                                        <td><?= number_format($row['charge_31_40'], 2); ?></td>
                                                        <td><?= number_format($row['charge_41_50'], 2); ?></td>
                                                        <td><?= number_format($row['charge_51_up'], 2); ?></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary edit-btn" 
                                                                data-id="<?= $row['price_matrix_id']; ?>"
                                                                data-classification="<?= htmlspecialchars($row['classification']); ?>"
                                                                data-minimum="<?= $row['minimum_price']; ?>"
                                                                data-metersize="<?= htmlspecialchars($row['meter_size']); ?>"
                                                                data-charge0="<?= $row['charge_0']; ?>"
                                                                data-charge1="<?= $row['charge_11_20']; ?>"
                                                                data-charge2="<?= $row['charge_21_30']; ?>"
                                                                data-charge3="<?= $row['charge_31_40']; ?>"
                                                                data-charge4="<?= $row['charge_41_50']; ?>"
                                                                data-charge5="<?= $row['charge_51_up']; ?>"
                                                            ><i class="fa-solid fa-edit"></i></button>

                                                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $row['price_matrix_id']; ?>">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr class="text-center">
                                                    <td colspan="10">No price matrix found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Price Matrix Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa-solid fa-edit mr-2"></i>Edit Price Matrix</h5>
                <button type="button" class="close text-white" id="editCancelBtn" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editPriceMatrixForm" method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" name="price_matrix_id" id="edit_price_matrix_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Classification</label>
                            <select name="classification_id" id="edit_classification_id" class="form-control" required>
                                <?php foreach($classification_data as $row): ?>
                                    <option value="<?= $row['classification_id']; ?>"><?= htmlspecialchars($row['classification']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Meter Size</label>
                            <select name="meter_size_id" id="edit_meter_size_id" class="form-control" required>
                                <?php foreach($meter_size_data as $row): ?>
                                    <option value="<?= $row['meter_size_id']; ?>"><?= htmlspecialchars($row['meter_size']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Minimum Price</label>
                            <input type="number" step="0.01" name="minimum_price" id="edit_minimum_price" class="form-control" required>
                        </div>

                        <div class="col-md-12"><hr></div>

                        <div class="col-md-12 text-center">
                            <p class="font-weight-bold text-primary">Commodity Charges</p>
                        </div>

                        <div class="col-md-12"><hr></div>
                        <div class="col-md-4 mb-3">
                            <label>0-10 cu.m.</label>
                            <input type="number" step="0.01" name="charge_0" id="edit_charge_0" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>11-20 cu.m.</label>
                            <input type="number" step="0.01" name="charge_1" id="edit_charge_1" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>21-30 cu.m.</label>
                            <input type="number" step="0.01" name="charge_2" id="edit_charge_2" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>31-40 cu.m.</label>
                            <input type="number" step="0.01" name="charge_3" id="edit_charge_3" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>41-50 cu.m.</label>
                            <input type="number" step="0.01" name="charge_4" id="edit_charge_4" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>51 up cu.m.</label>
                            <input type="number" step="0.01" name="charge_5" id="edit_charge_5" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="editCancelBtn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_price_matrix" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

                <!-- Add Price Matrix Modal -->
                <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="addNewLabel">
                                    <i class="fa-solid fa-tags mr-2"></i>Add Price Matrix
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <form id="addPriceMatrixForm" method="POST" action="">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Classification</label>
                                            <select name="classification_id" class="form-control" required>
                                                <option value="">-- Select Classification --</option>
                                                <?php foreach($classification_data as $row): ?>
                                                    <option value="<?= $row['classification_id']; ?>"><?= htmlspecialchars($row['classification']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Meter Size</label>
                                            <select name="meter_size_id" class="form-control" required>
                                                <option value="">-- Select Meter Size --</option>
                                                <?php foreach($meter_size_data as $row): ?>
                                                    <option value="<?= $row['meter_size_id']; ?>"><?= htmlspecialchars($row['meter_size']); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="font-weight-bold">0-10 cu.m. (Minimum Price) </label>
                                            <input type="number" step="0.01" name="minimum_price" class="form-control" required>
                                        </div>



                                        <div class="col-md-12"><hr></div>
                                        <div class="col-md-12 text-center">
                                            <p class="font-weight-bold text-primary">Commodity Charges</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>0-10 cu.m.</label>
                                            <input type="number" step="0.01" name="charge_0" class="form-control" value="10" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>11-20 cu.m.</label>
                                            <input type="number" step="0.01" name="charge_1" class="form-control" value="18.15" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>21-30 cu.m.</label>
                                            <input type="number" step="0.01" name="charge_2" class="form-control" value="19.40" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>31-40 cu.m.</label>
                                            <input type="number" step="0.01" name="charge_3" class="form-control" value="20.65" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>41-50 cu.m.</label>
                                            <input type="number" step="0.01" name="charge_4" class="form-control" value="22.00" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>51 up cu.m.</label>
                                            <input type="number" step="0.01" name="charge_5" class="form-control" value="23.45" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-save mr-1"></i>Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div> <!-- content -->

        <?php include './include/footer.php'; ?>
    </div> <!-- content-wrapper -->
</div> <!-- wrapper -->

<?php include './include/script.php'; ?>

<script>
    // Wait 3 seconds and fade out alerts
    setTimeout(function() {
        const flash = document.getElementById('flashMessage');
        if(flash) {
            flash.style.transition = 'opacity 0.5s ease-out';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }
    }, 3000);
</script>

<script>
$(document).ready(function() {

    // Use delegated event (important for dynamic rows like DataTables)
    $(document).on('click', '.edit-btn', function() {

        const id = $(this).data('id');
        const classification = ($(this).data('classification') || '').toString().trim();
        const minimum = $(this).data('minimum');
        const metersize = ($(this).data('metersize') || '').toString().trim();
        const charge0 = $(this).data('charge0');
        const charge1 = $(this).data('charge1');
        const charge2 = $(this).data('charge2');
        const charge3 = $(this).data('charge3');
        const charge4 = $(this).data('charge4');
        const charge5 = $(this).data('charge5');

        // Set basic values
        $('#edit_price_matrix_id').val(id);
        $('#edit_minimum_price').val(minimum);
        $('#edit_charge_0').val(charge0);
        $('#edit_charge_1').val(charge1);
        $('#edit_charge_2').val(charge2);
        $('#edit_charge_3').val(charge3);
        $('#edit_charge_4').val(charge4);
        $('#edit_charge_5').val(charge5);

        // Safer classification matching (trim + case insensitive)
        $('#edit_classification_id option').each(function() {
            if ($(this).text().trim().toLowerCase() === classification.toLowerCase()) {
                $(this).prop('selected', true);
            }
        });

        // Better meter size + brand handling
        if (metersize !== '') {

            // Example: "10mm BrandX"
            const lastSpaceIndex = metersize.lastIndexOf(" ");

            let sizePart = metersize;
            let brandPart = "";

            if (lastSpaceIndex !== -1) {
                sizePart = metersize.substring(0, lastSpaceIndex).trim();
                brandPart = metersize.substring(lastSpaceIndex + 1).trim();
            }

            // Match size
            $('#edit_meter_size_id option').each(function() {
                if ($(this).text().trim().toLowerCase() === sizePart.toLowerCase()) {
                    $(this).prop('selected', true);
                }
            });

            // Match brand
            $('#edit_meter_brand_id option').each(function() {
                if ($(this).text().trim().toLowerCase() === brandPart.toLowerCase()) {
                    $(this).prop('selected', true);
                }
            });
        }

        $('#editModal').modal('show');
    });

});
</script>



<script>
$(document).ready(function() {
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to your PHP delete page
                window.location.href = "manage-price-metrix.php?delete_id=" + id;
            }
        });
    });
});

</script>

<script>
$(document).ready(function() {
    // Reset Edit Modal form when modal hides
    $('#editModal').on('hidden.bs.modal', function () {
        $('#editPriceMatrixForm')[0].reset();
    });
});
</script>



</body>
</html>

<?php ob_end_flush(); ?>
