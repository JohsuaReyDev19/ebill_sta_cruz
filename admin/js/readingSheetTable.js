			$(document).ready(function () {

                

    // Handle Bill button click (Unbilled accounts)
    $('#readingSheetTable').on('click', '.generate-bill', function () {
        $('.current-reading').removeClass('is-invalid');

        let button = $(this);
        let row = button.closest('tr');
        let meterId = button.data('account');
        let currentReadingInput = row.find('.current-reading');
        let currentReading = currentReadingInput.val();
        let billingScheduleId = $('#billing_schedule_id').val();
        let readingDate = new Date().toISOString().slice(0, 10);
        let consumed = row.find('.consumed').text();

        if (!currentReading) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Data',
                text: 'Please enter the current reading before generating the bill.',
            });
            currentReadingInput.addClass('is-invalid');
            return;
        }

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
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (response) {
                Swal.close();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved',
                        text: 'Billing data has been successfully saved.',
                    }).then(() => row.fadeOut(300, function () { $(this).remove(); }));
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed to save billing data.' });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'An unexpected error occurred. Please try again.' });
            }
        });
    });

    // Handle Update button click (Billed accounts)
    $('#readingSheetTable').on('click', '.update-bill', function () {
        let row = $(this).closest('tr');
        let currentInput = row.find('.current-reading');
        let billBtn = row.find('.regenerate-bill'); // Update Bill + Cancel buttons
        let updateBtn = $(this);

        // Show "Update Bill" and "Cancel", hide "Update"
        billBtn.prop('hidden', false);
        updateBtn.prop('hidden', true);

        // Enable input
        currentInput.prop('disabled', false)
                    .removeClass('form-control-plaintext')
                    .addClass('form-control border-primary');
    });

    // Handle Cancel button click
    $('#readingSheetTable').on('click', '.regenerate-bill.cancel', function () {
        let row = $(this).closest('tr');
        let billBtn = row.find('.regenerate-bill');
        let updateBtn = row.find('.update-bill');
        let currentInput = row.find('.current-reading');

        // Hide Update Bill / Cancel, show Update
        billBtn.prop('hidden', true);
        updateBtn.prop('hidden', false);

        // Revert input to readonly
        currentInput.prop('disabled', true)
                    .removeClass('form-control border-primary')
                    .addClass('form-control-plaintext');
    });

    // Handle Update Bill click
    $('#readingSheetTable').on('click', '.regenerate-bill:not(.cancel)', function () {

		
        let button = $(this);
        let row = button.closest('tr');
        let meterId = button.data('account');
        let readingId = button.data('reading-id');
        let currentReadingInput = row.find('.current-reading');
        let currentReading = currentReadingInput.val();
        let billingScheduleId = $('#billing_schedule_id').val();
        let readingDate = new Date().toISOString().slice(0, 10);
        let consumed = row.find('.consumed').text();

        if (!currentReading) {

            Swal.fire({ 
				icon: 'warning', 
				title: 'Missing Data', text: 'Please enter the current reading before regenerating the bill.' });
            currentReadingInput.addClass('is-invalid');
            return;
        }

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
                Swal.fire({ title: 'Updating...', text: 'Please wait while the bill is being regenerated.', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            },
            success: function (response) {
                Swal.close();
                if (response.success) {
                    Swal.fire({ icon: 'success', title: 'Updated', text: 'Bill has been successfully regenerated.' });

                    // Revert buttons and input
                    row.find('.regenerate-bill').prop('hidden', true);
                    row.find('.update-bill').prop('hidden', false);
                    currentReadingInput.prop('disabled', true)
                                       .removeClass('form-control border-primary')
                                       .addClass('form-control-plaintext');
                }else if(response.message == "No changes detected. Data is already up to date."){
                    Swal.fire({ icon: 'warning', title: 'Opps', text: response.message || 'Failed to regenerate bill.' });
				} else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed to regenerate bill.' });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'An unexpected error occurred. Please try again.' });
            }
        });
    });

});

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