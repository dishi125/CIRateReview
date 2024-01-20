<html>
<head>
	<title>View Report</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
	<meta content="Themesbrand" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/images/logo_inngenius.ico'); ?>">
	<link href="<?php echo base_url().'assets/css/bootstrap.min.css'; ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<!--	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
	<!-- Icons Css -->
	<link href="<?php echo base_url().'assets/css/icons.min.css'; ?>" rel="stylesheet" type="text/css" />
	<!-- App Css-->
	<link href="<?php echo base_url().'assets/css/app.min.css'; ?>" id="app-style" rel="stylesheet" type="text/css" />
	<!-- custom Css-->
	<link href="<?php echo base_url().'assets/css/custom.min.css'; ?>" id="app-style" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="<?php echo base_url().'assets/css/my_custom.css'; ?>" rel="stylesheet" type="text/css" />
	<style type="text/css">
		/*#pdf_view_div {
			display: grid;
			page-break-inside: avoid;
		}*/
		/*.custom_row:after {
			content: "";
			display: table;
			clear: both;
		}
		.column {
			float: left;
			width: 50%;
		}*/
		.row, .col-6, .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
			margin: 0 !important;
			padding:0 !important;
		}
	</style>
</head>

<body>
<div class="container" id="pdf_view_div">
	<?php if (isset($hotel_names) && !empty($hotel_names)) {
	$i = 0;
	$web_i = 0;
	$weekly_web_i = 0;
	$monthly_web_i = 0;
	foreach ($hotel_names as $key => $hotel_name) {

	$key = array_search($hotel_name, array_column($Responded_Reviews, 'hotel_name'));
	if (!empty($key) || $key === 0) {
		if ($Responded_Reviews[$key]['image']!="" && file_exists(FCPATH.'assets/hotel_cover_picture'.'/'.$Responded_Reviews[$key]['image'])) {
			$hotel_image = base_url('assets/hotel_cover_picture/'.$Responded_Reviews[$key]['image']);
		}
		else {
			$hotel_image = base_url('assets/images/default_hotel_cover.webp');
		}

		if ($Responded_Reviews[$key]['logo']!="" && file_exists(FCPATH.'assets/hotel_logo'.'/'.$Responded_Reviews[$key]['logo'])) {
			$hotel_logo = base_url('assets/hotel_logo/'.$Responded_Reviews[$key]['logo']);
		}
		else {
			$hotel_logo = base_url('assets/images/default_hotel_logo.jpg');
		}

		$hotel_state = $Responded_Reviews[$key]['state'];
		$hotel_city = $Responded_Reviews[$key]['city'];
		$hotel_address = $Responded_Reviews[$key]['address'];
	}
	?>

	<?php if ($key!=0){ ?>
	<pagebreak>
	<?php } ?>
	<div style="text-align: center;background: #d3d3d3;border: 1px solid #0e96e5;border-right: none;border-left: none;margin:5px">
		<img src="<?= $hotel_logo ?>" alt="logo dark" height="80" width="80" style="float: left;">
		<span style="font-size: 44px; font-weight: bold; color: #000080;">Review Report</span>
	</div>
	<div style="width: 100%;padding-top: 10px">
		<div align="left" style="width: 46%;float: left; height: 550px;box-shadow: 0 0 10px 5px;margin-left: 15px;padding:5px;border-bottom: 4px solid #d7cece;">
			<img src="<?= $hotel_image ?>" alt="logo dark" style="width: 100%; height: 550px;">
		</div>
		<div align="left" style="width: 50%;">
			<h1 style="margin: 10px 0; padding-left: 20px; padding-right: 20px; font-size: 35px;color: #000099;font-weight: bold;"><?= ucfirst(strtolower($hotel_name)) ?></h1>
			<h1 style="margin: 10px 0; color: #1a1aff; padding-left: 20px; padding-right: 25px; font-size: 20px;font-weight:600"><?= $hotel_state ?>, <?= $hotel_city ?>, <?= $hotel_address ?></h1>
			<h1 style="margin: 10px 0; color: #485056cc; padding-left: 20px; padding-right: 20px;font-weight:400; font-size: 18px;">Date: <?= date("j F, Y", strtotime($date)) ?></h1>

			<div style="margin-top: 220px; text-align: right; border-bottom: 4px solid #d7cece; border-radius: 5px; padding: 10px; margin-left: 200px; margin-right: 30px;">
				<p style="font-weight: bold;">Presented By,</p>
				<img src="<?= base_url('assets/images/psmtech_logo.png') ?>" class="card-logo card-logo-dark" alt="logo dark" height="50">
				<p style="margin:0px">South Swing Road, PI Greensboro, NC-27409</p><p style="margin:0px">E-mail: info@psmtech.com </p><p style="margin:0px">Phone: (336)-285-9178, (336)-285-9177</p>
			</div>
		</div>
	</div>

	<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
	$Responded_Reviews_name = array_column($Responded_Reviews, 'hotel_name');
	$count_Responded_Reviews = count(array_keys($Responded_Reviews_name, $hotel_name));
	?>
	<pagebreak>
	<div style="text-align: center;background: #d3d3d3;border: 1px solid #0e96e5;border-right: none;border-left: none;margin:5px">
		<img src="<?= $hotel_logo ?>" alt="logo dark" height="80" width="80" style="float: left;">
		<span style="font-size: 44px; font-weight: bold; color: navy;"><?= ucfirst(strtolower($hotel_name)) ?></span>
	</div>
	<div style="width: 100%;margin-left: 20px">
		<p style="text-align: center; font-size: 35px; font-weight: bold; margin: 0;text-decoration: underline double;margin-top: 0px;"> Reviews at Site </p>
		<?php if ($count_Responded_Reviews <= 3) { ?>
		<div align="left" style="width: 50%;float: left;">
			<div style="margin-top: 50px;">
				<div style="padding: 10px; width: fit-content!important; margin: 10px;border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-right: 10px;">
				<p class="fw-bolder mb-1" style="color: #000; margin-left: 10px;font-size: 24px;font-weight: bold"><?= $hotel_wise_totals[$i] ?></p>
				<p class="mb-1" style="color: green; margin-left: 10px;font-size: 20px"><?= $hotel_wise_total_positives[$i] ?></p>
				<p class="mb-1" style="color: red; margin-left: 10px;font-size: 20px"><?= $hotel_wise_total_negatives[$i] ?></p>
				</div>
			<?php $website_names = array();
				foreach ($Responded_Reviews as $Responded_Review) {
				if ($Responded_Review['hotel_name'] == $hotel_name) {
					array_push($website_names, $Responded_Review['Name']); ?>
				<div style="border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-top: 15px;margin-left: 10px;">
					<p class="fw-bolder mb-1" style="color: #000; margin-left: 10px; font-size: 24px;font-weight: bold"><?= ucfirst($Responded_Review['Name']) ?></p>
					<p class="mb-1" style="color: green; margin-left: 10px;font-size: 20px">Positive: <?= $Responded_Review['positive_review'] ?></p>
					<p class="mb-1" style="color: red; margin-left: 10px;font-size: 20px">Negative: <?= $Responded_Review['negative_review'] ?></p>
				</div>
				<?php }
			} ?>
			</div>
		</div>
		<?php if (isset($view_report_chart_urls) && !empty($view_report_chart_urls) && isset($view_report_chart_urls[$i])) { ?>
		<div align="left" style="width: 46%;float: right;box-shadow: inset 0 0 0 4px rgb(0 0 0 / 15%);margin:50px 10px 10px 10px">
			<img id="view_report_chart_url" src="<?= $view_report_chart_urls[$i] ?>" style="width: 100%;margin-right: 10px;height: 100%"/>
		</div>
		<?php }
		} else { ?>
			<div align="left" style="width: 25%;float: left;">
				<div style="margin-top: 50px">
					<div style="border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px); margin-top: 15px;">
						<p class="fw-bolder mb-1" style="color: #000; margin-left: 10px;font-size: 24px;font-weight: bold"><?= $hotel_wise_totals[$i] ?></p>
						<p class="mb-1" style="color: green; margin-left: 10px;font-size: 20px"><?= $hotel_wise_total_positives[$i] ?></p>
						<p class="mb-1" style="color: red; margin-left: 10px;font-size: 20px"><?= $hotel_wise_total_negatives[$i] ?></p>
					</div>
					<?php
					$cnt_start = 1;
					$displayed_responds = array();
					$website_names = array();
					foreach ($Responded_Reviews as $respond_key=>$Responded_Review) {
						if ($cnt_start > 3){
							break;
						}
						if ($Responded_Review['hotel_name'] == $hotel_name && $cnt_start <= 3) {
							array_push($website_names, $Responded_Review['Name']); ?>
					<div style="border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-top: 15px;">
						<p class="fw-bolder mb-1" style="color: #000; margin-left: 10px; font-size: 24px;font-weight: bold"><?= ucfirst($Responded_Review['Name']) ?></p>
						<p class="mb-1" style="color: green; margin-left: 10px;font-size: 20px">Positive: <?= $Responded_Review['positive_review'] ?></p>
						<p class="mb-1" style="color: red; margin-left: 10px;font-size: 20px">Negative: <?= $Responded_Review['negative_review'] ?></p>
					</div>
					<?php array_push($displayed_responds, $respond_key);
						$cnt_start++;
					}
					} ?>
				</div>
			</div>
			<div align="left" style="width: 25%;float: left;">
				<div style="margin-top: 50px">
					<?php
					foreach ($Responded_Reviews as $respond_key=>$Responded_Review) {
						if ($Responded_Review['hotel_name'] == $hotel_name && !in_array($respond_key, $displayed_responds)) {
							array_push($website_names, $Responded_Review['Name']); ?>
					<div style="border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-top: 15px;margin-left:2px;">
						<p class="fw-bolder mb-1" style="color: #000; margin-left: 10px;font-size: 24px;font-weight: bold"><?= ucfirst($Responded_Review['Name']) ?></p>
						<p class="mb-1" style="color: green;margin-left: 10px;font-size: 20px">Positive: <?= $Responded_Review['positive_review'] ?></p>
						<p class="mb-1" style="color: red;margin-left: 10px;font-size: 20px">Negative: <?= $Responded_Review['negative_review'] ?></p>
					</div>
					<?php }
					} ?>
				</div>
			</div>
			<?php if (isset($view_report_chart_urls) && !empty($view_report_chart_urls) && isset($view_report_chart_urls[$i])) { ?>
			<div align="left" style="width: 46%;float: right;box-shadow: inset 0 0 0 4px rgb(0 0 0 / 15%);margin:50px 10px 10px 10px">
				<img id="view_report_chart_url" src="<?= $view_report_chart_urls[$i] ?>" style="width: 100%; height: 100%"/>
			</div>
			<?php } ?>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
	$attachments_arr = array();
	foreach ($Responded_Reviews as $webIndex=>$Responded_Review) {
	if ($Responded_Review['hotel_name'] == $hotel_name) {
		if ($Responded_Review['attachments']!=""){
			$attachments = explode(",",$Responded_Review['attachments']);
			$attachments_arr[$hotel_name] = $attachments;
		}
	?>
	<pagebreak>
	<div style="text-align: center;background: #d3d3d3;border: 1px solid #0e96e5;border-right: none;border-left: none;margin:5px">
		<img src="<?= $hotel_logo ?>" alt="logo dark" height="80" width="80" style="float: left;">
		<span style="font-size: 44px; font-weight: bold; color: navy;"><?= ucfirst(strtolower($hotel_name)) ?></span>
	</div>
	<div style="width: 100%;margin-left: 20px;margin-right: 20px;">
		<p style="text-align: center; font-size: 30px; font-weight: bold; margin: 0;text-decoration: underline double;margin-top: 10px;"><?= ucfirst($Responded_Review['Name']) ?> Reviews </p>
		<div align="left" style="width: 50%;float: left;">
			<div style="border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-top: 60px">
			<p class="mb-2" style="color: green;margin-left: 10px; font-size: 24px">Positive: <?= $Responded_Review['positive_review'] ?></p>
			<p class="" style="color: red;margin-left: 10px;font-size: 24px">Negative: <?= $Responded_Review['negative_review'] ?></p>
			</div>
		</div>
		<div align="left" style="width: 46%;float: right;">
			<div style="box-shadow: inset 0 0 0 4px rgb(0 0 0 / 15%);margin:50px 10px 10px 10px">
				<img id="website_chart_url" src="<?= $website_chart_urls[$web_i] ?>" style="width: 100%;margin-right: 10px; height: 100%"/>
			</div>
			<div style="width: 100%;margin-left: 20px;margin-right: 20px;">
				<div align="left" style="width: 14%;float: left;margin-left: 100px">Positive</div>
				<div align="left" style="width: 10%;float: left;height: 20px;background: green; margin-left: 10px"></div>
				<div align="left" style="width: 14%;float: left;margin-left: 40px">Negative</div>
				<div align="left" style="width: 10%;float: left;height: 20px;background: red; margin-left: 10px"></div>
			</div>
		</div>
	</div>
	<div style="page-break-inside: avoid;">
		<div style="border: 1px solid black; border-radius: 5px; padding: 5px; margin:15px 5px 20px 20px;">
			<p style="text-align: left; font-size: 24px; font-weight: bold;color: green;" class="mt-0 mb-0"><u>Positive Review Description</u> </p>
			<p class="fs-18 mt-0 mb-0" style=""><?= ucfirst(strtolower($Responded_Review['positive_description'])) ?></p>
		</div>
		<div style="border: 1px solid black; border-radius: 5px; padding: 5px; margin:5px 5px 20px 20px;">
			<p style="text-align: left; font-size: 24px; font-weight: bold;color: red;" class="mt-0 mb-0"><u>Reasons for Negative Reviews</u> </p>
			<p class="fs-18 mt-0 mb-0" style=""><?= ucfirst(strtolower($Responded_Review['negative_description'])) ?></p>
		</div>
	</div>
	<?php
	$web_i++;
	}
	}
	}?>

	<?php if (isset($weekly_Responded_Reviews) && !empty($weekly_Responded_Reviews)) { ?>
		<pagebreak>
		<div style="text-align: center;background: lightgrey;">
			<img src="<?= $hotel_logo ?>" alt="logo dark" height="80" width="80" style="float: left;">
			<span style="font-size: 44px; font-weight: bold; color: navy;"><?= ucfirst(strtolower($hotel_name)) ?></span>
		</div>
		<div style="width: 100%;margin-left: 20px;margin-right: 20px;">
			<p style="text-align: center; font-size: 30px; font-weight: bold; margin: 0;text-decoration: underline double;margin-top: 10px;"><?= $weekly_report_title ?> Reviews At Brands</p>
			<div align="left" style="width: 50%;float: left;">
				<?php $positive_reviews = 0; $negative_reviews = 0; $total_reviews = 0;
				foreach ($weekly_Responded_Reviews as $weekly_Responded_Review) {
					if ($weekly_Responded_Review['hotel_name'] == $hotel_name) {
						$positive_reviews += $weekly_Responded_Review['positive_review'];
						$negative_reviews += $weekly_Responded_Review['negative_review'];
						$total_reviews = $total_reviews + $weekly_Responded_Review['positive_review'] + $weekly_Responded_Review['negative_review'];
					}
				} ?>
				<div style="text-align: center;border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-top: 150px">
					<p class="mb-2" style="text-align: center;color: #000;margin-left: 10px; font-size: 24px;font-weight: bold">Total Reviews: <?= $total_reviews ?></p>
					<p class="mb-2" style="text-align: center;color: green;margin-left: 10px; font-size: 24px">Positive Reviews: <?= $positive_reviews ?></p>
					<p class="" style="text-align: center;color: red;margin-left: 10px; font-size: 24px">Negative Reviews: <?= $negative_reviews ?></p>
				</div>
			</div>
			<div align="left" style="width: 46%;float: right;">
				<div style="box-shadow: inset 0 0 0 4px rgb(0 0 0 / 15%);margin:50px 10px 10px 10px">
					<img id="weekly_chart_url" src="<?= $weekly_chart_urls[$i] ?>" style="width: 100%;margin-right: 10px; height: 100%"/>
				</div>			
				<div style="width: 100%;margin-left: 20px;margin-right: 20px;margin-bottom: 10px">
					<div align="left" style="width: 14%;float: left;margin-left: 100px">Positive</div>
					<div align="left" style="width: 10%;float: left;height: 20px;background: green; margin-left: 10px"></div>
					<div align="left" style="width: 14%;float: left;margin-left: 40px">Negative</div>
					<div align="left" style="width: 10%;float: left;height: 20px;background: red; margin-left: 10px"></div>
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
				} ?>
			<pagebreak>
			<div style="text-align: center;background: #d3d3d3;border: 1px solid #0e96e5;border-right: none;border-left: none;margin:5px">
				<img src="<?= $hotel_logo ?>" alt="logo dark" height="80" width="80" style="float: left;">
				<span style="font-size: 44px; font-weight: bold; color: navy;"><?= ucfirst(strtolower($hotel_name)) ?></span>
			</div>
			<div style="width: 100%;margin-left: 20px;margin-right: 20px;">
				<p style="text-align: center; font-size: 30px; font-weight: bold; margin: 0;text-decoration: underline double;margin-top: 10px;"><?= $weekly_report_title ?> Reviews At <?= ucfirst($website_name) ?></p>
				<div align="left" style="width: 50%;float: left;">
					<div style="text-align: center;border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-top: 150px">
						<p class="mb-2" style="text-align: center;color: green;margin-left: 10px; font-size: 24px">Positive: <?= $positive_reviews ?></p>
						<p class="" style="text-align: center;color: red;margin-left: 10px;font-size: 24px">Negative: <?= $negative_reviews ?></p>
					</div>
				</div>
				<div align="left" style="width: 46%;float: right;">
					<div style="box-shadow: inset 0 0 0 4px rgb(0 0 0 / 15%);margin:50px 10px 10px 10px">
						<img id="website_chart_url" src="<?= $weekly_website_chart_urls[$weekly_web_i] ?>" style="width: 100%;margin-right: 10px; height: 100%"/>
					</div>
					<div style="width: 100%;margin:35px 10px 20px 20px;">
						<div align="left" style="width: 14%;float: left;margin-left: 100px">Positive</div>
						<div align="left" style="width: 10%;float: left;height: 20px;background: green; margin-left: 10px"></div>
						<div align="left" style="width: 14%;float: left;margin-left: 40px">Negative</div>
						<div align="left" style="width: 10%;float: left;height: 20px;background: red; margin-left: 10px"></div>
					</div>
				</div>
			</div>
	<?php $weekly_web_i++;
			}
		}
	} ?>

	<?php if (isset($monthly_Responded_Reviews) && !empty($monthly_Responded_Reviews)) { ?>
	<pagebreak>
	<div style="text-align: center;background: #d3d3d3;border: 1px solid #0e96e5;border-right: none;border-left: none;margin:5px">
		<img src="<?= $hotel_logo ?>" alt="logo dark" height="80" width="80" style="float: left;">
		<span style="font-size: 44px; font-weight: bold; color: navy;"><?= ucfirst(strtolower($hotel_name)) ?></span>
	</div>
	<div style="width: 100%;margin-left: 20px;margin-right: 20px;">
		<p style="text-align: center; font-size: 30px; font-weight: bold; margin: 0;text-decoration: underline double;margin-top: 10px;"><?= $monthly_report_title ?> Reviews At Brands</p>
		<div align="left" style="width: 50%;float: left;">
			<?php $positive_reviews = 0; $negative_reviews = 0; $total_reviews = 0;
			foreach ($monthly_Responded_Reviews as $monthly_Responded_Review) {
				if ($monthly_Responded_Review['hotel_name'] == $hotel_name) {
					$positive_reviews += $monthly_Responded_Review['positive_review'];
					$negative_reviews += $monthly_Responded_Review['negative_review'];
					$total_reviews = $total_reviews + $monthly_Responded_Review['positive_review'] + $monthly_Responded_Review['negative_review'];
				}
			} ?>
			<div style="text-align: center;border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-top: 150px; padding-right: 10px;">
				<p class="mb-2" style="text-align: center;color: #000;margin-left: 10px; font-size: 24px;font-weight: bold;">Total Reviews: <?= $total_reviews ?></p>
				<p class="mb-2" style="color: green;margin-left: 10px; font-size: 24px">Positive Reviews: <?= $positive_reviews ?></p>
				<p class="" style="text-align: center;color: red;margin-left: 10px; font-size: 20px">Negative Reviews: <?= $negative_reviews ?></p>
			</div>
		</div>
		<div align="left" style="width: 46%;float: right;">
			<div style="box-shadow: inset 0 0 0 4px rgb(0 0 0 / 15%);margin:50px 10px 20px 10px">
				<img id="monthly_chart_url" src="<?= $monthly_chart_urls[$i] ?>" style="width: 100%;margin-right: 10px; height: 100%"/>
			</div>
			<div style="width: 100%;margin:35px 10px 20px 20px;">
				<div align="left" style="width: 14%;float: left;margin-left: 100px">Positive</div>
				<div align="left" style="width: 10%;float: left;height: 20px;background: green; margin-left: 10px"></div>
				<div align="left" style="width: 14%;float: left;margin-left: 40px">Negative</div>
				<div align="left" style="width: 10%;float: left;height: 20px;background: red; margin-left: 10px"></div>
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
	} ?>
	<pagebreak>
	<div style="text-align: center;background: #d3d3d3;border: 1px solid #0e96e5;border-right: none;border-left: none;margin:5px">
		<img src="<?= $hotel_logo ?>" alt="logo dark" height="80" width="80" style="float: left;">
		<span style="font-size: 44px; font-weight: bold; color: navy;"><?= ucfirst(strtolower($hotel_name)) ?></span>
	</div>
	<div style="width: 100%;margin-left: 20px;margin-right: 20px;">
		<p style="text-align: center; font-size: 30px; font-weight: bold; margin: 0;text-decoration: underline double;margin-top: 10px;"><?= $monthly_report_title ?> Reviews At <?= ucfirst($website_name) ?></p>
		<div align="left" style="width: 50%;float: left;">
			<div style="text-align: center;border: 1px solid rgba(255, 255, 255, 0.25);border-radius: 20px;background-color: rgba(255, 255, 255, 0.45);box-shadow: 0 0 10px 1px rgb(0 0 0 / 25%);backdrop-filter: blur(15px);margin-top: 150px;">
				<p class="mb-2" style="text-align: center;color: green;margin-left: 10px; font-size: 24px">Positive: <?= $positive_reviews ?></p>
				<p class="" style="text-align: center;color: red;margin-left: 10px;font-size: 24px">Negative: <?= $negative_reviews ?></p>
			</div>
		</div>
		<div align="left" style="width: 46%;float: right;">
			<div style="box-shadow: inset 0 0 0 4px rgb(0 0 0 / 15%);margin:50px 10px 10px 10px">
				<img id="website_chart_url" src="<?= $monthly_website_chart_urls[$monthly_web_i] ?>" style="width: 100%;margin-right: 10px; height: 100%"/>
			</div>
			<div style="width: 100%;margin-left: 20px;margin-right: 20px;margin-bottom: 10px">
				<div align="left" style="width: 14%;float: left;margin-left: 100px">Positive</div>
				<div align="left" style="width: 10%;float: left;height: 20px;background: green; margin-left: 10px"></div>
				<div align="left" style="width: 14%;float: left;margin-left: 40px">Negative</div>
				<div align="left" style="width: 10%;float: left;height: 20px;background: red; margin-left: 10px"></div>
			</div>
		</div>
	</div>
	<?php $monthly_web_i++;
	}
	}
	} ?>

	<?php /*if (isset($Responded_Reviews) && !empty($Responded_Reviews)) { */?><!--
	<pagebreak>
	<div class="row g-2" style="page-break-inside: avoid;">
		<div style="text-align: right">
			<img src="<?/*= $hotel_logo */?>" alt="logo dark" height="80" width="80">
		</div>
		<p style="text-align: center; font-size: 40px; font-weight: bold; margin: 0; background-color: darkseagreen;color: green"> Positive Reviews </p>
		<?php /*foreach ($Responded_Reviews as $Responded_Review) {
			if ($Responded_Review['hotel_name'] == $hotel_name) { */?>
				<div style="border: 1px solid darkcyan; border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 10px; margin-left: 20px; margin-right: 20px">
					<p class="fw-medium fs-20 mb-1" style="margin-left: 10px"><?/*= ucfirst($Responded_Review['Name']) */?></p>
					<p class="fs-18 mb-0" style="margin-left: 10px"><?/*= ucfirst(strtolower($Responded_Review['positive_description'])) */?></p>
				</div>
			<?php /*}
		} */?>
	</div>
	<?php /*} */?>

	<?php /*if (isset($Responded_Reviews) && !empty($Responded_Reviews)) {
		$attachments_arr = array();
	*/?>
	<div class="row g-2" style="page-break-inside: avoid; margin-top:30px">
		<p style="text-align: center; font-size: 40px; font-weight: bold; margin: 0; background-color: indianred; color: darkred"> Reasons for Negative Reviews </p>
		<?php /*foreach ($Responded_Reviews as $Responded_Review) {
			if ($Responded_Review['hotel_name'] == $hotel_name) {
				if ($Responded_Review['attachments']!=""){
					$attachments = explode(",",$Responded_Review['attachments']);
					$attachments_arr[$hotel_name] = $attachments;
				}
			*/?>
				<div style="border: 1px solid darkcyan; border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 10px; margin-left: 20px; margin-right: 20px">
					<p class="fs-20 mb-1 fw-medium" style="margin-left: 10px"><?/*= ucfirst($Responded_Review['Name']) */?></p>
					<p class="fs-18 mb-0" style="margin-left: 10px"><?/*= ucfirst(strtolower($Responded_Review['negative_description'])) */?></p>
				</div>
			<?php /*}
		} */?>
	</div>
	--><?php /*} */?>

	<?php if (isset($conclusions) && !empty($conclusions)) {
		foreach ($conclusions as $conclusion) {
			if ($conclusion['hotel_name'] == $hotel_name && $conclusion['conclusion'] != "") { ?>
				<div class="row g-2" style="page-break-inside: avoid; margin-top:30px">
					<p style="text-align: center; font-size: 40px; font-weight: bold; margin: 0; background-color: deepskyblue;color: darkblue"> Conclusion </p>
					<div style="border: 1px solid darkcyan; border-radius: 5px; padding: 10px; margin-top: 20px; margin-left: 20px; margin-right: 20px; margin-bottom: 10px;">
						<p class="fs-18 mb-0" style="margin-left: 10px"><?= ucfirst(strtolower($conclusion['conclusion'])) ?></p>
					</div>
				</div>
			<?php }
		}
	} ?>

	<?php if (isset($Responded_Reviews) && !empty($Responded_Reviews) && isset($attachments_arr) && !empty($attachments_arr)) { ?>
		<pagebreak>
		<div style="text-align: center;background: #d3d3d3;border: 1px solid #0e96e5;border-right: none;border-left: none;margin:5px">
			<img src="<?= $hotel_logo ?>" alt="logo dark" height="80" width="80" style="float: left;">
			<span style="font-size: 44px; font-weight: bold; color: navy;"><?= ucfirst(strtolower($hotel_name)) ?></span>
		</div>
		<div style="width: 100%;height: 100%">
			<p style="text-align: center; font-size: 40px; font-weight: bold">Customer Reviews Attachments</p>
			<div style="margin-left: 200px;margin-right: 200px;">
			<?php foreach ($Responded_Reviews as $Responded_Review) {
			if ($Responded_Review['hotel_name'] == $hotel_name && $Responded_Review['attachments']!="") {
			$attachments = explode(",",$Responded_Review['attachments']); ?>
			<?php foreach ($attachments as $attachment){ ?>
			<div align="left" style="width: 50%;float: left;" class="mb-2">
				<a href="<?= base_url('assets/respond_attachments/'.$attachment) ?>" target="_blank" style="color: blue"><?= $attachment ?></a>
			</div>
				<?php } ?>
			<?php }
			} ?>
			</div>
		</div>
	<?php } ?>

	<?php $i++;
	}
	} else { ?>
		<div class="card-body">
			<h1 style="font-size: 40px; padding: 50px">There is no reviews to respond OR Pending to check</h1>
		</div>
	<?php } ?>

	<pagebreak>
	<div>
		<h1 style="text-align: center; font-size: 150px; font-weight: bold;padding-top: 25%"> Thank You </h1>
	</div>
</div><!-- container-fluid -->

</body>
</html>
