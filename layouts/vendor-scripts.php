<button type="button" id="error_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>

<div class="modal fade" id="session_expired_modal" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body text-center p-5">
				<lord-icon
						src="https://cdn.lordicon.com/tdrtiskw.json"
						trigger="loop"
						colors="primary:#f7b84b,secondary:#405189"
						style="width:130px;height:130px">
				</lord-icon>
				<div class="mt-4 pt-4">
					<h3>Session Expired!</h3>
					<p class="text-muted">Session is expired. Page is going to refresh.</p>
					<!-- Toogle to second dialog -->
					<button class="btn btn-danger" id="btn_session_expired">Ok</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- JAVASCRIPT -->
<script src="<?php echo base_url().'assets/libs/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/libs/simplebar/simplebar.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/libs/node-waves/waves.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/libs/feather-icons/feather.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/pages/plugins/lord-icon-2.1.0.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/plugins.js'; ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript">
xhrPool = [];
var xhr2;
var auto_refresh_page_sec = 10000;
$(document).ready(function (){
    $('#users_dropdown').select2({
		placeholder: "Select Customer",
		// allowClear: true,
		width: '100%'
	});

	// console.log($('#own_hotels_dropdown').html());
	$('#own_hotels_dropdown').select2({
		placeholder: "Select Hotel",
		// allowClear: true,
		width: '100%'
	});
})

$('body').on('change', '#users_dropdown', function (){
	var user_id = $(this).val();
	var page = "<?= isset($page)?$page:'' ?>";

	$.ajax({
		url: "<?php echo base_url().'GetOwnHotelsByCustomer'; ?>",
		method: "POST",
		data: {"user_id": user_id, "page": page},
		success: function (res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				$("#own_hotels_dropdown").select2('destroy').val("").select2({
					placeholder: "Select Hotel",
				});
				$('#own_hotels_dropdown').html(res.html);

				$("#own_hotel_customer").html("");
				if (res.hotel_name) {
					$("#own_hotel_customer").html(res.hotel_name);
				}
				if (res.hotel_color) {
					$("#own_hotel_customer").css('color', res.hotel_color);
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
		error: function (){
			$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');
		},
		complete: function (){
			//rate analysis page active
			if ($('.chart_table').length > 0){
				change_content_tab();
			}
			//Hotel page active
			else if($("#List_Hotel_table").length > 0){
				filterDataBycustomer();
			}
			//Hotel page active
			else if($("#add_hotel").length > 0 || $("#edit_hotel").length > 0){
				if ($(".own_hotel_code_dropdown").length>0) {
					changePropertyDropdownBycustomer();
				}
			}
			//Propery code page active
			else if($("#List_Property_table").length > 0){
				filterPropertyDataBycustomer();
			}
			//Review Summary page active
			else if($("#review_summary_table").length > 0){
				filterReviewSummaryDataBycustomer();
			}
			//Review report page active
			else if($("#table_chart_review_report_div").length > 0){
				filterReviewReportDataBycustomer();
			}
			//Manage Hotel page active
			else if($("#List_Manage_Hotel_table").length > 0){
				filterManageHotelDataBycustomer();
			}
			//Add or edit Credentials page active
			else if($(".cred_hotel_name").length > 0){
				GetHotelNameByWebsite();
			}
			//Manage Credentials page active
			else if($("#List_cred_table").length > 0){
				filterManageCredentialsDataBycustomer();
			}
			//Add respond page active
			else if($(".respond_hotel_name").length > 0){
				GetHotelNameBycustomer();
			}
			//Respond Review page active
			else if($("#List_review_table").length > 0){
				filterRespondReviewDataBycustomer();
			}
			//Add Conclusion page active
			else if($(".conclusion_hotel_name").length > 0){
				GetHotelNameByWebsite();
			}
			//Employee Report page active
			else if($("#List_employee_report_table").length > 0){
				filterEmployeeReportDataBycustomer();
			}
			//View report page active
			else if($("#view_report_data").length > 0){
				filterViewReportDataBycustomer();
			}
			//Conclusion page active
			else if($("#List_conclusion_table").length > 0){
				filterConclusionsData();
			}
		}
	});
})

function changePropertyDropdownBycustomer(){
	var user_id = $('#users_dropdown').val();

	$.ajax({
		url: "<?= base_url('getProperty/') ?>" + user_id,
		method: "POST",
		success: function (res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				$(".own_hotel_code_dropdown").html("");
				$(".own_hotel_code_dropdown").select2('destroy').val("").select2({
					placeholder: "Select Property",
					width: '100%'
				});
				$(".own_hotel_code_dropdown").append(`<option value=""></option>`);
				$.each(res.own_hotels, function (key, value) {
					$(".own_hotel_code_dropdown").append(`<option value="${value.HotelCode}">${value.MappedHotelName}</option>`);
				})
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
		error: function (){
			$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');
		}
	});
}

$('body').on('change', '#own_hotels_dropdown', function (){
	//rate analysis page active
	if ($('.chart_table').length > 0){
		change_content_tab();
	}
	//Hotel page active
	else if($("#List_Hotel_table").length > 0){
		filterDataBycustomer();
	}
	//Respond Review page active
	else if($("#List_review_table").length > 0){
		filterRespondReviewDataBycustomer();
	}
	//Review Summary page active
	else if($("#review_summary_table").length > 0){
		filterReviewSummaryDataBycustomer();
	}
	//Review report page active
	else if($("#table_chart_review_report_div").length > 0){
		filterReviewReportDataBycustomer();
	}
	//View report page active
	else if($("#view_report_data").length > 0){
		filterViewReportDataBycustomer();
	}
	//Conclusion page active
	else if($("#List_conclusion_table").length > 0){
		filterConclusionsData();
	}
})

//on tab/menu click
$('body').on('click', '.abort_ajax', function (){
	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});
	if (xhr2) {
		xhr2.abort();
	}
})

$(document).on('click', '#btn_session_expired', function (){
	location.reload();
})
</script>

