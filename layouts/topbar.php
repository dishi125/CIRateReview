<?php
$user_permissions = $this->session->userdata('user_permissions');
$is_display_customer_dropdown = false;
if (isset($user_permissions) && !empty($user_permissions)) {
	foreach ($user_permissions as $permission) {
		if (($permission['display_name'] == "Add Customer" && $permission['is_add'] == true && $permission['is_view'] == true) || ($permission['display_name'] == "Manage Website" && $permission['is_add'] == true && $permission['is_view'] == true)) {
			$is_display_customer_dropdown = true;
		}
	}
}

$user_id = $this->session->userdata('user_id');
if ($this->session->userdata('new_user_id') && $this->session->userdata('new_user_id')!=""){
	$user_id = $this->session->userdata('new_user_id');
}

$this->RateAndReviewDb = $this->load->database('RateAndReview', true);
if (isset($page) && ($page=="manage_hotels" || $page=="respond_review" || $page=="manage_credentials" || $page=="review_summary" || $page=="review_report" || $page=="rr_dashboard" || $page=="manage_website" || $page=="view_report")){
	$this->RateAndReviewDb->select('ch.id,ch.hotel_name,ch.email,ch.copy_recipients');
	$this->RateAndReviewDb->from('client_hotels ch');
	$this->RateAndReviewDb->join('RR_customer as rrc', 'rrc.user_id = ch.client_id', 'left');
	$this->RateAndReviewDb->where('rrc.user_id',$user_id);
	$this->RateAndReviewDb->where('ch.is_deleted',0);
	$hotels = $this->RateAndReviewDb->get();
	$hotels = $hotels->result_array();
}
else {
	$this->RateAndReviewDb->select('SystemHotel, MappedHotelName, HotelColor, HotelCode');
	$this->RateAndReviewDb->from('RR_Hotel');
	$this->RateAndReviewDb->where('UserId', $user_id);
	$this->RateAndReviewDb->where('IsDelete', 0);
	$this->RateAndReviewDb->where('IsCompetitorHotel', 0);
	$own_hotels = $this->RateAndReviewDb->get();
	$own_hotels = $own_hotels->result_array();
	$MappedHotelNames = array_column($own_hotels, 'MappedHotelName');
	$MappedHotelNames = array_unique($MappedHotelNames);
	$own_hotels = array_filter($own_hotels, function ($key, $value) use ($MappedHotelNames) {
		return in_array($value, array_keys($MappedHotelNames));
	}, ARRAY_FILTER_USE_BOTH);
	if (isset($own_hotels) && !empty($own_hotels)) {
		$this->session->set_userdata('own_hotel_code', $own_hotels[0]['HotelCode']);
		$hotel_name = $own_hotels[0]['MappedHotelName'];
	}
}
?>
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex" id="header_div">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo base_url().'assets/images/logo-sm.png'; ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url().'assets/images/psmtech_logo.png'; ?>" alt="" height="40">
                        </span>
                    </a>

                    <a href="" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo base_url().'assets/images/logo-sm.png'; ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url().'assets/images/psmtech_logo.png'; ?>" alt="" height="40">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
				<label for="basiInput" id="own_hotel_customer" class="form-label mb-0 app-search" style="font-size: x-large; font-weight:bold; color: <?= (isset($own_hotels) && !empty($own_hotels)) ? $own_hotels[0]['HotelColor'] : '' ?>"><?= (isset($hotel_name)) ? $hotel_name : '' ?></label>
			</div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

				<?php if ($is_display_customer_dropdown == true) { ?>
				<div class="d-sm-flex ms-1 d-none header-item">
<!--					<label for="basiInput" class="form-label mb-0 app-search" style="padding-left: 20px">Customer</label>-->
					<select name="users_dropdown" id="users_dropdown" class="form-control">
						<option value=""></option>
						<?php $users = $this->session->userdata('all_users');
						foreach ($users as $user){ ?>
							<option value="<?= $user['id'] ?>" <?php if($user['id']==$user_id) {?> selected <?php } ?>><?= $user['user_name'] ?></option>
						<?php } ?>
					</select>
				</div>
				<?php } ?>

				<div class="d-sm-flex ms-1 d-none header-item">
<!--					<label for="basiInput" class="form-label mb-0 app-search" style="padding-left: 20px">Hotels</label>-->
					<?php
					if (isset($page) && $page=="dashboard") {

					} else { ?>
					<select name="own_hotels_dropdown" id="own_hotels_dropdown" class="form-select">
						<?php if (isset($hotels) && !empty($hotels)){ ?>
							<option value="all" selected>All Hotels</option>
						<?php foreach ($hotels as $key => $hotel){ ?>
							<option value="<?= $hotel['id'] ?>"><?= $hotel['hotel_name'] ?></option>
						<?php } } ?>

						<?php if (isset($own_hotels) && !empty($own_hotels)){ ?>
						<?php foreach ($own_hotels as $key => $own_hotel){ ?>
							<option value="<?= $own_hotel['HotelCode'] ?>" <?php if($key==0) {?> selected <?php } ?>><?= $own_hotel['MappedHotelName'] ?></option>
						<?php } } ?>
					</select>
					<?php } ?>
				</div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php echo base_url().'assets/images/users/avatar-1.jpg'; ?>" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text"><?php echo $this->session->userdata('username'); ?></span>
                                <span class="d-none d-xl-block ms-1 fs-13 text-muted user-name-sub-text"><?php echo $this->session->userdata('role_name'); ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome <?php echo $this->session->userdata('username'); ?>!</h6>
                        <a class="dropdown-item" href="pages-profile.php"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
<!--                        <a class="dropdown-item" href="apps-chat.php"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>-->
<!--                        <a class="dropdown-item" href="apps-tasks-kanban.php"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>-->
<!--                        <a class="dropdown-item" href="pages-faqs.php"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>-->
<!--                        <div class="dropdown-divider"></div>-->
<!--                        <a class="dropdown-item" href="pages-profile.php"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>-->
<!--                        <a class="dropdown-item" href="pages-profile-settings.php"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>-->
<!--                        <a class="dropdown-item" href="auth-lockscreen-basic.php"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>-->
                        <a class="dropdown-item" href="<?php echo base_url().'logout';?>"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo base_url().'assets/images/logo-sm.png'; ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo base_url().'assets/images/psmtech_logo.png'; ?>" alt="" height="40">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo base_url().'assets/images/logo-sm.png'; ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo base_url().'assets/images/psmtech_logo.png'; ?>" alt="" height="40">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
			<?php $user_permissions = $this->session->userdata('user_permissions');?>
            <?php //print_r($user_permissions);?>
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Menu</span></li>
				<?php if(isset($user_permissions) && !empty($user_permissions)) {
				foreach ($user_permissions as $permission_page){ ?>
				<?php if ($permission_page['parent_id'] == 0){ ?>
				<?php if ($permission_page['display_name'] == "Settings"){ ?>
					<li class="nav-item">
						<a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button"
						   aria-expanded="false" aria-controls="sidebarSettings">
							<i class="<?= $permission_page['icon'] ?>"></i> <span><?= $permission_page['display_name'] ?></span>
						</a>
						<div class="collapse menu-dropdown" id="sidebarSettings">
							<ul class="nav nav-sm flex-column">
								<?php foreach ($user_permissions as $permission_page){ ?>
								<?php if ($permission_page['parent_id'] == 9) { ?>
								<li class="nav-item abort_ajax">
									<a href="<?= base_url().ltrim($permission_page['router_link'], '/') ?>" class="nav-link" ><?= $permission_page['display_name'] ?></a>
								</li>
								<?php } } ?>
							</ul>
						</div>
					</li>
				<?php
             } else if ($permission_page['display_name'] == "Review Management"){ ?>
					<li class="nav-item">
						<a class="nav-link menu-link" href="#sidebarReviewManagement" data-bs-toggle="collapse" role="button"
						   aria-expanded="false" aria-controls="sidebarSettings">
							<i class="<?= $permission_page['icon'] ?>"></i> <span><?= $permission_page['display_name'] ?></span>
						</a>
						<div class="collapse menu-dropdown" id="sidebarReviewManagement">
							<ul class="nav nav-sm flex-column">
								<?php foreach ($user_permissions as $permission_page){ ?>
								<?php if ($permission_page['parent_id'] == 11) { ?>
								<li class="nav-item abort_ajax">
									<a href="<?= base_url().ltrim($permission_page['router_link'], '/') ?>" class="nav-link" ><?= $permission_page['display_name'] ?></a>
								</li>
								<?php } } ?>
							</ul>
						</div>
					</li>
				<?php }
                
                else { ?>
					<li class="nav-item abort_ajax">
						<a class="nav-link menu-link" href="<?= base_url().ltrim($permission_page['router_link'], '/') ?>">
							<i class="<?= $permission_page['icon'] ?>"></i> <span><?= $permission_page['display_name'] ?></span>
						</a>
					</li>
				<?php } } } }?>

				<li class="nav-item abort_ajax">
					<a class="nav-link menu-link" href="<?= base_url('dm_customer_signup_list') ?>">
						<i class=""></i> <span>DM Customer Signup</span>
					</a>
				</li>

				<li class="nav-item abort_ajax">
					<a class="nav-link menu-link" href="<?= base_url('support_list') ?>">
						<i class=""></i> <span>Support</span>
					</a>
				</li>
			</ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

