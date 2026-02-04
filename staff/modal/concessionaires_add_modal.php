<!-- Edit -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row float-left ml-2">
                    <h4 class="modal-title float-left text-success" id="myModalLabel">
                        <i class="fas fa-plus fa-sm"></i> Add New Concessionaire
                    </h4>
                </div>
                <div class="row float-right mr-2"><button type="button" class="close float-right" data-dismiss="modal" aria-hidden="true">&times;</button></div>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="row">
                            <!-- Account Name Card -->
                            <div class="col-md-9">
                            	<div class="row">
                            		<div class="card mb-3">
	                                    <div class="card-header">
	                                        <h5 class="card-title my-0">Account Name</h5>
	                                    </div>
	                                    <div class="card-body">
	                                        <div class="row">
	                                            <div class="col-3">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="account_no">Account No.</label>
	                                                    <input class="form-control" id="account_no" name="account_no" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Account No.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-3">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="first_name">First Name</label>
	                                                    <input class="form-control" id="first_name" name="first_name" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid First Name.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-3">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="middle_name">Middle Name</label>
	                                                    <input class="form-control" id="middle_name" name="middle_name" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Middle Name.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-3">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="last_name">Last Name</label>
	                                                    <input class="form-control" id="last_name" name="last_name" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Last Name.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
                            	</div>

                                <div class="row">
                            		<div class="card col-6 mb-3">
	                                    <div class="card-header">
	                                        <h5 class="card-title my-0">Boundary</h5>
	                                    </div>
	                                    <div class="card-body">
	                                        <div class="row">
	                                            <div class="col-7">
	                                                <div class="form-group mb-3">
			                                            <label class="control-label modal-label" for="zonebook">Zone/Book</label>
			                                            <select name="zonebook" class="form-control form-select custom-select" id="zonebook" required>
			                                                <option value="" disabled selected>Select Zone/Book</option>
			                                                <option value="individual">1001</option>
			                                                <option value="establishment">1002</option>
			                                                <option value="establishment">1003</option>
			                                                <option value="establishment">1004</option>
			                                                <option value="establishment">1005</option>
			                                            </select>
			                                            <div class="invalid-feedback">
	                                                        Please choose a valid Zone/Book.
	                                                    </div>
			                                        </div>
	                                            </div>
	                                            <div class="col-5">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="route_sequence">Route Sequence</label>
	                                                    <input class="form-control" id="route_sequence" name="route_sequence" type="number" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Router Sequence.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                                <div class="card col-6 mb-3">
	                                    <div class="card-header">
	                                        <h5 class="card-title my-0">Classification</h5>
	                                    </div>
	                                    <div class="card-body">
	                                        <div class="row">
	                                            <div class="col-12">
	                                                <div class="form-group mb-3">
			                                            <label class="control-label modal-label" for="classification">Classification</label>
			                                            <select name="classification" class="form-control form-select custom-select" id="classification" required>
			                                                <option value="" disabled selected>Select Classification</option>
			                                                <option value="residential">Residential</option>
			                                                <option value="commercial">Commercial</option>
			                                            </select>
			                                            <div class="invalid-feedback">
	                                                        Please choose a valid Classification.
	                                                    </div>
			                                        </div>
	                                            </div>
	                                            <div class="col-12">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="classification_date_applied">Date Applied</label>
	                                                    <input class="form-control" id="classification_date_applied" name="classification_date_applied" type="date" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Date.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
                            	</div>
                            </div>

                            <!-- Account Type Card -->
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title my-0">Account Type</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="control-label modal-label" for="account_type">Account Type</label>
                                            <select name="account_type" class="form-control form-select custom-select" id="account_type" required>
                                                <option value="" disabled selected>Select Type</option>
                                                <option value="individual">Individual</option>
                                                <option value="establishment">Establishment</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose an Account Type.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sex Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title my-0">Sex</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="control-label modal-label" for="sex">Sex</label>
                                            <select name="sex" class="form-control form-select custom-select" id="sex" required>
                                                <option value="" disabled selected>Select Sex</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose a Sex.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Home Address Card -->
                            <div class="col-md-6">
                                <div class="row">
                            		<div class="card col-12 mb-3">
	                                    <div class="card-header">
	                                        <h5 class="card-title my-0">Home Adress</h5>
	                                    </div>
	                                    <div class="card-body">
	                                        <div class="row">
	                                            <div class="col-12">
	                                                <div class="form-group mb-3 row">
	                                                	<div class="col-4">
	                                                		<label class="control-label modal-label" for="house_no">House No</label>
	                                                	</div>
	                                                    <div class="col-8">
	                                                    	<input class="form-control" id="house_no" name="house_no" type="text" required>
		                                                    <div class="invalid-feedback">
		                                                        Please input a valid House No.
		                                                    </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-12">
	                                                <div class="form-group mb-3 row">
	                                                	<div class="col-4">
	                                                		<label class="control-label modal-label" for="street">Street</label>
	                                                	</div>
	                                                    <div class="col-8">
	                                                    	<input class="form-control" id="street" name="street" type="text" required>
		                                                    <div class="invalid-feedback">
		                                                        Please input a valid Street.
		                                                    </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-12">
	                                                <div class="form-group mb-3 row">
	                                                	<div class="col-4">
	                                                		<label class="control-label modal-label" for="barangay">Barangay</label>
	                                                	</div>
	                                                    <div class="col-8">
	                                                    	<input class="form-control" id="barangay" name="barangay" type="text" required>
		                                                    <div class="invalid-feedback">
		                                                        Please input a valid Barangay.
		                                                    </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-12">
	                                                <div class="form-group mb-3 row">
	                                                	<div class="col-4">
	                                                		<label class="control-label modal-label" for="citytown">City/Town</label>
	                                                	</div>
	                                                    <div class="col-8">
	                                                    	<input class="form-control" id="citytown" name="citytown" type="text" required>
		                                                    <div class="invalid-feedback">
		                                                        Please input a valid City/Town.
		                                                    </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-12">
	                                                <div class="form-group mb-3 row">
	                                                	<div class="col-4">
	                                                		<label class="control-label modal-label" for="province">Province</label>
	                                                	</div>
	                                                    <div class="col-8">
	                                                    	<input class="form-control" id="province" name="province" type="text" required>
		                                                    <div class="invalid-feedback">
		                                                        Please input a valid Province.
		                                                    </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
                            	</div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                            		<div class="card col-12 mb-3">
	                                    <div class="card-header">
	                                        <h5 class="card-title my-0">Meter</h5>
	                                    </div>
	                                    <div class="card-body">
	                                        <div class="row">
	                                            <div class="col-4">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="meter_size">Meter Size</label>
	                                                    <input class="form-control" id="meter_size" name="meter_size" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Meter Size.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-4">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="meter_brand">Meter Brand</label>
	                                                    <select name="meter_brand" class="form-control form-select custom-select" id="meter_brand" required>
			                                                <option value="" disabled selected>Select Brand</option>
			                                                <option value="e-jet">E-JET</option>
			                                            </select>
	                                                    <div class="invalid-feedback">
	                                                        Please choose a valid Meter Brand.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-4">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="meter_no">Meter No</label>
	                                                    <input class="form-control" id="meter_no" name="meter_no" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Meter No.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-4">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="initial_reading">Initial Reading</label>
	                                                    <input class="form-control" id="initial_reading" name="initial_reading" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Initial Reading.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-4">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="last_reading">Last Reading</label>
	                                                    <input class="form-control" id="last_reading" name="last_reading" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Last Reading.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-4">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="meter_digit">Meter Digit</label>
	                                                    <input class="form-control" id="meter_digit" name="meter_digit" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Meter Digit.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-5">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="meter_date_applied">Date Applied</label>
	                                                    <input class="form-control" id="meter_date_applied" name="meter_date_applied" type="date" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Date.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-7">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="meter_remarks">Remarks</label>
	                                                    <input class="form-control" id="meter_remarks" name="meter_remarks" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Remarks.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
                            	</div>
                            </div>

                        </div>

                        <div class="row">
                            <!-- Home Address Card -->
                            <div class="col-md-6">
                                <div class="row">
                            		<div class="card col-12 mb-3">
	                                    <div class="card-header">
	                                        <h5 class="card-title my-0">Other Information</h5>
	                                    </div>
	                                    <div class="card-body">
	                                        <div class="row">
	                                            <div class="col-12">
	                                                <div class="form-group mb-3 row">
	                                                	<div class="col-4">
	                                                		<label class="control-label modal-label" for="contact_no">Contact No</label>
	                                                	</div>
	                                                    <div class="col-8">
	                                                    	<input class="form-control" id="contact_no" name="contact_no" type="number" required>
		                                                    <div class="invalid-feedback">
		                                                        Please input a valid Contact No.
		                                                    </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-12">
	                                                <div class="form-group mb-3 row">
	                                                	<div class="col-4">
	                                                		<label class="control-label modal-label" for="email">Email</label>
	                                                	</div>
	                                                    <div class="col-8">
	                                                    	<input class="form-control" id="email" name="email" type="text" required>
		                                                    <div class="invalid-feedback">
		                                                        Please input a valid Email.
		                                                    </div>
	                                                    </div>
	                                                </div>
	                                            </div>

	                                        </div>
	                                    </div>
	                                </div>
                            	</div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                            		<div class="card col-12 mb-3">
	                                    <div class="card-header">
	                                        <h5 class="card-title my-0">Service Connection</h5>
	                                    </div>
	                                    <div class="card-body">
	                                        <div class="row">
	                                        	<div class="col-6">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="service_status">Status</label>
	                                                    <select name="service_status" class="form-control form-select custom-select" id="service_status" required>
			                                                <option value="" disabled selected>Select Status</option>
			                                                <option value="disconnected">Disconnected</option>
			                                                <option value="connected">Connected</option>
			                                            </select>
	                                                    <div class="invalid-feedback">
	                                                        Please choose a valid Status.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-6">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="service_status_detail">Status Detail</label>
	                                                    <select name="service_status_detail" class="form-control form-select custom-select" id="service_status_detail" required>
			                                                <option value="" disabled selected>Select Status Detail</option>
			                                                <option value="disconnected">Temporary Disconnected</option>
			                                                <option value="connected">Permanent Disconnected</option>
			                                            </select>
	                                                    <div class="invalid-feedback">
	                                                        Please choose a valid Status Detail.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-5">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="service_date_applied">Date Applied</label>
	                                                    <input class="form-control" id="service_date_applied" name="service_date_applied" type="date" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Date.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <div class="col-7">
	                                                <div class="form-group mb-3">
	                                                    <label class="control-label modal-label" for="service_remarks">Remarks</label>
	                                                    <input class="form-control" id="service_remarks" name="service_remarks" type="text" required>
	                                                    <div class="invalid-feedback">
	                                                        Please input a valid Remarks.
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
                            	</div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit" class="btn btn-success" id="addConcessionaire">Save Concessionaire</button>
                </div>
            </form>
        </div>
    </div>
</div>
