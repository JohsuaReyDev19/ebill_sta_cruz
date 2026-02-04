$(document).ready(function () {

    let readingTable;

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
        }
    }

    function generateReadingSheet() {

        $("#zonebook_id, #billing_schedule_id").removeClass("is-invalid");

        let zonebookId = $("#zonebook_id").val();
        let billingID = $("#billing_schedule_id").val();
        let showBilled = $("#showBilled").is(":checked") ? 1 : 0;

        if (!zonebookId || !billingID) {
            if (!zonebookId) $("#zonebook_id").addClass("is-invalid");
            if (!billingID) $("#billing_schedule_id").addClass("is-invalid");
            $("#printNoticeBtn").prop("disabled", true);
            return;
        }

        $("#userStatusDropdown").prop("disabled", false);
        $("#userStatusControls").prop("disabled", false);

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

                readingTable = $("#readingSheetTable").DataTable({
                    scrollX: true,
                    order: []
                });

                readingTable.clear();

                if (response.success && response.data.length > 0) {

                    response.data.forEach((item) => {

                        let previousReading =
                            item.previous_reading !== null
                                ? parseFloat(item.previous_reading)
                                : null;

                        // extract value from input HTML
                        let currentReadingVal = $('<div>')
                            .html(item.current_reading)
                            .find('input')
                            .val();

                        currentReadingVal = parseFloat(currentReadingVal) || 0;

                        let consumedVal = 0;

                        if (item.consumed !== null) {
                            consumedVal = parseFloat(item.consumed);
                        } else if (previousReading !== null) {
                            consumedVal = currentReadingVal - previousReading;
                        }

                        readingTable.row.add([
							item.checkbox,
							item.account_no,
							item.account_name,
							item.barangay_name,
							item.meter_no,
							item.zonebook,
							previousReading !== null ? previousReading : 'N/A',
							item.current_reading,
							'<span class="consumed">' + consumedVal.toFixed(2) + '</span>',
							item.reading_date,
							item.action
						]);
                    });

                    readingTable.draw();

                    // APPLY BUTTON VISIBILITY AFTER TABLE LOAD
                    toggleBillingActionButtons();

                } else {
                    readingTable.clear().draw();
                    Swal.fire({
                        icon: "info",
                        title: "No Data",
                        text: response.message || "No records found for the selected zone/book."
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred while generating the reading sheet."
                });
            }
        });
    }

    /* =====================================================
       EVENTS
    ===================================================== */

    // Auto reload
    $("#zonebook_id").on("change", generateReadingSheet);
    $("#billing_schedule_id").on("change", function () {
        generateReadingSheet();
        toggleBillingActionButtons();
    });

    $("#generateBtnShowbilled").on("click", function (e) {
        e.preventDefault();
        generateReadingSheet();
    });

    // Live consumed computation
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