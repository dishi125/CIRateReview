<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Add Role </title>
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
							<h4 class="mb-sm-0">Add Role</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
									<li class="breadcrumb-item"><a href="javascript:void(0)">Role</a></li>
									<li class="breadcrumb-item active">Add Role</li>
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
									<h5 class="card-title mb-0 flex-grow-1">Add Role</h5>
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="add_role">
								<div class="row">
								<div class="col-xxl-3 col-md-6">
									<div>
										<label for="labelInput" class="form-label">Role Name</label>
										<input type="text" class="form-control" id="role_name" name="role_name">
										<div class="invalid-feedback" id="role_name_error" style="display: block"></div>
									</div>
								</div>
								<div class="col-xxl-3 col-md-6">
									<div>
										<label for="labelInput" class="form-label">Description</label>
										<input type="text" class="form-control" id="description" name="description">
									</div>
								</div>
								</div>
								</form>

								<div class="invalid-feedback" id="privilege_error" style="display: block"></div>
								<div class="pagination-list border p-4 mt-5">
									<div class="mx-n3 row border-bottom-double mb-3">
										<div class="col-4">
											<h5 class="fs-14 mb-1">Privilege Name</h5>
										</div>
										<div class="col-2">
											<h5 class="fs-14 mb-1">Is Add</h5>
										</div>
										<div class="col-2">
											<h5 class="fs-14 mb-1">Is Edit</h5>
										</div>
										<div class="col-2">
											<h5 class="fs-14 mb-1">Is Delete</h5>
										</div>
										<div class="col-2">
											<h5 class="fs-14 mb-1">Is View</h5>
										</div>
									</div>
									<?php foreach ($GetAllPrivileges as $privilege) { ?>
									<form class="permissionForm" method="post">
									<div class="mx-n3 row border-bottom-inset p-2">
										<input type="hidden" value="<?= $privilege['Id'] ?>" name="privilege_id">
										<input type="hidden" value="<?= $privilege['display_name'] ?>" name="display_name">
										<div class="col-4">
											<h5 class="fs-14 mb-1"><?= $privilege['display_name'] ?></h5>
										</div>
										<div class="col-2">
											<div class="flex-grow-1 form-check form-check-outline form-check-secondary"><input class="form-check-input" type="checkbox" name="is_add" value="true"></div>
										</div>
										<div class="col-2">
											<div class="flex-grow-1 form-check form-check-outline form-check-secondary"><input class="form-check-input" type="checkbox" name="is_edit" value="true"></div>
										</div>
										<div class="col-2">
											<div class="flex-grow-1 form-check form-check-outline form-check-secondary"><input class="form-check-input" type="checkbox" name="is_delete" value="true"></div>
										</div>
										<div class="col-2">
											<div class="flex-grow-1 form-check form-check-outline form-check-secondary"><input class="form-check-input" type="checkbox" name="is_view" value="true"></div>
										</div>
									</div>
									</form>
									<?php } ?>
								</div>

								<div class="text-end mb-3 mt-3">
								<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
								<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_role">Save</button>
								</div>
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

<button type="button" id="error_toast" data-toast data-toast-text="Role name already exist!" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="Role Added Successfully" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>

<script type="text/javascript">
$(document).on('click', '#save_role', function (){
	$(this).attr('disabled','disabled');

	var thi = $(this);
	$("#privilege_error").html("");
	$("#role_name_error").html("");

	var formData = new FormData($('#add_role')[0]);
	formData.append("action", "add");
	formData.append("total_permissionForm", $('.permissionForm').length);
	var cnt = 1;
	$('.permissionForm').each(function () {
		var thi = $(this);
		var permissionForm = $(this).serialize();
		formData.append("permissionForm" + cnt, permissionForm);
		cnt++;
	});


	if (validate()) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('save_role'); ?>",
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			success: function (res) {
				var res = JSON.parse(res);
				$(thi).removeAttr("disabled");
				if (res.status == -1) {
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
					location.href = "<?php echo base_url('settings/role'); ?>";
				}
			},
			error: function (){
				$(thi).removeAttr("disabled");
				$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');
			}
		});
	}
	else{
		$(thi).removeAttr("disabled");
	}
})

function validate(){
	var valid = false;

	$('input[name=is_add]').each(function () {
		if ($(this).is(':checked')){
			valid = true;
		}
	});
	$('input[name=is_edit]').each(function () {
		if ($(this).is(':checked')){
			valid = true;
		}
	});
	$('input[name=is_delete]').each(function () {
		if ($(this).is(':checked')){
			valid = true;
		}
	});
	$('input[name=is_view]').each(function () {
		if ($(this).is(':checked')){
			valid = true;
		}
	});

	if(valid == false){
		$("#privilege_error").html("Please select at lease one privilege permission.");
	}

	if ($("#role_name").val() == ""){
		$("#role_name_error").html("Please provide role name.");
		valid = false;
	}

	return valid;
}

$(document).on('click', '#cancel_btn', function() {
	$(this).attr('disabled','disabled');
	location.href = "<?php echo base_url('settings/role'); ?>";
})
</script>

</body>
</html>
