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
				<?php foreach ($user_permissions as $permission_page){ ?>
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
								<li class="nav-item">
									<a href="<?= base_url().ltrim($permission_page['router_link'], '/') ?>" class="nav-link" ><?= $permission_page['display_name'] ?></a>
								</li>
								<?php } } ?>
							</ul>
						</div>
					</li>
				<?php
             } else if ($permission_page['display_name'] == "Review Management"){ ?>
					<li class="nav-item">
						<a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button"
						   aria-expanded="false" aria-controls="sidebarSettings">
							<i class="<?= $permission_page['icon'] ?>"></i> <span><?= $permission_page['display_name'] ?></span>
						</a>
						<div class="collapse menu-dropdown" id="sidebarSettings">
							<ul class="nav nav-sm flex-column">
								<?php foreach ($user_permissions as $permission_page){ ?>
								<?php if ($permission_page['parent_id'] == 11) { ?>
								<li class="nav-item">
									<a href="<?= base_url().ltrim($permission_page['router_link'], '/') ?>" class="nav-link" ><?= $permission_page['display_name'] ?></a>
								</li>
								<?php } } ?>
							</ul>
						</div>
					</li>
				<?php }
                
                else { ?>
					<li class="nav-item">
						<a class="nav-link menu-link" href="<?= base_url().ltrim($permission_page['router_link'], '/') ?>">
							<i class="<?= $permission_page['icon'] ?>"></i> <span><?= $permission_page['display_name'] ?></span>
						</a>
					</li>
				<?php } } }?>
			</ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
