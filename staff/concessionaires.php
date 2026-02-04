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
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-primary"><i class="fas fa-users fa-sm mr-2"></i>List of Concessionaires</h1>
                    </div> -->

                    <!-- <hr> -->

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div class="card-header py-3 d-flex flex-column flex-md-row">
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-start mx-0 px-0 mb-2 mb-md-0">
                                        <h6 class="font-weight-bold text-primary mb-0">List of Concessionaires</h6>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end mx-0 px-0">
                                        <div class="col-12 col-md-4 float-right mx-0 px-0">
                                            <a href="add-concessionaires.php" class="btn btn-success shadow-sm w-100 h-100"><i class="fa-solid fa-plus mr-1"></i>Add Concessionaire</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table nowrap table-bordered table-striped table-hover" id="concessionairesTable" width="100%" style="width:100%">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th scope="col">Profile</th>                                        
                                                    <!-- <th scope="col">Account No</th>                                         -->
                                                    <th scope="col">Name</th>                                               
                                                    <th scope="col">Billing Address</th>                                             
                                                    <th scope="col">Contact Info</th>                                                                     
                                                    <th scope="col">Account Info</th>
                                                    <!-- <th scope="col">Meter No</th> -->
                                                    <th scope="col">Action</th>                             
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
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
        $('#concessionairesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'action/display_concessionaire.php',
                type: 'POST'
            },
            columns: [
                { data: 'profile', orderable: false },
                { data: 'name' },
                { data: 'address' },
                { data: 'contact_info' },
                { data: 'accounts_info' }, // New column for account information
                { data: 'action', orderable: false }
            ],
            scrollX: true,
            scrollCollapse: true,
            scrollY: '70vh'
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function for deleting concessionaire
            $(document).on('click', '.delete-concessionaire-btn', function(e) {
                e.preventDefault();
                
                var concessionaireId = $(this).data('concessionaire-id');
                var concessionaireName = decodeURIComponent($(this).data('concessionaire-name'));
                var concessionaireAddress = decodeURIComponent($(this).data('concessionaire-address'));
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to delete the concessionaire: " + concessionaireName + " located at " + concessionaireAddress,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'action/delete_concessionaire.php',
                            type: 'POST',
                            data: {
                                concessionaire_id: concessionaireId
                            },
                            success: function(response) {
                                if (response.trim() === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        'The concessionaire has been deleted.',
                                        'success'
                                    ).then(() => {
                                        // Reload the DataTables to reflect the deletion
                                        $('#concessionairesTable').DataTable().ajax.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was a problem deleting the concessionaire.',
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                Swal.fire(
                                    'Error!',
                                    'Unable to connect to the server.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>