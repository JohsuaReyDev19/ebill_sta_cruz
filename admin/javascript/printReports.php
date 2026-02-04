<script>
$(document).ready(function () {

    // ================= PRINT ALL TABLE =================
    $("#printReportsBtn").click(function (e) {
        e.preventDefault();

        let table = $('#readingSheetTable').DataTable();
        let allRows = table.rows({ search: 'applied' }).nodes();

        if (allRows.length === 0) {
            Swal.fire({
                icon: "info",
                title: "No Data",
                text: "There are no records to print."
            });
            return;
        }

        let accounts = [];

        $(allRows).each(function () {
            let row = $(this);

            accounts.push({
                account_no: row.find("td:eq(1)").text().trim(),
                account_name: row.find("td:eq(2)").text().trim(),
                barangay: row.find("td:eq(3)").text().trim(),
                meter_no: row.find("td:eq(4)").text().trim(),
                zonebook: row.find("td:eq(5)").text().trim(),
                previous_reading: row.find("td:eq(6)").text().trim(),
                current_reading: row.find("td:eq(7)").text().trim(),
                consumed: row.find("td:eq(8)").text().trim(),
                reading_date: row.find("td:eq(9)").text().trim()
            });
        });

        printReadingReport(accounts, "Billing Report");
    });


    // ================= OTHER PRINT BUTTONS =================
    $("#printReportsBtn").click(function (e) {
        e.preventDefault();
        let title = $("#printUnbilledBtn").is(":visible")
            ? "Unbilled Accounts"
            : "Billing Report";
        collectAndPrint(title);
    });

    $("#printNoticeBtn").click(function (e) {
        e.preventDefault();
        collectAndPrint("Billing Notice");
    });

    $("#printUnbilledBtn").click(function (e) {
        e.preventDefault();
        collectAndPrint("Unbilled Accounts");
    });


    // ================= COLLECT DATA =================
    function collectAndPrint(printTitle) {
        let table = $('#readingSheetTable').DataTable();
        let rows = table.rows({ search: 'applied' }).nodes();

        if (rows.length === 0) {
            Swal.fire({
                icon: "info",
                title: "No Data",
                text: "There are no records to print."
            });
            return;
        }

        let accounts = [];

        $(rows).each(function () {
            let row = $(this);

            accounts.push({
                account_no: row.find("td:eq(1)").text().trim(),
                account_name: row.find("td:eq(2)").text().trim(),
                barangay: row.find("td:eq(3)").text().trim(),
                meter_no: row.find("td:eq(4)").text().trim(),
                zonebook: row.find("td:eq(5)").text().trim(),
                previous_reading: row.find("td:eq(6)").text().trim(),
                current_reading: row.find("td:eq(7)").text().trim(),
                consumed: row.find("td:eq(8)").text().trim(),
                reading_date: row.find("td:eq(9)").text().trim()
            });
        });

        printReadingReport(accounts, printTitle);
    }


    // ================= PRINT FUNCTION =================
    function printReadingReport(accounts, printTitle = "DAILY BILLING REPORT") {
        let count = 1;

        const formattedDate = new Date().toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric"
        });

        const SYSTEM_LOGO = "<?php echo isset($_SESSION['system_profile']) ? '../img/' . $_SESSION['system_profile'] : '../img/system_6965ed6ed6091.png'; ?>";

        // ===== SUMMARY DATA =====
        let barangaySet = new Set(accounts.map(acc => acc.barangay));
        let totalConcessionaires = accounts.length;

        let html = `
        <html>
        <head>
            <title>${printTitle}</title>
            <style>
            @page { size: A4 ; margin: 0.5in; }
            body { font-family: Arial, sans-serif; }
            .print-header {
                display: flex;
                justify-content: center; 
                align-items: center;          
                text-align: center;
                gap: 30px;
            }
            .print-header img { 
            width: 80px; 
            margin-bottom: 5px; 
            margin-left: -50px;
            }
            table { width: 100%; border-collapse: collapse; font-size: 10px; }
            th, td { border: 1px solid #000; padding: 4px; text-align: center; }
            th { background: #f2f2f2; }
            .summary-table { width: 50%; margin-top: 15px; font-size: 10px; }
            .summary-table th, .summary-table td { border: 1px solid #000; padding: 4px; text-align: left; }
        </style>
        </head>
        <body>
            <div class="print-header">
                <img src="${SYSTEM_LOGO}">

                <div class="header-text">
                    <h4 style="letter-spacing: 1.5;">STA CRUZ WATER DISTRICT</h4>
                    <p style="margin:-20px; margin-bottom: 8px; font-size: 13px;">Poblacion South, Sta Cruz, Zambales</p>
                    <h4>DAILY BILLING REPORT</h4>
                    <p style="margin-top:-20px; font-size: 15px;">As of ${formattedDate}</p>
                </div>
            </div>


            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Account No</th>
                        <th>Account Name</th>
                        <th>Barangay</th>
                        <th>Meter No</th>
                        <th>Zone/Book</th>
                        <th>Previous Reading</th>
                        <th>Current Reading</th>
                        <th>Consumed</th>
                        <th>Reading Date</th>
                    </tr>
                </thead>
                <tbody>
        `;

        accounts.forEach(acc => {
            console.log(acc.current_reading);
            html += `
                <tr>
                    <td>${count++}</td>
                    <td>${acc.account_no}</td>
                    <td style="text-align:left; padding-left:5px;">${acc.account_name}</td>
                    <td>${acc.barangay}</td>
                    <td>${acc.meter_no}</td>
                    <td>${acc.zonebook}</td>
                    <td>${acc.previous_reading}</td>
                    <td>${acc.current_reading}</td>
                    <td>${acc.consumed}</td>
                    <td>${acc.reading_date}</td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>

            <!-- ===== SUMMARY TABLE ===== -->
            <div>
                <table class="summary-table">
                    <tr>
                        <th>Barangay(s)</th>
                        <td>${[...barangaySet].join(", ") || '-'}</td>
                    </tr>
                    <tr>
                        <th>Total of Concessionaires</th>
                        <td>${totalConcessionaires}</td>
                    </tr>
                </table>
            </div>

        </body>
        </html>
        `;

        let win = window.open("", "", "width=1200,height=800");
        win.document.write(html);
        win.document.close();
        win.onload = () => win.print();
    }

});
</script>
