<?php include 'layouts/head-main.php'; ?>

<head>

	<title> Dashboard </title>
	<?php include 'layouts/title-meta.php'; ?>


	<!-- gridjs css -->
	<link rel="stylesheet" href="<?php echo base_url().'assets/libs/gridjs/theme/mermaid.min.css'; ?>">

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
							<h4 class="mb-sm-0">Dashboard</h4>
							<div class="page-title-right">
								<ol class="breadcrumb m-0">
									<li class="breadcrumb-item active">Dashboard</li>
								</ol>
							</div>

						</div>
					</div>
				</div>
				<!-- end page title -->
              
				<div class="row">
					  <!-- Start right Content here -->
            <!-- ============================================================== -->
           

                   

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0 flex-grow-1">Base Example</h4>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div id="table-gridjs"></div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                      

            <!-- end main content-->

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

<!-- prismjs plugin -->

<!-- ecommerce product list -->
<!--<script src="--><?php //echo base_url().'assets/js/pages/ecommerce-product-list.init.js'; ?><!--"></script>-->
<!-- prismjs plugin -->
<script src="<?php echo base_url().'assets/libs/prismjs/prism.js'; ?>"></script>
<script src="<?php echo base_url().'assets/libs/gridjs/gridjs.umd.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/pages/gridjs.init.js'; ?>"></script>

    
<!-- apexcharts -->
<!-- App js -->
<script src="<?php echo base_url().'assets/js/app.js'; ?>"></script>

    
</body>
</html>
