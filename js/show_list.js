
        $('#addPriceMatrix').on('click', function(e) {
            e.preventDefault();

            var formData = $('#addNew form');
            const classificationId = $('#classification_id').val();
            const meterSizeId = $('#meter_size_id').val();
            const pricePerCubic = parseFloat($('#price_per_cubic_meter').val());

            const requiredFields = formData.find('[required], select');
            let fieldsAreValid = true;

            // Reset validation styles
            $('.form-control').removeClass('is-invalid');

            requiredFields.each(function () {
                if ($(this).val() === null || $(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    fieldsAreValid = false;
                }
            });

            // Check for invalid or zero/negative price
            if (isNaN(pricePerCubic) || pricePerCubic <= 0) {
                $('#price_per_cubic_meter').addClass('is-invalid');
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Price',
                    text: 'Minimum price must be greater than 0.'
                });
                return;
            }

            if (!fieldsAreValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please fill-up the required fields.'
                });
                return;
            }

            // Check for existing price matrix
            $.ajax({
                url: 'action/check_price_matrix.php',
                type: 'POST',
                data: {
                    classification_id: classificationId,
                    meter_size_id: meterSizeId
                },
                success: function(response) {
                    if (response === 'exists') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Duplicate Entry',
                            text: 'This price matrix already exists.'
                        });
                    } else if (response === 'not_exists') {
                        // Submit form via AJAX
                        $.ajax({
                            url: 'action/add_price_matrix.php',
                            type: 'POST',
                            data: formData.serialize(),
                            success: function(response) {
                                if (response === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Price Matrix added successfully!',
                                        confirmButtonText: 'OK'
                                    }).then(() => location.reload());
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed to add Price Matrix!',
                                        text: 'Please try again later.'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An unexpected error occurred.'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Unexpected response. Please try again.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to check existing price matrix.'
                    });
                }
            });
        });