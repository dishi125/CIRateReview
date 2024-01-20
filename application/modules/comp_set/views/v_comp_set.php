<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Comp Set </title>
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
							<h4 class="mb-sm-0">Comp Set</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void();">Settings</a></li>
									<li class="breadcrumb-item active">Comp Set</li>
								</ol>
							</div>

						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<div class="col-xl-12 col-lg-12">
						<div class="card">
							<!--<div class="card-header border-0">
								<div class="d-flex align-items-center">
									<h5 class="card-title mb-0 flex-grow-1">List of role</h5>
								</div>
							</div>-->

							<!--<div class="card-body border border-dashed border-end-0 border-start-0">
								<form>
									<div class="col-xxl-5 col-sm-6">
										<div class="search-box">
											<input type="text" class="form-control search" placeholder="Search for order ID, customer, order status or something...">
											<i class="ri-search-line search-icon"></i>
										</div>
									</div>
								</form>
							</div>-->

							<div class="card-body pt-0">
								<div class="live-preview">
									<div class="row gy-4">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="basiInput" class="form-label mb-0 mt-2">State</label>
												<select class="form-control" id="state" name="state">
													<option value=""></option>
													<?php foreach ($GetAllState as $state){ ?>
														<option value="<?php echo $state['state'] ?>" state-code="<?= $state['StateName'] ?>"> <?php echo $state['state'] ?> </option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="basiInput" class="form-label mb-0 mt-2">City</label>
												<select class="form-control" id="city" name="city">
												</select>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="basiInput" class="form-label mb-0 mt-2">Miles</label>
												<select class="form-control" id="miles" name="miles">
													<option value="5" selected>5</option>
													<option value="10">10</option>
													<option value="15">15</option>
													<option value="20">20</option>
													<option value="25">25</option>
													<option value="30">30</option>
												</select>
											</div>
										</div>
									</div>

									<div class="row gy-4">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="basiInput" class="form-label mb-0 mt-2">Website</label>
												<select class="form-control" id="website" name="website">
													<option value=""></option>
													<?php foreach ($GetAllWebsite as $website){ ?>
														<option value="<?php echo $website['Id'] ?>"> <?php echo $website['Name'] ?> </option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="basiInput" class="form-label mb-0 mt-2">Hotel Name</label>
												<select class="form-control" id="hotel" name="hotel">
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- end card -->

						<div class="card">
							<div class="card-body">
								<div class="live-preview">
									<div class="table-responsive" id="comp_set_table_div">
										<table class="table align-middle table-nowrap mb-0 paginated" id="comp_set" style="width: 100%">
											<thead class="table-light">
											<tr>
												<th scope="col"></th>
												<th scope="col">Hotel Name</th>
												<th scope="col">Type</th>
												<th scope="col">City</th>
												<th scope="col">State</th>
											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
										<!-- end table -->
										<div class='loading-ct' style="display: none">
											<div class='part_loading'>
												<i class="mdi mdi-spin mdi-loading fa-3x"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
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

<div class="modal fade bs-example-modal-lg" id="mapHotelModal" tabindex="-1" aria-labelledby="exampleModalgridLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header row">
				<div class="col-3">
					<h5 class="modal-title fw-bold" id="exampleModalgridLabel">Hotel Information</h5>
				</div>
				<div class="col-2">
					<p id="type" class="mt-2 border border-2 border-primary rounded-3" style="color:grey;padding: 5px;text-align: center">own</p>
				</div>
				<div class="col-4" id="hotel_code_compset_div">
				</div>
				<div class="col-3">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="float: right"></button>
				</div>
			</div>
			<div class="modal-body">
				<div id="liveAlertPlaceholder"></div>
				<h5 id="hotel_name">Baymont by Wyndham Greensboro/Coliseum</h5>
				<div id="star" dir="ltr"></div>
				<div class="row">
					<div class="col-3">Mapped Hotel Name</div>
					<div class="col-8">
						<input type="text" class="form-control" name="mapped_hotel" id="mapped_hotel">
						<div class="invalid-feedback" id="mapped_hotel_error" style="display: block"></div>
					</div>
				</div>
				<h4 class="text-black">Website</h4>
				<div id="map_room_div">
				<div class="row">
					<div class="col-3 selected_website" id="selected_website">Priceline.com</div>
					<div class="col-6" id="selected_hotel">Baymont by Wyndham Greensboro/Coliseum</div>
					<div class="col-3"><button type="button" id="map_room_btn" class="btn btn-soft-primary waves-effect waves-light">Map Room</button></div>
					<div id="mapped_rooms_div"></div>
				</div>
				</div>
				<div class="row gy-4 mt-1" id="add_hotel_div">
					<div class="col-xxl-3 col-md-3 col-lg-3">
						<select name="select_website" class="form-control select_website" id="select_website">
						</select>
						<div class="invalid-feedback" style="display: block" id="select_website_error"></div>
					</div>
					<div class="col-xxl-7 col-md-7 col-lg-7" id="select_hotel_div">
						<select name="select_hotel" class="form-control select_hotel" id="select_hotel">
						</select>
						<div class="invalid-feedback" style="display: block" id="select_hotel_error"></div>
					</div>
					<div class="col-xxl-2 col-md-2 col-lg-2"><button type="button" id="add_hotel_btn" class="btn btn-soft-primary waves-effect waves-light">Add</button></div>
				</div>
			</div>
			<div class="modal-footer">
				<h6 class="modal-title me-auto" id="rating_review" style="font-weight: bold; color: black">Rating: 8.6 Total Review: 8.6</h6>
				<button type="button" class="btn btn-info w-md waves-effect waves-light" id="save_hotel">Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-lg" id="mapRoomModal" tabindex="-1" aria-labelledby="exampleModalgridLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fw-bold" id="exampleModalgridLabel">Map Room</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="map_room_alert_box"></div>
				<div id="mapped_room_types"></div>
				<div class="row gy-4 mt-1" id="add_room_div">
					<div class="col-xxl-3 col-md-6">
						<select name="select_room_type" class="form-control select_room_type" id="select_room_type">
							<option value="" selected disabled>Select Room Type</option>
						</select>
						<div class="invalid-feedback" style="display: block" id="select_room_type_error"></div>
					</div>
					<div class="col-xxl-3 col-md-3">
						<select name="select_mapped_room_type" class="form-control select_mapped_room_type" id="select_mapped_room_type">
							<option value="" selected disabled>Select Mapped Room Type</option>
						</select>
						<div class="invalid-feedback" style="display: block" id="select_mapped_room_type_error"></div>
					</div>
					<div class="col-xxl-3 col-md-3"><button type="button" id="add_room_btn" class="btn btn-soft-secondary waves-effect waves-light" style="float: right">Add</button></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info w-md waves-effect waves-light" id="save_map_room">Save</button>
			</div>
		</div>
	</div>
</div>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>

<!-- rater-js plugin -->
<script src="<?php echo base_url().'assets/libs/rater-js/index.js'; ?>"></script>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
var table;
var starRatingStep;
var all_websites_list = <?php echo json_encode($GetAllWebsite); ?>;
var all_hotel_room_type;
var all_mapped_room_type;
var map_room_arr;

$(document).ready(function (){
	$('#state').select2({
		placeholder: "Select State",
		// allowClear: true,
		width: '100%'
	});

	$('#city').select2({
		placeholder: "Select City",
		width: '100%'
	});

	$('#miles').select2({
		placeholder: "Select Miles",
		width: '100%'
	});

	$('#website').select2({
		placeholder: "Select Website",
		width: '100%'
	});

	$('#hotel').select2({
		placeholder: "Select Hotel Name",
		width: '100%'
	});

	table = $("#comp_set").DataTable();
})

$('#state').change(function () {
	var state = $(this).val();
	// console.log(state_code);

	if (state != '') {
		$('#city').html("");
		$("#city").select2('destroy').val("").select2({
			placeholder: "Loading...",
			width: '100%',
			language: {
				noResults: function () {
					return "";
				}
			}
		});

		$.ajax({
			url: "<?php echo base_url().'GetAllCityByState'; ?>",
			method: "POST",
			data: { "state": state },
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$('#city').html("");
					$("#city").select2('destroy').val("").select2({
						placeholder: "Select City",
						width: '100%'
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
			width: '100%'
		});
	}

	$('#hotel').html("");
	$("#hotel").select2('destroy').val("").select2({
		placeholder: "Select Hotel Name",
		width: '100%'
	});

	table.destroy();
	$("#comp_set tbody").html("");
	table = $("#comp_set").DataTable();
});

$('#city').change(function () {
	GetHotelNames();
	table.destroy();
	$("#comp_set tbody").html("");
	table = $("#comp_set").DataTable();
});

$('#website').change(function () {
	GetHotelNames();
	table.destroy();
	$("#comp_set tbody").html("");
	table = $("#comp_set").DataTable();
});

function GetHotelNames(){
	var city_id = $("#city").val();
	var website_id = $("#website").val();
	var state = $("#state").val();

	if (city_id != '' && website_id != '' && state != '') {
		$.ajax({
			url: "<?php echo base_url().'GetHotelName'; ?>",
			method: "POST",
			data: { "city_id": city_id, "website_id": website_id, "state": state },
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#hotel").select2('destroy').val("").select2({
						placeholder: "Select Hotel Name",
						width: '100%'
					});
					$('#hotel').html(res.html);
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
		$('#hotel').html("");
		$("#hotel").select2('destroy').val("").select2({
			placeholder: "Select Hotel Name",
			width: '100%'
		});
	}
}

$('#hotel').change(function () {
	table_data();
});

$('#miles').change(function () {
	table_data();
});

function table_data(){
	var state_code = $("#state option:selected").attr('state-code');
	var hotel_name = $("#hotel option:selected").attr('hotel-name');
	var lat = $("#hotel option:selected").attr('lat');
	var long = $("#hotel option:selected").attr('long');
	var website_id = $("#website").val();
	var city_id = $("#city").val();
	var radius = $("#miles").val();

	if (state_code!="" && hotel_name!="" && lat!="" && long!="" && website_id!="" && city_id!="" && radius!="") {
		$.ajax({
			url: "<?php echo base_url() . 'Gethotelwithinradius'; ?>",
			method: "POST",
			data: {
				"state_code": state_code,
				"hotel_name": hotel_name,
				"lat": lat,
				"long": long,
				"website_id": website_id,
				"city_id": city_id,
				"radius": radius
			},
			beforeSend: function(){
				$("#comp_set_table_div").find('.loading-ct').show();
			},
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					table.destroy();
					$("#comp_set tbody").html(res.html);
					table = $("#comp_set").DataTable();
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
			},
			complete: function(){
				$("#comp_set_table_div").find('.loading-ct').hide();
			}
		});
	}
	else {
		table.destroy();
		$("#comp_set tbody").html("");
		table = $("#comp_set").DataTable();
	}
}

$(document).on('click', '#map_hotel_btn', function (){
	var type = $(this).attr('hotel-type');
	var hotel = $(this).attr('hotel-name');
	var star = $(this).attr('star');
	var website = $.trim($("#website option:selected").html());
	var rating = $(this).attr('rating');
	var total_reviews = $(this).attr('total-reviews');
	var website_id = $("#website").val();
	var hotel_id = $(this).attr('hotel-id');
	var address = $(this).attr('address');

	$("#mapped_hotel_error").html("");
	$("#hotel_code_compset-error").html("");
	$("#select_website_error").html("");
	$("#select_hotel_error").html("");
	$("#liveAlertPlaceholder").html("");

	if (starRatingStep!=undefined) {
		starRatingStep.clear();
		$("#star").html("");
		$("#star").removeAttr("class");
		$("#star").removeAttr("title");
		$("#star").removeAttr("style");
		$("#star").removeAttr("data-rating");
	}

	$("#mapHotelModal").find('#type').html(type);
	$("#mapHotelModal").find('#hotel_name').html(hotel);
	starRatingStep = raterJs({
		starSize: 22,
		rating: parseFloat(star),
		readOnly: true,
		element: document.querySelector("#star"),
		/*rateCallback: function rateCallback(rating, done) {
			this.setRating(rating);
			done();
		}*/
	});

	$("#mapHotelModal").find('#selected_website').html(website);
	$("#mapHotelModal").find('#selected_website').attr("website-id",website_id);
	$("#mapHotelModal").find('#selected_hotel').attr("hotel-id",hotel_id);
	$("#mapHotelModal").find('#selected_hotel').html(hotel);
	$("#mapHotelModal").find('#rating_review').html(`Rating: ${rating} Total Review: ${total_reviews}`);

	$("#select_website").html("");
	$("#select_hotel").html("");

	$("#select_website").append(`<option value=""></option>`);
	$.each(all_websites_list, function( key, value ) {
		if (value.Name!=website) {
			$("#select_website").append(`<option value="${value.Id}">${value.Name}</option>`);
		}
	})
	$("#select_hotel").append(`<option value=""></option>`);

	$("#select_website").select2({
		dropdownParent: $("#mapHotelModal"),
		placeholder: "Select Website",
		width: '100%'
	})
	$("#select_hotel").select2({
		dropdownParent: $("#mapHotelModal"),
		placeholder: "Select Hotel Name",
		width: '100%'
	})

	$("#map_room_div").find(".row:gt(0)").remove();
	$("#add_hotel_div").show();

	$("#mapped_hotel").val("");
	$("#mapped_rooms_div").html("");
	if ($("#edit_map_room_btn").length > 0){
		$('#edit_map_room_btn').html("Map Room");
		$('#edit_map_room_btn').attr("id", "map_room_btn");
	}

	if ($("#users_dropdown").val() == ""){
		$("#error_toast").attr('data-toast-text','Please select customer.');
		$("#error_toast").trigger('click');
	}
	else {
		$("#mapHotelModal #save_hotel").attr("address", address);
		var user_id = $('#users_dropdown').val();
		if (user_id == "" || user_id == undefined){
			user_id = null;
		}

		if (type=="Competitors") {
			var html = `<select name="hotel_code_compset" id="hotel_code_compset" class="form-control">
							<option value=""></option>
						</select>
						<div id="hotel_code_compset-error" class="invalid-feedback m-0" for="hotel_code_compset" style="display: block"></div>`;
			$("#hotel_code_compset_div").html(html);
			$("#hotel_code_compset").select2({
				dropdownParent: $("#mapHotelModal"),
				placeholder: "Select Property",
				width: '100%'
			});
			$.ajax({
				url: "<?= base_url('getProperty/') ?>" + user_id,
				method: "POST",
				success: function (res) {
					var res = JSON.parse(res);
					if (res.status == 1) {
						$("#hotel_code_compset").html("");
						$("#hotel_code_compset").select2('destroy').val("").select2({
							dropdownParent: $("#mapHotelModal"),
							placeholder: "Select Property",
							width: '100%'
						});
						$("#hotel_code_compset").append(`<option value=""></option>`);
						$.each(res.own_hotels, function (key, value) {
							$("#hotel_code_compset").append(`<option value="${value.HotelCode}">${value.MappedHotelName}</option>`);
						})
						$("#mapHotelModal").modal("show");
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
			var html = `<input type="text" name="hotel_code_compset" id="hotel_code_compset" class="form-control" placeholder="Hotel Code">
						<div id="hotel_code_compset-error" class="invalid-feedback m-0" for="hotel_code_compset" style="display: block"></div>`;
			$("#hotel_code_compset_div").html(html);
			$("#mapHotelModal").modal("show");
		}
	}
})

$(".select_website").change(function() {
	var city_id = $("#city").val();
	var website_id = $(this).val();
	var state = $("#state").val();
	var cnt = $(this).attr('cnt');

	if (city_id != '' && website_id != '' && state != '') {
		$.ajax({
			url: "<?php echo base_url().'GetHotelName'; ?>",
			method: "POST",
			data: { "city_id": city_id, "website_id": website_id, "state": state },
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#select_hotel").select2('destroy').val("").select2({
						dropdownParent: $("#mapHotelModal"),
						placeholder: "Select Hotel Name",
						width: '100%'
					});
					$("#select_hotel").html(res.html);
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
		$("#select_hotel").html("");
		$("#select_hotel").select2('destroy').val("").select2({
			dropdownParent: $("#mapHotelModal"),
			placeholder: "Select Hotel Name",
			width: '100%'
		});
	}
})

$(document).on('click', '#add_hotel_btn', function() {
	var select_website = $("#select_website option:selected").html();
	var select_hotel = $("#select_hotel option:selected").html();
	var website_id = $("#select_website").val();
	var hotel_id = $("#select_hotel").val();

	var userId= $("#users_dropdown").val();	
	var websiteId = $("#select_website").val();
	var hotelId = $("#select_hotel").val();
	var HotelCode = $("#mapHotelModal #hotel_code_compset").val();
	var type;
	if ($("#type").text() == "Own"){
		type = false;
	}
	else{
		type = true;
	}

	var html = `<div class="row mt-1">
					<div class="col-3 selected_website" id="selected_website" website-id="${website_id}">${select_website}</div>
					<div class="col-6" id="selected_hotel" hotel-id="${hotel_id}">${select_hotel}</div>
					<div class="col-3"><button type="button" id="map_room_btn" class="btn btn-soft-primary waves-effect waves-light">Map Room</button> <a id="remove_row"><img src="<?php echo base_url('assets/images/minus-icon.png') ?>"></a></div>
					<div id="mapped_rooms_div"></div>
				</div>`;

	$("#select_website_error").html("");
	$("#select_hotel_error").html("");

	if ($("#select_website").val() == ""){
		$("#select_website_error").html("Please select website name.");
	}
	else if ($("#select_hotel").val() == ""){
		$("#select_hotel_error").html("Please select hotel name.");
	}
	else{
		$.ajax({
			url: "<?php echo base_url().'CheckHotelValidation'; ?>",
			method: "POST",
			data: { "user_id": userId, "website_id": websiteId, "hotel_id": hotelId, "type": type, "HotelCode": HotelCode},
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 200) {
					$("#map_room_div").append(html);
					var select_website_arr = [];
					$(".selected_website").each(function () {
						select_website_arr.push($(this).html());
					})
					$("#select_website").html("");
					$("#select_website").select2('destroy').val("").select2({
						dropdownParent: $("#mapHotelModal"),
						placeholder: "Select Website",
						width: '100%'
					});
					$("#select_website").append(`<option value=""></option>`);
					$.each(all_websites_list, function (key, value) {
						if (select_website_arr.includes(value.Name)) {
						} else {
							$("#select_website").append(`<option value="${value.Id}">${value.Name}</option>`);
						}
					})
					$("#select_hotel").html("");
					$("#select_hotel").select2('destroy').val("").select2({
						dropdownParent: $("#mapHotelModal"),
						placeholder: "Select Hotel Name",
						width: '100%'
					});

					if ($("#select_website option").length <= 1) {
						$("#add_hotel_div").hide();
					} else {
						$("#add_hotel_div").show();
					}
				}
				else if(res.status == 'failed'){
					alert_message(res.error, $("#liveAlertPlaceholder"));
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
})

$(document).on('click', "#remove_row", function (){
	$(this).parents('.row').remove();
	var select_website = $("#select_website option:selected").html();

	var select_website_arr = [];
	$(".selected_website").each(function (){
		select_website_arr.push($(this).html());
	})
	$("#select_website").html("");
	$("#select_website").select2('destroy').val("").select2({
		dropdownParent: $("#mapHotelModal"),
		placeholder: "Select Website",
		width: '100%'
	});
	$("#select_website").append(`<option value=""></option>`);
	$.each(all_websites_list, function( key, value ) {
		if (select_website_arr.includes(value.Name)) {
		}
		else{
			var selected = "";
			if (select_website == value.Name){
				selected = "selected";
			}
			$("#select_website").append(`<option value="${value.Id}" ${selected}>${value.Name}</option>`);
		}
	})

	if ($("#select_website option").length <= 1){
		$("#add_hotel_div").hide();
	}
	else{
		$("#add_hotel_div").show();
	}
})

$(document).on('click', "#map_room_btn", function (){
	var websiteId = $(this).parents('.row').find('#selected_website').attr('website-id');
	var hotelId = $(this).parents('.row').find('#selected_hotel').attr('hotel-id')

	$("#select_room_type_error").html("");
	$("#select_mapped_room_type_error").html("");
	$("#map_room_alert_box").html("");

	$("#select_room_type").html("");
	$("#select_room_type").val("");
	$("#select_mapped_room_type").html("");
	$("#select_mapped_room_type").val("");

	$.ajax({
		url: "<?php echo base_url().'GetAllHotelsRoomTypeByParam'; ?>",
		method: "POST",
		data: { "websiteId": websiteId, "hotelId": hotelId },
		success: function (res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				all_hotel_room_type = res.GetAllHotelsRoomTypeByParam;
				all_mapped_room_type = res.GetMappedRoomType;

				$("#select_room_type").append(`<option value="" selected disabled>Select Room Type</option>`);
				$("#select_mapped_room_type").append(`<option value="" selected disabled>Select Mapped Room Type</option>`);
				$.each(all_hotel_room_type, function (key, value) {
					$("#select_room_type").append(`<option value="${value.Id}">${value.RoomType}</option>`);
				})
				$.each(all_mapped_room_type, function (key, value) {
					$("#select_mapped_room_type").append(`<option value="${value.Id}">${value.Name}</option>`);
				})

				$("#mapRoomModal").find("#mapped_room_types").html("");
				$("#mapRoomModal").find("#add_room_div").show();
				$("#mapRoomModal").find("#save_map_room").attr("website-id", websiteId);
				$("#mapRoomModal").modal("show");
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
})

$(document).on("click", "#add_room_btn", function (){
	var room_type = $("#select_room_type option:selected").html();
	var mapped_room_type = $("#select_mapped_room_type option:selected").html();
	var room_type_id = $("#select_room_type").val();
	var mapped_room_type_id = $("#select_mapped_room_type").val();

	var html = `<div class="row mt-1">
					<div class="col-xxl-3 col-md-7 selected_room_type" id="selected_room_type" room-type-id="${room_type_id}">${room_type}</div>
					<div class="col-xxl-3 col-md-3 selected_mapped_room_type" id="selected_mapped_room_type" mapped-room-type-id="${mapped_room_type_id}">${mapped_room_type}</div>
					<div class="col-xxl-3 col-md-2"><a id="remove_mapped_row"><img src="<?php echo base_url('assets/images/minus-icon.png') ?>"></a></div>
				</div>`;

	$("#select_room_type_error").html("");
	$("#select_mapped_room_type_error").html("");
	
	if ($("#select_room_type").val() == null || $("#select_room_type").val() == ""){
		$("#select_room_type_error").html("Please select room type.");
	}
	else if ($("#select_mapped_room_type").val() == null || $("#select_mapped_room_type").val() == ""){
		$("#select_mapped_room_type_error").html("Please select mapped room type.");
	}
	else{
		$("#mapped_room_types").append(html);
		var select_room_type_arr = [];
		$(".selected_room_type").each(function (){
			select_room_type_arr.push($(this).html());
		})
		$("#select_room_type").html("");
		$("#select_room_type").val("");
		$("#select_room_type").append(`<option value="" selected disabled>Select Room Type</option>`);
		$.each(all_hotel_room_type, function( key, value ) {
			if (select_room_type_arr.includes(value.RoomType)) {
			}
			else{
				$("#select_room_type").append(`<option value="${value.Id}">${value.RoomType}</option>`);
			}
		})

		var select_mapped_room_type_arr = [];
		$(".selected_mapped_room_type").each(function (){
			select_mapped_room_type_arr.push($(this).html());
		})
		$("#select_mapped_room_type").html("");
		$("#select_mapped_room_type").val("");
		$("#select_mapped_room_type").append(`<option value="" selected disabled>Select Mapped Room Type</option>`);
		$.each(all_mapped_room_type, function( key, value ) {
			if (select_mapped_room_type_arr.includes(value.Name)) {
			}
			else{
				$("#select_mapped_room_type").append(`<option value="${value.Id}">${value.Name}</option>`);
			}
		})

		if ($("#select_mapped_room_type option").length <= 1){
			$("#add_room_div").hide();
		}
		else{
			$("#add_room_div").show();
		}
	}
})

$(document).on('click', "#remove_mapped_row", function (){
	$(this).parents('.row').remove();
	var select_room_type = $("#select_room_type option:selected").html();
	var select_mapped_room_type = $("#select_mapped_room_type option:selected").html();

	var select_room_type_arr = [];
	$(".selected_room_type").each(function (){
		select_room_type_arr.push($(this).html());
	})
	$("#select_room_type").html("");
	$("#select_room_type").val("");
	$("#select_room_type").append(`<option value="" selected disabled>Select Room Type</option>`);
	$.each(all_hotel_room_type, function( key, value ) {
		if (select_room_type_arr.includes(value.RoomType)) {
		}
		else{
			var selected = "";
			if (select_room_type == value.RoomType){
				selected = "selected";
			}
			$("#select_room_type").append(`<option value="${value.Id}" ${selected}>${value.RoomType}</option>`);
		}
	})

	var select_mapped_room_type_arr = [];
	$(".selected_mapped_room_type").each(function (){
		select_mapped_room_type_arr.push($(this).html());
	})
	$("#select_mapped_room_type").html("");
	$("#select_mapped_room_type").val("");
	$("#select_mapped_room_type").append(`<option value="" selected disabled>Select Mapped Room Type</option>`);
	$.each(all_mapped_room_type, function( key, value ) {
		if (select_mapped_room_type_arr.includes(value.Name)) {
		}
		else{
			var selected = "";
			if (select_mapped_room_type == value.Name){
				selected = "selected";
			}
			$("#select_mapped_room_type").append(`<option value="${value.Id}" ${selected}>${value.Name}</option>`);
		}
	})

	if ($("#select_mapped_room_type option").length <= 1){
		$("#add_room_div").hide();
	}
	else{
		$("#add_room_div").show();
	}
})

$(document).on("click", "#save_map_room", function (){
	$("#select_room_type_error").html("");
	$("#select_mapped_room_type_error").html("");
	$("#map_room_alert_box").html("");

	if ($("#mapRoomModal #mapped_room_types").children('div').length == 0){
		alert_message("Please select atleast one map room details.", $("#map_room_alert_box"));
	}
	else {
		map_room_arr = [];
		$("#mapped_room_types .row").each(function () {
			var room_type = $(this).find('#selected_room_type').attr('room-type-id');
			var mapped_room_type = $(this).find('#selected_mapped_room_type').attr('mapped-room-type-id');
			var room_type_name = $(this).find('#selected_room_type').html();
			var mapped_room_type_name = $(this).find('#selected_mapped_room_type').html();
			map_room_arr.push({
				room_type: room_type,
				mapped_room_type: mapped_room_type,
				room_type_name: room_type_name,
				mapped_room_type_name: mapped_room_type_name,
			});
		})

		var website_id = $(this).attr("website-id");

		$.when(
			$("#mapHotelModal #map_room_div").find(".selected_website").each(function () {
				var exist_website_id = $(this).attr("website-id");
				var thi = $(this);
				if (website_id == exist_website_id) {
					var html = '';
					var i = 1;
					$.each(map_room_arr, function (key, value) {
						html += `<input type="hidden" name="mapped_room_${i}" class="mapped_room" room-type="${value.room_type}" mapped-room-type="${value.mapped_room_type}" room-type-name="${value.room_type_name}" mapped-room-type-name="${value.mapped_room_type_name}">`;
						i++;
					})
					$(thi).siblings('#mapped_rooms_div').html(html);
					$(thi).parent().find('#map_room_btn').html("Edit Map Room");
					$(thi).parent().find('#map_room_btn').attr("id", "edit_map_room_btn");
					return true;
				}
			})
		).then(function () {
			$("#mapRoomModal").modal("hide");
		});
	}
})

$(document).on("click", "#save_hotel", function (){
	$(this).attr('disabled','disabled');
	var userId= $("#users_dropdown").val();
	var websiteId = $("#selected_website").attr('website-id');
	var hotelId = $("#selected_hotel").attr('hotel-id');
	var type;
	if ($("#type").text() == "Own"){
		type = false;
	}
	else{
		type = true;
	}
	var Address = $(this).attr("address");
	var City = $("#city").val();
	var MappedHotelName = $("#mapHotelModal #mapped_hotel").val();
	var HotelCode = $("#mapHotelModal #hotel_code_compset").val();
	var State = $("#state option:selected").attr('state-code');
	var thi = $(this);

	$("#mapped_hotel_error").html("");
	$("#hotel_code_compset-error").html("");
	$("#liveAlertPlaceholder").html("");
	$("#select_website_error").html("");
	$("#select_hotel_error").html("");

	if ($("#mapHotelModal #mapped_hotel").val() == ""){
		$("#mapped_hotel_error").html("Please add mapped hotel name.");
		$(thi).removeAttr("disabled");
	}
	else if ($("#mapHotelModal #hotel_code_compset").val() == ""){
		$("#hotel_code_compset-error").html("Please add hotel code.");
		$(thi).removeAttr("disabled");
	}
	else if (!noSpaceAllow(HotelCode)){
		$("#hotel_code_compset-error").html("only one word can enter, no space allowed.");
		$(thi).removeAttr("disabled");
	}
	else if ($("#mapHotelModal .selected_website").length != $("#mapHotelModal").find("[id=edit_map_room_btn]").length){
		alert_message("Please add map room details for selected website.", $("#liveAlertPlaceholder"));
		$(thi).removeAttr("disabled");
	}
	else{
		var hotelRoomMapDetails = [];
		$("#map_room_div .row").each(function (){
			var thi = $(this);
			var roomType = $(this).find("input[name=mapped_room_1]").attr('room-type');
			var mappedRoomType = $(this).find("input[name=mapped_room_1]").attr('mapped-room-type');
			var roomTypeTwo = $(this).find("input[name=mapped_room_2]").attr('room-type');
			var mappedRoomTypeTwo = $(this).find("input[name=mapped_room_2]").attr('mapped-room-type');
			var roomTypeThree = $(this).find("input[name=mapped_room_3]").attr('room-type');
			var mappedRoomTypeThree = $(this).find("input[name=mapped_room_3]").attr('mapped-room-type');
			if (roomTypeTwo == undefined){
				roomTypeTwo = 0;
			}
			if (roomTypeThree == undefined){
				roomTypeThree = 0;
			}
			if (mappedRoomTypeTwo == undefined){
				mappedRoomTypeTwo = 0;
			}
			if (mappedRoomTypeThree == undefined){
				mappedRoomTypeThree = 0;
			}

			var isSelectedHotel = false;
			if ($(thi).find('#selected_website').attr('website-id') == $("#website").val()){
				isSelectedHotel = true;
			}

			hotelRoomMapDetails.push({
				websiteId: parseInt($(thi).find('#selected_website').attr('website-id')),
				websiteName: $(thi).find('#selected_website').html(),
				hotelId: parseInt($(thi).find('#selected_hotel').attr('hotel-id')),
				hotelName: $(thi).find('#selected_hotel').html(),
				roomType: parseInt(roomType),
				mappedRoomType: parseInt(mappedRoomType),
				roomTypeTwo: parseInt(roomTypeTwo),
				mappedRoomTypeTwo: parseInt(mappedRoomTypeTwo),
				roomTypeThree: parseInt(roomTypeThree),
				mappedRoomTypeThree: parseInt(mappedRoomTypeThree),
				isSelectedHotel: isSelectedHotel,
			});
		})

		$.ajax({
			url: "<?php echo base_url().'save_mapped_hotel'; ?>",
			method: "POST",
			data: { "user_id": userId, "website_id": websiteId, "hotel_id": hotelId, "type": type, "Address": Address, "City": City, "MappedHotelName": MappedHotelName, "State": State, "hotelRoomMapDetails": hotelRoomMapDetails, "HotelCode": HotelCode},
			success: function (res) {
				$(thi).removeAttr("disabled");
				var res = JSON.parse(res);
				// console.log(res);
				if (res.status == "failed"){
					alert_message(res.error, $("#liveAlertPlaceholder"));
				}
				else if(res.status == 200){
					$.each( res.success, function( key, value ) {
						$("#success_toast").attr('data-toast-text', value);
						$("#success_toast").trigger('click');
					});
					$("#mapHotelModal").modal('hide');
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
				$(thi).removeAttr("disabled");
			}
		});
	}
})

function noSpaceAllow(value){
	if ((value.trim() == value) && (value.indexOf(" ") < 0)){
		return true;
	}
	else {
		return false;
	}
}

function alert_message(message, div) {
	var wrapper = document.createElement('div');
	wrapper.innerHTML = '<div class="alert alert-danger alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
	div.html(wrapper);
}

$(document).on('click', '#edit_map_room_btn', function (){
	$("#select_room_type_error").html("");
	$("#select_mapped_room_type_error").html("");
	$("#map_room_alert_box").html("");

	var mapped_rooms_div = $(this).parent().siblings('#mapped_rooms_div');
	var html = '';
	mapped_rooms_div.children('.mapped_room').each(function (){
		var room_type_id = $(this).attr('room-type');
		var room_type = $(this).attr('room-type-name');
		var mapped_room_type_id = $(this).attr('mapped-room-type');
		var mapped_room_type = $(this).attr('mapped-room-type-name');

		html += `<div class="row mt-1">
					<div class="col-xxl-3 col-md-7 selected_room_type" id="selected_room_type" room-type-id="${room_type_id}">${room_type}</div>
					<div class="col-xxl-3 col-md-3 selected_mapped_room_type" id="selected_mapped_room_type" mapped-room-type-id="${mapped_room_type_id}">${mapped_room_type}</div>
					<div class="col-xxl-3 col-md-2"><a id="remove_mapped_row"><img src="<?php echo base_url('assets/images/minus-icon.png') ?>"></a></div>
				</div>`;
	})
	$("#mapped_room_types").html(html);
	if ($("#mapped_room_types .row").length == 3){
		$("#add_room_div").hide();
	}
	else{
		$("#add_room_div").show();
	}

	var select_room_type_arr = [];
	$(".selected_room_type").each(function (){
		select_room_type_arr.push($(this).html());
	})
	$("#select_room_type").html("");
	$("#select_room_type").val("");
	$("#select_room_type").append(`<option value="" selected disabled>Select Room Type</option>`);
	$.each(all_hotel_room_type, function( key, value ) {
		if (select_room_type_arr.includes(value.RoomType)) {
		}
		else{
			$("#select_room_type").append(`<option value="${value.Id}">${value.RoomType}</option>`);
		}
	})

	var select_mapped_room_type_arr = [];
	$(".selected_mapped_room_type").each(function (){
		select_mapped_room_type_arr.push($(this).html());
	})
	$("#select_mapped_room_type").html("");
	$("#select_mapped_room_type").val("");
	$("#select_mapped_room_type").append(`<option value="" selected disabled>Select Mapped Room Type</option>`);
	$.each(all_mapped_room_type, function( key, value ) {
		if (select_mapped_room_type_arr.includes(value.Name)) {
		}
		else{
			$("#select_mapped_room_type").append(`<option value="${value.Id}">${value.Name}</option>`);
		}
	})

	var websiteId = $(this).parents('.row').find('#selected_website').attr('website-id');
	$("#mapRoomModal").find("#save_map_room").attr("website-id", websiteId);
	$("#mapRoomModal").modal("show");
})
</script>

</body>
</html>
