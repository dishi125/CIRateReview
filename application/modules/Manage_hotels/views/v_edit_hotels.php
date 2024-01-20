<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Edit Hotel </title>
	<?php include 'layouts/title-meta.php'; ?>

	<?php include 'layouts/head-css.php'; ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
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
							<h4 class="mb-sm-0">Edit Hotel</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void(0)">Review Management</a></li>
									<li class="breadcrumb-item"><a href="<?= base_url('review_management/manage_hotels') ?>">Manage Hotels</a></li>
									<li class="breadcrumb-item active">Edit Hotel</li>
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
									<h5 class="card-title mb-0 flex-grow-1">Edit Hotel</h5>
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="edit_hotel" enctype="multipart/form-data">
									<input type="hidden" name="id" value="<?= $GetHotelList[0]['id'] ?>">
									<input type="hidden" name="customer" value="<?= $GetHotelList[0]['client_id'] ?>">
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Hotel Name</label>
												<input type="text" name="hotel_name" id="hotel_name" class="form-control" value="<?= $GetHotelList[0]['hotel_name'] ?>" readonly>
												<label id="hotel_name-error" class="error" for="hotel_name"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">E-mail</label>
												<input type="text" name="email" id="email" class="form-control" value="<?= $GetHotelList[0]['email'] ?>">
												<label id="email-error" class="error" for="email"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">To Mail Copy[CC]</label><br>
												<input type="text" value="<?= $GetHotelList[0]['copy_recipients'] ?>" data-role="tagsinput" id="copy_recipients" name="copy_recipients" class="form-control p-4">
												<label id="copy_recipients-error" class="error" for="copy_recipients"></label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">State</label>
												<select name="state" id="state" class="form-control">
													<option value=""></option>
													<?php foreach ($GetAllState as $state){ ?>
														<option value="<?= $state['StateName'] ?>" <?php if ($GetHotelList[0]['state'] == $state['StateName']) { echo 'selected'; } ?>><?= $state['state'] ?></option>
													<?php } ?>
												</select>
												<label id="state-error" class="error" for="state"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">City</label>
												<select name="city" id="city" class="form-control">
													<option value=""></option>
													<?php if (isset($GetAllCityByState) && $GetAllCityByState!="" && !empty($GetAllCityByState)){
														foreach ($GetAllCityByState as $city) {?>
														<option value="<?= $city['Id'] ?>" <?php if ($GetHotelList[0]['city_id'] == $city['Id']) { echo 'selected'; } ?>><?= $city['Name'] ?></option>
													<?php }
													} ?>
												</select>
												<label id="city-error" class="error" for="city"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Address</label>
												<input type="text" name="address" id="address" class="form-control" value="<?= $GetHotelList[0]['address'] ?>">
												<label id="address-error" class="error" for="address"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Cover Picture</label>
												<input type="file" name="cover_image" id="cover_image" class="form-control">
												<img id="cover_image_preview" src="<?= base_url('assets/hotel_cover_picture/'.$GetHotelList[0]['image']) ?>" width="100" height="100" class="mt-1">
												<label id="cover_image-error" class="error" for="cover_image"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Logo</label>
												<input type="file" name="hotel_logo" id="hotel_logo" class="form-control">
												<img id="hotel_logo_preview" src="<?= base_url('assets/hotel_logo/'.$GetHotelList[0]['logo']) ?>" width="100" height="100" class="mt-1">
												<label id="hotel_logo-error" class="error" for="hotel_logo"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Hotel Code</label>
												<input type="text" name="hotel_code" id="hotel_code" class="form-control" value="<?= $GetHotelList[0]['hotel_code'] ?>">
												<label id="hotel_code-error" class="error" for="hotel_code"></label>
											</div>
										</div>
									</div>

									<div class="text-end mb-3 mt-3">
										<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
										<button type="button" class="btn btn-info waves-effect waves-light w-lg" id="save_hotel">Save</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
$(document).ready(function (){
	$("#state").select2({
		placeholder: "Select State",
	});

	$("#city").select2({
		placeholder: "Select City",
	});

	$('#copy_recipients').tagsinput();
})

$('#state').change(function () {
	var state = $(this).val();

	if (state != '') {
		$.ajax({
			url: "<?php echo base_url().'GetAllCityByState'; ?>",
			method: "POST",
			data: { "state": state },
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#city").select2('destroy').val("").select2({
						placeholder: "Select City",
					});
					$('#city').html(res.html);
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
			error: function (){
				$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');
			}
		});
	}
	else {
		$('#city').html("");
		$("#city").select2('destroy').val("").select2({
			placeholder: "Select City",
		});
	}

	$('#hotel_name').html("");
	$("#address").val("");
});

$(document).on('click', '#cancel_btn', function (){
	$(this).attr('disabled','disabled');
	redirect_listpage();
})

function redirect_listpage(){
	location.href = "<?php echo base_url('review_management/manage_hotels')?>";
}

function validate_edit_hotel_form()
{
	$('#edit_hotel').validate({
		rules: {
			/*website: {
				required: true,
			},*/
			state: {
				required: true,
			},
			city: {
				required: true,
			},
			hotel_name: {
				required: true,
			},
			address: {
				required: true,
			},
		},
	});

	if($("#edit_hotel").valid() && $("#cover_image_preview").attr('src')!="" && $("#cover_image_preview").attr('src')!=undefined && $("#hotel_logo_preview").attr('src')!="" && $("#hotel_logo_preview").attr('src')!=undefined){
		return true;
	}
	else {
		if ($("#cover_image_preview").attr('src') == "" || $("#cover_image_preview").attr('src') == undefined){
			$("#cover_image-error").html("This field is required");
			$("#cover_image-error").show();
		}
		if ($("#hotel_logo_preview").attr('src') == "" || $("#hotel_logo_preview").attr('src') == undefined){
			$("#hotel_logo-error").html("This field is required");
			$("#hotel_logo-error").show();
		}
		return false;
	}
}

$(document).on('change', '#cover_image', function (event){
	filePreview(this);
})

function filePreview(input) {
	$("#cover_image_preview").removeAttr('src');
	$("#cover_image_preview").hide();
	$("#cover_image-error").html("");

	if (document.getElementById("cover_image").value == "") {
		$("#cover_image-error").html("This field is required");
		$("#cover_image-error").show();
	}
	else if (!hasExtension('cover_image', ['.jpg', '.jpeg', '.png'])) {
		alert("Cover picture must be .jpg, .jpeg and .png");
		document.getElementById("cover_image").value = "";
		$("#cover_image-error").html("This field is required");
		$("#cover_image-error").show();
	}
	else if(!validateImageSize(input)) {
		alert("Cover picture must not be greater than 8MB.");
		document.getElementById("cover_image").value = "";
		$("#cover_image-error").html("This field is required");
		$("#cover_image-error").show();
	}
	else {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#cover_image_preview").attr('src', e.target.result);
				$("#cover_image_preview").show();
			};
			reader.onerror = function (e) {
				alert("Cover picture is corrupted.");
				document.getElementById("cover_image").value = "";
				$("#cover_image-error").html("This field is required");
				$("#cover_image-error").show();
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
}

function hasExtension(inputID, exts) {
	var fileName = document.getElementById(inputID).value;
	return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
}

function validateImageSize(input) {
	const fileSize = input.files[0].size / 1024 / 1024; // in MiB
	if (fileSize > 8) {
		return false;
	}
	return true;
}

$(document).on('change', '#hotel_logo', function (event){
	hotelLogoPreview(this);
})

function hotelLogoPreview(input) {
	$("#hotel_logo_preview").removeAttr('src');
	$("#hotel_logo_preview").hide();
	$("#hotel_logo-error").html("");

	if (document.getElementById("hotel_logo").value == "") {
		$("#hotel_logo-error").html("This field is required");
		$("#hotel_logo-error").show();
	}
	else if (!hasExtension('hotel_logo', ['.jpg', '.jpeg', '.png', '.svg'])) {
		alert("Hotel logo  must be .jpg, .jpeg, .png and .svg");
		document.getElementById("hotel_logo").value = "";
		$("#hotel_logo-error").html("This field is required");
		$("#hotel_logo-error").show();
	}
	else if(!validateImageSize(input)) {
		alert("Hotel logo must not be greater than 8MB.");
		document.getElementById("hotel_logo").value = "";
		$("#hotel_logo-error").html("This field is required");
		$("#hotel_logo-error").show();
	}
	else {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$("#hotel_logo_preview").attr('src', e.target.result);
				$("#hotel_logo_preview").show();
			};
			reader.onerror = function (e) {
				alert("Hotel logo is corrupted.");
				document.getElementById("hotel_logo").value = "";
				$("#hotel_logo-error").html("This field is required");
				$("#hotel_logo-error").show();
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
}

$(document).on("click", "#save_hotel", function (){
	$(this).attr('disabled','disabled');
	var thi = $(this);
	var formData = new FormData($('#edit_hotel')[0]);

	if(validate_edit_hotel_form()){
		$.ajax({
			url: "<?php echo base_url().'save_clients_hotel'; ?>",
			method: "POST",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			cache: false,
			success: function (res) {
				if (res.status == "failed"){
					$("#error_toast").attr('data-toast-text', res.error);
					$("#error_toast").trigger('click');
				}
				else if (res.status == 1){
					$("#success_toast").attr('data-toast-text', "Hotel Updated successfully.");
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
</script>
