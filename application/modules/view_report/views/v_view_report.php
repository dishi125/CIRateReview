<?php include 'layouts/head-main.php'; ?>

<head>
    <title>View Report</title>
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
    <div class="main-content" style="margin-left: unset !important;">

        <div class="page-content">
            <div class="container-fluid">

				<!-- start page title -->
				<div class="row">
					<div class="col-12">
						<div class="page-title-box d-sm-flex align-items-center justify-content-between">
							<h4 class="mb-sm-0">View Report</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void()">Review Management</a></li>
									<li class="breadcrumb-item active">View Report</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body" id="review_report_div">
								<div class="live-preview">
									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
										<input type="date" name="view_report_date" id="view_report_date" class="form-control" value="<?= date('Y-m-d') ?>">
									</div>
								</div>
							</div>
						</div>
					</div><!-- end col -->
				</div>
				<!-- end row -->

                <div class="row justify-content-center" id="pdf_content">
					<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12" id="view_report_data">

					<?php $hotel_wise_data = array(); ?>
					<?php if (isset($hotel_names) && !empty($hotel_names)) {
					foreach ($hotel_names as $key => $hotel_name) {
					$hotel_wise_data[$hotel_name] = array();

					$key = array_search($hotel_name, array_column($Responded_Reviews, 'hotel_name'));
					if (!empty($key) || $key === 0) {
						$hotel_image = $Responded_Reviews[$key]['image'];
					}
					?>
                        <div class="card">
                            <div class="card-body" style="padding: 0">
								<div class="row">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<img src="<?= base_url('assets/hotel_cover_picture/'.$hotel_image) ?>" class="card-logo card-logo-dark" alt="logo dark" style="height: 100%; width: 100%">
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding: 50px">
									<h1 style="color: navy"><?= ucfirst(strtolower($hotel_name)) ?></h1>
									<h1 style="color: navy">Review Report</h1>
									<h1 style="color: deepskyblue">Date: <?= date("j F, Y", strtotime($curr_date)) ?></h1>
								</div>
								</div>
                            </div>
                        </div>

						<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) { ?>
						<div class="card">
							<div class="card-body py-2 p-4">
								<div class="row g-2">
									<h2 style="text-align: center;"> Reviews at Site </h2>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 hotel_wise_positive_negative">
										<?php $website_names = array();
										foreach ($Responded_Reviews as $Responded_Review) {
												if ($Responded_Review['hotel_name'] == $hotel_name) {
													array_push($hotel_wise_data[$hotel_name], $Responded_Review);
													array_push($website_names, $Responded_Review['Name']); ?>
													<p class="fw-medium fs-18 mb-1" style="color: blue"><?= ucfirst($Responded_Review['Name']) ?></p>
													<p class="fs-16 mb-1 hotel_wise_positive" style="color: darkcyan" review="<?= $Responded_Review['positive_review'] ?>">Positive: <?= $Responded_Review['positive_review'] ?></p>
													<p class="fs-16 mb-2 hotel_wise_negative" style="color: red" review="<?= $Responded_Review['negative_review'] ?>">Negative: <?= $Responded_Review['negative_review'] ?></p>
										<?php }
										} ?>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<canvas class="view_report_chart" hotel="<?= $hotel_name ?>" width="" height="" id="<?= 'view_report_chart_' . $key ?>"></canvas>
										<img class="view_report_chart_url" hotel="<?= $hotel_name ?>" id="<?= 'view_report_chart_url_' . $key ?>" style="display: none" />
									</div>
								</div>
							</div>
						</div>
						<?php } ?>

						<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
								foreach ($Responded_Reviews as $webIndex=>$Responded_Review) {
									if ($Responded_Review['hotel_name'] == $hotel_name) {?>
						<div class="card">
							<div class="card-body py-2 p-4">
								<div class="row g-2">
									<h2 style="text-align: center;"> Reviews at Site </h2>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 10px; margin-bottom: 10px; width: fit-content">
										<p class="fw-medium fs-24 mb-1" style="color: blue;"><?= ucfirst($Responded_Review['Name']) ?></p>
										<p class="fs-22 mb-1" style="color: darkcyan">Positive: <?= $Responded_Review['positive_review'] ?></p>
										<p class="fs-22 mb-2" style="color: red">Negative: <?= $Responded_Review['negative_review'] ?></p>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<canvas class="website_chart" hotel="<?= $hotel_name ?>" website="<?= $Responded_Review['Name'] ?>" width="" height="" id="<?= 'website_chart_' . $key.$webIndex ?>" positive="<?= $Responded_Review['positive_review'] ?>" negative="<?= $Responded_Review['negative_review'] ?>"></canvas>
										<img class="website_chart_url" hotel="<?= $hotel_name ?>" website="<?= $Responded_Review['Name'] ?>" id="<?= 'website_chart_url_' . $key.$webIndex ?>" style="display: none" />
									</div>
								</div>
							</div>
						</div>
						<?php }
							}
						} ?>

						<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) { ?>
						<div class="card">
							<div class="card-body py-2 p-4">
								<div class="row g-2">
									<h2 style="text-align: center;">Positive Reviews</h2>
									<?php foreach ($Responded_Reviews as $Responded_Review) {
											if ($Responded_Review['hotel_name'] == $hotel_name) { ?>
									<p class="fw-medium fs-20 mb-0" ><?= ucfirst($Responded_Review['Name']) ?></p>
									<p class="text-dark fs-18 mb-1" ><?= ucfirst(strtolower($Responded_Review['positive_description'])) ?></p>
									<?php }
										} ?>
								</div>
							</div>
						</div>
						<?php } ?>

						<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
							$attachments_arr = array();
						?>
						<div class="card">
							<div class="card-body py-2 p-4">
								<div class="row g-2">
									<h2 style="text-align: center;">Reasons for Negative Reviews</h2>
									<div class="row gy-4">
										<?php foreach ($Responded_Reviews as $Responded_Review) {
													if ($Responded_Review['hotel_name'] == $hotel_name) { ?>
										<div class="col-xl-4 col-md-6">
											<blockquote class="blockquote custom-blockquote rounded mb-0" style="background-color: rgb(227 145 61 / 58%); border-color: #e3823d;">
												<p class="text-dark mb-2 fw-medium fs-16 mb-1"><?= ucfirst($Responded_Review['Name']) ?></p>
												<p class="text-dark mb-2 fw-medium fs-14 mb-1"><?= ucfirst(strtolower($Responded_Review['negative_description'])) ?></p>
											</blockquote>
										</div>
											<?php if ($Responded_Review['attachments']!=""){
													$attachments = explode(",",$Responded_Review['attachments']);
													$attachments_arr[$hotel_name] = $attachments;
											} ?>
										<?php }
											} ?>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>

						<?php if (isset($weekly_Responded_Reviews) && !empty($weekly_Responded_Reviews)) { ?>
							<div class="card">
								<div class="card-body py-2 p-4">
									<div class="row g-2">
										<h2 style="text-align: center;"> <?= $weekly_report_title ?> Reviews At Brands</h2>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<?php $positive_reviews = 0; $negative_reviews = 0; $total_reviews = 0;
											foreach ($weekly_Responded_Reviews as $weekly_Responded_Review) {
												if ($weekly_Responded_Review['hotel_name'] == $hotel_name) {
													$positive_reviews += $weekly_Responded_Review['positive_review'];
													$negative_reviews += $weekly_Responded_Review['negative_review'];
													$total_reviews = $total_reviews + $weekly_Responded_Review['positive_review'] + $weekly_Responded_Review['negative_review'];
												}
											} ?>
											<div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 10px; margin-bottom: 10px; width: fit-content">
												<p class="fw-medium fs-24 mb-1" style="color: blue">Total Reviews: <?= $total_reviews ?></p>
												<p class="fs-22 mb-1 weekly_positive_reviews" style="color: darkcyan">Positive Reviews: <?= $positive_reviews ?></p>
												<p class="fs-22 mb-2 weekly_negative_reviews" style="color: red">Negative Reviews: <?= $negative_reviews ?></p>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<canvas class="weekly_report_chart" hotel="<?= $hotel_name ?>" width="" height="" id="<?= 'weekly_report_chart_' . $key ?>" positive="<?= $positive_reviews ?>" negative="<?= $negative_reviews ?>"></canvas>
											<img class="weekly_report_chart_url" hotel="<?= $hotel_name ?>" id="<?= 'weekly_report_chart_url_' . $key ?>" style="display: none" />
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php if (isset($weekly_Responded_Reviews) && !empty($weekly_Responded_Reviews)) {
							if (isset($website_names) && !empty($website_names)){
							foreach ($website_names as $webIndex=>$website_name) {
								$positive_reviews = 0;
								$negative_reviews = 0;
								$total_reviews = 0;
								foreach ($weekly_Responded_Reviews as $weekly_Responded_Review) {
									if ($weekly_Responded_Review['hotel_name'] == $hotel_name && $weekly_Responded_Review['Name'] == $website_name) {
										$positive_reviews += $weekly_Responded_Review['positive_review'];
										$negative_reviews += $weekly_Responded_Review['negative_review'];
										$total_reviews = $total_reviews + $weekly_Responded_Review['positive_review'] + $weekly_Responded_Review['negative_review'];
									}
								}
								?>
								<div class="card">
									<div class="card-body py-2 p-4">
										<div class="row g-2">
											<h2 style="text-align: center;"><?= $weekly_report_title ?> Reviews At <?= ucfirst($website_name) ?></h2>
											<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 10px; margin-bottom: 10px; width: fit-content">
													<p class="fw-medium fs-24 mb-1" style="color: blue;"><?= ucfirst($website_name) ?></p>
													<p class="fs-22 mb-1" style="color: darkcyan">Positive: <?= $positive_reviews ?></p>
													<p class="fs-22 mb-2" style="color: red">Negative: <?= $negative_reviews ?></p>
												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<canvas class="weekly_website_chart" hotel="<?= $hotel_name ?>" website="<?= $website_name ?>" width="" height="" id="<?= 'weekly_website_chart_' . $key.$webIndex ?>" positive="<?= $positive_reviews ?>" negative="<?= $negative_reviews ?>"></canvas>
												<img class="weekly_website_chart_url" hotel="<?= $hotel_name ?>" website="<?= $website_name ?>" id="<?= 'weekly_website_chart_url_' . $key.$webIndex ?>" style="display: none" />
											</div>
										</div>
									</div>
								</div>
							<?php }
							}
						} ?>

						<?php if (isset($monthly_Responded_Reviews) && !empty($monthly_Responded_Reviews)) { ?>
							<div class="card">
								<div class="card-body py-2 p-4">
									<div class="row g-2">
										<h2 style="text-align: center;"> <?= $monthly_report_title ?> Reviews At Brands</h2>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<?php $positive_reviews = 0; $negative_reviews = 0; $total_reviews = 0;
											foreach ($monthly_Responded_Reviews as $monthly_Responded_Review) {
												if ($monthly_Responded_Review['hotel_name'] == $hotel_name) {
													$positive_reviews += $monthly_Responded_Review['positive_review'];
													$negative_reviews += $monthly_Responded_Review['negative_review'];
													$total_reviews = $total_reviews + $monthly_Responded_Review['positive_review'] + $monthly_Responded_Review['negative_review'];
												}
											} ?>
											<div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 10px; margin-bottom: 10px; width: fit-content">
												<p class="fw-medium fs-24 mb-1" style="color: blue">Total Reviews: <?= $total_reviews ?></p>
												<p class="fs-22 mb-1 monthly_positive_reviews" style="color: darkcyan">Positive Reviews: <?= $positive_reviews ?></p>
												<p class="fs-22 mb-2 monthly_negative_reviews" style="color: red">Negative Reviews: <?= $negative_reviews ?></p>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<canvas class="monthly_report_chart" hotel="<?= $hotel_name ?>" width="" height="" id="<?= 'monthly_report_chart_' . $key ?>" positive="<?= $positive_reviews ?>" negative="<?= $negative_reviews ?>"></canvas>
											<img class="monthly_report_chart_url" hotel="<?= $hotel_name ?>" id="<?= 'monthly_report_chart_url_' . $key ?>" style="display: none" />
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php if (isset($monthly_Responded_Reviews) && !empty($monthly_Responded_Reviews)) {
							if (isset($website_names) && !empty($website_names)){
								foreach ($website_names as $webIndex=>$website_name) {
									$positive_reviews = 0;
									$negative_reviews = 0;
									$total_reviews = 0;
									foreach ($monthly_Responded_Reviews as $monthly_Responded_Review) {
										if ($monthly_Responded_Review['hotel_name'] == $hotel_name && $monthly_Responded_Review['Name'] == $website_name) {
											$positive_reviews += $monthly_Responded_Review['positive_review'];
											$negative_reviews += $monthly_Responded_Review['negative_review'];
											$total_reviews = $total_reviews + $monthly_Responded_Review['positive_review'] + $monthly_Responded_Review['negative_review'];
										}
									}
									?>
									<div class="card">
										<div class="card-body py-2 p-4">
											<div class="row g-2">
												<h2 style="text-align: center;"><?= $monthly_report_title ?> Reviews At <?= ucfirst($website_name) ?></h2>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
													<div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 10px; margin-bottom: 10px; width: fit-content">
														<p class="fw-medium fs-24 mb-1" style="color: blue;"><?= ucfirst($website_name) ?></p>
														<p class="fs-22 mb-1" style="color: darkcyan">Positive: <?= $positive_reviews ?></p>
														<p class="fs-22 mb-2" style="color: red">Negative: <?= $negative_reviews ?></p>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
													<canvas class="monthly_website_chart" hotel="<?= $hotel_name ?>" website="<?= $website_name ?>" width="" height="" id="<?= 'monthly_website_chart_' . $key.$webIndex ?>" positive="<?= $positive_reviews ?>" negative="<?= $negative_reviews ?>"></canvas>
													<img class="monthly_website_chart_url" hotel="<?= $hotel_name ?>" website="<?= $website_name ?>" id="<?= 'monthly_website_chart_url_' . $key.$webIndex ?>" style="display: none" />
												</div>
											</div>
										</div>
									</div>
								<?php }
							}
						} ?>

						<?php if (isset($conclusions) && !empty($conclusions)) {
								foreach ($conclusions as $conclusion) {
									if ($conclusion['hotel_name'] == $hotel_name && $conclusion['conclusion'] != "") { ?>
						<div class="card">
							<div class="card-body py-2 p-4">
								<div class="row g-2">
									<h2 style="text-align: left;">Conclusion</h2>
									<p class="fw-medium fs-16 mb-1" ><?= ucfirst(strtolower($conclusion['conclusion'])) ?></p>
								</div>
							</div>
						</div>
						<?php }
							}
						} ?>

						<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews) && isset($attachments_arr) && !empty($attachments_arr)) { ?>
							<div class="card">
								<div class="card-body py-2 p-4">
									<div class="row g-2">
										<h2 style="text-align: center;">Customer Reviews Attachments</h2>
										<?php foreach ($Responded_Reviews as $Responded_Review) {
											if ($Responded_Review['hotel_name'] == $hotel_name && $Responded_Review['attachments']!="") {
												$attachments = explode(",",$Responded_Review['attachments']); ?>
												<?php foreach ($attachments as $attachment){ ?>
												<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
													<a href="<?= base_url('assets/respond_attachments/'.$attachment) ?>" target="_blank"><?= $attachment ?></a>
												</div>
												<?php } ?>
											<?php }
										} ?>
									</div>
								</div>
							</div>
						<?php } ?>

					<?php }
					} else { ?>
							<div class="card">
								<div class="card-body">
									<h4>There is no reviews to respond OR Pending to check</h4>
								</div>
							</div>
					<?php } ?>

					</div>

					<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
						<div class="hstack gap-2 justify-content-end d-print-none mt-4">
							<button id="view_pdf" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</button>
							<button id="send_mail" class="btn btn-success"><i class="ri-mail-send-line align-bottom me-1"></i> Send Mail</button>
						</div>
					</div>

					<div class='loading-ct' style="display: none">
						<div class='part_loading'>
							<i class="mdi mdi-spin mdi-loading fa-3x"></i>
						</div>
					</div>
                </div>
                <!--end row-->

            </div><!-- container-fluid -->
        </div><!-- End Page-content -->

		<?php include 'layouts/footer.php'; ?>
	</div><!-- end main content-->

</div>
<!-- END layout-wrapper -->
<button type="button" id="error_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- Chart JS -->
<script src="<?php echo base_url().'assets/libs/chart.js/chart.min.js'; ?>"></script>
<!-- App js -->
<script src="<?php echo base_url() . 'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
$(document).ready(function (){
	var hotel_wise_data =
			<?= (isset($hotel_wise_data) && !empty($hotel_wise_data)) ? json_encode($hotel_wise_data) : "''" ?>;
	if (hotel_wise_data != '') {
		$.each(hotel_wise_data, function(key, value) {
			view_report_chart(key, value);
		})
	}

	$(".website_chart").each(function() {
		var chart_id = $(this).attr('id');
		website_chart(chart_id);
	})

	$(".weekly_report_chart").each(function() {
		var chart_id = $(this).attr('id');
		weekly_report_chart(chart_id);
	})

	$(".weekly_website_chart").each(function() {
		var chart_id = $(this).attr('id');
		weekly_website_chart(chart_id);
	})

	$(".monthly_report_chart").each(function() {
		var chart_id = $(this).attr('id');
		monthly_report_chart(chart_id);
	})

	$(".monthly_website_chart").each(function() {
		var chart_id = $(this).attr('id');
		monthly_website_chart(chart_id);
	})

	$(".hotel_wise_positive_negative").each(function (){
		var thi = $(this);
		var negative = 0;
		$(thi).find('.hotel_wise_negative').each(function (){
			negative += parseInt($(this).attr('review'));
		})

		var positive = 0;
		$(thi).find('.hotel_wise_positive').each(function (){
			positive += parseInt($(this).attr('review'));
		})

		var total = positive + negative;
		$(thi).prepend(`<p class="fw-medium fs-18 mb-1 hotel_wise_total" style="color: blue" id="hotel_wise_total">Total Reviews: ${total}</p>
						<p class="fs-16 mb-1 hotel_wise_total_positive" style="color: darkcyan" id="hotel_wise_total_positive">Positive: ${positive}</p>
						<p class="fs-16 mb-2 hotel_wise_total_negative" style="color: red" id="hotel_wise_total_negative">Negative: ${negative}</p>`);
	})
})

function view_report_chart(hotel, chart_data){
	// console.log(hotel);
	// console.log(chart_data);
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	Chart.defaults.color = "#000000";

	$(".view_report_chart").html("");

	var dataset_arr = [];
	$(chart_data).each(function (index, value){
		dataset_arr.push({
			label: value.Name,
			backgroundColor: generateRandomColor(),
			data: [value.positive_review, value.negative_review],
			barThickness: 70,
			maxBarThickness: 90,
		})
	})

	var ctx;
	var this_chart;
	$(".view_report_chart").each(function() {
		var chart_id = $(this).attr('id');
		if ($(this).attr('hotel') == hotel) {
			this_chart = chart_id;
			ctx = document.getElementById(chart_id);
		}
	})
	var data = {
		labels: ["Positive", "Negative"],
		datasets: dataset_arr
	};

	ctx.setAttribute("width", ctx.parentElement.offsetWidth);
	var height = '300px';
	if (isMobile) {
		height = '400px';
	}
	ctx.setAttribute("height", height);
	myBarChart = new Chart(ctx, {
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
					text: "",
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
					position: 'top',
					labels: {
						font: {
							size: '14px',
							weight: 'bold'
						},
					}
				}
			},
			scales: {
				y: {
					stacked: true,
					ticks: {
						beginAtZero: true,
						font: {
							size: '14px',
							weight: 'bold'
						}
					},
					type: 'linear',
					title: {
						display: true,
						align: 'center',
						text: 'Review',
						font: {
							weight: 'bold'
						},
					},
				},
				x: {
					stacked: true,
					gridLines: {
						display: false,
					},
					title: {
						display: true,
						align: 'center',
						text: '',
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
			tooltips: {
				displayColors: true,
				callbacks:{
					mode: 'x',
				},
			},
			animation: {
				onComplete: function (){
					$(".view_report_chart_url").each(function() {
						var id = $(this).attr('id');
						var thi = $(this);
						if ($(thi).attr('hotel') == hotel) {
							var url = document.getElementById(this_chart).toDataURL('image/jpg');
							document.getElementById(id).src = url;
						}
					})
				}
			}
		}
	});
}

function website_chart(chart_id){
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	Chart.defaults.color = "#000000";

	$(".website_chart").html("");

	var hotel = $("#"+chart_id).attr('hotel');
	var website = $("#"+chart_id).attr('website');
	var positive = $("#"+chart_id).attr('positive');
	var negative = $("#"+chart_id).attr('negative');

	var data = {
		labels: ["Positive", "Negative"],
		datasets: [{
			label: website,
			backgroundColor: ['green', 'red'],
			data: [positive, negative],
			barThickness: 70,
			maxBarThickness: 90,
		}]
	};

	var ctx = document.getElementById(chart_id);
	ctx.setAttribute("width", ctx.parentElement.offsetWidth);
	var height = '300px';
	if (isMobile) {
		height = '400px';
	}
	ctx.setAttribute("height", height);
	myBarChart = new Chart(ctx, {
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
					text: "",
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
					display: false,
					position: 'top',
					labels: {
						font: {
							size: '14px',
							weight: 'bold'
						},
					}
				}
			},
			scales: {
				y: {
					stacked: true,
					ticks: {
						beginAtZero: true,
						font: {
							weight: 'bold',
							size: '14px',
						},
					},
					type: 'linear',
					title: {
						display: true,
						align: 'center',
						text: 'Review',
						font: {
							weight: 'bold'
						},
					},
				},
				x: {
					// stacked: true,
					gridLines: {
						display: false,
					},
					title: {
						display: true,
						align: 'center',
						text: '',
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
			tooltips: {
				displayColors: true,
				callbacks:{
					mode: 'x',
				},
			},
			animation: {
				onComplete: function (){
					$(".website_chart_url").each(function (){
						var img_id = $(this).attr('id');
						if ($(this).attr('hotel')==hotel && $(this).attr('website')==website){
							var url = document.getElementById(chart_id).toDataURL('image/jpg');
							document.getElementById(img_id).src = url;
						}
					})
				}
			}
		}
	});
}

function weekly_report_chart(chart_id){
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	Chart.defaults.color = "#000000";

	$(".weekly_report_chart").html("");

	var hotel = $("#"+chart_id).attr('hotel');
	var positive = $("#"+chart_id).attr('positive');
	var negative = $("#"+chart_id).attr('negative');

	var data = {
		labels: ["Positive", "Negative"],
		datasets: [{
			label: '',
			backgroundColor: ['green', 'red'],
			data: [positive, negative],
			barThickness: 70,
			maxBarThickness: 90,
		}]
	};

	var ctx = document.getElementById(chart_id);
	ctx.setAttribute("width", ctx.parentElement.offsetWidth);
	var height = '300px';
	if (isMobile) {
		height = '400px';
	}
	ctx.setAttribute("height", height);
	myBarChart = new Chart(ctx, {
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
					text: "",
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
					display: false,
					position: 'top',
					labels: {
						font: {
							size: '14px',
							weight: 'bold'
						},
					}
				}
			},
			scales: {
				y: {
					stacked: true,
					ticks: {
						beginAtZero: true,
						font: {
							weight: 'bold',
							size: '14px',
						},
					},
					type: 'linear',
					title: {
						display: true,
						align: 'center',
						text: 'Review',
						font: {
							weight: 'bold'
						},
					},
				},
				x: {
					// stacked: true,
					gridLines: {
						display: false,
					},
					title: {
						display: true,
						align: 'center',
						text: '',
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
			tooltips: {
				displayColors: true,
				callbacks:{
					mode: 'x',
				},
			},
			animation: {
				onComplete: function (){
					$(".weekly_report_chart_url").each(function (){
						var img_id = $(this).attr('id');
						if ($(this).attr('hotel')==hotel){
							var url = document.getElementById(chart_id).toDataURL('image/jpg');
							document.getElementById(img_id).src = url;
						}
					})
				}
			}
		}
	});
}

function weekly_website_chart(chart_id){
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	Chart.defaults.color = "#000000";

	$(".weekly_website_chart").html("");

	var hotel = $("#"+chart_id).attr('hotel');
	var website = $("#"+chart_id).attr('website');
	var positive = $("#"+chart_id).attr('positive');
	var negative = $("#"+chart_id).attr('negative');

	var data = {
		labels: ["Positive", "Negative"],
		datasets: [{
			label: website,
			backgroundColor: ['green', 'red'],
			data: [positive, negative],
			barThickness: 70,
			maxBarThickness: 90,
		}]
	};

	var ctx = document.getElementById(chart_id);
	ctx.setAttribute("width", ctx.parentElement.offsetWidth);
	var height = '300px';
	if (isMobile) {
		height = '400px';
	}
	ctx.setAttribute("height", height);
	myBarChart = new Chart(ctx, {
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
					text: "",
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
					display: false,
					position: 'top',
					labels: {
						font: {
							size: '14px',
							weight: 'bold'
						},
					}
				}
			},
			scales: {
				y: {
					stacked: true,
					ticks: {
						beginAtZero: true,
						font: {
							weight: 'bold',
							size: '14px',
						},
					},
					type: 'linear',
					title: {
						display: true,
						align: 'center',
						text: 'Review',
						font: {
							weight: 'bold'
						},
					},
				},
				x: {
					// stacked: true,
					gridLines: {
						display: false,
					},
					title: {
						display: true,
						align: 'center',
						text: '',
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
			tooltips: {
				displayColors: true,
				callbacks:{
					mode: 'x',
				},
			},
			animation: {
				onComplete: function (){
					$(".weekly_website_chart_url").each(function (){
						var img_id = $(this).attr('id');
						if ($(this).attr('hotel')==hotel && $(this).attr('website')==website){
							var url = document.getElementById(chart_id).toDataURL('image/jpg');
							document.getElementById(img_id).src = url;
						}
					})
				}
			}
		}
	});
}

function monthly_report_chart(chart_id){
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	Chart.defaults.color = "#000000";

	$(".monthly_report_chart").html("");

	var hotel = $("#"+chart_id).attr('hotel');
	var positive = $("#"+chart_id).attr('positive');
	var negative = $("#"+chart_id).attr('negative');

	var data = {
		labels: ["Positive", "Negative"],
		datasets: [{
			label: '',
			backgroundColor: ['green', 'red'],
			data: [positive, negative],
			barThickness: 70,
			maxBarThickness: 90,
		}]
	};

	var ctx = document.getElementById(chart_id);
	ctx.setAttribute("width", ctx.parentElement.offsetWidth);
	var height = '300px';
	if (isMobile) {
		height = '400px';
	}
	ctx.setAttribute("height", height);
	myBarChart = new Chart(ctx, {
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
					text: "",
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
					display: false,
					position: 'top',
					labels: {
						font: {
							size: '14px',
							weight: 'bold'
						},
					}
				}
			},
			scales: {
				y: {
					stacked: true,
					ticks: {
						beginAtZero: true,
						font: {
							weight: 'bold',
							size: '14px',
						},
					},
					type: 'linear',
					title: {
						display: true,
						align: 'center',
						text: 'Review',
						font: {
							weight: 'bold'
						},
					},
				},
				x: {
					// stacked: true,
					gridLines: {
						display: false,
					},
					title: {
						display: true,
						align: 'center',
						text: '',
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
			tooltips: {
				displayColors: true,
				callbacks:{
					mode: 'x',
				},
			},
			animation: {
				onComplete: function (){
					$(".monthly_report_chart_url").each(function (){
						var img_id = $(this).attr('id');
						if ($(this).attr('hotel')==hotel){
							var url = document.getElementById(chart_id).toDataURL('image/jpg');
							document.getElementById(img_id).src = url;
						}
					})
				}
			}
		}
	});
}

function monthly_website_chart(chart_id){
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	Chart.defaults.color = "#000000";

	$(".monthly_website_chart").html("");

	var hotel = $("#"+chart_id).attr('hotel');
	var website = $("#"+chart_id).attr('website');
	var positive = $("#"+chart_id).attr('positive');
	var negative = $("#"+chart_id).attr('negative');

	var data = {
		labels: ["Positive", "Negative"],
		datasets: [{
			label: website,
			backgroundColor: ['green', 'red'],
			data: [positive, negative],
			barThickness: 70,
			maxBarThickness: 90,
		}]
	};

	var ctx = document.getElementById(chart_id);
	ctx.setAttribute("width", ctx.parentElement.offsetWidth);
	var height = '300px';
	if (isMobile) {
		height = '400px';
	}
	ctx.setAttribute("height", height);
	myBarChart = new Chart(ctx, {
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
					text: "",
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
					display: false,
					position: 'top',
					labels: {
						font: {
							size: '14px',
							weight: 'bold'
						},
					}
				}
			},
			scales: {
				y: {
					stacked: true,
					ticks: {
						beginAtZero: true,
						font: {
							weight: 'bold',
							size: '14px',
						},
					},
					type: 'linear',
					title: {
						display: true,
						align: 'center',
						text: 'Review',
						font: {
							weight: 'bold'
						},
					},
				},
				x: {
					// stacked: true,
					gridLines: {
						display: false,
					},
					title: {
						display: true,
						align: 'center',
						text: '',
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
			tooltips: {
				displayColors: true,
				callbacks:{
					mode: 'x',
				},
			},
			animation: {
				onComplete: function (){
					$(".monthly_website_chart_url").each(function (){
						var img_id = $(this).attr('id');
						if ($(this).attr('hotel')==hotel && $(this).attr('website')==website){
							var url = document.getElementById(chart_id).toDataURL('image/jpg');
							document.getElementById(img_id).src = url;
						}
					})
				}
			}
		}
	});
}

function filterViewReportDataBycustomer() {
	var user_id = $('#users_dropdown').val();
	var user_name = $('#users_dropdown option:selected').html();
	var hotel_id = $('#own_hotels_dropdown').val();
	var date = $("#view_report_date").val();
	var thi = $(this);

	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});

	$.ajax({
		url: "<?= base_url('filter_view_report') ?>",
		method: "POST",
		data: {
			"user_id": user_id,
			"user_name": user_name,
			"date": date,
			"hotel_id": hotel_id,
		},
		beforeSend: function(jqXHR) {
			xhrPool.push(jqXHR);
			$("#pdf_content").find('.loading-ct').show();
		},
		success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				$("#view_report_data").html("");
				$("#view_report_data").html(res.html);

				if (!$.isEmptyObject(res.hotel_wise_data)) {
					$.each(res.hotel_wise_data, function(key, value) {
						view_report_chart(key, value);
					})
				}

				$(".website_chart").each(function() {
					var chart_id = $(this).attr('id');
					website_chart(chart_id);
				})

				$(".weekly_report_chart").each(function() {
					var chart_id = $(this).attr('id');
					weekly_report_chart(chart_id);
				})

				$(".weekly_website_chart").each(function() {
					var chart_id = $(this).attr('id');
					weekly_website_chart(chart_id);
				})

				$(".monthly_report_chart").each(function() {
					var chart_id = $(this).attr('id');
					monthly_report_chart(chart_id);
				})

				$(".monthly_website_chart").each(function() {
					var chart_id = $(this).attr('id');
					monthly_website_chart(chart_id);
				})

				$(".hotel_wise_positive_negative").each(function (){
					var thi = $(this);
					var negative = 0;
					$(thi).find('.hotel_wise_negative').each(function (){
						negative += parseInt($(this).attr('review'));
					})

					var positive = 0;
					$(thi).find('.hotel_wise_positive').each(function (){
						positive += parseInt($(this).attr('review'));
					})

					var total = positive + negative;
					$(thi).prepend(`<p class="fw-medium fs-18 mb-1 hotel_wise_total" style="color: blue" id="hotel_wise_total">Total Reviews: ${total}</p>
						<p class="fs-16 mb-1 hotel_wise_total_positive" style="color: darkcyan" id="hotel_wise_total_positive">Positive: ${positive}</p>
						<p class="fs-16 mb-2 hotel_wise_total_negative" style="color: red" id="hotel_wise_total_negative">Negative: ${negative}</p>`);
				})
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

		},
		complete: function(data) {
			$("#pdf_content").find('.loading-ct').hide();
		}
	});
}

$(document).on('change', '#view_report_date', function() {
	filterViewReportDataBycustomer();
})

$(document).on('click', '#view_pdf', function (){
	var url = "<?= base_url('view_report_pdf') ?>";
	// location.href = url;

	$(this).attr('disabled', 'disabled');
	var thi = $(this);

	var formData = new FormData();
	formData.append('user_id', $("#users_dropdown").val());
	formData.append('hotel_id', $("#own_hotels_dropdown").val());
	formData.append('date', $("#view_report_date").val());
	formData.append('hotel_name', $("#own_hotels_dropdown option:selected").html());
	formData.append('user_name', $("#users_dropdown option:selected").html());
	$(".view_report_chart_url").each(function (index, value){
		formData.append('view_report_chart_urls[]', $(this).attr('src'));
	})
	$(".website_chart_url").each(function (index, value){
		formData.append('website_chart_urls[]', $(this).attr('src'));
	})
	$(".weekly_report_chart_url").each(function (index, value){
		formData.append('weekly_report_chart_urls[]', $(this).attr('src'));
	})
	$(".weekly_website_chart_url").each(function (index, value){
		formData.append('weekly_website_chart_urls[]', $(this).attr('src'));
	})
	$(".monthly_report_chart_url").each(function (index, value){
		formData.append('monthly_report_chart_urls[]', $(this).attr('src'));
	})
	$(".monthly_website_chart_url").each(function (index, value){
		formData.append('monthly_website_chart_urls[]', $(this).attr('src'));
	})
	$(".hotel_wise_positive_negative").each(function (index, value){
		formData.append('hotel_wise_totals[]', $(this).find('.hotel_wise_total').html());
		formData.append('hotel_wise_total_positives[]', $(this).find('.hotel_wise_total_positive').html());
		formData.append('hotel_wise_total_negatives[]', $(this).find('.hotel_wise_total_negative').html());
	})

	$.ajax({
		url: url,
		method: "POST",
		data: formData,
		// cache: false,
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
	formData.append('date', $("#view_report_date").val());
	formData.append('hotel_name', $("#own_hotels_dropdown option:selected").html());
	formData.append('user_name', $("#users_dropdown option:selected").html());
	$(".view_report_chart_url").each(function (index, value){
		formData.append('view_report_chart_urls[]', $(this).attr('src'));
	})
	$(".website_chart_url").each(function (index, value){
		formData.append('website_chart_urls[]', $(this).attr('src'));
	})
	$(".weekly_report_chart_url").each(function (index, value){
		formData.append('weekly_report_chart_urls[]', $(this).attr('src'));
	})
	$(".weekly_website_chart_url").each(function (index, value){
		formData.append('weekly_website_chart_urls[]', $(this).attr('src'));
	})
	$(".monthly_report_chart_url").each(function (index, value){
		formData.append('monthly_report_chart_urls[]', $(this).attr('src'));
	})
	$(".monthly_website_chart_url").each(function (index, value){
		formData.append('monthly_website_chart_urls[]', $(this).attr('src'));
	})
	$(".hotel_wise_positive_negative").each(function (index, value){
		formData.append('hotel_wise_totals[]', $(this).find('.hotel_wise_total').html());
		formData.append('hotel_wise_total_positives[]', $(this).find('.hotel_wise_total_positive').html());
		formData.append('hotel_wise_total_negatives[]', $(this).find('.hotel_wise_total_negative').html());
	})

	$.ajax({
		url: "<?= base_url('send_mail_view_report') ?>",
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

function generateRandomColor() {
	var letters = '0123456789ABCDEF';
	var color = '#';
	for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	}
	return color;
}
</script>

</body>
</html>
