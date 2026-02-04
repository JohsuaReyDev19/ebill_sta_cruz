<!-- Personal Information -->
<div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="slideHorz">
    <h5 class="multisteps-form__title text-primary"><i class="fa-solid fa-user fa-sm mr-2"></i>Personal Information</h5>
    <hr>
    <div class="multisteps-form__content">
        <div class="row">
            <div class="col-sm-12 col-12">
                <!-- Note Card -->
                <!-- <div class="card mb-3 shadow">
                    <div class="card-body">
                        <p class="m-0 font-italic font-weight-bold">
                            Note: <span>Labels marked with <span class="text-primary">*</span> indicate mandatory fields.</span>
                        </p>
                    </div>
                </div> -->
            </div>

            <div class="col-sm-12 col-12">
                <!-- Organization Checkbox Card -->
                <div class="card mb-3 shadow">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_organization" id="isOrganization">
                            <label class="form-check-label text-primary font-weight-bold" for="isOrganization">
                                Check this if the new concessionaire is an Institution!
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Name & Gender Row -->
<div class="row" id="nameGenderRow">
    <div class="col-sm-7 col-12">
        <!-- Name Card -->
        <div class="card mb-3 shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">Name</h6>
            </div>
            <div class="card-body">
                <!-- Last Name -->
                <div class="form-group mb-3">
                    <label class="form-label">Last Name <span class="text-primary">*</span></label>
                    <input type="text" class="form-control" name="last_name" required>
                    <div class="invalid-feedback">Please enter concessionare's last name.</div>
                </div>
                <!-- First Name -->
                <div class="form-group mb-3">
                    <label class="form-label">First Name <span class="text-primary">*</span></label>
                    <input type="text" class="form-control" name="first_name" required>
                    <div class="invalid-feedback">Please enter concessionare's first name.</div>
                </div>
                <!-- Middle Name -->
                <div class="form-group mb-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name">
                </div>
                <!-- Suffix Name -->
                <div class="form-group mb-3">
                    <label class="form-label">Suffix Name</label>
                    <select class="form-control custom-select" name="suffix_name" required>
                        <option value="NA">N/A</option>
                        <option value="JR">JR</option>
                        <option value="SR">SR</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                        <option value="VI">VI</option>
                        <option value="VII">VII</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5 col-12">
        <!-- Gender Card -->
        <div class="card mb-3 shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">Gender</h6>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label class="form-label" for="gender">Gender <span class="text-primary">*</span></label>
                    <select class="form-control custom-select" name="gender" id="gender" required>
                        <option value="" disabled selected>-- Select Gender --</option>
                        <option value="MALE">MALE</option>
                        <option value="FEMALE">FEMALE</option>
                    </select>
                    <div class="invalid-feedback">Please select the concessionare's gender.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Institution Row -->
<div class="row d-none" id="institutionRow">
    <div class="col-sm-12 col-12">
        <!-- Institution Card -->
        <div class="card mb-3 shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">Institution</h6>
            </div>
            <div class="card-body">
                <!-- Note -->
                <p class="m-0 mb-3 font-italic text-warning">
                    Note: Use this only when the concessionaire has no registrant name or does not want to register as an individual.
                </p>
                <!-- Institution Name -->
                <div class="form-group mb-3">
                    <label class="form-label">Institution Name <span class="text-primary">*</span></label>
                    <textarea class="form-control" name="institution_name" rows="3" disabled></textarea>
                    <div class="invalid-feedback">Please enter concessionare's institution name.</div>
                </div>
                <!-- Institution Description -->
                <div class="form-group mb-3">
                    <label class="form-label">Institution Description <span class="text-primary">*</span></label>
                    <textarea class="form-control" name="institution_description" rows="5" disabled></textarea>
                    <div class="invalid-feedback">Please enter concessionare's institution description.</div>
                </div>
            </div>
        </div>
    </div>
</div>

        <hr>
        <div class="button-row d-flex justify-content-end mt-4">
            <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">Next Form<i class="fa-solid fa-chevron-right ml-2"></i></button>
        </div>
    </div>
</div>
