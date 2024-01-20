<div class="row">
	<div class="col-3">
		<div>
			<select name="website_analysis_price" id="website_analysis_price" class="form-select">
				<option value="1">High</option>
				<option value="0" selected>Low</option>
			</select>
		</div>
	</div>
	<div class="col-3">
		<div>
			<select name="website_analysis_room_type" id="website_analysis_room_type" class="form-select">
				<?php if(isset($GetRoomTypeList) && !empty($GetRoomTypeList)){ ?>
				<?php foreach ($GetRoomTypeList as $roomType){ ?>
					<option value="<?= $roomType['Id'] ?>" <?php if ($roomType['Name']=="King"){ ?> selected <?php } ?>><?= $roomType['Name'] ?></option>
				<?php } } ?>
			</select>
		</div>
	</div>
	<div class="col-3">
		<div>
			<select name="website_analysis_website" id="website_analysis_website" class="form-select">
				<?php if(isset($GetAllWebsite) && !empty($GetAllWebsite)){ ?>
				<?php foreach ($GetAllWebsite as $website){ ?>
					<option value="<?= $website['Id'] ?>" <?php if ($website['Id']==1){ ?> selected <?php } ?>><?= $website['Name'] ?></option>
				<?php } } ?>
			</select>
		</div>
	</div>
	<div class="col-3">
		<input type="text" value="<?= date('d/m/Y') ?>" class="form-control" disabled>
	</div>
</div>

<div class="row" id="website_analysis_chart_div">
	<div class="col-12">
		<span id="website_analysis_chart_message" style="display:none;"></span>
<!--		<div id="website_analysis_chart" class="apex-charts mt-3" data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info", "--vz-warning", "--vz-danger", "--vz-dark"]' dir="ltr"></div>-->
		<canvas id="website_analysis_chart" width="400" height="400"></canvas>
		<div class='loading-ct' style="display: none">
			<div class='part_loading'>
				<i class="mdi mdi-spin mdi-loading fa-3x"></i>
			</div>
		</div>
	</div>
</div>

<div class="row mt-4" id="website_analysis_table_div">
	<div class="col-lg-12">
		<div class="live-preview">
			<div class="table-responsive">
				<table class="table table-bordered align-middle table-nowrap mb-0" id="website_analysis_table">
					<thead>
					<tr>
						<th scope="col">Hotel Name</th>
						<th scope="col">Price</th>
						<th scope="col">Room Type</th>
						<th scope="col">Actual Room Type</th>
						<th scope="col">Type</th>
					</tr>
					</thead>
					<tbody>
<!--					--><?php //$own_hotel = $this->session->userdata('own_hotel_name'); ?>
					<?php if(isset($GetHotelReviewRateCompareChartByWebsite) && !empty($GetHotelReviewRateCompareChartByWebsite)) { ?>
						<?php foreach ($GetHotelReviewRateCompareChartByWebsite as $hotel) { ?>
							<?php
							if ($hotel['value'] == "-1"){
								$price = "Sold Out";
							}
							elseif ($hotel['value'] == "-2"){
								$price = "Not Available";
							}
							else{
								$price = '$'.round($hotel['value']);
							}
							?>

							<tr <?php if($hotel['IsCompetitorHotel'] != 1){ ?> style="color: darkblue" <?php } ?>>
								<td><?= $hotel['HotelName'] ?></td>
								<td><?= $price ?></td>
								<td><?= $hotel['MappedRoom'] ?></td>
								<td><?= $hotel['ActualRoomType'] ?></td>
								<td><?= ($hotel['IsCompetitorHotel']==1)?'Competitor':'Own' ?></td>
							</tr>
						<?php } } else {?>
						<tr>
							<td colspan="5" style="text-align: center">No Records Found</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

<!--				<div id='pagination' style="float: right" class="mt-2">--><?//= $pagination ?><!--</div>-->
			</div>
		</div>
		<div class='loading-ct' style="display: none">
			<div class='part_loading'>
				<i class="mdi mdi-spin mdi-loading fa-3x"></i>
			</div>
		</div>
	</div>
	<!-- end col -->
</div>
<hr>
<div class="row mt-4">
	<div class="col-xxl-3 col-md-4">
		<div>
			<select name="website_analysis2_price" id="website_analysis2_price" class="form-select">
				<option value="1">High</option>
				<option value="0" selected>Low</option>
			</select>
		</div>
	</div>
	<div class="col-xxl-3 col-md-4">
		<div>
			<select name="website_analysis2_room_type" id="website_analysis2_room_type" class="form-select">
				<?php if(isset($GetRoomTypeList) && !empty($GetRoomTypeList)){ ?>
					<?php foreach ($GetRoomTypeList as $roomType){ ?>
						<option value="<?= $roomType['Id'] ?>" <?php if ($roomType['Name']=="King"){ ?> selected <?php } ?>><?= $roomType['Name'] ?></option>
					<?php } } ?>
			</select>
		</div>
	</div>
	<div class="col-xxl-3 col-md-4">
		<div>
			<select name="website_analysis2_hotel" id="website_analysis2_hotel" class="form-select">
				<?php if(isset($competitor_hotels) && !empty($competitor_hotels)){ ?>
					<?php foreach ($competitor_hotels as $key=>$hotel){ ?>
						<option value="<?= $hotel['SystemHotel'] ?>" <?php if ($key==0){ ?> selected <?php } ?>><?= $hotel['MappedHotelName'] ?></option>
					<?php } } ?>
			</select>
		</div>
	</div>
</div>

<div class="row" id="website_analysis_chart2_div">
	<div class="col-12">
		<span id="website_analysis_chart2_message" style="display:none;"></span>
		<canvas id="website_analysis_chart2" width="400" height="400" class="chartjs-chart" data-colors='["--vz-primary-rgb, 0.2", "--vz-primary", "--vz-success-rgb, 0.2", "--vz-success"]'></canvas>
		<div class='loading-ct' style="display: none">
			<div class='part_loading'>
				<i class="mdi mdi-spin mdi-loading fa-3x"></i>
			</div>
		</div>
	</div>
</div>

<div class="row mt-4" id="website_analysis_table2_div">
	<div class="col-lg-12">
		<div class="live-preview">
			<div class="table-responsive">
				<table class="table table-bordered align-middle table-nowrap mb-0" id="website_analysis2_table">
					<thead>
					<tr>
						<th scope="col">Website</th>
						<th scope="col">Hotel Name</th>
						<th scope="col">Price</th>
						<th scope="col">Room Type</th>
						<th scope="col">Type</th>
					</tr>
					</thead>
					<tbody>
<!--					--><?php //$own_hotel = $this->session->userdata('own_hotel_name'); ?>
					<?php if(isset($GetDashboardHotelList) && !empty($GetDashboardHotelList)) { ?>
						<?php foreach ($GetDashboardHotelList as $hotel) { ?>
							<?php
							if ($hotel['CRate'] == "-1"){
								$price = "Sold Out";
							}
							elseif ($hotel['CRate'] == "-2"){
								$price = "Not Available";
							}
							else{
								$price = '$'.round($hotel['CRate']);
							}
							?>

							<tr <?php if($hotel['IsCompetitorHotel'] != 1){ ?> style="color: darkblue" <?php } ?>>
							<td><?= get_websitename_by_id($hotel['WebSiteId'])?></td>
								<td><?= $hotel['MappedHotelName'] ?></td>
								<td><?= $price ?></td>
								<td><?= $hotel['OriginalRoomType'] ?></td>
								<td><?= ($hotel['IsCompetitorHotel']==1)?'Competitor':'Own' ?></td>
																
							</tr>
						<?php } } else {?>
						<tr>
							<td colspan="4" style="text-align: center">No Records Found</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

				<div id='website_analysis_table2_pagination' style="float: right" class="mt-2"><?= $pagination ?></div>
			</div>
		</div>
		<div class='loading-ct' style="display: none">
			<div class='part_loading'>
				<i class="mdi mdi-spin mdi-loading fa-3x"></i>
			</div>
		</div>
	</div>
	<!-- end col -->
</div>

<script type="text/javascript">
$(document).ready(function (){
	var GetHotelReviewRateCompareChartByWebsite = <?= (isset($GetHotelReviewRateCompareChartByWebsite)&&!empty($GetHotelReviewRateCompareChartByWebsite)) ? json_encode($GetHotelReviewRateCompareChartByWebsite) : "''" ?>;
	if (GetHotelReviewRateCompareChartByWebsite==''){
		$("#website_analysis_chart").hide();
	}
	else {
		$("#website_analysis_chart").show();
		bar_chart(GetHotelReviewRateCompareChartByWebsite);
	}

	var chart_data = <?= (isset($chart_data)&&!empty($chart_data)) ? json_encode($chart_data) : "''" ?>;
	var GetAllWebsite = <?= (isset($GetAllWebsite)&&!empty($GetAllWebsite)) ? json_encode($GetAllWebsite) : "''" ?>;
	if (chart_data=='' || GetAllWebsite==''){
		$("#website_analysis_chart2").hide();
	}
	else {
		$("#website_analysis_chart2").show();
		hotel_chart(chart_data, GetAllWebsite);
	}
})

$(document).on('change', '#website_analysis_price', function (){
	filter_website_analysis_chart();
})

$(document).on('change', '#website_analysis_room_type', function (){
	filter_website_analysis_chart();
})

$(document).on('change', '#website_analysis_website', function (){
	filter_website_analysis_chart();
})

function bar_chart_apexchart(chart_data){
	var hotel_names = chart_data.map(function(item) {
		return item.name;
	});
	var rates = chart_data.map(function(item) {
		return item.value;
	});

	$("#website_analysis_chart").html("");
	var chartDatalabelsBarColors = getChartColorsArray("website_analysis_chart");
	if(chartDatalabelsBarColors) {
		var options = {
			series: [{
				data: rates
			}],
			chart: {
				type: 'bar',
				height: 600,
			},
			title: {
				text: 'Graph of Website Analysis',
				align: 'center'
			},
			plotOptions: {
				bar: {
					// barHeight: '100%',
					distributed: true,
					borderRadius: 4,
					horizontal: false,
					columnWidth: '30%',
				}
			},
			colors: chartDatalabelsBarColors,
			dataLabels: {
				enabled: false
			},
			stroke: {
				width: 1,
				colors: ["#fff"]
			},
			legend: {
				position: 'top',
			},
			xaxis: {
				categories: hotel_names,
				// labels: {
				// 	style: {
				// 		colors: ["#000"]
				// 	}
				// }
			},
			tooltip: {
				custom: function({ series, seriesIndex, dataPointIndex, w }) {
					return (
						'<div class="arrow_box">' +
						"<span>" +
						w.globals.labels[dataPointIndex] +
						": " +
						series[seriesIndex][dataPointIndex] +
						"</span>" +
						"</div>"
					);
				}
			}
		};

		var chart = new ApexCharts(document.querySelector("#website_analysis_chart"), options);
		chart.render();
	}
}

function bar_chart(chart_data){
	// console.log(chart_data)
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

	Chart.defaults.color = "#000000";
	const chart_exists = Chart.getChart("website_analysis_chart");
	if (chart_exists!=undefined){
		chart_exists.destroy();
	}
	$("#website_analysis_chart").html("");
	var own_hotel = chart_data.filter(function(item) {
		return item.IsCompetitorHotel != 1;
	});

	var hotel_names = chart_data.map(function(item) {
		if(item.IsCompetitorHotel != 1){
			//var hotel = item.HotelName.substring(0,10);
			//return 'My Hotel - ' + hotel;
		}
		else {
			return item.HotelName;
		}
	});

	var rates = chart_data.map(function(item) {		
		if(item.IsCompetitorHotel == 1){
			return item.value;
		}		
	});
	rates = rates.filter(function( element ) {
   	return element !== undefined;
	});
	hotel_names = hotel_names.filter(function( element ) {
   	return element !== undefined;
	});
	
	var own_data = chart_data.filter(function(data) {
		return data.IsCompetitorHotel != "1"; });
	var own_rates = own_data.map(function(item) {
		return item.value;
	});
	var own_data = [];
	$.each(hotel_names, function (index, data) {
		own_data.push(own_rates[0]);
	})

	/*var competitor_data = chart_data.filter(function(data) {
		return data.IsCompetitorHotel == "1"; });
	var competitor_rates = competitor_data.map(function(item) {
		return item.value;
	});

	var own_data = chart_data.filter(function(data) {
		return data.IsCompetitorHotel != "1"; });
	var own_rates = own_data.map(function(item) {
		return item.value;
	});*/

	/*var dataset = [];
	$.each(chart_data, function (index, data) {
		if (data.IsCompetitorHotel == 1){
			dataset.push({
				type: 'bar',
				label: 'Competitors Hotel',
				backgroundColor: data.HotelColor,
				data: data.value,
			});
		}
		else {
			dataset.push({
				type: 'line',
				fill: false,
				label: 'Own Hotel',
				borderColor: data.HotelColor,
				data: data.value,
			});
		}
	})*/

	var bg_colors = chart_data.map(function(item) {
		return item.HotelColor;
	});

	var ctx = document.getElementById('website_analysis_chart');
	ctx.setAttribute("width", ctx.parentElement.offsetWidth);
	var height = '400px';
	if (isMobile){
		height = '500px';
	}
	// console.log("website analysis height:", height);
	ctx.setAttribute("height", height);
	const mixedChart = new Chart(ctx, {
		data: {
			datasets: [{
				type: 'bar',
				label: '',
				backgroundColor: bg_colors,
				barThickness: 50,
				maxBarThickness: 60,
				data: rates
			},
			{
				type: 'line',
				fill: false,
				label: '',
				borderColor: 'rgb(75, 192, 192)',
				borderWidth: 5,
				data: own_data,
				pointRadius: 2,
				pointHitRadius: 5,
			}],
			labels: hotel_names
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				title: {
					display: true,
					align: 'center',
					text: 'Graph of own and competitors hotels comparison',
					font: {
						weight: 'bold',
						size: '17px'
					},
					padding: {
						top: 30,
						bottom: 10
					}
				},
				tooltip: {
					enabled: true,
					callbacks: {
						title: (toolTipItem, data) => {
							let title = toolTipItem[0].label; // uses the x value of this point as the title
							if (toolTipItem[0].dataset.type == "line"){
								title = own_hotel[0].HotelName;
							}
							return title;
						},
						label: function(context) {
							var type = context.dataset.type;
							let label = '';
							if (label) {
								label += ': ';
							}

							let y_val = context.parsed.y;
							if (type == "line"){
								y_val = own_rates[0];
							}
							if (y_val !== null) {
								if (y_val == "-1"){
									label += "Sold Out";
								}
								else if (y_val == "-2"){
									label += "NA";
								}
								else{
									label = label +'$'+Math.round(y_val);
								}
							}
							return label;
						}
					}
				},
				legend: {
					display: false
				}
			},
			scales: {
				y: {
					title: {
						display: true,
						align: 'center',
						text: 'Rate ($)',
						/*font: {
							weight: 'bold'
						},*/
					}
				},
				x: {
					title: {
						display: true,
						align: 'center',
						text: 'Hotels',
						font: {
							weight: 'bold'
						},
					}
				}
			},
			showInlineValues : true,
			centeredInllineValues : true,
			animation: {
				duration: 0,
				onComplete: function() {
					if(!isMobile) {
						const chartInstance = Chart.getChart("website_analysis_chart"),
							ctx = chartInstance.ctx;
						ctx.font = Chart.helpers.fontString(
							18,
							Chart.defaults.defaultFontStyle,
							Chart.defaults.defaultFontFamily
						);
						ctx.textAlign = "center";
						ctx.textBaseline = "bottom";

						this.data.datasets.forEach(function (dataset, i) {
							const meta = chartInstance.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								const data = dataset.data[index];
								ctx.fillStyle = "#000";
								if (data != undefined) {
									var label;
									if (data == "-1") {
										label = "Sold Out";
									} else if (data == "-2") {
										label = "NA";
									} else {
										label = '$' + Math.round(data);
									}
									ctx.fillText(label, bar.x, bar.y - 2);
								}
							});
						});
					}
				}
			},
			hover: {
				// mode: null,
				animationDuration: 0, // duration of animations when hovering an item
			},
			responsiveAnimationDuration: 0,
		}
	});
}

function getChartColorsArray(chartId) {
	if (document.getElementById(chartId) !== null) {
		var colors = document.getElementById(chartId).getAttribute("data-colors");
		colors = JSON.parse(colors);
		// console.log("colors", colors);
		return colors.map(function (value) {
			var newValue = value.replace(" ", "");
			if (newValue.indexOf(",") === -1) {
				var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
				if (color) return color; else return newValue;
			} else {
				var val = value.split(',');
				if(val.length == 2){
					var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
					rgbaColor = "rgba("+rgbaColor+","+val[1]+")";
					return rgbaColor;
				} else {
					return newValue;
				}
			}
		});
	}
}

function filter_website_analysis_chart(need_abort = true){
	var roomTypeId = $("#website_analysis_room_type").val();
	var price = $("#website_analysis_price").val();
	var userId = $("#users_dropdown").val();
	var websiteId = $("#website_analysis_website").val();
	var hotelCode = $("#own_hotels_dropdown").val();

	if (need_abort==true) {
		$.each(xhrPool, function(idx, jqXHR) {
			jqXHR.abort();
		});
	}

	$.ajax({
		url: "<?= base_url('rate_analysis/filter_website_analysis_chart') ?>",
		type: 'POST',
		data: {"roomTypeId": roomTypeId, "price": price, "userId": userId, "websiteId": websiteId, "hotelCode": hotelCode},
		dataType: 'json',
		beforeSend: function(jqXHR){
			xhrPool.push(jqXHR);
			$("#website_analysis_chart_div").find('.loading-ct').show();
			$("#website_analysis_table_div").find('.loading-ct').show();
		},
		success: function(res){
			// console.log(res.data);
			if (res.status == 1) {
				if (res.data == "" || res.data == null) {
					$("#website_analysis_chart").hide();
				} else {
					$("#website_analysis_chart").show();
					bar_chart(res.data);
				}
				$("#website_analysis_table tbody").html(res.html);
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
			$("#website_analysis_chart_div").find('.loading-ct').hide();
			$("#website_analysis_table_div").find('.loading-ct').hide();
		},
		error: function (){
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		}
	});
}

$(document).on('click', '#pagination a', function (e){
	e.preventDefault();
	var pageno = $(this).attr('data-ci-pagination-page');
	change_table_data(pageno, false, false);
})

$("#website_analysis2_price").change(function (){
	change_table_data(1, true, false);
})

$("#website_analysis2_room_type").change(function (){
	change_table_data(1, true, false);
})

$("#website_analysis2_hotel").change(function (){
	change_table_data(1, true, false);
})

function change_table_data(pageno, is_change_chart, is_change_hotels, need_abort = true){
	var roomTypeId = $("#website_analysis2_room_type").val();
	var price = $("#website_analysis2_price").val();
	var userId = $("#users_dropdown").val();
	var hotelName = $("#website_analysis2_hotel option:selected").html();
	var hotelCode = $("#own_hotels_dropdown").val();

	if (need_abort== true && xhr2) {
		xhr2.abort();
	}

	xhr2 = $.ajax({
		url: "<?= base_url('website_analysis/filter_data_hotelwise/') ?>" + pageno,
		type: 'POST',
		data: {"page_no": pageno, "roomTypeId": roomTypeId, "price": price, "userId": userId, "hotelName": hotelName, "is_change_chart": is_change_chart, "is_change_hotels": is_change_hotels, "hotelCode": hotelCode},
		dataType: 'json',
		beforeSend: function(){
			$("#website_analysis_table2_div").find('.loading-ct').show();
			$("#website_analysis_chart2_div").find('.loading-ct').show();
		},
		success: function(res){
			if (res.status == 1) {
				if (is_change_hotels) {
					var html = "";
					$.each(res.hotels, function (key, value) {
						var selected = "";
						if (key == 0) {
							selected = "selected";
						}
						html += `<option value="${value.SystemHotel}" ${selected}>${value.MappedHotelName}</option>`;
					});
					$("#website_analysis2_hotel").html(html);
				}

				if (is_change_chart) {
					$('#website_analysis_table2_pagination').html(res.pagination);
					$('#website_analysis2_table tbody').html(res.html);
					if (res.chart_data == "" || res.websites == "") {
						$("#website_analysis_chart2").hide();
					} else {
						$("#website_analysis_chart2").show();
						hotel_chart(res.chart_data, res.websites);
					}
				} else {
					$('#website_analysis_table2_pagination').html(res.pagination);
					$('#website_analysis2_table tbody').html(res.html);
				}
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
			$("#website_analysis_table2_div").find('.loading-ct').hide();
			$("#website_analysis_chart2_div").find('.loading-ct').hide();
		},
		error: function (){
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		}
	});
}

function hotel_chart(chart_data, websites){
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

	Chart.defaults.color = "#000000";
	const chart_exists = Chart.getChart("website_analysis_chart2");
	if (chart_exists!=undefined){
		chart_exists.destroy();
	}
	$("#website_analysis_chart2").html("");

	var websites = websites.map(function(item) {
		return item.Name;
	});

	var ownData = chart_data.filter(function(data) {
		return data.IsCompetitorHotel != "1"; });
	var competitorData = chart_data.filter(function(data) {
		return data.IsCompetitorHotel == "1"; });

	var own_data = [];
	var competitor_data = [];
	$.each(websites, function (index, val) {
		var own_rate = ownData.filter(function(data) {
			return data.WebSite == val; });
		var own_rate = own_rate.map(function(item) {
			return item.CRate;
		});
		own_data.push(own_rate[0]);

		var competitor_rate = competitorData.filter(function(data) {
			return data.WebSite == val; });
		var competitor_rate = competitor_rate.map(function(item) {
			return item.CRate;
		});
		competitor_data.push(competitor_rate[0]);
	})

	own_data = own_data.map(function(item) {
		if (item == undefined)
			return 0;
		else
			return item;
	});
	competitor_data = competitor_data.map(function(item) {
		if (item == undefined)
			return 0;
		else
			return item;
	});
//	console.log(websites);
// 	console.log(chart_data);
// 	console.log(own_data);
	//console.log(competitor_data);

	var lineChartColor =  getChartColorsArray('website_analysis_chart2');
	var ctx = document.getElementById('website_analysis_chart2');
	var height = '400px';
	if (isMobile){
		height = '500px';
	}
	ctx.setAttribute("height", height);
	var lineChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: websites,
			datasets: [
				{
					label: "Competitor Hotels",
					fill: true,
					lineTension: 0.5,
					backgroundColor: lineChartColor[0],
					borderColor: lineChartColor[1],
					borderCapStyle: 'butt',
					borderDash: [],
					borderDashOffset: 0.0,
					borderJoinStyle: 'miter',
					pointBorderColor: "#fff",
					pointBackgroundColor: lineChartColor[1],
					pointBorderWidth: 1,
					pointHoverRadius: 5,
					pointHoverBackgroundColor: lineChartColor[1],
					pointHoverBorderColor: "#fff",
					pointHoverBorderWidth: 2,
					pointRadius: 4,
					pointHitRadius: 10,
					spanGaps: true,
					data: competitor_data
				},
				{
					label: "Own Hotel",
					fill: true,
					lineTension: 0.5,
					backgroundColor: lineChartColor[2],
					borderColor: lineChartColor[3],
					borderCapStyle: 'butt',
					borderDash: [],
					borderDashOffset: 0.0,
					borderJoinStyle: 'miter',
					pointBorderColor: "#eef0f2",
					pointBackgroundColor: lineChartColor[3],
					pointBorderWidth: 1,
					pointHoverRadius: 5,
					pointHoverBackgroundColor: lineChartColor[3],
					pointHoverBorderColor: "#eef0f2",
					pointHoverBorderWidth: 2,
					pointRadius: 4,
					pointHitRadius: 10,
					spanGaps: true,
					data: own_data
				}
			]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			x: {
				ticks: {
					font: {
						family: 'Poppins',
					},
				},
			},
			y: {
				ticks: {
					font: {
						family: 'Poppins',
					},
				},
			},
			plugins: {
				legend: {
					labels: {
						// This more specific font property overrides the global property
						font: {
							family: 'Poppins',
						}
					}
				},
				title: {
					display: true,
					align: 'center',
					text: 'Graph of own and competitors hotels comparison',
					font: {
						weight: 'bold',
						size: '17px'
					},
					padding: {
						top: 30,
						bottom: 10
					}
				},
				tooltip: {
					enabled: true,
					backgroundColor: '#000',
					callbacks: {
						label: function(context) {
							let label = '';

							if (label) {
								label += ': ';
							}
							if (context.parsed.y !== null) {
								if (context.parsed.y == "-1"){
									label += "Sold Out";
								}
								else if (context.parsed.y == "-2"){
									label += "NA";
								}
								else{
									//console.log(context.parsed.y);
									label = label +'$'+Math.round(context.parsed.y);
								}
							}
							return label;
						}
					}
				},
			},
			scales: {
				y: {
					title: {
						display: true,
						align: 'center',
						text: 'Rate ($)',
						/*font: {
							weight: 'bold'
						},*/
					}
				},
				x: {
					title: {
						display: true,
						align: 'center',
						text: 'Websites',
						font: {
							weight: 'bold'
						},
					}
				}
			},
			animation: {
				duration: 0,
				onComplete: function() {
					if(!isMobile) {
						const chartInstance = Chart.getChart("website_analysis_chart2"),
							ctx = chartInstance.ctx;
						ctx.font = Chart.helpers.fontString(
							18,
							Chart.defaults.defaultFontStyle,
							Chart.defaults.defaultFontFamily
						);
						ctx.textAlign = "center";
						ctx.textBaseline = "bottom";

						this.data.datasets.forEach(function (dataset, i) {
							const meta = chartInstance.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								const data = dataset.data[index];
								ctx.fillStyle = "#000";
								if (data != undefined) {
									var label;
									if (data == "-1") {
										label = "Sold Out";
									} else if (data == "-2") {
										label = "NA";
									} else {
										label = '$' + Math.round(data);
									}
									ctx.fillText(label, bar.x, bar.y - 2);
								}
							});
						});
					}
				}
			},
			hover: {
				// mode: null,
				animationDuration: 0, // duration of animations when hovering an item
			},
			responsiveAnimationDuration: 0,
		},
	});
}
</script>
