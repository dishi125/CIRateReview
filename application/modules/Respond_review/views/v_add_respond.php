<?php include 'layouts/head-main.php'; ?>

<head>
    <title> Add Respond </title>
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
                            <h4 class="mb-sm-0">Add Respond</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void();">Review Management</a></li>
									<li class="breadcrumb-item"><a href="<?= base_url('review_management/respond_review') ?>">Respond Review</a></li>
                                    <li class="breadcrumb-item active">Add Respond</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">Add Respond</h5>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <form method="post" id="add_respond">
									<div id="hotel_website_pair_error" class="error" style="display: block"></div>
									<div id="added_hotels_div"></div>
									<div class="row" id="add_hotel_div">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Hotel Name</label>
												<select name="hotel_name" id="hotel_name" class="form-control respond_hotel_name">
													<option value=""></option>
													<?php if (isset($GetAllhotels) && !empty($GetAllhotels)){
													foreach ($GetAllhotels as $hotel) { ?>
													<option value="<?= $hotel['id'] ?>"><?= $hotel['hotel_name'] ?></option>
													<?php }
													}?>
												</select>
												<label id="hotel_name-error" class="error" for="hotel_name" style="display: block"></label>
											</div>
										</div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Website</label>
                                                <select name="website" id="website" class="form-control">
                                                    <option value=""></option>
                                                    <?php if (isset($GetAllWebsite) && !empty($GetAllWebsite)) {
													foreach ($GetAllWebsite as $website) { ?>
                                                    <option value="<?= $website['id'] ?>"><?= $website['name'] ?></option>
                                                    <?php }
													}?>
                                                </select>
                                                <label id="website-error" class="error" for="website" style="display: block"></label>
                                            </div>
                                        </div>
										<div class="col-xxl-3 col-md-4">
											<label for="labelInput" class="form-label"></label>
											<button type="button" id="add_hotel_btn" class="btn btn-soft-secondary waves-effect waves-light form-control"><i class="ri-add-line align-bottom me-1"></i> Add</button>
										</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">No. of Positive Reviews</label>
                                                <input type="number" name="positive_review" id="positive_review" class="form-control">
                                                <label id="positive_review-error" class="error" for="positive_review"></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">No. of Negative Review</label>
                                                <input type="number" name="negative_review" id="negative_review" class="form-control">
                                                <label id="negative_review-error" class="error" for="negative_review"></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Total Reviews</label>
                                                <input type="number" name="total_review" id="total_review" class="form-control">
                                                <label id="total_review-error" class="error" for="total_review"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Notes</label>
												<textarea name="notes" id="notes" class="form-control"></textarea>
                                                <label id="notes-error" class="error" for="notes"></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Positive Review Description</label>
												<textarea name="positive_description" id="positive_description" class="form-control"></textarea>
                                                <label id="positive_description-error" class="error" for="positive_description"></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Negative Review Description</label>
												<textarea name="negative_description" id="negative_description" class="form-control"></textarea>
                                                <label id="negative_description-error" class="error" for="negative_description"></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Respond Date</label>
                                                <input type="date" name="respond_date" id="respond_date" class="form-control" value="<?= date('Y-m-d') ?>">
                                                <label id="respond_date-error" class="error" for="respond_date"></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label"> Have You Responded</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_responded" id="inlineRadio1" value="true">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_responded" id="inlineRadio2" value="false">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
											<label id="is_responded-error" class="error" for="is_responded"></label>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Upload Attachments</label>
												<input type="file" name="images[]" id="attachments" class="form-control" value="Upload" multiple="multiple">
												<div class="d-flex gap-2" id="display_attachment_list"></div>
											</div>
										</div>
                                    </div>

                                    <div class="text-end mb-3 mt-3">
                                        <button type="button"
                                            class="btn btn-outline-danger waves-effect waves-light w-lg"
                                            id="cancel_btn">Cancel</button>
                                        <button type="button" class="btn btn-info waves-effect waves-light w-lg"
                                            id="save_respond">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- end card -->
                    </div><!-- end col -->
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

<div aria-live="polite" aria-atomic="true">
	<!-- Position it -->
	<div style="position: absolute; top: 3rem; right: 0; z-index: 99999;" class="bg-warning">
		<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="message_toast">
			<div class="toast-header bg-warning">
				<strong class="mr-auto" style="color: red; display: none">Message</strong>
				<button type="button" class="ms-auto mb-1 close" data-dismiss="toast" aria-label="Close" data-delay="5000" id="message_toast_close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="toast-body" id="message_toast_body">
				Some Toast Body
			</div>
		</div>
	</div>
</div>

<button type="button" id="error_toast" data-toast data-toast-text="" data-toast-gravity="top"
    data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs"
    data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="" data-toast-gravity="top"
    data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs"
    data-toast-classname="success"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url() . 'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
var all_hotel_names = <?= json_encode($GetAllhotels) ?>;
var all_websites = <?= json_encode($GetAllWebsite) ?>;
var input_file = document.getElementById('attachments');
var remove_products_ids = [];
var product_dynamic_id = 0;
var uploaded_images = [];
$(document).ready(function() {
    $("#website").select2({
        placeholder: "Select Website",
    });

    $("#hotel_name").select2({
        placeholder: "Select Hotel Name",
    });
})

$(document).on('change','#attachments', function(event) {
	var len = input_file.files.length;

	for(var j=0; j<len; j++) {
		var src = "";
		var name = event.target.files[j].name;
		var mime_type = event.target.files[j].type.split("/");
		if (!hasExtension(name, ['.html', '.svg', '.jpg', '.jpeg', '.png', '.txt', '.doc', '.excel', '.docx', '.mp4', '.mp3', '.mpeg', '.ppt', '.pptx', '.rar', '.zip', '.tif', '.tiff', '.wav', '.xls', '.xlsx', '.pdf'])) {
			alert("attachment must be html, svg,jpg,png,jpeg,txt,doc, excel,docx,mp4,mp3,mpeg,ppt,pptx,rar,zip,tif, tiff,wav,xls,xlsx,pdf");
		}
		else {
			uploaded_images.push(event.target.files[j]);
			src = URL.createObjectURL(event.target.files[j]);
			$('#display_attachment_list').append("<div class='ic-sing-file d-flex' id='" + product_dynamic_id + "'><a id='" + product_dynamic_id + "' title='" + name + "' href='" + src + "' target='_blank'>" + name + "</a><span class='close' id='" + product_dynamic_id + "' style='cursor: pointer' image='" + name + "'>X</span></div>");
			product_dynamic_id++;
		}
	}
});
$(document).on('click','span.close', function() {
	var id = $(this).attr('id');
	var image_name = $(this).attr('image');
	remove_products_ids.push(id);
	$('div#'+id).remove();
	// if(("li").length == 0) document.getElementById('attachments').value="";
	$.each(uploaded_images, function(key, value) {
		if(value.name == image_name) {
			uploaded_images.splice(key, 1);
			return false; // breaks
		}
	});
});

function hasExtension(fileName, exts) {
	return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
}

function GetHotelNameBycustomer(){
	var customer = $("#users_dropdown").val();

	$("#added_hotels_div").html("");
	$("#add_hotel_div").show();

	$.ajax({
		url: "<?php echo base_url().'GetHotelNameByWebsite'; ?>",
		method: "POST",
		data: {"customer":customer},
		success: function (res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				$("#hotel_name").select2('destroy').val("").select2({
					placeholder: "Select Hotel Name",
				});
				$('#hotel_name').html(res.html);
				all_hotel_names = res.GetAllhotels;
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

$(document).on("click", "#save_respond", function() {
	$(this).attr('disabled', 'disabled');
	var formData = new FormData($('#add_respond')[0]);
    var userId = $("#users_dropdown").val();
    if (userId != '') {
        formData.append('customer', userId);
    }
	var thi = $(this);

	formData.append('hotel_id_1', $("#hotel_name").val());
	formData.append('hotel_name_1', $("#hotel_name option:selected").html());
	formData.append('website_id_1', $("#website").val());
	formData.append('website_name_1', $("#website option:selected").html());

	var cnt = 2;
	$("#added_hotels_div .row").each(function (){
		formData.append('hotel_id_'+cnt, parseInt($(this).find('.selected_hotel_name').attr('hotel-id')));
		formData.append('website_id_'+cnt, parseInt($(this).find('.selected_website').attr('website-id')));
		formData.append('hotel_name_'+cnt, $(this).find('.selected_hotel_name').val());
		formData.append('website_name_'+cnt, $(this).find('.selected_website').val());
		cnt++;
	})
	formData.append('total_added_hotels', cnt);

	for (var x = 0; x < uploaded_images.length; x++) {
		formData.append("files[]", uploaded_images[x]);
	}

	$(".error").html("");
	if (validate_add_respond_form()) {
        $.ajax({
            url: "<?php echo base_url() . 'save_respond'; ?>",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(res) {
                if (res.status == 1) {
					var html = "";
					$.each(res.success, function (index, value){
						html += `<p style="color: green">${value}</p>`;
					})

					$.each(res.errors, function (index, value){
						html += `<p style="color: red">${value}</p>`;
					})

					if (html!="") {
						$("#message_toast_body").html(html);
						// $(".toast").toast({ autohide: false });
						$("#message_toast").toast('show');
					}

					if (res.errors.length == 0){
						redirect_listpage();
					}
                }
				else if (res.status == 404) {
                    $('#session_expired_modal').modal('show');
                    setTimeout(function() {
                        location.reload();
                    }, auto_refresh_page_sec);
                }
				else {
                    $("#error_toast").attr('data-toast-text', "Something went wrong!!");
                    $("#error_toast").trigger('click');
                }
            },
            error: function() {
				$(thi).removeAttr("disabled");
				$("#error_toast").attr('data-toast-text', "Something went wrong!!");
                $("#error_toast").trigger('click');
            },
			complete: function () {
				$(thi).removeAttr("disabled");
			}
        });
    }
	else {
		$(thi).removeAttr("disabled");
	}
})

$(document).on('click', '#cancel_btn', function() {
    redirect_listpage();
})

function redirect_listpage() {
	location.href = "<?php echo base_url('review_management/respond_review') ?>";
}

function validate_add_respond_form() {
	var validate = false;
    $('#add_respond').validate({
        rules: {
			/*hotel_name: {
				required: true,
			},
            website: {
                required: true,
            },*/
            positive_review: {
                required: true,
            },
            negative_review: {
                required: true,
            },
			total_review: {
				required: true,
			},
			/*notes :{
				required: true,
			},*/
            positive_description: {
                required: true,
            },
            negative_description: {
                required: true,
            },
            respond_date: {
                required: true,
            },
            is_responded: {
                required: true,
            },
        },
    });

	if ($("#added_hotels_div").html() == "" && $("#hotel_name").val()=="" && $("#website").val()==""){
		$("#hotel_website_pair_error").html("Please select atleast one hotel.");
		validate = false;
	}
	else {
		validate = true;
	}

    if ($("#add_respond").valid() && validate==true) {
        return true;
    } else {
        return false;
    }
}

$(document).on("click", "#add_hotel_btn", function (){
	var hotel_name = $("#hotel_name option:selected").html();
	var website = $("#website option:selected").html();
	var hotel_id = $("#hotel_name").val();
	var website_id = $("#website").val();

	var html = `<div class="row">
				<div class="col-xxl-3 col-md-7">
					<div>
						<label for="labelInput" class="form-label">Hotel Name</label>
						<input type="text" name="selected_hotel_name" id="selected_hotel_name" class="form-control selected_hotel_name" hotel-id="${hotel_id}" value="${hotel_name}" readonly>
					</div>
				</div>
				<div class="col-xxl-3 col-md-2">
					<div>
						<label for="labelInput" class="form-label">Website</label>
						<input type="text" name="selected_website" id="selected_website" class="form-control selected_website" website-id="${website_id}" value="${website}" readonly>
					</div>
				</div>
				<div class="col-xxl-3 col-md-3">
					<label for="labelInput" class="form-label"></label>
					<button type="button" id="remove_btn" class="btn btn-soft-danger waves-effect waves-light form-control">- Remove</button>
				</div>
				</div>`;

	$("#hotel_name-error").html("");
	$("#website-error").html("");

	if ($("#hotel_name").val() == "" || $("#hotel_name").val() == null){
		$("#hotel_name-error").html("Please select hotel.");
		$("#hotel_name-error").show();
	}
	else if ($("#website").val() == "" || $("#website").val() == null){
		$("#website-error").html("Please select website.");
		$("#website-error").show();
	}
	else {
		$("#added_hotels_div").append(html);

		var select_hotel_name_arr = [];
		$(".selected_hotel_name").each(function (){
			select_hotel_name_arr.push($(this).val());
		})
		$("#hotel_name").html("");
		$("#hotel_name").select2('destroy').val("").select2({
			placeholder: "Select Hotel Name",
			width: '100%'
		});
		$("#hotel_name").append(`<option value=""></option>`);
		$.each(all_hotel_names, function( key, value ) {
			if (select_hotel_name_arr.includes(value.hotel_name)) {
			}
			else{
				$("#hotel_name").append(`<option value="${value.id}">${value.hotel_name}</option>`);
			}
		})

		/*var select_website_arr = [];
		$(".selected_website").each(function (){
			select_website_arr.push($(this).val());
		})
		$("#website").html("");
		$("#website").select2('destroy').val("").select2({
			placeholder: "Select Website",
			width: '100%'
		});
		$("#website").append(`<option value=""></option>`);
		$.each(all_websites, function( key, value ) {
			if (select_website_arr.includes(value.name)) {
			}
			else{
				$("#website").append(`<option value="${value.id}">${value.name}</option>`);
			}
		})*/

		if ($("#hotel_name option").length <= 1){
			$("#add_hotel_div").hide();
		}
		else{
			$("#add_hotel_div").show();
		}
	}
})

$(document).on('click', "#remove_btn", function (){
	$(this).parents('.row:first').remove();
	var select_hotel_name = $("#hotel_name option:selected").html();
	var select_website = $("#website option:selected").html();

	var select_hotel_name_arr = [];
	$(".selected_hotel_name").each(function (){
		select_hotel_name_arr.push($(this).val());
	})
	$("#hotel_name").html("");
	$("#hotel_name").select2('destroy').val("").select2({
		placeholder: "Select Hotel Name",
		width: '100%'
	});
	$("#hotel_name").append(`<option value=""></option>`);
	$.each(all_hotel_names, function( key, value ) {
		if (select_hotel_name_arr.includes(value.hotel_name)) {
		}
		else{
			var selected = "";
			if (select_hotel_name == value.hotel_name){
				selected = "selected";
			}
			$("#hotel_name").append(`<option value="${value.id}" ${selected}>${value.hotel_name}</option>`);
		}
	})

	/*var select_website_arr = [];
	$(".selected_website").each(function (){
		select_website_arr.push($(this).val());
	})
	$("#website").html("");
	$("#website").select2('destroy').val("").select2({
		placeholder: "Select Website",
		width: '100%'
	});
	$("#website").append(`<option value=""></option>`);
	$.each(all_websites, function( key, value ) {
		if (select_website_arr.includes(value.name)) {
		}
		else{
			var selected = "";
			if (select_website == value.Name){
				selected = "selected";
			}
			$("#website").append(`<option value="${value.id}" ${selected}>${value.name}</option>`);
		}
	})*/

	if ($("#hotel_name option").length <= 1){
		$("#add_hotel_div").hide();
	}
	else{
		$("#add_hotel_div").show();
	}
})

$('body').on('click','#message_toast_close',function(){
	$(this).closest('#message_toast').toast('hide');
})
</script>

</body>
</html>
