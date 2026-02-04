<!DOCTYPE html>
<html lang="en">

<?php include './include/head.php'; ?>

<body id="page-top">
    <div class="d-none" id="users-active"></div>

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
                        <h1 class="h3 mb-0 text-primary"><i class="fa-solid fa-user fa-sm mr-2"></i>Manage Active Users</h1>
                    </div> -->

                    <hr>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                
                                <div class="card-header py-3">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                            <h6 class="font-weight-bold text-primary mb-0">
                                                List of Active Users Account
                                            </h6>
                                        <!-- Left side: Title + Dropdown -->
                                        
                                        <?php 
                                            include "include/dropdown.php";
                                        ?>

                                        <!-- Right side (future buttons / actions) -->
                                        <!--
                                        <div class="d-flex">
                                            <a data-bs-toggle="modal" data-bs-target="#addNew"
                                            class="btn btn-success shadow-sm">
                                                <i class="fa-solid fa-plus me-1"></i> Add Users
                                            </a>
                                        </div>
                                        -->

                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered nowrap" id="myTable" width="100%" cellspacing="0">
                                            <thead class="">
                                                <tr>
                                                  
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Username</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Role</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>                            
                                                   
                                                </tr>
                                            </thead>
                                            
                                            <tbody>

                                            <?php
                                                require '../db/dbconn.php';

                                                $display_zonebook = "SELECT * FROM users WHERE deleted = 0 AND status = 1 AND role = 2";
                                                $sqlQuery = mysqli_query($con, $display_zonebook) or die(mysqli_error($con));

                                                $counter = 1;

                                                while($row = mysqli_fetch_array($sqlQuery)) {
                                                    // Fetch all fields into variables
                                                    $user_id = $row['user_id'];
                                                    $first_name = $row['first_name'];
                                                    $middle_name = $row['middle_name'];
                                                    $last_name = $row['last_name'];
                                                    $suffix_name = $row['suffix_name'];
                                                    $email = $row['email'];
                                                    $username = $row['username'];
                                                    $role = $row['role'];
                                                    $status = $row['status'];

                                                    if ($suffix_name == "NA") {
                                                        $suffix_name_displayed = "";
                                                    } else {
                                                        $suffix_name_displayed = $suffix_name;
                                                    }

                                                    $full_name = $last_name . ", " . $first_name . " " . $suffix_name_displayed;

                                                    if ($status == 0) {
                                                        $status_text = "<p class='badge-warning text-center rounded-pill'>PENDING</p>";
                                                    } elseif ($status == 1) {
                                                        $status_text = "<p class='badge-success text-center rounded-pill'>APPROVED</p>";
                                                    } elseif ($status == 2) {
                                                        $status_text = "<p class='badge-danger text-center rounded-pill'>DECLINED</p>";
                                                    }

                                                    if ($role == 1) {
                                                        $role_text = "<span class='text-success'>ADMIN</p>";
                                                    } elseif ($role == 2) {
                                                        $role_text = "<span class='text-primary'>STAFF</p>";
                                                    }
                                                    
                                            ?>

                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo htmlspecialchars($full_name); ?></td>
                                                    <td><?php echo htmlspecialchars($username); ?></td>
                                                    <td><?php echo htmlspecialchars($email); ?></td>
                                                    <td class="text-center"><?php echo $role_text; ?></td>
                                                    <td><?php echo $status_text; ?></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm btn-primary edit-user-btn"
                                                           data-user-id="<?php echo $user_id;?>"
                                                           data-user-name="<?php echo htmlspecialchars($full_name); ?>"
                                                           data-user-username="<?php echo htmlspecialchars($username); ?>"
                                                           data-user-email="<?php echo htmlspecialchars($email); ?>"
                                                           >
                                                           <i class="fa-solid fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-sm btn-danger delete-user-btn"
                                                           data-user-id="<?php echo $user_id; ?>"
                                                           data-user-name="<?php echo htmlspecialchars($full_name); ?>"
                                                           data-user-username="<?php echo htmlspecialchars($username); ?>"
                                                           data-user-email="<?php echo htmlspecialchars($email); ?>"
                                                           >
                                                           <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                    $counter++;
                                                }
                                                ?>
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
        $(document).ready(function(){
            //inialize datatable
            $('#myTable').DataTable({
                scrollX: true
            })
        });
    </script>

    <!-- Delete user -->
    <script>
        $(document).ready(function () {
            $('.delete-user-btn').on('click', function (e) {
                e.preventDefault();

                const button = $(this);
                const userID = button.data('user-id');
                const name = decodeURIComponent(button.data('user-name'));
                const username = decodeURIComponent(button.data('user-username'));
                const email = decodeURIComponent(button.data('user-email'));

                Swal.fire({
                    title: 'Delete User Account?',
                    html: `
                        <strong>Name:</strong> ${name}<br>
                        <strong>Username:</strong> ${username}<br>
                        <strong>Email:</strong> ${email}<br><br>
                        Are you sure you want to delete this account?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545', // Red
                    cancelButtonColor: '#6c757d',  // Grey
                    confirmButtonText: 'Yes, delete!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Updating account status...',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

                        $.ajax({
                            url: 'action/delete_user.php',
                            type: 'POST',
                            data: { user_id: userID },
                            success: function (response) {
                                if (response.trim() === 'success') {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'User account has been deleted successfully.',
                                        icon: 'success'
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error', 'Something went wrong while deleting user.', 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Failed to connect to the server.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>