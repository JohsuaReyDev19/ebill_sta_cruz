<!-- Add -->
<div class="modal fade" id="addNewMaterials" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-success" id="myModalLabel">
                        <i class="fas fa-plus fa-sm"></i> Additional Materials
                    </h4>
                </div>
                <div class="row float-right mr-2">
                    <button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
            </div>
            <form method="POST" id="addOtherMaterialForm">
                <div class="modal-body">
                    <div class="container-fluid">

                        <input type="hidden" id="addOtherMaterialMetersId" name="meters_id" required readonly>

                        <!-- Other Material -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Other Material</label>

                            <select class="form-control custom-select" name="units_included" id="units_included" required>
                                <option value="" selected disabled>Select other material</option>
                                <?php
                                require '../db/dbconn.php';
                                $sqlFetchActType = "SELECT * FROM `other_billing_material_pricing_settings` WHERE deleted = 0";
                                $resultFetchActType = $con->query($sqlFetchActType);

                                if ($resultFetchActType->num_rows > 0) {
                                    while ($rowFetchActType = $resultFetchActType->fetch_assoc()) {
                                        $other_billing_material_id = $rowFetchActType['other_billing_material_id'];
                                        $other_billing_material = $rowFetchActType['other_billing_material'];
                                        echo "<option value='$other_billing_material'>$other_billing_material</option>";
                                    }
                                } else {
                                    echo "<option value='none' selected disabled>No other material available</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select other material.</div>
                        </div>

                        <hr>

                        <div class="form-row align-items-center">
                            <!-- Units Column -->
                            <div class="form-group col-12 col-lg-6 mb-1">
                                <label class="mb-1 text-sm">Units</label>
                                <p class="font-weight-bold text-success mb-0" id="unitsLabel">—</p>
                                <input type="hidden" name="units" id="unitsInput" required readonly>
                            </div>

                            <!-- Price Per Unit Column -->
                            <div class="form-group col-12 col-lg-6 mb-1">
                                <label class="mb-1 text-sm">Price Per Unit</label>
                                <p class="font-weight-bold text-success mb-0" id="priceLabel">—</p>
                                <input type="hidden" name="price_per_unit" id="priceInput" required readonly>
                            </div>
                        </div>

                        <hr>

                        <!-- Quantity -->
                        <div class="form-group mb-3">
                            <label class="control-label modal-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantityInput" required>
                            <div class="invalid-feedback">Please input a valid quantity.</div>
                        </div>

                        <hr>

                        <!-- Subtotal -->
                        <div class="form-group mb-3">
                            <label class="mb-1 text-sm">Subtotal</label>
                            <p class="font-weight-bold text-success mb-0" id="subtotalLabel">₱0.00</p>
                        </div>

                        <hr>

                        <!-- Remarks -->
                        <div class="form-group">
                            <label class="control-label modal-label">Remarks (Optional)</label>
                            <textarea class="form-control form-control-sm" name="remarks" id="OtherMaterialRemarks"></textarea>
                            <div class="invalid-feedback">Please input a valid remarks.</div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer col-12 px-4">
                    <button type="button" class="btn btn-outline-secondary col-12 col-sm-3" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-success col-12 col-sm-3" id="addOtherMaterialBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>