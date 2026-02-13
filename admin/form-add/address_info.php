<!-- Address Information -->
<div class="multisteps-form__panel shadow p-2 rounded bg-white" data-animation="slideHorz">
    <h5 class="multisteps-form__title text-primary"><i class="fa-solid fa-location-dot fa-sm mr-2"></i>Account Role</h5>
    <hr>
    <div class="multisteps-form__content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="w-100">

                    <!-- Home Address Card -->
                    <div class="card mb-3 shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="card-title mb-0">System Control</h6>
                        </div>

                        <div class="card-body">

                            <!-- Concessionaires -->
                            <div class="form-group mb-3">
                                <div class="form-check role-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" value="1" id="concessionaires">
                                    <label class="form-check-label fw-semibold" for="concessionaires">
                                        <i class="fa-solid fa-users text-primary"></i>
                                        Concessionaires
                                    </label>
                                </div>
                            </div>

                            <!-- Billing system -->
                            <div class="form-group mb-3">
                                <div class="form-check role-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" value="1" id="billing_system">
                                    <label class="form-check-label fw-semibold" for="billing_system">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.50" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt-text-icon lucide-receipt-text text-primary"><path d="M13 16H8"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M4 3a1 1 0 0 1 1-1 1.3 1.3 0 0 1 .7.2l.933.6a1.3 1.3 0 0 0 1.4 0l.934-.6a1.3 1.3 0 0 1 1.4 0l.933.6a1.3 1.3 0 0 0 1.4 0l.933-.6a1.3 1.3 0 0 1 1.4 0l.934.6a1.3 1.3 0 0 0 1.4 0l.933-.6A1.3 1.3 0 0 1 19 2a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1 1.3 1.3 0 0 1-.7-.2l-.933-.6a1.3 1.3 0 0 0-1.4 0l-.934.6a1.3 1.3 0 0 1-1.4 0l-.933-.6a1.3 1.3 0 0 0-1.4 0l-.933.6a1.3 1.3 0 0 1-1.4 0l-.934-.6a1.3 1.3 0 0 0-1.4 0l-.933.6a1.3 1.3 0 0 1-.7.2 1 1 0 0 1-1-1z"/></svg>
                                        Billing System
                                    </label>
                                </div>
                            </div>
                            
                                <!-- Collecting System -->
                            <div class="form-group mb-3">
                                <div class="form-check role-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" value="yes" id="collecting_system">
                                    <label class="form-check-label fw-semibold" for="collecting_system">
                                        <i class="fa-solid fa-coins text-primary"></i>
                                        Collecting System
                                    </label>
                                </div>
                            </div>

                            <!-- Accounting System -->
                            <div class="form-group mb-3">
                                <div class="form-check role-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" value="1" id="accounting_system">
                                    <label class="form-check-label fw-semibold" for="accounting_system">
                                        <i class="fa-solid fa-file-invoice-dollar text-primary"></i>
                                        Accounting System
                                    </label>
                                </div>
                            </div>

                            <!-- Manage User -->
                            <div class="form-group mb-3">
                                <div class="form-check role-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" value="1" id="manage_user">
                                    <label class="form-check-label fw-semibold" for="manage_user">
                                        <i class="fa-solid fa-users-gear text-primary"></i>
                                        Manage Users
                                    </label>
                                </div>
                            </div>

                            <!-- System Settings -->
                            <div class="form-group mb-3">
                                <div class="form-check role-check d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" value="1" id="system_settings">
                                    <label class="form-check-label fw-semibold" for="system_settings">
                                        <i class="fa-solid fa-gear text-primary"></i>
                                        System Settings
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <hr>
        <div class="button-row d-flex justify-content-end mt-4">
            <div>
                <a href="users-active.php?title=Manage Active Users" class="btn btn-secondary mb-0"><i class="fas fa-circle-chevron-left mr-2"></i>Cancel</a>
                <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i class="fa-solid fa-chevron-left mr-2"></i>Previous Form</button>
                <button class="btn btn-success ml-2" type="button" title="Send" id="accomplishBtn"><i class="fa-solid fa-floppy-disk mr-2"></i>Accomplish</button>
            </div>
        </div>
    </div>
</div>

<style>
    .role-check {
        padding: 12px 16px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .role-check:hover {
        background-color: #f8f9fa;
    }

    .role-check input[type="checkbox"] {
        transform: scale(1.6);
        margin-right: 14px;
        cursor: pointer;
    }

    .role-check label {
        font-size: 1.15rem;
        cursor: pointer;
    }

    .role-check i {
        font-size: 1.4rem;
        margin-right: 8px;
    }
</style>
