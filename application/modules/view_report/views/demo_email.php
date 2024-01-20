<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<style>
		table{
			border-collapse: collapse;
		}
		table th{
			color: black !important;
			font-size: 17px !important;
			font-weight: bold !important;
			background-color: #d3d3d3ab !important;
		}
		table td{
			font-weight: 500 !important;
			font-size: 16px !important;
			color: black !important;
		}
	</style>
</head>

<body>
<div class="container">
	<h3 style="text-align:left;float:left;">Hi, <?= $user_name ?></h3> <br>
	<h3 style="text-align: center; margin: 0">Review Summary</h3>
	<div class="table-responsive">
		<table class="table table-bordered align-middle table-nowrap" border="1" width="100%">
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
	<p style="margin-bottom: 0px">Please, see the attached report for Responded Reviews.</p>
	<p class="text-muted" style="margin-top: 0px; margin-bottom: 5px">Thanks.</p>
	<p class="text-muted" style="margin: 0">Best Regards, </p>
	<p class="text-muted" style="margin: 0">Psmtech Team. </p>
</div>

</body>
</html>
