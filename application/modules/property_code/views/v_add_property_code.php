<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Add Property </title>
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
							<h4 class="mb-sm-0">Add Property</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
									<li class="breadcrumb-item"><a href="<?= base_url('settings/manage_property') ?>">List of Property</a></li>
									<li class="breadcrumb-item active">Add Property</li>
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
									<h5 class="card-title mb-0 flex-grow-1">Add Property</h5>
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="add_property">
									<div class="row">
										<div class="col-6">
											<div>
												<label for="labelInput" class="form-label">Property Name</label>
												<input type="text" name="PropertyName" id="PropertyName" class="form-control">
												<label id="PropertyName-error" class="error" for="PropertyName"></label>
											</div>
										</div>
										<div class="col-6">
											<div>
												<label for="labelInput" class="form-label">Property Code</label>
												<input type="text" name="HotelCode" id="HotelCode" class="form-control">
												<label id="HotelCode-error" class="error" for="HotelCode"></label>
											</div>
										</div>
									</div>

									<div class="text-end mb-3 mt-3">
										<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
										<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_property">Save</button>
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
<button type="button" id="success_toast" data-toast data-toast-text="Property Added Successfully" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>

<script type="text/javascript">
$(document).on("click", "#save_property", function (){
	$(this).attr('disabled','disabled');
	var userId = $("#users_dropdown").val();
	var formData = new FormData($('#add_property')[0]);
	formData.append('user_id', userId);
	var thi = $(this);

	if(validate_add_property_form()){
		$.ajax({
			url: "<?php echo base_url().'save_property'; ?>",
			method: "POST",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			cache: false,
			success: function (res) {
				// var res = JSON.parse(res);
				// console.log(res);
				if (res.status == 1){
					$("#success_toast").trigger('click');
					redirect_listpage();
				}
				else if(res.status == 0){
					$('#session_expired_modal').modal('show');
					setTimeout(function () {
						location.reload();
					}, auto_refresh_page_sec);
				}
				else {
					$(thi).removeAttr("disabled");
					$("#error_toast").attr('data-toast-text', "Something went wrong!!");
					$("#error_toast").trigger('click');
				}
			},
			error: function (){
				$(thi).removeAttr("disabled");
				$("#error_toast").attr('data-toast-text', 'Something went wrong!');
				$("#error_toast").trigger('click');
			}
		});
	}
	else{
		$(thi).removeAttr("disabled");
	}
})

$(document).on('click', '#cancel_btn', function (){
	redirect_listpage();
})

function redirect_listpage(){
	location.href = "<?php echo base_url('settings/manage_property')?>";
}

function validate_add_property_form(){
	$('#add_property').validate({
		rules: {
			PropertyName: {
				required: true,
			},
			HotelCode: {
				required: true,
			},
		},
	});

	if($("#add_property").valid()){
		return true;
	}
	else {
		return false;
	}
}
</script>
