<div class="row mb-3">
    <div class="col-xxl-4 col-md-4">
        <div>
            <select name="website_historical_rate_website" id="website_historical_rate_website" class="form-select">
                <?php if (isset($GetAllWebsite) && !empty($GetAllWebsite)) { ?>
                <?php foreach ($GetAllWebsite as $website) { ?>
                <option value="<?= $website['Id'] ?>" <?php if ($website['Id'] == 1) { ?> selected <?php } ?>>
                    <?= $website['Name'] ?></option>
                <?php }
                } ?>
            </select>
        </div>
    </div>

    <div class="col-xxl-8 col-md-8">
        <ul class="nav nav-tabs" role="tablist" style="float: right">
            <li class="nav-item">
                <a class="nav-link inner_tabs_website_historical active" aria-selected="false"
                    tab-type="calender_view">Calender view</a>
            </li>
            <li class="nav-item">
                <a class="nav-link inner_tabs_website_historical" aria-selected="false" tab-type="table_view">Table
                    view</a>
            </li>
        </ul>
    </div>
</div>

<div id="website_historical_div" class="row">
    <div class="col-12">
        <div id="website_historical_rate_table"></div>
        <div id="website_historical_rate_calendar"></div>
        <div class='loading-ct' style="display: none">
            <div class='part_loading'>
                <i class="mdi mdi-spin mdi-loading fa-3x"></i>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="website_historical_rate_calender_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-bold" id="event_title">Scrollable Modal</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <!--<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
$(document).ready(function() {
    var GetWebsiteHistoricalRate = <?= (isset($GetWebsiteHistoricalRate) && !empty($GetWebsiteHistoricalRate)) ? json_encode($GetWebsiteHistoricalRate) : "''" ?>;
    if (GetWebsiteHistoricalRate == '') {
        website_historical_rate_calendar([]);
    } else {
        website_historical_rate_calendar(GetWebsiteHistoricalRate);
    }
})

$(document).on('click', '#pagination_website_historical_rate a', function(e) {
    e.preventDefault();
    var pageno = $(this).attr('data-ci-pagination-page');
    loadPagination_website_historical_rate(pageno);
});

$(document).on("click", ".inner_tabs_website_historical", function() {
    var thi = $(this);
    var tab_type = $(this).attr('tab-type');
    tab_content(tab_type, $(this));
})

$(document).on('change', '#filter_date', function() {
    loadPagination_website_historical_rate(1);
})

$(document).on('change', '#website_historical_rate_website', function() {
    var tab_type;
    $('.inner_tabs_website_historical').each(function() {
        var thi = $(this);
        if ($(thi).hasClass('active') && $(thi).attr('tab-type') == "table_view") {
            loadPagination_website_historical_rate(1);
        } else if ($(thi).hasClass('active') && $(thi).attr('tab-type') == "calender_view") {
            filter_calender_data();
        }
    })
})

$(document).on('click', 'button.fc-prev-button', function() {
    filter_calender_data();
});

$(document).on('click', 'button.fc-next-button', function() {
    filter_calender_data();
});

function filter_calender_data(need_abort = true) {
	/*var tglCurrent = $('#website_historical_rate_calendar').fullCalendar('getDate');
	var year = tglCurrent.format('YYYY');
	var month = tglCurrent.format('MM');
	var day = tglCurrent.format('DD');
	console.log('Year is '+year+' Month is '+month+' Day is '+day);*/
	var first_cell = $('#website_historical_rate_calendar').fullCalendar('getView').start.format('YYYY-MM-DD');
	var last_cell = $('#website_historical_rate_calendar').fullCalendar('getView').end.format('YYYY-MM-DD');
	var userId = $("#users_dropdown").val();
	var websiteId = $("#website_historical_rate_website").val();
	var start_date = first_cell;
	var end_date = last_cell;
	var hotelCode = $("#own_hotels_dropdown").val();

	if (need_abort == true) {
		$.each(xhrPool, function(idx, jqXHR) {
			jqXHR.abort();
		});
	}

	$.ajax({
		url: "<?= base_url('website_historical_rate/filter_calender_data') ?>",
		type: 'POST',
		data: {
			"userId": userId,
			"websiteId": websiteId,
			"start_date": start_date,
			"end_date": end_date,
			"hotelCode": hotelCode
		},
		dataType: 'json',
		beforeSend: function(jqXHR) {
			xhrPool.push(jqXHR);
			$("#website_historical_div").find('.loading-ct').show();
		},
		success: function(res) {
			if (res.status == 1) {
				if (res != '' && res.event_data != "") {
					var event_data = res.event_data.map(({
															 price,
															 startDateTime,
															 endDateTime
														 }) => ({
						title: price,
						start: moment(startDateTime).format('YYYY-MM-DD'),
						end: moment(endDateTime).format('YYYY-MM-DD')
					}));
				} else {
					var event_data = [];
				}
				//var event_data = res.event_data.map(({price, startDateTime, endDateTime }) => ({ title: price.replace("$", ""), start: moment(startDateTime).format('YYYY-MM-DD'), end: moment(endDateTime).format('YYYY-MM-DD') }));
				$('#website_historical_rate_calendar').fullCalendar('removeEvents', function () {
					return true;
				});
				$('#website_historical_rate_calendar').fullCalendar('addEventSource', event_data, true);
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
			$("#website_historical_div").find('.loading-ct').hide();
		},
		error: function (){
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		}
	});
}

function tab_content(tab_type, element) {
    var userId = $("#users_dropdown").val();
    var websiteId = $("#website_historical_rate_website").val();
    var hotelCode = $("#own_hotels_dropdown").val();

    $.each(xhrPool, function(idx, jqXHR) {
        jqXHR.abort();
    });

    $.ajax({
        url: "<?php echo base_url() . 'rate_analysis/ajax_website_historical_rate'; ?>",
        method: "POST",
        data: {
            "tab_type": tab_type,
            "websiteId": websiteId,
            "userId": userId,
            "hotelCode": hotelCode
        },
        beforeSend: function(jqXHR) {
            xhrPool.push(jqXHR);
            $('#rate_analysis_page_loader').show();
        },
        success: function(res) {
            var res = JSON.parse(res);
			if (res.status == 1) {
				$('#website_historical_rate_calendar').fullCalendar('destroy');
				$('#website_historical_rate_calendar').empty();
				$("#website_historical_rate_calendar").html("");
				$("#website_historical_rate_calendar").removeAttr('class');
				$("#website_historical_rate_table").html("");
				if (tab_type == "calender_view") {
					if (res.event_data == "") {
						website_historical_rate_calendar([]);
					} else {
						website_historical_rate_calendar(res.event_data);
					}
				} else if (tab_type == "table_view") {
					$("#website_historical_rate_table").html(res.table_view_html);
					var date = new Date();
					$('#filter_date').daterangepicker({
						dateFormat: 'yy-mm-dd',
						startDate: moment(date),
						endDate: moment(date).add(1, 'days'),
						locale: {
							format: 'YYYY/MM/DD'
						}
					});
				}
				$(".inner_tabs_website_historical").removeClass('active');
				element.addClass('active');
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
            $('#rate_analysis_page_loader').hide();
        },
		error: function (){
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		}
    });
}

function website_historical_rate_calendar(event_data) {
    // console.log(event_data);
    //var event_data = event_data.map(({ price, startDateTime, endDateTime }) => ({ title: price.replace("$", ""), start: moment(startDateTime).format('YYYY-MM-DD'), end: moment(endDateTime).format('YYYY-MM-DD') }));

    if (event_data.length != 0) {
        event_data = event_data.map(({
            price,
            startDateTime,
            endDateTime
        }) => ({
            title: price,
            start: moment(startDateTime).format('YYYY-MM-DD'),
            end: moment(endDateTime).format('YYYY-MM-DD')
        }));
    } else {
        event_data = [];
    }

    // console.log(event_data.length);
    // console.log(event_data);
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()

    $('#website_historical_rate_calendar').fullCalendar({
        showNonCurrentDates: false,
        header: {
            left: '',
            right: 'prev,next',
            center: 'title',
            // right: 'month,agendaWeek,agendaDay'
        },
        buttonText: {
            today: 'today',
            // month: 'month',
            // week: 'week',
            // day: 'day'
        },
        dayClick: function(date, allDay, jsEvent, view) {
            // console.log(IsDateHasEvent(date));
            if (IsDateHasEvent(date)) {
                var eventDate = moment(date).format("YYYY-MM-DD");
                priceModal(eventDate);
            }
        },
        eventClick: function(date, calEvent, jsEvent, view) {
            var eventDate = moment(date.start).format("YYYY-MM-DD");
            priceModal(eventDate);
        },
        eventRender: function(event, element, view) {
            // console.log(element);
            //if (element.find('span.fc-title').text() != "NA") {
            if (element.find('span.fc-title').text() != "20000") {
                element.find('span.fc-title').html(
                    `<i class="fa-solid fa-dollar-sign" style="font-size: initial; vertical-align: super"></i>` +
                    element.find('span.fc-title').text());
            } else if (element.find('span.fc-title').text() == '') {
                element.find('span.fc-title').html('NS');
            } else if (element.find('span.fc-title').text() == "20000") {
                element.find('span.fc-title').html('NA');
            }
        },
        events: event_data,
    })
}

// check if this day has an event before
function IsDateHasEvent(date) {
    var allEvents = [];
    allEvents = $('#website_historical_rate_calendar').fullCalendar('clientEvents');
    var event = $.grep(allEvents, function(v) {
        return +v.start === +date;
    });
    return event.length > 0;
}

function priceModal(eventDate) {
    var userId = $("#users_dropdown").val();
    var websiteId = $("#website_historical_rate_website").val();
    var hotelCode = $("#own_hotels_dropdown").val();

    $.ajax({
        url: "<?= base_url('website_historical_rate/getDateWiseBookingDetails') ?>",
        type: 'POST',
        data: {
            "eventDate": eventDate,
            "userId": userId,
            "websiteId": websiteId,
            "hotelCode": hotelCode
        },
        dataType: 'json',
        beforeSend: function() {
            $("#website_historical_div").find('.loading-ct').show();
        },
        success: function(res) {
			if (res.status == 1) {
				$("#website_historical_rate_calender_modal #event_title").html(res.date);
				$("#website_historical_rate_calender_modal .modal-body").html(res.html);
				$("#website_historical_rate_calender_modal").modal('show');
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
            $("#website_historical_div").find('.loading-ct').hide();
        },
		error: function (){
			$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');
		}
    });
}

function loadPagination_website_historical_rate(pageno, need_abort = true) {
    var userId = $("#users_dropdown").val();
    var websiteId = $("#website_historical_rate_website").val();
    var date = $("#filter_date").val();
    var hotelCode = $("#own_hotels_dropdown").val();
    // console.log(date);

    if (need_abort == true) {
        $.each(xhrPool, function(idx, jqXHR) {
            jqXHR.abort();
        });
    }

    $.ajax({
        url: "<?= base_url('website_historical_rate/filter_data/') ?>" + pageno,
        type: 'POST',
        data: {
            "page_no": pageno,
            "userId": userId,
            "websiteId": websiteId,
            "date": date,
            "hotelCode": hotelCode
        },
        dataType: 'json',
        beforeSend: function(jqXHR) {
            xhrPool.push(jqXHR);
            $("#website_historical_div").find('.loading-ct').show();
        },
        success: function(res) {
			if (res.status == 1) {
				$('#pagination_website_historical_rate').html(res.pagination);
				$('#website_historical_rate_table_data tbody').html(res.html);
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
            $("#website_historical_div").find('.loading-ct').hide();
        },
		error: function (){
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		}
    });
}
</script>
