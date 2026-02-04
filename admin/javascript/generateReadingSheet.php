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

    function togglePrintOptions(mode) {
        // mode: "billed" or "unbilled"
        if (mode === "billed") {
            $("#printNoticeBtn, #printAllTableBtn").show();
            $("#printUnbilledBtn").hide();
        } else if (mode === "unbilled") {
            $("#printNoticeBtn, #printAllTableBtn").hide();
            $("#printUnbilledBtn").show();
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
                                    let curr = parseFloat(row.current_reading) || 0;
                                    let consumed = data !== null ? parseFloat(data) : (curr - prev);
                                    return `<span class="consumed">${consumed.toFixed(2)}</span>`;
                                }
                            },
                            { data: 'reading_date' },
                            { data: 'action' }
                        ]
                    });

                    toggleBillingActionButtons();

                    // Toggle print options based on billed/unbilled
                    if (showBilled == 1) togglePrintOptions("billed");
                    else togglePrintOptions("unbilled");

                } else {
                    readingTable = $("#readingSheetTable").DataTable({
                        scrollX: true,
                        order: []
                    });
                    Swal.fire("No Data", "No records found.", "info");
                    // Hide all print options if no data
                    $("#printNoticeBtn, #printAllTableBtn, #printUnbilledBtn").hide();
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

    // Show Billed button
    $("#generateBtn").on("click", function (e) {
        e.preventDefault();
        generateReadingSheet(1); // 1 = show billed
        togglePrintOptions("billed");
    });

    // Show Unbilled button
    $("#showUnbilled").on("click", function (e) {
        e.preventDefault();
        generateReadingSheet(0); // 0 = show unbilled
        togglePrintOptions("unbilled");
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

    // On page load, default print option
    togglePrintOptions("billed");
});

</script>