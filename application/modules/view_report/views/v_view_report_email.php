<!doctype html>
<html>
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>View Report</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style>
		/* -------------------------------------
    GLOBAL RESETS
------------------------------------- */

		/*All the styling goes here*/

		img {
			border: none;
			-ms-interpolation-mode: bicubic;
			max-width: 100%;
		}

		body {
			background-color: #eaebed;
			font-family: sans-serif;
			-webkit-font-smoothing: antialiased;
			font-size: 14px;
			line-height: 1.4;
			margin: 0;
			padding: 0;
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%;
		}

		table {
			border-collapse: separate;
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
			min-width: 100%;
			width: 100%;
		}
		table td {
			font-family: sans-serif;
			font-size: 14px;
			vertical-align: top;
		}

		/* -------------------------------------
			BODY & CONTAINER
		------------------------------------- */

		.body {
			background-color: #eaebed;
			width: 100%;
		}

		/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
		.container {
			display: block;
			Margin: 0 auto !important;
			/* makes it centered */
			max-width: 580px;
			padding: 10px;
			width: 580px;
		}

		/* This should also be a block element, so that it will fill 100% of the .container */
		.content {
			box-sizing: border-box;
			display: block;
			Margin: 0 auto;
			max-width: 580px;
			padding: 10px;
		}

		/* -------------------------------------
			HEADER, FOOTER, MAIN
		------------------------------------- */
		.main {
			background: #ffffff;
			border-radius: 3px;
			width: 100%;
		}

		.header {
			padding: 20px 0;
		}

		.wrapper {
			box-sizing: border-box;
			padding: 20px;
		}

		.content-block {
			padding-bottom: 10px;
			padding-top: 10px;
		}

		.footer {
			clear: both;
			Margin-top: 10px;
			text-align: center;
			width: 100%;
		}
		.footer td,
		.footer p,
		.footer span,
		.footer a {
			color: #9a9ea6;
			font-size: 12px;
			text-align: center;
		}

		/* -------------------------------------
			TYPOGRAPHY
		------------------------------------- */
		h1,
		h2,
		h3,
		h4 {
			color: #06090f;
			font-family: sans-serif;
			font-weight: 400;
			line-height: 1.4;
			margin: 0;
			/*margin-bottom: 30px;*/
		}

		h1 {
			font-size: 30px;
			font-weight: 300;
			text-align: center;
			text-transform: capitalize;
		}

		p,
		ul,
		ol {
			font-family: sans-serif;
			font-size: 14px;
			font-weight: normal;
			margin: 0;
			margin-bottom: 15px;
		}
		p li,
		ul li,
		ol li {
			list-style-position: inside;
			margin-left: 5px;
		}

		a {
			color: #ec0867;
			text-decoration: underline;
		}

		/* -------------------------------------
			BUTTONS
		------------------------------------- */
		.btn {
			box-sizing: border-box;
			width: 100%; }
		.btn > tbody > tr > td {
			padding-bottom: 15px; }
		.btn table {
			min-width: auto;
			width: auto;
		}
		.btn table td {
			background-color: #ffffff;
			border-radius: 5px;
			text-align: center;
		}
		.btn a {
			background-color: #ffffff;
			border: solid 1px #ec0867;
			border-radius: 5px;
			box-sizing: border-box;
			color: #ec0867;
			cursor: pointer;
			display: inline-block;
			font-size: 14px;
			font-weight: bold;
			margin: 0;
			padding: 12px 25px;
			text-decoration: none;
			text-transform: capitalize;
		}

		.btn-primary table td {
			background-color: #ec0867;
		}

		.btn-primary a {
			background-color: #ec0867;
			border-color: #ec0867;
			color: #ffffff;
		}

		/* -------------------------------------
			OTHER STYLES THAT MIGHT BE USEFUL
		------------------------------------- */
		.last {
			margin-bottom: 0;
		}

		.first {
			margin-top: 0;
		}

		.align-center {
			text-align: center;
		}

		.align-right {
			text-align: right;
		}

		.align-left {
			text-align: left;
		}

		.clear {
			clear: both;
		}

		.mt0 {
			margin-top: 0;
		}

		.mb0 {
			margin-bottom: 0;
		}

		.preheader {
			color: transparent;
			display: none;
			height: 0;
			max-height: 0;
			max-width: 0;
			opacity: 0;
			overflow: hidden;
			mso-hide: all;
			visibility: hidden;
			width: 0;
		}

		.powered-by a {
			text-decoration: none;
		}

		hr {
			border: 0;
			border-bottom: 1px solid #f6f6f6;
			Margin: 20px 0;
		}

		/* -------------------------------------
			RESPONSIVE AND MOBILE FRIENDLY STYLES
		------------------------------------- */
		@media only screen and (max-width: 620px) {
			table[class=body] h1 {
				font-size: 28px !important;
				margin-bottom: 10px !important;
			}
			table[class=body] p,
			table[class=body] ul,
			table[class=body] ol,
			table[class=body] td,
			table[class=body] span,
			table[class=body] a {
				font-size: 16px !important;
			}
			table[class=body] .wrapper,
			table[class=body] .article {
				padding: 10px !important;
			}
			table[class=body] .content {
				padding: 0 !important;
			}
			table[class=body] .container {
				padding: 0 !important;
				width: 100% !important;
			}
			table[class=body] .main {
				border-left-width: 0 !important;
				border-radius: 0 !important;
				border-right-width: 0 !important;
			}
			table[class=body] .btn table {
				width: 100% !important;
			}
			table[class=body] .btn a {
				width: 100% !important;
			}
			table[class=body] .img-responsive {
				height: auto !important;
				max-width: 100% !important;
				width: auto !important;
			}
		}

		/* -------------------------------------
			PRESERVE THESE STYLES IN THE HEAD
		------------------------------------- */
		@media all {
			.ExternalClass {
				width: 100%;
			}
			.ExternalClass,
			.ExternalClass p,
			.ExternalClass span,
			.ExternalClass font,
			.ExternalClass td,
			.ExternalClass div {
				line-height: 100%;
			}
			.apple-link a {
				color: inherit !important;
				font-family: inherit !important;
				font-size: inherit !important;
				font-weight: inherit !important;
				line-height: inherit !important;
				text-decoration: none !important;
			}
			.btn-primary table td:hover {
				background-color: #d5075d !important;
			}
			.btn-primary a:hover {
				background-color: #d5075d !important;
				border-color: #d5075d !important;
			}
		}

		#review_summary_table{
			border-collapse: collapse !important;
		}
		#review_summary_table th{
			color: black !important;
			font-size: 17px !important;
			font-weight: bold !important;
			background-color: #d3d3d3ab !important;
		}
		#review_summary_table td{
			font-weight: 500 !important;
			font-size: 16px !important;
			color: black !important;
		}
	</style>
</head>
<body class="">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
	<tr>
		<td>&nbsp;</td>
		<td class="container">
			<div class="header">
				<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="align-center" width="100%">
							<a href="https://psmtech.com/"><img src="<?php echo base_url().'assets/images/psmtech_logo.png'; ?>" height="40" alt="PSM Tech"></a>
						</td>
					</tr>
				</table>
			</div>
			<div class="content">

				<!-- START CENTERED WHITE CONTAINER -->
<!--				<span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>-->
				<h1 style="text-align: center; background-color: #0066FFFF; color: white; font-weight: bold">PSMTECH</h1>
				<table role="presentation" class="main">

					<!-- START MAIN CONTENT AREA -->
					<tr>
						<td class="wrapper">
							<table role="presentation" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td>
										<p>Hello <?= $user_name ?>,</p>
										<h3 style="text-align: center; margin: 0; font-weight: bold">Review Summary</h3>
										<div class="table-responsive">
											<table class="table table-bordered align-middle table-nowrap" border="1" width="100%" id="review_summary_table">
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
										<p style="margin-bottom: 5px; margin-top: 5px">Please, see the attached report for Responded Reviews.</p>
										<p style="margin: 0">Thanks, </p>
										<p style="margin: 0">Psmtech Team</p>
										<!--										<p>👋&nbsp; Welcome to Postdrop. A simple tool to help developers with HTML email.</p>-->
										<!--										<p>✨&nbsp; HTML email templates are painful to build. So instead of spending hours or days trying to make your own, just use this template and call it a day.</p>-->
										<!--										<p>⬇️&nbsp; Add your own content then download and copy over to your codebase or ESP. Postdrop will inline the CSS for you to make sure it doesn't fall apart when it lands in your inbox.</p>-->
										<!--										<p>📬&nbsp; Postdrop also lets you send test emails to yourself. You just need to sign up first so we know you're not a spammer.</p>-->
										<!--<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
											<tbody>
											<tr>
												<td align="center">
													<table role="presentation" border="0" cellpadding="0" cellspacing="0">
														<tbody>
														<tr>
															<td> <a href="/signup" target="_blank">Sign Up For Postdrop</a> </td>
														</tr>
														</tbody>
													</table>
												</td>
											</tr>
											</tbody>
										</table>-->
										<!--										<p>💃&nbsp; That's it. Enjoy this free template.</p>-->
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<!-- END MAIN CONTENT AREA -->
				</table>

				<div style="width: 100%;background-color: darkgray;overflow:auto;">
					<div align="left" style="width: 50%;float: left;">
						<p style="margin: 0; margin-left: 5px"> Contact: (336)-285-9178</p>
						<p style="margin: 0; margin-left: 5px"> E-mail: info@psmtech.com</p>
						<p style="margin: 0; margin-left: 5px"> Website: https://psmtech.com</p>
					</div>
					<div align="left" style="width: 50%;float: left;">
						<p style="margin: 0; margin-right: 5px">Address: 371, South Swing Road, PI Greensboro, NC-27409</p>
					</div>
				</div>

				<!--<div style="display: flex; margin-left: 10px; margin-right: 10px;">
					<p style="margin-right: 20px;margin-bottom: 2px!important;">Contact: (336)-285-9178</p>
					<p style="margin-bottom: 2px!important;">Address: 371, South Swing Road, PI Greensboro, NC-27409</p>
				</div>
				<div style="display: flex;margin-left: 10px; margin-right: 10px">
					<p style="margin-right: 20px;margin-bottom: 0px!important;">E-mail: info@psmtech.com</p>
					<p style="margin-bottom: 0px!important;">Website: https://psmtech.com</p>
				</div>-->

				<!-- START FOOTER -->
				<div class="footer">
					<table role="presentation" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="content-block">
								<span class="apple-link">Don't forget to add your address here</span>
								<br> And <a href="https://postdrop.io">unsubscribe link</a> here.
							</td>
						</tr>
						<tr>
							<td class="content-block powered-by">
								Powered by <a href="https://postdrop.io">Postdrop</a>.
							</td>
						</tr>
					</table>
				</div>
				<!-- END FOOTER -->

				<!-- END CENTERED WHITE CONTAINER -->
			</div>
		</td>
		<td>&nbsp;</td>
	</tr>
</table>
</body>
</html>
