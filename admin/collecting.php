<!DOCTYPE html>
<html>          
    <?php include './include/head.php'; ?>
<body id="page-top">
    <div class="d-none" id="collecting"></div>

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
                            <h1 class="h3 mb-0 text-primary"><i class="fas fa-file-invoice fa-sm mr-2"></i>Collecting</h1>
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

                        <div class="row d-flex align-items-stretch mb-3">
                            <div class="col-sm-12 col-12">
						        <div class="card">
						            <div class="card-header bg-primary text-white">
						                Bill and Other Charges
						            </div>
						            <div class="card-body">
						                <div class="table-responsive">
	                                        <table class="table table-bordered nowrap text-center" id="readingSheetTable" width="100%" cellspacing="0">
	                                            <thead class="">
	                                                <tr>
	                                                    <th scope="col">Bill No</th>                                        
	                                                    <th scope="col">Description</th>                                        
	                                                    <th scope="col">Due Date</th>                                               
	                                                    <th scope="col">Amount Due</th>                            
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

						<!-- Payment Modal -->
						<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title text-primary" id="paymentModalLabel">
											<i class="fas fa-money-bill-wave fa-sm"></i>
											Bill Payment
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<div class="modal-body">
										<div class="container">
											<form id="paymentForm">
												<!-- <div class="form-group">
													<p class="modal-label font-weight-bold">Meter Id: <span class="font-weight-normal" id="meter_id"></span></p>
												</div> -->
												<div class="form-group">
													<p class="modal-label font-weight-bold">Account Name: <span class="font-weight-normal" id="account_name"></span></p>
												</div>
												<div class="form-group">
													<p class="modal-label  font-weight-bold">Account No: <span class="font-weight-normal" id="account_no"></span></p>
												</div>
												<div class="form-group">
													<p class="modal-label font-weight-bold">Bill No: <span class="font-weight-normal" id="bill_no"></span></p>
												</div>
												<div class="form-group">
													<p class="modal-label font-weight-bold">Description: <span class="font-weight-normal" id="description"></span></p>
												</div>
												<div class="form-group">
													<p class="modal-label font-weight-bold">Consumption (cu.m): <span class="font-weight-normal" id="consumption"></span></p>
												</div>
												<div class="form-group">
													<p class="modal-label font-weight-bold">Amount Due: <span class="font-weight-normal" id="amount_due"></span></p>
												</div>
												<div class="form-group">
													<p class="modal-label font-weight-bold">Due Date: <span class="font-weight-normal" id="due_date"></span></p>
												</div>
												<hr class="my-2">
												<input type="hidden" name="meter_reading_id" id="mridInput">
												<input type="hidden" name="meter_id" id="meterId">
												<input type="hidden" name="description" id="descInput">
												<input type="hidden" name="amount_due" id="adInput">
												<input type="hidden" name="due_date" id="ddInput">
												<div class="form-group">
													<label class="modal-label">Amount to Pay:</label>
													<input type="number" name="amount_paid" id="amount_paid" class="form-control" step="0.01" min="0">
												</div>
												<div class="form-group">
													<label class="modal-label">Change:</label>
													<input type="text" id="change" class="form-control" name="amount_change" readonly>
												</div>
											</form>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" id="confirmPayment">Confirm Payment</button>
									</div>
								</div>
							</div>
						</div>

				<div id="viewPaymentModal" class="modal fade" tabindex="-1">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-success" id="paymentModalLabel">
									<i class="fas fa-money-bill-wave fa-sm"></i>
									Payment Info
								</h5>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="modal-body">
								<div class="container">
									<!-- <p><strong>Meter Id:</strong> <span id="vp_meter_id" class=""></span></p> -->
									<p><strong>Account Name:</strong> <span id="vp_account_name" class=""></span></p>
									<p><strong>Account No:</strong> <span id="vp_account_no" class=""></span></p>
									<p><strong>Bill No:</strong> <span id="vp_bill_no" class=""></span></p>
									<p><strong>Description:</strong> <span id="vp_description" class=""></span></p>
									<p><strong>Amount Due:</strong> <span id="vp_amount_due" class=""></span></p>
									<p><strong>Discount pwd/senior:</strong> <span id="vp_discount" class=""></span></p>
									<p><strong>Amount Paid:</strong> <span id="vp_amount_paid" class=""></span></p>
									<p><strong>Change:</strong> <span id="vp_change" class=""></span></p>
									<p><strong>Payment Date:</strong> <span id="vp_payment_date" class=""></span></p>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">
									Close
								</button>
								<button type="button" class="btn btn-success" id="printReceiptBtn" >Print Receipt</button>
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

		$(document).on("click", ".modal .btn-secondary, .modal .close", function () {
			$(this).closest(".modal").modal("hide");
		});

		$(document).on("click", "#printReceiptBtn", function () {

		const SYSTEM_LOGO = "<?php echo isset($_SESSION['system_profile']) ? '../img/' . $_SESSION['system_profile'] : '../img/system_6965ed6ed6091.png'; ?>";

			const receiptData = {
				account_name: $("#vp_account_name").text(),
				account_no: $("#vp_account_no").text(),
				bill_no: $("#vp_bill_no").text(),
				description: $("#vp_description").text(),
				amount_due: $("#vp_amount_due").text(),
				amount_paid: $("#vp_amount_paid").text(),
				change: $("#vp_change").text(),
				payment_date: $("#vp_payment_date").text()
			};

			let html = `
			<html>
			<head>
				<title>Payment Receipt</title>
				<style>
					body { font-family: Arial, sans-serif; font-size: 12px; }
						.receipt { width: 300px; margin: auto; text-align: center; }

						.receipt img {
							width: 50px;        /*FIXED LOGO SIZE */
							height: auto;
							margin-bottom: 6px;
						}
					h3, p { text-align: center; margin: 4px 0; }
					hr { border-top: 1px dashed #000; }
					table { width: 100%; margin-top: 10px; }
					td { 
						padding: 4px;
						font-size: 10px; 
					}
					.right { 
						text-align: right; 
					}
				</style>
			</head>
			<body>
				<div class="receipt">
					<img src="${SYSTEM_LOGO}">
					<h3>STA CRUZ WATER DISTRICT</h3>
					<p>Poblacion South, Sta. Cruz, Zambales</p>
					<hr>

					<table>
						<tr><td>Account Name</td><td class="right">${receiptData.account_name}</td></tr>
						<tr><td>Account No</td><td class="right">${receiptData.account_no}</td></tr>
						<tr><td>Bill No</td><td class="right">${receiptData.bill_no}</td></tr>
					</table>
					<hr>
					<table>
						<tr>
						<td class="center" style="font-size: 13px; text-align: center;">${receiptData.description}</td>
						</tr>
					</table>

					<hr>

					<table>
						<tr><td>Amount Due:</td><td class="right">${receiptData.amount_due}</td></tr>
						<tr><td>Amount Paid:</td><td class="right">${receiptData.amount_paid}</td></tr>
						<tr><td>Change:</td><td class="right">${receiptData.change}</td></tr>
					</table>

					<hr>

					<p>Payment Date</p>
					<p><strong>${receiptData.payment_date}</strong></p>

					<hr>
					<p>Thank you for your payment!</p>
				</div>
			</body>
			</html>
			`;

			let win = window.open("", "", "width=400,height=600");
			win.document.write(html);
			win.document.close();
			win.onload = () => win.print();
		});

    	$(document).ready(function () {
		    // Initialize Selectize for account number input
		    var selectize = $('#account_number').selectize({
		        valueField: 'account_no',
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

		    // Get Selectize instance
		    var selectizeInstance = selectize[0].selectize;

		    var fetchedResponse = null; // Store response globally

			function searchBtn(){
		        var account_no = selectizeInstance.getValue(); // Get selected account number

		        if (account_no) {
		            $.ajax({
		                url: 'action/fetch_bills.php',
		                type: 'POST',
		                data: { account_no: account_no },
		                dataType: 'json',
		                success: function (response) {
		                    if (response.success) {
		                        fetchedResponse = response; // Store response globally

		                        // Populate account details
								$('#meter_id').text(response.account.meter_id);
		                        $('#accountNumber').text(response.account.account_no);
		                        $('#accountName').text(response.account.account_name);
		                        $('#accountStatus').text(response.account.service_status);
		                        $('#accountType').text(response.account.account_type);
		                        $('#accountClassification').text(response.account.classification);
		                        $('#accountAddress').text(response.account.barangay);

		                        // Populate billing table
		                        var billsTableBody = $('#readingSheetTable tbody');
		                        billsTableBody.empty(); // Clear previous data

		                        response.bills.forEach(function (bill) {
								    var row = `
								        <tr>
								            <td>${bill.meter_reading_id}</td>
								            <td>${bill.description}</td>
								            <td>${bill.date_due}</td>
								            <td>₱${bill.amount}</td>
								            <td>${bill.button}</td>
								        </tr>
								    `;
								    billsTableBody.append(row);
								});

		                        // Enable Clear button
		                        $('#clearBtn').prop('disabled', false);
		                    } else {
		                        Swal.fire({
		                            icon: 'warning',
		                            title: 'Oops...',
		                            text: response.message,
		                        });
		                    }
		                },
		                error: function () {
		                    Swal.fire({
		                        icon: 'error',
		                        title: 'Error',
		                        text: 'An error occurred while fetching data.',
		                    });
		                }
		            });
		        } else {
		            Swal.fire({
		                icon: 'warning',
		                title: 'Invalid Selection',
		                text: 'Please select a valid account number.',
		            });
		        }
			}

			selectizeInstance.on('change', function(value){
				if(value){
					searchBtn()
				}
			})

			$('#searchAccountBtn').on('click', function(e){
				e.preventDefault();
				searchBtn();
			})



		    // Clear account details and table when Clear button is clicked
		    $('#clearBtn').on('click', function () {
		        $('#accountNumber, #accountName, #accountStatus, #accountType, #accountClassification, #accountAddress').text('');
                selectizeInstance.clear();

		        $('#readingSheetTable tbody').empty();
		        $('#clearBtn').prop('disabled', true);
		    });

		    // Handle payment button click
			$(document).on("click", ".payBillBtn", function () {
			    var billId = $(this).data("bill-id");

			    if (fetchedResponse && fetchedResponse.bills) {
			        var billData = fetchedResponse.bills.find(bill => bill.meter_reading_id == billId);

			        if (billData) {
			            // Set text for visible fields
						$('#meter_id').text(fetchedResponse.account.meter_id);
			            $("#account_name").text(fetchedResponse.account.account_name);
			            $("#account_no").text(fetchedResponse.account.account_no);
			            $("#bill_no").text(billData.meter_reading_id);
			            $("#description").text(billData.description);
			            $("#consumption").text(billData.consumed + " cu.m");
			            $("#amount_due").text(parseFloat(billData.amount).toFixed(2));
			            $("#due_date").text(billData.date_due);

			            // Set values for hidden inputs\
						$("#meterId").val(billData.meter_id);
			            $("#mridInput").val(billData.meter_reading_id);
			            $("#descInput").val(billData.description);
			            $("#adInput").val(parseFloat(billData.amount).toFixed(2));
			            
			            // Assuming billData.date_due is "November 4, 2024"
						let dateStr = billData.date_due;

						// Convert to Date object
						let dateObj = new Date(dateStr);

						// Format as YYYY-MM-DD
						let formattedDate = dateObj.toISOString().split('T')[0];

						// Set the input value
						$("#ddInput").val(formattedDate);

			            // Reset payment fields
			            $("#amount_paid").val("");
			            $("#change").val("");

			            // Show the modal
			            $("#paymentModal").modal("show");
			        } else {
			            Swal.fire("Error", "Bill data not found.", "error");
			        }
			    } else {
			        Swal.fire("Error", "Bill information is unavailable.", "error");
			    }
			});

		    // Calculate change dynamically
		    $("#amount_paid").on("input", function () {
		        var amountDue = parseFloat($("#amount_due").text()) || 0;
		        var amountPaid = parseFloat($(this).val()) || 0;
		        var change = amountPaid - amountDue;

		        $("#change").val(change >= 0 ? change.toFixed(2) : "0.00");
		    });

		    // Handle Payment Confirmation
			$("#confirmPayment").click(function () {
			    var formData = $("#paymentForm").serialize(); // Serialize the form data

			    var amountPaid = $("#amount_paid").val();
			    var amountDue = parseFloat($("#amount_due").text());

			    if (amountPaid === "" || parseFloat(amountPaid) < amountDue) {
			        Swal.fire("Error", "Amount paid must be equal to or greater than the amount due.", "warning");
			        return;
			    }

			    // Calculate change
			    var amountChange = parseFloat(amountPaid) - amountDue;

			    $.ajax({
			        url: "action/process_payment.php",
			        type: "POST",
			        data: formData,
			        success: function (response) {
			            Swal.fire("Success", "Payment successful!", "success").then(() => {
			                $("#paymentModal").modal("hide");
			                reloadBillsTable(); // Reload only the table instead of the whole page
			            });
			        },
			        error: function () {
			            Swal.fire("Error", "Payment failed. Please try again.", "error");
			        }
			    });
			});

			// Function to reload bills table dynamically
			function reloadBillsTable() {
				$.ajax({
					url: "action/fetch_bills.php",
					type: "GET",
					data: { account_no: selectizeInstance.getValue() },
					success: function (response) {
						var data;
						try {
							data = typeof response === 'object' ? response : JSON.parse(response);
						} catch (e) {
							console.error("Invalid JSON response:", response);
							$("#readingSheetTable tbody").html("<tr><td colspan='5' class='text-center'>Failed to load data</td></tr>");
							return;
						}

						var billsTableBody = $("#readingSheetTable tbody");
						billsTableBody.empty();

						if (data.success && data.bills.length > 0) {
							data.bills.forEach(function (bill) {
								var row = `
									<tr>
										<td>${bill.meter_reading_id}</td>
										<td>${bill.description}</td>
										<td>${bill.date_due}</td>
										<td>₱${bill.amount}</td>
										<td>${bill.button}</td>
									</tr>
								`;
								billsTableBody.append(row);
							});
						} else {
							billsTableBody.html("<tr><td colspan='5' class='text-center'>No records found</td></tr>");
						}
					},
					error: function (xhr, status, error) {
						console.error("Failed to reload bills table:", status, error);
						$("#readingSheetTable tbody").html("<tr><td colspan='5' class='text-center'>Error fetching data</td></tr>");
					}
				});
			}


			$(document).on("click", ".viewBillBtn", function () {
				let billId = $(this).data("bill-id");

				$.ajax({
					url: "action/fetch_payment_info.php",
					type: "POST",
					data: { bill_id: billId },
					dataType: "json",

					success: function (response) {
						if (!response || response.success !== true) {
							Swal.fire(
								"Error",
								response?.message || "Invalid response from server.",
								"error"
							);
							return;
						}

						let account = response.account;
						let bill = response.bills?.length ? response.bills[0] : null;

						if (account) {
							$("#vp_account_name").text(account.account_name);
							$("#vp_account_no").text(account.account_no);
						} else {
							$("#vp_account_name, #vp_account_no").text("N/A");
						}

						if (bill) {
							$("#vp_bill_no").text(bill.meter_reading_id);
							$("#vp_description").text(bill.description);
							$("#vp_amount_due").text(`₱${parseFloat(bill.amount).toFixed(2)}`);
							$("#vp_amount_paid").text(`₱${parseFloat(bill.amount_paid).toFixed(2)}`);
							$("#vp_discount").text(`₱${parseFloat(bill.discountAmount).toFixed(2)}`);
							$("#vp_change").text(`₱${parseFloat(bill.amount_change).toFixed(2)}`);
							$("#vp_payment_date").text(bill.payment_date);
						} else {
							$("#vp_bill_no, #vp_description, #vp_amount_due, #vp_amount_paid, #vp_change, #vp_payment_date")
								.text("N/A");
						}

						$("#viewPaymentModal").modal("show");
					},

					error: function (xhr) {
						console.error("AJAX ERROR:", xhr.responseText);
						Swal.fire(
							"Error",
							"Failed to fetch payment details.",
							"error"
						);
					}
				});
			});


		});
    </script>

</body>

</html>