<html>
<head>
	<title>Review Report</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- Icons Css -->
	<link href="<?php echo base_url().'assets/css/icons.min.css'; ?>" rel="stylesheet" type="text/css" />
	<!-- App Css-->
	<link href="<?php echo base_url().'assets/css/app.min.css'; ?>" id="app-style" rel="stylesheet" type="text/css" />
	<!-- custom Css-->
	<link href="<?php echo base_url().'assets/css/custom.min.css'; ?>" id="app-style" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url().'assets/css/my_custom.css'; ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<style type="text/css">
		#pdf_view_div {
			display: grid;
			page-break-inside: avoid;
		}
	</style>
</head>

<body>
<div class="container-fluid">
	<div class="row justify-content-center" id="pdf_view_div">
		<div class="col-12">
<!--			<div class="card">-->
				<div class="card-header border-bottom-dashed" id="psmtech_logo">
					<div class="d-sm-flex">
						<div class="flex-grow-1">
							<img src="<?= base_url() . 'assets/images/psmtech_logo.png' ?>" class="card-logo card-logo-dark" alt="logo dark" height="50">
						</div>
					</div>
				</div>
				<!--end card-header-->
				<div class="card-body py-2 p-4">
					<div class="row">
						<div class="col-12">
							<p class="m-0 fs-22" id="client_name" style="text-align: left; font-weight: bold"><?= $user_name ?> Review Report</p>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<p class="m-0" id="respond_date" style="text-align: left; "><?= $respond_date ?></p>
						</div>
					</div>
				</div>
				<div id="table_chart_review_report_div">
					<?php $hotel_wise_data = array(); ?>
					<?php if (isset($hotel_names) && !empty($hotel_names)) {
						$i = 0;
						foreach ($hotel_names as $key => $hotel_name) {
							$hotel_wise_data[$hotel_name] = array();
							$class = "";
							if ($i!=0){
								$class = "border-top border-top-dashed";
							} ?>
							<div class="card-body py-2 p-4 <?= $class ?>">
								<div style="page-break-inside: avoid;">
								<p class="mt-2 mb-3 fs-21" style="font-weight: bold; border-bottom: 3px double darkblue;border-top: 3px double darkblue; color: blue; padding-top: 10px; padding-bottom: 10px"><?= $hotel_name ?></p>
								<?php if (isset($chart_urls) && !empty($chart_urls) && isset($chart_urls[$i])) { ?>
								<div class="row">
									<div class="col-12">
										<img class="review_report_chart_url" hotel="<?= $hotel_name ?>" id="<?= 'review_report_chart_url_' . $key ?>" src="<?= $chart_urls[$i] ?>" style="width: 100%;"/>
									</div>
								</div>
								<?php } ?>
								</div>

								<div class="row g-2 mb-1 mt-2">
									<div class="col-lg-12 col-12">
										<div class="table-responsive">
											<table cellpadding="10" id="review_report_pdf_table">
												<thead>
												<tr>
													<th>Website</th>
													<th>Positive Review</th>
													<th>Negative Review</th>
													<th>Total Review</th>
													<th>Notes</th>
												</tr>
												</thead>
												<tbody>
												<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
													foreach ($Responded_Reviews as $Responded_Review) {
														if ($Responded_Review['hotel_name'] == $hotel_name) {
															array_push($hotel_wise_data[$hotel_name], $Responded_Review); ?>
															<tr>
																<td class="fs-16"><?= ucfirst($Responded_Review['Name']) ?></td>
																<td class="fs-16"><?= $Responded_Review['positive_review'] ?></td>
																<td class="fs-16"><?= $Responded_Review['negative_review'] ?></td>
																<td class="fs-16"><?= $Responded_Review['total_reviews'] ?></td>
																<td class="fs-16"><?= ucfirst(strtolower($Responded_Review['notes'])) ?></td>
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
							<div class="card-body p-4">
								<div class="row g-3">
									<div class="col-sm-12" style="page-break-inside: avoid;">
										<p class="mt-0 mb-0 fs-20" style="font-weight: bold; border-bottom: 3px solid darkgreen;border-top: 3px solid darkgreen; color: green; padding-top: 10px; padding-bottom: 10px">Positive Review Feedback:</p>
										<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
											foreach ($Responded_Reviews as $Responded_Review) {
												if ($Responded_Review['hotel_name'] == $hotel_name) { ?>
													<div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 10px; margin-bottom: 10px">
													<p class="fw-medium fs-18 mb-0" style="color: navy;"><?= ucfirst($Responded_Review['Name']) ?>:</p>
													<p class="fs-16 mb-0"><?= ucfirst(strtolower($Responded_Review['positive_description'])) ?></p>
													</div>
												<?php }
											}
										} ?>
									</div>
									<!--end col-->

									<div class="col-sm-12" style="page-break-inside: avoid;">
										<p class="mt-3 mb-0 fs-20" style="font-weight: bold; border-bottom: 3px solid darkred;border-top: 3px solid darkred; color: red; padding-top: 10px; padding-bottom: 10px">Negative Review Feedback:</p>
										<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
											foreach ($Responded_Reviews as $Responded_Review) {
												if ($Responded_Review['hotel_name'] == $hotel_name) { ?>
													<div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; margin-top: 10px; margin-bottom: 10px">
													<p class="fw-medium fs-18 mb-0" style="color: navy"><?= ucfirst($Responded_Review['Name']) ?>:</p>
													<p class="fs-16 mb-0"><?= ucfirst(strtolower($Responded_Review['negative_description'])) ?></p>
													</div>
												<?php }
											}
										} ?>
									</div>
									<!--end col-->

									<div class="col-sm-12" style="page-break-inside: avoid;">
										<?php if (isset($conclusions) && !empty($conclusions)) {
											foreach ($conclusions as $conclusion) {
												if ($conclusion['hotel_name'] == $hotel_name && $conclusion['conclusion'] != "") { ?>
													<p class="mt-0 mb-0 fs-20" style="font-weight: bold">Conclusion</p>
													<p class="fs-16 mb-2"><?= ucfirst(strtolower($conclusion['conclusion'])) ?></p>
												<?php }
											}
										} ?>
									</div>

								</div>
								<!--end row-->
							</div>
							<!--end card-body-->
						<?php $i++;
						}
					} else { ?>
						<div class="card-body p-4">
							<div class="row g-3">
								<div class="col-sm-12">
									<h4>There is no reviews to respond OR Pending to check</h4>
								</div>
							</div>
						</div>
					<?php } ?>
					<!--end card-body-->
				</div>

				<div class="card-footer border-top-dashed" style="page-break-inside: avoid;">
					<div class="d-sm-flex">
						<div class="flex-grow-1">
							<div class="mt-sm-3 mt-2">
								<h6 class="text-muted fs-22 fw-bold">Address</h6>
								<p class="text-muted mb-1">371 South Swing Road, PI Greensboro, NC-27409</p>
								<p class="text-muted mb-1">E-mail: info@psmtech.com </p>
								<p class="text-muted mb-0">Phone: (336)-285-9178, (336)-285-9177</p>
							</div>
						</div>
					</div>
				</div>
<!--			</div>-->
			<!--end card-->
		</div>
		<!--end col-->
	</div>
	<!--end row-->
</div>

</body>
</html>
