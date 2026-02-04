<div class="text-center gap-4 p-4">
            <img src="../img/<?php echo $_SESSION['system_profile'] ?? 'mmwd.png'; ?>" alt="MMWD Logo" class="w-8 md:w-20 m-auto mb-3">

            <div>
                <h1 class="text-sm md:text-lg font-bold whitespace-nowrap">
                        e-Billing System
                    </h1>
                    <p class="my-0"><?php echo $_SESSION['system_name'] ?? ''; ?>
                </p>
            </div>
        </div>
            <hr class="text-gray-500 ">
        <div class="space-y-2">
            <a href="index.php" class="flex items-center gap-2 text-gray-300 letter-spacing-2 p-2 bg-gray-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Dashboard
            </a>

            <hr class="text-gray-500 ">

            <a href="concessionaires.php" class="flex items-center gap-2 p-2 hover:bg-gray-600 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                Concessionaires
            </a>
            <div>
                <a id="billingMenu" class="flex items-center gap-2 text-gray-300 p-2 hover:bg-gray-600 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-text-icon lucide-notebook-text"><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9.5 8h5"/><path d="M9.5 12H16"/><path d="M9.5 16H14"/></svg>
                    Billing
                    <svg id="billingArrow" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 ml-auto opacity-60
                                group-hover:opacity-100
                                transition-transform duration-200
                                group-hover:translate-x-1"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 17 5-5-5-5"/>
                        <path d="m13 17 5-5-5-5"/>
                    </svg>
                </a>
                <!-- billing dropdown -->
                <div id="billing" class="mt-2 bg-gray-700/60 rounded-lg px-4 py-3 space-y-1 hidden">

                    <i class="block text-[10px] text-gray-400  tracking-widest mb-2">
                        Billing
                    </i>

                    <a href="billing.php"
                        class="block px-3 py-2 text-sm text-gray-300 rounded-md
                                hover:bg-gray-600 hover:text-white
                                transition-all duration-200">
                        Billing
                    </a>

                    <a href="other-billing.php"
                        class="block px-3 py-2 text-sm text-gray-300 rounded-md
                                hover:bg-gray-600 hover:text-white
                                transition-all duration-200">
                        Other Billing
                    </a>

                </div>
            </div>
            <a href="collecting.php" class="flex items-center gap-2 text-gray-300 p-2 hover:bg-gray-600 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-pen-icon lucide-notebook-pen"><path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4"/><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><path d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/></svg>
                Collecting
            </a>
            <hr class="text-gray-500 ">
            <div>
                <i class="text-[10px] text-gray-400">MANAGE USERS</i>
            </div>
            <div>
                <a id="usersMenu" class="flex items-center gap-2 text-gray-300 p-2 hover:bg-gray-600 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-cog-icon lucide-user-cog"><path d="M10 15H6a4 4 0 0 0-4 4v2"/><path d="m14.305 16.53.923-.382"/><path d="m15.228 13.852-.923-.383"/><path d="m16.852 12.228-.383-.923"/><path d="m16.852 17.772-.383.924"/><path d="m19.148 12.228.383-.923"/><path d="m19.53 18.696-.382-.924"/><path d="m20.772 13.852.924-.383"/><path d="m20.772 16.148.924.383"/><circle cx="18" cy="15" r="3"/><circle cx="9" cy="7" r="4"/></svg>
                    Users
                    <svg id="usersArrow" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 ml-auto opacity-60
                                group-hover:opacity-100
                                transition-transform duration-200
                                group-hover:translate-x-1"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 17 5-5-5-5"/>
                        <path d="m13 17 5-5-5-5"/>
                    </svg>
                </a>
            <!-- manage user -->
                <div id="users" class="mt-2 bg-gray-700/60 rounded-lg px-4 py-3 space-y-1 hidden">

                        <span class="block text-[10px] text-gray-400  tracking-widest mb-2">
                            Users
                        </span>

                        <a href="users-active.php"
                            class="block px-3 py-2 text-sm text-gray-300 rounded-md
                                    hover:bg-gray-600 hover:text-white
                                    transition-all duration-200">
                            Active
                        </a>

                        <a href="users-pending.php"
                            class="block px-3 py-2 text-sm text-gray-300 rounded-md
                                    hover:bg-gray-600 hover:text-white
                                    transition-all duration-200">
                            Pending
                        </a>
                        <a href="users-declined.php"
                            class="block px-3 py-2 text-sm text-gray-300 rounded-md
                                    hover:bg-gray-600 hover:text-white
                                    transition-all duration-200">
                            Declined
                        </a>
                        <a href="users-archived.php"
                            class="block px-3 py-2 text-sm text-gray-300 rounded-md
                                    hover:bg-gray-600 hover:text-white
                                    transition-all duration-200">
                            Archived
                        </a>

                    </div>
                </div>
            </div>
        </div>
            <hr class="text-gray-500 ">
        <!-- manage settingds -->
         <div>
            <i class="text-[10px] text-gray-400">MANAGE SETTINGS</i>
        </div>
        <div>
            <a id="settingsMenu" class="flex items-center gap-2 text-gray-300 p-2 hover:bg-gray-600 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/></svg>
                Settings
                <svg id="settingsArrow" xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 ml-auto opacity-60
                            group-hover:opacity-100
                            transition-transform duration-200
                            group-hover:translate-x-1"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="m6 17 5-5-5-5"/>
                    <path d="m13 17 5-5-5-5"/>
                </svg>
            </a>
            <div id="settings" class="mt-2 bg-gray-700/60 rounded-lg px-4 py-3 space-y-1 hidden">
                <span class="block text-[10px] text-gray-400  tracking-widest mb-2">
                    SETTINGS
                </span>

                <a href="zonebook-settings.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Zone/Book
                </a>

                <a href="classification-settings.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Classification
                </a>
                <a href="account-type-settings.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Account Type
                </a>
                <a href="meter-brand-settings.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Metter Brand
                </a>
                <a href="meter-size-settings.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Meter Size
                </a>
                <a href="billing-schedule-settings.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Billing Schedule
                </a>
                <a href="price-matrix-settings.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Price Matrix
                </a>
                <a href="system-settings.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    System Settings
                </a>
            </div>

        </div>
            <hr class="text-gray-500 ">
        <!-- manage reports -->
        <div>
            <i class="text-[10px] text-gray-400">MANAGE REPORTS</i>
            <a id="reportsMenu" class="flex items-center gap-2 text-gray-300 p-2 hover:bg-gray-600 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-warning-icon lucide-message-square-warning"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/><path d="M12 15h.01"/><path d="M12 7v4"/></svg>
                Reports
                <svg id="reportsArrow" xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 ml-auto opacity-60
                            group-hover:opacity-100
                            transition-transform duration-200
                            group-hover:translate-x-1"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="m6 17 5-5-5-5"/>
                    <path d="m13 17 5-5-5-5"/>
                </svg>
            </a>

            <div id="reports" class="mt-2 bg-gray-700/60 rounded-lg px-4 py-3 space-y-1 hidden">
                <span class="block text-[10px] text-gray-400  tracking-widest mb-2">
                    REPORTS
                </span>

                <a href="notice-printing.php"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Notice Printing
                </a>

                <a href="#"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md
                            hover:bg-gray-600 hover:text-white
                            transition-all duration-200">
                    Receipt Printing
                </a>
            </div>
        </div>
            <hr class="text-gray-500 ">
        <div class="flex justify-center py-8">
            <div class="bg-gray-74444444400 rounded-full p-3 inline-flex items-center justify-center hover:bg-gray-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevrons-left-icon">
                    <path d="m11 17-5-5 5-5"/>
                    <path d="m18 17-5-5 5-5"/>
                </svg>
            </div>
        </div>