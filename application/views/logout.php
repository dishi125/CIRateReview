<?php include 'layouts/head-main.php'; ?>

<head>

	<title>Log Out</title>
	<?php include 'layouts/title-meta.php'; ?>

	<?php include 'layouts/head-css.php'; ?>

</head>

<?php include 'layouts/body.php'; ?>

<div class="auth-page-wrapper pt-5">
	<!-- auth page bg -->
	<div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
		<div class="bg-overlay"></div>

		<div class="shape">
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
				<path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
			</svg>
		</div>
	</div>

	<!-- auth page content -->
	<div class="auth-page-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-center mt-sm-5 mb-4 text-white-50">
						<div>
							<a href="" class="d-inline-block auth-logo">
								<img src="<?php echo base_url().'assets/images/psmtech_logo.png'; ?>" alt="PSMTech" height="50">
							</a>
						</div>
					</div>
				</div>
			</div>
			<!-- end row -->

			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6 col-xl-5">
					<div class="card mt-4">
						<div class="card-body p-4 text-center">
							<lord-icon
								src="https://cdn.lordicon.com/hzomhqxz.json"
								trigger="loop"
								colors="primary:#405189,secondary:#08a88a"
								style="width:180px;height:180px">
							</lord-icon>

							<div class="mt-4 pt-2">
								<h4>You are Logged Out</h4>
<!--								<p class="text-muted">Thank you for using <span class="fw-bold">velzon</span> admin template</p>-->
								<div class="mt-4">
									<a href="<?php echo base_url().'login'; ?>" class="btn btn-success w-100">Sign In</a>
								</div>
							</div>
						</div>
						<!-- end card body -->
					</div>
					<!-- end card -->

				</div>
				<!-- end col -->
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</div>
	<!-- end auth page content -->

	<!-- footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-center">
						<p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

<?php include 'layouts/vendor-scripts.php'; ?>

<!-- particles js -->
<script src="<?php echo base_url().'assets/libs/particles.js/particles.js'; ?>"></script>

<!-- particles app js -->
<script src="<?php echo base_url().'assets/js/pages/particles.app.js'; ?>"></script>
</body>

</html>
