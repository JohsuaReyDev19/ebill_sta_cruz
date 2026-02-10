<!-- Personal Information -->
<div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="slideHorz">
    <!-- <h5 class="multisteps-form__title text-primary">
        <i class="fa-solid fa-user fa-sm mr-2"></i>Personal Information
    </h5> -->
    <!-- <hr> -->
     
    <div class="multisteps-form__content">
        <div class="row">
            
            <div class="col-sm-12 col-12">
                <!-- Organization Checkbox Card -->
                <div class="card mb-3 shadow">
                    <div class="card-body">
                        <div class="form-check d-flex justify-content-left items-center">
                            <input class="form-check-input" type="checkbox" 
                                   name="is_institution" id="isOrganization"
                                   <?= $is_institution == 1 ? 'checked' : '' ?>>
                            <i class="form-check-label text-sm text-secondary font-weight-bold" for="isOrganization" id="note">
                                Check this if the concessionaire is an Institution!
                            </i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Name & Gender Row (for individuals) -->
        <div class="row <?= $is_institution == 1 ? 'd-none' : '' ?>" id="nameGenderRow">
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
                            <input type="text" class="form-control" name="last_name" 
                                   value="<?= $last_name ?>" <?= $is_institution == 1 ? 'disabled' : '' ?>>
                        </div>
                        <!-- First Name -->
                        <div class="form-group mb-3">
                            <label class="form-label">First Name <span class="text-primary">*</span></label>
                            <input type="text" class="form-control" name="first_name" 
                                   value="<?= $first_name ?>" <?= $is_institution == 1 ? 'disabled' : '' ?>>
                        </div>
                        <!-- Middle Name -->
                        <div class="form-group mb-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name" 
                                   value="<?= $middle_name ?>" <?= $is_institution == 1 ? 'disabled' : '' ?>>
                        </div>
                        <!-- Suffix Name -->
                        <div class="form-group mb-3">
                            <label class="form-label">Suffix Name</label>
                            <select class="form-control custom-select" name="suffix_name" <?= $is_institution == 1 ? 'disabled' : '' ?>>
                                <option value="NA" <?= $suffix_name == 'NA' ? 'selected' : ''; ?>>N/A</option>
                                <option value="JR" <?= $suffix_name == 'JR' ? 'selected' : ''; ?>>JR</option>
                                <option value="SR" <?= $suffix_name == 'SR' ? 'selected' : ''; ?>>SR</option>
                                <option value="III" <?= $suffix_name == 'III' ? 'selected' : ''; ?>>III</option>
                                <option value="IV" <?= $suffix_name == 'IV' ? 'selected' : ''; ?>>IV</option>
                                <option value="V" <?= $suffix_name == 'V' ? 'selected' : ''; ?>>V</option>
                                <option value="VI" <?= $suffix_name == 'VI' ? 'selected' : ''; ?>>VI</option>
                                <option value="VII" <?= $suffix_name == 'VII' ? 'selected' : ''; ?>>VII</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Discount</label>
                            <select class="form-control custom-select" name="discount" <?= $is_institution == 1 ? 'disabled' : '' ?>>
                                <option value="" <?= empty($discount) ? 'selected' : '' ?>>-- Select Discount --</option>
                                <option value="Pwd" <?= $discount == 'Pwd' ? 'selected' : ''; ?>>Pwd</option>
                                <option value="Senior" <?= $discount == 'Senior' ? 'selected' : ''; ?>>Senior</option>
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
                            <select class="form-control custom-select" name="gender" id="gender" <?= $is_institution == 1 ? 'disabled' : '' ?>>
                                <option value="" disabled <?= empty($gender) ? 'selected' : '' ?>>-- Select Gender --</option>
                                <option value="MALE" <?= $gender == 'MALE' ? 'selected' : '' ?>>MALE</option>
                                <option value="FEMALE" <?= $gender == 'FEMALE' ? 'selected' : '' ?>>FEMALE</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Institution Row -->
        <div class="row <?= $is_institution == 1 ? '' : 'd-none' ?>" id="institutionRow">
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
                            <textarea class="form-control" name="institution_name" rows="3" 
                                      <?= $is_institution == 0 ? 'disabled' : '' ?>><?= $institution_name ?></textarea>
                        </div>
                        <!-- Institution Description -->
                        <div class="form-group mb-3">
                            <label class="form-label">Institution Description <span class="text-primary">*</span></label>
                            <textarea class="form-control" name="institution_description" rows="5" 
                                      <?= $is_institution == 0 ? 'disabled' : '' ?>><?= $institution_description ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="button-row d-flex justify-content-end mt-4">
            <div>
                <a href="concessionaires.php?title=Concessionaires" class="btn btn-secondary mb-0"><i class="fas fa-circle-chevron-left mr-2"></i>Cancel</a>
                <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next">
                    Next Form<i class="fa-solid fa-chevron-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>
