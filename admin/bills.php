<!DOCTYPE html>
<html>          
    <?php include './include/head.php'; ?>
<body id="page-top">
    <div class="d-none" id="billing"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include './include/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './include/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid" style="margin-top: -15px;">

                        <!-- Page Heading -->
                        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-primary"><i class="fas fa-receipt fa-sm mr-2"></i>Billing</h1>
                        </div> -->

                        <!-- <hr class="bg-primary"> -->

                        <!-- Content Row -->
                                        
                        <div class="row d-flex align-items-stretch mb-2">
                            <div class="col-sm-12 col-12">
						        <div class="card">
						            <!-- <div class="card-header bg-primary text-white">
						                Reading Information
						            </div> -->
						            <div class="p-2">
						                <div class="row d-flex align-items-stretch">
										    <!-- Card 4 -->
											<div class="col-sm-14 col-12 d-flex mb-3 mb-sm-0 mt-0">
											    <div class="flex-fill">
											        <div class="row g-3 g-md-2 justify-content-center align-items-center billing-toolbar text-center text-md-start">


														<!-- Billing Schedule -->
														<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
															<select class="form-control form-control-sm w-100"
																	name="billing_schedule_id"
																	id="billing_schedule_id"
																	required>
																<option value="" selected disabled>Select billing schedule</option>
																<?php
																require '../db/dbconn.php';

																$sql = "SELECT * FROM billing_schedule_settings 
																		WHERE deleted = 0 
																		ORDER BY reading_date DESC";
																$result = $con->query($sql);

																while ($row = $result->fetch_assoc()) {
																	$formattedDate = date("F Y", strtotime($row['date_covered_to']));
																	$isActive = (int)$row['set_active']; // 1 = active, 0 = inactive

																	echo "<option 
																			value='{$row['billing_schedule_id']}' 
																			data-active='{$isActive}'>
																			{$formattedDate} " . ($isActive ? '(Active)' : '') . "
																		</option>";
																	echo "<script>console.log($isActive)</script>";
																}
																?>
															</select>
														</div>

														<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
															<select class="form-control form-control-sm w-100"
																	name="#"
																	id="#"
																	required>
																<option value="" selected disabled>Select Barangay</option>
																
																<option value="0">BIAY</option>
																<option value="0">BIAY</option>
																<option value="0">BIAY</option>
																<option value="0">BIAY</option>

															</select>
														</div>

														<!-- Zone / Book -->
														<div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-2">
															<select class="form-control form-control-sm w-100"
																	name="zonebook_id"
																	id="zonebook_id"
																	required>
																<option value="" selected disabled>Select zone/book</option>
																<?php
																$result = $con->query("SELECT * FROM zonebook_settings WHERE deleted = 0");
																while ($row = $result->fetch_assoc()) {
																	echo "<option value='{$row['zonebook_id']}'>{$row['zonebook']}</option>";
																}
																?>
																<option value="0">Accounts with no Zone/Book Assigned</option>
															</select>
														</div>

														<!-- sorting -->
														



														<!-- Controls -->
														<div class="col-lg-2 col-md-4 col-sm-6 col-12 d-flex justify-content-center mb-2">
															<div class="dropdown w-100 w-md-auto">
																<!-- Main Filter Button -->
																<button
																class="btn btn-success btn-sm dropdown-toggle w-100"
																type="button"
																id="userStatusControls"
																data-bs-toggle="dropdown"
																aria-expanded="false">
																<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-search-icon lucide-text-search">
																	<path d="M21 5H3"/>
																	<path d="M10 12H3"/>
																	<path d="M10 19H3"/>
																	<circle cx="17" cy="15" r="3"/>
																	<path d="m21 19-1.9-1.9"/>
																</svg>
																Filter
																</button>

																<ul class="dropdown-menu w-100" aria-labelledby="userStatusControls">
																<li><a id="showViewAll" class="dropdown-item" href="#">View All</a></li>
																<li><a id="showUnbilled" class="dropdown-item" href="#">Show Unbilled</a></li>
																<li><a id="generateBtn" class="dropdown-item" href="#">Show Billed</a></li>

																<!-- Date Nested Dropdown -->
																<li class="dropend">
																	<a class="dropdown-item dropdown-toggle" href="#" id="dateDropdown" data-bs-toggle="dropdown" aria-expanded="false">
																	Reading Date
																	</a>
																	<ul class="dropdown-menu p-3" aria-labelledby="dateDropdown" style="min-width: 200px;">
																	<li class="mb-2">
																		<label for="myDateFrom" class="form-label">From</label>
																		<input type="date" id="myDateFrom" class="form-control form-control-sm">
																	</li>
																	<li>
																		<label for="myDateTo" class="form-label">To</label>
																		<input type="date" id="myDateTo" class="form-control form-control-sm">
																	</li>
																	<li class="mt-2">
																		<button class="btn btn-primary btn-sm w-100" id="applyDateFilter">Filter</button>
																	</li>
																	</ul>
																</li>
																</ul>
															</div>
														</div>




														<!-- Print -->
														<!-- <div class="col-lg-2 col-md-4 col-sm-6 col-12 d-flex justify-content-center mb-2">
															<button id="printNoticeBtn"
																	class="btn btn-success btn-sm w-100 w-md-auto" disabled>
																	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-printer-check-icon lucide-printer-check"><path d="M13.5 22H7a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v.5"/><path d="m16 19 2 2 4-4"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/></svg>
																Print Notice
															</button>
														</div> -->

														<div class="col-lg-2 col-md-4 col-sm-6 col-12 d-flex justify-content-center mb-2">
															<div class="dropdown w-100 w-md-auto">
																<!-- Main Filter Button -->
																<button
																class="btn btn-success btn-sm dropdown-toggle w-100"
																type="button"
																id="userStatusControls"
																data-bs-toggle="dropdown"
																aria-expanded="false" >
																<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-printer-check-icon lucide-printer-check"><path d="M13.5 22H7a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v.5"/><path d="m16 19 2 2 4-4"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/></svg>
																Print Reports
																</button>

																<ul class="dropdown-menu w-100" aria-labelledby="userStatusControls">
																<li><a id="printNoticeBtn" class="dropdown-item" href="#">Print Notice</a></li>
																<li><a id="printAllTableBtn" class="dropdown-item" href="#">Print billing reports</a></li>
																<li><a id="#" class="dropdown-item" href="#">Print unbilled</a></li>
																</ul>
															</div>
														</div>
														

														<!-- Clear -->
														<div class="col-lg-2 col-md-4 col-sm-6 col-12 d-flex justify-content-center mb-2">
															<a class="btn btn-primary btn-sm w-100 w-md-auto"
															href="billing.php?title=Billing">
															<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eraser-icon lucide-eraser"><path d="M21 21H8a2 2 0 0 1-1.42-.587l-3.994-3.999a2 2 0 0 1 0-2.828l10-10a2 2 0 0 1 2.829 0l5.999 6a2 2 0 0 1 0 2.828L12.834 21"/><path d="m5.082 11.09 8.828 8.828"/></svg>
																Clear
															</a>
														</div>

														<!-- Hidden -->
														<div class="d-none">
															<input type="checkbox" id="showBilled" checked>
															<input type="checkbox" id="unbilledAccount">
														</div>

													</div>


												</div>
											</div>

											<!-- <div class="col-sm-12 col-12 d-flex mb-3 mb-sm-0 mt-sm-3 mt-0">
											    <div class="card flex-fill">
											        <div class="card-body">
											            <div class="row">
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-dark m-0">Reading Date:</p>
											                    <span class="text-primary font-weight-bold" id="readingDate"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-dark m-0">Covered From:</p>
											                    <span class="text-primary font-weight-bold" id="coveredFrom"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-dark m-0">Covered To:</p>
											                    <span class="text-primary font-weight-bold" id="coveredTo"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-dark m-0">Due Date:</p>
											                    <span class="text-primary font-weight-bold" id="dueDate"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-dark m-0">Disconnection Date:</p>
											                    <span class="text-primary font-weight-bold" id="disconnectionDate"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-dark m-0">Zone/Book:</p>
											                    <span class="text-primary font-weight-bold" id="zoneBookSelected"></span>
											                </div>
											            </div>
											        </div>
											    </div>
											</div>	 -->
										</div>
						            </div>
						        </div>
						    </div>
                        </div>

                        <div class="row d-flex align-items-stretch mb-3">
                            <div class="col-sm-12 col-12">
						        <div class="card">
								<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
									<span>Reading Sheet</span>
									<!-- <div>
									<button id="printAllTableBtn"
												class="btn btn-success btn-sm w-100 w-md-auto">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-printer-check-icon lucide-printer-check"><path d="M13.5 22H7a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v.5"/><path d="m16 19 2 2 4-4"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/></svg>
												Print Table
										</button>
									</div> -->

									<!-- <div class="d-flex justify-content-center align-items-center gap-2">
										<div class="d-flex align-items-center">
											<label class="form-label mb-0 mr-2 text-white">From:</label>
											<input type="date" class="form-control form-control-sm shadow-sm rounded" name="date_from" required
												style="max-width: 150px; background-color: #f8f9fa;">
										</div>

										<div class="d-flex align-items-center">
											<label class="form-label mb-0 text-white">To:</label>
											<input type="date" class="form-control form-control-sm shadow-sm rounded" name="date_to" required
												style="max-width: 150px; background-color: #f8f9fa;">
										</div>
									</div> -->
								</div>


						            <div class="card-body">
						                <div class="table-responsive">
	                                        <table class="table text-sm table-bordered nowrap text-center" id="readingSheetTable" width="100%" cellspacing="0">
	                                            <thead class="">
	                                                <tr>
	                                                	<th style="font-size: 12px;">
											                <input type="checkbox" id="selectAll" />
											            </th>
	                                                    <th style="font-size: 12px;">Account No</th>                                        
	                                                    <th style="font-size: 12px;">Account Name</th>  
	                                                    <th style="font-size: 12px;">Barangay</th>                                        
	                                                    <th style="font-size: 12px;">Meter No</th>                                               
	                                                    <th style="font-size: 12px;">Zone/Book</th>                            
	                                                    <th style="font-size: 12px;">Previous Reading</th>                            
	                                                    <th style="font-size: 12px;">Current Reading</th>                            
	                                                    <th class="text-center" style="font-size: 12px;">Consumed</th>
	                                                    <th class="text-center" style="font-size: 12px;">Reading Date</th>
	                                                    <th style="font-size: 12px;">Action</th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>

	                                            </tbody>
	                                        </table>
	                                    </div>
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
    <?php include './modal/billing_print_modal.php'; ?>
    <?php include './include/script.php'; ?>


<script src="js/dateFromTo.js"></script>

<!-- generateReadingSheet script -->
<script>
$(document).ready(function () {

    let readingTable = null;

    function toggleBillingActionButtons() {
        let selectedOption = $('#billing_schedule_id option:selected');
        let isActive = selectedOption.data('active');

        if (isActive == 1) {
            $('.update-bill, .generate-bill, .regenerate-bill')
                .prop('disabled', false)
                .removeClass('disabled')
                .show();
        } else {
            $('.update-bill, .generate-bill, .regenerate-bill')
                .prop('disabled', true)
                .addClass('disabled')
                .hide();
        }
    }

    function generateReadingSheet(showBilled = null) {

        $("#zonebook_id, #billing_schedule_id").removeClass("is-invalid");

        let zonebookId = $("#zonebook_id").val();
        let billingID = $("#billing_schedule_id").val();

        if (!zonebookId || !billingID) {
            if (!zonebookId) $("#zonebook_id").addClass("is-invalid");
            if (!billingID) $("#billing_schedule_id").addClass("is-invalid");
            return;
        }

        if (showBilled === null) {
            showBilled = $("#showBilled").is(":checked") ? 1 : 0;
        }

        $.ajax({
            url: "action/fetch_reading_sheet.php",
            type: "POST",
            dataType: "json",
            data: {
                zonebook_id: zonebookId,
                billing_schedule_id: billingID,
                show_billed: showBilled
            },
            beforeSend() {
                Swal.fire({
                    title: "Generating...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success(response) {
                Swal.close();

                if ($.fn.dataTable.isDataTable('#readingSheetTable')) {
                    $('#readingSheetTable').DataTable().clear().destroy();
                }

                if (response.success && response.data.length > 0) {
                    readingTable = $("#readingSheetTable").DataTable({
                        scrollX: true,
                        order: [],
                        data: response.data,
                        columns: [
                            { data: 'checkbox' },
                            { data: 'account_no' },
                            { data: 'account_name' },
                            { data: 'barangay_name' },
                            { data: 'meter_no' },
                            { data: 'zonebook' },
                            {
                                data: 'previous_reading',
                                render: d => d !== null ? d : 0
                            },
                            { data: 'current_reading' },
                            {
                                data: 'consumed',
                                render: function (data, type, row) {
                                    let prev = parseFloat(row.previous_reading) || 0;

                                    let inputVal = $('<div>')
                                        .html(row.current_reading)
                                        .find('input')
                                        .val();

                                    let curr = parseFloat(inputVal) || 0;
                                    let consumed = data !== null ? parseFloat(data) : (curr - prev);

                                    return `<span class="consumed">${consumed.toFixed(2)}</span>`;
                                }
                            },
                            { data: 'reading_date' },
                            { data: 'action' }
                        ]
                    });

                    toggleBillingActionButtons();
                } else {
                    readingTable = $("#readingSheetTable").DataTable({
                        scrollX: true,
                        order: []
                    });

                    Swal.fire("No Data", "No records found.", "info");
                }
            },
            error() {
                Swal.fire("Error", "Failed to load reading sheet.", "error");
            }
        });
    }

    

    // Auto reload
    $("#zonebook_id").on("change", () => generateReadingSheet());
    $("#billing_schedule_id").on("change", () => {
        generateReadingSheet();
        toggleBillingActionButtons();
    });

    // Generate button
    $("#generateBtnShowbilled").on("click", function (e) {
        e.preventDefault();
        generateReadingSheet();
    });

    // SHOW UNBILLED (FIXED)
    $("#showUnbilled").on("click", function (e) {
        e.preventDefault();
        generateReadingSheet(0); // force unbilled
    });

    // Live consumed calculation
    $('#readingSheetTable').on('input', '.current-reading', function () {
        let row = $(this).closest('tr');
        let previousReading = parseFloat(row.find('td').eq(6).text()) || 0;
        let currentReading = parseFloat($(this).val()) || 0;
        let consumed = currentReading - previousReading;

        row.find('.consumed').text(consumed.toFixed(2));
    });

    // Sorting dropdown
    $(document).on("click", ".sort-option", function (e) {
        e.preventDefault();
        if (!readingTable) return;

        let columnIndex = $(this).data("column");
        let direction = $(this).data("direction");

        readingTable.order([columnIndex, direction]).draw();
        $("#userStatusDropdown").text($(this).text());
    });

});
</script>


<!-- readingSheetTable script -->


<!-- generateBtn -->
<script>
	
/* =====================================================
   GLOBAL STORAGE (DATES FOR PRINTING)
===================================================== */
let GLOBAL_READING_DATE = '';
let GLOBAL_DUE_DATE = '';
let GLOBAL_COVERED_FROM = '';
let GLOBAL_COVERED_TO = '';

$(document).ready(function () {

    /* =====================================================
       GENERATE TABLE
    ===================================================== */
    $("#generateBtn").click(function (e) {
        e.preventDefault();

        $("#zonebook_id, #billing_schedule_id").removeClass("is-invalid");

        let zonebookId = $("#zonebook_id").val();
        let billingID  = $("#billing_schedule_id").val();

        if (!zonebookId || !billingID) {
            if (!zonebookId) $("#zonebook_id").addClass("is-invalid");
            if (!billingID) $("#billing_schedule_id").addClass("is-invalid");

            Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "Please select both a billing schedule and zone/book.",
            });

            $("#printNoticeBtn").prop("disabled", true);
            return;
        }

        $("#printNoticeBtn").prop("disabled", false);

        $.ajax({
            url: "action/fetch_reading_sheet_notice.php",
            type: "POST",
            data: {
                zonebook_id: zonebookId,
                billing_schedule_id: billingID
            },
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Generating...",
                    text: "Please wait while the reading sheet is being prepared.",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                });
            },
            success: function (response) {
                Swal.close();

                if ($.fn.dataTable.isDataTable('#readingSheetTable')) {
                    $('#readingSheetTable').DataTable().clear().destroy();
                }

                let table = $("#readingSheetTable").DataTable({
                    scrollX: true
                });

                table.clear();

                if (response.success && response.data.length > 0) {

                    /* =============================
                       STORE GLOBAL DATES (ONCE)
                    ============================== */
                    GLOBAL_READING_DATE = response.data[0].reading_date ?? '';
                    GLOBAL_DUE_DATE     = response.data[0].due_date ?? '';

                    // Optional (if you later return these from PHP)
                    GLOBAL_COVERED_FROM = response.covered_from ?? '';
                    GLOBAL_COVERED_TO   = response.covered_to ?? '';

                    response.data.forEach(item => {
                        table.row.add([
                            item.checkbox,
                            item.account_no,
                            item.account_name,
                            item.barangay_name,
                            item.meter_no,
                            item.zonebook,
                            item.previous_reading,
                            item.current_reading,
                            item.consumed,
							item.reading_date,
                            item.amount_due
                        ]);
                    });

                    table.draw();
                    $("#printNoticeBtn").prop("disabled", false);

                } else {
                    table.clear().draw();
                    Swal.fire({
                        icon: "info",
                        title: "No Data",
                        text: response.message || "No records found.",
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to generate reading sheet.",
                });
            }
        });
    });

    /* =====================================================
       SELECT ALL CHECKBOX
    ===================================================== */
    $("#selectAll").on("click", function () {
        $(".rowCheckbox").prop("checked", this.checked);
    });

    $(document).on("click", ".rowCheckbox", function () {
        $("#selectAll").prop(
            "checked",
            $(".rowCheckbox:checked").length === $(".rowCheckbox").length
        );
    });

    /* =====================================================
       PRINT NOTICE (FULLY FIXED)
    ===================================================== */
    $("#printNoticeBtn").click(function () {

        let selectedAccounts = [];

        $(".rowCheckbox:checked").each(function () {
            let row = $(this).closest("tr");

            selectedAccounts.push({
                account_no: row.find("td:eq(1)").text().trim(),
                account_name: row.find("td:eq(2)").text().trim(),
                barangay: row.find("td:eq(3)").text().trim(),
                meter_no: row.find("td:eq(4)").text().trim(),
                zonebook: row.find("td:eq(5)").text().trim(),
                previous_reading: row.find("td:eq(6)").text().trim(),
                current_reading: row.find("td:eq(7)").text().trim(),
                consumed: row.find("td:eq(8)").text().trim(),
                amount_due: row.find("td:eq(9)").text().trim()
            });
        });

        if (selectedAccounts.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No Accounts Selected",
                text: "Please select at least one account.",
            });
            return;
        }

        /* =============================
           USE GLOBAL VALUES
        ============================== */
        let readingDate = GLOBAL_READING_DATE;
        let dueDate     = GLOBAL_DUE_DATE;
        let coveredFrom = GLOBAL_COVERED_FROM;
        let coveredTo   = GLOBAL_COVERED_TO;

        let monthYear = '';
        if (readingDate) {
            let d = new Date(readingDate);
            monthYear = d.toLocaleDateString("en-US", {
                year: "numeric",
                month: "long"
            });
        }

        const SYSTEM_LOGO = "<?php echo isset($_SESSION['system_profile']) ? '../img/' . $_SESSION['system_profile'] : '../img/system_6965ed6ed6091.png'; ?>";

        let printContent = `
        <html>
        <head>
        <title>Print Water Bill Notices</title>
        <style>
            @page { size: A4; margin: 0.3in; }
            body { font-family: Arial, sans-serif; margin: 0; }
            .wrapper { display: flex; flex-wrap: wrap; }
            .notice {
                width: 50%;
                box-sizing: border-box;
                padding: 10px;
                border: 1px dashed #999;
                page-break-inside: avoid;
            }
            .logo { text-align: center; }
            .logo img { width: 45px; height: 45px; }
            .header { text-align: center; font-size: 11px; }
            .details { font-size: 10px; line-height: 1.3; }
            .note { font-size: 8px; margin-top: 5px; }
        </style>
        </head>
        <body>
        <div class="wrapper">`;

        selectedAccounts.forEach(acc => {
            printContent += `
            <div class="notice">
                <div class="logo"><img src="${SYSTEM_LOGO}"></div>
                <div class="header">
                    <strong>Sta Cruz Water District</strong><br>
                    Water Bill Notice<br>
                    Billing Period: ${monthYear}
                </div>
                <hr>
                <div class="details">
                    <p><strong>Account No:</strong> ${acc.account_no}</p>
                    <p><strong>Name:</strong> ${acc.account_name}</p>
                    <p><strong>Billing Address:</strong> ${acc.barangay}, Sta Cruz, Zambales</p>
                    <p><strong>Meter No:</strong> ${acc.meter_no}</p>
                    <p><strong>Zone/Book:</strong> ${acc.zonebook}</p>
                    <hr>
                    <p><strong>Reading Date:</strong> ${readingDate}</p>
                    <p><strong>Covered:</strong> ${coveredFrom} ${coveredTo ? '– ' + coveredTo : ''}</p>
                    <p><strong>Due Date:</strong> ${dueDate}</p>
                    <hr>
                    <p><strong>Previous:</strong> ${acc.previous_reading}</p>
                    <p><strong>Current:</strong> ${acc.current_reading}</p>
                    <p><strong>Consumed:</strong> ${acc.consumed}</p>
                    <p><strong>Amount Due:</strong> ${acc.amount_due}</p>
                </div>
                <p class="note">
                    This is not an official receipt. Please pay on or before the due date.
                </p>
            </div>`;
        });

        printContent += `</div></body></html>`;

        let win = window.open("", "", "width=1000,height=800");
        win.document.write(printContent);
        win.document.close();
        win.onload = () => win.print();
    });

});
</script>

<script>
  // Prevent parent dropdown from closing when clicking inside nested dropdown
  document.querySelectorAll('.dropdown-menu').forEach(menu => {
    menu.addEventListener('click', function (e) {
      e.stopPropagation(); // Stop click from closing parent
    });
  });
</script>

<!-- script for Print Billed Accounts -->
<script>
	$("#printAllTableBtn").click(function () {

    let table = $('#readingSheetTable').DataTable();
    let allRows = table.rows({ search: 'applied' }).nodes();

    if (allRows.length === 0) {
        Swal.fire({
            icon: "info",
            title: "No Data",
            text: "There are no records to print."
        });
        return;
    }

    let accounts = [];

    $(allRows).each(function () {
        let row = $(this);

        accounts.push({
            account_no: row.find("td:eq(1)").text().trim(),
            account_name: row.find("td:eq(2)").text().trim(),
            barangay: row.find("td:eq(3)").text().trim(),
            meter_no: row.find("td:eq(4)").text().trim(),
            zonebook: row.find("td:eq(5)").text().trim(),
            previous_reading: row.find("td:eq(6)").text().trim(),
            current_reading: row.find("td:eq(7)").text().trim(),
            consumed: row.find("td:eq(8)").text().trim(),
            reading_date: row.find("td:eq(9)").text().trim(),
            amount_due: row.find("td:eq(10)").text().trim()
        });
    });

    printBilledAccounts(accounts);
});

function printBilledAccounts(accounts, printTitle = "Billing Report") {
    let count = 1;

    // Get "From" date
    let rawDateFrom = $("#myDateFrom").val();
    let formattedDateFrom = "";
    if (rawDateFrom) {
        formattedDateFrom = new Date(rawDateFrom).toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric"
        });
    }

    // Get "To" date
    let rawDateTo = $("#myDateTo").val();
    let formattedDateTo = "";
    if (rawDateTo) {
        formattedDateTo = new Date(rawDateTo).toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric"
        });
    }

    // Default current date
    const dateNotformatted = new Date();
    const formattedDate = dateNotformatted.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    // Set print title and date display
    let dateDisplay = "";
    if (rawDateFrom && rawDateTo) {
        printTitle = "DAILY BILLING REPORT";
        dateDisplay = `As of ${formattedDateFrom} to ${formattedDateTo}`;
    } else {
        printTitle = "BILLING REPORT";
        dateDisplay = formattedDate;
    }

    const SYSTEM_LOGO = "<?php echo isset($_SESSION['system_profile']) ? '../img/' . $_SESSION['system_profile'] : '../img/system_6965ed6ed6091.png'; ?>";

    // Start building HTML
    let html = `
    <html>
    <head>
        <title>${printTitle}</title>
        <style>
            @page { size: A4 ; margin: 0.5in; }
            body { font-family: Arial, sans-serif; }
            .print-header { text-align: center; margin-bottom: 15px; }
            .print-header img { width: 60px; margin-bottom: 5px; }
            table { width: 100%; border-collapse: collapse; font-size: 10px; }
            th, td { border: 1px solid #000; padding: 4px; text-align: center; }
            th { background: #f2f2f2; }
            .summary-table { width: 50%; margin-top: 15px; font-size: 10px; }
            .summary-table th, .summary-table td { border: 1px solid #000; padding: 4px; text-align: left; }
        </style>
    </head>
    <body>
        <div class="print-header">
            <img src="${SYSTEM_LOGO}">
            <h2>STA CRUZ WATER DISTRICT</h2>
            <p style="margin-top: -20px; font-size: 13px;">Poblacion South Sta Cruz, Zambales</p>
            <h4>${printTitle}</h4>
            <p style="font-size: 13px; margin-top: -15px;">${dateDisplay}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Account No</th>
                    <th>Bill No</th>
                    <th>Name</th>
                    <th>Zone</th>
                    <th>Previous</th>
                    <th>Current</th>
                    <th>Consumed</th>
                    <th>Amount Due</th>
                </tr>
            </thead>
            <tbody>
    `;

    // Add each account row
    accounts.forEach(acc => {
        html += `
            <tr>
                <td style="text-align: center;">${count++}</td>
                <td>${acc.account_no}</td>
                <td>-</td>
                <td style="text-align: left; padding-left: 5px;">${acc.account_name}</td>
                <td>${acc.zonebook}</td>
                <td>${acc.previous_reading}</td>
                <td>${acc.current_reading}</td>
                <td>${acc.consumed}</td>
                <td>${acc.amount_due}</td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    // ===== Dynamic summary table =====
    let barangaySet = new Set(accounts.map(acc => acc.barangay));
    let totalConcessionaires = accounts.length;

    html += `
        <div>
            <table class="summary-table">
                <tr>
                    <th>Barangay(s)</th>
                    <td>${[...barangaySet].join(", ") || '-'}</td>
                </tr>
                <tr>
                    <th>Total of Concessionaires</th>
                    <td>${totalConcessionaires}</td>
                </tr>
            </table>
        </div>
    `;

    html += `
    </body>
    </html>
    `;

    // Open print window
    let win = window.open("", "", "width=1200,height=800");
    win.document.write(html);
    win.document.close();
    win.onload = () => win.print();
}
</script>

	 
</body>

</html>