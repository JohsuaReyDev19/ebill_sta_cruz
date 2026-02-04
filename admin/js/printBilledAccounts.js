$("#printAllTableBtn").click(function () {

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
            reading_date: row.find("td:eq(9)").text().trim(),
            amount_due: row.find("td:eq(10)").text().trim()
        });
    });

    printBilledAccounts(accounts);
});

function printBilledAccounts(accounts, printTitle = "Notice Billing Report") {
    let count = 1;

    // Get "From" date
    let rawDateFrom = $("#myDateFrom").val();
    let formattedDateFrom = "";
    if (rawDateFrom) {
        formattedDateFrom = new Date(rawDateFrom).toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric"
        });
    }

    // Get "To" date
    let rawDateTo = $("#myDateTo").val();
    let formattedDateTo = "";
    if (rawDateTo) {
        formattedDateTo = new Date(rawDateTo).toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric"
        });
    }

    // Default current date
    const dateNotformatted = new Date();
    const formattedDate = dateNotformatted.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    // Set print title and date display
    let dateDisplay = "";
    if (rawDateFrom && rawDateTo) {
        printTitle = "DAILY BILLING REPORT";
        dateDisplay = `As of ${formattedDateFrom} to ${formattedDateTo}`;
    } else {
        printTitle = "BILLING REPORT";
        dateDisplay = formattedDate;
    }

    const SYSTEM_LOGO = "<?php echo isset($_SESSION['system_profile']) ? '../img/' . $_SESSION['system_profile'] : '../img/system_6965ed6ed6091.png'; ?>";

    // Start building HTML
    let html = `
    <html>
    <head>
        <title>${printTitle}</title>
        <style>
            @page { size: A4 ; margin: 0.5in; }
            body { font-family: Arial, sans-serif; }
            .print-header { text-align: center; margin-bottom: 15px; }
            .print-header img { width: 60px; margin-bottom: 5px; }
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
                    <p style="margin-top:-20px; font-size: 15px;">${dateDisplay}</p>
                </div>
            </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Account No</th>
                    <th>Bill No</th>
                    <th>Name</th>
                    <th>Barangay</th>
                    <th>Previous</th>
                    <th>Current</th>
                    <th>Consumed</th>
                    <th>Amount Due</th>
                </tr>
            </thead>
            <tbody>
    `;

    // Add each account row
    accounts.forEach(acc => {
        html += `
            <tr>
                <td style="text-align: center;">${count++}</td>
                <td>${acc.account_no}</td>
                <td>-</td>
                <td style="text-align: left; padding-left: 5px;">${acc.account_name}</td>
                <td>${acc.barangay}</td>
                <td>${acc.previous_reading}</td>
                <td>${acc.current_reading}</td>
                <td>${acc.consumed}</td>
                <td>${acc.amount_due}</td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    // ===== Dynamic summary table =====
    let zoneSet = new Set(accounts.map(acc => acc.zonebook));
    let totalConcessionaires = accounts.length;

    html += `
        <div>
            <table class="summary-table">
                <tr>
                    <th>Barangay(s)</th>
                    <td>${[...zoneSet].join(", ") || '-'}</td>
                </tr>
                <tr>
                    <th>Total of Concessionaires</th>
                    <td>${totalConcessionaires}</td>
                </tr>
            </table>
        </div>
    `;

    html += `
    </body>
    </html>
    `;

    // Open print window
    let win = window.open("", "", "width=1200,height=800");
    win.document.write(html);
    win.document.close();
    win.onload = () => win.print();
}