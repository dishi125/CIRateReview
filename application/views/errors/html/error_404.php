<?php
$CI =& get_instance();
if( ! isset($CI))
{
    $CI = new CI_Controller();
}
$CI->load->helper('url');
?>

<?php include 'layouts/head-main.php'; ?>

<head>
	<title>404 Error</title>
	<?php include 'layouts/head-css.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- auth-page wrapper -->
<div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">

	<!-- auth-page content -->
	<div class="auth-page-content overflow-hidden p-0">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-7 col-lg-8">
					<div class="text-center">
						<img src="<?php echo base_url().'assets/images/error400-cover.png'; ?>" alt="error img" class="img-fluid">
						<div class="mt-3">
							<h3 class="text-uppercase">Sorry, Page not Found 😭</h3>
							<p class="text-muted mb-4">The page you are looking for not available!</p>
<!--							<a href="index.php" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Back to home</a>-->
						</div>
					</div>
				</div><!-- end col -->
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</div>
	<!-- end auth-page content -->
</div>
<!-- end auth-page-wrapper -->

</body>

</html>
