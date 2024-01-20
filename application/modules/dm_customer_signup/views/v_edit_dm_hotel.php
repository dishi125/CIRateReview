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
									<li class="breadcrumb-item"><a href="javascript:void(0)">DM Customer Signup</a></li>
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
								<div class="alert alert-danger" role="alert" style="display: none" id="hotel_error">Please add at lease one hotel.</div>

								<form method="post" id="dm_customer_signup">
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Name of corporation</label>
												<input type="text" name="corporation_name" id="corporation_name" class="form-control" value="<?= $dms_hotel['corporation_name'] ?>">
												<label id="corporation_name-error" class="error" for="corporation_name"></label>
											</div>
										</div>
										<!--<div class="col-xxl-3 col-md-4">
											<button type="button" class="btn btn-success add-btn" id="add_dm_hotel_btn"><i class="ri-add-line align-bottom me-1"></i> Add Hotel</button>
										</div>-->
									</div>
								</form>

								<div id="hotel_1" style="border: 2px solid royalblue; border-radius: 5px; padding: 10px;position: relative;" class="mt-5 hotel_form_div">
									<label style="color: white; padding: 5px;position: absolute;background-color: royalblue;top: -15px; left: 15px;font-weight: bold">Edit Hotel Informations</label>
									<form method="post" enctype="multipart/form-data" class="hotel_form mt-3">
										<input type="hidden" name="hotel_id" value="<?= $dms_hotel['id'] ?>">
										<input type="hidden" name="dm_corporate_id" value="<?= $dms_hotel['dm_corporate_id'] ?>">
										<input type="hidden" name="db_images" value="<?= $dms_hotel['images'] ?>">
										<h5 style="margin: 0"><u>Hotel Info</u></h5>
										<div class="row">
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Brand name</label>
													<input type="text" name="brand_name" id="brand_name" class="form-control" value="<?= $dms_hotel['brand_name'] ?>">
													<label id="brand_name-error" class="error" for="brand_name"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Hotel Name</label>
													<input type="text" name="hotel_name" id="hotel_name" class="form-control" value="<?= $dms_hotel['hotel_name'] ?>">
													<label id="hotel_name-error" class="error" for="hotel_name"></label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Hotel Address</label>
													<input type="text" name="hotel_address" id="hotel_address" class="form-control" value="<?= $dms_hotel['hotel_address'] ?>">
													<label id="hotel_address-error" class="error" for="hotel_address"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Phone</label>
													<input type="text" name="phone" id="phone" class="form-control" value="<?= $dms_hotel['phone'] ?>">
													<label id="phone-error" class="error" for="phone"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Email address – reporting</label>
													<input type="text" name="email" id="email" class="form-control" value="<?= $dms_hotel['email'] ?>">
													<label id="email-error" class="error" for="email"></label>
												</div>
											</div>
										</div>

										<h5 style="margin: 0"><u>Website Build & SEO</u></h5>
										<div class="row">
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Prefer hotel domain name</label>
													<input type="text" name="hotel_domain" id="hotel_domain" class="form-control" value="<?= $dms_hotel['hotel_domain'] ?>">
													<label id="hotel_domain-error" class="error" for="hotel_domain"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div>
													<label for="labelInput" class="form-label mb-0">Franchise Hotel website link</label>
													<input type="text" name="Franchise_hotel_website" id="Franchise_hotel_website" class="form-control" value="<?= $dms_hotel['franchise_hotel_website_link'] ?>">
													<label id="Franchise_hotel_website-error" class="error" for="Franchise_hotel_website"></label>
												</div>
											</div>
											<div class="col-xxl-3 col-md-4">
												<div id="input-images_1" class="input-images"></div>
												<?php
												if ($dms_hotel['images']!="") {
													$dm_hotel_images = explode(",", $dms_hotel['images']);
													$images = array();
													foreach ($dm_hotel_images as $img) {
														$temp['src'] = base_url('assets/dm_customer_hotels/' . $img);
														array_push($images, $temp);
													}
												}
												?>
											</div>
										</div>

										<h5 style="margin: 0"><u>Reputation Management</u></h5>
										<div id="reputation-error" class="error"></div>
										<div class="row gy-4 mt-1" id="add_site_div">
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
												<div>
													<label for="labelInput" class="form-label mb-0">Website</label>
													<select name="select_website" class="form-select select_website" id="select_website">
														<option value="" selected disabled>Select Website</option>
														<?php $dms_reputation_ids = array_column($dms_reputation, 'website_id');
														foreach ($GetAllReputation as $website){
														   if (!in_array($website['id'], $dms_reputation_ids)){ ?>
															<option value="<?= $website['id'] ?>" link="<?= $website['link'] ?>"><?= $website['name'] ?></option>
														<?php } } ?>
													</select>
													<div id="select_website-error" class="error" for="select_website"></div>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
												<div>
													<label for="labelInput" class="form-label mb-0">Username</label>
													<input type="text" name="username" id="username" class="form-control">
													<div id="username-error" class="error" for="username"></div>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
												<div>
													<label for="labelInput" class="form-label mb-0">Password</label>
													<input type="password" name="password" id="password" class="form-control">
													<div id="password-error" class="error" for="password"></div>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
												<div>
													<button type="button" id="add_site_btn" class="btn btn-soft-secondary waves-effect waves-light">Add</button>
												</div>
											</div>
										</div>
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
										<div id="social_media_market-error" class="error" for=""></div>
										<div class="row gy-4 mt-1" id="add_social_media_div">
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
												<div>
													<label for="labelInput" class="form-label mb-0">Social Media</label>
													<select name="select_social_media" class="form-select select_social_media" id="select_social_media">
														<option value="" selected disabled>Select Social Media</option>
														<?php $dms_social_media_ids = array_column($dms_social_media, 'website_id');
														foreach ($GetAllSocialmedia as $website){
															if (!in_array($website['id'], $dms_social_media_ids)){ ?>
																<option value="<?= $website['id'] ?>" link="<?= $website['link'] ?>"><?= $website['name'] ?></option>
														<?php } } ?>
													</select>
													<div id="select_social_media-error" class="error" for="select_social_media"></div>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
												<div>
													<label for="labelInput" class="form-label mb-0">Username</label>
													<input type="text" name="username" id="username" class="form-control">
													<div id="username-error" class="error" for="username"></div>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
												<div>
													<label for="labelInput" class="form-label mb-0">Password</label>
													<input type="password" name="password" id="password" class="form-control">
													<div id="password-error" class="error" for="password"></div>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
												<div>
													<button type="button" id="add_social_media_btn" class="btn btn-soft-secondary waves-effect waves-light">Add</button>
												</div>
											</div>
										</div>
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

<!--								<button type="button" class="btn btn-success add-btn mt-2" id="add_dm_hotel_btn"><i class="ri-add-line align-bottom me-1"></i> Add More Hotel</button>-->

								<div id="added_hotels_div">
								</div>

								<div class="text-end mb-3 mt-2">
									<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
									<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_dm_customer_signup">Submit</button>
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

<button type="button" id="error_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>
<div class="modal fade" id="success_modal" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center p-5">
				<div class="mt-4 pt-4">
					<h3>Thank You</h3>
					<p class="text-muted">Your data has been sent successfull!</p>
					<!-- Toogle to second dialog -->
					<button class="btn btn-danger" id="btn_success">Ok</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<script type="text/javascript" src="<?= base_url('assets/image_uploader/image-uploader.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/image_uploader/image-uploader.js') ?>"></script>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
$(document).ready(function (){
	var images = <?= (isset($images) && !empty($images)) ? json_encode($images) : "''" ?>;

	if (images == '') {
		$('#input-images_1').imageUploader({
			extensions: ['.jpg', '.jpeg', '.png', '.svg', '.pdf', '.html', '.htm', '.txt', '.doc', '.docx', '.xls', '.xlsx', '.mp4', '.mp3', '.mpeg',
				'.ppt', '.pptx', '.rar', '.zip', '.tif', '.tiff', '.wav'],
			mimes: ['image/jpeg', 'image/png', 'image/svg+xml', 'application/pdf', 'text/html', 'text/plain', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'video/mp4', 'audio/mpeg',
				'video/mpeg', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'application/vnd.rar', 'application/zip', 'image/tiff', 'audio/wav'],
			maxSize: 8 * 1024 * 1024,
			maxFiles: 10,
		});
	}
	else {
		$('#input-images_1').imageUploader({
			extensions: ['.jpg', '.jpeg', '.png', '.svg', '.pdf', '.html', '.htm', '.txt', '.doc', '.docx', '.xls', '.xlsx', '.mp4', '.mp3', '.mpeg',
				'.ppt', '.pptx', '.rar', '.zip', '.tif', '.tiff', '.wav'],
			mimes: ['image/jpeg', 'image/png', 'image/svg+xml', 'application/pdf', 'text/html', 'text/plain', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'video/mp4', 'audio/mpeg',
				'video/mpeg', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'application/vnd.rar', 'application/zip', 'image/tiff', 'audio/wav'],
			maxSize: 8 * 1024 * 1024,
			maxFiles: 10,
			preloaded: images,
			preloadedInputName: 'old_image'
		});
	}
})

$(document).on('click', '#add_site_btn', function (){
	var thi = $(this);
	var website_id = $(this).parents('#add_site_div:first').find('#select_website').val();
	var website_link = $(this).parents('#add_site_div:first').find('#select_website option:selected').attr('link');
	var username = $(this).parents('#add_site_div:first').find('#username').val();
	var password = $(this).parents('#add_site_div:first').find('#password').val();

	$(thi).parents('#add_site_div:first').find('#select_website-error').html("");
	$(thi).parents('#add_site_div:first').find('#username-error').html("");
	$(thi).parents('#add_site_div:first').find('#password-error').html("");
	var valid = true;

	if (website_id=="" || website_id==undefined){
		$(thi).parents('#add_site_div:first').find('#select_website-error').html("Please select website.");
		valid = false;
	}
	if (username=="" || username==undefined){
		$(thi).parents('#add_site_div:first').find('#username-error').html("Please add username.");
		valid = false;
	}
	if (password=="" || password==undefined){
		$(thi).parents('#add_site_div:first').find('#password-error').html("Please add password.");
		valid = false;
	}

	var html = `<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
						<div>
							<label for="labelInput" class="form-label mb-0" website-id="${website_id}" id="website_id">${website_link}</label>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
						<div>
							Login: <label for="labelInput" class="form-label mb-0" id="repu_user">${username}</label>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
						<div>
							Password: <label for="labelInput" class="form-label mb-0" id="repu_pwd">${password}</label>
						</div>
					</div>
				</div>`;

	if (valid) {
		$(thi).parents('#add_site_div:first').siblings("#added_sites_div").append(html);
		$(thi).parents('#add_site_div:first').find('#select_website option:selected').remove();
		$(thi).parents('#add_site_div:first').find('#select_website option:first').prop('selected', true);
		$(thi).parents('#add_site_div:first').find('#username').val("");
		$(thi).parents('#add_site_div:first').find('#password').val("");
	}
})

$(document).on('click', '#add_social_media_btn', function (){
	var thi = $(this);
	var website_id = $(this).parents('#add_social_media_div:first').find('#select_social_media').val();
	var website_link = $(this).parents('#add_social_media_div:first').find('#select_social_media option:selected').attr('link');
	var username = $(this).parents('#add_social_media_div:first').find('#username').val();
	var password = $(this).parents('#add_social_media_div:first').find('#password').val();

	$(thi).parents('#add_social_media_div:first').find('#select_social_media-error').html("");
	$(thi).parents('#add_social_media_div:first').find('#username-error').html("");
	$(thi).parents('#add_social_media_div:first').find('#password-error').html("");
	var valid = true;

	if (website_id=="" || website_id==undefined){
		$(thi).parents('#add_social_media_div:first').find('#select_social_media-error').html("Please select website.");
		valid = false;
	}
	if (username=="" || username==undefined){
		$(thi).parents('#add_social_media_div:first').find('#username-error').html("Please add username.");
		valid = false;
	}
	if (password=="" || password==undefined){
		$(thi).parents('#add_social_media_div:first').find('#password-error').html("Please add password.");
		valid = false;
	}

	var html = `<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
						<div>
							<label for="labelInput" class="form-label mb-0" id="website_id" website-id="${website_id}">${website_link}</label>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
						<div>
							Login: <label for="labelInput" class="form-label mb-0" id="social_user">${username}</label>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 0">
						<div>
							Password: <label for="labelInput" class="form-label mb-0" id="social_pwd">${password}</label>
						</div>
					</div>
				</div>`;

	if (valid) {
		$(thi).parents('#add_social_media_div:first').siblings("#added_social_media_div").append(html);
		$(thi).parents('#add_social_media_div:first').find('#select_social_media option:selected').remove();
		$(thi).parents('#add_social_media_div:first').find('#select_social_media option:first').prop('selected', true);
		$(thi).parents('#add_social_media_div:first').find('#username').val("");
		$(thi).parents('#add_social_media_div:first').find('#password').val("");
	}
})

$(document).on("click", "#cancel_btn", function (){
	$(this).attr('disabled', 'disabled');
	location.href = "<?= base_url('dm_customer_signup_list') ?>";
})

$(document).on('click', "#save_dm_customer_signup", function (){
	$(this).attr('disabled', 'disabled');
	var thi = $(this);
	var valid = true;
	valid_repu_social = true;

	$(".error").html("");

	validate_dm_customer_signup_form("#dm_customer_signup");
	if (!$("#dm_customer_signup").valid()) {
		valid = false;
	}

	$('.hotel_form').each(function () { //for validate forms
		validate_hotel_form(this);
		if (!$(this).valid()) {
			valid = false;
		}
	});

	if(valid && valid_repu_social){
		var form = new FormData($(".hotel_form")[0]);
		form.append('corporation_name', $("#corporation_name").val());
		$(".uploaded-image").each(function (){
			var src = $(this).find('img').attr('src');
			var name = src.split("/").pop();
			if ($(this).attr('data-preloaded') == "true"){
				form.append('old_images[]', name);
			}
		})
		var reput = $("#added_sites_div").children('div');
		$(reput).each(function (){
			var repu_web = $(this).find("#website_id").attr("website-id");
			var repu_user = $(this).find("#repu_user").html();
			var repu_pwd = $(this).find("#repu_pwd").html();
			form.append("repu_web[]", repu_web);
			form.append("repu_user[]", repu_user);
			form.append("repu_pwd[]", repu_pwd);
		})
		var social = $("#added_social_media_div").children('div');
		$(social).each(function (){
			var social_web = $(this).find("#website_id").attr("website-id");
			var social_user = $(this).find("#social_user").html();
			var social_pwd = $(this).find("#social_pwd").html();
			form.append("social_web[]", social_web);
			form.append("social_user[]", social_user);
			form.append("social_pwd[]", social_pwd);
		})

		// console.log(form);

		$.ajax({
			url: "<?php echo base_url().'update_customer_signup'; ?>",
			method: "POST",
			data: form,
			// data: { "images": images, "data": JSON.stringify(data) },
			// data: data,
			dataType: "json",
			contentType: false,
			cache: false,
			processData: false,
			success: function (res) {
				// var res = JSON.parse(res);
				if (res.status == 1){
					$("#success_toast").attr('data-toast-text', "Hotel updated successfully.");
					$("#success_toast").trigger('click');
					location.href = "<?= base_url('dm_customer_signup_list') ?>";
				}
				else if(res.status == 0){
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
				$(thi).removeAttr("disabled");
			}
		});
	}
	else {
		$(thi).removeAttr("disabled");
	}
})

var valid_repu_social;
function validate_hotel_form(form)
{
	$(form).validate({
		onkeyup: function (element) {
			$(element).valid()
		},
		rules: {
			brand_name: {
				required: true,
			},
			hotel_name: {
				required: true,
			},
			hotel_address: {
				required: true,
			},
			phone: {
				required: true,
				digits: true,
				minlength:10,
				maxlength:10,
			},
			email: {
				required: true,
				email: true
			},
			hotel_domain: {
				required: true,
			},
			Franchise_hotel_website: {
				required: true,
			},
		},
		messages: {
			/*hotel_code: {
				noSpace: "only one word can enter, no space allowed.",
			},*/
		}
	}).settings.ignore = [];

	if ($(form).find("#added_sites_div").html() == ""){
		$(form).find("#reputation-error").html("Please add at least one Reputation.");
		valid_repu_social = false;
	}

	if ($(form).find("#added_social_media_div").html() == ""){
		$(form).find("#social_media_market-error").html("Please add at least one Social Media Market.");
		valid_repu_social = false;
	}
}

function validate_dm_customer_signup_form(form)
{
	$(form).validate({
		onkeyup: function (element) {
			$(element).valid()
		},
		rules: {
			corporation_name: {
				required: true,
			},
		},
		messages: {
			/*hotel_code: {
				noSpace: "only one word can enter, no space allowed.",
			},*/
		}
	}).settings.ignore = [];
}
</script>

</body>
</html>
