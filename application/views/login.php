<?php include 'layouts/head-main.php'; ?>

<head>

	<title>Sign In</title>
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
						<!-- <p class="mt-3 fs-15 fw-semibold">Call Services</p> -->
					</div>
				</div>
			</div>
			<!-- end row -->

			<div class="row justify-content-center">
				<div class="col-md-8 col-lg-6 col-xl-5">
					<div class="card mt-4">

						<div class="card-body p-4">
							<div class="text-center mt-2">
								<h5 class="text-primary">Welcome Back !</h5>
								<p class="text-muted">Sign in to continue to PSMTech.</p>
							</div>
							<div class="p-2 mt-4">
								<?php if($this->session->userdata('success_msg')) { ?>
									<div class="alert alert-success text-center mb-4 mt-4 pt-2" role="alert">
										<?php echo $this->session->userdata('success_msg');
										$this->session->unset_userdata('success_msg');?>
									</div>
								<?php } ?>
								<form action="<?php echo base_url().'login'; ?>" method="post">
									<div class="mb-3 <?php echo (isset($username_err)) ? 'has-error' : ''; ?>">
										<label for="username" class="form-label">Username</label>
										<input type="text" class="form-control" value="<?php echo set_value('username'); ?>" name="username" id="username" placeholder="Enter username">
										<span class="text-danger"><?php echo isset($username_err)?$username_err:""; ?></span>
									</div>

									<div class="mb-3 <?php echo (isset($password_err)) ? 'has-error' : ''; ?>">
										<div class="float-end">
											<a href="<?php echo base_url().'forgot_password' ?>" class="text-muted">Forgot password?</a>
										</div>
										<label class="form-label" for="password-input">Password</label>
										<div class="position-relative auth-pass-inputgroup mb-3">
											<input type="password" class="form-control pe-5" value="<?php echo set_value('password'); ?>" name="password" placeholder="Enter password" id="password-input">
											<span class="text-danger"><?php echo isset($password_err)?$password_err:""; ?></span>
											<button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
										</div>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
										<label class="form-check-label" for="auth-remember-check">Remember me</label>
									</div>

									<div class="mt-4">
										<button class="btn btn-success w-100" type="submit">Sign In</button>
									</div>

									<!--<div class="mt-4 text-center">
										<div class="signin-other-title">
											<h5 class="fs-13 mb-4 title">Sign In with</h5>
										</div>
										<div>
											<button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
											<button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
											<button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
											<button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
										</div>
									</div>-->
								</form>
							</div>
						</div>
						<!-- end card body -->
					</div>
					<!-- end card -->

					<div class="mt-4 text-center">
						<p class="mb-0">Don't Remember Password ? <a href="<?php echo base_url().'forgot_password' ?>" class="fw-bold text-primary text-decoration-underline"> Forgot Password </a> </p>
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
<script src="<?php echo base_url().'assets/js/pages/particles.app.js' ?>"></script>
<!-- password-addon init -->
<script src="<?php echo base_url().'assets/js/pages/password-addon.init.js'; ?>"></script>
</body>

</html>
