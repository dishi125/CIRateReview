<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Edit Credential </title>
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
							<h4 class="mb-sm-0">Edit Credential</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void(0)">Review Management</a></li>
									<li class="breadcrumb-item"><a href="<?= base_url('review_management/manage_credentials') ?>">Manage Credentials</a></li>
									<li class="breadcrumb-item active">Edit Credential</li>
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
									<h5 class="card-title mb-0 flex-grow-1">Edit Credential</h5>
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="edit_credentials">
									<input type="hidden" name="id" value="<?= $cred['id'] ?>">
									<input type="hidden" name="customer" value="<?= $cred['client_id'] ?>">
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Hotel Name</label>
												<select name="cred_hotel_name" id="cred_hotel_name" class="form-control" disabled>
													<?php foreach ($GetAllhotels as $hotel){ ?>
														<option value="<?= $hotel['id'] ?>" <?php if ($cred['hotel_id'] == $hotel['id']) { echo 'selected'; } ?>><?= $hotel['hotel_name'] ?></option>
													<?php } ?>
												</select>
												<label id="cred_hotel_name-error" class="error" for="cred_hotel_name"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Website</label>
												<select name="website" id="website" class="form-control" disabled>
													<?php foreach ($GetAllWebsite as $website){ ?>
														<option value="<?= $website['id'] ?>" <?php if ($cred['website_id'] == $website['id']) { echo 'selected'; } ?>><?= $website['name'] ?></option>
													<?php } ?>
												</select>
												<label id="website-error" class="error" for="website"></label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">User Name</label>
												<input type="text" name="user_name" id="user_name" class="form-control" value="<?= $cred['user_name'] ?>">
												<label id="user_name-error" class="error" for="user_name"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Password</label>
												<input type="password" name="password" id="password" class="form-control" value="<?= $cred['password'] ?>">
												<label id="password-error" class="error" for="password"></label>
											</div>
										</div>
									</div>
									<div class="text-end mb-3 mt-3">
										<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
										<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_credentials">Save</button>
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
<button type="button" id="success_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
$(document).ready(function (){
/*	$("#website").select2({
		placeholder: "Select Website",
	});
	$("#cred_hotel_name").select2({
		placeholder: "Select Hotel Name",
	});*/
})

/*$('#website').change(function () {
	GetHotelNameByWebsite();
});*/

/*$('#users_dropdown').change(function () {
	GetHotelNameByWebsite();
});*/

$(document).on("click", "#save_credentials", function (){
	var formData = new FormData($('#edit_credentials')[0]);
	formData.append('cred_hotel_name', $("#cred_hotel_name").val());
	formData.append('website', $("#website").val());
	if(validate_edit_credentials_form()){
		$.ajax({
			url: "<?php echo base_url().'save_credentials'; ?>",
			method: "POST",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			cache: false,
			success: function (res) {
				//alert(res);
				//var res = JSON.parse(res);
				//	alert(res.status);
				if (res.status == "error"){
					$("#error_toast").attr('data-toast-text', res.error);
					$("#error_toast").trigger('click');
				}
				else if (res.status == 0){
					$("#error_toast").attr('data-toast-text', "Credentials already exist on this website.");
					$("#error_toast").trigger('click');
				}
				else if (res.status == 1){
					$("#success_toast").attr('data-toast-text', "credentials Updated successfully.");
					$("#success_toast").trigger('click');
					redirect_listpage();
				}
				else if(res.status == 404){
					$('#session_expired_modal').modal('show');
					setTimeout(function () {
						location.reload();
					}, auto_refresh_page_sec);
				}
				else {
					$("#error_toast").attr('data-toast-text', "Something went wrong!!");
					$("#error_toast").trigger('click');
				}
			},
			error: function (){
				$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');
			}
		});
	}
})

$(document).on('click', '#cancel_btn', function (){
	redirect_listpage();
})

function redirect_listpage(){
	location.href = "<?php echo base_url('manage_credentials')?>";
}

function validate_edit_credentials_form()
{
	$('#edit_credentials').validate({
		rules: {
			website: {
				required: true,
			},
			cred_hotel_name: {
				required: true,
			},
			password: {
				required: true,
			},
			user_name: {
				required: true,
			},
		},
	});

	if($("#edit_credentials").valid() ){
		return true;
	}
	else {
		return false;
	}
}
</script>
