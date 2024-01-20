<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Review Report </title>
	<?php include 'layouts/title-meta.php'; ?>

	<?php include 'layouts/head-css.php'; ?>
	<style type="text/css">
		table th {
			background-color: lightgrey;
			white-space: -o-pre-wrap;
			word-wrap: break-word;
			white-space: pre-wrap;
			white-space: -moz-pre-wrap;
			white-space: -pre-wrap;
		}

		table {
			table-layout: fixed;
			width: 100%;
			word-break: break-word;
		}

		table td {
			white-space: -o-pre-wrap;
			word-wrap: break-word;
			white-space: pre-wrap;
			white-space: -moz-pre-wrap;
			white-space: -pre-wrap;
		}
	</style>
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
							<h4 class="mb-sm-0">Review Report</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void()">Review Management</a></li>
									<li class="breadcrumb-item active">Review Report</li>
								</ol>
							</div>

						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<div class="col-xl-12 col-lg-12">
						<div class="card">
							<div class="card-body" id="review_report_div">
								<div class="live-preview">
									<div class="col-3">
										<input type="date" name="review_report_date" id="review_report_date" class="form-control" value="<?= date('Y-m-d') ?>">
									</div>
								</div>
							</div>
						</div>
					</div><!-- end col -->
				</div>
				<!-- end row -->

				<div class="row justify-content-center" id="pdf_view_div">
					<div class="col-8">
						<div class="card">
							<div class="card-header border-bottom-dashed p-4" id="psmtech_logo">
								<div class="d-sm-flex">
									<div class="flex-grow-1">
										<img src="<?= base_url() . 'assets/images/psmtech_logo.png' ?>" class="card-logo card-logo-dark" alt="logo dark" height="50">
									</div>
								</div>
							</div>
							<!--end card-header-->
							<div class="card-body py-2 p-4">
								<div class="row">
									<div class="col-6">
										<h2 class="m-0" id="client_name" style="text-align: left; "><?= $username['user_name'] ?> </h2>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<p class="m-0" id="respond_date" style="text-align: left; "><?= date("m-d-Y", strtotime($curr_date)) ?></p>
									</div>
								</div>
							</div>
							<div id="table_chart_review_report_div">
								<?php $hotel_wise_data = array(); ?>
								<?php if (isset($hotel_names) && !empty($hotel_names)) {
									foreach ($hotel_names as $key => $hotel_name) {
										$hotel_wise_data[$hotel_name] = array(); ?>
										<div class="card-body py-2 p-4 border-top border-top-dashed">
											<h3 class=" mt-2 mb-3"><?= $hotel_name ?></h3>
											<div class="row">
												<div class="col-6">
													<canvas class="review_report_chart" hotel="<?= $hotel_name ?>" width="" height="" id="<?= 'review_report_chart_' . $key ?>"></canvas>
												</div>
												<div class="col-6">
													<img class="review_report_chart_url" hotel="<?= $hotel_name ?>" id="<?= 'review_report_chart_url_' . $key ?>" style="display: none" />
												</div>
											</div>

											<div class="row g-2  mb-1 mt-2">
												<div class="col-lg-12 col-12">
													<div class="table-responsive">
														<table class="table-bordered" cellpadding="10">
															<thead>
																<tr class="">
																	<th class="">Website</th>
																	<th class="">Positive Review</th>
																	<th class="">Negative Review</th>
																	<th class="">Total Review</th>
																	<th class="">Notes</th>
																</tr>
															</thead>
															<tbody id="products-list">
																<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
																	foreach ($Responded_Reviews as $Responded_Review) {
																		if ($Responded_Review['hotel_name'] == $hotel_name) {
																			array_push($hotel_wise_data[$hotel_name], $Responded_Review); ?>
																			<tr>
																				<td><?= ucfirst($Responded_Review['Name']) ?></td>
																				<td><?= $Responded_Review['positive_review'] ?></td>
																				<td><?= $Responded_Review['negative_review'] ?></td>
																				<td><?= $Responded_Review['total_reviews'] ?></td>
																				<td><?= ucfirst($Responded_Review['notes']) ?></td>
																			</tr>
																	<?php }
																	}
																} else { ?>
																	<tr>
																		<td colspan="6" style="text-align: center">No records found</td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
														<!--end table-->
													</div>
												</div>
											</div>
										</div>
										<div class="card-body p-4 ">
											<div class="row g-3">
												<div class="col-sm-12">
													<h4 class=" mt-2 mb-3">Positive Review Feedback:</h4>
													<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
														foreach ($Responded_Reviews as $Responded_Review) {
															if ($Responded_Review['hotel_name'] == $hotel_name) { ?>
																<p class="fw-medium fs-18 mb-1"><?= ucfirst($Responded_Review['Name']) ?>:</p>
																<p class="fs-16 mb-2"><?= ucfirst($Responded_Review['positive_description']) ?></p>
													<?php }
														}
													} ?>
												</div>
												<br>
												<!--end col-->
												<div class="col-sm-12  mb-1 mt-2">
													<h4 class=" mt-2 mb-3">Negative Review Feedback:</h4>
													<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
														foreach ($Responded_Reviews as $Responded_Review) {
															if ($Responded_Review['hotel_name'] == $hotel_name) { ?>
																<p class="fw-medium fs-18 mb-1"><?= ucfirst($Responded_Review['Name']) ?>:</p>
																<p class="fs-16 mb-2"><?= ucfirst($Responded_Review['negative_description']) ?></p>
													<?php }
														}
													} ?>
												</div>
												<!--end col-->

												<div class="col-sm-12">
													<?php if (isset($conclusions) && !empty($conclusions)) {
														foreach ($conclusions as $conclusion) {
															if ($conclusion['hotel_name'] == $hotel_name && $conclusion['conclusion'] != "") { ?>
																<h4 class=" mt-2 mb-3">Conclusion</h4>
																<p class="fs-16 mb-2"><?= ucfirst($conclusion['conclusion']) ?></p>
													<?php }
														}
													} ?>
												</div>

											</div>
											<!--end row-->
										</div>
										<!--end card-body-->
									<?php }
								} else { ?>
									<div class="card-body p-4 ">
										<div class="row g-3">
											<div class="col-sm-12">
												<h4>There is no reviews to respond OR Pending to check</h4>
											</div>
										</div>
									</div>
								<?php } ?>
								<!--end card-body-->
							</div>
							<div class="card-footer border-top-dashed p-4">
								<div class="d-sm-flex">
									<div class="flex-grow-1">
										<div class="mt-sm-3 mt-2">
											<h6 class="text-muted text-uppercase fs-22 fw-bold">Address</h6>
											<p class="text-muted mb-1">371 South Swing Road, PI Greensboro, NC-27409</p>
											<p class="text-muted mb-1">E-mail: info@psmtech.com </p>
											<p class="text-muted mb-0">Phone: (336)-285-9178, (336)-285-9177</p>
										</div>
									</div>
								</div>
								<div class="hstack gap-2 justify-content-end d-print-none mt-4">
									<button id="view_pdf" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</button>
									<button id="send_mail" class="btn btn-success"><i class="ri-mail-send-line align-bottom me-1"></i> Send Mail</button>
								</div>
							</div>
						</div>
						<!--end card-->
					</div>
					<!--end col-->
					<div class='loading-ct' style="display: none">
						<div class='part_loading'>
							<i class="mdi mdi-spin mdi-loading fa-3x"></i>
						</div>
					</div>
				</div>
				<!--end row-->

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
<!-- Chart JS -->
<script src="<?php echo base_url() . 'assets/libs/chart.js/chart.min.js'; ?>"></script>
<!-- App js -->
<script src="<?php echo base_url() . 'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var hotel_wise_data =
			<?= (isset($hotel_wise_data) && !empty($hotel_wise_data)) ? json_encode($hotel_wise_data) : "''" ?>;
		if (hotel_wise_data != '') {
			$.each(hotel_wise_data, function(key, value) {
				bar_chart(key, value);
			})
		}
		// console.log(hotel_wise_data);
	})

	function bar_chart(hotel, chart_data) {
		let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
		Chart.defaults.color = "#000000";
		/*const chart_exists = Chart.getChart(chart_id);
		if (chart_exists != undefined) {
			chart_exists.destroy();
		}*/
		$(".review_report_chart").html("");
		var websites = chart_data.map(function(item) {
			return item.Name;
		});
		var positive_reviews = chart_data.map(function(item) {
			return item.positive_review;
		});
		var negative_reviews = chart_data.map(function(item) {
			return item.negative_review;
		});

		// console.log(websites);
		// console.log(positive_reviews);
		// console.log(negative_reviews);
		var ctx;
		var this_chart;
		$(".review_report_chart").each(function() {
			var chart_id = $(this).attr('id');
			if ($(this).attr('hotel') == hotel) {
				this_chart = chart_id;
				ctx = document.getElementById(chart_id);
			}
		})
		var data = {
			labels: websites,
			datasets: [{
				label: "Positive Review",
				backgroundColor: "green",
				barThickness: 20,
				maxBarThickness: 30,
				data: positive_reviews
			}, {
				label: "Negative Review",
				backgroundColor: "red",
				barThickness: 20,
				maxBarThickness: 30,
				data: negative_reviews
			}]
		};

		ctx.setAttribute("width", ctx.parentElement.offsetWidth);
		var height = '300px';
		if (isMobile) {
			height = '400px';
		}
		ctx.setAttribute("height", height);
		var myBarChart = new Chart(ctx, {
			type: 'bar',
			data: data,
			options: {
				responsive: true,
				maintainAspectRatio: false,
				// barValueSpacing: 20,
				plugins: {
					title: {
						display: true,
						align: 'center',
						text: 'Graph of ' + hotel,
						font: {
							weight: 'bold',
							size: '17px',
						},
						/*padding: {
							top: 30,
							bottom: 10
						}*/
					},
					legend: {
						display: true,
						labels: {
							font: {
								size: '14px',
							},
						}
					}
				},
				scales: {
					y: {
						title: {
							display: true,
							align: 'center',
							text: 'Review',
							font: {
								weight: 'bold'
							},
						},
						ticks: {
							font: {
								weight: 'bold'
							}
						},
					},
					x: {
						title: {
							display: true,
							align: 'center',
							text: 'Websites',
							font: {
								weight: 'bold'
							},
						},
						ticks: {
							font: {
								size: '14px',
								weight: 'bold'
							}
						},
					}
				},
				animation: {
					onComplete: function() {
						// var url = this.toBase64Image();
						$(".review_report_chart_url").each(function() {
							var id = $(this).attr('id');
							var thi = $(this);
							if ($(thi).attr('hotel') == hotel) {
								/*var canvas = $("#"+this_chart).get(0), ctx = canvas.getContext("2d");
								var context = document.getElementById(this_chart).getContext('2d');
								var canvas = context.canvas;
								var w = canvas.width;
								var h = canvas.height;
								ctx.fillStyle = "#FFF";
								ctx.fillRect(0,0,w,h);*/
								// var url = document.getElementById(this_chart).toDataURL("image/jpeg");
								var url = document.getElementById(this_chart).toDataURL('image/jpg');
								// var url = document.getElementById(this_chart).toDataURL('image/jpeg');
								// var url = document.getElementById(this_chart).toDataURL('image/png');
								// var url = document.getElementById(this_chart).toDataURL();
								document.getElementById(id).src = url;
							}
						})
					}
				}
			}
		});
	}

	function filterReviewReportDataBycustomer() {
		var user_id = $('#users_dropdown').val();
		var user_name = $('#users_dropdown option:selected').html();
		var date = $("#review_report_date").val();
		var thi = $(this);

		$.each(xhrPool, function(idx, jqXHR) {
			jqXHR.abort();
		});

		$.ajax({
			url: "<?= base_url('filter_review_report') ?>",
			method: "POST",
			data: {
				"user_id": user_id,
				"user_name": user_name,
				"date": date,
				"hotel_id": $("#own_hotels_dropdown").val(),
			},
			beforeSend: function(jqXHR) {
				xhrPool.push(jqXHR);
				$("#pdf_view_div").find('.loading-ct').show();
			},
			success: function(res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#table_chart_review_report_div").html("");
					$("#client_name").html(res.user_name);
					$("#respond_date").html(res.respond_date);
					$("#table_chart_review_report_div").html(res.html);
					if (!$.isEmptyObject(res.hotel_wise_data)) {
						$.each(res.hotel_wise_data, function(key, value) {
							bar_chart(key, value);
						})
					}
				} else if (res.status == 0) {
					$('#session_expired_modal').modal('show');
					setTimeout(function() {
						location.reload();
					}, auto_refresh_page_sec);
				} else {
					$("#error_toast").attr('data-toast-text', "Something went wrong!!");
					$("#error_toast").trigger('click');
				}
			},
			error: function() {
				$("#error_toast").attr('data-toast-text', 'Something went wrong!');
				$("#error_toast").trigger('click');
			},
			complete: function(data) {
				$("#pdf_view_div").find('.loading-ct').hide();
			}
		});
	}

	$(document).on('change', '#review_report_date', function() {
		filterReviewReportDataBycustomer();
	})

	$(document).on('click', '#view_pdf', function() {
		$(this).attr('disabled', 'disabled');
		var thi = $(this);

		var formData = new FormData();
		formData.append('user_id', $("#users_dropdown").val());
		formData.append('hotel_id', $("#own_hotels_dropdown").val());
		formData.append('date', $("#review_report_date").val());
		formData.append('user_name', $("#client_name").html());
		formData.append('hotel_name', $("#own_hotels_dropdown option:selected").html());
		$(".review_report_chart_url").each(function (index, value){
			// var this_id = $(this).attr('id');
			formData.append('chart_urls[]', $(this).attr('src'));
		})

		$.ajax({
			url: "<?= base_url('view_review_report_pdf') ?>",
			method: "POST",
			data: formData,
			// cache:false,
			contentType: false,
			processData: false,
			beforeSend: function(jqXHR) {
				xhrPool.push(jqXHR);
			},
			success: function(res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					window.open(res.url, "_blank");
				} else if (res.status == 0) {
					$('#session_expired_modal').modal('show');
					setTimeout(function() {
						location.reload();
					}, auto_refresh_page_sec);
				} else {
					$("#error_toast").attr('data-toast-text', "Something went wrong!!");
					$("#error_toast").trigger('click');
				}
			},
			error: function(data) {
				$("#error_toast").attr('data-toast-text', 'Something went wrong!');
				$("#error_toast").trigger('click');
				$(thi).removeAttr("disabled");
			},
			complete: function() {
				$(thi).removeAttr("disabled");
			}
		});
	});

	$(document).on('click', '#send_mail', function() {
		$(this).attr('disabled', 'disabled');
		var thi = $(this);

		var formData = new FormData();
		formData.append('user_id', $("#users_dropdown").val());
		formData.append('hotel_id', $("#own_hotels_dropdown").val());
		formData.append('date', $("#review_report_date").val());
		formData.append('user_name', $("#client_name").html());
		formData.append('hotel_name', $("#own_hotels_dropdown option:selected").html());
		$(".review_report_chart_url").each(function (index, value){
			// var this_id = $(this).attr('id');
			formData.append('chart_urls[]', $(this).attr('src'));
		})

		$.ajax({
			url: "<?= base_url('send_mail_review_report') ?>",
			method: "POST",
			data: formData,
			// cache:false,
			contentType: false,
			processData: false,
			beforeSend: function(jqXHR) {
				xhrPool.push(jqXHR);
			},
			success: function(res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#success_toast").attr('data-toast-text', "Mail sent successfully.");
					$("#success_toast").trigger('click');
				} else if (res.status == 0) {
					$('#session_expired_modal').modal('show');
					setTimeout(function() {
						location.reload();
					}, auto_refresh_page_sec);
				} else {
					$("#error_toast").attr('data-toast-text', "Something went wrong!!");
					$("#error_toast").trigger('click');
				}
			},
			error: function(data) {
				$("#error_toast").attr('data-toast-text', 'Something went wrong!');
				$("#error_toast").trigger('click');
				$(thi).removeAttr("disabled");
			},
			complete: function() {
				$(thi).removeAttr("disabled");
			}
		});
	})
</script>
</body>

</html>
