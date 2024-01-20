<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Support </title>
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
							<h4 class="mb-sm-0">Support</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item active">List of Support</li>
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
									<h5 class="card-title mb-0 flex-grow-1">List of Support</h5>
									<!--<div class="flex-shrink-0">
										<button type="button" class="btn btn-success add-btn" id="add_btn"><i class="ri-add-line align-bottom me-1"></i> Add Website</button>
									</div>-->
								</div>
							</div>

							<div class="card-body pt-0">
								<div class="live-preview">
									<div class="table-responsive table-card mb-1 mt-1">
										<table class="table table-nowrap align-middle" id="List_Support_table">
											<thead class="text-muted table-light">
											<tr class="text-uppercase">
												<th>Id</th>
												<th>Username</th>
												<th>E-mail</th>
												<th>Problem Type</th>
												<th>Reported Problem</th>
												<th>Subject</th>
												<th>Message</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
											</thead>
											<tbody class="list">
											<?php if(isset($getsupportList)) { foreach ($getsupportList as $support){ ?>
												<tr>
													<td><?= $support['id'] ?></td>
													<td><?= $support['username'] ?></td>
													<td><?= $support['email'] ?></td>
													<td><?= $support['problem_type'] ?></td>
													<td><?= $support['reported_problem'] ?></td>
													<td><?= $support['subject'] ?></td>
													<td><?= $support['message'] ?></td>
													<td><?= $support['status'] ?></td>

													<td>
														<ul class="list-inline hstack gap-2 mb-0">
															<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
																<a class="text-primary d-inline-block edit-item-btn" onclick="edit_support(<?= $support['id'] ?>)"><i class="ri-pencil-fill fs-16"></i></a>
															</li>
															<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
																<a class="text-danger d-inline-block remove-item-btn" onclick="delete_support(<?= $support['id'] ?>)"><i class="ri-delete-bin-5-fill fs-16"></i></a>
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
<button type="button" id="error_toast" data-toast data-toast-text="Something went wrong!" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<div class="modal fade" id="editSupportModal" tabindex="-1" aria-labelledby="exampleModalgridLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fw-bold" id="exampleModalgridLabel">Edit</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="post" id="edit_support">
					<div class="row g-3">
						<div class="col-xxl-6">
							<div>
								<label class="form-label">User Name</label>
								<input type="text" class="form-control" id="username" name="username" readonly>
							</div>
						</div><!--end col-->
						<div class="col-xxl-6">
							<div>
								<label class="form-label">E-mail</label>
								<input type="text" class="form-control" id="user_email" name="user_email" readonly>
							</div>
						</div><!--end col-->
						<div class="col-xxl-6">
							<div>
								<label class="form-label">Problem Type</label>
								<input type="text" class="form-control" id="problem_type" name="problem_type" readonly>
							</div>
						</div><!--end col-->
						<div class="col-xxl-6">
							<div>
								<label class="form-label">Reported Problem</label>
								<input type="text" class="form-control" id="reported_problem" name="reported_problem" readonly>
							</div>
						</div><!--end col-->
						<div class="col-xxl-6">
							<div>
								<label class="form-label">Subject</label>
								<input type="text" class="form-control" id="subject" name="subject" readonly>
							</div>
						</div><!--end col-->
						<div class="col-xxl-6">
							<div>
								<label class="form-label">Message</label>
								<textarea class="form-control" id="message" name="message" readonly></textarea>
							</div>
						</div><!--end col-->
						<div class="col-xxl-6">
							<div>
								<label class="form-label">Status</label>
								<select class="form-control" name="status" id="status">
									<option value="pending">pending</option>
									<option value="completed">completed</option>
									<option value="draft">draft</option>
									<option value="under review">under review</option>
									<option value="assigned">assigned</option>
									<option value="under investigation">under investigation</option>
									<option value="closed">closed</option>
									<option value="cancelled">cancelled</option>
								</select>
							</div>
						</div><!--end col-->
						<div class="col-lg-12">
							<div class="hstack gap-2 justify-content-end">
								<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary" id="edit_support_btn">Save</button>
							</div>
						</div><!--end col-->
					</div><!--end row-->
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade zoomIn" id="deleteSupportModal" tabindex="-1" aria-hidden="true">
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
						<p class="text-muted mx-4 mb-0">Are you sure you want to remove this support?</p>
					</div>
				</div>
				<div class="d-flex gap-2 justify-content-center mt-4 mb-2">
					<button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn w-sm btn-danger" id="delete-support">Yes, Delete It!</button>
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
var table;
$(document).ready(function (){
	table = $("#List_Support_table").DataTable();
})

function edit_support(support_id){
	$.ajax({
		url: "<?php echo base_url().'support_details'; ?>",
		method: "POST",
		data: {"support_id":support_id},
		/*dataType: "json",
		contentType: false,
		processData: false,
		cache: false,*/
		success: function (res) {
			var res = JSON.parse(res);
			console.log(res);
			if (res.status == 1) {
				$("#editSupportModal #username").val(res.support_details.username);
				$("#editSupportModal #user_email").val(res.support_details.email);
				$("#editSupportModal #problem_type").val(res.support_details.problem_type);
				$("#editSupportModal #reported_problem").val(res.support_details.reported_problem);
				$("#editSupportModal #subject").val(res.support_details.subject);
				$("#editSupportModal #message").val(res.support_details.message);
				$("#editSupportModal #status").val("");
				$("#editSupportModal #status").val(res.support_details.status);
				$("#editSupportModal #edit_support_btn").attr('support-id', support_id);
				// $('#status option:selected').attr("selected",null);
				// $('#status option[value="'+res.support_details.status+'"]').attr("selected", "selected");
				$("#editSupportModal").modal('show');
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

$(document).on("click", "#edit_support_btn", function (){
	var support_id = $(this).attr('support-id');
	var status = $("#editSupportModal #status").val();
	$(this).attr('disabled','disabled');
	var thi = $(this);

	$.ajax({
		url: "<?php echo base_url().'update_support'; ?>",
		method: "POST",
		data: {"support_id":support_id, "status": status},
		success: function (res) {
			var res = JSON.parse(res);
			$("#editSupportModal").modal('hide');
			if (res.status == 1) {
				$("#success_toast").attr('data-toast-text', "Support updated successfully.");
				$("#success_toast").trigger('click');
				table.destroy();
				$("#List_Support_table tbody").html(res.html);
				table = $("#List_Support_table").DataTable();
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
		},
		complete: function (){
			$(thi).removeAttr("disabled");
		}
	});
})

function delete_support(support_id){
	$("#delete-support").attr('support-id',support_id);
	$("#deleteSupportModal").modal('show');
}

$(document).on('click', '#delete-support', function() {
	var support_id = $(this).attr('support-id');
	$(this).attr('disabled','disabled');
	var thi = $(this);

	$.ajax({
		url: "<?php echo base_url().'delete_support/'; ?>" + support_id,
		method: "POST",
		success: function (res) {
			$(thi).removeAttr("disabled");
			var res = JSON.parse(res);
			$("#deleteSupportModal").modal('hide');

			if (res.status == 1){
				$("#success_toast").attr('data-toast-text', "Support deleted successfully.");
				$("#success_toast").trigger('click');
				table.destroy();
				$("#List_Support_table tbody").html(res.html);
				table = $("#List_Support_table").DataTable();
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
			$(thi).removeAttr("disabled");
		}
	});
})
</script>

</body>
</html>
