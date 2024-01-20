<?php include 'layouts/head-main.php'; ?>

<head>

    <title> Dashboard </title>
    <?php include 'layouts/title-meta.php'; ?>

    <!-- nouisliderribute css -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/libs/nouislider/nouislider.min.css'; ?>">

    <!-- gridjs css -->
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/libs/gridjs/theme/mermaid.min.css'; ?>">

    <?php include 'layouts/head-css.php'; ?>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" type="text/css" media="all" />
</head>

<?php include 'layouts/body.php'; ?>
<?php
$ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
$isMob = is_numeric(strpos($ua, "mobile"));
?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>
    <div class="loading" style="display: none">Loading&#8230;</div>

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
					<div class="col-xxl-2 col-xl-3 col-lg-3">
						<div class="card">
							<div class="card-header">
								<div class="d-flex">
									<div class="flex-grow-1">
										<?php if ($isMob == 1) { ?>
										<button type="button" class="btn btn-info" id="more_filter_btn"> <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters</button>
										<?php } else { ?>
										<h5 class="fs-16">Filters</h5>
										<?php } ?>
									</div>
									<div class="flex-shrink-0">
										<button type="button" id="apply_filter" onclick="apply_filter()" class="btn btn-primary btn-sm" style="font-size: 16px">Search</button>
										<button type="button" class="btn btn-soft-dark btn-sm" id="clearall" onclick="clear_all()" style="font-size: 16px">Reset</button>
									</div>
								</div>
							</div>

							<div class="accordion accordion-flush filter-accordion">
								<div class="card-body border-bottom">
									<div>
										<label for="labelInput"
											   class="form-label mb-0 dashboard_labels">State</label>
										<select class="form-control" id="filter_state" name="filter_state[]"
												multiple disabled>
											<option value=""></option>
											<!-- <?php foreach ($state_data as $state) { ?>
												<option value="<?php echo $state['state_code'] ?>"><?php echo $state['state'] ?></option>
												<?php } ?> -->
										</select>
									</div>
									<div>
										<label for="labelInput"
											   class="form-label mb-0 dashboard_labels">City</label>
										<select class="form-control" id="filter_city" name="filter_city[]" multiple
												disabled>
										</select>
									</div>
									<?php $display = "";
									if ($isMob == 1) {
										$display = "display: none;";
									}?>
									<div style="<?= $display ?>" id="check_in_check_out_date">
										<label for="labelInput" class="form-label mb-0 dashboard_labels">Check In -
											Check Out</label>
										<input type="text" id="filter_date" class="form-control"
											   readonly="readonly">
									</div>
								</div>

								<div class="card-body border-bottom" style="<?= $display ?>" id="price_filter">
									<!--<label for="labelInput"
										   class="form-label mb-0 dashboard_labels">Price</label>
									<div class="d-flex gap-2">
										<input class="form-control form-control-sm" type="text" id="minCost"
											   value="60" />
										<span class="fw-semibold text-muted">to</span>
										<input class="form-control form-control-sm" type="text" id="maxCost"
											   value="5000" />
									</div>-->
									<label for="labelInput" class="form-label dashboard_labels">Price</label>
									<div id="slider-range" class="price-filter-range" name="rangeInput"></div>
									<div class="d-flex gap-2 mt-3">
										<input type="number" min=0 max="100" oninput="validity.valid||(value='60');" id="minCost" class="price-range-field form-control form-control-sm" />
										<span class="fw-semibold text-muted">to</span>
										<input type="number" min=0 max="5000" oninput="validity.valid||(value='5000');" id="maxCost" class="price-range-field form-control form-control-sm" />
									</div>
								</div>

								<div class="accordion-item" style="<?= $display ?>" id="brands_filter_div">
									<h2 class="accordion-header" id="flush-headingBrands">
										<button class="accordion-button bg-transparent shadow-none collapsed" type="button"
												data-bs-toggle="collapse" data-bs-target="#flush-collapseBrands"
												aria-expanded="true" aria-controls="flush-collapseBrands">
											<span class="text-black text-uppercase fs-14 fw-bold">Brands</span>
											<span class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
										</button>
										<div id="selected_brands" style="font-weight: 100; font-size: medium; padding-left: 15px"></div>
									</h2>
									<div id="flush-collapseBrands" class="accordion-collapse collapse"
										 aria-labelledby="flush-headingBrands">
										<div class="accordion-body text-body pt-1">
											<div class="d-flex flex-column gap-2 filter-check" id="brand_filter">
											</div>
										</div>
									</div>
								</div>
								<!-- end accordion-item -->

								<div class="accordion-item" style="<?= $display ?>" id="tiers_filter_div">
									<h2 class="accordion-header" id="flush-headingTier">
										<button class="accordion-button bg-transparent shadow-none collapsed"
												type="button" data-bs-toggle="collapse"
												data-bs-target="#flush-collapseTier" aria-expanded="false"
												aria-controls="flush-collapseTier">
											<span class="text-black text-uppercase fs-14 fw-bold">Tier</span>
											<span class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
										</button>
										<div id="selected_tiers" style="font-weight: 100; font-size: medium; padding-left: 15px"></div>
									</h2>

									<div id="flush-collapseTier" class="accordion-collapse collapse"
										 aria-labelledby="flush-headingTier">
										<div class="accordion-body text-body">
											<div class="d-flex flex-column gap-2 filter-check" id="tier_filter">
											</div>
										</div>
									</div>
								</div>
								<!-- end accordion-item -->

								<div class="accordion-item" style="<?= $display ?>" id="ratings_filter_div">
									<h2 class="accordion-header" id="flush-headingRating">
										<button class="accordion-button bg-transparent shadow-none collapsed"
												type="button" data-bs-toggle="collapse"
												data-bs-target="#flush-collapseRating" aria-expanded="false"
												aria-controls="flush-collapseRating">
											<span class="text-black text-uppercase fs-14 fw-bold">Rating</span>
											<span class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
										</button>
										<div id="selected_stars" style="font-weight: 100; font-size: medium; padding-left: 15px"></div>
									</h2>

									<div id="flush-collapseRating" class="accordion-collapse collapse"
										 aria-labelledby="flush-headingRating">
										<div class="accordion-body text-body">
											<div class="d-flex flex-column gap-2 filter-check">
												<div class="form-check">
													<input class="form-check-input star-filter" type="checkbox"
														   value="5" id="filter_rating_5" name="star[]">
													<label class="form-check-label dashboard_chk_labels"
														   for="filter_rating_5">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                </span> 5
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input star-filter" type="checkbox"
														   value="4" id="filter_rating_4" name="star[]">
													<label class="form-check-label dashboard_chk_labels"
														   for="filter_rating_4">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                </span> 4
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input star-filter" type="checkbox"
														   value="3" id="filter_rating_3" name="star[]">
													<label class="form-check-label dashboard_chk_labels"
														   for="filter_rating_3">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                </span> 3
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input star-filter" type="checkbox"
														   value="2" id="filter_rating_2" name="star[]">
													<label class="form-check-label dashboard_chk_labels"
														   for="filter_rating_2">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                </span> 2
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input star-filter" type="checkbox"
														   value="1" id="filter_rating_1" name="star[]">
													<label class="form-check-label dashboard_chk_labels"
														   for="filter_rating_1">
                                                                <span class="text-muted">
                                                                    <i class="mdi mdi-star text-warning"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                    <i class="mdi mdi-star"></i>
                                                                </span> 1
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- end accordion-item -->

								<div class="accordion-item" style="<?= $display ?>" id="guest_scores_filter_div">
									<h2 class="accordion-header" id="flush-headingGuestScore">
										<button class="accordion-button bg-transparent shadow-none collapsed"
												type="button" data-bs-toggle="collapse"
												data-bs-target="#flush-collapseGuestScore" aria-expanded="false"
												aria-controls="flush-collapseGuestScore">
											<span class="text-black text-uppercase fs-14 fw-bold">Guest Score</span>
											<span class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
										</button>
										<div id="selected_guest_scores" style="font-weight: 100; font-size: medium; padding-left: 15px"></div>
									</h2>

									<div id="flush-collapseGuestScore" class="accordion-collapse collapse"
										 aria-labelledby="flush-headingGuestScore">
										<div class="accordion-body text-body">
											<div class="d-flex flex-column gap-2 filter-check">
												<?php $i = 10;
												$GuestScore_data = [10, 9, 8, 7, 6, 5, 4, 3, 2, 1];
												foreach ($GuestScore_data as $GuestScore) { ?>
													<div class="form-check">
														<input class="form-check-input guest-filter" type="checkbox"
															   id="filter_guestscore_<?php echo $i ?>"
															   name="filter_guestscore[]"
															   value="<?php echo $GuestScore; ?>">
														<label class="form-check-label dashboard_chk_labels"
															   for="filter_guestscore_<?php echo $i ?>"><?php echo $GuestScore; ?></label>
													</div>
													<?php $i--;
												} ?>
											</div>
										</div>
									</div>
								</div>
								<!-- end accordion-item -->
							</div>
						</div>
						<!-- end card -->
					</div>

					<div class="col-xxl-10 col-xl-9 col-lg-9">
                        <div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="col-12 col-md-12 col-lg-12 d-flex">
                                        <?php if ($isMob == 1) { ?>
                                        <div class="buttons" id="get_web_data">
                                            <?php if (isset($websites) && !empty($websites)) {
                                                    foreach ($websites as $key => $value) { ?>
                                            <button class="btn btn-outline-primary btn-sm main_tabs_dashboard"
                                                onclick="get_website_data(<?= $value['Id'] ?>)"
                                                id="web-<?= $value['Id'] ?>"
                                                web-id="<?= $value['Name'] ?>"><?= rtrim($value['Name'], ".com") ?></button>
                                            <?php }
                                                } ?>
                                            <div style="float: right">
												<span class="btn btn-soft-primary btn-sm" style="cursor: unset">last updated</span>
												<span class="scrape_time btn btn-soft-primary btn-sm"><?= date('m/d/Y', strtotime($rate_data[0]->scrape_time)) ?></span>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                        <div class="buttons col-9" id="get_web_data">
                                            <?php if (isset($websites) && !empty($websites)) {
                                                    foreach ($websites as $key => $value) { ?>
                                            <button class="btn btn-outline-primary btn-sm main_tabs_dashboard"
                                                onclick="get_website_data(<?= $value['Id'] ?>)"
                                                id="web-<?= $value['Id'] ?>"
                                                web-id="<?= $value['Name'] ?>"><?= rtrim($value['Name'], ".com") ?></button>
                                            <?php }
                                                } ?>
                                        </div>
                                        <div class="col-3">
											<button class="btn btn-soft-primary btn-sm" style="cursor: unset;">last updated</button>
											<span class="scrape_time btn btn-soft-primary btn-sm"><?= date('m/d/Y', strtotime($rate_data[0]->scrape_time)) ?></span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- end card header -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6" id="price_table_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="price_table_heading">Top 10 Hotel Price</h4>
                                                </div>
                                                <div class="card-body rate-data">
                                                    <div class="table-responsive">
                                                        <span id="rate_message" style="display:none;"></span>
                                                        <table class="table table-hover mb-0 rating_data">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                if (isset($rate_data) && count($rate_data) > 0) :
                                                                    foreach ($rate_data as $row) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td>
                                                                        <a href="<?php echo base_url() . 'get_single_hotel_data/' . $row->hotelid . '/booking.com'; ?>" target="_blank"><?php echo $row->hotel_name; ?></a>
                                                                    </td>
                                                                    <td>$<?php echo round($row->rate); ?></td>
                                                                </tr>
                                                                <?php
                                                                        $i++;
                                                                    }
                                                                else :
                                                                    ?>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <center>No Record Found</center>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-body rate-ajax-data d-none">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0" id="ajax_rating_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="rate_html">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6" id="price_chart_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="price_chart_heading">Top 10 Hotel Price Chart</h4>
                                                </div>
                                                <div class="card-body">
                                                    <span id="rate_chart_message" style="display:none;"></span>
                                                    <div>
                                                        <canvas id="rate_chart" class="chartjs-chart"
                                                            data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></canvas>
                                                    </div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6" id="guest_score_table_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="guest_score_table_heading">Top 10 Hotel Guest Score</h4>
                                                </div>
                                                <div class="card-body guest-score-data">
                                                    <div class="table-responsive">
                                                        <span id="guest_score_message" style="display:none;"></span>
                                                        <table class="table table-hover mb-0 guest_score_data">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Guest Score</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                if (isset($guest_scrore_data) && count($guest_scrore_data) > 0) :
                                                                    foreach ($guest_scrore_data as $row) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td> <a href="<?php echo base_url() . 'get_single_hotel_data/' . $row->hotelid . '/booking.com'; ?>" target="_blank"><?php echo $row->hotel_name; ?></a>
                                                                    </td>
                                                                    <td><?php echo $row->guest_score; ?></td>
                                                                </tr>
                                                                <?php
                                                                        $i++;
                                                                    }
                                                                else :
                                                                    ?>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <center>No Record Found</center>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-body guest-score-ajax-data d-none">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0" id="ajax_guest_score_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Guest Score</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="guest_score_html">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6" id="guest_score_chart_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="guest_score_chart_heading">Top 10 Guest Score Chart</h4>
                                                </div>
                                                <div class="card-body">
                                                    <span id="guest_score_chart_message" style="display:none;"></span>
                                                    <div id="guest_score_chart" class="apex-charts"
                                                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                                                        dir="ltr"></div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6" id="star_table_data_div">
                                            <div class="card star_table_data">
                                                <div class="card-header">
                                                    <h4 id="star_table_heading">Top 10 Hotel Star</h4>
                                                </div>
                                                <div class="card-body star-data">
                                                    <div class="table-responsive">
                                                        <span id="star_data_message" style="display:none;"></span>
                                                        <table class="table table-hover mb-0 star_data">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Star</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                if (isset($star_data) && count($star_data) > 0) :
                                                                    foreach ($star_data as $row) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td> <a href="<?php echo base_url() . 'get_single_hotel_data/' . $row->hotelid . '/booking.com'; ?>" target="_blank"><?php echo $row->hotel_name; ?></a>
                                                                    </td>
                                                                    <td><?php echo $row->star; ?></td>
                                                                </tr>
                                                                <?php
                                                                        $i++;
                                                                    }
                                                                else :
                                                                    ?>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <center>No Record Found</center>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-body star-ajax-data d-none">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0" id="ajax_star_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Star</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="star_html">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6" id="star_chart_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="star_chart_heading">Top 10 Hotel Star Chart</h4>
                                                </div>
                                                <div class="card-body">
                                                    <span id="star_chart_message" style="display:none;"></span>
                                                    <canvas id="star_chart" class="chartjs-chart"
                                                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'></canvas>
                                                    <!-- <div id="star_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]' class="apex-charts" dir="ltr"></div> -->
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6" id="brand_table_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="brand_table_heading">Top 10 Hotel Brand</h4>
                                                </div>
                                                <div class="card-body brand-data">
                                                    <div class="table-responsive">
                                                        <span id="brand_hotel_message" style="display:none;"></span>
                                                        <table class="table table-hover mb-0 brand_hotel">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                if (isset($brands_data) && count($brands_data) > 0) :
                                                                    foreach ($brands_data as $row) {
                                                                        $hotname = isset($row->Brand) ? ($row->hotel_name . ' (' . $row->Brand . ')') : $row->hotel_name;
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td> <a href="<?php echo base_url() . 'get_single_hotel_data/' . $row->hotelid . '/booking.com'; ?>" target="_blank"><?php echo $hotname; ?></a>
                                                                    </td>
                                                                    <td>$<?php echo round($row->rate); ?></td>
                                                                </tr>
                                                                <?php
                                                                        $i++;
                                                                    }
                                                                else :
                                                                    ?>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <center>No Record Found</center>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-body brand-ajax-data d-none">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0" id="ajax_brand_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="brand_html">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6" id="brand_chart_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="brand_chart_heading">Top 10 Hotel Brand Chart</h4>
                                                </div>
                                                <div class="card-body">
                                                    <span id="brand_chart_message" style="display:none;"></span>
                                                    <div id="brand_chart"
                                                        data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info", "--vz-warning", "--vz-danger", "--vz-dark"]'
                                                        class="apex-charts" dir="ltr"></div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6" id="tier_table_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="tier_table_heading">Top 10 Hotel Tier</h4>
                                                </div>
                                                <div class="card-body tier-data">
                                                    <div class="table-responsive">
                                                        <span id="tier_hotel_message" style="display:none;"></span>
                                                        <table class="table table-hover mb-0 tier_hotel">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;
                                                                if (isset($tiers_data) && count($tiers_data) > 0) :
                                                                    foreach ($tiers_data as $row) {
                                                                        $teirlist = isset($row->tier) ? ($row->hotel_name . ' (' . $row->tier . ')') : $row->hotel_name;
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><a href="<?php echo base_url() . 'get_single_hotel_data/' . $row->hotelid . '/booking.com'; ?>" target="_blank"><?php echo $teirlist; ?></a>
                                                                    </td>
                                                                    <td>$<?php echo round($row->rate); ?></td>
                                                                </tr>
                                                                <?php
                                                                        $i++;
                                                                    }
                                                                else :
                                                                    ?>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <center>No Record Found</center>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-body tier-ajax-data d-none">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0" id="ajax_tier_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Hotel Name</th>
                                                                    <th>Tier</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tier_html">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6" id="tier_chart_data_div">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 id="tier_chart_heading">Top 10 Tier Chart</h4>
                                                </div>
                                                <div class="card-body">
                                                    <span id="tier_chart_message" style="display:none;"></span>
                                                    <div id="tier_chart"
                                                        data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info", "--vz-warning", "--vz-danger", "--vz-dark"]'
                                                        class="apex-charts" dir="ltr"></div>
                                                </div>
                                            </div>
											<div class='loading-ct' style="display: none">
												<div class='part_loading'>
													<i class="mdi mdi-spin mdi-loading fa-3x"></i>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                    </div>
                    <!-- end col -->
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

<?php include 'layouts/customizer.php'; ?>

<?php include 'layouts/vendor-scripts.php'; ?>
<!-- ecommerce product list -->
<!--<script src="--><?php //echo base_url().'assets/js/pages/ecommerce-product-list.init.js'; 
                    ?>
<!--"></script>-->
<!-- prismjs plugin -->
<script src="<?php echo base_url() . 'assets/libs/prismjs/prism.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/js/pages/form-pickers.init.js'; ?>"></script>
<!-- Chart JS -->
<script src="<?php echo base_url() . 'assets/libs/chart.js/chart.min.js'; ?>"></script>
<!-- chartjs init -->
<script src="<?php echo base_url() . 'assets/js/pages/chartjs.init.js'; ?>"></script>
<!-- apexcharts -->
<script src="<?php echo base_url() . 'assets/libs/apexcharts/apexcharts.min.js'; ?>"></script>
<!-- App js -->
<script src="<?php echo base_url() . 'assets/js/app.js'; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
// 'use strict';
var rate = [];
var star = [];
var guest = [];
var brand = [];
var tier = [];
var BASE_URL = $('#base_url').val();
var ChartHasBeenRendered = false;
var guestScoreChart;
var starChart;
var brandChart;
var tierChart;
var user_state = '<?= $user_state ?>';
var user_city = '<?= $user_city ?>';
var selected_cities;

$(document).ready(function() {
	$("#slider-range").slider({
		range: true,
		orientation: "horizontal",
		min: 60,
		max: 5000,
		values: [60, 5000],
		step: 1,
		slide: function (event, ui) {
			if (ui.values[0] == ui.values[1]) {
				return false;
			}
			$("#minCost").val(ui.values[0]);
			$("#maxCost").val(ui.values[1]);
		}
	});
	$("#minCost").val($("#slider-range").slider("values", 0));
	$("#maxCost").val($("#slider-range").slider("values", 1));

    $("#filter_state").removeAttr('disabled');
    $("#filter_city").removeAttr('disabled');
    $('#filter_state').select2({
        placeholder: "Select State",
        allowClear: true,
        width: '100%'
    });
    $('#filter_city').select2({
        placeholder: "Select City",
        allowClear: true,
        width: '100%'
    });

    $.ajax({
        url: "<?php echo base_url() . 'get_data_filter'; ?>",
        method: "POST",
        success: function(res) {
            var res = JSON.parse(res);
			if (res.status == 1) {
				var state_html = `<option value=""></option>`;
				$.each(res.states, function (index, value) {
					var selected = "";
					if (value.state_code == user_state) {
						selected = "selected";
					}
					state_html +=
						`<option value="${value.state_code}" ${selected}>${value.state}</option>`;
				});
				$("#filter_state").html("");
				// $("#filter_state").select2('destroy').val("").select2({
				// 	placeholder: "Select State",
				// 	allowClear: true,
				// });
				$("#filter_state").html(state_html);
				fill_cities(user_state, user_city);

				var brand_html = "";
				var i = 1;
				$.each(res.brands, function (index, value) {
					brand_html += `<div class="form-check">
										<input class="form-check-input brand-filter" type="checkbox" id="filter_brand_${i}" name="filter_brand[]" value="${value.brand}">
										<label class="form-check-label dashboard_chk_labels" for="filter_brand_${i}">${value.brand}</label>
									</div>`;
					i++;
				});
				$("#brand_filter").html(brand_html);

				var tier_html = "";
				var i = 1;
				$.each(res.tiers, function (index, value) {
					tier_html += `<div class="form-check">
									<input class="form-check-input tier-filter" type="checkbox" id="filter_tier_${i}" name="filter_tier[]" value="${value.tier}">
									<label class="form-check-label dashboard_chk_labels" for="filter_tier_${i}">${value.tier}</label>
								</div>`;
					i++;
				});
				$("#tier_filter").html(tier_html);
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

    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();
    $('#filter_date').daterangepicker({
        // minDate: new Date(currentYear, currentMonth, currentDate),
        dateFormat: 'yy-mm-dd',
        startDate: moment(date),
        endDate: moment(date).add(1, 'days'),
        locale: {
            format: 'YYYY/MM/DD'
        }
    });

    $("#get_web_data button").first().addClass("active");

    var rate_data = <?= json_encode($rate_data) ?>;
    var rate_chart_labels = [];
    var rate_chart_data = [];
    $.each(rate_data, function(index, value) {
        var country = value.hotel_name.substring(0, 17);
        rate_chart_labels.push(country);
        rate_chart_data.push(Math.round(value.rate));
    });
    rate_barChart(rate_chart_labels, rate_chart_data);

    var guest_scrore_data = <?= json_encode($guest_scrore_data) ?>;
    var guestScrore_chart_labels = [];
    var guestScrore_chart_data = [];
    $.each(guest_scrore_data, function(index, value) {
        var country = value.hotel_name.substring(0, 25);
        guestScrore_chart_labels.push(country);
        guestScrore_chart_data.push(parseFloat(value.guest_score));
    });
    guestScore_donutChart(guestScrore_chart_labels, guestScrore_chart_data);

    var star_data = <?= json_encode($star_data) ?>;
    var star_chart_labels = [];
    var star_chart_data = [];
    $.each(star_data, function(index, value) {
        var country = value.hotel_name.substring(0, 25);
        star_chart_labels.push(country);
        star_chart_data.push(parseFloat(value.star));
    });
    star_barChart(star_chart_labels, star_chart_data);

    var brands_data = <?= json_encode($brands_data) ?>;
    var brand_chart_labels = [];
    var brand_chart_data = [];
    $.each(brands_data, function(index, value) {
        var category = value.hotel_name.substring(0, 17);
        if (value.Brand != null) {
            var category = value.Brand + "-" + value.hotel_name.substring(0, 17);
        }
        brand_chart_labels.push(category);
        brand_chart_data.push(parseFloat(value.rate));
    });
    brand_barChart(brand_chart_labels, brand_chart_data);

    var tiers_data = <?= json_encode($tiers_data) ?>;
    var tier_chart_labels = [];
    var tier_chart_data = [];
    $.each(tiers_data, function(index, value) {
        var category = value.hotel_name.substring(0, 15);
        if (value.tier != null) {
            var category = value.tier + "-" + value.hotel_name.substring(0, 15);
        }
        tier_chart_labels.push(category);
        tier_chart_data.push(parseFloat(value.rate));
    });
    tier_barChart(tier_chart_labels, tier_chart_data);
})

function rate_barChart(rate_chart_labels = [], rate_chart_data = []) {
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	Chart.defaults.color = "#000000";
    const chart_exists = Chart.getChart("rate_chart");
    // console.log(chart_exists);
    if (chart_exists != undefined) {
        chart_exists.destroy();
    }
    var isbarchart = document.getElementById('rate_chart');
    var barChartColor = getChartColorsArray('rate_chart');
    isbarchart.setAttribute("width", isbarchart.parentElement.offsetWidth);
    isbarchart.setAttribute("height", $(".rate-data").height());
    // $("#rate_chart").parent().css('height', $(".rate-data").height());
    // console.log($(".rate-data").height());
    var barChart = new Chart(isbarchart, {
        type: 'bar',
        data: {
            labels: rate_chart_labels,
            datasets: [{
                label: "",
                backgroundColor: barChartColor,
                borderColor: barChartColor,
                borderWidth: 1,
                hoverBackgroundColor: barChartColor,
                hoverBorderColor: barChartColor,
				barThickness: 20,
				maxBarThickness: 50,
                data: rate_chart_data
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            x: {
                ticks: {
                    font: {
                        family: 'Poppins',
                    },
                },
            },
            y: {
                ticks: {
                    font: {
                        family: 'Poppins',
                    },
                },
            },
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        font: {
                            family: 'Poppins',
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            // console.log(context)
                            let label = context.dataset.label || '';

                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                if (context.parsed.y == "-1") {
                                    label += "Sold Out";
                                } else if (context.parsed.y == "-2") {
                                    label += "Not Available";
                                } else {
                                    label = label + '$' + Math.round(context.parsed.y);
                                }
                            }
                            return label;
                        }
                    }
                },
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        align: 'center',
                        text: 'Rate ($)',
                    }
                },
                x: {
                    title: {
                        display: true,
                        align: 'center',
                        text: 'Hotels',
                    }
                }
            },
			showInlineValues : true,
			centeredInllineValues : true,
			animation: {
				duration: 0,
				onComplete: function() {
					if(!isMobile) {
						const chartInstance = Chart.getChart("rate_chart"),
							ctx = chartInstance.ctx;
						ctx.font = Chart.helpers.fontString(
							18,
							Chart.defaults.defaultFontStyle,
							Chart.defaults.defaultFontFamily
						);
						ctx.textAlign = "center";
						ctx.textBaseline = "bottom";

						this.data.datasets.forEach(function (dataset, i) {
							const meta = chartInstance.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								const data = dataset.data[index];
								ctx.fillStyle = "#000";
								if (data != undefined) {
									var label;
									if (data == "-1") {
										label = "Sold Out";
									} else if (data == "-2") {
										label = "NA";
									} else {
										label = '$' + Math.round(data);
									}
									ctx.fillText(label, bar.x, bar.y - 2);
								}
							});
						});
					}
				}
			},
			hover: {
				animationDuration: 0, // duration of animations when hovering an item
			},
			responsiveAnimationDuration: 0,
        }
    });
}

function guestScore_donutChart(guestScore_chart_labels = [], guestScore_chart_data = []) {
    if (ChartHasBeenRendered == true && guestScoreChart) {
        guestScoreChart.destroy();
    }
    $("#guest_score_chart").html("");
    $("#guest_score_chart").empty();

    // console.log(guestScore_chart_labels);
    // console.log(guestScore_chart_data);
    var chartDonutBasicColors = getChartColorsArray("guest_score_chart");
    // console.log(chartDonutBasicColors);
    if (chartDonutBasicColors) {
        var options = {
            series: guestScore_chart_data,
            chart: {
                height: 600,
                type: 'donut',
            },
            labels: guestScore_chart_labels,
            legend: {
                position: 'bottom',
                labels: {
                    colors: ["#000000"],
                    useSeriesColors: false
                },
            },
            dataLabels: {
                dropShadow: {
                    enabled: false,
                },
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex]
                },
            },
            colors: chartDonutBasicColors,
        };

        guestScoreChart = new ApexCharts(document.querySelector("#guest_score_chart"), options);
        guestScoreChart.render().then(() => ChartHasBeenRendered = true);
    }
}

function star_barChart(star_chart_labels = [], star_chart_data = []) {
	let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
	Chart.defaults.color = "#000000";
    const chart_exists = Chart.getChart("star_chart");
    // console.log(star_chart_labels);
    // console.log(star_chart_data);
    if (chart_exists != undefined) {
        chart_exists.destroy();
    }
    var isbarchart = document.getElementById('star_chart');
    var barChartColor = getChartColorsArray('star_chart');
    isbarchart.setAttribute("width", isbarchart.parentElement.offsetWidth);
    isbarchart.setAttribute("height", $(".star_table_data").height());
    var barChart = new Chart(isbarchart, {
        type: 'bar',
        data: {
            labels: star_chart_labels,
            datasets: [{
                label: "",
                backgroundColor: barChartColor,
                borderColor: barChartColor,
                borderWidth: 1,
                hoverBackgroundColor: barChartColor,
                hoverBorderColor: barChartColor,
				barThickness: 20,
				maxBarThickness: 50,
                data: star_chart_data
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            x: {
                ticks: {
                    font: {
                        family: 'Poppins',
                    },
                },
            },
            y: {
                ticks: {
                    font: {
                        family: 'Poppins',
                    },
                },
            },
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        font: {
                            family: 'Poppins',
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            let label = '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y;
                            return label;
                        }
                    }
                },
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        align: 'center',
                        text: 'Stars',
                    }
                },
                x: {
                    title: {
                        display: true,
                        align: 'center',
                        text: 'Hotels',
                    }
                }
            },
			showInlineValues : true,
			centeredInllineValues : true,
			animation: {
				duration: 0,
				onComplete: function() {
					if(!isMobile) {
						const chartInstance = Chart.getChart("star_chart"),
							ctx = chartInstance.ctx;
						ctx.font = Chart.helpers.fontString(
							18,
							Chart.defaults.defaultFontStyle,
							Chart.defaults.defaultFontFamily
						);
						ctx.textAlign = "center";
						ctx.textBaseline = "bottom";

						this.data.datasets.forEach(function (dataset, i) {
							const meta = chartInstance.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								const data = dataset.data[index];
								ctx.fillStyle = "#000";
								if (data != undefined) {
									ctx.fillText(data, bar.x, bar.y - 2);
								}
							});
						});
					}
				}
			},
			hover: {
				animationDuration: 0, // duration of animations when hovering an item
			},
			responsiveAnimationDuration: 0,
        }
    });
}

function star_pieChart(star_chart_labels = [], star_chart_data = []) {
    if (ChartHasBeenRendered == true && starChart) {
        starChart.destroy();
    }
    $("#star_chart").html("");
    $("#star_chart").empty();
    // console.log(star_chart_labels);
    // console.log(star_chart_data);
    var chartPieBasicColors = getChartColorsArray("star_chart");
    // console.log(chartPieBasicColors);

    if (chartPieBasicColors) {
        var options = {
            series: star_chart_data,
            chart: {
                height: $(".star_table_data").height(),
                type: 'pie',
            },
            labels: star_chart_labels,
            legend: {
                position: 'bottom',
                labels: {
                    colors: ['black'],
                    useSeriesColors: false
                },
            },
            dataLabels: {
                dropShadow: {
                    enabled: false,
                },
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex]
                },
            },
            colors: chartPieBasicColors
        };

        starChart = new ApexCharts(document.querySelector("#star_chart"), options);
        starChart.render().then(() => ChartHasBeenRendered = true);
    }
}

function brand_barChart(brand_chart_labels = [], brand_chart_data = []) {
    if (ChartHasBeenRendered == true && brandChart) {
        brandChart.destroy();
    }
    $("#brand_chart").html("");
    $("#brand_chart").empty();
    // console.log(brand_chart_labels);
    // console.log(brand_chart_data);
    var chartDatalabelsBarColors = getChartColorsArray("brand_chart");
    if (chartDatalabelsBarColors) {
        var options = {
            series: [{
                data: brand_chart_data
            }],
            chart: {
                type: 'bar',
                height: 600,
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '60%',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
            colors: chartDatalabelsBarColors,
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['black']
                },
                formatter: function(val, opt) {
                    var price = "";
                    if (val == "-1") {
                        price = "Sold Out";
                    } else if (val == "-2") {
                        price = "Not Available";
                    } else {
                        price = '$' + Math.round(val);
                    }
                    return opt.w.globals.labels[opt.dataPointIndex] + " [" + price + "]"
                },
                offsetX: 0,
                dropShadow: {
                    enabled: false
                }
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: brand_chart_labels,
                title: {
                    text: "Rate ($)",
                },
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Hotels Brand',
                align: 'center',
                floating: true,
                style: {
                    fontWeight: 500,
                },
            },
            subtitle: {
                text: 'Hotel Name as DataLabels inside bars',
                align: 'center',
            },
            tooltip: {
                theme: 'light',
                x: {
                    show: true
                },
                y: {
                    formatter: function(val) {
                        return '$' + Math.round(val);
                    },
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                }
            }
        };

        brandChart = new ApexCharts(document.querySelector("#brand_chart"), options);
        brandChart.render().then(() => ChartHasBeenRendered = true);
    }
}

function tier_barChart(tier_chart_labels = [], tier_chart_data = []) {
    if (ChartHasBeenRendered == true && tierChart) {
        tierChart.destroy();
    }
    $("#tier_chart").html("");
    $("#tier_chart").empty();
    // console.log(tier_chart_labels);
    // console.log(tier_chart_data);
    var chartDatalabelsBarColors = getChartColorsArray("tier_chart");
    if (chartDatalabelsBarColors) {
        var options = {
            series: [{
                data: tier_chart_data
            }],
            chart: {
                type: 'bar',
                height: 600,
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    barHeight: '60%',
                    distributed: true,
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    },
                }
            },
            colors: chartDatalabelsBarColors,
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['black']
                },
                formatter: function(val, opt) {
                    var price = "";
                    if (val == "-1") {
                        price = "Sold Out";
                    } else if (val == "-2") {
                        price = "Not Available";
                    } else {
                        price = '$' + Math.round(val);
                    }
                    return opt.w.globals.labels[opt.dataPointIndex] + " [" + price + "]"
                },
                offsetX: 0,
                dropShadow: {
                    enabled: false
                }
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: tier_chart_labels,
                title: {
                    text: "Rate ($)",
                },
            },
            yaxis: {
                labels: {
                    show: false
                }
            },
            title: {
                text: 'Hotels Tier',
                align: 'center',
                floating: true,
                style: {
                    fontWeight: 500,
                },
            },
            subtitle: {
                text: 'Hotel Name, Tier, Price  as DataLabels inside bars',
                align: 'center',
            },
            tooltip: {
                theme: 'light',
                x: {
                    show: true
                },
                y: {
                    formatter: function(val) {
                        return '$' + Math.round(val);
                    },
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                }
            }
        };

        tierChart = new ApexCharts(document.querySelector("#tier_chart"), options);
        tierChart.render().then(() => ChartHasBeenRendered = true);
    }
}

function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        colors = JSON.parse(colors);
        // console.log("colors", colors);
        return colors.map(function(value) {
            var newValue = value.replace(" ", "");
            if (newValue.indexOf(",") === -1) {
                var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                if (color) return color;
                else return newValue;
            } else {
                var val = value.split(',');
                if (val.length == 2) {
                    var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                    rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                    return rgbaColor;
                } else {
                    return newValue;
                }
            }
        });
    }
}

function get_website_data(id) {
    $("#web-" + id).addClass('active').siblings().removeClass('active');
    get_single_web_data();
}

function get_single_web_data() {
    $.each(xhrPool, function(idx, jqXHR) {
        jqXHR.abort();
    });

    var limit = $('#limit_change').val();
    var state = $('#filter_state').val();
    var city = $('#filter_city').val();
    var date = $('#filter_date').val();
    var web_site = $('#get_web_data button.active').attr('web-id');
    var web_site_string = web_site.toLowerCase();

    var jdata = {
        // 'rate': rate,
        'from_rate': $("#minCost").val(),
        'to_rate': $("#maxCost").val(),
        'star': star,
        'guest': guest,
        'brand': brand,
        'tier': tier,
        'state': state,
        'city': city,
        'date': date,
        'web_table': web_site_string,
        'limit': limit
    };

    var url = BASE_URL + "filters"

    var hotel_data_url = "<?php echo base_url() . 'get_single_hotel_data/'; ?>";

    $.ajax({
        type: 'POST',
        url: url,
        data: jdata,
        dataType: 'JSON',
        beforeSend: function(jqXHR) {
            xhrPool.push(jqXHR);
            // $('.loading').show();
			$("#price_table_data_div").find('.loading-ct').show();
			$("#price_chart_data_div").find('.loading-ct').show();
			$("#guest_score_table_data_div").find('.loading-ct').show();
			$("#guest_score_chart_data_div").find('.loading-ct').show();
			$("#star_table_data_div").find('.loading-ct').show();
			$("#star_chart_data_div").find('.loading-ct').show();
			$("#brand_table_data_div").find('.loading-ct').show();
			$("#brand_chart_data_div").find('.loading-ct').show();
			$("#tier_table_data_div").find('.loading-ct').show();
			$("#tier_chart_data_div").find('.loading-ct').show();
		},
        success: function(res) {
			if (res.status == 1) {
				$(".accordion-button").addClass('collapsed');
				$("#flush-collapseBrands, #flush-collapseTier, #flush-collapseRating, #flush-collapseGuestScore").removeClass('show');
				var brands = brand.slice(0,3);
				brands = brands.join(" , ");
				$("#selected_brands").html(brands);
				var tiers = tier.slice(0,3);
				tiers = tiers.join(" , ");
				$("#selected_tiers").html(tiers);
				var stars = star.slice(0,3);
				stars = stars.join(" , ");
				$("#selected_stars").html(stars);
				var guest_scores = guest.slice(0,3);
				guest_scores = guest_scores.join(" , ");
				$("#selected_guest_scores").html(guest_scores);

				$('.rate-data').addClass('d-none');
				$('.rate-ajax-data').removeClass('d-none');

				$('.star-data').addClass('d-none');
				$('.star-ajax-data').removeClass('d-none');

				$('.brand-data').addClass('d-none');
				$('.brand-ajax-data').removeClass('d-none');

				$('.tier-data').addClass('d-none');
				$('.tier-ajax-data').removeClass('d-none');

				$('.guest-score-data').addClass('d-none');
				$('.guest-score-ajax-data').removeClass('d-none');

				$('#rate_html').html('');
				$('#star_html').html('');
				$('#brand_html').html('');
				$('#tier_html').html('');
				$('#guest_score_html').html('');
				var rate_html = '';
				var star_html = '';
				if (res.rate_json != "") {
					var i = 1;
					var rate_chart_labels = [];
					var rate_chart_data = [];
					$.each(res.rate_json, function (index, value) {
						if (index == 0){
							var scrape_time = moment(value.scrape_time).format('MM/DD/YYYY');
							$(".scrape_time").html(scrape_time);
						}
						rate_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value.hotel_name + `</a></td>
                                <td>$` + Math.round(value.rate) + `</td>
                            </tr>`
						i++;
						$('#rate_html').append(rate_html);
						var country = value.hotel_name.substring(0, 17);
						rate_chart_labels.push(country);
						rate_chart_data.push(Math.round(value.rate));
					});
					$('.rating_data').show();
					$('#rate_chart').show();
					$('#rate_message').hide();
					$('#rate_chart_message').hide();
					rate_barChart(rate_chart_labels, rate_chart_data);
				} else {
					$('.rate-data').removeClass('d-none');
					$('.rate-ajax-data').addClass('d-none');
					$('.rating_data').hide();
					$('#rate_message').show();
					$('#rate_chart_message').show();
					$('#rate_chart').hide();
					document.getElementById('rate_message').innerHTML = 'No record Found.'
					document.getElementById('rate_chart_message').innerHTML = 'No record Found.'
				}

				if (res.star_json != "") {
					var i = 1;
					var star_chart_labels = [];
					var star_chart_data = [];
					$.each(res.star_json, function (index, value) {
						star_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value
							.hotel_name + `</a></td>
                                <td>` + value.star + `</td>
                            </tr>`
						i++;
						$('#star_html').append(star_html);
						var country = value.hotel_name.substring(0, 25);
						star_chart_labels.push(country);
						star_chart_data.push(parseFloat(value.star));
					});
					$('.star_data').show();
					$('#star_chart').show();
					$('#star_data_message').hide();
					$('#star_chart_message').hide();
					star_barChart(star_chart_labels, star_chart_data);
				} else {
					$('.star-data').removeClass('d-none');
					$('.star-ajax-data').addClass('d-none');
					$('.star_data').hide();
					$('#star_data_message').show();
					$('#star_chart_message').show();
					$('#star_chart').hide();
					document.getElementById('star_data_message').innerHTML = 'No record Found.'
					document.getElementById('star_chart_message').innerHTML = 'No record Found.'
				}

				if (res.brand_json != "") {
					var i = 1;
					var brand_chart_labels = [];
					var brand_chart_data = [];
					$.each(res.brand_json, function (index, value) {
						star_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value
							.hotel_name + `</a></td>
                                <td>$` + Math.round(value.rate) + `</td>
                            </tr>`
						i++;
						$('#brand_html').append(star_html);
						var category = value.hotel_name.substring(0, 17);
						if (value.Brand != null) {
							var category = value.Brand + "-" + value.hotel_name.substring(0, 17);
						}
						brand_chart_labels.push(category);
						brand_chart_data.push(parseFloat(value.rate));
					});
					$('.brand_hotel').show();
					$('#brand_chart').show();
					$('#brand_hotel_message').hide();
					$('#brand_chart_message').hide();
					brand_barChart(brand_chart_labels, brand_chart_data);
				} else {
					$('.brand-data').removeClass('d-none');
					$('.brand-ajax-data').addClass('d-none');
					$('.brand_hotel').hide();
					$('#brand_hotel_message').show();
					$('#brand_chart_message').show();
					$('#brand_chart').hide();
					document.getElementById('brand_chart_message').innerHTML = 'No record Found.'
					document.getElementById('brand_hotel_message').innerHTML = 'No record Found.'
				}

				if (res.tier_json != "") {
					var i = 1;
					var tier_chart_labels = [];
					var tier_chart_data = [];
					$.each(res.tier_json, function (index, value) {
						star_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value
							.hotel_name + `</a></td>
                                <td>$` + Math.round(value.rate) + `</td>
                            </tr>`
						i++;
						$('#tier_html').append(star_html);
						var category = value.hotel_name.substring(0, 15);
						if (value.tier != null) {
							var category = value.tier + "-" + value.hotel_name.substring(0, 15);
						}
						tier_chart_labels.push(category);
						tier_chart_data.push(parseFloat(value.rate));
					});
					$('.tier_hotel').show();
					$('#tier_chart').show();
					$('#tier_hotel_message').hide();
					$('#tier_chart_message').hide();
					tier_barChart(tier_chart_labels, tier_chart_data);
				} else {
					$('.tier-data').removeClass('d-none');
					$('.tier-ajax-data').addClass('d-none');
					$('.tier_hotel').hide();
					$('#tier_hotel_message').show();
					$('#tier_chart_message').show();
					$('#tier_chart').hide();
					document.getElementById('tier_hotel_message').innerHTML = 'No record Found.'
					document.getElementById('tier_chart_message').innerHTML = 'No record Found.'
				}

				if (res.guest_scrorejson != "") {
					var i = 1;
					var guestScrore_chart_labels = [];
					var guestScrore_chart_data = [];
					$.each(res.guest_scrorejson, function (index, value) {
						star_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value
							.hotel_name + `</a></td>
                                <td>` + value.guest_score + `</td>
                            </tr>`
						i++;
						$('#guest_score_html').append(star_html);
						var country = value.hotel_name.substring(0, 25);
						guestScrore_chart_labels.push(country);
						guestScrore_chart_data.push(parseFloat(value.guest_score));
					});
					$('.guest_score_data').show();
					$('#guest_score_chart').show();
					$('#guest_score_message').hide();
					$('#guest_score_chart_message').hide();
					guestScore_donutChart(guestScrore_chart_labels, guestScrore_chart_data);
				} else {
					$('.guest-score-data').removeClass('d-none');
					$('.guest-score-ajax-data').addClass('d-none');
					$('.guest_score_data').hide();
					$('.guest_score').hide();
					$('#guest_score_message').show();
					$('#guest_score_chart_message').show();
					$('#guest_score_chart').hide();
					document.getElementById('guest_score_message').innerHTML = 'No record Found.'
					document.getElementById('guest_score_chart_message').innerHTML = 'No record Found.'
				}

				var city_cnt = $("#filter_city option:selected").length;
				var state_cnt = $("#filter_state option:selected").length;
				if (city_cnt == 1){
					var city = $("#filter_city option:selected").html();
					$("#price_table_heading").html(`Top 10 ${city} Hotel Price`);
					$("#price_chart_heading").html(`Top 10 ${city} Hotel Price Chart`);
					$("#guest_score_table_heading").html(`Top 10 ${city} Hotel Guest Score`);
					$("#guest_score_chart_heading").html(`Top 10 ${city} Hotel Guest Score Chart`);
					$("#star_table_heading").html(`Top 10 ${city} Hotel Star`);
					$("#star_chart_heading").html(`Top 10 ${city} Hotel Star Chart`);
					$("#brand_table_heading").html(`Top 10 ${city} Hotel Brand`);
					$("#brand_chart_heading").html(`Top 10 ${city} Hotel Brand Chart`);
					$("#tier_table_heading").html(`Top 10 ${city} Hotel Tier`);
					$("#tier_chart_heading").html(`Top 10 ${city} Tier Chart`);
				}
				else if(city_cnt==0 && state_cnt==1){
					var state = $("#filter_state option:selected").html();
					$("#price_table_heading").html(`Top 10 ${state} Hotel Price`);
					$("#price_chart_heading").html(`Top 10 ${state} Hotel Price Chart`);
					$("#guest_score_table_heading").html(`Top 10 ${state} Hotel Guest Score`);
					$("#guest_score_chart_heading").html(`Top 10 ${state} Hotel Guest Score Chart`);
					$("#star_table_heading").html(`Top 10 ${state} Hotel Star`);
					$("#star_chart_heading").html(`Top 10 ${state} Hotel Star Chart`);
					$("#brand_table_heading").html(`Top 10 ${state} Hotel Brand`);
					$("#brand_chart_heading").html(`Top 10 ${state} Hotel Brand Chart`);
					$("#tier_table_heading").html(`Top 10 ${state} Hotel Tier`);
					$("#tier_chart_heading").html(`Top 10 ${state} Tier Chart`);
				}
				else {
					$("#price_table_heading").html(`Top 10 Hotel Price`);
					$("#price_chart_heading").html(`Top 10 Hotel Price Chart`);
					$("#guest_score_table_heading").html(`Top 10 Hotel Guest Score`);
					$("#guest_score_chart_heading").html(`Top 10 Hotel Guest Score Chart`);
					$("#star_table_heading").html(`Top 10 Hotel Star`);
					$("#star_chart_heading").html(`Top 10 Hotel Star Chart`);
					$("#brand_table_heading").html(`Top 10 Hotel Brand`);
					$("#brand_chart_heading").html(`Top 10 Hotel Brand Chart`);
					$("#tier_table_heading").html(`Top 10 Hotel Tier`);
					$("#tier_chart_heading").html(`Top 10 Tier Chart`);
				}
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
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		},
        complete: function(data) {
            // $('.loading').hide();
			$("#price_table_data_div").find('.loading-ct').hide();
			$("#price_chart_data_div").find('.loading-ct').hide();
			$("#guest_score_table_data_div").find('.loading-ct').hide();
			$("#guest_score_chart_data_div").find('.loading-ct').hide();
			$("#star_table_data_div").find('.loading-ct').hide();
			$("#star_chart_data_div").find('.loading-ct').hide();
			$("#brand_table_data_div").find('.loading-ct').hide();
			$("#brand_chart_data_div").find('.loading-ct').hide();
			$("#tier_table_data_div").find('.loading-ct').hide();
			$("#tier_chart_data_div").find('.loading-ct').hide();
        }
    });
}

function apply_filter() {
    get_single_web_data();
}

function clear_all() {
    $('#filter_state').html("");
    $("#filter_state").select2('destroy').val("").select2({
        placeholder: "Select State",
        allowClear: true,
        width: '100%'
    });
    $('#filter_city').html("");
    $("#filter_city").select2('destroy').val("").select2({
        placeholder: "Select City",
        allowClear: true,
        width: '100%'
    });
    var date = new Date();
    $('#filter_date').daterangepicker({
        dateFormat: 'yy-mm-dd',
        startDate: moment(date),
        endDate: moment(date).add(1, 'days'),
        locale: {
            format: 'YYYY/MM/DD'
        }
    });
    $("#minCost").val(60);
    $("#maxCost").val(5000);
    $('.brand-filter').prop('checked', false);
    brand = [];
    $('.tier-filter').prop('checked', false);
    tier = [];
    $('.star-filter').prop('checked', false);
    star = [];
    $('.guest-filter').prop('checked', false);
    guest = [];

    $.each(xhrPool, function(idx, jqXHR) {
        jqXHR.abort();
    });

    var hotel_data_url = "<?php echo base_url() . 'get_single_hotel_data/'; ?>";
    var web_site = $('#get_web_data button.active').attr('web-id');
    var web_site_string = web_site.toLowerCase();

    $.ajax({
        type: 'POST',
        url: "<?php echo base_url('clear_all'); ?>",
        dataType: 'JSON',
        beforeSend: function(jqXHR) {
            xhrPool.push(jqXHR);
			$("#price_table_data_div").find('.loading-ct').show();
			$("#price_chart_data_div").find('.loading-ct').show();
			$("#guest_score_table_data_div").find('.loading-ct').show();
			$("#guest_score_chart_data_div").find('.loading-ct').show();
			$("#star_table_data_div").find('.loading-ct').show();
			$("#star_chart_data_div").find('.loading-ct').show();
			$("#brand_table_data_div").find('.loading-ct').show();
			$("#brand_chart_data_div").find('.loading-ct').show();
			$("#tier_table_data_div").find('.loading-ct').show();
			$("#tier_chart_data_div").find('.loading-ct').show();
        },
        success: function(res) {
			if (res.status == 1) {
				$(".accordion-button").addClass('collapsed');
				$("#flush-collapseBrands, #flush-collapseTier, #flush-collapseRating, #flush-collapseGuestScore").removeClass('show');
				$("#selected_brands").html("");
				$("#selected_tiers").html("");
				$("#selected_stars").html("");
				$("#selected_guest_scores").html("");

				$('#filter_state').html(res.state_data);
				fill_cities(res.user_state, res.user_city);
				$('.rate-data').addClass('d-none');
				$('.rate-ajax-data').removeClass('d-none');

				$('.star-data').addClass('d-none');
				$('.star-ajax-data').removeClass('d-none');

				$('.brand-data').addClass('d-none');
				$('.brand-ajax-data').removeClass('d-none');

				$('.tier-data').addClass('d-none');
				$('.tier-ajax-data').removeClass('d-none');

				$('.guest-score-data').addClass('d-none');
				$('.guest-score-ajax-data').removeClass('d-none');

				$('#rate_html').html('');
				$('#star_html').html('');
				$('#brand_html').html('');
				$('#tier_html').html('');
				$('#guest_score_html').html('');
				var rate_html = '';
				var star_html = '';
				if (res.rate_json != "") {
					var i = 1;
					var rate_chart_labels = [];
					var rate_chart_data = [];
					$.each(res.rate_json, function (index, value) {
						if (index == 0){
							var scrape_time = moment(value.scrape_time).format('MM/DD/YYYY');
							$(".scrape_time").html(scrape_time);
						}

						rate_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value
							.hotel_name + `</a></td>
                                <td>$` + Math.round(value.rate) + `</td>
                            </tr>`
						i++;
						$('#rate_html').append(rate_html);
						var country = value.hotel_name.substring(0, 17);
						rate_chart_labels.push(country);
						rate_chart_data.push(Math.round(value.rate));
					});
					$('.rating_data').show();
					$('#rate_chart').show();
					$('#rate_message').hide();
					$('#rate_chart_message').hide();
					rate_barChart(rate_chart_labels, rate_chart_data);
				} else {
					$('.rate-data').removeClass('d-none');
					$('.rate-ajax-data').addClass('d-none');
					$('.rating_data').hide();
					$('#rate_message').show();
					$('#rate_chart_message').show();
					$('#rate_chart').hide();
					document.getElementById('rate_message').innerHTML = 'No record Found.'
					document.getElementById('rate_chart_message').innerHTML = 'No record Found.'
				}

				if (res.star_json != "") {
					var i = 1;
					var star_chart_labels = [];
					var star_chart_data = [];
					$.each(res.star_json, function (index, value) {
						star_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value
							.hotel_name + `</a></td>
                                <td>` + value.star + `</td>
                            </tr>`
						i++;
						$('#star_html').append(star_html);
						var country = value.hotel_name.substring(0, 25);
						star_chart_labels.push(country);
						star_chart_data.push(parseFloat(value.star));
					});
					$('.star_data').show();
					$('#star_chart').show();
					$('#star_data_message').hide();
					$('#star_chart_message').hide();
					star_barChart(star_chart_labels, star_chart_data);
				} else {
					$('.star-data').removeClass('d-none');
					$('.star-ajax-data').addClass('d-none');
					$('.star_data').hide();
					$('#star_data_message').show();
					$('#star_chart_message').show();
					$('#star_chart').hide();
					document.getElementById('star_data_message').innerHTML = 'No record Found.'
					document.getElementById('star_chart_message').innerHTML = 'No record Found.'
				}

				if (res.brand_json != "") {
					var i = 1;
					var brand_chart_labels = [];
					var brand_chart_data = [];
					$.each(res.brand_json, function (index, value) {
						star_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value
							.hotel_name + `</a></td>
                                <td>$` + Math.round(value.rate) + `</td>
                            </tr>`
						i++;
						$('#brand_html').append(star_html);
						var category = value.hotel_name.substring(0, 17);
						if (value.Brand != null) {
							var category = value.Brand + "-" + value.hotel_name.substring(0, 17);
						}
						brand_chart_labels.push(category);
						brand_chart_data.push(parseFloat(value.rate));
					});
					$('.brand_hotel').show();
					$('#brand_chart').show();
					$('#brand_hotel_message').hide();
					$('#brand_chart_message').hide();
					brand_barChart(brand_chart_labels, brand_chart_data);
				} else {
					$('.brand-data').removeClass('d-none');
					$('.brand-ajax-data').addClass('d-none');
					$('.brand_hotel').hide();
					$('#brand_hotel_message').show();
					$('#brand_chart_message').show();
					$('#brand_chart').hide();
					document.getElementById('brand_chart_message').innerHTML = 'No record Found.'
					document.getElementById('brand_hotel_message').innerHTML = 'No record Found.'
				}

				if (res.tier_json != "") {
					var i = 1;
					var tier_chart_labels = [];
					var tier_chart_data = [];
					$.each(res.tier_json, function (index, value) {
						star_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value.hotel_name + `</a></td>
                                <td>$` + Math.round(value.rate) + `</td>
                            </tr>`
						i++;
						$('#tier_html').append(star_html);
						var category = value.hotel_name.substring(0, 15);
						if (value.tier != null) {
							var category = value.tier + "-" + value.hotel_name.substring(0, 15);
						}
						tier_chart_labels.push(category);
						tier_chart_data.push(parseFloat(value.rate));
					});
					$('.tier_hotel').show();
					$('#tier_chart').show();
					$('#tier_hotel_message').hide();
					$('#tier_chart_message').hide();
					tier_barChart(tier_chart_labels, tier_chart_data);
				} else {
					$('.tier-data').removeClass('d-none');
					$('.tier-ajax-data').addClass('d-none');
					$('.tier_hotel').hide();
					$('#tier_hotel_message').show();
					$('#tier_chart_message').show();
					$('#tier_chart').hide();
					document.getElementById('tier_hotel_message').innerHTML = 'No record Found.'
					document.getElementById('tier_chart_message').innerHTML = 'No record Found.'
				}

				if (res.guest_scrorejson != "") {
					var i = 1;
					var guestScrore_chart_labels = [];
					var guestScrore_chart_data = [];
					$.each(res.guest_scrorejson, function (index, value) {
						star_html = `<tr>
                                <td>` + i + `</td>
                                <td><a href="` + hotel_data_url + value.hotelid + `/` + web_site_string + `" target="_blank">` + value
							.hotel_name + `</a></td>
                                <td>` + value.guest_score + `</td>
                            </tr>`
						i++;
						$('#guest_score_html').append(star_html);
						var country = value.hotel_name.substring(0, 25);
						guestScrore_chart_labels.push(country);
						guestScrore_chart_data.push(parseFloat(value.guest_score));
					});
					$('.guest_score_data').show();
					$('#guest_score_chart').show();
					$('#guest_score_message').hide();
					$('#guest_score_chart_message').hide();
					guestScore_donutChart(guestScrore_chart_labels, guestScrore_chart_data);
				} else {
					$('.guest-score-data').removeClass('d-none');
					$('.guest-score-ajax-data').addClass('d-none');
					$('.guest_score_data').hide();
					$('.guest_score').hide();
					$('#guest_score_message').show();
					$('#guest_score_chart_message').show();
					$('#guest_score_chart').hide();
					document.getElementById('guest_score_message').innerHTML = 'No record Found.'
					document.getElementById('guest_score_chart_message').innerHTML = 'No record Found.'
				}
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
			/*$("#error_toast").attr('data-toast-text', "Something went wrong!!");
			$("#error_toast").trigger('click');*/
		},
        complete: function(data) {
			$("#price_table_data_div").find('.loading-ct').hide();
			$("#price_chart_data_div").find('.loading-ct').hide();
			$("#guest_score_table_data_div").find('.loading-ct').hide();
			$("#guest_score_chart_data_div").find('.loading-ct').hide();
			$("#star_table_data_div").find('.loading-ct').hide();
			$("#star_chart_data_div").find('.loading-ct').hide();
			$("#brand_table_data_div").find('.loading-ct').hide();
			$("#brand_chart_data_div").find('.loading-ct').hide();
			$("#tier_table_data_div").find('.loading-ct').hide();
			$("#tier_chart_data_div").find('.loading-ct').hide();
        }
    });
}

$(document).on('click', '.star-filter', function() {
    var checked = $(this).val();
    if ($(this).is(':checked')) {
        star.push(checked);
    } else {
        star.splice($.inArray(checked, star), 1);
    }

	get_single_web_data();
});

$(document).on('click', '.guest-filter', function() {
    var checked = $(this).val();
    if ($(this).is(':checked')) {
        guest.push(checked);
    } else {
        guest.splice($.inArray(checked, guest), 1);
    }

	get_single_web_data();
});

$(document).on('click', '.brand-filter', function() {
    var checked = $(this).val();
    if ($(this).is(':checked')) {
        brand.push(checked);
    } else {
        brand.splice($.inArray(checked, brand), 1);
    }

	get_single_web_data();
});

$(document).on('click', '.tier-filter', function() {
    var checked = $(this).val();
    if ($(this).is(':checked')) {
        tier.push(checked);
    } else {
        tier.splice($.inArray(checked, tier), 1);
    }

	get_single_web_data();
});

$('#filter_state').change(function() {
    var state_code = $('#filter_state').val();
    // console.log(state_code);

	$.each(xhrPool, function(idx, jqXHR) {
		jqXHR.abort();
	});

    if (state_code != '') {
		$('#filter_city').html("");
		$("#filter_city").select2('destroy').val("").select2({
			placeholder: "Loading...",
			allowClear: true,
			width: '100%',
			language: {
				noResults: function () {
					return "";
				}
			}
		});

        $.ajax({
            url: "<?php echo base_url() . 'fetch_city'; ?>",
            method: "POST",
            data: {
                "state_code": state_code,
				"selected_cities": selected_cities
            },
            success: function(res) {
				var res = JSON.parse(res);
				if (res.status == 1) {
					$("#filter_city").select2('destroy').val("").select2({
						placeholder: "Select City",
						allowClear: true,
						width: '100%'
					});
					$('#filter_city').html(res.html);
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
			},
			complete: function (){
				get_single_web_data();
			}
        });
    } else {
        $('#filter_city').html("");
        $("#filter_city").select2('destroy').val("").select2({
            placeholder: "Select City",
            allowClear: true,
            width: '100%'
        });
		get_single_web_data();
	}
});

function fill_cities(user_state, user_city) {
    $.ajax({
        url: "<?php echo base_url() . 'fetch_city'; ?>",
        method: "POST",
        data: {
            "state_code": user_state,
            "user_city": user_city
        },
        success: function(res) {
			var res = JSON.parse(res);
			if (res.status == 1) {
				$("#filter_city").select2('destroy').val("").select2({
					placeholder: "Select City",
					allowClear: true,
					width: '100%'
				});
				$('#filter_city').html(res.html);

				var city_cnt = $("#filter_city option:selected").length;
				var state_cnt = $("#filter_state option:selected").length;
				if (city_cnt == 1){
					var city = $("#filter_city option:selected").html();
					$("#price_table_heading").html(`Top 10 ${city} Hotel Price`);
					$("#price_chart_heading").html(`Top 10 ${city} Hotel Price Chart`);
					$("#guest_score_table_heading").html(`Top 10 ${city} Hotel Guest Score`);
					$("#guest_score_chart_heading").html(`Top 10 ${city} Hotel Guest Score Chart`);
					$("#star_table_heading").html(`Top 10 ${city} Hotel Star`);
					$("#star_chart_heading").html(`Top 10 ${city} Hotel Star Chart`);
					$("#brand_table_heading").html(`Top 10 ${city} Hotel Brand`);
					$("#brand_chart_heading").html(`Top 10 ${city} Hotel Brand Chart`);
					$("#tier_table_heading").html(`Top 10 ${city} Hotel Tier`);
					$("#tier_chart_heading").html(`Top 10 ${city} Tier Chart`);
				}
				else if(city_cnt==0 && state_cnt==1){
					var state = $("#filter_state option:selected").html();
					$("#price_table_heading").html(`Top 10 ${state} Hotel Price`);
					$("#price_chart_heading").html(`Top 10 ${state} Hotel Price Chart`);
					$("#guest_score_table_heading").html(`Top 10 ${state} Hotel Guest Score`);
					$("#guest_score_chart_heading").html(`Top 10 ${state} Hotel Guest Score Chart`);
					$("#star_table_heading").html(`Top 10 ${state} Hotel Star`);
					$("#star_chart_heading").html(`Top 10 ${state} Hotel Star Chart`);
					$("#brand_table_heading").html(`Top 10 ${state} Hotel Brand`);
					$("#brand_chart_heading").html(`Top 10 ${state} Hotel Brand Chart`);
					$("#tier_table_heading").html(`Top 10 ${state} Hotel Tier`);
					$("#tier_chart_heading").html(`Top 10 ${state} Tier Chart`);
				}
				else {
					$("#price_table_heading").html(`Top 10 Hotel Price`);
					$("#price_chart_heading").html(`Top 10 Hotel Price Chart`);
					$("#guest_score_table_heading").html(`Top 10 Hotel Guest Score`);
					$("#guest_score_chart_heading").html(`Top 10 Hotel Guest Score Chart`);
					$("#star_table_heading").html(`Top 10 Hotel Star`);
					$("#star_chart_heading").html(`Top 10 Hotel Star Chart`);
					$("#brand_table_heading").html(`Top 10 Hotel Brand`);
					$("#brand_chart_heading").html(`Top 10 Hotel Brand Chart`);
					$("#tier_table_heading").html(`Top 10 Hotel Tier`);
					$("#tier_chart_heading").html(`Top 10 Tier Chart`);
				}
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

$(document).on('change', '#filter_city', function (){
	selected_cities = [];
	$("#filter_city option:selected").each(function (){
		selected_cities.push($(this).val());
	})

	get_single_web_data();
})

$(document).on('change', '#minCost', function (){
	get_single_web_data();
})

$(document).on('change', '#maxCost', function (){
	get_single_web_data();
})

$(document).on('click', '#more_filter_btn', function (){
	$("#check_in_check_out_date").show();
	$("#price_filter").show();
	$("#brands_filter_div").show();
	$("#tiers_filter_div").show();
	$("#ratings_filter_div").show();
	$("#guest_scores_filter_div").show();

	$(this).html(`<i class="ri-close-line me-2 align-bottom"></i>Close`);
	$(this).attr('id', 'close_filter_btn');
})

$(document).on('click', '#close_filter_btn', function (){
	$("#check_in_check_out_date").hide();
	$("#price_filter").hide();
	$("#brands_filter_div").hide();
	$("#tiers_filter_div").hide();
	$("#ratings_filter_div").hide();
	$("#guest_scores_filter_div").hide();

	$(this).html(`<i class="ri-equalizer-fill me-2 align-bottom"></i>Filters`);
	$(this).attr('id', 'more_filter_btn');
})
</script>

</body>
</html>
