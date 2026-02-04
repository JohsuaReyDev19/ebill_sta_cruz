        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion text-white" id="accordionSidebar" style="background-color: #001f54;">

            <li class="text-center">   <!-- Sidebar - Brand -->
                <a class="sidebar-brand items-center justify-center" href="index.php">
                    <div class="sidebar-brand-icon">
                        <center>
                            <img src="../img/<?php echo $_SESSION['system_profile'] ?? 'mmwd.png'; ?>" alt="" style="width: 95px; height: auto;">
                        </center>
                    </div>
                    <div class="mt-3">
                        <div class="sidebar-brand-text">
                            e-Billing System
                            <p class="my-0"><?php echo $_SESSION['system_name'] ?? ''; ?></p>
                        </div>
                    </div>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link fs-4" href="index.php?title=Dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block my-0">

            <li class="nav-item">
                <a class="nav-link fs-4" href="concessionaires.php?title=Concessionaires">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Concessionaires</span>
                </a>
            </li>

            <!-- Nav Item - Inventory Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed fs-4" href="#" data-toggle="collapse" data-target="#billingCollapse"
                    aria-expanded="true" aria-controls="billingCollapse">
                    <i class="fas fa-fw fa-receipt"></i>
                    <span>Billing</span>
                </a>
                <div id="billingCollapse" class="collapse" aria-labelledby=""
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Billing</h6>
                        <a class="collapse-item" href="billing.php?title=Billing">Water Billing</a>
                        <a class="collapse-item" href="other-billing.php?title=Other Billing">Other Billing</a>
                    </div>
                </div>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link fs-4" href="collecting.php?title=Collecting">
                    <i class="fa-solid fa-fw fa-file-invoice"></i>
                    <span>Collecting</span>
                </a>
            </li> -->

            <!-- Divider -->
            <!-- <hr class="sidebar-divider d-none d-md-block"> -->

            <!-- Nav Item - Inventory Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed fs-4" href="users-active.php?title=Manage Active Users">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Manage Users</span>
                </a>
            </li> -->

            <!-- Divider -->
            <!-- <hr class="sidebar-divider d-none d-md-block"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Manage Setings
            </div> -->

            <!-- Nav Item - Inventory Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed fs-4" href="#" data-toggle="collapse" data-target="#inventoryCollapse"
                    aria-expanded="true" aria-controls="inventoryCollapse">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
                <div id="inventoryCollapse" class="collapse" aria-labelledby=""
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Settings</h6>
                        <a class="collapse-item" href="zonebook-settings.php">Zone/Book</a>
                        <a class="collapse-item" href="classification-settings.php">Classification</a>
                        <a class="collapse-item" href="account-type-settings.php">Account Type</a>
                        <a class="collapse-item" href="service-status-settings.php">Service Status</a>
                        <a class="collapse-item" href="meter-brand-settings.php">Meter Brand</a>
                        <a class="collapse-item" href="meter-size-settings.php">Meter Size</a>
                        <a class="collapse-item" href="billing-schedule-settings.php">Billing Schedule</a>
                        <a class="collapse-item" href="price-matrix-settings.php">Price Matrix</a>
                        <a class="collapse-item" href="system-settings.php">System Settings</a>
                    </div>
                </div>
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Manage Reports
            </div> -->

            <!-- Nav Item - Inventory Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reportCollapse"
                    aria-expanded="true" aria-controls="reportCollapse">
                    <i class="fas fa-fw fa-chart-pie"></i>
                    <span>Reports</span>
                </a>
                <div id="reportCollapse" class="collapse" aria-labelledby=""
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Reports</h6>
                        <a class="collapse-item" href="notice-printing.php">Notice Printing</a>
                        <a class="collapse-item" href="">Receipt Printing</a>
                    </div>
                </div>
            </li> -->

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->