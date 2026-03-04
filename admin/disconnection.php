<?php
require '../db/dbconn.php';

/* ===============================
   CLASSIFICATION FILTER
=================================*/
$classificationFilter = '';
if (isset($_GET['classification_id']) && $_GET['classification_id'] !== '') {
    $classification_id = intval($_GET['classification_id']);
    $classificationFilter = " AND m.classification_id = $classification_id ";
}

/* ===============================
   MONTHS FILTER
=================================*/
$monthsFilter = '';
if (isset($_GET['months']) && $_GET['months'] !== '') {
    $months = intval($_GET['months']);
    if ($months == 1) {
        $monthsFilter = " HAVING total_months = 1 ";
    } elseif ($months == 2) {
        $monthsFilter = " HAVING total_months = 2 ";
    } elseif ($months >= 3) {
        $monthsFilter = " HAVING total_months >= 3 ";
    }
}

/* ===============================
   OVERDUE ACCOUNTS QUERY
=================================*/
$sql = "
SELECT 
    m.meters_id,
    m.account_no,

    CONCAT(
        c.last_name, ', ',
        c.first_name, ' ',
        IFNULL(c.middle_name, ''),
        IF(TRIM(c.suffix_name) = '' OR TRIM(c.suffix_name) = 'NA', '', CONCAT(' ', c.suffix_name))
    ) AS account_name,

    GROUP_CONCAT(
        CONCAT(
            DATE_FORMAT(ad.due_date, '%b %Y'),
            ' (₱',
            FORMAT(ad.amount,2),
            ')'
        )
        SEPARATOR ', '
    ) AS months_list,

    COUNT(ad.due_id) AS total_months,
    SUM(ad.penalty_amount) AS total_penalty,
    SUM(ad.total_due) AS grand_total

    FROM account_dues ad
    INNER JOIN meters m 
        ON ad.meters_id = m.meters_id
    INNER JOIN concessionaires c 
        ON m.concessionaires_id = c.concessionaires_id

    WHERE 
        ad.status = 0
        AND m.deleted = 0
        AND c.deleted = 0
        $classificationFilter

    GROUP BY m.meters_id
    $monthsFilter
";

$result = $con->query($sql);

/* ===============================
   CLASSIFICATION DROPDOWN
=================================*/
$classSql = "SELECT * FROM classification_settings WHERE deleted = 0";
$classResult = $con->query($classSql);
?>

<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="concessionaires"></div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include './include/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include './include/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">List of Accounts</h6>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                        <!-- No. of Months Filter -->
                                        <div class="dropdown mr-2">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                No. of Months
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="?months=1">1 Month</a></li>
                                                <li><a class="dropdown-item" href="?months=2">2 Months</a></li>
                                                <li><a class="dropdown-item" href="?months=3">3+ Months</a></li>
                                            </ul>
                                        </div>

                                        <!-- Zone Dropdown -->
                                        <div class="dropdown mr-2">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="userStatusDropdown"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Zone
                                            </button>

                                            <ul class="dropdown-menu" aria-labelledby="userStatusDropdown">
                                                <li><a class="dropdown-item" href="showAll.php">Show All</a></li>
                                                <li><a class="dropdown-item" href="#">Zone</a></li>
                                                <li><a class="dropdown-item" href="#">Barangay</a></li>
                                            </ul>
                                        </div>

                                        <div class="col-12 col-md-4 float-right mx-0 px-0">
                                            <button type="button"
                                                onclick="printTable()"
                                                class="btn btn-success shadow-sm w-100 h-100 gap-2">
                                                Print
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                                    <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/>
                                                    <rect x="6" y="14" width="12" height="8" rx="1"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered nowrap" id="myTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Account No</th>
                                                    <th>Account Name</th>
                                                    <th style="text-align: center;">Months</th>
                                                    <th style="text-align: center;">Penalty</th>
                                                    <th style="text-align: center;">Total Amount Due</th>
                                                </tr>
                                            </thead>
                                            <tbody id="consTable">
                                                <?php
                                                $count = 1;
                                                if ($result && $result->num_rows > 0):
                                                    while ($row = $result->fetch_assoc()):
                                                ?>
                                                    <tr class="<?= ($row['total_months'] >= 3) ? 'table-danger' : ''; ?>">
                                                        <td class="text-center"><?= $count++; ?></td>
                                                        <td class="text-center"><?= htmlspecialchars($row['account_no']); ?></td>
                                                        <td><?= $row['account_name'] ?: 'Sta Cruz Water District'; ?></td>
                                                        <td class="text-center"><?= $row['months_list']; ?></td>
                                                        <td class="text-center text-danger">₱<?= number_format($row['total_penalty'], 2); ?></td>
                                                        <td class="text-center font-weight-bold">₱<?= number_format($row['grand_total'], 2); ?></td>
                                                    </tr>
                                                <?php
                                                    endwhile;
                                                else:
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-center text-muted">No overdue accounts found.</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include('modal/account_add_modal.php'); ?>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include './include/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include './include/logout_modal.php'; ?>

    <?php include './include/script.php'; ?>
    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                destroy: true,   
                scrollX: true,
                language: {
                    emptyTable: "No overdue accounts found."
                }
            });
        });

        function printTable() {
            const table = $('#myTable').DataTable();
            const rows = table.rows({ search: 'applied' }).nodes();
            let tbody = '<tbody>';
            rows.each(function(row){ tbody += '<tr>' + row.innerHTML + '</tr>'; });
            tbody += '</tbody>';

            const thead = `
            <thead>
                <tr>
                    <th>#</th>
                    <th>Account No</th>
                    <th>Account Name</th>
                    <th>Months</th>
                    <th>Penalty</th>
                    <th>Total Amount Due</th>
                </tr>
            </thead>
            `;

            const printWindow = window.open('', '', 'width=1200,height=800');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Print Overdue Accounts</title>
                    <style>
                        @page { size: landscape; margin: 20mm; }
                        body { font-family: Arial, sans-serif; }
                        .print-header { text-align: center; margin-bottom: 15px; }
                        table { width: 100%; border-collapse: collapse; font-size: 11px; }
                        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    <div class="print-header">
                        <h3>Overdue Accounts List</h3>
                        <small>Printed on: ${new Date().toLocaleString()}</small>
                    </div>
                    <table>
                        ${thead}
                        ${tbody}
                    </table>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>

</body>
</html>