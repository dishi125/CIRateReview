<html>
<head>
	<meta charset="utf-8">
	<title>Report</title>
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
<!--	<div class="row justify-content-center" id="pdf_view_div">-->
<!--		<div class="col-12" id="pdf_content">-->
			<div style="width: 100%;">
				<div align="left" style="width: 50%;float: left; height: 100%">
					<img src="demo.jpg" alt="logo dark" style="width: 100%; height: 100%">
				</div>
				<div align="left" style="width: 50%;float: left; height: 100%;">
					<h1 style="color: navy; padding-left: 20px; padding-right: 20px; font-size: 40px; padding-top: 20px">Sleep Inn Airport Greensboro</h1>
					<h1 style="color: navy; padding-left: 20px; padding-right: 20px; font-size: 40px;">Review Report</h1>
					<h1 style="color: deepskyblue; padding-left: 20px; padding-right: 20px; font-size: 40px;">Date: 18 June - 24 June 22</h1>
				</div>
			</div>

			<pagebreak>

			<div style="width: 100%;">
				<p style="text-align: center; font-size: 40px; font-weight: bold;"> Reviews at Site </p>
				<div align="left" style="width: 50%;float: left; height: 100%;">
					<p class="fw-bold fs-22 mb-1 text-center" style="color: blue; margin: 0">Total number: 37</p>
					<p class="fs-18 mb-2 text-center" style="color: red; margin: 0">negative: 14</p>
					<p class="fs-18 mb-2 text-center" style="color: darkcyan; margin: 0">positive: 23</p>
					<p class="fw-bolder fs-22 mb-1 text-center" style="color: blue; margin: 0">Booking.com</p>
					<p class="fs-18 mb-2 text-center" style="color: red; margin: 0">negative: 04</p>
					<p class="fs-18 mb-2 text-center" style="color: darkcyan; margin: 0">positive: 11</p>
					<p class="fw-bolder fs-22 mb-1 text-center" style="color: blue; margin: 0">Medallia</p>
					<p class="fs-18 mb-2 text-center" style="color: red; margin: 0">Negative: 10</p>
					<p class="fs-18 mb-2 text-center" style="color: darkcyan; margin: 0">Positive: 12</p>
				</div>
				<div align="left" style="width: 50%;float: left; height: 100%;">
					<img id="review_report_chart_url" src="<?= $review_report_chart_url ?>" style="width: 100%;"/>
				</div>
			</div>

			<pagebreak>

			<div style="width: 100%;">
				<p style="text-align: center; font-size: 40px; font-weight: bold;"> Reviews at Site </p>
				<div align="left" style="width: 50%;float: left; height: 100%;">
					<p class="fw-bolder fs-22 mb-2 text-center" style="color: blue;">Booking.com</p>
					<p class="fs-18 mb-1 text-center" style="color: red">negative: 04</p>
					<p class="fs-18 mb-1 text-center" style="color: darkcyan">positive: 11</p>
				</div>
				<div align="left" style="width: 50%;float: left; height: 100%;">
					<img id="booking_chart_url" src="<?= $booking_chart_url ?>" style="width: 100%;"/>
				</div>
			</div>

			<pagebreak>

			<div style="width: 100%;">
				<p style="text-align: center; font-size: 40px; font-weight: bold;"> Reviews at Site </p>
				<div align="left" style="width: 50%;float: left; height: 100%;">
					<p class="fw-bolder fs-22 mb-2 text-center" style="color: blue">Medallia</p>
					<p class="fs-18 mb-1 text-center" style="color: red">negative: 10</p>
					<p class="fs-18 mb-1 text-center" style="color: darkcyan">positive: 12</p>
				</div>
				<div align="left" style="width: 50%;float: left; height: 100%;">
					<img id="medallia_chart_url" src="<?= $medallia_chart_url ?>" style="width: 100%"/>
				</div>
			</div>

			<pagebreak>

			<div class="row g-2" style="page-break-inside: avoid !important;">
				<p style="text-align: center; font-size: 40px; font-weight: bold; margin: 0; background-color: darkseagreen;color: green"> Positive Reviews </p>
				<div style="border: 1px solid darkcyan; border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 10px; margin-left: 20px; margin-right: 20px">
				<p class="fs-16 mb-0" style="margin-left: 10px">The Behaviour of the staff is the second reason that the hotel is getting positive reviews. The way the staff treats the guest is very nice.</p>
				</div>
			</div>

			<div class="row g-2" style="page-break-inside: avoid !important; margin-top:30px">
				<p style="text-align: center; font-size: 40px; font-weight: bold; margin: 0; background-color: indianred; color: darkred"> Reasons for Negative Reviews </p>
				<div style="border: 1px solid darkcyan; border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 10px; margin-left: 20px; margin-right: 20px">
				<p class="fs-16 mb-0" style="margin-left: 10px">Unwelcome pests in the rooms.</p>
				</div>
			</div>

			<div class="row g-2" style="page-break-inside: avoid !important; margin-top:30px">
				<p style="text-align: center; font-size: 40px; font-weight: bold; margin: 0; background-color: #E0E090FF; color: darkorange"> Feedback </p>
				<div style="border: 1px solid darkcyan; border-radius: 5px; padding: 10px; margin-top: 20px; margin-bottom: 10px; margin-left: 20px; margin-right: 20px">
				<p class="fs-16 mb-0" style="margin-left: 10px">Cleanliness is the first main reason that needs to be done. Customers have reviewed negatively as rooms were so dirty.</p>
				</div>
			</div>

			<div class="row g-2" style="page-break-inside: avoid !important; margin-top:30px">
				<p style="text-align: center; font-size: 40px; font-weight: bold; margin: 0; background-color: deepskyblue;color: darkblue"> Conclusion </p>
				<div style="border: 1px solid darkcyan; border-radius: 5px; padding: 10px; margin-top: 20px; margin-left: 20px; margin-right: 20px; margin-bottom: 10px;">
					<p class="fs-16 mb-0" style="margin-left: 10px">The hotel needs up-gradation in several things such as cleanliness stinky smell, etc. due to which guests share the reviews in a negative way. So we
						need to work on such things. The location of the hotel is very beautiful and guests choose Sleep Inn Airport Greensboro hotel for making their stay
						better. But the stay gets spoiled due to certain problems in the hotel. Around 20% of the reviews are negative per day.</p>
				</div>
			</div>
<!--		</div>-->
		<!--end col-->
<!--	</div>-->
	<!--end row-->
</div><!-- container-fluid -->

</body>
</html>
