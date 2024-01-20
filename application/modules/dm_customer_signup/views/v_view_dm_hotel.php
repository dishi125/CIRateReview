<?php include 'layouts/head-main.php'; ?>

<head>

	<title> DM Customer Signup </title>
	<?php include 'layouts/title-meta.php'; ?>

	<?php include 'layouts/head-css.php'; ?>
	<link rel="stylesheet" href="<?= base_url('assets/image_uploader/image-uploader.min.css') ?>">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,700|Montserrat:300,400,500,600,700|Source+Code+Pro&display=swap" rel="stylesheet">
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
							<h4 class="mb-sm-0">DM Customer Signup</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="<?= base_url('dm_customer_signup_list') ?>">DM Customer Signup</a></li>
									<li class="breadcrumb-item active">View DM Hotel</li>
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
									<!--									<h5 class="card-title mb-0 flex-grow-1">DM Customer Signup</h5>-->
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="dm_customer_signup">
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Name of corporation</label>
												<input type="text" name="corporation_name" id="corporation_name" class="form-control" value="<?= $dms_hotel['corporation_name'] ?>" disabled>
												<label id="corporation_name-error" class="error" for="corporation_name"></label>
											</div>
										</div>
										<!--<div class="col-xxl-3 col-md-4">
											<button type="button" class="btn btn-success add-btn" id="add_dm_hotel_btn"><i class="ri-add-line align-bottom me-1"></i> Add Hotel</button>
										</div>-->
									</div>
								</form>

								<div id="hotel_1" style="border: 2px solid royalblue; border-radius: 5px; padding: 10px;position: relative;" class="mt-5 hotel_form_div">
									<label style="color: white; padding: 5px;position: absolute;background-color: royalblue;top: -15px; left: 15px;font-weight: bold">Hotel Informations</label>
									<form method="post" enctype="multipart/form-data" class="hotel_form mt-3">
										<input type="hidden" name="hotel_id" value="<?= $dms_hotel['id'] ?>">
										<input type="hidden" name="dm_corporate_id" value="<?= $dms_hotel['dm_corporate_id'] ?>">
										<input type="hidden" name="db_images" value="<?= $dms_hotel['images'] ?>">
										<h5 style="margin: 0"><u>Hotel Info</u></h5>
										<div class="row">
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Brand name</label>
													<input type="text" name="brand_name" id="brand_name" class="form-control" value="<?= $dms_hotel['brand_name'] ?>" disabled>
													<label id="brand_name-error" class="error" for="brand_name"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Hotel Name</label>
													<input type="text" name="hotel_name" id="hotel_name" class="form-control" value="<?= $dms_hotel['hotel_name'] ?>" disabled>
													<label id="hotel_name-error" class="error" for="hotel_name"></label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Hotel Address</label>
													<input type="text" name="hotel_address" id="hotel_address" class="form-control" value="<?= $dms_hotel['hotel_address'] ?>" disabled>
													<label id="hotel_address-error" class="error" for="hotel_address"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Phone</label>
													<input type="text" name="phone" id="phone" class="form-control" value="<?= $dms_hotel['phone'] ?>" disabled>
													<label id="phone-error" class="error" for="phone"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Email address – reporting</label>
													<input type="text" name="email" id="email" class="form-control" value="<?= $dms_hotel['email'] ?>" disabled>
													<label id="email-error" class="error" for="email"></label>
												</div>
											</div>
										</div>

										<h5 style="margin: 0"><u>Website Build & SEO</u></h5>
										<div class="row">
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Prefer hotel domain name</label>
													<input type="text" name="hotel_domain" id="hotel_domain" class="form-control" value="<?= $dms_hotel['hotel_domain'] ?>" disabled>
													<label id="hotel_domain-error" class="error" for="hotel_domain"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Franchise Hotel website link</label>
													<input type="text" name="Franchise_hotel_website" id="Franchise_hotel_website" class="form-control" value="<?= $dms_hotel['franchise_hotel_website_link'] ?>" disabled>
													<label id="Franchise_hotel_website-error" class="error" for="Franchise_hotel_website"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
<!--												<div id="input-images_1" class="input-images" style="pointer-events: none"></div>-->
												<?php if ($dms_hotel['images']!="") { ?>
												<div>
													<label for="labelInput" class="form-label mb-0">Files</label>
													<div class="row" style="border: 2px solid lightgray; border-radius: 5px;margin-right: 1px;">
													<?php $dm_hotel_images = explode(",", $dms_hotel['images']);
													$images = array();
													foreach ($dm_hotel_images as $img) { ?>
													<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" style="padding-right: 0">
													<a href="<?= base_url('assets/dm_customer_hotels/' . $img) ?>" target="_blank"><?= $img ?></a>
													</div>
													<?php } ?>
													</div>
												</div>
												<?php } ?>
											</div>
										</div>

										<h5 style="margin: 0"><u>Reputation Management</u></h5>
										<div id="added_sites_div">
											<?php if (isset($dms_reputation) && !empty($dms_reputation)){
												foreach ($dms_reputation as $reputation) {?>
													<div class="row">
														<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
															<div>
																<label for="labelInput" class="form-label mb-0" website-id="<?= $reputation['website_id'] ?>" id="website_id"><?= $reputation['link'] ?></label>
															</div>
														</div>
														<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
															<div>
																Login: <label for="labelInput" class="form-label mb-0" id="repu_user"><?= $reputation['username'] ?></label>
															</div>
														</div>
														<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
															<div>
																Password: <label for="labelInput" class="form-label mb-0" id="repu_pwd"><?= $reputation['password'] ?></label>
															</div>
														</div>
													</div>
												<?php }
											} ?>
										</div>

										<h5 class="mt-3 mb-0"><u>Social Media Market</u></h5>
										<div id="added_social_media_div">
											<?php if (isset($dms_social_media) && !empty($dms_social_media)) {
												foreach ($dms_social_media as $social_media) { ?>
													<div class="row">
														<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
															<div>
																<label for="labelInput" class="form-label mb-0" id="website_id" website-id="<?= $social_media['website_id'] ?>"><?= $social_media['link'] ?></label>
															</div>
														</div>
														<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
															<div>
																Login: <label for="labelInput" class="form-label mb-0" id="social_user"><?= $social_media['username'] ?></label>
															</div>
														</div>
														<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
															<div>
																Password: <label for="labelInput" class="form-label mb-0" id="social_pwd"><?= $social_media['password'] ?></label>
															</div>
														</div>
													</div>
												<?php }
											} ?>
										</div>
									</form>
								</div>

								<!--<div class="text-end mb-3 mt-2">
									<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
									<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_dm_customer_signup">Submit</button>
								</div>-->
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

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<script type="text/javascript" src="<?= base_url('assets/image_uploader/image-uploader.min.js') ?>"></script>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
$(document).ready(function (){
	/*var images = <?= (isset($images) && !empty($images)) ? json_encode($images) : "''" ?>;

	if (images == '') {

	}
	else {
		$('#input-images_1').imageUploader({
			extensions: ['.jpg', '.jpeg', '.png', '.svg'],
			mimes: ['image/jpeg', 'image/png', 'image/svg+xml'],
			maxSize: 2 * 1024 * 1024,
			maxFiles: 10,
			preloaded: images,
			preloadedInputName: 'old_image'
		});
	}*/
})
</script>

</body>
</html>
