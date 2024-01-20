<?php include 'layouts/head-main.php'; ?>
<head>

	<title> Employee Report </title>
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
							<h4 class="mb-sm-0">Employee Report</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item active">Employee Report</li>
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
									<h5 class="card-title mb-0 flex-grow-1 text-dark">List of Employee Report</h5>
									<?php if (isset($add) && $add == 1){ ?>
									<div class="flex-shrink-0">
										<button type="button" class="btn btn-success add-btn" id="add_employee_report_btn"><i class="ri-add-line align-bottom me-1"></i> Add Employee Report</button>
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
									<div class="table-responsive table-card mb-1 mt-1" style="margin-left: 5px; margin-right: 5px">
										<table class="table table-nowrap align-middle" id="List_employee_report_table">
											<thead class="text-dark table-light">
											<tr class="text-uppercase">
												<th>No.</th>
												<th>Start Time</th>
												<th>End Time</th>
												<th>Total Time</th>
												<th>Break Hours</th>
												<th>Description</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
											</thead>
											<tbody class="list">
											<?php if (isset($employee_reports) && !empty($employee_reports)) {
												$i = 1;
												foreach ($employee_reports as $employee_report) { ?>
												<td><?= $i ?></td>
												<td><?= $employee_report['start_time'] ?></td>
												<td><?= $employee_report['end_time'] ?></td>
												<td><?= $employee_report['total_time'] ?></td>
												<td><?= $employee_report['break_hours'] ?></td>
												<td><?= $employee_report['description'] ?></td>
												<td><?= $employee_report['date'] ?></td>
												<td>
													<ul class="list-inline hstack gap-2 mb-0">
														<?php if (isset($edit) && $edit == 1){ ?>
														<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
															<a href="<?php echo base_url() . 'edit_employee_report/' . $employee_report['id']; ?>"
															   class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
														</li>
														<?php } ?>
														<?php if (isset($delete) && $delete == 1){ ?>
														<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
															<a class="text-danger d-inline-block remove-item-btn"
															   onclick="delete_employee_report(<?= $employee_report['id'] ?>)"><i class="ri-delete-bin-5-fill fs-16"></i></a>
														</li>
														<?php } ?>
													</ul>
												</td>
											<?php }
												$i++;
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

<div class="modal fade zoomIn" id="deleteEmployeeReportModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
			</div>
			<div class="modal-body">
				<div class="mt-2 text-center">
					<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
							   colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
					<div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
						<h4>Are you sure ?</h4>
						<p class="text-muted mx-4 mb-0">Are you sure you want to remove this report ?</p>
					</div>
				</div>
				<div class="d-flex gap-2 justify-content-center mt-4 mb-2">
					<button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn w-sm btn-danger" id="delete-report">Yes, Delete It!</button>
				</div>
			</div>
		</div>
	</div>
</div>

<button type="button" id="error_toast" data-toast data-toast-text="Something went wrong!" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="Employee report Deleted Successfully." data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>

<script type="text/javascript">
var table;
$(document).ready(function (){
	table = $("#List_employee_report_table").DataTable();
})

$(document).on('click', '#add_employee_report_btn', function() {
	location.href = "<?php echo base_url('add_employee_report'); ?>";
})

function delete_employee_report(report_id) {
	$("#delete-report").attr('report-id', report_id);
	$("#deleteEmployeeReportModal").modal('show');
}

$(document).on('click', '#delete-report', function() {
	var report_id = $(this).attr('report-id');
	var user_id = $("#users_dropdown").val();
	$(this).attr('disabled', 'disabled');
	var thi = $(this);

	$.ajax({
		url: "<?php echo base_url() . 'delete_employee_report'; ?>",
		method: "POST",
		data: {"report_id": report_id, "user_id": user_id},
		success: function(res) {
			$(thi).removeAttr("disabled");
			var res = JSON.parse(res);
			if (res.status == 1) {
				$("#success_toast").trigger('click');
				table.destroy();
				$("#List_employee_report_table tbody").html(res.html);
				table = $("#List_employee_report_table").DataTable();
				$("#deleteEmployeeReportModal").modal('hide');
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
		error: function() {
			$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');
			$(thi).removeAttr("disabled");
		}
	});
})

function filterEmployeeReportDataBycustomer(){
	var userId = $("#users_dropdown").val();

	$.ajax({
		url: "<?php echo base_url() . 'get_employee_reportlist'; ?>",
		method: "POST",
		data: {"userId": userId},
		success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				table.destroy();
				$("#List_employee_report_table tbody").html(res.html);
				table = $("#List_employee_report_table").DataTable();
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
		error: function() {
			$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');
		}
	});
}
</script>
