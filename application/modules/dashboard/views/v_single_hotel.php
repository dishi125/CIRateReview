<?php include 'layouts/head-main.php'; ?>

	<head>

		<title>Hotel Details</title>
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
							<h4 class="mb-sm-0">Hotel Details</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
									<li class="breadcrumb-item active">Hotel Details</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header">
								<h3 class="section-title mb-3"><?= $hotel_data[0]['hotel_name'] ?></h3>
							</div>
							<div class="card-body">
								<div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-md-2 row-cols-1">
									<div class="col">
										<div class="card card-animate">
											<a class="card-header bg-soft-primary" role="button" aria-expanded="false" aria-controls="leadDiscovered">
												<h5 class="card-title text-uppercase fw-bold mb-1 fs-16">Star</h5>
												<p class="text-muted mb-0"><?= $hotel_data[0]['star'] ?></p>
											</a>
										</div>
										<div class="card card-animate">
											<a class="card-header bg-soft-secondary" role="button" aria-expanded="false" aria-controls="leadDiscovered">
												<h5 class="card-title text-uppercase fw-bold mb-1 fs-16">Brand</h5>
												<p class="text-muted mb-0"><?= $hotel_data[0]['brand'] ?></p>
											</a>
										</div>
										<div class="card card-animate">
											<a class="card-header bg-soft-success" role="button" aria-expanded="false" aria-controls="leadDiscovered">
												<h5 class="card-title text-uppercase fw-bold mb-1 fs-16">Address</h5>
												<p class="text-muted mb-0"><?= $hotel_data[0]['street_address'] .','.$city_data[0]['city'].','.$city_data[0]['state'].'('.$hotel_data[0]['state'].')' ?></p>
											</a>
										</div>
									</div>

									<div class="col">
										<div class="card card-animate">
											<a class="card-header bg-soft-danger" role="button" aria-expanded="false" aria-controls="contactInitiated">
												<h5 class="card-title text-uppercase fw-bold mb-1 fs-16">Rating</h5>
												<p class="text-muted mb-0"><?= $hotel_data[0]['guest_score'] ?></p>
											</a>
										</div>
										<div class="card card-animate">
											<a class="card-header bg-soft-info" role="button" aria-expanded="false" aria-controls="contactInitiated">
												<h5 class="card-title text-uppercase fw-bold mb-1 fs-16">Tier</h5>
												<p class="text-muted mb-0"><?= $hotel_data[0]['tier'] ?></p>
											</a>
										</div>
									</div>

									<div class="col">
										<div class="card card-animate">
											<a class="card-header bg-soft-warning" role="button" aria-expanded="false" aria-controls="needsIdentified">
												<h5 class="card-title text-uppercase fw-bold mb-1 fs-16">Total available room</h5>
												<p class="text-muted mb-0"><?= $hotel_data[0]['number_of_room'] ?></p>
											</a>
										</div>
										<div class="card card-animate">
											<a class="card-header bg-soft-light" role="button" aria-expanded="false" aria-controls="needsIdentified">
												<h5 class="card-title text-uppercase fw-bold mb-1 fs-16">Review</h5>
												<p class="text-muted mb-0"><?= $hotel_data[0]['reviews'] ?></p>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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
</body>

</html>
