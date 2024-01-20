<?php include 'layouts/head-main.php'; ?>

<head>

    <title> Add Conclusion </title>
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
                            <h4 class="mb-sm-0">Add Conclusion</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void();">Review Management</a></li>
									<li class="breadcrumb-item"><a href="<?= base_url('review_management/respond_review') ?>">Respond Review</a></li>
									<li class="breadcrumb-item"><a href="<?= base_url('conclusion') ?>">Conclusion</a></li>
									<li class="breadcrumb-item active">Add Conclusion</li>
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
                                    <h5 class="card-title mb-0 flex-grow-1">Add Conclusion</h5>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <form method="post" id="add_conclusion">
                                    <div class="row">
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Hotel Name</label>
                                                <select name="hotel_name" id="hotel_name" class="form-control conclusion_hotel_name">
                                                    <option value=""></option>
                                                    <?php if (isset($GetAllhotels) && !empty($GetAllhotels)) {
                                                    foreach ($GetAllhotels as $hotels) { ?>
                                                    <option value="<?= $hotels['id'] ?>"><?= $hotels['hotel_name'] ?></option>
                                                    <?php }
													} ?>
                                                </select>
                                                <label id="hotel_name-error" class="error" for="hotel_name"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Respond Date</label>
                                                <input type="date" name="respond_date" id="respond_date" class="form-control" value="<?= date('Y-m-d') ?>">
                                                <label id="respond_date-error" class="error" for="respond_date"></label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-4">
                                            <div>
                                                <label for="labelInput" class="form-label">Conclusion</label>
												<textarea name="conclusion" id="conclusion" class="form-control"></textarea>
                                                <label id="conclusion-error" class="error" for="conclusion"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mb-3 mt-3">
                                        <button type="button" class="btn btn-outline-danger waves-effect waves-light w-lg"
                                            id="cancel_btn">Cancel</button>
                                        <button type="button" class="btn btn-info waves-effect waves-light w-lg"
                                            id="save_conclusion">Save</button>
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
$(document).ready(function() {
    $("#hotel_name").select2({
        placeholder: "Select Hotel Name",
    });
})

function GetHotelNameByWebsite(){
	var customer = $("#users_dropdown").val();

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

$(document).on("click", "#save_conclusion", function() {
	$(this).attr('disabled', 'disabled');
	var formData = new FormData($('#add_conclusion')[0]);
    var userId = $("#users_dropdown").val();
    if (userId != '') {
        formData.append('customer', userId);
    }
	var thi = $(this);

    if (validate_add_conclusion_form()) {
        $.ajax({
            url: "<?php echo base_url() . 'save_conclusion'; ?>",
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
                    $("#success_toast").attr('data-toast-text', "Conclusion added successfully.");
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
	location.href = "<?php echo base_url('conclusion') ?>";
}

function validate_add_conclusion_form() {
    $('#add_conclusion').validate({
        rules: {
            hotel_name: {
                required: true,
            },
            respond_date: {
                required: true,
            },
			conclusion: {
				required: true,
			}
        },
    });

    if ($("#add_conclusion").valid()) {
        return true;
    } else {
        return false;
    }
}
</script>

</body>
</html>
