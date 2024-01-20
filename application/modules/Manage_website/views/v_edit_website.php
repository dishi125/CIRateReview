<?php include 'layouts/head-main.php'; ?>

<head>
	<title> Edit Website</title>
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
							<h4 class="mb-sm-0">Edit Website</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void(0)">Manage Websites</a></li>
									<li class="breadcrumb-item"><a href="javascript:void(0)">List of Website</a></li>
									<li class="breadcrumb-item active">Edit Website</li>
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
									<h5 class="card-title mb-0 flex-grow-1">Edit Website</h5>
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="edit_website">
									<input type="hidden" name="id" value="<?= $website['id'] ?>">
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Website Name</label>
												<input type="text" name="website" id="website" class="form-control" value="<?= $website['name'] ?>">
												<label id="website-error" class="error" for="website"></label>
											</div>
										</div>
									</div>
									<div class="col-xxl-3 col-md-4">
										<div>
											<label for="labelInput" class="form-label">Link</label>
											<input type="text" name="link" id="link" class="form-control" value="<?= $website['link'] ?>">
											<label id="link-error" class="error" for="link"></label>
										</div>
									</div>
							</div>
							<div class="text-end mb-3 mt-3">
								<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
								<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_website">Save</button>
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
	$(document).on("click", "#save_website", function (){
		$(this).attr('disabled','disabled');
		var thi = $(this);

		var formData = new FormData($('#edit_website')[0]);

		if(validate_edit_website_form()){
			$.ajax({
				url: "<?php echo base_url().'save_website'; ?>",
				method: "POST",
				data: formData,
				dataType: "json",
				contentType: false,
				processData: false,
				cache: false,
				success: function (res) {
					if (res.status == 0){
						$("#error_toast").attr('data-toast-text', res.error);
						$("#error_toast").trigger('click');
					}
					else if (res.status == 1){
						$("#success_toast").attr('data-toast-text', "Website updated successfully.");
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
				complete: function (){
					$(thi).removeAttr("disabled");
				},
				error: function (){
					$("#error_toast").attr('data-toast-text', "Something went wrong!!");
					$("#error_toast").trigger('click');
				}
			});
		}
		else {
			$(thi).removeAttr("disabled");
		}
	})

	$(document).on('click', '#cancel_btn', function (){
		redirect_listpage();
	})

	function redirect_listpage(){
		location.href = "<?php echo base_url('manage_website')?>";
	}

	function validate_edit_website_form()
	{
		$('#edit_website').validate({
			rules: {
				website: {
					required: true,
				},
				link: {
					required: true,
				},
			},
		});

		if($("#edit_website").valid() ){
			return true;
		}
		else {
			return false;
		}
	}
</script>

</body>
</html>
