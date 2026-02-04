<script>
$(document).ready(function () {
    $("#showUnbilled").click(function (e) {
        e.preventDefault();

        // Clear validation feedback
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

                    const today = new Date();

                    const formattedDate = today.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: '2-digit'
                    });

                    console.log(formattedDate);
                    response.data.forEach((item) => {
                        let previousReading = item.previous_reading !== null ? item.previous_reading : 'N/A';
                        let consumedVal;

                        if (item.consumed !== null) {
                            consumedVal = item.consumed;
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
                            formattedDate,
                            item.action
                        ]);
                    });
                    table.draw();

                    // Hide "Reading Date" column (10th index: 0-based)
                    table.column(9).visible(false);
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
        let previousReading = row.find('td').eq(6).text();
        let currentReading = $(this).val();
        previousReading = parseFloat(previousReading) || 0;
        currentReading = parseFloat(currentReading) || 0;
        let consumed = currentReading - previousReading;
        row.find('.consumed').text(consumed.toFixed(2));
    });
});

</script>
