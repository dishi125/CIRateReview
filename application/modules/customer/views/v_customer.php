<?php include 'layouts/head-main.php'; ?>
<head>

	<title> Customer </title>
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
							<h4 class="mb-sm-0">Customer</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="javascript:void();">Settings</a></li>
									<li class="breadcrumb-item active">List of Customers</li>
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
									<h5 class="card-title mb-0 flex-grow-1 text-dark">List of Customers</h5>
									<?php if (isset($add) && $add == 1){ ?>
									<div class="flex-shrink-0">
										<button type="button" class="btn btn-success add-btn" id="add_customer_btn"><i class="ri-add-line align-bottom me-1"></i> Add Customer</button>
									</div>
									<?php } ?>
								</div>
							</div>

							<!-- <div class="card-body border border-dashed border-end-0 border-start-0">
								<form>
									<div class="col-xxl-5 col-sm-6">
										<div class="search-box">
											<input type="text" class="form-control search" placeholder="Search for order ID, customer, order status or something...">
											<i class="ri-search-line search-icon"></i>
										</div>
									</div>
								</form>
							</div> -->

							<div class="card-body pt-0 border border-dashed border-end-0 border-start-0">
								<div class="live-preview">
									<div class="table-responsive table-card mb-1 mt-1" style="margin-left: 5px; margin-right: 5px">
										<table class="table table-nowrap align-middle" id="List_Customer_table">
											<thead class="text-dark table-light">
											<tr class="text-uppercase">
												<th>No</th>
												<th>Name</th>
												<th>E-mail</th>
												<th>Property Limit</th>
												<th>Trial Period</th>
												<th>Action</th>
											</tr>
											</thead>
											<tbody class="list">
											<?php if (isset($GetCustomerList)){ ?>
											<?php foreach ($GetCustomerList as $customer){ ?>
												<tr>
													<td><?= $customer['Id'] ?></td>
													<td><?= $customer['UserName'] ?></td>
													<td><?= $customer['UserEmail'] ?></td>
													<td><?= $customer['NoOfProperties'] ?></td>
													<td><?= $customer['TrialPeriod'] ?></td>
													<td>
														<ul class="list-inline hstack gap-2 mb-0">
															<?php if (isset($edit) && $edit == 1){ ?>
															<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
																<a href="<?php echo base_url().'edit_customer/'.$customer['CustomerId']; ?>" class="text-primary d-inline-block edit-item-btn"><i class="ri-pencil-fill fs-16"></i></a>
															</li>
															<?php } ?>

															<?php if (isset($delete) && $delete == 1){ ?>
															<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
																<a class="text-danger d-inline-block remove-item-btn" onclick="delete_customer(<?= $customer['CustomerId'] ?>)"><i class="ri-delete-bin-5-fill fs-16"></i></a>
															</li>
															<?php } ?>
														</ul>
													</td>
												</tr>
											<?php } }?>
											</tbody>
										</table>
									</div>
								</div>
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

<button type="button" id="error_toast" data-toast data-toast-text="Something went wrong!" data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="danger"></button>
<button type="button" id="success_toast" data-toast data-toast-text="Customer Deleted Successfully." data-toast-gravity="top" data-toast-position="right" data-toast-duration="3000" data-toast-close="close" class="btn btn-light w-xs" data-toast-classname="success"></button>

<div class="modal fade zoomIn" id="deleteCustomerModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
			</div>
			<div class="modal-body">
				<div class="mt-2 text-center">
					<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
					<div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
						<h4>Are you sure ?</h4>
						<p class="text-muted mx-4 mb-0">Are you sure you want to remove this role ?</p>
					</div>
				</div>
				<div class="d-flex gap-2 justify-content-center mt-4 mb-2">
					<button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn w-sm btn-danger" id="delete-customer">Yes, Delete It!</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>

<script type="text/javascript">
var table;
$(document).ready(function (){
	table = $("#List_Customer_table").DataTable();
})

$(document).on('click', '#add_customer_btn', function() {
	location.href = "<?php echo base_url('add_customer'); ?>";
})

function delete_customer(CustomerId){
	$("#delete-customer").attr('customer-id',CustomerId);
	$("#deleteCustomerModal").modal('show');
}

$(document).on('click', '#delete-customer', function() {
	var CustomerId = $(this).attr('customer-id');
	$(this).attr('disabled','disabled');
	var thi = $(this);

	$.ajax({
		url: "<?php echo base_url().'delete_customer/'; ?>" + CustomerId,
		method: "POST",
		success: function (res) {
			$(thi).removeAttr("disabled");
			var res = JSON.parse(res);
			if (res.status == 1){
				$("#success_toast").trigger('click');
				table.destroy();
				$("#List_Customer_table tbody").html(res.html);
				table = $("#List_Customer_table").DataTable();
				$("#deleteCustomerModal").modal('hide');
			}
			else if(res.status == 404){
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
		error: function () {
			$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');
			$(thi).removeAttr("disabled");
		}
	});
})
</script>
