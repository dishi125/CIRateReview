<div class="row">
    <div class="col-3">
        <div>
            <select name="rate_analysis_room_type" id="rate_analysis_room_type" class="form-select">
                <?php if (isset($GetRoomTypeList) && !empty($GetRoomTypeList)) { ?>
                <!--				<option value="" selected>All</option>-->
                <?php foreach ($GetRoomTypeList as $roomType) { ?>
                <option value="<?= $roomType['Id'] ?>" <?php if ($roomType['Id'] == 1) { ?> selected <?php } ?>>
                    <?= $roomType['Name'] ?></option>
                <?php }
                } ?>
            </select>
        </div>
    </div>
    <div class="col-3">
        <div>
            <select name="rate_analysis_price" id="rate_analysis_price" class="form-select">
                <!--				<option value="" selected>All</option>-->
                <option value="1">High</option>
                <option value="0" selected>Low</option>
            </select>
        </div>
    </div>
    <div class="col-3">
        <div>
            <select name="rate_analysis_website" id="rate_analysis_website" class="form-select">
                <option value="" selected>All Websites</option>
                <?php if (isset($GetAllWebsite) && !empty($GetAllWebsite)) { ?>
                <?php foreach ($GetAllWebsite as $website) { ?>
                <option value="<?= $website['Id'] ?>"><?= $website['Name'] ?></option>
                <?php }
                } ?>
            </select>
        </div>
    </div>
	<div class="col-3">
		<input type="text" value="<?= date('d/m/Y') ?>" class="form-control" disabled>
	</div>
</div>

<div class="row" id="rate_analysis_chart_div">
    <div class="col-lg-12">
        <span id="rate_analysis_chart_message" style="display:none;"></span>
        <!--		<div id="rate_analysis_chart" class="apex-charts mt-3 mb-3" data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info", "--vz-warning", "--vz-danger", "--vz-dark"]' dir="ltr"></div>-->
        <canvas id="rate_analysis_chart" width="" height=""></canvas>
        <div class='loading-ct' style="display: none">
            <div class='part_loading'>
                <i class="mdi mdi-spin mdi-loading fa-3x"></i>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>

<div class="row mt-4" id="rate_analysis_table_div">
    <div class="col-lg-12">
        <div class="live-preview">
            <div class="table-responsive">
                <table class="table table-bordered align-middle table-nowrap mb-0" id="rate_analysis_table">
                    <thead>
                        <tr>
                            <th scope="col">Hotels Name</th>
                            <th scope="col">Websites</th>
                            <th scope="col">Room Type</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Days</th>
                            <th scope="col">last 2 hours rate</th>
                            <th scope="col">Changes 2 hours rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--					--><?php //$own_hotel = $this->session->userdata('own_hotel_name'); 
                                                    ?>
                        <?php if (isset($GetDashboardHotelList) && !empty($GetDashboardHotelList)) { ?>
                        <?php foreach ($GetDashboardHotelList as $hotel) { ?>
                        <?php
                                if ($hotel['CRate'] == "-1") {
                                    $CRate = "Sold Out";
                                } elseif ($hotel['CRate'] == "-2") {
                                    $CRate = "Not Available";
                                } else {
                                    $CRate = '$' . round($hotel['CRate']);
                                }

                                if ($hotel['Rate'] == "-1") {
                                    $rate = "Sold Out";
                                } elseif ($hotel['Rate'] == "-2") {
                                    $rate = "Not Available";
                                } else {
                                    $rate = '$' . round($hotel['Rate']);
                                }

                                if ($hotel['CRate'] != "-1" && $hotel['CRate'] != "-2" && $hotel['Rate'] != "-1" && $hotel['Rate'] != "-2") {
                                    $change = round($hotel['CRate'] - $hotel['Rate']);
                                } else {
                                    $change = $hotel['Rate'];
                                }

                                if ($change == "-1") {
                                    $change = "Sold Out";
                                } elseif ($change == "-2") {
                                    $change = "Not Available";
                                } else {
                                    if ($hotel['CRate'] > $hotel['Rate']) {
                                        $change = '<p style="color: limegreen; margin: 0"><i class="ri-arrow-up-s-fill" style="font-size: large"></i>+$' . $change . '</p>';
                                    } else if ($hotel['CRate'] < $hotel['Rate']) {
                                        $change = '<p style="color: red; margin: 0"><i class="ri-arrow-down-s-fill" style="font-size: large"></i>-$' . $change . '</p>';
                                    } else {
                                        $change = '$' . round($change);
                                    }
                                }
                                ?>

                        <tr <?php if ($hotel['IsCompetitorHotel'] == 0) { ?> style="color: darkblue" <?php } ?>>
                            <td><?= $hotel['HotelName'] ?></td>
                            <td><?= $hotel['WebSite'] ?></td>
                            <td><?= $hotel['OriginalRoomType'] ?></td>
                            <td><?= $CRate ?></td>
                            <td>1 Day</td>
                            <td><?= $rate ?></td>
                            <td><?= $change ?></td>
                        </tr>
                        <?php }
                        } else { ?>
                        <tr>
                            <td colspan="7" style="text-align: center">No Records Found</td>
                        </tr>
                        <?php } ?>
                    </tbody>
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

<script type="text/javascript">
var rate_analysis_mixChart;
var ChartHasBeenRendered = false;
$(document).ready(function() {
    var websites = <?= (isset($websites) && !empty($websites)) ? json_encode($websites) : "''" ?>;
    var hotel_rates = <?= (isset($hotel_rates) && !empty($hotel_rates)) ? json_encode($hotel_rates) : "''" ?>;

    if (websites == '' || hotel_rates == '') {
        $("#rate_analysis_chart").hide();
    } else {
        $("#rate_analysis_chart").show();
        mix_chart(websites, hotel_rates);
    }

    $('#pagination').on('click', 'a', function(e) {
        e.preventDefault();
        var pageno = $(this).attr('data-ci-pagination-page');
        loadPagination(pageno);
    });

    $("#rate_analysis_room_type").change(function() {
        rate_analysis_filteration();
    })

    $("#rate_analysis_price").change(function() {
        rate_analysis_filteration();
    })

    $("#rate_analysis_website").change(function() {
        loadPagination(1);
    })
})

function mix_chart_apexcharts(websites, hotel_rates) {
    if (ChartHasBeenRendered == true && rate_analysis_mixChart) {
        rate_analysis_mixChart.destroy();
    }
    $("#rate_analysis_chart").html("");
    // console.log("hotel_rates",hotel_rates);
    // console.log("websites",websites);
    var website_names = websites.map(function(item) {
        return item.Name;
    });

    var GetData = hotel_rates;
    var sitelist = websites;
    let hotlist = [];
    let dataset = [];
    //_------------------------------------placeing data in formate----------------------------------------------

    GetData.forEach((value, key) => {
        hotlist.push({
            hotelname: value.HotelName
        });
    });
    hotlist = hotlist
        .map((item) => item.hotelname)
        .filter(
            (value, index, self) =>
            self.indexOf(value) === index
        );
    hotlist.forEach((indexHotel) => {
        let dataMain = [];
        var HotelRateListDetails = [];
        var isComp = 0;
        var hotelColor = '';
        for (let i = 0; i < sitelist.length; i++) {
            HotelRateListDetails = GetData.filter(function(item) {
                return (
                    item.HotelName === indexHotel && item.WebSiteId == sitelist[i].Id
                );
            });
            if (HotelRateListDetails.length > 0) {
                isComp = HotelRateListDetails[0].IsCompetitorHotel;
                hotelColor = HotelRateListDetails[0].HotelColor;
                // console.log(HotelRateListDetails[0].Rate);
                if (HotelRateListDetails[0].Rate == -2) {
                    dataMain.push('-2');
                } else if (HotelRateListDetails[0].Rate == -1) {
                    dataMain.push('-1');
                } else {
                    dataMain.push(Math.round(HotelRateListDetails[0].Rate));
                }
            } else dataMain.push(0);
        }
        if (isComp == 0) {
            dataset.push({
                type: 'line',
                fill: false,
                name: indexHotel,
                borderColor: hotelColor,
                data: dataMain,
            });
        } else {
            dataset.push({
                type: 'column',
                name: indexHotel,
                backgroundColor: hotelColor,
                data: dataMain,
            });
        }
    });
    console.log("dataset", dataset);

    var options = {
        series: dataset,
        chart: {
            type: 'line',
            height: 400,
        },
        /*plotOptions: {
        	bar: {
        		columnWidth: '20%',
        	}
        },*/
        stroke: {
            width: [0, 5],
            curve: 'smooth',
        },
        title: {
            text: 'Graph of own and competitors hotels comparison',
            align: 'center'
        },
        dataLabels: {
            enabled: false,
            // enabledOnSeries: [1]
        },
        labels: website_names,
        yaxis: {
            title: {
                text: 'Rate ($)'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            enabled: true,
            followCursor: true,
            y: {
                formatter: function(val) {
                    if (val == "-1") {
                        val = "Sold Out";
                    } else if (val == "-2") {
                        val = "NA";
                    } else {
                        val = '$ ' + Math.round(val);
                    }
                    return val;
                }
            }
        }
    };

    //	console.log(options);
    rate_analysis_mixChart = new ApexCharts(document.querySelector("#rate_analysis_chart"), options);
    rate_analysis_mixChart.render().then(() => ChartHasBeenRendered = true);
}

function mix_chart(websites, hotel_rates) {
    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

    Chart.defaults.color = "#000000";
    const chart_exists = Chart.getChart("rate_analysis_chart");
    if (chart_exists != undefined) {
        chart_exists.destroy();
    }
    $("#rate_analysis_chart").html("");
    // console.log("hotel_rates",hotel_rates);
    // console.log("websites",websites);
    var website_names = websites.map(function(item) {
        return item.Name;
    });

    var GetData = hotel_rates;
    var sitelist = websites;
    let hotlist = [];
    let dataset = [];
    //_------------------------------------placeing data in formate----------------------------------------------

    GetData.forEach((value, key) => {
        hotlist.push({
            hotelname: value.HotelName
        });
    });
    hotlist = hotlist
        .map((item) => item.hotelname)
        .filter(
            (value, index, self) =>
            self.indexOf(value) === index
        );
    hotlist.forEach((indexHotel) => {
        let dataMain = [];
        var HotelRateListDetails = [];
        var isComp = 0;
        var hotelColor = '';
        for (let i = 0; i < sitelist.length; i++) {
            HotelRateListDetails = GetData.filter(function(item) {
                return (
                    item.HotelName === indexHotel && item.WebSiteId == sitelist[i].Id
                );
            });
            if (HotelRateListDetails.length > 0) {
                isComp = HotelRateListDetails[0].IsCompetitorHotel;
                hotelColor = HotelRateListDetails[0].HotelColor;
                // console.log(HotelRateListDetails[0].Rate);
                if (HotelRateListDetails[0].Rate == -2) {
                    dataMain.push('-2');
                } else if (HotelRateListDetails[0].Rate == -1) {
                    dataMain.push('-1');
                } else {
                    dataMain.push(Math.round(HotelRateListDetails[0].Rate));
                }
            } else dataMain.push(0);
        }
        if (isComp == 0) {
            dataset.push({
                type: 'line',
                fill: false,
                label: indexHotel,
                borderColor: hotelColor,
                data: dataMain,
            });
        } else {
            dataset.push({
                type: 'bar',
                label: indexHotel,
                backgroundColor: hotelColor,
                data: dataMain,
            });
        }
    });
    // console.log("dataset", dataset);

    var ctx = document.getElementById('rate_analysis_chart');
    ctx.setAttribute("width", ctx.parentElement.offsetWidth);
    var height = '400px';
    if (isMobile) {
        height = '500px';
    }
    ctx.setAttribute("height", height);
    const mixedChart = new Chart(ctx, {
        data: {
            datasets: dataset,
            labels: website_names
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
                        size: '17px',
                    },
                    padding: {
                        top: 30,
                        bottom: 10
                    }
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';

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
                    }
                },
                legend: {
                    display: true,
                    labels: {
                        font: {
                            size: '16px',
                        },
                    }
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
                    },
                    ticks: {
                        font: {
                            weight: 'bold'
                        }
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
                    },
                    ticks: {
                        font: {
                            size: '16px',
                            // weight: 'bold'
                        }
                    }
                }
            },
            animation: {
                onComplete: function() {
                    if (!isMobile) {
                        const chartInstance = Chart.getChart("rate_analysis_chart"),
                            ctx = chartInstance.ctx;
                        // console.log(ctx);
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
                                    var label = "";
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
        }
    });
}

function loadPagination(pageno, need_abort = true){
	var roomTypeId = $("#rate_analysis_room_type").val();
	var price = $("#rate_analysis_price").val();
	var userId = $("#users_dropdown").val();
	var websiteId = $("#rate_analysis_website").val();
	var hotelCode = $("#own_hotels_dropdown").val();

	if (need_abort==true) {
		$.each(xhrPool, function (idx, jqXHR) {
			jqXHR.abort();
		});
	}

    $.ajax({
        url: "<?= base_url('rate_analysis/filter_data/') ?>" + pageno,
        type: 'POST',
        data: {
            "page_no": pageno,
            "roomTypeId": roomTypeId,
            "price": price,
            "userId": userId,
            "websiteId": websiteId,
            "hotelCode": hotelCode
        },
        dataType: 'json',
        beforeSend: function(jqXHR) {
            xhrPool.push(jqXHR);
            $("#rate_analysis_table_div").find('.loading-ct').show();
        },
        success: function(res) {
			if (res.status == 1) {
				$('#pagination').html(res.pagination);
				$('#rate_analysis_table tbody').html(res.html);
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
            $("#rate_analysis_table_div").find('.loading-ct').hide();
        },
		error: function (){
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		}
    });
}

function rate_analysis_filteration(need_abort = true) {
    var roomTypeId = $("#rate_analysis_room_type").val();
    var price = $("#rate_analysis_price").val();
    var userId = $("#users_dropdown").val();
    var hotelCode = $("#own_hotels_dropdown").val();

    if (need_abort == true) {
        $.each(xhrPool, function(idx, jqXHR) {
            jqXHR.abort();
        });
    }

	$.ajax({
		url: "<?= base_url('rate_analysis/filter_chart') ?>",
		type: 'POST',
		data: {"roomTypeId": roomTypeId, "price": price, "userId": userId, "hotelCode": hotelCode},
		dataType: 'json',
		beforeSend: function(jqXHR){
			xhrPool.push(jqXHR);
			$("#rate_analysis_chart_div").find('.loading-ct').show();
			$("#rate_analysis_table_div").find('.loading-ct').show();
		},
		success: function(res){
			if (res.status == 1) {
				if (res.websites == "" || res.hotel_rates == "") {
					$("#rate_analysis_chart").hide();
					loadPagination(1, need_abort);
				} else {
					$("#rate_analysis_chart").show();
					$.when(mix_chart(res.websites, res.hotel_rates)).then(function () {
						loadPagination(1, need_abort);
					})
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
			$("#rate_analysis_chart_div").find('.loading-ct').hide();
			$("#rate_analysis_table_div").find('.loading-ct').hide();
		},
		error: function (){
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		}
	});
}
</script>
