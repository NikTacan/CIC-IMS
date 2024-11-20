	<header class="ttr-header">
		<div class="ttr-header-wrapper">
			<div class="ttr-toggle-sidebar ttr-material-button">
				<i class="ti-close ttr-open-icon text-secondary"></i>
				<i class="ti-menu ttr-close-icon text-secondary"></i>
			</div>
			<div class="ttr-logo-box">
				<div>
					<a href="index" class="ttr-logo">
						<img alt="" class="ttr-logo-mobile me-2" src="../assets/images/<?php echo $customize['logo_file']; ?>" style="width: 32px; height: 30px;">
						<img alt="" class="ttr-logo-desktop me-2" src="../assets/images/<?php echo $customize['logo_file']; ?>" style="width: 32px; height: 30px;">
						<div class="p-0 ms-2" style="border-left: 3px solid #F0F0F0; height: 30px;">
							<h4 class="sys-name p-0 ms-3 mb-0 "><?php echo $customize['sys_name']; ?></h4>
						</div>
					</a>
				</div>
			</div>
			<div class="ttr-header-menu">
			</div>
			<div class="ttr-header-right ttr-with-seperator float-right">
				<ul class="ttr-header-navigation">
					<li>
						<a href="#" class="ttr-material-buttooon ttr-submenu-toggle"><span class="ttr-user-avatar text-primary"><i class="fa fa-cog fa-spinn text-secondary" style="font-size: 32px;"></i></span></a>
						<div class="ttr-header-submenu">
							<ul>
								<li><a href="logout">Logout</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</header>
	<div class="ttr-sidebar">
		<div class="ttr-sidebar-wrapper content-scroll">
			<div style="height: 135px">
				<div class="ttr-sidebar-logo" style="background-image: url('../assets/images/cic-bldg.png'); background-position: center; background-repeat: no-repeat;background-size: cover; height: 135px; border-color: #222831; background-color: rgba(0, 0, 0, 0.5);">
					<div class="ttr-sidebar-toggle-button">
						<i class="ti-arrow-left" style="color: blue;"></i>
					</div>
				
					<div style="padding-left: px; padding-top: 12px;">
					<a href="user-view?id=<?php echo $account_id; ?>">
						<!--<div class="image">
							<img src="../assets/images/profile-img/default.jpg" alt="User" style="  width: 50px; height: 50px; border-radius: 50%;object-fit: cover;cover;border: 1px solid #E2E2E2;">
						</div>-->
						<div class="mt-4" style="height: 8px;">
						</div>
						<div class="info-container">
							
							<div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white; font-size: 17px;"><b><?php echo $session_name; ?></b></div>
							
			
						</div>
					</a>	
					</div>
				</div>
			</div>