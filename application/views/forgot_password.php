
<?php include 'layouts/head-main.php'; ?>

<head>

	<title>Forgot Password</title>
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
								<img src="<?php echo base_url().'assets/images/psmtech_logo.png'; ?>" alt="" height="50">
							</a>
						</div>
<!--						<p class="mt-3 fs-16 fw-semibold">Premium Admin & Dashboard Template</p>-->
					</div>
				</div>
			</div>
			<!-- end row -->

			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6 col-xl-5">
					<div class="card mt-4">

						<div class="card-body p-4">
							<div class="text-center mt-2">
								<h5 class="text-primary">Forgot Password?</h5>
								<p class="text-muted">Forgot password with PSMTech</p>

								<lord-icon
									src="https://cdn.lordicon.com/rhvddzym.json"
									trigger="loop"
									colors="primary:#0ab39c"
									class="avatar-xl">
								</lord-icon>

							</div>
							<div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
								Enter your email and instructions will be sent to you!
							</div>
							<div class="p-2">
								<?php if (isset($success_msg)) { ?>
									<div class="alert alert-success text-center mb-4 mt-4 pt-2" role="alert">
										<?php echo $success_msg; ?>
									</div>
								<?php } elseif (isset($error_msg)) {?>
								<div class="alert alert-danger text-center mb-4 mt-4 pt-2" role="alert">
									<?php echo $error_msg; ?>
								</div>
								<?php } ?>
								<form action="<?php echo base_url().'forgot_password'; ?>" method="post">
									<div class="mb-4 <?php echo isset($useremail_err) ? 'has-error' : ''; ?>">
										<label class="form-label">Email</label>
										<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
										<span class="text-danger"><?php echo isset($useremail_err) ? $useremail_err : ""; ?></span>
									</div>

									<div class="text-center mt-4">
										<button class="btn btn-success w-100" type="submit">Send Reset Link</button>
									</div>
								</form><!-- end form -->
							</div>
						</div>
						<!-- end card body -->
					</div>
					<!-- end card -->

					<div class="mt-4 text-center">
						<p class="mb-0">Wait, I remember my password... <a href="<?php echo base_url().'login' ?>" class="fw-bold text-primary text-decoration-underline"> Click here </a> </p>
					</div>

				</div>
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
						<p class="mb-0 text-muted">© <script>document.write(new Date().getFullYear())</script> PSMTech - All Rights Reserved Made by PSMTech</p>
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
