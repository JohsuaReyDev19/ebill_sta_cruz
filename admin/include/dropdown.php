<div class="d-flex align-items-center gap-3 mb-2 mb-md-0">
    <a href="add-account-staff.php?title=Add Account" class="btn btn-success mr-2 d-flex items-center justify-content-center" type="button"
        aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-plus-icon lucide-circle-plus"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
        Add Account 
    </a>                              

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button"
            id="userStatusDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            Account status
        </button>

        <ul class="dropdown-menu" aria-labelledby="userStatusDropdown">
            <li><a class="dropdown-item" href="users-active.php?title=Manage Active Users">Active</a></li>
            <li><a class="dropdown-item" href="users-pending.php?title=Manage Pending Users">Suspend</a></li>
            <li><a class="dropdown-item" href="users-declined.php?title=Manage Declined Users">Declined</a></li>
            <li><a class="dropdown-item" href="users-archived.php?title=Manage Archived Users">Archived</a></li>
        </ul>
    </div>
</div>