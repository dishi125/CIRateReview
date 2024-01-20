<?php include 'layouts/head-main.php'; ?>

<head>

	<title>System Analysis</title>
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
							<h4 class="mb-sm-0">System Analysis Dashboard</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item active">System Analysis Dashboard</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<?php if(isset($website_wise_cnt)){
						foreach ($website_wise_cnt as $website){
							$key = array_rand($bg_colors);
							$color = $bg_colors[$key];
							?>
							<div class="col-xl-3 col-md-6">
								<div class="card card-animate <?= $color ?>">
									<div class="card-body">
										<div class="d-flex align-items-center">
											<div class="flex-grow-1">
												<p class="text-uppercase fw-semibold text-black-50 mb-0"><?= $website['website_name'] ?></p>
											</div>
										</div>
										<div class="align-items-end justify-content-between mt-4">
											<div class="d-flex mb-1">
												<h4 class="fs-15 fw-bold ff-secondary text-black-50">Total states: <?= $website['total_states'] ?></h4>
												<button type="button" class="btn btn-light btn-sm ms-auto text-black-50 btn-soft-dark" website-db="<?= $website['website_db'] ?>" id="view_all_states">View All</button>
											</div>
											<div class="d-flex mb-1">
												<h4 class="fs-15 fw-bold ff-secondary text-black-50">Total Cities: <?= $website['total_cities'] ?></h4>
												<button type="button" class="btn btn-light btn-sm ms-auto text-black-50 btn-soft-dark" website-db="<?= $website['website_db'] ?>" id="view_all_cities">View All</button>
											</div>
											<div class="d-flex">
												<h4 class="fs-15 fw-bold ff-secondary text-black-50">Total Hotels: <?= $website['total_hotels'] ?></h4>
												<button type="button" class="btn btn-light btn-sm ms-auto text-black-50 btn-soft-dark" website-db="<?= $website['website_db'] ?>" id="view_all_hotels">View All</button>
											</div>
										</div>
									</div><!-- end card body -->
								</div>
							</div>
						<?php }
					} ?>
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

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- cleave.js -->
<script src="<?php echo base_url().'assets/libs/cleave.js/cleave.min.js'; ?>"></script>
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>
<script type="text/javascript">
$(document).on('click', '#view_all_states', function (){
	var website_db = $(this).attr('website-db');
	location.href = "<?= base_url('view_states/')?>" + website_db;
})

$(document).on('click', '#view_all_cities', function (){
	var website_db = $(this).attr('website-db');
	location.href = "<?= base_url('view_cities/')?>" + website_db;
})

$(document).on('click', '#view_all_hotels', function (){
	var website_db = $(this).attr('website-db');
	location.href = "<?= base_url('view_hotels/')?>" + website_db;
})
</script>

</body>
</html>
