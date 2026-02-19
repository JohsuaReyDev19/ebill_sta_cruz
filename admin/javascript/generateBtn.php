<script>
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

            $("#printNoticeBilled").prop("disabled", true);
            return;
        }

        $("#printNoticeBilled").prop("disabled", true);

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

                // Destroy previous DataTable if exists
                if ($.fn.dataTable.isDataTable('#readingSheetTable')) {
                    $('#readingSheetTable').DataTable().clear().destroy();
                }

                let table = $("#readingSheetTable").DataTable({
                    scrollX: true
                });

                table.clear();

                if (response.success && response.data.length > 0) {

                    // Store global dates
                    GLOBAL_READING_DATE = response.data[0].reading_date ?? '';
                    GLOBAL_DUE_DATE     = response.data[0].due_date ?? '';
                    GLOBAL_COVERED_FROM = response.covered_from ?? '';
                    GLOBAL_COVERED_TO   = response.covered_to ?? '';

                    // Populate DataTable
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
                            item.amount_due,
                            item.arrears
                        ]);
                    });

                    table.draw();
                    $("#printNoticeBilled").prop("disabled", false);

                } else {
                    table.clear().draw();
                    Swal.fire({
                        icon: "info",
                        title: "No Data",
                        text: response.message || "No records found.",
                    });
                    $("#printNoticeBilled").prop("disabled", true);
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
       PRINT NOTICE
    ===================================================== */
    $("#printNoticeBilled").click(function () {

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
                reading_date: row.find("td:eq(9)").text().trim(),
                amount_due: row.find("td:eq(10)").text().trim(),
                arrears: row.find("td:eq(11)").text().trim()
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

        let readingDate = GLOBAL_READING_DATE;
        let dueDate = GLOBAL_DUE_DATE;

        let monthYear = '';
        if (readingDate) {
            let d = new Date(readingDate);
            monthYear = d.toLocaleDateString("en-US", { year: "numeric", month: "long" });
        }

        const SYSTEM_LOGO = "<?php echo isset($_SESSION['system_profile']) ? '../img/' . $_SESSION['system_profile'] : '../img/system_6965ed6ed6091.png'; ?>";

        let printContent = `<html><head><title>Water Bill Notice</title><style>
            @page { size: A4; margin: 0; }
            body { font-family: 'Courier New', monospace; margin: 0; }
            .wrapper { display: flex; flex-wrap: wrap; }
            .notice { width: 50%; height: 50vh; box-sizing: border-box; border: 1px dashed black; padding: 5mm; page-break-inside: avoid; }
            .header-flex { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 6px; }
            .logo img { width: 40px; height: 40px; }
            .header-text { text-align: center; }
            .title { font-size: 15px; font-weight: bold; }
            .section-title { font-size: 13px; font-weight: bold; text-align: center; margin-top: 10px; }
            .text { font-size: 12px; line-height: 1.4; }
            .label { display: inline-block; width: 130px; }
            .reminders { font-size: 10px; margin-top: 8px; text-align: justify; }
        </style></head><body><div class="wrapper">`;

        selectedAccounts.forEach(acc => {
            printContent += `
            <div class="notice">
                <div class="header-flex">
                    <div class="logo"><img src="${SYSTEM_LOGO}"></div>
                    <div class="header-text">
                        <div class="title">STA CRUZ WATER DISTRICT</div>
                        <div class="text">Poblacion, Sta Cruz, Zambales<br>047-234-445 <a>stacruzwd@projectbeta.net</a></div>
                    </div>
                </div>

                <div class="section-title">SERVICE INFORMATION</div>
                <div class="text">
                    <span class="label">Account No.</span>: <b>${acc.account_no}</b><br>
                    <span class="label">Account Name</span>: ${acc.account_name}<br>
                    <span class="label">Service Address</span>: ${acc.barangay}, Sta. Cruz, Zambales<br>
                    <span class="label">Rate Class</span>: Residential
                </div>

                <div class="section-title">METER INFORMATION</div>
                <div class="text">
                    <span class="label">Meter No.</span>: ${acc.meter_no}<br>
                    <span class="label">Reading Date</span>: ${acc.reading_date}<br>
                    <span class="label">Present Reading</span>: ${acc.current_reading}<br>
                    <span class="label">Previous Reading</span>: ${acc.previous_reading}<br>
                    <span class="label">Consumption</span>: ${acc.consumed}
                </div>

                <div class="section-title">BILLING SUMMARY</div>
                <div class="text">
                    <span class="label">Billing Period</span>: ${monthYear}<br>
                    <span class="label">Rate meter</span>: 170.00<br>
                    <span class="label">Total Consumption</span>: ${acc.consumed}<br>
                    <span class="label">Discount</span>: ---<br>
                    <span class="label">Arrears</span>: ${acc.arrears || 'N/A'}<br>
                    <span class="label">Total Amount Due</span>: ${acc.amount_due}<br>
                    <span class="label">Payment Due Date</span>: ${dueDate}
                </div>

                <div class="section-title">REMINDERS</div>
                <div class="reminders">
                    Please examine your bill carefully. If no complaint is made within 60 days of receipt,
                    the bill is considered true and correct. SWD employees are not allowed to receive cash payments.
                    Pay your bill via safe and convenient digital channels, e.g. Maya, GCash, and online banking.
                    To avoid disconnection, please pay on time.
                    Kindly disregard this notice if payment has been made.
                </div>
            </div>`;
        });

        printContent += `</div></body></html>`;

        let win = window.open("", "", "width=1000,height=800");
        win.document.write(printContent);
        win.document.close();
        win.onload = () => win.print();

    });

});
</script>
