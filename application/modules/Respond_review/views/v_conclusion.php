<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Conclusion </title>
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
							<h4 class="mb-sm-0">Conclusion</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void();">Review Management</a></li>
									<li class="breadcrumb-item"><a href="<?= base_url('review_management/respond_review') ?>">Respond Review</a></li>
									<li class="breadcrumb-item active">Conclusion</li>
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
									<h5 class="card-title mb-0 flex-grow-1">List of Conclusions</h5>
									<div class="flex-shrink-0">
										<button type="button" class="btn btn-success add-btn" style='margin-right:16px'
												id="add_conclusion_btn"><i class="ri-add-line align-bottom me-1"></i> Add Conclusion</button>
									</div>
								</div>
							</div>

							<div class="card-body border border-dashed border-end-0 border-start-0">
								<div class="col-3">
									<input type="date" name="conclusion_date_filter" id="conclusion_date_filter" class="form-control" value="<?= date('Y-m-d') ?>">
								</div>
							</div>

							<div class="card-body pt-0">
								<div class="live-preview">
									<div class="table-responsive table-card mb-1 mt-1">
										<table class="table table-nowrap align-middle" id="List_conclusion_table">
											<thead class="text-muted table-light">
											<tr class="text-uppercase">
												<th>Hotel</th>
												<th>Date</th>
												<th>Conclusion</th>
												<th>Action</th>
											</tr>
											</thead>
											<tbody class="list">
											<?php if (isset($conclusions) && !empty($conclusions)) {
												foreach ($conclusions as $conclusion) { ?>
													<tr>
														<td><?= $conclusion['hotel_name'] ?></td>
														<td><?= $conclusion['date'] ?></td>
														<td><?= $conclusion['conclusion'] ?></td>
														<td>
															<ul class="list-inline hstack gap-2 mb-0">
																<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
																	<a href="<?php echo base_url() . 'edit_conclusion/' . $conclusion['id']; ?>"
																	   class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
																</li>
																<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
																	<a class="text-danger d-inline-block remove-item-btn"
																	   onclick="delete_conclusion(<?= $conclusion['id'] ?>)"><i class="ri-delete-bin-5-fill fs-16"></i></a>
																</li>
															</ul>
														</td>
													</tr>
												<?php }
											} ?>
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
<button type="button" id="error_toast" data-toast data-toast-text="Something went wrong!" data-toast-gravity="top"
		data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs"
		data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="Conclusion Deleted Successfully."
		data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close"
		class="btn btn-light w-xs" data-toast-classname="success"></button>

<div class="modal fade zoomIn" id="deleteConclusionModal" tabindex="-1" aria-hidden="true">
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
						<p class="text-muted mx-4 mb-0">Are you sure you want to remove this Conclusion ?</p>
					</div>
				</div>
				<div class="d-flex gap-2 justify-content-center mt-4 mb-2">
					<button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn w-sm btn-danger" id="delete-conclusion">Yes, Delete It!</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url() . 'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
var table;
$(document).ready(function() {
	table = $("#List_conclusion_table").DataTable();
})

$(document).on("click", "#add_conclusion_btn", function() {
	location.href = "<?php echo base_url('add_conclusion'); ?>";
})

function delete_conclusion(conclusion_id) {
	$("#delete-conclusion").attr('conclusion-id',conclusion_id);
	$("#deleteConclusionModal").modal('show');
}

$(document).on('click', '#delete-conclusion', function() {
	var conclusion_id = $(this).attr('conclusion-id');
	var userId = $("#users_dropdown").val();
	var date = $("#conclusion_date_filter").val();
	var hotelId = $("#own_hotels_dropdown").val();
	$(this).attr('disabled','disabled');
	var thi = $(this);

	$.ajax({
		url: "<?php echo base_url().'delete_conclusion'; ?>",
		method: "POST",
		data: {"conclusionId": conclusion_id, "userId": userId, "date": date, "hotelId": hotelId},
		success: function (res) {
			$(thi).removeAttr("disabled");
			var res = JSON.parse(res);
			if (res.status == true ){
				$("#success_toast").trigger('click');
				table.destroy();
				$("#List_conclusion_table tbody").html(res.html);
				table = $("#List_conclusion_table").DataTable();
				$("#deleteConclusionModal").modal('hide');
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
		error: function () {
			$("#error_toast").trigger('click');
			$(thi).removeAttr("disabled");
		}
	});
})

$(document).on('change', '#conclusion_date_filter', function (){
	filterConclusionsData();
})

function filterConclusionsData(){
	var userId = $("#users_dropdown").val();
	var hotelId = $("#own_hotels_dropdown").val();
	var date = $("#conclusion_date_filter").val();
	var thi = $(this);

	$.ajax({
		url: "<?php echo base_url().'filter_conclusions'; ?>",
		method: "POST",
		data: {"userId": userId, "hotelId": hotelId, "date": date},
		success: function (res) {
			var res = JSON.parse(res);
			if (res.status == 1){
				table.destroy();
				$("#List_conclusion_table tbody").html(res.html);
				table = $("#List_conclusion_table").DataTable();
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
		error: function () {
			$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');
		}
	});
}
</script>

</body>
</html>
