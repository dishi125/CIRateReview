<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Support </title>
	<?php include 'layouts/title-meta.php'; ?>

	<?php include 'layouts/head-css.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<!--<div id="layout-wrapper">-->

<!--	--><?php //include 'layouts/menu.php'; ?>

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<!--<div class="main-content">

		<div class="page-content">-->
			<div class="container-fluid">

				<!-- start page title -->
				<!--<div class="row">
					<div class="col-12">
						<div class="page-title-box d-sm-flex align-items-center justify-content-between">
							<h4 class="mb-sm-0">Support</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item active">Support</li>
								</ol>
							</div>

						</div>
					</div>
				</div>-->
				<!-- end page title -->

				<div class="row mt-5 justify-content-center">
					<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
						<div class="card">
							<div class="card-body">
								<form method="post" id="add_support">
									<div class="row">
										<div class="col-xxl-3 col-md-6">
											<div>
												<label for="labelInput" class="form-label">User Name</label>
												<input type="text" class="form-control" id="username" name="username">
												<label id="username-error" class="error" for="username"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-6">
											<div>
												<label for="labelInput" class="form-label">E-mail</label>
												<input type="text" class="form-control" id="user_email" name="user_email">
												<label id="user_email-error" class="error" for="user_email"></label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-6">
											<div>
												<label for="labelInput" class="form-label">Problem Type</label>
												<input type="text" class="form-control" id="problem_type" name="problem_type">
												<label id="problem_type-error" class="error" for="problem_type"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-6">
											<div>
												<label for="labelInput" class="form-label">Reported Problem</label>
												<input type="text" class="form-control" id="reported_problem" name="reported_problem">
												<label id="reported_problem-error" class="error" for="reported_problem"></label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-6">
											<div>
												<label for="labelInput" class="form-label">Subject</label>
												<input type="text" class="form-control" id="subject" name="subject">
												<label id="subject-error" class="error" for="subject"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-6">
											<div>
												<label for="labelInput" class="form-label">Message</label>
												<textarea class="form-control" id="message" name="message"></textarea>
												<label id="message-error" class="error" for="message"></label>
											</div>
										</div>
									</div>
								</form>

								<div class="text-end mb-3 mt-3">
									<!--									<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>-->
									<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_support">Submit</button>
								</div>
							</div>
						</div><!-- end card -->
					</div><!-- end col -->
				</div>
				<!-- end row -->

			</div>
			<!-- container-fluid -->
		<!--</div>
		 End Page-content

		<?php /*include 'layouts/footer.php'; */?>
	</div>

</div>-->
<!--END layout-wrapper-->

<button type="button" id="error_toast" data-toast data-toast-text="Something went wrong!" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<?php //include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<!--<script src="--><?php //echo base_url().'assets/js/app.js'; ?><!--"></script>-->

<script type="text/javascript">
$(document).on("click", "#save_support", function (){
	$(this).attr('disabled', 'disabled');
	var formData = new FormData($('#add_support')[0]);
	var thi = $(this);

	if (validate_add_support_form()) {
		$.ajax({
			url: "<?php echo base_url() . 'save_support'; ?>",
			method: "POST",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			cache: false,
			success: function(res) {
				if (res.status == 1) {
					$("#success_toast").attr('data-toast-text', "Support submitted successfully.");
					$("#success_toast").trigger('click');
					location.reload();
				}
				else {
					$("#error_toast").attr('data-toast-text', "Something went wrong!!");
					$("#error_toast").trigger('click');
				}
			},
			error: function() {
				$(thi).removeAttr("disabled");
				$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');
			},
			complete: function () {
				$(thi).removeAttr("disabled");
			}
		});
	}
	else {
		$(thi).removeAttr("disabled");
	}
})

function validate_add_support_form(){
	$('#add_support').validate({
		rules: {
			username: {
				required: true,
			},
			user_email: {
				required: true,
				email: true
			},
			problem_type: {
				required: true,
			},
			reported_problem: {
				required: true,
			},
			subject: {
				required: true,
			},
			message: {
				required: true,
			}
		},
	});

	if ($("#add_support").valid()) {
		return true;
	} else {
		return false;
	}
}
</script>

</body>
</html>
