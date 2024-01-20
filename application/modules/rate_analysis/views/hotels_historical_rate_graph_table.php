<div class="row">
	<div class="col-xxl-3 col-md-4">
		<div>
			<select name="hotels_historical_rate_room_type" id="hotels_historical_rate_room_type" class="form-select">
				<?php if (isset($GetRoomTypeList) && !empty($GetRoomTypeList)) { ?>
					<?php foreach ($GetRoomTypeList as $roomType) { ?>
						<option value="<?= $roomType['Id'] ?>" <?php if ($roomType['Name'] == "King") { ?> selected <?php } ?>>
							<?= $roomType['Name'] ?></option>
					<?php }
				} ?>
			</select>
		</div>
	</div>
	<div class="col-xxl-3 col-md-4">
		<div>
			<select name="hotels_historical_rate_website" id="hotels_historical_rate_website" class="form-select">
				<?php if (isset($GetAllWebsite) && !empty($GetAllWebsite)) { ?>
					<?php foreach ($GetAllWebsite as $website) { ?>
						<option value="<?= $website['Id'] ?>" <?php if ($website['Id'] == 1) { ?> selected <?php } ?>>
							<?= $website['Name'] ?></option>
					<?php }
				} ?>
			</select>
		</div>
	</div>
	<div class="col-xxl-3 col-md-4">
		<div>
			<select name="hotels_historical_rate_hotel" id="hotels_historical_rate_hotel" class="form-select">
				<?php if (isset($Hoteldropdownfilter) && !empty($Hoteldropdownfilter)) { ?>
					<?php foreach ($Hoteldropdownfilter as $key => $hotel) { ?>
						<option value="<?= $hotel['SystemHotel'] ?>" <?php if ($key == 0) { ?> selected <?php } ?>>
							<?= $hotel['MappedHotelName'] ?></option>
					<?php }
				} else {?>
					<option value="" selected disabled>No competitor's hotels found</option>
				<?php } ?>
			</select>
		</div>
	</div>
</div>

<div class="row mb-3 mt-3" id="own_hotel_historical_rate_table_div">
	<div class="col-lg-12">
		<div class="live-preview">
			<div class="table-responsive">
				<table class="table table-bordered align-middle table-nowrap" id="own_hotel_historical_rate_table">
					<?php if (isset($ownHistoricalData) && !empty($ownHistoricalData)) { ?>
						<thead>
						<tr>
							<th rowspan="2" style="text-align: center; vertical-align: middle">Own Hotel</th>
							<?php $all_dates_cnt = array_count_values(array_column($ownHistoricalData, 'date')); ?>
							<?php foreach ($all_dates_cnt as $key => $val) { ?>
								<th colspan="<?= $val ?>" style="text-align: center"><?= $key ?></th>
							<?php } ?>
						</tr>
						<tr>
							<?php foreach ($ownHistoricalData as &$own_data) { ?>
								<?php
								$own_data['scrapedate'] = date("m/d/Y h:i A", strtotime($own_data['scrapedate']));
								$own_data['time'] = date("g:i A", strtotime($own_data['time']));
								?>
								<th><?= $own_data['time'] ?></th>
							<?php } ?>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td><?= $ownHistoricalData[0]['hotelname'] ?></td>
							<?php foreach ($ownHistoricalData as &$own_data) { ?>
								<?php $own_data['price'] = round((float)$own_data['price']); ?>
								<?php
								if ($own_data['price'] == "-1") {
									$price = "Sold Out";
								} elseif ($own_data['price'] == "-2") {
									$price = "Not Available";
								} else {
									$price = '$' . $own_data['price'];
								}
								?>
							<td><?= $price ?></td>
							<?php } ?>
						</tr>
						</tbody>
					<?php } else { ?>
						<tbody>
						<tr>
							<td>Own Historical Data</td>
						</tr>
						<tr>
							<td style="text-align: center">No records found</td>
						</tr>
						</tbody>
					<?php } ?>
				</table>
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

<div class="row mb-3 mt-5" id="competitor_hotel_historical_rate_table_div">
	<div class="col-lg-12">
		<div class="live-preview">
			<div class="table-responsive">
				<table class="table table-bordered align-middle table-nowrap"
					   id="competitor_hotel_historical_rate_table">
					<?php if (isset($competitorHistoricalData) && !empty($competitorHistoricalData)) { ?>
						<thead>
						<tr>
							<th rowspan="2" style="text-align: center; vertical-align: middle">Competitor Hotel</th>
							<?php $all_dates_cnt = array_count_values(array_column($competitorHistoricalData, 'date')); ?>
							<?php foreach ($all_dates_cnt as $key => $val) { ?>
							<th colspan="<?= $val ?>" style="text-align: center"><?= $key ?></th>
							<?php } ?>
						</tr>
						<tr>
							<?php foreach ($competitorHistoricalData as &$competitor_data) { ?>
								<?php
								$competitor_data['scrapedate'] = date("m/d/Y h:i A", strtotime($competitor_data['scrapedate']));
								$competitor_data['time'] = date("g:i A", strtotime($competitor_data['time']));
								?>
								<th><?= $competitor_data['time'] ?></th>
							<?php } ?>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td><?= $competitorHistoricalData[0]['hotelname'] ?></td>
							<?php foreach ($competitorHistoricalData as &$competitor_data) { ?>
								<?php $competitor_data['price'] = round((float)$competitor_data['price']); ?>
								<?php
								if ($competitor_data['price'] == "-1") {
									$price = "Sold Out";
								} elseif ($competitor_data['price'] == "-2") {
									$price = "Not Available";
								} else {
									$price = '$' . $competitor_data['price'];
								}
								?>
								<td><?= $price ?></td>
							<?php } ?>
						</tr>
						</tbody>
					<?php } else { ?>
						<tbody>
						<tr>
							<td>Competitor Historical Data</td>
						</tr>
						<tr>
							<td style="text-align: center">No records found</td>
						</tr>
						</tbody>
					<?php } ?>
				</table>
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

<div class="row" id="hotels_historical_rate_chart_div">
	<div class="col-lg-12 chartWrapper">
		<!--		<canvas id="hotels_historical_rate_chart" width="1200" height="400" class="chartjs-chart" data-colors='["--vz-primary-rgb, 0.2", "--vz-primary", "--vz-success-rgb, 0.2", "--vz-success"]'></canvas>-->
		<div class="chartAreaWrapper">
			<canvas id="hotels_historical_rate_chart" width="1200" height="400" class="chartjs-chart" data-colors='["--vz-primary-rgb, 0.2", "--vz-primary", "--vz-success-rgb, 0.2", "--vz-success"]'></canvas>
		</div>
	</div>
	<!-- end col -->
</div>

<!--<div class="chartWrapper">
	<div class="chartAreaWrapper">
		<div class="chartAreaWrapper2">
			<canvas id="myChart"></canvas>
		</div>
	</div>
	<canvas id="myChartAxis1" height="300" width="0"></canvas>
</div>-->

<script type="text/javascript">
	$(document).ready(function() {
		var ownHistoricalData = <?= (isset($ownHistoricalData) && !empty($ownHistoricalData)) ? json_encode($ownHistoricalData) : "''" ?>;
		var competitorHistoricalData = <?= (isset($competitorHistoricalData) && !empty($competitorHistoricalData)) ? json_encode($competitorHistoricalData) : "''" ?>;
		var scrape_dates = <?= (isset($scrape_dates) && !empty($scrape_dates)) ? json_encode($scrape_dates) : "''" ?>;
		if ((ownHistoricalData == '' && competitorHistoricalData == '') || scrape_dates == '') {
			$("#hotels_historical_rate_chart").hide();
		} else {
			$("#hotels_historical_rate_chart").show();
			chart_hotels_historical_rate(ownHistoricalData, competitorHistoricalData, scrape_dates);
		}
		// demo_chart();
	})

	function demo_chart() {
		var ctx = document.getElementById("myChart").getContext("2d");

		var chart = {
			options: {
				responsive: true,
				maintainAspectRatio: false,
				animation: {
					onComplete: function(animation) {
						// var myLiveChart = Chart.getChart("myChart");
						console.log(myLiveChart);
						var sourceCanvas = myLiveChart.canvas;
						var copyWidth = myLiveChart.scales.y.width - 10;
						var copyHeight = myLiveChart.scales.y.height + myLiveChart.scales.y.top + 10;
						var targetCtx = document.getElementById("myChartAxis").getContext("2d");
						targetCtx.canvas.width = copyWidth;
						targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth, copyHeight, 0, 0, copyWidth, copyHeight);
					}
				}
			},
			type: 'line',
			data: {
				labels: ["January", "February", "March", "April", "May", "June", "July"],
				datasets: [{
					label: "My First dataset",
					fillColor: "rgba(220,220,220,0.2)",
					strokeColor: "rgba(220,220,220,1)",
					pointColor: "rgba(220,220,220,1)",
					pointStrokeColor: "#fff",
					pointHighlightFill: "#fff",
					pointHighlightStroke: "rgba(220,220,220,1)",
					data: [65, 59, 80, 81, 56, 55, 40]
				},
					{
						label: "My Second dataset",
						fillColor: "rgba(151,187,205,0.2)",
						strokeColor: "rgba(151,187,205,1)",
						pointColor: "rgba(151,187,205,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(151,187,205,1)",
						data: [28, 48, 40, 19, 86, 27, 90]
					}
				]
			}
		};

		var myLiveChart = new Chart(ctx, chart);

		setInterval(function() {
			myLiveChart.data.datasets[0].data.push(Math.random() * 100);
			myLiveChart.data.labels.push("Test");
			var newwidth = $('.chartAreaWrapper2').width() + 60;
			$('.chartAreaWrapper2').width(newwidth);
			$('.chartAreaWrapper').animate({
				scrollLeft: newwidth
			});
		}, 5000);
	}

	$(document).on('change', "#hotels_historical_rate_website", function() {
		filter_hotels_historical_rate_data(true);
	})

	$(document).on('change', "#hotels_historical_rate_room_type", function() {
		filter_hotels_historical_rate_data(false);
	})

	$(document).on('change', "#hotels_historical_rate_hotel", function() {
		filter_hotels_historical_rate_data(false);
	})

	function chart_hotels_historical_rate(ownHistoricalData, competitorHistoricalData, scrape_dates) {
		let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
		// console.log(ownHistoricalData);
		// console.log(competitorHistoricalData);
		/*var labels1 = ownHistoricalData.map(function(item) {
			return item.scrapedate;
		});
		var labels2 = competitorHistoricalData.map(function(item) {
			return item.scrapedate;
		});
		var labels = $.merge(labels1, labels2);
		var unique_labels = labels.filter(function(item, i, labels) {
			return i == labels.indexOf(item);
		});
		unique_labels.sort();*/
		// console.log(unique_labels);

		var own_data = [];
		var competitor_data = [];
		$.each(scrape_dates, function(index, val) {
			if (ownHistoricalData != '') {
				var own_rate = ownHistoricalData.filter(function(data) {
					return data.scrapedate == val;
				});
				var own_rate = own_rate.map(function(item) {
					return item.price;
				});
				own_data.push(own_rate[0]);
			}

			if (competitorHistoricalData != '') {
				var competitor_rate = competitorHistoricalData.filter(function(data) {
					return data.scrapedate == val;
				});
				var competitor_rate = competitor_rate.map(function(item) {
					return item.price;
				});
				competitor_data.push(competitor_rate[0]);
			}
		})

		// console.log(own_data);
		// console.log(competitor_data);

		/*var own_data = [];
		$.each(ownHistoricalData, function (index, val) {
			own_data.push({x: val.scrapedate, y: Math.round(val.price)});
		});

		var competitor_data = [];
		$.each(competitorHistoricalData, function (index, val) {
			competitor_data.push({x: val.scrapedate, y: Math.round(val.price)});
		});*/

		Chart.defaults.color = "#000000";
		const chart_exists = Chart.getChart("hotels_historical_rate_chart");
		if (chart_exists != undefined) {
			chart_exists.destroy();
		}
		$("#hotels_historical_rate_chart").html("");
		var lineChartColor = getChartColorsArray('hotels_historical_rate_chart');
		var ctx = document.getElementById('hotels_historical_rate_chart');
		var height = '400px';
		if (isMobile) {
			height = '500px';
		}
		ctx.setAttribute("height", height);
		var lineChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: scrape_dates,
				datasets: [{
					label: "Competitor Hotel",
					fill: true,
					lineTension: 0.5,
					backgroundColor: lineChartColor[0],
					borderColor: lineChartColor[1],
					borderCapStyle: 'butt',
					borderDash: [],
					borderDashOffset: 0.0,
					borderJoinStyle: 'miter',
					pointBorderColor: lineChartColor[1],
					pointBackgroundColor: "#fff",
					pointBorderWidth: 1,
					pointHoverRadius: 5,
					pointHoverBackgroundColor: lineChartColor[1],
					pointHoverBorderColor: "#fff",
					pointHoverBorderWidth: 2,
					pointRadius: 1,
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
						pointBorderColor: lineChartColor[3],
						pointBackgroundColor: "#fff",
						pointBorderWidth: 1,
						pointHoverRadius: 5,
						pointHoverBackgroundColor: lineChartColor[3],
						pointHoverBorderColor: "#eef0f2",
						pointHoverBorderWidth: 2,
						pointRadius: 1,
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
						text: 'Graph of own and competitors hotel comparison',
						font: {
							weight: 'bold'
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
									if (context.parsed.y == "-1") {
										label += "Sold Out";
									} else if (context.parsed.y == "-2") {
										label += "NA";
									} else {
										label = label + '$' + Math.round(context.parsed.y);
									}
								}
								return label;
							}
						},
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
							text: 'Scrape Time',
							padding: 5,
							font: {
								weight: 'bold'
							},
						}
					}
				},
				animation: {
					duration: 0,
					/*onComplete: function() {
						if (!isMobile) {
							const chartInstance = Chart.getChart("hotels_historical_rate_chart"),
								ctx = chartInstance.ctx;
							ctx.font = Chart.helpers.fontString(
								18,
								Chart.defaults.defaultFontStyle,
								Chart.defaults.defaultFontFamily
							);
							ctx.textAlign = "center";
							ctx.textBaseline = "bottom";

							this.data.datasets.forEach(function(dataset, i) {
								const meta = chartInstance.getDatasetMeta(i);
								meta.data.forEach(function(bar, index) {
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
					}*/
				},
				hover: {
					// mode: null,
					animationDuration: 0, // duration of animations when hovering an item
				},
				responsiveAnimationDuration: 0,
				interaction: {
					mode: 'index',
					axis: 'x',
					intersect: false,
				},
			},
		});
	}

	function filter_hotels_historical_rate_data(is_change_hotels, need_abort = true) {
		var roomTypeId = $("#hotels_historical_rate_room_type").val();
		var userId = $("#users_dropdown").val();
		var websiteId = $("#hotels_historical_rate_website").val();
		var hotelId = $("#hotels_historical_rate_hotel").val();
		var hotelCode = $("#own_hotels_dropdown").val();

		if (need_abort == true) {
			$.each(xhrPool, function(idx, jqXHR) {
				jqXHR.abort();
			});
		}

		$.ajax({
			url: "<?= base_url('rate_analysis/filter_hotels_historical_rate_data') ?>",
			type: 'POST',
			data: {
				"roomTypeId": roomTypeId,
				"userId": userId,
				"websiteId": websiteId,
				"hotelId": hotelId,
				"is_change_hotels": is_change_hotels,
				"hotelCode": hotelCode
			},
			dataType: 'json',
			beforeSend: function(jqXHR) {
				xhrPool.push(jqXHR);
				$("#own_hotel_historical_rate_table_div").find('.loading-ct').show();
				$("#competitor_hotel_historical_rate_table_div").find('.loading-ct').show();
				$("#hotels_historical_rate_chart_div").find('.loading-ct').show();
			},
			success: function(res) {
				if (res.status == 1) {
					if (is_change_hotels) {
						$("#hotels_historical_rate_hotel").html(res.hotel_dropdown_html);
					}
					$("#own_hotel_historical_rate_table").html(res.own_html);
					$("#competitor_hotel_historical_rate_table").html(res.competitor_html);
					if ((res.ownHistoricalData == "" && res.competitorHistoricalData == "") || res.scrape_dates == "") {
						$("#hotels_historical_rate_chart").hide();
					} else {
						$("#hotels_historical_rate_chart").show();
						chart_hotels_historical_rate(res.ownHistoricalData, res.competitorHistoricalData, res.scrape_dates);
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
			complete: function(data) {
				$("#own_hotel_historical_rate_table_div").find('.loading-ct').hide();
				$("#competitor_hotel_historical_rate_table_div").find('.loading-ct').hide();
				$("#hotels_historical_rate_chart_div").find('.loading-ct').hide();
			},
			error: function (){
				/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
				$("#error_toast").trigger('click');*/
			}
		});
	}

	function change_hotels() {
		var websiteId = $("#hotels_historical_rate_website").val();

		$.ajax({
			url: "<?= base_url('rate_analysis/Hoteldropdownfilter') ?>",
			type: 'POST',
			data: {
				"websiteId": websiteId
			},
			dataType: 'json',
			success: function(res) {
				var hotels = res.hotels;
				var html = "";
				$.each(hotels, function(key, value) {
					var selected = "";
					if (key == 0) {
						selected = "selected";
					}
					html += `<option value="${value.SystemHotel}" ${selected}>${value.MappedHotelName}</option>`;
				})
				$("#hotels_historical_rate_hotel").html(html);
			}
		}).then(function() {
			filter_hotels_historical_rate_data();
		});
	}

	function line_chart_hotels_historical_rate(times, rates) {
		$("#hotels_historical_rate_chart").html("");
		$("#hotels_historical_rate_chart").empty();

		if (times == "") {
			times = [0, 0];
		}
		if (rates == "") {
			rates = [0, 0];
		}
		times.shift(); // theRemovedElement == 1
		rates.shift(); // theRemovedElement == 1
		if (times.length > 90) {
			var times = times.slice(0, 90);
		}
		if (rates.length > 90) {
			var rates = rates.slice(0, 90);
		}

		var lineChartGradientColors = getChartColorsArray("hotels_historical_rate_chart");
		if (lineChartGradientColors) {
			var options = {
				series: [{
					name: 'Price',
					data: rates
				}],
				chart: {
					height: 350,
					type: 'line',
					toolbar: {
						show: false
					},
				},
				stroke: {
					width: 5,
					curve: 'smooth'
				},
				xaxis: {
					categories: times,
					labels: {
						rotate: -90,
						rotateAlways: false,
						hideOverlappingLabels: true,
						style: {
							fontSize: '12px',
							// fontFamily: 'Helvetica, Arial, sans-serif',
							// fontWeight: 400,
							cssClass: 'apexcharts-xaxis-label',
						},
					}
				},
				title: {
					text: 'Historical Data of perticular hotel',
					align: 'center',
					style: {
						fontWeight: 500,
					},
				},
				fill: {
					type: 'gradient',
					gradient: {
						shade: 'dark',
						gradientToColors: lineChartGradientColors,
						shadeIntensity: 1,
						type: 'horizontal',
						opacityFrom: 1,
						opacityTo: 1,
						stops: [0, 100, 100, 100]
					},
				},
				markers: {
					size: 2,
					colors: ["#038edc"],
					strokeColors: "#fff",
					strokeWidth: 1,
					hover: {
						size: 5,
					}
				},
				/*yaxis: {
					// min: -10,
					// max: 40,
					title: {
						text: 'Price',
					},
				}*/
			};

			var chart = new ApexCharts(document.querySelector("#hotels_historical_rate_chart"), options);
			chart.render();
		}
	}

	function getChartColorsArray(chartId) {
		if (document.getElementById(chartId) !== null) {
			var colors = document.getElementById(chartId).getAttribute("data-colors");
			if (colors) {
				colors = JSON.parse(colors);
				return colors.map(function(value) {
					var newValue = value.replace(" ", "");
					if (newValue.indexOf(",") === -1) {
						var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
						if (color) return color;
						else return newValue;;
					} else {
						var val = value.split(',');
						if (val.length == 2) {
							var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
							rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
							return rgbaColor;
						} else {
							return newValue;
						}
					}
				});
			}
		}
	}
</script>
