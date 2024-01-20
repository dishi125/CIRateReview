<?php include 'layouts/head-main.php'; ?>

<head>

	<title> <?= $type ?> </title>
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
							<h4 class="mb-sm-0"><?= $type ?></h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void();">Settings</a></li>
									<li class="breadcrumb-item active">List of <?= $type ?></li>
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
									<h5 class="card-title mb-0 flex-grow-1 text-dark">List of <?= $type ?></h5>
									<?php if (isset($add) && $add == 1){ ?>
									<div class="flex-shrink-0">
										<button type="button" class="btn btn-success add-btn" id="add_btn"><i class="ri-add-line align-bottom me-1"></i> Add Hotel</button>
									</div>
									<?php } ?>
								</div>
							</div>

							<!-- <div class="card-body border border-dashed border-end-0 border-start-0">
								<form>
									<div class="col-xxl-5 col-sm-6">
										<div class="search-box">
											<input type="text" class="form-control search" placeholder="Search for order ID, customer, order status or something...">
											<i class="ri-search-line search-icon"></i>
										</div>
									</div>
								</form>
							</div> -->

							<div class="card-body pt-0 border border-dashed border-end-0 border-start-0">
								<div class="live-preview">
									<div class="table-responsive table-card mb-1 mt-1">
										<table class="table table-nowrap align-middle" id="List_Hotel_table">
											<thead class="text-dark table-light">
											<tr class="text-uppercase">
												<th>Website</th>
												<th>State</th>
												<th>City</th>
												<th>Hotel Name</th>
												<th>Mapped Hotel Name</th>
												<!--<th>Room Type</th>
												<th>Mapped Room Type</th>-->
												<th>Action</th>
											</tr>
											</thead>
											<tbody class="list">
											<?php if (isset($GetHotelList) && !empty($GetHotelList)){ ?>
											<?php foreach ($GetHotelList as $hotel){ ?>
												<tr>
													<td><?= $hotel['WebSiteName'] ?></td>
													<td><?= $hotel['StateName'] ?></td>
													<td><?= $hotel['CityName'] ?></td>
													<td><?= $hotel['HotelName'] ?></td>
													<td><?= $hotel['MappedHotelName'] ?></td>
													<!--<td><?/*= $hotel['RoomType'] */?></td>
													<td><?/*= $hotel['MappedRoomType'] */?></td>-->
													<td>
														<ul class="list-inline hstack gap-2 mb-0">
															<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
																<a onclick="view_hotel('<?= $hotel['WebSiteName'] ?>', '<?= $hotel['RoomType'] ?>', '<?= $hotel['MappedRoomType'] ?>', '<?= $hotel['HotelName'] ?>')" class="text-primary d-inline-block"><i class="ri-eye-fill fs-16"></i></a>
															</li>
															<?php if (isset($edit) && $edit == 1){ ?>
															<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
																<a href="<?php echo base_url().'edit_hotel/'.$hotel['HotelId'].'/'.$type; ?>" class="text-primary d-inline-block edit-item-btn" style="cursor: pointer"><i class="ri-pencil-fill fs-16"></i></a>
															</li>
															<?php } ?>
															<?php if (isset($delete) && $delete == 1){ ?>
															<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
																<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel(<?= $hotel['HotelId'] ?>)"><i class="ri-delete-bin-5-fill fs-16"></i></a>
															</li>
															<?php } ?>
														</ul>
													</td>
												</tr>
											<?php } } else {?>
												<tr>
													<td colspan="8" style="text-align: center">No records found</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
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

<button type="button" id="error_toast" data-toast data-toast-text="Something went wrong!" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="Hotel Deleted Successfully" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<div class="modal fade zoomIn" id="deleteHotelModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
			</div>
			<div class="modal-body">
				<div class="mt-2 text-center">
					<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
					<div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
						<h4>Are you sure ?</h4>
						<p class="text-muted mx-4 mb-0">Are you sure you want to remove this hotel ?</p>
					</div>
				</div>
				<div class="d-flex gap-2 justify-content-center mt-4 mb-2">
					<button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn w-sm btn-danger" id="delete-hotel">Yes, Delete It!</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bs-example-modal-md" id="ViewHotelModal" aria-labelledby="exampleModalgridLabel">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fw-bold" id="exampleModalgridLabel">View Hotel</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<h5 id="website"></h5>
				<div class="table-responsive">
					<table class="table table-bordered align-middle table-nowrap mt-2" id="view_hotel_table">
						<thead>
						<tr>
							<th style="font-weight: bold">Mapped Room Type</th>
							<th style="font-weight: bold">Room Type</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>

<script type="text/javascript">
var table;
$(document).ready(function (){
	table = $("#List_Hotel_table").DataTable();
})

$(document).on("click", "#add_btn", function (){
	location.href = "<?php echo base_url('add_hotel/').$type; ?>";
})

function delete_hotel(hotelId){
	$("#delete-hotel").attr('hotel-id',hotelId);
	$("#deleteHotelModal").modal('show');
}

$(document).on('click', '#delete-hotel', function() {
	var hotelId = $(this).attr('hotel-id');
	var user_id = $("#users_dropdown").val();
	var own_hotel = $("#own_hotels_dropdown").val();
	$(this).attr('disabled','disabled');
	var thi = $(this);

	if (user_id == "" || user_id == undefined){
		user_id = null;
	}

	$.ajax({
		url: "<?php echo base_url().'delete_hotel/'.$type; ?>",
		method: "POST",
		data: {"hotelId": hotelId, "user_id": user_id, "own_hotel": own_hotel},
		success: function (res) {
			$(thi).removeAttr("disabled");
			var res = JSON.parse(res);
			if (res.status == 1){
				$("#success_toast").trigger('click');
				table.destroy();
				$("#List_Hotel_table tbody").html(res.html);
				table = $("#List_Hotel_table").DataTable();
				$("#deleteHotelModal").modal('hide');
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
		error: function () {
			$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');
			$(thi).removeAttr("disabled");
		}
	});
})

/*$(document).on('change', '#users_dropdown', function (){
	filterDataBycustomer();
})*/

function filterDataBycustomer(){
	var user_id = $('#users_dropdown').val();
	var own_hotel = $("#own_hotels_dropdown").val();

	$.ajax({
		url: "<?= base_url('filter_hotel/').$type ?>",
		method: "POST",
		data: {"user_id": user_id, "own_hotel": own_hotel},
		success: function (res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				table.destroy();
				$("#List_Hotel_table tbody").html(res.html);
				table = $("#List_Hotel_table").DataTable();
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

function view_hotel(website, room_type, mapped_roomtype, hotel_name){
	$("#ViewHotelModal").find(".modal-title").html(hotel_name);
	$("#ViewHotelModal").find("#website").html(website);
	var mapped_roomtypes = mapped_roomtype.split(" || ");
	var room_types = room_type.split(" || ");
	var html = "";
	for(var i=0; i<mapped_roomtypes.length; i++){
		html += `<tr>
				<td>${mapped_roomtypes[i]}</td>
				<td>${room_types[i]}</td>
				</tr>`;
	}

	$("#ViewHotelModal").find("#view_hotel_table tbody").html(html);
	$("#ViewHotelModal").modal('show');
}
</script>

</body>
</html>
