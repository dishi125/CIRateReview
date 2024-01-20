<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Edit Employee Report </title>
	<?php include 'layouts/title-meta.php'; ?>

	<?php include 'layouts/head-css.php'; ?>
	<!--Material Design Iconic Font-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
							<h4 class="mb-sm-0">Edit Employee Report</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="<?= base_url('employee_report') ?>">Employee Report</a></li>
									<li class="breadcrumb-item active">Edit Employee Report</li>
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
									<h5 class="card-title mb-0 flex-grow-1">Edit Employee Report</h5>
								</div>
							</div>

							<div class="card-body pt-0">
								<form method="post" id="Edit_employee_report" enctype="multipart/form-data">
									<input type="hidden" name="id" value="<?= $employee_report['id'] ?>">
									<input type="hidden" name="customer" value="<?= $employee_report['user_id'] ?>">
									<input type="hidden" name="attachments" value="<?= $employee_report['attachments'] ?>">
									<?php
									$break_hours = explode(":",$employee_report['break_hours']);
									$break_hours_hh = $break_hours[0];
									$break_hours_mm = $break_hours[1];
									?>
									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Start Time</label>
												<input type="time" id="start_time" name="start_time" class="form-control" value="<?= isset($employee_report['start_time']) ? date('H:i',strtotime($employee_report['start_time'])) : '' ?>">
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">End Time</label>
												<input type="time" id="end_time" name="end_time" class="form-control" value="<?= isset($employee_report['end_time']) ? date('H:i',strtotime($employee_report['end_time'])) : '' ?>">
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Total Time</label>
												<input type="text" class="form-control" id="total_time" name="total_time" readonly value="<?= isset($employee_report['total_time']) ? date('H:i:s',strtotime($employee_report['total_time'])) : '' ?>">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-4">
											<div>
												<label for="labelInput" class="form-label">Total Break Time</label>
												<div class="d-flex gap-2">
													<select name="break_hours_hh" id="break_hours_hh" class="form-select">
														<?php for ($i=0; $i<24; $i++){
															if ($i < 10) {
																$i = "0".$i;
															} ?>
															<option value="<?= $i ?>" <?php if ($i==$break_hours_hh){ ?> selected <?php } ?>><?= $i ?></option>
														<?php } ?>
													</select>
													<select name="break_hours_mm" id="break_hours_mm" class="form-select">
														<?php for ($i=0; $i<=59; $i++){
															if ($i < 10) {
																$i = "0".$i;
															} ?>
															<option value="<?= $i ?>" <?php if ($i==$break_hours_mm){ ?> selected <?php } ?>><?= $i ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-8">
											<div>
												<label for="labelInput" class="form-label">Upload Attachments</label>
												<input type="file" name="images[]" id="attachments" class="form-control" value="Upload" multiple="multiple">
												<div class="d-flex gap-2" id="display_attachment_list">
													<?php if (isset($employee_report['attachments']) && $employee_report['attachments']!=""){
														$attachments = explode(",", $employee_report['attachments']);
													}
													$i=1;
													foreach ($attachments as $attachment) {?>
														<div class="ic-sing-file d-flex" id="<?= $i ?>"><a id="<?= $i ?>" title="<?= $attachment ?>" href="<?= base_url('assets/employee_reports/' . str_replace(" ", "_", $employee_report['user_name']).'/'.$attachment) ?>" target="_blank" class="old_image"><?= $attachment ?></a><span class="close" id="<?= $i ?>" style="cursor: pointer" image="<?= $attachment ?>">X</span></div>
													<?php $i++;
													} ?>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Description</label>
												<textarea class="form-control" id="desc" name="desc"><?= $employee_report['description'] ?></textarea>
											</div>
										</div>
										<div class="col-xxl-3 col-md-4">
											<div>
												<label for="labelInput" class="form-label">Date</label>
												<input type="text" name="date" id="date" class="form-control" value="<?= date("d-m-Y", strtotime($employee_report['date'])) ?>" readonly>
											</div>
										</div>
									</div>

									<div class="text-end mb-3 mt-3">
										<button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg" id="cancel_btn">Cancel</button>
										<button type="submit" class="btn btn-info waves-effect waves-light w-lg" id="save_employee_report">Save</button>
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

<button type="button" id="error_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
var input_file = document.getElementById('attachments');
var remove_products_ids = [];
var product_dynamic_id = <?= $i ?>;
var uploaded_images = [];
$(document).on('change','#attachments', function(event) {
	var len = input_file.files.length;

	for(var j=0; j<len; j++) {
		uploaded_images.push(event.target.files[j]);
		var src = "";
		var name = event.target.files[j].name;
		var mime_type = event.target.files[j].type.split("/");
		src = URL.createObjectURL(event.target.files[j]);
		$('#display_attachment_list').append("<div class='ic-sing-file d-flex' id='"+product_dynamic_id+"'><a id='" + product_dynamic_id + "' title='"+name+"' href='"+src+"' target='_blank'>"+name+"</a><span class='close' id='" + product_dynamic_id + "' style='cursor: pointer' image='"+name+"'>X</span></div>");
		product_dynamic_id++;
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

$(document).on('click', '#cancel_btn', function() {
	$(this).attr('disabled','disabled');
	location.href = "<?php echo base_url('employee_report'); ?>";
})

$(document).on('change', '#start_time, #end_time', function (){
	if($("#start_time").val()!="" && $("#end_time").val()!="") {
		var start_time = moment($("#start_time").val(), "HH:mm:ss");
		var end_time = moment($("#end_time").val(), "HH:mm:ss");
		var hrs = moment.utc(end_time.diff(start_time)).format("HH");
		var min = moment.utc(end_time.diff(start_time)).format("mm");
		var sec = moment.utc(end_time.diff(start_time)).format("ss");
		var total_time = [hrs, min, sec].join(':');
		$("#total_time").val(total_time);
	}
	else {
		$("#total_time").val("");
	}
})

$(document).on("click", "#save_employee_report", function() {
	$(this).attr('disabled', 'disabled');
	var formData = new FormData($('#Edit_employee_report')[0]);

	for (var x = 0; x < uploaded_images.length; x++) {
		formData.append("files[]", uploaded_images[x]);
	}

	$(".old_image").each(function (){
		var image = $(this).attr('title');
		formData.append("old_images[]", image);
	})

	var thi = $(this);

	if (validate_edit_employee_report_form()) {
		$.ajax({
			url: "<?php echo base_url() . 'save_employee_report'; ?>",
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
					$("#error_toast").attr('data-toast-text', res.error);
					$("#error_toast").trigger('click');
				} else if (res.status == 1) {
					$("#success_toast").attr('data-toast-text', "Employee report Updated successfully.");
					$("#success_toast").trigger('click');
					location.href = "<?php echo base_url('employee_report'); ?>";
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

function validate_edit_employee_report_form(){
	$('#Edit_employee_report').validate({
		rules: {
			start_time: {
				required: true,
			},
			end_time: {
				required: true,
			},
			/*total_time: {
				required: true,
			},*/
			desc: {
				required: true,
			},
			date: {
				required: true,
			},
		},
	});

	if ($("#Edit_employee_report").valid()) {
		return true;
	} else {
		return false;
	}
}
</script>
