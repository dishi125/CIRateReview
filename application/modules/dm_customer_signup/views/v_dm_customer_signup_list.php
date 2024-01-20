<?php include 'layouts/head-main.php'; ?>

<head>

	<title> DM Customer Signup </title>
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
							<h4 class="mb-sm-0">DM Customer List</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void(0)">DM Customer List</a></li>
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
									<h5 class="card-title mb-0 flex-grow-1">DM Customer List</h5>
									<div class="flex-shrink-0">
										<button type="button" class="btn btn-success add-btn" id="add_btn"><i class="ri-add-line align-bottom me-1"></i>DM Customer Signup</button>
									</div>
								</div>
							</div>

							<div class="card-body pt-0">
								<div class="live-preview">
									<div class="table-responsive">
										<table class="table table-bordered align-middle table-nowrap" id="List_dm_customer_table">
											<thead>
											<tr>
												<th>Corporate</th>
												<th>Hotel Name</th>
												<th>Brand Name</th>
												<th colspan="2">Action</th>
											</tr>
											</thead>
											<tbody>
											<?php
											if (isset($dms_hotels) && !empty($dms_hotels)){
												$keys = array_column($dms_hotels, 'dm_corporate_id');
												array_multisort($keys, SORT_ASC, $dms_hotels);
												$first_corporate_id = 0;
												foreach ($dms_hotels as $dms_hotel) {
													$rowspan = array_count_values(array_column($dms_hotels, 'dm_corporate_id'))[$dms_hotel['dm_corporate_id']];
													if ($first_corporate_id == $dms_hotel['dm_corporate_id']) {?>
														<tr>
															<td><?= $dms_hotel['hotel_name'] ?></td>
															<td><?= $dms_hotel['brand_name'] ?></td>
															<td>
																<ul class="list-inline hstack gap-2 mb-0">
																	<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
																		<a class="text-primary d-inline-block" href="<?php echo base_url().'view_dm_hotel/'.$dms_hotel['id']; ?>"><i class="ri-eye-fill fs-16"></i></a>
																	</li>
																	<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
																		<a href="<?php echo base_url().'edit_dm_hotel/'.$dms_hotel['id']; ?>" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
																	</li>
																	<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
																		<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel(<?= $dms_hotel['id'] ?>)"><i class="ri-delete-bin-5-fill fs-16"></i></a>
																	</li>
																</ul>
															</td>
														</tr>
													<?php } else { ?>
														<tr>
															<td rowspan="<?= $rowspan ?>" style="text-align: center; vertical-align: middle"><?= $dms_hotel['corporation_name'] ?></td>
															<td><?= $dms_hotel['hotel_name'] ?></td>
															<td><?= $dms_hotel['brand_name'] ?></td>
															<td>
																<ul class="list-inline hstack gap-2 mb-0">
																	<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
																		<a class="text-primary d-inline-block" href="<?php echo base_url().'view_dm_hotel/'.$dms_hotel['id']; ?>"><i class="ri-eye-fill fs-16"></i></a>
																	</li>
																	<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
																		<a href="<?php echo base_url().'edit_dm_hotel/'.$dms_hotel['id']; ?>" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
																	</li>
																	<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
																		<a class="text-danger d-inline-block remove-item-btn" onclick="delete_hotel(<?= $dms_hotel['id'] ?>)"><i class="ri-delete-bin-5-fill fs-16"></i></a>
																	</li>
																</ul>
															</td>
															<td rowspan="<?= $rowspan ?>">
																<ul class="list-inline hstack gap-2 mb-0">
																	<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
																		<a class="text-danger d-inline-block remove-item-btn" onclick="delete_corporate(<?= $dms_hotel['dm_corporate_id'] ?>)"><i class="ri-delete-bin-5-fill fs-16"></i></a>
																	</li>
																</ul>
															</td>
														</tr>
													<?php }
													$first_corporate_id = $dms_hotel['dm_corporate_id']; }
											} else {?>
												<tr>
													<td colspan="4" style="text-align: center">No records found</td>
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

<button type="button" id="error_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>
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
						<p class="text-muted mx-4 mb-0">Are you sure you want to remove this hotel?</p>
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

<div class="modal fade zoomIn" id="deleteCorporateModal" tabindex="-1" aria-hidden="true">
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
						<p class="text-muted mx-4 mb-0">Are you sure you want to remove this corporate?</p>
					</div>
				</div>
				<div class="d-flex gap-2 justify-content-center mt-4 mb-2">
					<button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn w-sm btn-danger" id="delete-corporate">Yes, Delete It!</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
$(document).on("click", "#add_btn", function (){
	location.href = "<?php echo base_url('dm_customer_signup') ?>";
})

function delete_hotel(hotel_id){
	$("#delete-hotel").attr('hotel-id',hotel_id);
	$("#deleteHotelModal").modal('show');
}

$(document).on('click', '#delete-hotel', function() {
	var hotel_id = $(this).attr('hotel-id');
	$(this).attr('disabled','disabled');
	var thi = $(this);

	$.ajax({
		url: "<?php echo base_url().'delete_dm_hotel/'; ?>" + hotel_id,
		method: "POST",
		success: function (res) {
			$(thi).removeAttr("disabled");
			var res = JSON.parse(res);

			if (res.status == 1 ){
				$("#success_toast").attr('data-toast-text', "DM Hotel Deleted successfully.");
				$("#success_toast").trigger('click');
				$("#List_dm_customer_table tbody").html(res.html);
				$("#deleteHotelModal").modal('hide');
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
			$("#deleteHotelModal").modal('hide');

		},
		error: function () {
			$("#error_toast").trigger('click');
			$(thi).removeAttr("disabled");
		}
	});
})

function delete_corporate(corporate_id){
	$("#delete-corporate").attr('corporate-id',corporate_id);
	$("#deleteCorporateModal").modal('show');
}

$(document).on('click', '#delete-corporate', function() {
	var corporate_id = $(this).attr('corporate-id');
	$(this).attr('disabled','disabled');
	var thi = $(this);

	$.ajax({
		url: "<?php echo base_url().'delete_dm_corporate/'; ?>" + corporate_id,
		method: "POST",
		success: function (res) {
			$(thi).removeAttr("disabled");
			var res = JSON.parse(res);

			if (res.status == 1 ){
				$("#success_toast").attr('data-toast-text', "DM Corporate Deleted successfully.");
				$("#success_toast").trigger('click');
				$("#List_dm_customer_table tbody").html(res.html);
				$("#deleteCorporateModal").modal('hide');
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
			$("#deleteCorporateModal").modal('hide');

		},
		error: function () {
			$("#error_toast").trigger('click');
			$(thi).removeAttr("disabled");
		}
	});
})
</script>

</body>
</html>
