        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion text-white" id="accordionSidebar" style="background-color: #001f54;">

            <li class="text-center">   <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex items-center justify-content-center mb-2" href="index.php">
                        <center>
                            <img src="../img/<?php echo $_SESSION['system_profile'] ?? 'mmwd.png'; ?>" alt="" style="width: 40px; height: auto; border-radius: 50%;" class="rounded-full">
                        </center>
                    <div>
                        <div class="sidebar-brand-text">
                            e-Billing System
                        </div>
                    </div>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link fs-4" href="index.php?title=Dashboard">
                    <i class="fas fa-fw fa-tachometer-alt "></i>
                    <span id="sidebar-label" class="sidebar-brand-text">Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block my-0">

            <!-- <li class="nav-item">
                <a class="nav-link fs-4" href="concessionaires.php?title=Concessionaires">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Concessionaires</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link collapsed fs-4" href="#" data-toggle="collapse" data-target="#Concessionaires"
                    aria-expanded="true" aria-controls="Concessionaires">
                    <i class="fas fa-fw fa-receipt"></i>
                    <span>Concessionaires</span>
                </a>
                <div id="Concessionaires" class="collapse" aria-labelledby=""
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Concessionaires System</h6>
                        <a class="collapse-item" href="concessionaires.php?title=Concessionaires">Concessionaires</a>
                        <a class="collapse-item" href="account_list?title=Account List">Account List</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Inventory Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed fs-4" href="#" data-toggle="collapse" data-target="#billingCollapse"
                    aria-expanded="true" aria-controls="billingCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-arrow-down-icon lucide-banknote-arrow-down"><path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5"/><path d="m16 19 3 3 3-3"/><path d="M18 12h.01"/><path d="M19 16v6"/><path d="M6 12h.01"/><circle cx="12" cy="12" r="2"/></svg>
                    <span>Billing System</span>
                </a>
                <div id="billingCollapse" class="collapse" aria-labelledby=""
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Billing</h6>
                        <a class="collapse-item" href="billing.php?title=Billing System">Water Billing</a>
                        <a class="collapse-item" href="other-billing.php?title=Other Billing">Other Billing</a>
                    </div>
                </div>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link fs-4" href="collecting.php?title=Collecting System">
                    <i class="fa-solid fa-fw fa-file-invoice"></i>
                    <span>Collecting System</span>
                </a>
            </li> -->

            

            <li class="nav-item">
                <a class="nav-link collapsed fs-4" href="collecting.php?title=Collecting System">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-toolbox-icon lucide-toolbox"><path d="M16 12v4"/><path d="M16 6a2 2 0 0 1 1.414.586l4 4A2 2 0 0 1 22 12v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 .586-1.414l4-4A2 2 0 0 1 8 6z"/><path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><path d="M2 14h20"/><path d="M8 12v4"/></svg>
                    <span>Collecting</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-4" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand-coins-icon lucide-hand-coins"><path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"/><path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 16 6 6"/><circle cx="16" cy="9" r="2.9"/><circle cx="6" cy="5" r="3"/></svg>
                    <span>Accounting System</span>
                </a>
            </li>

            <!-- Nav Item - Inventory Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed fs-4" href="users-active.php?title=Manage Active Users">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Manage Users</span>
                </a>
            </li>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider d-none d-md-block"> -->

            <!-- Nav Item - Inventory Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed fs-4" href="#" data-toggle="collapse" data-target="#inventoryCollapse"
                    aria-expanded="true" aria-controls="inventoryCollapse">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>System Settings</span>
                </a>
                <div id="inventoryCollapse" class="collapse" aria-labelledby=""
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Settings</h6>
                        <a class="collapse-item" href="zonebook-settings.php?title=Zone/Book">Zone/Book</a>
                        <a class="collapse-item" href="classification-settings.php?title=Classification">Classification</a>
                        <a class="collapse-item" href="account-type-settings.php?title=Account Type Settings">Account Type</a>
                        <a class="collapse-item" href="#">Manage Barangay's</a>
                        <!-- <a class="collapse-item" href="service-status-settings.php">Service Status</a> -->
                        <a class="collapse-item" href="meter-brand-settings.php">Meter Brand</a>
                        <a class="collapse-item" href="meter-size-settings.php?title=Meter Size">Meter Size</a>
                        <a class="collapse-item" href="billing-schedule-settings.php">Billing Schedule</a>
                        <a class="collapse-item" href="price-matrix-settings.php">Price Matrix</a>
                        <a class="collapse-item" href="manage-price-metrix.php?title=Manage Price Matrix">Manage Price Matrix</a>
                        <a class="collapse-item" href="other-price-matrix.php?title=Other Price Rate">Other Price Matrix</a>
                        <a class="collapse-item" href="system-settings.php?title=System Settings">System Settings</a>
                    </div>
                </div>
            </li>

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
