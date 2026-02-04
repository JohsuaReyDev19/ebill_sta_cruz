<script>
$(document).ready(function () {
    $("#printReportsBtn").show();

    let readingTable = null;

    /* =========================
       TOGGLE BILL ACTIONS
    ========================== */
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
        if (mode === "billed") {
            $("#printNoticeBtn, #printAllTableBtn").show();
            $("#printUnbilledBtn").hide();
        } else {
            $("#printNoticeBtn, #printAllTableBtn").hide();
            $("#printUnbilledBtn").show();
        }
    }

    /* =========================
       GENERATE READING SHEET
    ========================== */
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
                            { data: 'previous_reading' },
                            { data: 'current_reading' },
                            {
                                data: 'consumed',
                                render: d => `<span class="consumed">${parseFloat(d).toFixed(2)}</span>`
                            },
                            { data: 'reading_date' },
                            { data: 'action' }
                        ]
                    });

                    toggleBillingActionButtons();
                    togglePrintOptions(showBilled == 1 ? "billed" : "unbilled");

                } else {
                    readingTable = $("#readingSheetTable").DataTable({ scrollX: true });
                    Swal.fire("No Data", "No records found.", "info");
                    $("#printNoticeBtn, #printAllTableBtn, #printUnbilledBtn").hide();
                }
            },
            error() {
                Swal.fire("Error", "Failed to load reading sheet.", "error");
            }
        });
    }

    $("#zonebook_id, #billing_schedule_id").on("change", generateReadingSheet);

    $("#generateBtn").on("click", e => {
        e.preventDefault();
        generateReadingSheet(1);
    });

    $("#showUnbilled").on("click", e => {
        e.preventDefault();
        generateReadingSheet(0);
    });

    /* =========================
       LIVE CONSUMED CALC (FIXED)
    ========================== */
    $('#readingSheetTable').on('input', '.current-reading', function () {
        let prev = parseFloat($(this).data('prev')) || 0;
        let curr = parseFloat($(this).val()) || 0;
        $(this).closest('tr').find('.consumed').text((curr - prev).toFixed(2));
    });

    /* =========================
       UPDATE MODE
    ========================== */
    $('#readingSheetTable').on('click', '.update-bill', function () {

        let row = $(this).closest('tr');
        let input = row.find('.current-reading');

        $('#readingSheetTable tr').not(row).each(function () {
            let other = $(this).find('.current-reading');
            if (!other.prop('disabled')) {
                $(this).find('.cancel-update').click();
            }
        });

        if (input.data('original') === undefined) {
            input.data('original', input.val());
        }

        input.prop('disabled', false)
             .removeClass('form-control-plaintext')
             .addClass('form-control border-primary');

        row.find('.update-bill').addClass('d-none');
        row.find('.regenerate-bill, .cancel-update').removeClass('d-none');
    });

    /* =========================
       CANCEL UPDATE
    ========================== */
    $('#readingSheetTable').on('click', '.cancel-update', function () {

        let row = $(this).closest('tr');
        let input = row.find('.current-reading');

        let original = input.data('original');
        let prev = parseFloat(input.data('prev')) || 0;

        input.val(original);
        row.find('.consumed').text((original - prev).toFixed(2));

        input.prop('disabled', true)
             .removeClass('form-control border-primary')
             .addClass('form-control-plaintext');

        row.find('.regenerate-bill, .cancel-update').addClass('d-none');
        row.find('.update-bill').removeClass('d-none');
    });

    /* =========================
       GENERATE BILL (UNBILLED)
    ========================== */
    $('#readingSheetTable').on('click', '.generate-bill', function () {

        let row = $(this).closest('tr');
        let input = row.find('.current-reading');
        let currentReading = input.val();

        if (!currentReading) {
            Swal.fire('Missing Data', 'Please enter the current reading.', 'warning');
            return;
        }

        let prev = parseFloat(input.data('prev')) || 0;
        let consumed = (currentReading - prev).toFixed(2);

        $.ajax({
            url: 'action/save_reading.php',
            type: 'POST',
            dataType: 'json',
            data: {
                meters_id: $(this).data('account'),
                billing_schedule_id: $('#billing_schedule_id').val(),
                reading_date: new Date().toISOString().slice(0,10),
                current_reading: currentReading,
                consumed: consumed
            },
            success(res) {
                if (res.success) {
                    Swal.fire('Saved', 'Billing data saved.', 'success')
                        .then(() => row.fadeOut());
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }
        });
    });

    /* =========================
       REGENERATE BILL (FIXED)
    ========================== */
    $('#readingSheetTable').on('click', '.regenerate-bill', function () {

        let row = $(this).closest('tr');
        let input = row.find('.current-reading');
        let currentReading = input.val();

        let prev = parseFloat(input.data('prev')) || 0;
        let consumed = (currentReading - prev).toFixed(2);

        $.ajax({
            url: 'action/update_reading.php',
            type: 'POST',
            dataType: 'json',
            data: {
                meter_reading_id: $(this).data('reading-id'),
                meters_id: $(this).data('account'),
                billing_schedule_id: $('#billing_schedule_id').val(),
                reading_date: new Date().toISOString().slice(0,10),
                current_reading: currentReading,
                consumed: consumed
            },
            success(res) {
                if (res.success) {
                    Swal.fire('Updated', 'Bill regenerated.', 'success');

                    input.data('original', currentReading)
                         .prop('disabled', true)
                         .removeClass('form-control border-primary')
                         .addClass('form-control-plaintext');

                    row.find('.regenerate-bill, .cancel-update').addClass('d-none');
                    row.find('.update-bill').removeClass('d-none');
                } else {
                    Swal.fire('Opps', res.message, 'Warning');
                }
            }
        });
    });

});
</script>
