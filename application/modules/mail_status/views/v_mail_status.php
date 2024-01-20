<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Mail Status </title>
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
							<h4 class="mb-sm-0">Mail Status</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void()">Review Management</a></li>
									<li class="breadcrumb-item active">Mail Status</li>
								</ol>
							</div>

						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<div class="col-xl-12 col-lg-12">
						<div class="card">
							<div class="card-body" id="review_summary_div">
								<div class="live-preview">
									<div class="col-3 mb-4">
										<input type="date" name="Mail_status_date" id="Mail_status_date" class="form-control" value="<?= date('Y-m-d') ?>">
									</div>
									<div class="table-responsive">
										<table class="table table-bordered align-middle table-nowrap mt-2" id="Mail_status_table">
											<thead>
											<tr>
												<th scope="col">Client Name</th>
												<th scope="col">Hotel Name</th>
												<th scope="col">Date</th>
												<th scope="col">Sent Mail Status</th>
											</tr>
											</thead>
											<tbody>
											<?php if (isset($mail_logs) && !empty($mail_logs)){
												foreach ($mail_logs as $mail_log) { ?>
											<tr>
												<td><?= $mail_log['user_name'] ?></td>
												<td><?= $mail_log['hotel_name'] ?></td>
												<td><?= $mail_log['datetime'] ?></td>
												<td><?= $mail_log['status'] ?></td>
											</tr>
											<?php }
											} ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class='loading-ct' style="display: none">
									<div class='part_loading'>
										<i class="mdi mdi-spin mdi-loading fa-3x"></i>
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

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>

<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
var table;
$(document).ready(function (){
	table = $("#Mail_status_table").DataTable();
})
</script>

</body>
</html>
