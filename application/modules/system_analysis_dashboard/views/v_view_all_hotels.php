<?php include 'layouts/head-main.php'; ?>

<head>
	<title>View Hotels</title>
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
							<h4 class="mb-sm-0" id="page_title">View Hotels</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0" id="breadcrumb_link">
									<li class="breadcrumb-item"><a href="<?= base_url('system_analysis_dashboard') ?>">System Analysis Dashboard</a></li>
									<li class="breadcrumb-item active">View Hotels</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header align-items-center d-flex">
								<h4 class="card-title mb-0 flex-grow-1"><?= rtrim($website_db,"com").".com" ?></h4>
							</div>
							<div class="card-body">
								<div class="live-preview">
									<div class="col-8">
										<div class="table-responsive" id="view_all_hotels_div">
											<table class="table table-bordered align-middle table-nowrap mb-0" id="view_all_hotels_table">
												<thead>
												<tr>
													<th><input type="text" placeholder="State" class="form-control" name="search_state_hotels_table" id="search_state_hotels_table" website-db="<?= $website_db ?>"></th>
													<th><input type="text" placeholder="City" class="form-control" name="search_city_hotels_table" id="search_city_hotels_table" website-db="<?= $website_db ?>"></th>
													<th><input type="text" placeholder="Hotel" class="form-control" name="search_hotel_hotels_table" id="search_hotel_hotels_table" website-db="<?= $website_db ?>"></th>
													<th><input type="text" placeholder="Scrape time" class="form-control" name="search_scrape_time_hotels_table" id="search_scrape_time_hotels_table" website-db="<?= $website_db ?>"></th>
												</tr>
												<tr>
													<th>State</th>
													<th>City</th>
													<th>Hotel</th>
													<th>Scrape time</th>
												</tr>
												</thead>
												<tbody>
												<?php foreach ($hotels as $hotel){ ?>
													<tr>
														<td><?= $hotel['state'] ?></td>
														<td><?= $hotel['city_name'] ?></td>
														<td><?= $hotel['hotel'] ?></td>
														<td><?= $hotel['scrape_time'] ?></td>
													</tr>
												<?php } ?>
												</tbody>
											</table>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
											<p id='total_records' style="float: left" class="mt-2">Total No. of records <?= $total_records ?></p>
											<div id='view_all_hotel_pagination' style="float: right" class="mt-2 pagination_link"><?= $pagination ?></div>
										</div>
									</div>
								</div>`
							</div>
						</div>
					</div>
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

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
var website = "<?= $website_db ?>";
$(document).on('click', '#view_all_hotel_pagination a', function(e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	hotel_table_data(pageno);
});

$(document).on('input', '#search_state_hotels_table', function (){
	hotel_table_data(1, false);
})
$(document).on('input', '#search_city_hotels_table', function (){
	hotel_table_data(1, false);
})
$(document).on('input', '#search_hotel_hotels_table', function (){
	hotel_table_data(1, false);
})
$(document).on('input', '#search_scrape_time_hotels_table', function (){
	hotel_table_data(1, false);
})

function hotel_table_data(pageno){
	var search_state = $("#search_state_hotels_table").val();
	var search_city = $("#search_city_hotels_table").val();
	var search_hotel = $("#search_hotel_hotels_table").val();
	var search_scrape_time = $("#search_scrape_time_hotels_table").val();

	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});

	$.ajax({
		url: "<?php echo base_url() . 'get_hotel_list/'; ?>" + website + "/"+ pageno,
		method: "POST",
		data: {"search_state": search_state, "search_city": search_city, "search_hotel": search_hotel, "search_scrape_time": search_scrape_time},
		beforeSend: function(jqXHR){
			xhrPool.push(jqXHR);
			$("#view_all_hotels_div").find('.loading-ct').show();
		},
		success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				var html = hotel_table_html(res.hotels);
				$("#view_all_hotels_table tbody").html(html);
				$("#total_records").html("Total No. of records " + res.total_records);
				$("#view_all_hotel_pagination").html(res.pagination);
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
		complete: function (){
			$("#view_all_hotels_div").find('.loading-ct').hide();
		},
		error: function (){
			$("#view_all_hotels_div").find('.loading-ct').hide();
		}
	});
}

function hotel_table_html(hotels){
	var html = "";

	$.each(hotels, function (index, value){
		html += `<tr>
					<td>${value.state}</td>
					<td>${value.city_name}</td>
					<td>${value.hotel}</td>
					<td>${value.scrape_time}</td>
				</tr>`;
	});

	if (hotels.length == 0){
		html += `<tr>
					<td style="text-align: center" colspan="4">No records found</td>
				</tr>`;
	}

	return html;
}
</script>
