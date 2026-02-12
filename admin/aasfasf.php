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
                <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-primary"><i class="fas fa-receipt fa-sm mr-2"></i>Billing</h1>
                        </div>

                        <hr class="bg-primary">

                        <!-- Content Row -->
                                        
                        <div class="row d-flex align-items-stretch mb-3">
                            <div class="col-sm-12 col-12">
						        <div class="card border-primary">
						            <div class="card-header bg-primary text-white">
						                Reading Information
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

										            	<!-- Show billed accounts checkbox -->
														<div class="form-check">
														    <input class="form-check-input" type="checkbox" id="showBilled">
														    <label class="form-check-label text-primary" for="showBilled">
														        Show Billed Accounts
														    </label>
														</div>

														<hr>

										                <!-- Generate Reading Button -->
								                        <div class="form-group">
								                            <button class="btn btn-success shadow-sm w-100" id="generateBtn">Generate Reading Sheet</button>
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
						                Reading Sheet
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
	                                                    <th scope="col">Barangay Name</th>                                        
	                                                    <th scope="col">Meter No</th>                                               
	                                                    <th scope="col">Zone/Book</th>                            
	                                                    <th scope="col">Previous Reading</th>                            
	                                                    <th scope="col">Current Reading</th>                            
	                                                    <th scope="col" class="text-center">Consumed</th>
	                                                    <th scope="col" class="text-center">Reading Date</th>
	                                                    <th scope="col">Action</th>
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
    		$('#selectAll').on('change', function() {
			    $('.select-account:not(:disabled)').prop('checked', this.checked);
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

		    // Trigger change event on zone/book selection
		    $('#zonebook_id').change(function () {
		        const zonebookTextSelected = $(this).find("option:selected").text(); // Get text of selected option

		        if (zonebookTextSelected) {
		            $('#zoneBookSelected').text(zonebookTextSelected);
		        }
		    });
		});	
    </script>

    <script>
		$(document).ready(function () {
		    $("#generateBtn").click(function (e) {
		        e.preventDefault();

		        // Clear validation feedback
		        $("#zonebook_id, #billing_schedule_id").removeClass("is-invalid");

		        // Get selected values
		        let zonebookId = $("#zonebook_id").val();
		        let billingID = $("#billing_schedule_id").val();
		        let showBilled = $("#showBilled").is(":checked") ? 1 : 0;

		        // Validate if billing schedule and zone/book are selected
		        if (!zonebookId || !billingID) {
		            if (!zonebookId) $("#zonebook_id").addClass("is-invalid");
		            if (!billingID) $("#billing_schedule_id").addClass("is-invalid");

		            Swal.fire({
		                icon: "error",
		                title: "Oops..",
		                text: !zonebookId && !billingID 
		                    ? "Please select a billing schedule and zone/book before generating the reading sheet." 
		                    : !zonebookId 
		                    ? "Please select a zone/book before generating the reading sheet." 
		                    : "Please select a billing schedule before generating the reading sheet.",
		            });
		            return;
		        }

		        // Fetch data via AJAX
		        $.ajax({
		            url: "action/fetch_reading_sheet.php",
		            type: "POST",
		            data: {
		                zonebook_id: zonebookId,
		                billing_schedule_id: billingID,
		                show_billed: showBilled   // send checkbox state
		            },
		            dataType: "json",
		            beforeSend: function () {
		                Swal.fire({
		                    title: "Generating...",
		                    text: "Please wait while the reading sheet is being prepared.",
		                    allowOutsideClick: false,
		                    didOpen: () => {
		                        Swal.showLoading();
		                    },
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
							    let previousReading = item.previous_reading !== null ? item.previous_reading : 'N/A';
							    let consumedVal;

							    if (item.consumed !== null) {
							        consumedVal = item.consumed; // use DB value for billed
							    } else if (
							        !isNaN(item.current_reading) &&
							        !isNaN(previousReading) &&
							        item.current_reading !== '' &&
							        previousReading !== 'N/A'
							    ) {
							        consumedVal = parseFloat(item.current_reading) - parseFloat(previousReading);
							    } else {
							        consumedVal = 0;
							    }

							    table.row.add([
							        item.checkbox,
							        item.account_no,
							        item.account_name,
                                    item.barangay_name,
							        item.meter_no,
							        item.zonebook,
							        previousReading,
							        item.current_reading,
							        '<span class="consumed">' + consumedVal + '</span>',
                                    item.reading_date,
							        item.action
							    ]);
							});
		                    table.draw();
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

		    // Keep your current-reading input listener
		    $('#readingSheetTable').on('input', '.current-reading', function() {
		        let row = $(this).closest('tr');
		        let previousReading = row.find('td').eq(5).text();
		        let currentReading = $(this).val();
		        previousReading = parseFloat(previousReading) || 0;
		        currentReading = parseFloat(currentReading) || 0;
		        let consumed = currentReading - previousReading;
		        row.find('.consumed').text(consumed.toFixed(2));
		    });
		});
    </script>

    <script>
		$(document).ready(function () {
		    // Handle Bill button click
		    $('#readingSheetTable').on('click', '.generate-bill', function () {
		        $('.current-reading').removeClass('is-invalid');

		        let button = $(this); // Reference the clicked button
		        let row = button.closest('tr'); // Find the row containing the button
		        let meterId = button.data('account'); // Get meter ID from data attribute
		        let currentReadingInput = row.find('.current-reading'); // Find the current reading input
		        let currentReading = currentReadingInput.val(); // Get current reading value
		        let billingScheduleId = $('#billing_schedule_id').val(); // Billing schedule ID
		        let readingDate = new Date().toISOString().slice(0, 10);
		        let consumed = row.find('.consumed').text(); // Get consumed value from the row

		        // Validate current reading
		        if (!currentReading) {
		            Swal.fire({
		                icon: 'warning',
		                title: 'Missing Data',
		                text: 'Please enter the current reading before generating the bill.',
		            });
		            currentReadingInput.addClass('is-invalid');
		            return;
		        }

		        // AJAX request to save the billing data
		        $.ajax({
		            url: 'action/save_reading.php',
		            type: 'POST',
		            data: {
		                meters_id: meterId,
		                billing_schedule_id: billingScheduleId,
		                reading_date: readingDate,
		                current_reading: currentReading,
		                consumed: consumed
		            },
		            dataType: 'json',
		            beforeSend: function () {
		                Swal.fire({
		                    title: 'Saving...',
		                    text: 'Please wait while the billing data is being saved.',
		                    allowOutsideClick: false,
		                    didOpen: () => {
		                        Swal.showLoading();
		                    },
		                });
		            },
		            success: function (response) {
		                Swal.close();

		                if (response.success) {
		                    Swal.fire({
		                        icon: 'success',
		                        title: 'Saved',
		                        text: 'Billing data has been successfully saved.',
		                    }).then(() => {
		                        // Remove the billed row from the table
		                        row.fadeOut(300, function () {
		                            $(this).remove();
		                        });
		                    });
		                } else {
		                    Swal.fire({
		                        icon: 'error',
		                        title: 'Error',
		                        text: response.message || 'Failed to save billing data. Please try again.',
		                    });
		                }
		            },
		            error: function () {
		                Swal.fire({
		                    icon: 'error',
		                    title: 'Error',
		                    text: 'An unexpected error occurred. Please try again.',
		                });
		            },
		        });
		    });

		    // Handle Update button
			$('#readingSheetTable').on('click', '.update-bill', function () {
			    let row = $(this).closest('tr');
			    let currentInput = row.find('.current-reading');
			    let billBtn = row.find('.regenerate-bill');
			    let updateBtn = $(this);

			    // Enable the input and Bill button again
			    currentInput.prop('disabled', false).removeClass('form-control-plaintext').addClass('form-control border-primary');
			    billBtn.prop('disabled', false).removeClass('btn-outline-primary').addClass('btn-primary');

			    // Disable Update button until regenerate is done
    			updateBtn.prop('disabled', true).removeClass('btn-info').addClass('btn-outline-info');
			});

			// Handle Regenerate Bill button click
			$('#readingSheetTable').on('click', '.regenerate-bill', function () {
			    $('.current-reading').removeClass('is-invalid');

			    let button = $(this); // Reference the clicked button
			    let row = button.closest('tr'); // Find the row containing the button
			    let meterId = button.data('account'); // Get meter ID
			    let readingId = button.data('reading-id'); // Existing reading ID
			    let currentReadingInput = row.find('.current-reading'); // Find the input
			    let currentReading = currentReadingInput.val(); // Get value
			    let billingScheduleId = $('#billing_schedule_id').val(); // Billing schedule
			    let readingDate = new Date().toISOString().slice(0, 10);
			    let consumed = row.find('.consumed').text(); // Get consumed

			    // Validation
			    if (!currentReading) {
			        Swal.fire({
			            icon: 'warning',
			            title: 'Missing Data',
			            text: 'Please enter the current reading before regenerating the bill.',
			        });
			        currentReadingInput.addClass('is-invalid');
			        return;
			    }

			    // AJAX request to update the billing data
			    $.ajax({
			        url: 'action/update_reading.php',
			        type: 'POST',
			        data: {
			            meter_reading_id: readingId,
			            meters_id: meterId,
			            billing_schedule_id: billingScheduleId,
			            reading_date: readingDate,
			            current_reading: currentReading,
			            consumed: consumed
			        },
			        dataType: 'json',
			        beforeSend: function () {
			            Swal.fire({
			                title: 'Updating...',
			                text: 'Please wait while the bill is being regenerated.',
			                allowOutsideClick: false,
			                didOpen: () => {
			                    Swal.showLoading();
			                },
			            });
			        },
			        success: function (response) {
			            Swal.close();

			            if (response.success) {
			                Swal.fire({
			                    icon: 'success',
			                    title: 'Updated',
			                    text: 'Bill has been successfully regenerated.',
			                });

			                // Disable regenerate after success
			                button.prop('disabled', true).removeClass('btn-primary').addClass('btn-outline-primary');

			                // Also lock the input again (plaintext style)
			                currentReadingInput.prop('disabled', true).removeClass('form-control border-primary').addClass('form-control-plaintext');

			                // Re-enable the Update button for future edits
						    row.find('.update-bill').prop('disabled', false).removeClass('btn-outline-info').addClass('btn-info');
			            } else {
			                Swal.fire({
			                    icon: 'error',
			                    title: 'Error',
			                    text: response.message || 'Failed to regenerate bill.',
			                });
			            }
			        },
			        error: function () {
			            Swal.fire({
			                icon: 'error',
			                title: 'Error',
			                text: 'An unexpected error occurred. Please try again.',
			            });
			        },
			    });
			});
		});
		</script>

		                    <!-- <a href="#" class="btn btn-sm btn-danger shadow-sm delete-concessionaire-btn"
                        data-concessionaire-id="' . $encryptedData . '" 
                        data-concessionaire-name="' . htmlspecialchars($row['full_name']) . '"
                        data-concessionaire-address="' . htmlspecialchars($row['billing_address']) . '">
                        <i class="fa-solid fa-trash"></i>
                    </a> -->


</body>

</html>