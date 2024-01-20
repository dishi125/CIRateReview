<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Add Customer </title>
	<?php include 'layouts/title-meta.php'; ?>

	<?php include 'layouts/head-css.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

	<?php include 'layouts/menu.php'; ?>

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="main-content">

		<div class="page-content">
			<div class="container-fluid">

				<!-- start page title -->
				<div class="row">
					<div class="col-12">
						<div class="page-title-box d-sm-flex align-items-center justify-content-between">
							<h4 class="mb-sm-0">Add Customer</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
									<li class="breadcrumb-item"><a href="javascript:void(0)">List of Customers</a></li>
									<li class="breadcrumb-item active">Add Customer</li>
								</ol>
							</div>

						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<div class="col-xl-12 col-lg-12">
						<div class="card">
							<div class="card-header border-0">
								<div class="d-flex align-items-center">
									<h5 class="card-title mb-0 flex-grow-1">Add Customer</h5>
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="add_customer">
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Name</label>
												<input type="text" class="form-control" id="name" name="name">
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">E-mail</label>
												<input type="text" class="form-control" id="email" name="email">
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Password</label>
												<input type="password" class="form-control" id="password" name="password">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Property Limit</label>
												<select name="property_limit" id="property_limit" class="form-select">
													<option value="" selected disabled>Select Property Limit</option>
													<?php foreach ($property_limit as $property) { ?>
													<option value="<?= $property ?>"><?= $property ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Trial Period</label>
												<select name="trial_period" id="trial_period" class="form-select">
													<option value="" selected disabled>Select Trial Period</option>
													<?php foreach ($trial_period as $trial) { ?>
														<option value="<?= $trial ?>"><?= $trial ?> Days</option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Extra Days</label>
												<input type="text" name="extra_days" id="extra_days" class="form-control">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Role</label>
												<select name="role" id="role" class="form-control">
													<option value=""></option>
													<?php foreach ($GetAllRoles as $Role) { ?>
														<option value="<?= $Role['role_id'] ?>"><?= $Role['name'] ?></option>
													<?php } ?>
												</select>
												<label id="role-error" class="error" for="role"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label"></label>
												<select name="identity" id="identity" class="form-select">
<!--													<option value="" selected disabled>Select...</option>-->
													<option value="0" selected>Client</option>
													<option value="1">Review Responder</option>
													<option value="2">Employee</option>
												</select>
											</div>
										</div>
									</div>


									<div class="text-end mb-3 mt-3">
										<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
										<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_customer">Save</button>
									</div>
								</form>
							</div>
						</div><!-- end card -->
					</div><!-- end col -->
				</div>
				<!-- end row -->

			</div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->

		<?php include 'layouts/footer.php'; ?>
	</div>
	<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<button type="button" id="error_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="Customer Added Successfully." data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>

<script type="text/javascript">
$(document).ready(function (){
	$('#role').select2({
		placeholder: "Select Role",
		width: '100%'
	});
})

$(document).on('click', '#cancel_btn', function() {
	$(this).attr('disabled','disabled');
	location.href = "<?php echo base_url('settings/customer'); ?>";
})

$(document).on('click', '#save_customer', function (){
	$(this).attr('disabled','disabled');
	var thi = $(this);
	var formData = new FormData($('#add_customer')[0]);
	formData.append("action", "add");

	if (validate()) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('save_customer'); ?>",
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			success: function (res) {
				var res = JSON.parse(res);
				
				$(thi).removeAttr("disabled");
				if (res.status == "1") {
					$("#error_toast").attr('data-toast-text', 'Record already exist!');
					$("#error_toast").trigger('click');
				}
				else if(res.status == 404){
					$('#session_expired_modal').modal('show');
					setTimeout(function () {
						location.reload();
					}, auto_refresh_page_sec);
				}
				else{
					$("#success_toast").trigger('click');
					location.href = "<?php echo base_url('settings/customer'); ?>";
				}
			},
			error: function () {
				$("#error_toast").attr('data-toast-text', 'Something went wrong!');
				$("#error_toast").trigger('click');
				$(thi).removeAttr("disabled");
			}
		});
	}
	else{
		$(thi).removeAttr("disabled");
	}
})

function validate(){
	$('#add_customer').validate({
		rules: {
			name: {
				required: true,
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
			},
			property_limit: {
				required: true,
			},
			trial_period: {
				required: true,
			},
			extra_days: {
				required: true,
				number: true
			},
			role: {
				required: true,
			},
		},
	});

	if($("#add_customer").valid()){
		return true;
	}
	else {
		return false;
	}
}
</script>
