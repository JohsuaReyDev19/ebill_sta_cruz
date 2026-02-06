                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow text-white" style="background-color: #303991;">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h3 class="h3 mb-0 text-white">
                        <?php
                            if (isset($_GET['title'])) {
                                $title = htmlspecialchars($_GET['title']);
                                if($title == "Dashboard"){
                                    echo '<i class="fas fa-fw fa-tachometer-alt"></i>';
                                    echo $title;
                                }elseif($title == "Concessionaires"){
                                    echo '<i class="fas fa-fw fa-users mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Billing System"){
                                    echo '<i class="fas fa-fw fa-receipt"></i>';
                                    echo $title;
                                }elseif($title == "Other Billing"){
                                    echo '<i class="fas fa-fw fa-receipt"></i>';
                                    echo $title;
                                }elseif($title == "Collecting System"){
                                    echo '<i class="fa-solid fa-fw fa-file-invoice"></i>';
                                    echo $title;
                                }elseif($title == "Add Concessionaire"){
                                    echo '<i class="fa-solid fa-gauge mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Edit Concessionaire"){
                                    echo '<i class="fa-solid fa-gauge mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Accounts"){
                                    echo '<i class="fa-solid fa-gauge mr-2"></i>';
                                    echo $title;
                                }elseif($title == "New Account"){
                                    echo '<i class="fa-solid fa-gauge mr-2"></i>';
                                    echo $title;
                                }
                                elseif($title == "Account Meter Info"){
                                    echo '<i class="fa-solid fa-gauge-simple mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Manage Active Users"){
                                    echo '<i class="fa-solid fa-user fa-sm mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Manage Pending Users"){
                                    echo '<i class="fa-solid fa-user fa-sm mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Manage Declined Users"){
                                    echo '<i class="fa-solid fa-user fa-sm mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Manage Archived Users"){
                                    echo '<i class="fa-solid fa-user fa-sm mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Add Account"){
                                    echo '<i class="fa-solid fa-user fa-sm mr-2"></i>';
                                    echo $title;
                                }
                                elseif($title == "Account List"){
                                    echo '<i class="fa-solid fa-user fa-sm mr-2"></i>';
                                    echo $title;
                                }elseif($title == "Summary of Collection"){
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="mr-3 lucide lucide-toolbox-icon lucide-toolbox"><path d="M16 12v4"/><path d="M16 6a2 2 0 0 1 1.414.586l4 4A2 2 0 0 1 22 12v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 .586-1.414l4-4A2 2 0 0 1 8 6z"/><path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><path d="M2 14h20"/><path d="M8 12v4"/></svg>';
                                    echo $title;
                                }elseif($title == "Other Price Rate"){
                                    echo '<i class="fa-solid fa-gauge mr-2"></i>';
                                    echo $title;
                                }


                            }
                        ?>
                    </h3>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline small">
                                    <?php
                                        if (isset($_SESSION['fullname'])) {
                                            echo $_SESSION['fullname'];
                                        }else{
                                            echo "Guest User";
                                        }
                                    ?>
                                </span>
                                <?php
                                    if (isset($_SESSION['profile']) && $_SESSION['profile']!="") {
                                        $profile_pic = $_SESSION['profile'];
                                    }else{
                                        $profile_pic = "mmwd.png";
                                    }
                                ?>
                                <img class="img-profile rounded-circle"
                                    src="../img/<?php echo $_SESSION['system_profile'] ?? 'mmwd.png'; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="">
                                    <?php
                                        if (isset($_SESSION['fullname'])) {
                                            echo $_SESSION['fullname'];
                                        }else{
                                            echo "Guest User";
                                        }
                                    ?>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" id="resetPassBtn" href="#" data-user-id="<?php echo $_SESSION['user_id']; ?>">
                                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Update Password
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->