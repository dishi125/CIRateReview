<?php include 'layouts/head-main.php'; ?>

<head>

	<title>View States</title>
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
							<h4 class="mb-sm-0" id="page_title">View States</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0" id="breadcrumb_link">
									<li class="breadcrumb-item"><a href="<?= base_url('system_analysis_dashboard') ?>">System Analysis Dashboard</a></li>
									<li class="breadcrumb-item active">View States</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<div class="col-12">
						<div class="flex-shrink-0">
							<button type="button" class="btn btn-primary waves-effect waves-light list_btn" id="city_list_btn" website-db="<?= $website_db ?>">Get City List</button>
						</div>

						<div class="card mt-1">
							<div class="card-header align-items-center d-flex">
								<h4 class="card-title mb-0 flex-grow-1"><?= rtrim($website_db,"com").".com" ?></h4>
							</div>
							<div class="card-body">
								<div class="live-preview">
									<div class="col-8">
									<div class="table-responsive" id="view_all_states_div">
										<table class="table table-bordered align-middle table-nowrap mb-0" id="view_all_states_table">
											<thead>
											<tr>
												<th style="width: 42px;"></th>
												<th><input type="text" placeholder="State" class="form-control" name="search_state_states_table" id="search_state_states_table" website-db="<?= $website_db ?>"></th>
											</tr>
											<tr>
												<th style="width: 42px;"></th>
												<th>State</th>
											</tr>
											</thead>
											<tbody>
											<?php foreach ($all_states as $all_state){
												if ($all_state['state'] != ""){
											?>
											<tr>
												<td>
													<div class="form-check">
														<input class="form-check-input" type="checkbox" value="<?= $all_state['state'] ?>" id="responsivetableCheck" name="states[]">
														<label class="form-check-label" for="responsivetableCheck"></label>
													</div>
												</td>
												<td><?= $all_state['state'] ?></td>
											</tr>
											<?php }
											} ?>
											</tbody>
										</table>
										<div class='loading-ct' style="display: none">
											<div class='part_loading'>
												<i class="mdi mdi-spin mdi-loading fa-3x"></i>
											</div>
										</div>
										<p id='total_records' style="float: left" class="mt-2"></p>
										<div id='view_all_state_pagination' style="float: right" class="mt-2 pagination_link"></div>
									</div>
									</div>
								</div>
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
var states;
var website;
var cities;
$(document).on('input', '#search_state_states_table', function (){
	var search_state = $(this).val();
	var website_db = $(this).attr('website-db');

	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});

	$.ajax({
		url: "<?php echo base_url() . 'get_state_list/'; ?>" + website_db,
		method: "POST",
		data: {"search_state": search_state},
		beforeSend: function(jqXHR){
			xhrPool.push(jqXHR);
			$("#view_all_states_div").find('.loading-ct').show();
		},
		success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				var html = update_state_table_data(res.states);
				$("#view_all_states_table tbody").html(html);
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
			$("#view_all_states_div").find('.loading-ct').hide();
		},
		error: function (){
			$("#view_all_states_div").find('.loading-ct').hide();
		}
	});
})

function update_state_table_data(states){
	var html = "";

	$.each(states, function (index, value){
		html += `<tr>
					<td>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="${value.state}" id="responsivetableCheck" name="states[]">
							<label class="form-check-label" for="responsivetableCheck"></label>
						</div>
					</td>
					<td>${value.state}</td>
				</tr>`;
	});

	if (states.length == 0){
		html += `<tr>
					<td style="text-align: center" colspan="2">No records found</td>
				</tr>`;
	}

	return html;
}

$(document).on('click', '#city_list_btn', function (){
	states = $("input[name='states[]']:checked").map(function () {
		return this.value;
	}).get();
	website = $(this).attr('website-db');
	city_table_data(1, true);
})

$(document).on('click', '#hotel_list_btn', function (){
	cities = $("input[name='cities[]']:checked").map(function () {
		return this.value;
	}).get();
	website = $(this).attr('website-db');
	hotel_table_data(1, true);
})

$(document).on('click', '#view_all_state_pagination a', function(e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	city_table_data(pageno, false);
});

$(document).on('input', '#search_state_cities_table', function (){
	city_table_data(1, false);
})

$(document).on('input', '#search_city_cities_table', function (){
	city_table_data(1, false);
})

$(document).on('click', '#hotel_list_pagination a', function(e) {
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	hotel_table_data(pageno, false);
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

function city_table_data(pageno, need_update_full_table){
	var search_state = $("#search_state_cities_table").val();
	var search_city = $("#search_city_cities_table").val();

	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});

	$.ajax({
		url: "<?php echo base_url() . 'get_city_list/'; ?>" + website + "/"+ pageno,
		method: "POST",
		data: {"states": states, "search_state": search_state, "search_city": search_city},
		beforeSend: function(jqXHR){
			xhrPool.push(jqXHR);
			$("#view_all_states_div").find('.loading-ct').show();
		},
		success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				var html = city_table_html(res.cities, need_update_full_table);
				if (need_update_full_table) {
					$("#view_all_states_table").html(html);
				}
				else {
					$("#view_all_states_table tbody").html(html);
				}
				$("#total_records").html("Total No. of records " + res.total_records);
				$("#view_all_state_pagination").html(res.pagination);
				$(".list_btn").attr('id', 'hotel_list_btn');
				$(".list_btn").html("Get Hotel List");
				var breadcrumb_link = `<li class="breadcrumb-item"><a href="<?= base_url('system_analysis_dashboard') ?>">System Analysis Dashboard</a></li>
									<li class="breadcrumb-item"><a id="state_list_link">View States</a></li>
									<li class="breadcrumb-item active">View Cities</li>`;
				$("#breadcrumb_link").html(breadcrumb_link);
				$(".list_btn").show();
				$("#page_title").html("View Cities");
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
			$("#view_all_states_div").find('.loading-ct').hide();
		},
		error: function (){
			$("#view_all_states_div").find('.loading-ct').hide();
		}
	});
}

function hotel_table_data(pageno, need_update_full_table){
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
		data: {"cities": cities, "search_state": search_state, "search_city": search_city, "search_hotel": search_hotel, "search_scrape_time": search_scrape_time},
		beforeSend: function(jqXHR){
			xhrPool.push(jqXHR);
			$("#view_all_states_div").find('.loading-ct').show();
		},
		success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				var html = hotel_table_html(res.hotels, need_update_full_table);
				if (need_update_full_table) {
					$("#view_all_states_table").html(html);
				}
				else {
					$("#view_all_states_table tbody").html(html);
				}
				$("#total_records").html("Total No. of records " + res.total_records);
				$(".pagination_link").attr('id', 'hotel_list_pagination');
				$(".pagination_link").html(res.pagination);
				$(".list_btn").hide();
				var breadcrumb_link = `<li class="breadcrumb-item"><a href="<?= base_url('system_analysis_dashboard') ?>">System Analysis Dashboard</a></li>
									<li class="breadcrumb-item"><a id="state_list_link">View States</a></li>
									<li class="breadcrumb-item"><a id="city_list_link">View Cities</a></li>
									<li class="breadcrumb-item active">View Hotels</li>`;
				$("#breadcrumb_link").html(breadcrumb_link);
				$("#page_title").html("View Hotels");
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
			$("#view_all_states_div").find('.loading-ct').hide();
		},
		error: function (){
			$("#view_all_states_div").find('.loading-ct').hide();
		}
	});
}

function state_table_html(states){
	var html = `<thead>
				<tr>
					<th style="width: 42px;"></th>
					<th><input type="text" placeholder="State" class="form-control" name="search_state_states_table" id="search_state_states_table" website-db="${website}"></th>
				</tr>
				<tr>
					<th style="width: 42px;"></th>
					<th>State</th>
				</tr>
				</thead>
				<tbody>`;

	$.each(states, function (index, value){
		html += `<tr>
					<td>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="${value.state}" id="responsivetableCheck" name="states[]">
							<label class="form-check-label" for="responsivetableCheck"></label>
						</div>
					</td>
					<td>${value.state}</td>
				</tr>`;
	});

	html += `</tbody>`;

	return html;
}

function city_table_html(cities, need_update_full_table){
	var html = "";
	if (need_update_full_table) {
		html += `<thead>
				<tr>
					<th style="width: 42px;"></th>
					<th><input type="text" placeholder="State" class="form-control" name="search_state_cities_table" id="search_state_cities_table" website-db="${website}"></th>
					<th><input type="text" placeholder="City" class="form-control" name="search_city_cities_table" id="search_city_cities_table" website-db="${website}"></th>
				</tr>
				<tr>
					<th style="width: 42px;"></th>
					<th>State</th>
					<th>City</th>
				</tr>
				</thead>
				<tbody>`;
	}

	$.each(cities, function (index, value){
		html += `<tr>
					<td>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="${value.city_id}" id="responsivetableCheck" name="cities[]">
							<label class="form-check-label" for="responsivetableCheck"></label>
						</div>
					</td>
					<td>${value.state_code}</td>
					<td>${value.city}</td>
				</tr>`;
	});

	if (cities.length == 0){
		html += `<tr>
					<td style="text-align: center" colspan="3">No records found</td>
				</tr>`;
	}

	if (need_update_full_table) {
		html += `</tbody>`;
	}

	return html;
}

function hotel_table_html(hotels, need_update_full_table){
	var html = "";
	if (need_update_full_table) {
		html += `<thead>
				<tr>
					<th><input type="text" placeholder="State" class="form-control" name="search_state_hotels_table" id="search_state_hotels_table" website-db="${website}"></th>
					<th><input type="text" placeholder="City" class="form-control" name="search_city_hotels_table" id="search_city_hotels_table" website-db="${website}"></th>
					<th><input type="text" placeholder="Hotel" class="form-control" name="search_hotel_hotels_table" id="search_hotel_hotels_table" website-db="${website}"></th>
					<th><input type="text" placeholder="Scrape time" class="form-control" name="search_scrape_time_hotels_table" id="search_scrape_time_hotels_table" website-db="${website}"></th>
				</tr>
				<tr>
					<th>State</th>
					<th>City</th>
					<th>Hotel</th>
					<th>Scrape time</th>
				</tr>
				</thead>
				<tbody>`;
	}

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

	if (need_update_full_table) {
		html += `</tbody>`;
	}

	return html;
}

$(document).on('click', "#state_list_link", function (){
	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});

	$.ajax({
		url: "<?php echo base_url() . 'get_state_list/'; ?>" + website,
		method: "POST",
		beforeSend: function(jqXHR){
			xhrPool.push(jqXHR);
			$("#view_all_states_div").find('.loading-ct').show();
		},
		success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				var html = state_table_html(res.states);
				$("#view_all_states_table").html(html);
				$("#total_records").html("");
				$(".list_btn").attr("id", "city_list_btn");
				$(".list_btn").html("Get City List");
				var breadcrumb_link = `<li class="breadcrumb-item"><a href="<?= base_url('system_analysis_dashboard') ?>">System Analysis Dashboard</a></li>
									<li class="breadcrumb-item active">View States</li>`;
				$("#breadcrumb_link").html(breadcrumb_link);
				$(".pagination_link").html("");
				$(".pagination_link").attr("id", "view_all_state_pagination");
				$(".list_btn").show();
				$("#page_title").html("View States");
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
			$("#view_all_states_div").find('.loading-ct').hide();
		},
		error: function (){
			$("#view_all_states_div").find('.loading-ct').hide();
		}
	});
})

$(document).on('click', "#city_list_link", function (){
	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});

	$.ajax({
		url: "<?php echo base_url() . 'get_city_list/'; ?>" + website + "/" + 1,
		method: "POST",
		data: {"states": states},
		beforeSend: function(jqXHR){
			xhrPool.push(jqXHR);
			$("#view_all_states_div").find('.loading-ct').show();
		},
		success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				var html = city_table_html(res.cities, true);
				$("#view_all_states_table").html(html);
				$("#total_records").html("Total No. of records " + res.total_records);
				$(".pagination_link").html(res.pagination);
				$(".pagination_link").attr("id", "view_all_state_pagination");
				$(".list_btn").attr('id', 'hotel_list_btn');
				$(".list_btn").html("Get Hotel List");
				var breadcrumb_link = `<li class="breadcrumb-item"><a href="<?= base_url('system_analysis_dashboard') ?>">System Analysis Dashboard</a></li>
									<li class="breadcrumb-item"><a id="state_list_link">View States</a></li>
									<li class="breadcrumb-item active">View Cities</li>`;
				$("#breadcrumb_link").html(breadcrumb_link);
				$(".list_btn").show();
				$("#page_title").html("View Cities");
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
			$("#view_all_states_div").find('.loading-ct').hide();
		},
		error: function (){
			$("#view_all_states_div").find('.loading-ct').hide();
		}
	});
})
</script>

</body>
</html>
