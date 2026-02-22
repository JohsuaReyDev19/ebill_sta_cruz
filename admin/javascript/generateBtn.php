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
                    response.data.forEach(function(item) {

                // Convert full row data to safe JSON string
                let fullData = JSON.stringify(item)
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;');

                table.row.add([
                    `<input type="checkbox" class="rowCheckbox" data-full='${fullData}'>`,
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

        console.log(JSON.parse($(this).attr("data-full")));

            let acc = JSON.parse($(this).attr("data-full"));

            selectedAccounts.push({
                account_no: acc.account_no,
                account_name: acc.account_name,
                barangay: acc.barangay_name,
                meter_no: acc.meter_no,
                zonebook: acc.zonebook,
                previous_reading: acc.previous_reading,
                current_reading: acc.current_reading,
                consumed: acc.consumed,
                reading_date: acc.reading_date,
                amount_due: acc.amount_due,
                arrears: acc.arrears,
                discount_amount: acc.discount_amount,
                house_no: acc.house_no,
                other_fees: acc.other_fees || [],   // new
                other_total : acc.other_total
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
            @page {
    size: 102mm 152mm;   /* Exact 1/4 of A4 */
    margin: 5mm;
}

body {
    font-family: 'Courier New', monospace;
    margin: 0;
}

.wrapper {
    width: 100%;
    height: 100%;
}

.notice {
    width: 100%;
    height: 100%;
    box-sizing: border-box;
}

/* HEADER */
.header-flex {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-bottom: 5px;
}

.logo img {
    width: 30px;
    height: 30px;
}

.header-text {
    text-align: center;
}

/* FONT SIZES (your requested sizes) */
.title {
    font-size: 11pt;   /* Title */
    font-weight: bold;
}

.section-title {
    font-size: 9pt;   /* Bold text */
    text-align: center;
    margin-top: 5px;
}

.text {
    font-size: 8pt;    /* Normal text */
    line-height: 1.3;
}

.label {
    display: inline-block;
    width: 90px;
}
.label2 {
    display: inline-block;
    width: 130px;
}

.reminders {
    font-size: 6pt;    /* Reminders */
    margin-top: 5px;
    text-align: justify;
}
        </style></head><body><div class="wrapper">`;

        selectedAccounts.forEach(acc => {

        let d = new Date(readingDate);
        let yy = d.getFullYear().toString().slice(-2);
        let mm = String(d.getMonth() + 1).padStart(2, '0');

        let randomNum = Math.floor(1000 + Math.random() * 9000); // 4 digits

        let billNo = yy + mm + randomNum;

            console.log(acc.discount);
            printContent += `
            <div class="notice">
                <div class="header-flex">
                    <div class="logo"><img src="${SYSTEM_LOGO}"></div>
                    <div class="header-text">
                        <div class="title">STA CRUZ WATER DISTRICT</div>
                        <div class="text">Poblacion, Sta Cruz, Zambales<br>047-234-x445 <a>stacruzwd@projectbeta.net</a></div>
                    </div>
                </div>
                <div><span style="font-size: 16px; margin-top: 8px;"><span style="font-size: 11px;">Bill No.</span> ${billNo}</span></div>
                
                <div class="text" style="margin-top: 8px;">
                    <span class="label">Account No.</span>: ${acc.account_no}<br>
                    <span class="label">Account Name</span>: ${acc.account_name}<br>
                    <span class="label">Address</span>: ${acc.barangay}, Sta. Cruz, Zambales<br>
                    <span class="label">House No.</span>: ${acc.house_no}<br>
                    <span class="label">Rate Class</span>: Residential
                </div>

                <div class="section-title">BILLING SUMMARY</div>
                <div class="text">
                <span class="label">Billing Month</span>: ${monthYear}<br>
                    <span class="label">Billing Period</span>: ${monthYear} -> ${dueDate}<br>
                    <span class="label">Reading Date</span>: ${acc.reading_date}<br>
                    <span class="label">Previous Reading</span>: ${acc.previous_reading}<br>
                    <span class="label">Present Reading</span>: ${acc.current_reading}<br>
                    <span class="label">Cubic Meter Consumed</span>: ${acc.consumed}
                </div>

                
                <div class="text">
                    
                    <span class="label">Less Discount SC/PWD/MOV/SP</span>: ${acc.discount_amount || 'N/A'}<br>
                    <span class="label">Arrears</span>: ${acc.arrears || '---'}<br>
                </div>

                <div class="section-title">OTHER FEES</div>
                    <table class="text" style="width: 100%; border-collapse: collapse; margin-top: 2px;">
                        <thead>
                            <tr>
                                <td style="text-align: left; width: 40%;">Description</td>
                                <td style="text-align: left; width: 20%;">Qty</td>
                                <td style="text-align: right; width: 20%;">Unit Price</td>
                                <td style="text-align: right; width: 25%;">Amount</td>
                            </tr>
                        </thead>
                        <tbody>
                            ${acc.other_fees && acc.other_fees.length > 0
                                ? acc.other_fees.map(fee => `
                                    <tr>
                                        <td style="font-size: 7px;">${fee.description}</td>
                                        <td style="text-align: left; font-size: 7px;">${fee.quantity}</td>
                                        <td style="text-align: right; font-size: 7px;">${fee.price}</td>
                                        <td style="text-align: right; font-size: 7px;">${fee.amount}</td>
                                    </tr>`).join('')
                                : `<tr>
                                        <td colspan="4" style="text-align: center; font-size: 8px;">No other fees</td>
                                </tr>`}
                        </tbody>
                    </table>
                <div class="text" style="padding-top: 5px;">
                    <span class="label2" >Total Amount Due</span> <span style="font-size: 16px;">${acc.amount_due}</span><br>
                    <span class="label2" >Payment Due Date</span> <span style="font-size: 16px;">${dueDate}</span>
                </div>

                <div class="section-title">REMINDERS</div>
                <div class="reminders">
                    <span>1.A PENALTY CHANGE of 10% is added to bill if paid after due date.</span><br>
                    <span>3.Service maybe DISCONNECTED without further notice if payment is not made ON of BEFORE DUE DATE.</span><br>
                    <span>4.Disconnected will be activated upon payment of all amounts due plus RECONNECTION FEE.</span><br>
                    <span>5.Kindly Please pay you bill before DUE DATE to avoid penalty.</span><br>
                    <span>6.Provide your contact number for text purposes.</span>
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
