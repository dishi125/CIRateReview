<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Dashboard </title>
	<?php include 'layouts/title-meta.php'; ?>


	<!-- gridjs css -->
	<link rel="stylesheet" href="<?php echo base_url().'assets/libs/gridjs/theme/mermaid.min.css'; ?>">
	<?php include 'layouts/head-css.php'; ?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

	<?php include 'layouts/menu.php'; ?>
	<div class="loading" style="display: none" id="rate_analysis_page_loader">Loading&#8230;</div>

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
							<h4 class="mb-sm-0">Dashboard</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item active">Dashboard</li>
								</ol>
							</div>

						</div>
					</div>
				</div>
				<!-- end page title -->
                <div class="row">
					<div class="col-xxl-12">
						<div class="card">
							<div class="card-header align-items-xl-center d-xl-flex">
								<p class="text-muted flex-grow-1 mb-xl-0"></p>
								<div class="flex-shrink-0">
									<ul class="nav nav-pills card-header-pills" role="tablist">
										<li class="nav-item">
											<a class="nav-link tabs" id="rate_analysis_tab">
												Rate Analysis
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link tabs" id="website_analysis_tab">
												Website Analysis
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link tabs" id="hotels_historical_rate_tab">
												Hotels Historical Rate
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link tabs" id="website_historical_rate_tab">
												Website Historical Rate
											</a>
										</li>
									</ul>
								</div>
							</div><!-- end card header -->
							<div class="card-body">
								<!-- Tab panes -->
								<div class="tab-content text-muted">
									<div id="chart_table_rate_analysis_tab" style="display:none" class="chart_table"></div>
									<div id="chart_table_website_analysis_tab" style="display:none" class="chart_table"></div>
									<div id="chart_table_hotels_historical_rate_tab" style="display:none" class="chart_table"></div>
									<div id="chart_table_website_historical_rate_tab" style="display:none" class="chart_table"></div>
								</div>
							</div><!-- end card-body -->
						</div><!-- end card -->
					</div><!--end col-->
				</div>
			</div>
			<!-- container-fluid -->
		</div>
		<!-- End Page-content -->

		<?php include 'layouts/footer.php'; ?>
	</div>
	<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<div aria-live="polite" aria-atomic="true">
	<!-- Position it -->
	<div style="position: absolute; top: 3rem; right: 0; z-index: 99999;" class="bg-warning">
		<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="rate_analysis_page_suggestion_toast">
			<div class="toast-header bg-warning">
				<strong class="mr-auto" style="color: red">Add Mentioned Hotels</strong>
				<button type="button" class="ms-auto mb-1 close" data-dismiss="toast" aria-label="Close" data-delay="5000" id="rate_analysis_page_suggestion_toast_close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="toast-body" id="rate_analysis_page_suggestion_toast_body">
				Some Toast Body
			</div>
		</div>
	</div>
</div>

<button type="button" id="error_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- prismjs plugin -->
<script src="<?php echo base_url().'assets/libs/prismjs/prism.js'; ?>"></script>
<script src="<?php echo base_url().'assets/libs/gridjs/gridjs.umd.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/pages/gridjs.init.js'; ?>"></script>
<!-- Chart JS -->
<script src="<?php echo base_url().'assets/libs/chart.js/chart.min.js'; ?>"></script>
<!-- chartjs init -->
<script src="<?php echo base_url().'assets/js/pages/chartjs.init.js'; ?>"></script>
<!-- apexcharts -->
<script src="<?php echo base_url().'assets/libs/apexcharts/apexcharts.min.js'; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
$(document).ready(function (){
	// $('#users_dropdown').find('option').removeAttr('selected');
	// $('#users_dropdown option:nth-child(2)').attr('selected', 'selected');
	tabs('<?= $tab_type ?>', $("#" + '<?= $tab_type ?>'), true , false);
})

$(document).on("click", ".tabs", function (){
	var thi = $(this);
	var tab_type = $(this).attr('id');
	tabs(tab_type, $(this), false, true);
})

function tabs(tab_type, element, is_check_hotels, need_abort){
	var roomTypeId = 1;
	var price = 0;
	var userId = $("#users_dropdown").val();
	var hotelCode = $("#own_hotels_dropdown").val();
	var websiteId = 1;
	// console.log(userId);

	if ($("#chart_table_" + tab_type).html() == "") {
		if (need_abort) {
			$.each(xhrPool, function(idx, jqXHR) {
				jqXHR.abort();
			});

			if (xhr2) {
				xhr2.abort();
			}
		}

		$.ajax({
			url: "<?php echo base_url() . 'rate_analysis/ajax_call' ?>",
			method: "POST",
			data: {
				"tab_type": tab_type,
				"roomTypeId": roomTypeId,
				"price": price,
				"userId": userId,
				"websiteId": websiteId,
				"hotelCode": hotelCode
			},
			beforeSend: function (jqXHR) {
				xhrPool.push(jqXHR);
				if($("#chart_table_" + tab_type).html() == "")
				{
					$('#rate_analysis_page_loader').show();
				}
			},
			success: function (res) {
				// console.log(tab_type);
				var res = JSON.parse(res);
				if (res.status == 1) {
					var new_url = "<?php echo base_url() . 'rate_analysis/tab/' ?>" + tab_type;
					window.history.pushState('data', "test", new_url);
					$(".tabs").removeClass('active');
					element.addClass('active');
					$(".chart_table").hide();
					$("#chart_table_" + tab_type).html(res.html);
					$("#chart_table_" + tab_type).show();
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
			complete: function (data) {
				$('#rate_analysis_page_loader').hide();
				//suggestion box
				if (is_check_hotels==true && tab_type=="rate_analysis_tab"){
					var websites = <?= (isset($websites)&&!empty($websites)) ? json_encode($websites) : "''" ?>;
					var added_hotels = <?= (isset($added_hotels)&&!empty($added_hotels)) ? json_encode($added_hotels) : "''" ?>;

					var html = "";
					if (websites=='' || added_hotels==''){
						html += `<h5 style="color: red; font-weight: bold">Please add your own and competitor hotels</h5>`;
					}
					else {
						var website_names = websites.map(function(item) {
							return item.Name;
						});

						var own_hotel_list = added_hotels.filter(function(item) {
							if(item.IsCompetitorHotel == 0){
								return item.MappedHotelName;
							}
						});
						var own_hotel_list = own_hotel_list
							.map((item) => item.MappedHotelName)
							.filter(
								(value, index, self) =>
									self.indexOf(value) === index
							);
						var html_own_msg = "";
						$.each(website_names, function (key, value){
							var website = value;
							var not_added_hotels = [];
							$.each(own_hotel_list, function (key, value){
								var check_added = added_hotels.filter(function(item) {
									if(item.MappedHotelName == value && item.Name == website && item.IsCompetitorHotel == 0){
										return item.MappedHotelName;
									}
								});
								if (check_added.length == 0){
									not_added_hotels.push(value);
								}
							})

							if (not_added_hotels.length != 0){
								var hotel_string = not_added_hotels.join(" <br> ");
								html_own_msg += `<p style="color: darkblue" class="mb-0 mt-1">${website}</p> <p style="color: black" class="m-0">${hotel_string}</p>`;
							}
						})

						var comp_hotel_list = added_hotels.filter(function(item) {
							if(item.IsCompetitorHotel == 1){
								return item.MappedHotelName;
							}
						});
						var comp_hotel_list = comp_hotel_list
							.map((item) => item.MappedHotelName)
							.filter(
								(value, index, self) =>
									self.indexOf(value) === index
							);
						var html_comp_msg = "";
						$.each(website_names, function (key, value){
							var website = value;
							var not_added_hotels = [];
							$.each(comp_hotel_list, function (key, value){
								var check_added = added_hotels.filter(function(item) {
									if(item.MappedHotelName == value && item.Name == website && item.IsCompetitorHotel == 1){
										return item.MappedHotelName;
									}
								});
								if (check_added.length == 0){
									not_added_hotels.push(value);
								}
							})

							if (not_added_hotels.length != 0){
								var hotel_string = not_added_hotels.join(" <br> ");
								html_comp_msg += `<p style="color: darkblue" class="mb-0 mt-1">${website}</p> <p style="color: black" class="m-0">${hotel_string}</p>`;
							}
						})

						if (html_own_msg != ""){
							html += `<h5 style="color: red; font-weight: bold">Own Hotels</h5>`;
							html += `${html_own_msg}`;
						}
						if (html_comp_msg != ""){
							html += `<h5 class="mt-2" style="color: red; font-weight: bold">Competitor Hotels</h5>`;
							html += `${html_comp_msg}`;
						}
					}

					if (html != "") {
						$("#rate_analysis_page_suggestion_toast_body").html(html);
						// $(".toast").toast({ autohide: false });
						$("#rate_analysis_page_suggestion_toast").toast('show');
					}
				}
				add_other_tabs_data_in_background();
			},
			error: function (){
				/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');*/
			}
		});
	}
	else {
		var new_url = "<?php echo base_url() . 'rate_analysis/tab/' ?>" + tab_type;
		window.history.pushState('data', "test", new_url);
		$(".tabs").removeClass('active');
		element.addClass('active');
		$(".chart_table").hide();
		$("#chart_table_" + tab_type).show();

		let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
		var height = '400px';
		if (isMobile) {
			height = '500px';
		}
		if (tab_type == "website_analysis_tab") {
			$("#website_analysis_chart").css("height", height);
			$("#website_analysis_chart2").css("height", height);
		}
		else if (tab_type == "hotels_historical_rate_tab") {
			$("#hotels_historical_rate_chart").css("height", height);
		}
		else if (tab_type == "rate_analysis_tab") {
			$("#rate_analysis_chart").css("height", height);
		}
	}
}

$('body').on('click','#rate_analysis_page_suggestion_toast_close',function(){
	$(this).closest('#rate_analysis_page_suggestion_toast').toast('hide');
})

async function add_other_tabs_data_in_background(){
	var roomTypeId = 1;
	var price = 0;
	var userId = $("#users_dropdown").val();
	var hotelCode = $("#own_hotels_dropdown").val();
	var websiteId = 1;
	// console.log(userId);
	await append_rate_analysis_tab_data();
	await append_website_analysis_tab_data();
	await append_hotels_historical_rate_tab_data();
	await append_website_historical_rate_tab_data();
}

function append_rate_analysis_tab_data(){
	var roomTypeId = 1;
	var price = 0;
	var userId = $("#users_dropdown").val();
	var hotelCode = $("#own_hotels_dropdown").val();
	var websiteId = 1;

	if ($("#chart_table_rate_analysis_tab").html() == ""){
		$.ajax({
			url: "<?php echo base_url().'rate_analysis/ajax_call' ?>",
			method: "POST",
			data: {"tab_type": "rate_analysis_tab", "roomTypeId": roomTypeId, "price": price, "userId": userId, "websiteId": websiteId, "hotelCode": hotelCode},
			beforeSend: function(jqXHR){
				xhrPool.push(jqXHR);
			},
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#chart_table_rate_analysis_tab").html(res.html);
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
			complete:function(data){
			},
			error: function (){
				/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');*/
			}
		});
	}
}

function append_website_analysis_tab_data(){
	var roomTypeId = 1;
	var price = 0;
	var userId = $("#users_dropdown").val();
	var hotelCode = $("#own_hotels_dropdown").val();
	var websiteId = 1;

	if ($("#chart_table_website_analysis_tab").html() == ""){
		$.ajax({
			url: "<?php echo base_url().'rate_analysis/ajax_call' ?>",
			method: "POST",
			data: {"tab_type": "website_analysis_tab", "roomTypeId": roomTypeId, "price": price, "userId": userId, "websiteId": websiteId, "hotelCode": hotelCode},
			beforeSend: function(jqXHR){
				xhrPool.push(jqXHR);
			},
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#chart_table_website_analysis_tab").html(res.html);
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
			complete:function(data){
			},
			error: function (){
				/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');*/
			}
		});
	}
}

function append_hotels_historical_rate_tab_data(){
	var roomTypeId = 1;
	var price = 0;
	var userId = $("#users_dropdown").val();
	var hotelCode = $("#own_hotels_dropdown").val();
	var websiteId = 1;

	if ($("#chart_table_hotels_historical_rate_tab").html() == ""){
		$.ajax({
			url: "<?php echo base_url().'rate_analysis/ajax_call' ?>",
			method: "POST",
			data: {"tab_type": "hotels_historical_rate_tab", "roomTypeId": roomTypeId, "price": price, "userId": userId, "websiteId": websiteId, "hotelCode": hotelCode},
			beforeSend: function(jqXHR){
				xhrPool.push(jqXHR);
			},
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#chart_table_hotels_historical_rate_tab").html(res.html);
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
			complete:function(data){
			},
			error: function (){
				/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');*/
			}
		});
	}
}

function append_website_historical_rate_tab_data(){
	var roomTypeId = 1;
	var price = 0;
	var userId = $("#users_dropdown").val();
	var hotelCode = $("#own_hotels_dropdown").val();
	var websiteId = 1;

	if ($("#chart_table_website_historical_rate_tab").html() == ""){
		$.ajax({
			url: "<?php echo base_url().'rate_analysis/ajax_call' ?>",
			method: "POST",
			data: {"tab_type": "website_historical_rate_tab", "roomTypeId": roomTypeId, "price": price, "userId": userId, "websiteId": websiteId, "hotelCode": hotelCode},
			beforeSend: function(jqXHR){
				xhrPool.push(jqXHR);
			},
			success: function (res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#chart_table_website_historical_rate_tab").html(res.html);
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
			complete:function(data){
			},
			error: function (){
				/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');*/
			}
		});
	}
}

/*$(document).on('change', '#users_dropdown', function (){
	change_content_tab();
})*/

/*$(document).on('change', '#own_hotels_dropdown', function () {
	change_content_tab();
})*/

async function change_content_tab() {
	if($("#chart_table_rate_analysis_tab").html() != "") {
		await rate_analysis_filteration(false);
	}
	if($("#chart_table_website_analysis_tab").html() != "") {
		await filter_website_analysis_chart(false);
		await change_table_data(1, true, true, false);
	}
	if($("#chart_table_hotels_historical_rate_tab").html() != "") {
		await filter_hotels_historical_rate_data(true, false);
	}
	if($("#chart_table_website_historical_rate_tab").html() != "") {
		$('.inner_tabs_website_historical').each(async function () {
			var thi = $(this);
			if ($(thi).hasClass('active') && $(thi).attr('tab-type') == "table_view") {
				await loadPagination_website_historical_rate(1, false);
			} else if ($(thi).hasClass('active') && $(thi).attr('tab-type') == "calender_view") {
				await filter_calender_data(false);
			}
		})
	}
}
</script>

</body>
</html>
