
/* =====================================================
   GLOBAL STORAGE (DATES FOR PRINTING)
===================================================== */
let GLOBAL_READING_DATE = '';
let GLOBAL_DUE_DATE = '';
let GLOBAL_COVERED_FROM = '';
let GLOBAL_COVERED_TO = '';

$(document).ready(function () {

    /* =====================================================
       GENERATE TABLE
    ===================================================== */
    $("#generateBtn").click(function (e) {
        e.preventDefault();

        $("#zonebook_id, #billing_schedule_id").removeClass("is-invalid");

        let zonebookId = $("#zonebook_id").val();
        let billingID  = $("#billing_schedule_id").val();

        if (!zonebookId || !billingID) {
            if (!zonebookId) $("#zonebook_id").addClass("is-invalid");
            if (!billingID) $("#billing_schedule_id").addClass("is-invalid");

            Swal.fire({
                icon: "error",
                title: "Oops..",
                text: "Please select both a billing schedule and zone/book.",
            });

            $("#printNoticeBtn").prop("disabled", true);
            return;
        }

        $("#printNoticeBtn").prop("disabled", false);

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

                    /* =============================
                       STORE GLOBAL DATES (ONCE)
                    ============================== */
                    GLOBAL_READING_DATE = response.data[0].reading_date ?? '';
                    GLOBAL_DUE_DATE     = response.data[0].due_date ?? '';

                    // Optional (if you later return these from PHP)
                    GLOBAL_COVERED_FROM = response.covered_from ?? '';
                    GLOBAL_COVERED_TO   = response.covered_to ?? '';

                    response.data.forEach(item => {
                        table.row.add([
                            item.checkbox,
                            item.account_no,
                            item.account_name,
                            item.barangay_name,
                            item.meter_no,
                            item.zonebook,
                            item.previous_reading,
                            item.current_reading,
                            item.consumed,
							item.reading_date,
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
                        text: response.message || "No records found.",
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to generate reading sheet.",
                });
            }
        });
    });

    /* =====================================================
       SELECT ALL CHECKBOX
    ===================================================== */
    $("#selectAll").on("click", function () {
        $(".rowCheckbox").prop("checked", this.checked);
    });

    $(document).on("click", ".rowCheckbox", function () {
        $("#selectAll").prop(
            "checked",
            $(".rowCheckbox:checked").length === $(".rowCheckbox").length
        );
    });

    /* =====================================================
       PRINT NOTICE (FULLY FIXED)
    ===================================================== */
    $("#printNoticeBtn").click(function () {

        let selectedAccounts = [];

        $(".rowCheckbox:checked").each(function () {
            let row = $(this).closest("tr");

            selectedAccounts.push({
                account_no: row.find("td:eq(1)").text().trim(),
                account_name: row.find("td:eq(2)").text().trim(),
                barangay: row.find("td:eq(3)").text().trim(),
                meter_no: row.find("td:eq(4)").text().trim(),
                zonebook: row.find("td:eq(5)").text().trim(),
                previous_reading: row.find("td:eq(6)").text().trim(),
                current_reading: row.find("td:eq(7)").text().trim(),
                consumed: row.find("td:eq(8)").text().trim(),
                amount_due: row.find("td:eq(9)").text().trim()
            });
        });

        if (selectedAccounts.length === 0) {
            Swal.fire({
                icon: "warning",
                title: "No Accounts Selected",
                text: "Please select at least one account.",
            });
            return;
        }

        /* =============================
           USE GLOBAL VALUES
        ============================== */
        let readingDate = GLOBAL_READING_DATE;
        let dueDate     = GLOBAL_DUE_DATE;
        let coveredFrom = GLOBAL_COVERED_FROM;
        let coveredTo   = GLOBAL_COVERED_TO;

        let monthYear = '';
        if (readingDate) {
            let d = new Date(readingDate);
            monthYear = d.toLocaleDateString("en-US", {
                year: "numeric",
                month: "long"
            });
        }

        const SYSTEM_LOGO = "<?php echo isset($_SESSION['system_profile']) ? '../img/' . $_SESSION['system_profile'] : '../img/system_6965ed6ed6091.png'; ?>";

        let printContent = `
        <html>
        <head>
        <title>Print Water Bill Notices</title>
        <style>
            @page { size: A4; margin: 0.3in; }
            body { font-family: Arial, sans-serif; margin: 0; }
            .wrapper { display: flex; flex-wrap: wrap; }
            .notice {
                width: 50%;
                box-sizing: border-box;
                padding: 10px;
                border: 1px dashed #999;
                page-break-inside: avoid;
            }
            hr { border-top: 1px dashed #000; }
            .logo { text-align: center; }
            .logo img { width: 45px; height: 45px; }
            .header { text-align: center; font-size: 11px; }
            .details { font-size: 10px; line-height: 1.3; }
            .note { font-size: 8px; margin-top: 5px; }
        </style>
        </head>
        <body>
        <div class="wrapper">`;

        selectedAccounts.forEach(acc => {
            printContent += `
            <div class="notice">
                <div class="logo"><img src="${SYSTEM_LOGO}"></div>
                <div class="header">
                    <strong>Sta Cruz Water District</strong><br>
                    Water Bill Notice<br>
                    Billing Period: ${monthYear}
                </div>
                <hr>
                <div class="details">
                    <p><strong>Account No:</strong> ${acc.account_no}</p>
                    <p><strong>Name:</strong> ${acc.account_name}</p>
                    <p><strong>Billing Address:</strong> ${acc.barangay}, Sta Cruz, Zambales</p>
                    <p><strong>Meter No:</strong> ${acc.meter_no}</p>
                    <p><strong>Zone/Book:</strong> ${acc.zonebook}</p>
                    <hr>
                    <p><strong>Reading Date:</strong> ${readingDate}</p>
                    <p><strong>Covered:</strong> ${coveredFrom} ${coveredTo ? '– ' + coveredTo : ''}</p>
                    <p><strong>Due Date:</strong> ${dueDate}</p>
                    <hr>
                    <p><strong>Previous:</strong> ${acc.previous_reading}</p>
                    <p><strong>Current:</strong> ${acc.current_reading}</p>
                    <p><strong>Consumed:</strong> ${acc.consumed}</p>
                    <p><strong>Amount Due:</strong> ${acc.amount_due}</p>
                </div>
                <p class="note">
                    This is not an official receipt. Please pay on or before the due date.
                </p>
            </div>`;
        });

        printContent += `</div></body></html>`;

        let win = window.open("", "", "width=1000,height=800");
        win.document.write(printContent);
        win.document.close();
        win.onload = () => win.print();
    });

});