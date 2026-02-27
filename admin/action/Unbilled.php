<script>
$(document).ready(function () {

    /* =========================================
       ENTER KEY → TRIGGER BILL BUTTON
    ========================================== */
    $('#readingSheetTable').on('keydown', '.current-reading', function(e) {
        if (e.key === "Enter") {
            e.preventDefault();

            let row = $(this).closest('tr');
            let currentValue = $(this).val();

            if (!currentValue || parseFloat(currentValue) <= 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Invalid Reading",
                    text: "Please enter a valid current reading before billing."
                });
                return;
            }

            row.find('.generate-bill').trigger('click');
        }
    });

    /* =========================================
       GENERATE BILL BUTTON CLICK
    ========================================== */
    $('#readingSheetTable').on('click', '.generate-bill', function () {

        let row = $(this).closest('tr');
        let input = row.find('.current-reading');
        let currentReading = input.val();

        if (!currentReading || parseFloat(currentReading) <= 0) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Reading",
                text: "Please enter a valid current reading."
            });
            return;
        }

        let prev = parseFloat(input.data('prev')) || 0;
        let consumed = (currentReading - prev).toFixed(2);
        let metersId = $(this).data('account');

        // STEP 1: Save the reading first (old save_reading.php logic)
        $.ajax({
            url: 'action/save_reading.php',
            type: 'POST',
            dataType: 'json',
            data: {
                meters_id: metersId,
                billing_schedule_id: $('#billing_schedule_id').val(),
                reading_date: new Date().toISOString().slice(0,10),
                current_reading: currentReading,
                consumed: consumed
            },
            success(res) {
                if (res.success) {
                    // STEP 2: After saving, check for other billing
                    checkOtherBilling(metersId, currentReading, row);
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error() {
                Swal.fire('Error', 'Failed to save reading.', 'error');
            }
        });
    });

    /* =========================================
       CHECK OTHER BILLING
    ========================================== */
    function checkOtherBilling(metersId, currentReading, row) {
        $.ajax({
            url: "action/check_other_billing.php",
            type: "POST",
            data: { meters_id: metersId },
            dataType: "json",
            success: function (response) {

                if (response.hasOtherBilling) {
                    let tbody = $("#otherBillingTable tbody");
                    tbody.empty();

                    response.data.forEach(function (item) {
                        tbody.append(`
                            <tr>
                                <td><input type="checkbox" class="other-bill-check" value="${item.other_billing_id}" checked></td>
                                <td>${item.description}</td>
                                <td>${item.quantity}</td>
                                <td>${item.price_per_units}</td>
                                <td>${item.amount_due}</td>
                            </tr>
                        `);
                    });

                    $("#confirmOtherBilling")
                        .data("meters", metersId)
                        .data("reading", currentReading)
                        .data("row", row); // store the row

                    $("#otherBillingModal").modal("show");

                } else {
                    // No other billing → Ask confirmation first
                    Swal.fire({
                        title: "Confirm Billing?",
                        text: "No additional charges found.",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Continue",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            proceedBilling(metersId, currentReading, [], row);
                        }
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to check other billing records."
                });
            }
        });
    }

    /* =========================================
       CONFIRM OTHER BILLING (MODAL BUTTON)
    ========================================== */
    $('#confirmOtherBilling').click(function () {

        let metersId = $(this).data("meters");
        let reading = $(this).data("reading");
        let row = $(this).data("row");

        let selectedOtherBills = [];
        $('.other-bill-check:checked').each(function () {
            selectedOtherBills.push($(this).val());
        });

        $("#otherBillingModal").modal("hide");

        // Ask confirmation before billing
        Swal.fire({
            title: "Confirm Billing?",
            text: "Continue with selected additional charges?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Continue"
        }).then((result) => {
            if (result.isConfirmed) {
                proceedBilling(metersId, reading, selectedOtherBills, row);
            }
        });
    });

    /* =========================================
       MAIN BILLING FUNCTION
    ========================================== */
    function proceedBilling(metersId, reading, otherBills, row) {
        $.ajax({
            url: "action/process_billing.php",
            type: "POST",
            data: {
                meters_id: metersId,
                current_reading: reading,
                other_bills: otherBills
            },
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Processing Billing...",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading(),
                });
            },
            success: function (response) {
                Swal.close();

                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Billing Successful"
                    }).then(() => {
                        if (row) row.fadeOut(); // fade out only the billed row
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Billing Failed",
                        text: response.message || "Something went wrong."
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Unable to process billing."
                });
            }
        });
    }

    /* =========================================
       AUTO COMPUTE CONSUMED
    ========================================== */
    $('#readingSheetTable').on('input', '.current-reading', function() {

        let row = $(this).closest('tr');
        let previousReading = row.find('td').eq(6).text();
        let currentReading = $(this).val();

        previousReading = parseFloat(previousReading) || 0;
        currentReading = parseFloat(currentReading) || 0;

        let consumed = currentReading - previousReading;
        row.find('.consumed').text(consumed.toFixed(2));
    });

    /* =========================================
       GENERATE READING SHEET
    ========================================== */
    $("#showUnbilled").click(function (e) {
        e.preventDefault();

        $("#zonebook_id, #billing_schedule_id").removeClass("is-invalid");

        let zonebookId = $("#zonebook_id").val();
        let billingID = $("#billing_schedule_id").val();
        let showBilled = 0;

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

        $.ajax({
            url: "action/fetch_reading_sheet.php",
            type: "POST",
            data: {
                zonebook_id: zonebookId,
                billing_schedule_id: billingID,
                show_billed: showBilled
            },
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: "Generating...",
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

                    const today = new Date();
                    const formattedDate = today.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: '2-digit'
                    });

                    response.data.forEach((item) => {

                        let previousReading = item.previous_reading !== null ? item.previous_reading : 'N/A';
                        let consumedVal = item.consumed ?? 0;

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
                            formattedDate,
                            item.action
                        ]);
                    });

                    table.draw();
                    table.column(9).visible(false);

                } else {
                    table.clear().draw();
                    Swal.fire({
                        icon: "info",
                        title: "No Data",
                        text: response.message || "No records found."
                    });
                }
            }
        });
    });

});
</script>