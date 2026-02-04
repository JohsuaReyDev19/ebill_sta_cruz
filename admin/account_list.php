<?php
require '../db/dbconn.php';

$classificationFilter = '';
if (isset($_GET['classification_id']) && $_GET['classification_id'] !== '') {
    $classification_id = intval($_GET['classification_id']);
    $classificationFilter = " AND m.classification_id = $classification_id ";
}

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
    ats.account_type,
    m.meter_no,
    ms.meter_size,
    zs.zonebook AS zone,
    cs.classification
FROM meters m
INNER JOIN concessionaires c 
    ON m.concessionaires_id = c.concessionaires_id
INNER JOIN account_type_settings ats 
    ON m.account_type_id = ats.account_type_id
INNER JOIN meter_size_settings ms 
    ON m.meter_size_id = ms.meter_size_id
INNER JOIN zonebook_settings zs 
    ON m.zonebook_id = zs.zonebook_id
LEFT JOIN classification_settings cs
    ON m.classification_id = cs.classification_id
    AND cs.deleted = 0
WHERE 
    m.deleted = 0
    AND c.deleted = 0
    AND ats.deleted = 0
    AND ms.deleted = 0
    AND zs.deleted = 0
    $classificationFilter
";


$result = $con->query($sql);

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
                    

                    <!-- <hr> -->

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
                                        <div class="dropdown mr-2">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="userStatusDropdown"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Classification
                                            </button>

                                            <?php
                                            $classSql = "SELECT * FROM classification_settings WHERE deleted = 0";
                                            $classResult = $con->query($classSql);
                                            ?>
                                            <ul class="dropdown-menu">
                                            <?php while($c = $classResult->fetch_assoc()): ?>
                                                <li>
                                                    <a class="dropdown-item" href="?classification_id=<?= $c['classification_id']; ?>">
                                                        <?= htmlspecialchars($c['classification']); ?>
                                                    </a>
                                                </li>
                                            <?php endwhile; ?>
                                            </ul>
                                        </div>
                                        <div class="dropdown mr-2">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="userStatusDropdown"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Short by
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
                                                    <th scope="col">#</th>                                        
                                                    <th scope="col">Account No</th>
                                                    <th scope="col">Account Name</th>                                        
                                                    <th scope="col">Account Type</th>                                        
                                                    <th scope="col">Meter No</th>                                         
                                                    <th scope="col">Meter Size</th>                                         
                                                    <th scope="col">Zone</th>         
                                                    <th scope="col">Classification</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody id="consTable">
                                            <?php
                                            $count = 1;
                                            if ($result->num_rows > 0):
                                                while ($row = $result->fetch_assoc()):
                                            ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $count++; ?></td>
                                                    <td style="text-align: center;"><?= htmlspecialchars($row['account_no'] ?? ''); ?></td>
                                                    <td><?php 
                                                        $name = $row['account_name'];
                                                        echo $name ?: 'Sta Cruz Water District';
                                                    ?></td>
                                                    <td style="text-align: center;"><?= htmlspecialchars($row['account_type'] ?? ''); ?></td>
                                                    <td style="text-align: center;"><?= htmlspecialchars($row['meter_no'] ?? ''); ?></td>
                                                    <td style="text-align: center;"><?= htmlspecialchars($row['meter_size'] ?? ''); ?></td>
                                                    <td style="text-align: center;"><?= htmlspecialchars($row['zone'] ?? ''); ?></td>
                                                    <td><?= htmlspecialchars($row['classification'] ?? 'Not Set'); ?></td>
                                                </tr>
                                            <?php
                                                endwhile;
                                            else:
                                            ?>
                                                <!-- Empty row with 8 TDs to prevent DataTables warning -->
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
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
                scrollX: true
            });
        });

    </script>

<script>
function printTable() {

    const table = $('#myTable').DataTable();
    const rows = table.rows({ search: 'applied' }).nodes();

    let tbody = '<tbody>';
    rows.each(function(row){
        tbody += '<tr>' + row.innerHTML + '</tr>';
    });
    tbody += '</tbody>';

    let classificationText = 'All Classifications';
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('classification_id')) {
        const selected = document.querySelector(
            '.dropdown-menu a[href*="classification_id"]'
        );
        if (selected) {
            classificationText = selected.textContent.trim();
        }
    }

    const thead = `
    <thead>
        <tr>
            <th scope="col">#</th>                                        
            <th scope="col">Account No</th>
            <th scope="col">Account Name</th>                                        
            <th scope="col">Account Type</th>                                        
            <th scope="col">Meter No</th>                                         
            <th scope="col">Meter</th>                                         
            <th scope="col">Zone</th>         
            <th scope="col">Classification</th>
        </tr>
    </thead>
    `;

    const printWindow = window.open('', '', 'width=1200,height=800');

    printWindow.document.write(`
        <html>
        <head>
            <title>Print Accounts</title>
            <style>
                @page {
                    size: landscape;
                    margin: 20mm;
                }

                body {
                    font-family: Arial, sans-serif;
                }

                .print-header {
                    text-align: center;
                    margin-bottom: 15px;
                }

                .print-header h3 {
                    margin: 0;
                }

                .print-header small {
                    font-size: 12px;
                    color: #555;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 11px;
                }

                th, td {
                    border: 1px solid #000;
                    padding: 6px;
                    text-align: center;
                }

                th {
                    background-color: #f2f2f2;
                }

                thead {
                    display: table-header-group;
                }
            </style>
        </head>
        <body>

            <div class="print-header">
                <h3>List of Accounts</h3>
                <small>
                    Classification: ${classificationText}<br>
                    Printed on: ${new Date().toLocaleString()}
                </small>
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