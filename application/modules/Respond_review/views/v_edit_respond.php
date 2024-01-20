<?php include 'layouts/head-main.php'; ?>

<head>
    <title> Edit Respond </title>
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
                            <h4 class="mb-sm-0">Edit Respond</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void();">Review Management</a></li>
									<li class="breadcrumb-item"><a href="<?= base_url('review_management/respond_review') ?>">Respond Review</a></li>
									<li class="breadcrumb-item active">Edit Respond</li>
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
                                    <h5 class="card-title mb-0 flex-grow-1">Edit Respond</h5>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <form method="post" id="edit_respond">
                                    <input type="hidden" name="id" value="<?= $respond['id'] ?>">
									<input type="hidden" name="customer" value="<?= $respond['client_id'] ?>">
									<input type="hidden" name="attachments" value="<?= $respond['attachments'] ?>">
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Hotel Name</label>
												<select name="hotel_name" id="hotel_name" class="form-control" disabled>
													<?php foreach ($GetAllhotels as $hotel) { ?>
														<option value="<?= $hotel['id'] ?>" <?php if ($respond['hotel_id'] == $hotel['id']) { echo 'selected'; } ?>><?= $hotel['hotel_name'] ?></option>
													<?php } ?>
												</select>
												<label id="hotel_name-error" class="error" for="hotel_name"></label>
											</div>
										</div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Website</label>
                                                <select name="website" id="website" class="form-control" disabled>
													<?php foreach ($GetAllWebsite as $website){ ?>
														<option value="<?= $website['id'] ?>" <?php if ($respond['website_id'] == $website['id']) { echo 'selected'; } ?>><?= $website['name'] ?></option>
													<?php } ?>
                                                </select>
                                                <label id="website-error" class="error" for="website"></label>
                                            </div>
                                        </div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">No. of Positive Reviews</label>
												<input type="number" name="positive_review" id="positive_review" class="form-control" value="<?= $respond['positive_review'] ?>">
												<label id="positive_review-error" class="error" for="positive_review"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">No. of Negative Review</label>
												<input type="number" name="negative_review" id="negative_review" class="form-control" value="<?= $respond['negative_review'] ?>">
												<label id="negative_review-error" class="error" for="negative_review"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Total Reviews</label>
												<input type="number" name="total_review" id="total_review" class="form-control" value="<?= $respond['total_reviews'] ?>">
												<label id="total_review-error" class="error" for="total_review"></label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Notes</label>
												<textarea name="notes" id="notes" class="form-control"><?= $respond['notes'] ?></textarea>
												<label id="notes-error" class="error" for="notes"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Positive Review Description</label>
												<textarea name="positive_description" id="positive_description" class="form-control"><?= $respond['positive_description'] ?></textarea>
												<label id="positive_description-error" class="error" for="positive_description"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Negative Review Description</label>
												<textarea name="negative_description" id="negative_description" class="form-control"><?= $respond['negative_description'] ?></textarea>
												<label id="negative_description-error" class="error" for="negative_description"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Respond Date</label>
												<input type="date" name="respond_date" value="<?= date('Y-m-d', strtotime($respond['respond_date'])); ?>" id="respond_date" class="form-control" disabled>
												<label id="respond_date-error" class="error" for="respond_date"></label>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label"> Have You Responded</label><br>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="is_responded"
														id="inlineRadio1" value="true"
														<?php echo $respond['is_responded']  == '1' ? 'checked' : ''; ?>>
													<label class="form-check-label" for="inlineRadio1">Yes</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="is_responded"
														id="inlineRadio2" value="false"
														<?php echo $respond['is_responded']  == '0' ? 'checked' : ''; ?>>
													<label class="form-check-label" for="inlineRadio2">No</label>
												</div>
											</div>
											<label id="is_responded-error" class="error" for="is_responded"></label>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Upload Attachments</label>
												<input type="file" name="images[]" id="attachments" class="form-control" value="Upload" multiple="multiple">
												<div class="d-flex gap-2" id="display_attachment_list">
													<?php if (isset($respond['attachments']) && $respond['attachments']!=""){
														$attachments = explode(",", $respond['attachments']);
													}
													$i=1;
													if (isset($attachments) && !empty($attachments)){
													foreach ($attachments as $attachment) {?>
														<div class="ic-sing-file d-flex" id="<?= $i ?>"><a id="<?= $i ?>" title="<?= $attachment ?>" href="<?= base_url('assets/respond_attachments/'.$attachment) ?>" target="_blank" class="old_image"><?= $attachment ?></a><span class="close" id="<?= $i ?>" style="cursor: pointer" image="<?= $attachment ?>">X</span></div>
														<?php $i++;
													}
													} ?>
												</div>
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
var input_file = document.getElementById('attachments');
var remove_products_ids = [];
var product_dynamic_id = <?= $i ?>;
var uploaded_images = [];
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

$(document).on("click", "#save_respond", function() {
	$(this).attr('disabled', 'disabled');
	var formData = new FormData($('#edit_respond')[0]);
	formData.append('hotel_name', $("#hotel_name").val());
	formData.append('website', $("#website").val());
	formData.append('respond_date', $("#respond_date").val());
	var thi = $(this);

	for (var x = 0; x < uploaded_images.length; x++) {
		formData.append("files[]", uploaded_images[x]);
	}

	$(".old_image").each(function (){
		var image = $(this).attr('title');
		formData.append("old_images[]", image);
	})

    if (validate_edit_respond_form()) {
        $.ajax({
            url: "<?php echo base_url() . 'update_respond'; ?>",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            success: function(res) {
                if (res.status == "error") {
                    $("#error_toast").attr('data-toast-text', res.error);
                    $("#error_toast").trigger('click');
                } else if (res.status == 0) {
                    $("#error_toast").attr('data-toast-text', "Responded Review already exist on this website.");
                    $("#error_toast").trigger('click');
                } else if (res.status == 1) {
                    $("#success_toast").attr('data-toast-text', "Respond Updated successfully.");
                    $("#success_toast").trigger('click');
                    redirect_listpage();
                } else if (res.status == 404) {
                    $('#session_expired_modal').modal('show');
                    setTimeout(function() {
                        location.reload();
                    }, auto_refresh_page_sec);
                } else {
                    $("#error_toast").attr('data-toast-text', "Something went wrong!!");
                    $("#error_toast").trigger('click');
                }
            },
			complete: function () {
				$(thi).removeAttr("disabled");
			},
            error: function() {
                $("#error_toast").attr('data-toast-text', "Something went wrong!!");
                $("#error_toast").trigger('click');
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
    location.href = "<?php echo base_url('respond_review') ?>";
}

function validate_edit_respond_form() {
    $('#edit_respond').validate({
		rules: {
			hotel_name: {
				required: true,
			},
			website: {
				required: true,
			},
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

    if ($("#edit_respond").valid()) {
        return true;
    } else {
        return false;
    }
}
</script>
