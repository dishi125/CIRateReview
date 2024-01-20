<?php include 'layouts/head-main.php'; ?>

	<head>

		<title> Edit <?= $type ?> </title>
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
							<h4 class="mb-sm-0">Edit <?= $type ?></h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
									<li class="breadcrumb-item"><a href="javascript:void(0)">List of <?= $type ?></a></li>
									<li class="breadcrumb-item active">Edit <?= $type ?></li>
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
									<h5 class="card-title mb-0 flex-grow-1">Edit <?= $type ?></h5>
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="edit_hotel">
									<input type="hidden" name="id" value="<?= $GetHotelById[0]['HotelId'] ?>">
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Website</label>
												<select name="website" id="website" class="form-control">
													<option value=""></option>
													<?php foreach ($GetAllWebsite as $website){ ?>
														<option value="<?= $website['Id'] ?>" <?php if ($GetHotelById[0]['WebSite'] == $website['Id']) { echo 'selected'; } ?>><?= $website['Name'] ?></option>
													<?php } ?>
												</select>
												<label id="website-error" class="error" for="website"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">State</label>
												<select name="state" id="state" class="form-control">
													<option value=""></option>
													<?php foreach ($GetAllState as $state){ ?>
														<option value="<?= $state['StateName'] ?>" <?php if ($GetHotelById[0]['State'] == $state['StateName']) { echo 'selected'; } ?>><?= $state['state'] ?></option>
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
													<?php foreach ($GetAllCityByState as $city){ ?>
														<option value="<?= $city['Id'] ?>" <?php if ($GetHotelById[0]['City'] == $city['Id']) { echo 'selected'; } ?>><?= $city['Name'] ?></option>
													<?php } ?>
												</select>
												<label id="city-error" class="error" for="city"></label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Hotel Name</label>
												<select name="hotel_name" id="hotel_name" class="form-control">
													<option value=""></option>
													<?php foreach ($GetHotelName as $hotel){ ?>
														<option value="<?= $hotel['HotelId'] ?>" <?php if ($GetHotelById[0]['SystemHotel'] == $hotel['HotelId']) { echo 'selected'; } ?>><?= $hotel['HotelName'] ?></option>
													<?php } ?>
												</select>
												<label id="hotel_name-error" class="error" for="hotel_name"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Mapped Hotel Name</label>
												<input type="text" name="mapped_hotel_name" id="mapped_hotel_name" class="form-control" value="<?= $GetHotelById[0]['MappedHotelName'] ?>">
												<label id="mapped_hotel_name-error" class="error" for="mapped_hotel_name"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Address</label>
												<input type="text" name="address" id="address" class="form-control" value="<?= $GetHotelById[0]['Address'] ?>">
												<label id="address-error" class="error" for="address"></label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<?php if ($type=="Competitor Hotel") { ?>
											<div>
												<label for="labelInput" class="form-label">Select Property</label>
												<select name="hotel_code" id="hotel_code" class="form-control own_hotel_code_dropdown">
													<option value=""></option>
													<?php foreach ($own_hotels as $own_hotel){ ?>
														<option value="<?= $own_hotel['HotelCode'] ?>" <?php if ($own_hotel['HotelCode']==$GetHotelById[0]['HotelCode']){ ?> selected <?php } ?>><?= $own_hotel['MappedHotelName'] ?></option>
													<?php } ?>
												</select>
												<label id="hotel_code-error" class="error" for="hotel_code"></label>
											</div>
											<?php } else { ?>
												<div>
													<label for="labelInput" class="form-label">Hotel Code</label>
													<input type="text" name="hotel_code" id="hotel_code" class="form-control" value="<?= $GetHotelById[0]['HotelCode'] ?>">
													<label id="hotel_code-error" class="error" for="hotel_code"></label>
												</div>
											<?php } ?>
										</div>
									</div>

									<div id="mapped_rooms_div">
										<?php for ($i=1; $i<count($GetHotelById); $i++) {?>
										<div class="row">
											<div class="col-xxl-3 col-md-7">
												<div>
													<label for="labelInput" class="form-label">Room Type</label>
													<input type="text" name="selected_room_type" id="selected_room_type" class="form-control selected_room_type" room-type-id="<?= $GetHotelById[$i]['RoomType'] ?>" value="<?= $GetHotelById[$i]['RoomTypeName'] ?>" readonly>
												</div>
											</div>
											<div class="col-xxl-3 col-md-2">
												<div>
													<label for="labelInput" class="form-label">Mapped Room Type</label>
													<input type="text" name="selected_mapped_room_type" id="selected_mapped_room_type" class="form-control selected_mapped_room_type" mapped-room-type-id="<?= $GetHotelById[$i]['MappedRoomType'] ?>" value="<?= $GetHotelById[$i]['MappedRoomTypeName'] ?>" readonly>
												</div>
											</div>
											<div class="col-xxl-3 col-md-3">
												<label for="labelInput" class="form-label"></label>
												<button type="button" id="remove_mapped_row" class="btn btn-soft-danger waves-effect waves-light form-control">- Remove Room Type</button>
											</div>
										</div>
										<?php } ?>
									</div>

									<div class="row" id="add_room_hotel_div" <?php if (count($GetHotelById)>=4) {?> style="display: none" <?php } ?>>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">RoomType</label>
												<select name="room_type" id="room_type" class="form-control room_type">
													<option value=""></option>
													<?php foreach ($GetAllHotelsRoomTypeByParam as $RoomType){ ?>
														<?php if(!in_array($RoomType['Id'], $room_type_ids)) {?>
														<option value="<?= $RoomType['Id'] ?>"><?= $RoomType['RoomType'] ?></option>
														<?php } ?>
													<?php } ?>
												</select>
												<div id="room_type_error" class="error" style="display: block"></div>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Mapped RoomType</label>
												<select name="mapped_room_type" id="mapped_room_type" class="form-control mapped_room_type">
													<option value=""></option>
													<?php foreach ($GetMappedRoomType as $mappedRoomType){ ?>
														<?php if(!in_array($mappedRoomType['Id'], $mapped_room_type_ids)) {?>
														<option value="<?= $mappedRoomType['Id'] ?>"><?= $mappedRoomType['Name'] ?></option>
														<?php } ?>
													<?php } ?>
												</select>
												<div class="error" id="mapped_room_type_error" style="display: block"></div>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<label for="labelInput" class="form-label"></label>
											<button type="button" id="add_room_type" class="btn btn-soft-secondary waves-effect waves-light form-control"><i class="ri-add-line align-bottom me-1"></i> Add New Room Type</button>
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

<script type="text/javascript">
var all_hotel_room_types = <?php echo json_encode($GetAllHotelsRoomTypeByParam) ?>;
var all_mapped_room_types = <?php echo json_encode($GetMappedRoomType) ?>;

$(document).ready(function (){
	$("#website").select2({
		placeholder: "Select Website",
		width: '100%'
	});

	$("#state").select2({
		placeholder: "Select State",
		width: '100%'
	});

	$("#city").select2({
		placeholder: "Select City",
		width: '100%'
	});

	$("#hotel_name").select2({
		placeholder: "Select Hotel Name",
		width: '100%'
	});

	$(".own_hotel_code_dropdown").select2({
		placeholder: "Select Property",
		width: '100%'
	});

	$("#room_type").select2({
		placeholder: "Select Room Type",
		width: '100%'
	});

	$("#mapped_room_type").select2({
		placeholder: "Select Mapped Room Type",
		width: '100%'
	});
})

$('#state').change(function () {
	var state = $(this).val();

	if (state != '') {
		$.ajax({
			url: "<?php echo base_url().'GetAllCityByState'; ?>",
			method: "POST",
			data: { "state": state },
			success: function (res) {
				if (res.status == 1) {
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

	$('#hotel_name').html("");
	$("#hotel_name").select2('destroy').val("").select2({
		placeholder: "Select Hotel Name",
		width: '100%'
	});

	$("#address").val("");
	$("#room_type").html("");
	$("#room_type").select2('destroy').val("").select2({
		placeholder: "Select Room Type",
		width: '100%'
	});
	$("#mapped_rooms_div").html("");
	$("#add_room_hotel_div").show();
	$("#mapped_room_type").html("");
	$("#mapped_room_type").select2('destroy').val("").select2({
		placeholder: "Select Mapped Room Type",
		width: '100%'
	});
	$("#mapped_room_type").append(`<option value=""></option>`);
	$.each(all_mapped_room_types, function( key, value ) {
		$("#mapped_room_type").append(`<option value="${value.Id}">${value.Name}</option>`);
	})
});

$('#city').change(function () {
	GetHotelNames();
});

$('#website').change(function () {
	GetHotelNames();
});

$('#hotel_name').change(function () {
	var hotel_id = $(this).val();
	var website_id = $("#website").val();
	var state_name = $("#state").val();
	var city_id = $("#city").val();
	$("#mapped_rooms_div").html("");
	$("#add_room_hotel_div").show();
	$("#mapped_room_type").html("");
	$("#mapped_room_type").select2('destroy').val("").select2({
		placeholder: "Select Mapped Room Type",
		width: '100%'
	});
	$("#mapped_room_type").append(`<option value=""></option>`);
	$.each(all_mapped_room_types, function( key, value ) {
		$("#mapped_room_type").append(`<option value="${value.Id}">${value.Name}</option>`);
	})

	if (hotel_id != "" && website_id != "" && state_name != "" && city_id != "") {
		$.ajax({
			url: "<?php echo base_url().'getAddress_RoomTypes'; ?>",
			method: "POST",
			data: { "hotel_id": hotel_id, "website_id": website_id, "state_name": state_name, "city_id": city_id },
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					all_hotel_room_types = res.GetAllHotelsRoomTypeByParam;
					$("#address").val(res.address);
					$("#room_type").select2('destroy').val("").select2({
						placeholder: "Select Room Type",
						width: '100%'
					});
					$('#room_type').html(res.roomtype_html);
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
		$("#address").val("");
		$("#room_type").html("");
		$("#room_type").select2('destroy').val("").select2({
			placeholder: "Select Room Type",
			width: '100%'
		});
	}
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
					$("#hotel_name").select2('destroy').val("").select2({
						placeholder: "Select Hotel Name",
						width: '100%'
					});
					$('#hotel_name').html(res.html);
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
		$('#hotel_name').html("");
		$("#hotel_name").select2('destroy').val("").select2({
			placeholder: "Select Hotel Name",
			width: '100%'
		});
	}

	$("#address").val("");
	$("#room_type").html("");
	$("#room_type").select2('destroy').val("").select2({
		placeholder: "Select Room Type",
		width: '100%'
	});
	$("#mapped_rooms_div").html("");
	$("#add_room_hotel_div").show();
	$("#mapped_room_type").html("");
	$("#mapped_room_type").select2('destroy').val("").select2({
		placeholder: "Select Mapped Room Type",
		width: '100%'
	});
	$("#mapped_room_type").append(`<option value=""></option>`);
	$.each(all_mapped_room_types, function( key, value ) {
		$("#mapped_room_type").append(`<option value="${value.Id}">${value.Name}</option>`);
	})
}

$(document).on("click", "#add_room_type", function (){
	var room_type = $("#room_type option:selected").html();
	var mapped_room_type = $("#mapped_room_type option:selected").html();
	var room_type_id = $("#room_type").val();
	var mapped_room_type_id = $("#mapped_room_type").val();

	var html = `<div class="row">
				<div class="col-xxl-3 col-md-7">
					<div>
						<label for="labelInput" class="form-label">Room Type</label>
						<input type="text" name="selected_room_type" id="selected_room_type" class="form-control selected_room_type" room-type-id="${room_type_id}" value="${room_type}" readonly>
					</div>
				</div>
				<div class="col-xxl-3 col-md-2">
					<div>
						<label for="labelInput" class="form-label">Mapped Room Type</label>
						<input type="text" name="selected_mapped_room_type" id="selected_mapped_room_type" class="form-control selected_mapped_room_type" mapped-room-type-id="${mapped_room_type_id}" value="${mapped_room_type}" readonly>
					</div>
				</div>
				<div class="col-xxl-3 col-md-3">
					<label for="labelInput" class="form-label"></label>
					<button type="button" id="remove_mapped_row" class="btn btn-soft-danger waves-effect waves-light form-control">- Remove Room Type</button>
				</div>
				</div>`;

	$("#room_type_error").html("");
	$("#mapped_room_type_error").html("");

	if ($("#room_type").val() == "" || $("#room_type").val() == null){
		$("#room_type_error").html("Please select room type.");
	}
	else if ($("#mapped_room_type").val() == "" || $("#mapped_room_type").val() == null){
		$("#mapped_room_type_error").html("Please select mapped room type.");
	}
	else {
		$("#mapped_rooms_div").append(html);

		var select_room_type_arr = [];
		$(".selected_room_type").each(function (){
			select_room_type_arr.push($(this).val());
		})
		$("#room_type").html("");
		$("#room_type").select2('destroy').val("").select2({
			placeholder: "Select Room Type",
			width: '100%'
		});
		$("#room_type").append(`<option value=""></option>`);
		$.each(all_hotel_room_types, function( key, value ) {
			if (select_room_type_arr.includes(value.RoomType)) {
			}
			else{
				$("#room_type").append(`<option value="${value.Id}">${value.RoomType}</option>`);
			}
		})

		var select_mapped_room_type_arr = [];
		$(".selected_mapped_room_type").each(function (){
			select_mapped_room_type_arr.push($(this).val());
		})
		$("#mapped_room_type").html("");
		$("#mapped_room_type").select2('destroy').val("").select2({
			placeholder: "Select Mapped Room Type",
			width: '100%'
		});
		$("#mapped_room_type").append(`<option value=""></option>`);
		$.each(all_mapped_room_types, function( key, value ) {
			if (select_mapped_room_type_arr.includes(value.Name)) {
			}
			else{
				$("#mapped_room_type").append(`<option value="${value.Id}">${value.Name}</option>`);
			}
		})

		if ($("#mapped_room_type option").length <= 1){
			$("#add_room_hotel_div").hide();
		}
		else{
			$("#add_room_hotel_div").show();
		}
	}
})

$(document).on('click', "#remove_mapped_row", function (){
	$(this).parents('.row:first').remove();
	var select_room_type = $("#room_type option:selected").html();
	var select_mapped_room_type = $("#mapped_room_type option:selected").html();

	var select_room_type_arr = [];
	$(".selected_room_type").each(function (){
		select_room_type_arr.push($(this).val());
	})
	$("#room_type").html("");
	$("#room_type").select2('destroy').val("").select2({
		placeholder: "Select Room Type",
		width: '100%'
	});
	$("#room_type").append(`<option value=""></option>`);
	$.each(all_hotel_room_types, function( key, value ) {
		if (select_room_type_arr.includes(value.RoomType)) {
		}
		else{
			var selected = "";
			if (select_room_type == value.RoomType){
				selected = "selected";
			}
			$("#room_type").append(`<option value="${value.Id}" ${selected}>${value.RoomType}</option>`);
		}
	})

	var select_mapped_room_type_arr = [];
	$(".selected_mapped_room_type").each(function (){
		select_mapped_room_type_arr.push($(this).val());
	})
	$("#mapped_room_type").html("");
	$("#mapped_room_type").select2('destroy').val("").select2({
		placeholder: "Select Mapped Room Type",
		width: '100%'
	});
	$("#mapped_room_type").append(`<option value=""></option>`);
	$.each(all_mapped_room_types, function( key, value ) {
		if (select_mapped_room_type_arr.includes(value.Name)) {
		}
		else{
			var selected = "";
			if (select_mapped_room_type == value.Name){
				selected = "selected";
			}
			$("#mapped_room_type").append(`<option value="${value.Id}" ${selected}>${value.Name}</option>`);
		}
	})

	if ($("#mapped_room_type option").length <= 1){
		$("#add_room_hotel_div").hide();
	}
	else{
		$("#add_room_hotel_div").show();
	}
})

$(document).on("click", "#save_hotel", function (){
	$(this).attr('disabled','disabled');
	var userId = $("#users_dropdown").val();

	var formData = new FormData($('#edit_hotel')[0]);
	formData.append('type', '<?= $type ?>');
	formData.append('user_id', userId);

	var thi = $(this);
	var cnt = 1;
	$("#mapped_rooms_div .row").each(function (){
		formData.append('RoomType_'+cnt, parseInt($(this).find('.selected_room_type').attr('room-type-id')));
		formData.append('MappedRoomType_'+cnt, parseInt($(this).find('.selected_mapped_room_type').attr('mapped-room-type-id')));
		cnt++;
	})

	if(validate_edit_hotel_form()){
		$.ajax({
			url: "<?php echo base_url().'update_hotel'; ?>",
			method: "POST",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			cache: false,
			success: function (res) {
				// var res = JSON.parse(res);
				// console.log(res);
				$(thi).removeAttr("disabled");
				if (res.status == "failed"){
					$("#error_toast").attr('data-toast-text', res.error);
					$("#error_toast").trigger('click');
				}
				else if (res.status == "1"){
					$("#error_toast").attr('data-toast-text', "Hotel already exist on this website.");
					$("#error_toast").trigger('click');
				}
				else if (res.status == "0"){
					$("#success_toast").attr('data-toast-text', "Hotel Updated successfully.");
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
	else{
		$(thi).removeAttr("disabled");
	}
})

$(document).on('click', '#cancel_btn', function (){
	redirect_listpage();
})

function redirect_listpage(){
	var type = "<?= $type ?>";
	if (type == "Hotel"){
		location.href = "<?php echo base_url('settings/hotel')?>";
	}
	else {
		location.href = "<?php echo base_url('settings/competitorHotel')?>";
	}
}

$.validator.addMethod("noSpace", function(value, element) {
	return (value.trim() == value) && (value.indexOf(" ") < 0);
});

function validate_edit_hotel_form()
{
	$('#edit_hotel').validate({
		rules: {
			website: {
				required: true,
			},
			state: {
				required: true,
			},
			city: {
				required: true,
			},
			hotel_name: {
				required: true,
			},
			mapped_hotel_name: {
				required: true,
			},
			address: {
				required: true,
			},
			hotel_code: {
				required: true,
				noSpace: true
			},
		},
		messages: {
			hotel_code: {
				noSpace: "only one word can enter, no space allowed.",
			},
		}
	});

	if ($("#mapped_rooms_div").html() == ""){
		$("#room_type_error").html("Please select atleast one room type");
	}

	if($("#edit_hotel").valid() && $("#mapped_rooms_div").html() != ""){
		return true;
	}
	else {
		return false;
	}
}
</script>
