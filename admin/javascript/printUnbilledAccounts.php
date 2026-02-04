<script>
    // --------------------------
// PRINT UNBILLED ACCOUNTS
// --------------------------
$("#printUnbilledBtn").click(function (e) {
    e.preventDefault();

    let table = $('#readingSheetTable').DataTable();
    let allRows = table.rows({ search: 'applied' }).nodes();

    if (allRows.length === 0) {
        Swal.fire({
            icon: "info",
            title: "No Data",
            text: "There are no unbilled records to print."
        });
        return;
    }

    let accounts = [];

    $(allRows).each(function () {
        let row = $(this);

        // Only include unbilled rows: adjust your logic if needed
        let isUnbilled = row.find(".generate-bill").length > 0; // button exists means unbilled
        if (!isUnbilled) return;

        accounts.push({
            account_no: row.find("td:eq(1)").text().trim(),
            account_name: row.find("td:eq(2)").text().trim(),
            barangay: row.find("td:eq(3)").text().trim(),
            meter_no: row.find("td:eq(4)").text().trim(),
            zonebook: row.find("td:eq(5)").text().trim(),
            previous_reading: row.find("td:eq(6)").text().trim(),
            current_reading: row.find("td:eq(7)").text().trim(),
            consumed: row.find("td:eq(8)").text().trim()
        });
    });

    printUnbilledAccounts(accounts);
});


function printUnbilledAccounts(accounts, printTitle = "Unbilled Accounts Report") {
    let count = 1;

    const SYSTEM_LOGO = "<?php echo isset($_SESSION['system_profile']) ? '../img/' . $_SESSION['system_profile'] : '../img/system_6965ed6ed6091.png'; ?>";
    const dateDisplay = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

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
                <h4>UNBILLED REPORT</h4>
                <p style="margin-top:-20px; font-size: 15px;">As of ${dateDisplay}</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Account No</th>
                    <th>Name</th>
                    <th>Meter No</th>
                    <th>Zone</th>
                    <th>Previous Reading</th>
                </tr>
            </thead>
            <tbody>
    `;

    accounts.forEach(acc => {
        html += `
            <tr>
                <td style="text-align: center;">${count++}</td>
                <td>${acc.account_no}</td>
                <td style="text-align: left; padding-left: 5px;">${acc.account_name}</td>
                <td>${acc.meter_no}</td>
                <td>${acc.zonebook}</td>
                <td>${acc.previous_reading}</td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    // Summary table
    let barangaySet = new Set(accounts.map(acc => acc.barangay));
    let totalConcessionaires = accounts.length;

    html += `
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
    `;

    html += `</body></html>`;

    let win = window.open("", "", "width=1200,height=800");
    win.document.write(html);
    win.document.close();
    win.onload = () => win.print();
}

</script>