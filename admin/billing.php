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
                                                                    id="filterBarangay">
                                                                <option value="" selected>All Barangay</option>

                                                                <option value="BIAY">BIAY</option>
                                                                <option value="PAGATPAT">PAGATPAT</option>
                                                                <option value="TUBOTUBO NORTH">TUBOTUBO NORTH</option>
                                                                <option value="LUCAPON SOUTH">LUCAPON SOUTH</option>
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
																<li><a id="showViewAll" class="dropdown-item" href="#">Display All</a></li>
																<li><a id="showUnbilled" class="dropdown-item" href="#">Unbilled Concessioneres</a></li>
																<li><a id="generateBtn" class="dropdown-item" href="#">Billed Concessionaires</a></li>

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
																<li><a id="printReportsBtn" href="#" class="dropdown-item">Daily Billing Report</a></li>
																<li><a id="printNoticeBtn" class="dropdown-item" >Billing Notice</a></li>
																<li><a id="printAllTableBtn" class="dropdown-item" href="#">Billed Concessionaire</a></li>
																<li><a id="printUnbilledBtn" class="dropdown-item" href="#">Unbilled Concessionaire</a></li>
																<li><a id="#" class="dropdown-item" href="#">Summary of Collection</a></li>
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
	                                                    <th id="Reading_date" class="text-center" style="font-size: 12px;">Reading Date</th>
	                                                    <th style="font-size: 12px;">Amount Due</th>
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
	<?php include './action/Unbilled.php'?>
    <!-- <script src="js/dateFromTo.js"></script> -->

    <script>
    	$(document).ready(function () {
    		$('#selectAll').on('change', function() {
			    $('.select-account:not(:disabled)').prop('checked', this.checked);
			});

		    // Trigger change event on billing schedule selection
		    $('#billing_schedule_id').change(function () {
		        const billingScheduleId = $(this).val(); // Get selected value

		        if (billingScheduleId) {
		            // AJAX request to fetch data
		            $.ajax({
		                url: 'action/fetch_billing_schedule.php', 
		                method: 'POST',
		                data: { billing_schedule_id: billingScheduleId },
		                dataType: 'json',
		                success: function (response) {
		                    if (response.success) {
		                        // Populate the spans with the retrieved data
		                        $('#readingDate').text(response.data.reading_date);
		                        $('#coveredFrom').text(response.data.date_covered_from);
		                        $('#coveredTo').text(response.data.date_covered_to);
		                        $('#dueDate').text(response.data.date_due);
		                        $('#disconnectionDate').text(response.data.date_disconnection);
		                    } else {
		                        alert('Failed to fetch billing schedule details.');
		                    }
		                },
		                error: function () {
		                    alert('An error occurred while fetching billing schedule details.');
		                }
		            });
		        }
		    });

		    // Trigger change event on zone/book selection
		    $('#zonebook_id').change(function () {
		        const zonebookTextSelected = $(this).find("option:selected").text(); // Get text of selected option

		        if (zonebookTextSelected) {
		            $('#zoneBookSelected').text(zonebookTextSelected);
		        }
		    });
		});	
    </script>

    <!-- generateReadingSheet -->
     <?php include 'javascript/generateReadingSheet.php'; ?>

     <!-- readingSheetTable -->
    <?php include 'javascript/readingSheetTable.php'; ?>

    <!-- GLOBAL STORAGE (DATES FOR PRINTING) -->
    <?php include 'javascript/generateBtn.php'; ?>

    <!-- script for Print Billed Accounts -->
    <?php include 'javascript/printBilledAccount.php'; ?>

	<!-- script for print reports Unbilled -->
	<?php include 'javascript/printUnbilledAccounts.php' ?>

	<?php include 'javascript/printReports.php'?>


    
<script>
    // Barangay filter
$('#filterBarangay').on('change', function () {
    let barangay = $(this).val();

    if (barangay) {
        // exact match
        $('#readingSheetTable').DataTable()
            .column(3)
            .search('^' + barangay + '$', true, false)
            .draw();
    } else {
        // show all
        $('#readingSheetTable').DataTable()
            .column(3)
            .search('')
            .draw();
    }
});

</script>

	<!-- View All -->

	<script>
		$(document).ready(function () {
		function togglePrintOptions(mode) {
			// mode: "billed" or "unbilled"
			if (mode === "billed") {
				$("#printNoticeBtn, #printAllTableBtn").show();
				$("#printUnbilledBtn").hide();
			} else if (mode === "unbilled") {
				$("#printNoticeBtn, #printAllTableBtn, #printReportsBtn").hide();
				$("#printUnbilledBtn").show();
			}else if(mode === "printDefault"){
				$("#printNoticeBtn, #printAllTableBtn, #printUnbilledBtn").hide();
				$("#printReportsBtn").show();
			}
		}

		// When Show Billed is clicked
		$("#generateBtn").on("click", function (e) {
			e.preventDefault();
			togglePrintOptions("billed");
			// Your existing code to show billed accounts
		});

		// When Show Unbilled is clicked
		$("#showUnbilled").on("click", function (e) {
			e.preventDefault();
			togglePrintOptions("unbilled");
			// Your existing code to show unbilled accounts
		});


		// Optional: On page load, hide unbilled print
		togglePrintOptions("printDefault"); // default view, assuming billed is default
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
	
	<script>
	document.getElementById('applyDateFilter').addEventListener('click', function () {

		const from = document.getElementById('myDateFrom').value;
		const to   = document.getElementById('myDateTo').value;

		const fromDate = from ? new Date(from) : null;
		const toDate   = to ? new Date(to) : null;

		const rows = document.querySelectorAll('#readingSheetTable tbody tr');

		rows.forEach(row => {

			// Reading Date column index (adjust if needed)
			const dateText = row.cells[9].innerText.trim();
			const rowDate = new Date(dateText);

			let show = true;

			if (fromDate && rowDate < fromDate) show = false;
			if (toDate && rowDate > toDate) show = false;

			row.style.display = show ? '' : 'none';
		});
	});
	</script>

	 
</body>

</html>