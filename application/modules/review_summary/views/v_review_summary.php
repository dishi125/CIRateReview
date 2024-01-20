<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Review Summary </title>
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
							<h4 class="mb-sm-0">Review Summary</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void()">Review Management</a></li>
									<li class="breadcrumb-item active">Review Summary</li>
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
										<input type="date" name="review_summary_date" id="review_summary_date" class="form-control" value="<?= date('Y-m-d') ?>">
									</div>
									<h4 id="client_name"><?= $username['user_name'] ?></h4>
									<div class="table-responsive">
										<table class="table table-bordered align-middle table-nowrap mt-2" id="review_summary_table">
											<thead>
											<tr>
												<th scope="col">Website</th>
												<th scope="col">Hotel</th>
												<th scope="col">Positive Review</th>
												<th scope="col">Negative Review</th>
												<th scope="col">Total Review</th>
												<th scope="col">Notes</th>
											</tr>
											</thead>
											<tbody>
											<?php
											if (isset($Responded_Reviews) && !empty($Responded_Reviews)){
											$keys = array_column($Responded_Reviews, 'website_id');
											array_multisort($keys, SORT_ASC, $Responded_Reviews);
											$first_website_id = 0;
											foreach ($Responded_Reviews as $Responded_Review) {
												$rowspan = array_count_values(array_column($Responded_Reviews, 'website_id'))[$Responded_Review['website_id']];
												if ($first_website_id == $Responded_Review['website_id']) {?>
													<tr>
														<td><?= $Responded_Review['hotel_name'] ?></td>
														<td><?= $Responded_Review['positive_review'] ?></td>
														<td><?= $Responded_Review['negative_review'] ?></td>
														<td><?= $Responded_Review['total_reviews'] ?></td>
														<td><?= $Responded_Review['notes'] ?></td>
													</tr>
												<?php } else { ?>
													<tr>
														<td rowspan="<?= $rowspan ?>" style="text-align: center; vertical-align: middle"><?= $Responded_Review['Name'] ?></td>
														<td><?= $Responded_Review['hotel_name'] ?></td>
														<td><?= $Responded_Review['positive_review'] ?></td>
														<td><?= $Responded_Review['negative_review'] ?></td>
														<td><?= $Responded_Review['total_reviews'] ?></td>
														<td><?= $Responded_Review['notes'] ?></td>
													</tr>
												<?php }
												$first_website_id = $Responded_Review['website_id']; }
											} else {?>
											<tr>
												<td colspan="6" style="text-align: center">No records found</td>
											</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
									<button type="button" class="btn btn-soft-info waves-effect waves-light" style="float: right" id="send_mail_review_summary">Send Mail</button>
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
function filterReviewSummaryDataBycustomer(){
	var user_id = $('#users_dropdown').val();
	var user_name = $('#users_dropdown option:selected').html();
	var date = $("#review_summary_date").val();
	var hotelId = $("#own_hotels_dropdown").val();
	var thi = $(this);

	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});

	$.ajax({
		url: "<?= base_url('filter_review_Summary') ?>",
		method: "POST",
		data: {"user_id": user_id, "user_name": user_name, "date": date, "hotelId": hotelId},
		beforeSend: function(jqXHR) {
			xhrPool.push(jqXHR);
			$("#review_summary_div").find('.loading-ct').show();
		},
		success: function (res) {
			var res = JSON.parse(res);
			if (res.status == 1){
				$("#client_name").html(res.user_name);
				$("#review_summary_table tbody").html(res.html);
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
			$("#error_toast").attr('data-toast-text', 'Something went wrong!');
			$("#error_toast").trigger('click');
		},
		complete: function(data) {
			$("#review_summary_div").find('.loading-ct').hide();
		}
	});
}

$(document).on('change', '#review_summary_date', function (){
	filterReviewSummaryDataBycustomer();
})

$(document).on('click', '#send_mail_review_summary', function (){
	$(this).attr('disabled','disabled');
	var user_id = $('#users_dropdown').val();
	var user_name = $('#users_dropdown option:selected').html();
	var date = $("#review_summary_date").val();
	var hotelId = $("#own_hotels_dropdown").val();
	var thi = $(this);

	$.ajax({
		url: "<?= base_url('send_mail_review_summary') ?>",
		method: "POST",
		data: {"user_id": user_id, "user_name": user_name, "date": date,"hotelId": hotelId},
		beforeSend: function(jqXHR) {
			xhrPool.push(jqXHR);
		},
		success: function (res) {
			var res = JSON.parse(res);
			if (res.status == 1){
				$("#success_toast").attr('data-toast-text', 'Mail sent successfully.');
				$("#success_toast").trigger('click');
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
			$("#error_toast").attr('data-toast-text', 'Something went wrong!');
			$("#error_toast").trigger('click');
			$(thi).removeAttr("disabled");
		},
		complete: function(data) {
			$(thi).removeAttr("disabled");
		}
	});
})
</script>
</body>
</html>
