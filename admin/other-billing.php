<!DOCTYPE html>
<html>          
    <?php include './include/head.php'; ?>
<body id="page-top">
    <div class="d-none" id="other-billing"></div>

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
                            <h1 class="h3 mb-0 text-primary"><i class="fas fa-receipt fa-sm mr-2"></i>Other Billing</h1>
                        </div>

                        <hr class="bg-primary"> -->
                                        
                        <!-- Content Row -->
						<div class="row d-flex align-items-stretch mb-3">
						    <div class="col-sm-12 col-12">
						        <div class="card">
						            <!-- <div class="card-header bg-primary text-white">
						                Concessionaire Information
						            </div> -->
						            <div class="card-body">
						                <div>

						                    <!-- Account Search Input -->
						                    

						                    <!-- Search/Clear Buttons -->


                                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center px-2 mb-3 gap-3">
														<!-- Label -->
														

														<!-- Buttons and Select -->
														<div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3 w-100">
															<!-- Account Select -->
															<div class="flex-grow-1 mr-2 mb-2" style="min-width: 0;">
																<select class="form-select form-select-sm border-primary w-100" id="account_number" required>
																	<!-- Options go here -->
																</select>
															</div>

															<!-- Action Buttons -->
															<div class="d-flex gap-2 flex-shrink-0 flex-wrap">
																<button class="btn btn-secondary btn-sm shadow-sm mb-2" id="clearBtn" disabled>
																	Clear
																</button>
															</div>
														</div>
													</div>




						                    <!-- Account Details -->
						                    <div class="col-sm-12 col-12 d-flex mb-2 mt-sm-2 mt-0">
                                                <div class="card flex-fill">
                                                    <div class="card-body py-2">
														<label class="form-label mb-2 d-none d-sm-block">Concessionaire Information</label>
                                                        <div class="row g-1">
                                                            
                                                            <div class="col-sm-2 col-12">
                                                                <p class="card-text text-primary m-0 small">Account Number:</p>
                                                                <span class="text-dark small" id="accountNumber"></span>
                                                            </div>

                                                            <div class="col-sm-2 col-12">
                                                                <p class="card-text text-primary m-0 small">Account Name:</p>
                                                                <span class="text-dark small" id="accountName"></span>
                                                            </div>

                                                            <div class="col-sm-2 col-12">
                                                                <p class="card-text text-primary m-0 small">Account Status:</p>
                                                                <span class="text-dark small" id="accountStatus"></span>
                                                            </div>

                                                            <div class="col-sm-2 col-12">
                                                                <p class="card-text text-primary m-0 small">Account Type:</p>
                                                                <span class="text-dark small" id="accountType"></span>
                                                            </div>

                                                            <div class="col-sm-2 col-12">
                                                                <p class="card-text text-primary m-0 small">Classification:</p>
                                                                <span class="text-dark small" id="accountClassification"></span>
                                                            </div>

                                                            <div class="col-sm-2 col-12">
                                                                <p class="card-text text-primary m-0 small">Address:</p>
                                                                <span class="text-dark small" id="accountAddress"></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
						                </div>
						            </div>
						        </div>
						    </div>
						</div>

						<!-- Other Billing Table -->
						<div class="row d-flex align-items-stretch mb-3">
						    <div class="col-sm-12 col-12">
						        <div class="card shadow-sm">

                                    <!-- Card Header -->
                                    <div class="card-header bg-primary text-white py-2">
                                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">

                                            <h6 class="mb-0 small fw-semibold">
                                                Other Billing Records
                                            </h6>

                                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 ">
                                                <button type="button" 
                                                        class="btn btn-primary"
                                                        data-toggle="modal" 
                                                        data-target="#otherChargesModal">
                                                    Add Other Charges
                                                </button>

                                                <button id="addMaterialBtn"
                                                        data-toggle="modal"
                                                        data-target="#addNewMaterials"
                                                        class="btn btn-success btn-sm shadow-sm"
                                                        disabled>
                                                    <i class="fa-solid fa-plus me-1"></i>
                                                    Additional Materials
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body p-2">

                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered text-center align-middle nowrap"
                                                id="otherBillingTable"
                                                width="100%">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Bill No</th>
                                                        <th>Description</th>
                                                        <th>Units</th>
                                                        <th>Remarks</th>
                                                        <th>Amount</th>
                                                        <th>Due Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>

						    </div>
						</div>
                    <?php include('modal/other_billing_materials_modal.php'); ?>

                <!-- Bill Modal -->
                <div class="modal fade" id="billModal" tabindex="-1" role="dialog" aria-labelledby="billModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="billModalLabel">
                                    <i class="fas fa-money-bill-wave fa-sm"></i>
                                    Other Billing
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <form id="billForm">
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Account Name: <span class="font-weight-normal text-dark" id="bill_modal_account_name"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label  font-weight-bold my-0 text-primary">Account No: <span class="font-weight-normal text-dark" id="bill_modal_account_no"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Bill No: <span class="font-weight-normal text-dark" id="bill_modal_bill_no"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Description: <span class="font-weight-normal text-dark" id="bill_modal_description"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Units Included: <span class="font-weight-normal text-dark" id="bill_modal_units_included"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Amount Due: <span class="font-weight-normal text-dark" id="bill_modal_amount_due"></span></p>
                                        </div>

                                        <hr class="my-2">

                                        <input type="hidden" name="other_billing_id" id="bill_modal_other_billing_id" required readonly>

                                        <div class="form-group">
                                            <label class="modal-label">Billing Due Date:</label>
                                            <input type="date" name="due_date" id="bill_modal_due_date" class="form-control" required>
                                            <div class="invalid-feedback">Please input a valid due date.</div>
                                        </div>

                                        <div class="form-group">
                                            <label class="modal-label">Remarks</label>
                                            <textarea name="remarks" id="bill_modal_remarks" class="form-control"></textarea>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="button" class="btn btn-primary shadow-sm" id="confirmBill">Confirm Billing</button>
                            </div>
                        </div>
                    </div>
                </div>

                                    <!-- Other Charges Modal -->
                <div class="modal fade" id="otherChargesModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Other Charges</h5>
                                <button type="button" class="close text-white" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>

                            <div class="modal-body">

                                <form id="otherChargesForm">

                                    <div class="form-check">
                                        <input class="form-check-input charge-checkbox"
                                            type="checkbox"
                                            value="120.00"
                                            id="changeName">
                                        <label class="form-check-label" for="changeName">
                                            Change Name (₱120.00)
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input charge-checkbox"
                                            type="checkbox"
                                            value="100.00"
                                            id="penalty">
                                        <label class="form-check-label" for="penalty">
                                            Penalty (₱100.00)
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input charge-checkbox"
                                            type="checkbox"
                                            value="0.20"
                                            id="pwd">
                                        <label class="form-check-label" for="pwd">
                                            PWD (20% Discount)
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input charge-checkbox"
                                            type="checkbox"
                                            value="10.00"
                                            id="reconnection">
                                        <label class="form-check-label" for="reconnection">
                                            Re-connection (₱10.00)
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input charge-checkbox"
                                            type="checkbox"
                                            value="0.20"
                                            id="senior">
                                        <label class="form-check-label" for="senior">
                                            Senior (20% Discount)
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input charge-checkbox"
                                            type="checkbox"
                                            value="10.00"
                                            id="temporaryClosed">
                                        <label class="form-check-label" for="temporaryClosed">
                                            Temporary Closed (₱10.00)
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input charge-checkbox"
                                            type="checkbox"
                                            value="0.00"
                                            id="temporaryDisconnection">
                                        <label class="form-check-label" for="temporaryDisconnection">
                                            Temporary Disconnection (No charge)
                                        </label>
                                    </div>

                                    <hr>

                                    <h5>Total: ₱<span id="totalCharge">0.00</span></h5>

                                </form>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="button" class="btn btn-primary" id="applyCharges">
                                    Apply Charges
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- View Bill Modal -->
                <div class="modal fade" id="viewBillModal" tabindex="-1" role="dialog" aria-labelledby="viewBillModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="viewBillModalLabel">
                                    <i class="fas fa-money-bill-wave fa-sm"></i>
                                    Other Billing
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Account Name: <span class="font-weight-normal text-dark" id="view_bill_modal_account_name"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label  font-weight-bold my-0 text-primary">Account No: <span class="font-weight-normal text-dark" id="view_bill_modal_account_no"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Bill No: <span class="font-weight-normal text-dark" id="view_bill_modal_bill_no"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Description: <span class="font-weight-normal text-dark" id="view_bill_modal_description"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Units Included: <span class="font-weight-normal text-dark" id="view_bill_modal_units_included"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Amount Due: <span class="font-weight-normal text-dark" id="view_bill_modal_amount_due"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Due Date: <span class="font-weight-normal text-dark" id="view_bill_modal_due_date"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Remarks: <span class="font-weight-normal text-dark" id="view_bill_modal_remarks"></span></p>
                                        </div>
                                        <div class="">
                                            <p class="modal-label font-weight-bold my-0 text-primary">Billing Status: <span class="font-weight-normal text-dark" id="view_bill_modal_billing_status"></span></p>
                                        </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
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
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include './include/logout_modal.php'; ?>

    <?php include './include/script.php'; ?>

    <script>
        $(document).ready(function () {
            // Initialize Selectize for account number input
            var selectize = $('#account_number').selectize({
                valueField: 'meters_id',
                labelField: 'label',
                searchField: ['account_no', 'account_name'],
                placeholder: 'Search Account No...',
                load: function (query, callback) {
                    if (!query.length) return callback();
                    $.ajax({
                        url: 'action/fetch_account_info.php',
                        type: 'GET',
                        dataType: 'json',
                        data: { search: query },
                        success: function (data) {
                            callback(data);
                        }
                    });
                },
                render: {
                    option: function (item, escape) {
                        return `<div id="ShowAccountInfo">${escape(item.label)}</div>`;
                    }
                }
            });

            var selectizeInstance = selectize[0].selectize;
            var fetchedResponse = null;

            // Handle Search Button Click
            let otherBillingTable;

            function searchBtn(){

            
                const meters_id = selectizeInstance.getValue();

                if (!meters_id) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Selection',
                        text: 'Please select a valid account number.',
                    });
                    return;
                }

                // Set hidden input in modal
                $('#addOtherMaterialMetersId').val(meters_id);

                if (otherBillingTable) {
                    otherBillingTable.destroy();
                }

                otherBillingTable = $('#otherBillingTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: 'action/fetch_other_bills.php',
                        type: 'POST',
                        data: { meters_id: meters_id },
                        dataSrc: function (json) {
                            // Store the full response object so it can be reused later
                            fetchedResponse = json;
                            // Populate account info from the response
                            if (json.account) {
                                $('#accountNumber').text(json.account.account_no || '');
                                $('#accountName').text(json.account.account_name || 'N/A');
                                $('#accountStatus').text(json.account.service_status || '');
                                $('#accountType').text(json.account.account_type || '');
                                $('#accountClassification').text(json.account.classification || '');
                                $('#accountAddress').text(json.account.barangay || '');
                            }

                            return json.data; // only return rows for the table
                        }
                    },
                    columns: [
                        { title: "Bill No" },           // 0
                        { title: "Description" },       // 1
                        { title: "Units Included" },    // 2
                        { title: "Remarks" },           // 3
                        { title: "Amount Due" },        // 4
                        { title: "Due Date" },          // 5
                        { title: "Status" },            // 6
                        { title: "Action", orderable: false } // 7
                    ],
                    destroy: true,
                    scrollX: true
                });

                // Enable buttons
                $('#addMaterialBtn').prop('disabled', false);
                $('#clearBtn').prop('disabled', false);
            }

            // Trigger searchBtn when an account is selected
            selectizeInstance.on('change', function(value) {
                if (value) {
                    searchBtn();
                }
            });

            // Optional: manual search button click
            $('#searchAccountBtn').on('click', function(e) {
                e.preventDefault();
                searchBtn();
            });



            // clear all data
            $('#clearBtn').on('click', function () {
                if (otherBillingTable) {
                    otherBillingTable.clear().destroy(); // Fully destroy the table
                    $('#otherBillingTable tbody').empty(); // Clear table body
                    otherBillingTable = null; // Reset variable
                }

                // Clear account info display
                $('#accountNumber, #accountName, #accountStatus, #accountType, #accountClassification, #accountAddress').text('');

                // Clear Selectize field
                selectizeInstance.clear();

                // Clear hidden meter ID input in modal
                $('#addOtherMaterialMetersId').val('');

                // Disable buttons
                $('#addMaterialBtn').prop('disabled', true);
                $('#clearBtn').prop('disabled', true);
            });

            // Delegate click event for dynamically generated "Bill" buttons
            $(document).on("click", ".billBtn", function () {
                const billId = $(this).data("bill-id");

                if (fetchedResponse && fetchedResponse.bills) {
                    const billData = fetchedResponse.bills.find(b => b.other_billing_id == billId);

                    if (billData) {
                        // Populate modal visible fields
                        $("#bill_modal_account_name").text(fetchedResponse.account.account_name || '');
                        $("#bill_modal_account_no").text(fetchedResponse.account.account_no || '');
                        $("#bill_modal_bill_no").text(billData.other_billing_id);
                        $("#bill_modal_description").html(billData.description || '');
                        $("#bill_modal_units_included").html(billData.units_included || '');
                        $("#bill_modal_amount_due").text("₱" + parseFloat(billData.amount_due).toFixed(2));

                        // Populate hidden input values
                        $("#bill_modal_other_billing_id").val(billId);

                        // Clear or prepare inputs for new entry
                        $("#bill_modal_due_due_date").val('');
                        $("#bill_modal_remarks").val(billData.remarks);

                        // Show the modal
                        $("#billModal").modal("show");
                    } else {
                        Swal.fire("Error", "Billing data not found.", "error");
                    }
                } else {
                    Swal.fire("Error", "Billing information is unavailable.", "error");
                }
            });

            // Delegate click event for dynamically generated "Bill" buttons
            $(document).on("click", ".viewBillBtn", function () {
                const billId = $(this).data("bill-id");

                if (fetchedResponse && fetchedResponse.bills) {
                    const billData = fetchedResponse.bills.find(b => b.other_billing_id == billId);

                    if (billData) {
                        // Populate modal visible fields
                        $("#view_bill_modal_account_name").text(fetchedResponse.account.account_name || '');
                        $("#view_bill_modal_account_no").text(fetchedResponse.account.account_no || '');
                        $("#view_bill_modal_bill_no").text(billData.other_billing_id);
                        $("#view_bill_modal_description").html(billData.description || '');
                        $("#view_bill_modal_units_included").html(billData.units_included || '');
                        $("#view_bill_modal_amount_due").text("₱" + parseFloat(billData.amount_due).toFixed(2));
                        $("#view_bill_modal_due_date").text(billData.due_date);
                        $("#view_bill_modal_remarks").text(billData.remarks);
                        $("#view_bill_modal_billing_status").html(billData.billed_status);

                        // Show the modal
                        $("#viewBillModal").modal("show");
                    } else {
                        Swal.fire("Error", "Billing data not found.", "error");
                    }
                } else {
                    Swal.fire("Error", "Billing information is unavailable.", "error");
                }
            });

            // Handle Confirm Billing button
            $('#confirmBill').on('click', function (e) {
                e.preventDefault();

                $('#bill_modal_due_date').removeClass('is-invalid');

                const form = $('#billForm');
                const billId = $('#bill_modal_other_billing_id').val();
                const dueDate = $('#bill_modal_due_date').val();
                const remarks = $('#bill_modal_remarks').val();

                // Basic required validation
                if (!dueDate || !billId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Due Date',
                        text: 'Please provide a due date before confirming billing.'
                    }).then(() => {
                        $('#bill_modal_due_date').addClass('is-invalid');
                    });
                    return;
                }

                // Send data to the server
                $.ajax({
                    url: 'action/bill_other_material.php',
                    type: 'POST',
                    data: {
                        other_billing_id: billId,
                        due_date: dueDate,
                        remarks: remarks
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Billing Confirmed',
                                text: response.message || 'The other billing has been successfully processed.',
                                showConfirmButton: true
                            }).then(() => {
                                $('#billModal').modal('hide');     // Hide modal
                                $('#billForm')[0].reset();         // Reset form fields

                                // Reload DataTable if available
                                if (otherBillingTable) {
                                    otherBillingTable.ajax.reload(null, false); // Don't reset pagination
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Billing Failed',
                                text: response.message || 'An error occurred while processing billing.'
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'An unexpected error occurred while billing.'
                        });
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function () {
            let pricePerUnit = 0;

            // Load material data on selection
            $('#units_included').on('change', function () {
                const selectedMaterial = $(this).val();

                if (selectedMaterial) {
                    $.ajax({
                        url: 'action/get_other_material_info.php',
                        type: 'GET',
                        data: { material: selectedMaterial },
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                $('#unitsLabel').text(response.units);
                                $('#priceLabel').text(`₱${response.price_per_units}`);
                                pricePerUnit = parseFloat(response.price_per_units.replace(/,/g, '')) || 0;
                                $('#unitsInput').val(response.units);
                                $('#priceInput').val(parseFloat(response.price_per_units));
                                updateSubtotal(); 
                            } else {
                                $('#unitsLabel').text('—');
                                $('#priceLabel').text('—');
                                $('#subtotalLabel').text('₱0.00');
                                pricePerUnit = 0;
                            }
                        },
                        error: function () {
                            $('#unitsLabel').text('—');
                            $('#priceLabel').text('—');
                            $('#subtotalLabel').text('₱0.00');
                            pricePerUnit = 0;
                            // Set hidden input values
                            $('#unitsInput').val('');
                            $('#priceInput').val('');
                        }
                    });
                }
            });

            // Update subtotal on quantity input
            $('#quantityInput').on('input', function () {
                updateSubtotal();
            });

            function updateSubtotal() {
                const quantity = parseFloat($('#quantityInput').val()) || 0;
                const subtotal = pricePerUnit * quantity;
                $('#subtotalLabel').text(`₱${subtotal.toFixed(2)}`);
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#addOtherMaterialBtn').on('click', function (e) {
                e.preventDefault();

                const form = $('#addOtherMaterialForm');
                const requiredFields = form.find('[required]');
                let isValid = true;

                // Remove old validation styles
                form.find('.form-control, .custom-select').removeClass('is-invalid');

                // Basic required field check
                requiredFields.each(function () {
                    if ($(this).val() === '' || $(this).val() === null) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    }
                });

                // Numeric quantity validation
                const quantity = parseFloat($('#quantityInput').val());
                if (isNaN(quantity) || quantity <= 0) {
                    $('#quantityInput').addClass('is-invalid');
                    isValid = false;
                }

                // Price validation
                const priceText = $('#priceLabel').text().replace(/[₱,]/g, '');
                const price = parseFloat(priceText);
                if (isNaN(price) || price <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing or Invalid Price',
                        text: 'Please select a material with valid pricing.'
                    });
                    return;
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Fields',
                        text: 'Please complete all required fields before submitting.'
                    });
                    return;
                }

                // Submit via AJAX
                $.ajax({
                    url: 'action/add_other_material.php',
                    method: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Material Added',
                                text: response.message
                            }).then(() => {
                                $('#addNewMaterials').modal('hide'); // 
                                form[0].reset();
                                $('#unitsLabel').text('—');
                                $('#priceLabel').text('—');
                                $('#subtotalLabel').text('₱0.00');
                                $('#unitsInput').val('');
                                $('#priceInput').val('');

                                // Reload the table if available
                                if ($.fn.DataTable.isDataTable('#otherBillingTable')) {
                                    $('#otherBillingTable').DataTable().ajax.reload(null, false);
                                }
                            });
                        } else {
                            Swal.fire('Error', response.message || 'Unable to add material.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'An unexpected error occurred while saving.', 'error');
                    }
                });
            });
        });
    </script>

</body>

</html>