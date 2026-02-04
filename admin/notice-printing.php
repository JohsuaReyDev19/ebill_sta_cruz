<!DOCTYPE html>
<html>          
    <?php include './include/head.php'; ?>
<body id="page-top">
    <div class="d-none" id="notice-printing"></div>

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
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-primary"><i class="fas fa-receipt fa-sm mr-2"></i>Notice Printing</h1>
                        </div>

                        <hr class="bg-primary">

                        <!-- Content Row -->
                                        
                        <div class="row d-flex align-items-stretch mb-3">
                            <div class="col-sm-12 col-12">
						        <div class="card border-primary">
						            <div class="card-header bg-primary text-white">
						                Billing Information
						            </div>
						            <div class="card-body">
						                <div class="row d-flex align-items-stretch">
										    <!-- Card 1 -->
										    <div class="col-sm-4 col-12 d-flex mb-3 mb-sm-0">
										        <div class="card border-primary flex-fill shadow">
										            <div class="card-body">
										                <!-- Billing Schedule -->
														<div class="form-group mb-3">
														    <label class="form-label">Billing Schedule</label>
														    <select class="form-control custom-select" name="billing_schedule_id" id="billing_schedule_id" required>
														        <option value="" selected disabled>Select billing schedule</option>
														        <?php
														        require '../db/dbconn.php';
														        $sqlFetchActType = "SELECT * FROM billing_schedule_settings WHERE deleted = 0 ORDER BY reading_date DESC";
														        $resultFetchActType = $con->query($sqlFetchActType);

														        if ($resultFetchActType->num_rows > 0) {
														            while ($rowFetchActType = $resultFetchActType->fetch_assoc()) {
														                $billing_schedule_id = $rowFetchActType['billing_schedule_id'];
														                $date_covered_to = $rowFetchActType['date_covered_to'];
														                $set_active = $rowFetchActType['set_active'];

														                // Format date_covered_to to "Month Year" (e.g., November 2024)
														                $formattedDate = date("F Y", strtotime($date_covered_to));
														                echo "<option value='$billing_schedule_id'>$formattedDate  " . (($set_active == 1) ? "(Active)" : "") . "</option>";
														            }
														        } else {
														            echo "<option value='none' selected disabled>No billing schedule available</option>";
														        }
														        ?>
														    </select>
														    <div class="invalid-feedback">Please select billing schedule.</div>
														</div>
										            </div>
										        </div>
										    </div>
										    <!-- Card 2 -->
										    <div class="col-sm-4 col-12 d-flex mb-3 mb-sm-0">
										        <div class="card border-primary flex-fill shadow">
										            <div class="card-body">
														<!-- Zone/Book -->
								                        <div class="form-group mb-3">
								                            <label class="form-label">Zone/Book</label>
								                            
								                            <select class="form-control custom-select" name="zonebook_id" id="zonebook_id" required>
								                                <option value="" selected disabled>Select zone/book</option>
								                                <?php
								                                $sqlFetchZoneBook = "SELECT * FROM zonebook_settings WHERE deleted = 0";
								                                $resultFetchZoneBook = $con->query($sqlFetchZoneBook);

								                                if ($resultFetchZoneBook->num_rows > 0) {
								                                    while ($rowFetchZoneBook = $resultFetchZoneBook->fetch_assoc()) {
								                                        $zonebook_id = $rowFetchZoneBook['zonebook_id'];
								                                        $zonebook = $rowFetchZoneBook['zonebook'];
								                                        echo "<option value='$zonebook_id'>$zonebook</option>";
								                                    }
								                                } else {
								                                    echo "<option value='none' selected disabled>No Zone/Book available</option>";
								                                }
								                                ?>
								                                <option value="0">Accounts with no Zone/Book Assigned</option>
								                            </select>

								                            <div class="invalid-feedback">Please select zone/book.</div>
								                        </div>
										            </div>
										        </div>
										    </div>
										    <!-- Card 3 -->
										    <div class="col-sm-4 col-12 d-flex mb-3 mb-sm-0">
										        <div class="card border-primary flex-fill">
										            <div class="card-body">
										                <!-- Generate Reading Button -->
								                        <div class="form-group">
								                            <button class="btn btn-success shadow-sm w-100" id="generateBtn">Generate Reading Notice</button>
								                        </div>
								                        <!-- Print Notice Button -->
								                        <div class="form-group">
								                            <button class="btn btn-primary shadow-sm w-100" id="printNoticeBtn" disabled>Print Reading Notice</button>
								                        </div>
										            </div>
										        </div>
										    </div>
										    <!-- Card 4 -->
											<div class="col-sm-12 col-12 d-flex mb-3 mb-sm-0 mt-sm-3 mt-0">
											    <div class="card border-primary flex-fill">
											        <div class="card-body">
											            <div class="row">
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-primary m-0">Reading Date:</p>
											                    <span class="text-dark" id="readingDate"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-primary m-0">Covered From:</p>
											                    <span class="text-dark" id="coveredFrom"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-primary m-0">Covered To:</p>
											                    <span class="text-dark" id="coveredTo"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-primary m-0">Due Date:</p>
											                    <span class="text-dark" id="dueDate"></span>
											                </div>
											                <div class="col-sm-2 col-12">
											                    <p class="card-text text-primary m-0">Disconnection Date:</p>
											                    <span class="text-dark" id="disconnectionDate"></span>
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

                        <div class="row d-flex align-items-stretch mb-3">
                            <div class="col-sm-12 col-12">
						        <div class="card border-primary">
						            <div class="card-header bg-primary text-white">
						                Billed Accounts
						            </div>
						            <div class="card-body">
						                <div class="table-responsive">
	                                        <table class="table table-bordered nowrap text-center" id="readingSheetTable" width="100%" cellspacing="0">
	                                            <thead class="">
	                                                <tr>
	                                                	<th scope="col">
											                <input type="checkbox" id="selectAll" />
											            </th>
	                                                    <th scope="col">Account No</th>                                        
	                                                    <th scope="col">Account Name</th>                                        
	                                                    <th scope="col">Meter No</th>                                               
	                                                    <th scope="col">Zone/Book</th>                            
	                                                    <th scope="col">Previous Reading</th>                            
	                                                    <th scope="col">Current Reading</th>                            
	                                                    <th scope="col" class="text-center">Consumed</th>                            
	                                                    <th scope="col" class="text-center">Amount Due</th>
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

    <?php include './include/script.php'; ?>

    <script>
    	$(document).ready(function () {
    		$(document).on('change', '#selectAll', function () {
			    $('.select-account').prop('checked', this.checked);
			});

		    // Trigger change event on billing schedule selection
		    $('#billing_schedule_id').change(function () {
		        const billingScheduleId = $(this).val(); // Get selected value

		        if (billingScheduleId) {
		            // AJAX request to fetch data
		            $.ajax({
		                url: 'action/fetch_billing_schedule.php', // PHP script to fetch billing schedule details
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
		});	
    </script>

    <script>
    	$(document).ready(function () {
		    $("#generateBtn").click(function (e) {
		        e.preventDefault();

		        $("#zonebook_id, #billing_schedule_id").removeClass("is-invalid");

		        let zonebookId = $("#zonebook_id").val();
		        let billingID = $("#billing_schedule_id").val();

		        if (!zonebookId || !billingID) {
		            if (!zonebookId) $("#zonebook_id").addClass("is-invalid");
		            if (!billingID) $("#billing_schedule_id").addClass("is-invalid");

		            Swal.fire({
		                icon: "error",
		                title: "Oops..",
		                text: "Please select both a billing schedule and zone/book.",
		            });
		            return;
		        }

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
		                    response.data.forEach((item) => {
		                        table.row.add([
		                            item.checkbox,
		                            item.account_no,
		                            item.account_name,
		                            item.meter_no,
		                            item.zonebook,
		                            item.previous_reading,
		                            item.current_reading,
		                            item.consumed,
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
		                        text: response.message || "No records found for the selected zone/book.",
		                    });
		                }
		            },
		            error: function () {
		                Swal.fire({
		                    icon: "error",
		                    title: "Error",
		                    text: "An error occurred while generating the reading sheet. Please try again.",
		                });
		            },
		        });
		    });

		    // Handle "Select All" checkbox
		    $("#selectAll").on("click", function () {
		        $(".rowCheckbox").prop("checked", this.checked);
		    });

		    // Handle individual row checkboxes
		    $(document).on("click", ".rowCheckbox", function () {
		        if (!this.checked) {
		            $("#selectAll").prop("checked", false);
		        } else if ($(".rowCheckbox:checked").length === $(".rowCheckbox").length) {
		            $("#selectAll").prop("checked", true);
		        }
		    });
		});
    </script>

    <script>
    	$(document).ready(function () {
		    $("#printNoticeBtn").click(function () {
		        let selectedAccounts = [];

		        // Collect selected accounts
		        $(".rowCheckbox:checked").each(function () {
		            let row = $(this).closest("tr");
		            selectedAccounts.push({
		                account_no: row.find("td:eq(1)").text().trim(),
		                account_name: row.find("td:eq(2)").text().trim(),
		                meter_no: row.find("td:eq(3)").text().trim(),
		                zonebook: row.find("td:eq(4)").text().trim(),
		                previous_reading: row.find("td:eq(5)").text().trim(),
		                current_reading: row.find("td:eq(6)").text().trim(),
		                consumed: row.find("td:eq(7)").text().trim(),
		                amount_due: row.find("td:eq(8)").text().trim()
		            });
		        });

		        if (selectedAccounts.length === 0) {
		            Swal.fire({
		                icon: "warning",
		                title: "No Accounts Selected",
		                text: "Please select at least one account to print.",
		            });
		            return;
		        }

		        // Get billing details from the billing schedule
		        let readingDate = $("#readingDate").text();
		        let coveredFrom = $("#coveredFrom").text();
		        let coveredTo = $("#coveredTo").text();
		        let dueDate = $("#dueDate").text();

		        // Extract Month and Year from the Billing Schedule (coveredTo date)
		        let monthYear = "";
		        if (coveredTo) {
		            let dateObj = new Date(coveredTo);
		            let options = { year: "numeric", month: "long" };
		            monthYear = dateObj.toLocaleDateString("en-US", options); // Example: "March 2024"
		        }

		        // Use an absolute URL for the logo
		        let logoUrl = "https://stacruzwd.projectbeta.net/img/mmwd.png"; // Replace with actual image URL

		        // Generate printable content
		        let printContent = `
		            <html>
		                <head>
		                    <title>Print Reading Notice</title>
		                    <style>
		                        @page { 
		                            size: 4in 6in; /* A6 Paper Size */
		                            margin: 0.2in;
		                        }
		                        body { 
		                            font-family: Arial, sans-serif;
		                            width: 4in;
		                            height: 6in;
		                            margin: 0 auto;
		                        }
		                        .notice-container { padding: 5px; }
		                        .logo { text-align: center; margin-bottom: 5px; }
		                        .logo img { width: 50px; height: 50px; }
		                        .header-text { text-align: center; font-size: 12px; }
		                        .details { font-size: 10px; line-height: 1.2; }
		                        .note { font-size: 8px; text-align: center; margin-top: 10px; }
		                        .page-break { page-break-before: always; }
		                    </style>
		                </head>
		                <body>`;

		        selectedAccounts.forEach((account, index) => {
		            printContent += `
		                <div class="notice-container ${index === 0 ? '' : 'page-break'}">
		                    <div class="logo">
		                        <img src="${logoUrl}" alt="Sta Cruz Water District Logo">
		                    </div>
		                    <div class="header-text">
		                        <h3>Sta Cruz Water District</h3>
		                        <h4>Water Bill Notice</h4>
		                        <h5>Billing Period: ${monthYear}</h5>
		                    </div>
		                    <hr>
		                    <div class="details">
		                        <p><strong>Account No:</strong> ${account.account_no}</p>
		                        <p><strong>Account Name:</strong> ${account.account_name}</p>
		                        <p><strong>Meter No:</strong> ${account.meter_no}</p>
		                        <p><strong>Zone/Book:</strong> ${account.zonebook}</p>
		                        <hr>
		                        <p><strong>Reading Date:</strong> ${readingDate}</p>
		                        <p><strong>Period Covered:</strong> ${coveredFrom} to ${coveredTo}</p>
		                        <p><strong>Due Date:</strong> ${dueDate}</p>
		                        <hr>
		                        <p><strong>Previous Reading:</strong> ${account.previous_reading}</p>
		                        <p><strong>Current Reading:</strong> ${account.current_reading}</p>
		                        <p><strong>Total Cubic Meters Used:</strong> ${account.consumed}</p>
		                        <p><strong>Total Amount Due:</strong> ${account.amount_due}</p>
		                        <hr>
		                    </div>
		                    <p class="note">
		                        <strong>Note:</strong> This is not an official receipt. To avoid inconvenience, please pay on or before the due date. Two months of unpaid water bill will result in disconnection of service without prior notice.
		                    </p>
		                </div>`;
		        });

		        printContent += `</body></html>`;

		        // Open new print window
		        let printWindow = window.open("", "", "width=1000,height=800");
		        printWindow.document.write(printContent);
		        printWindow.document.close();

		        // Wait for the image to load before printing
		        printWindow.onload = function () {
		            printWindow.print();
		        };
		    });
		});
    </script>

</body>

</html>