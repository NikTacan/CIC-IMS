<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>
<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Components | <?php echo $customize['sys_name']; ?></title>

</head>
<body class="ttr-opened-sidebar ttr-pinned-sidebar" style="background-color: #F3F3F3;">

<!-- main header -->
<?php include('../includes/layouts/main-layouts/ttr-header.php') ?>

		<nav class="ttr-sidebar-navi">
			<ul>
				<li style="padding-left: 20px; padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
					<span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Main Navigation</span>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="index" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-home" aria-hidden="true"></i></span>
						<span class="ttr-label">Dashboard</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="inventory" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-database" aria-hidden="true"></i></span>
						<span class="ttr-label">Inventory</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="inventory-assignment" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-file-text" aria-hidden="true"></i></span>
						<span class="ttr-label">Assignment</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="end-user" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-address-book" aria-hidden="true"></i></span>
						<span class="ttr-label">End Users</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="category" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-cubes" aria-hidden="true"></i></span>
						<span class="ttr-label">Categories</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="article" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-cube" aria-hidden="true"></i></span>
						<span class="ttr-label">Article</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="location" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<span class="ttr-label">Location</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="report.php" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></span>
						<span class="ttr-label">Report</span>
					</a>
				</li>
				<li style="padding-left: 20px; padding-top: 40px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
					<span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Admin Settings</span>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="sub-admin" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-address-book" aria-hidden="true"></i></span>
						<span class="ttr-label">Sub Admin</span>
					</a>
				</li>
				<li class="show" style="margin-top: 0px;">
					<div class="accordion accordion-flush" id="accordionSettings">
						<div class="accordion-item">
							<h2 class="accordion-header">
							<button class="accordion-button ps-3.5 py-1 show" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings" ><i class="fa fa-solid fa-gear me-2 pe-3" aria-hidden="true"></i>
							Settings
							</button>
							</h2>
						<div id="collapseSettings" class="accordion-collapse show" data-bs-parent="#accordionSettings">
						<div class="accordion-body p-0">
							<div class="">
								<a href="system-content" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">General Content</span>
								</a>
							</div>
							<div class="show">
								<a href="customize" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon-show"></span>
									<span class="ttr-label-show">Components</span>
								</a>
							</div>
						</div>
					</div>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="history" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
						<span class="ttr-label">Activity Logs</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="archive-inventory" class="ttr-material-button">
						<span class="ttr-icon"><i class="ti-archive" aria-hidden="true"></i></span>
						<span class="ttr-label">Archives</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<main class="ttr-wrapper" style="background-color: #F3F3F3;">
	<div class="container-fluid">
		<div clas="ttr-header">
			<div class="float-left">
				<h2 class="title-head float-left">Components</h2>
			</div><br><br><br>
		</div>
		<div class="widget-box">
   			<div class="widget-inner">

			  	 <?php if (!empty($successMessage)): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<?php echo htmlspecialchars($successMessage); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>

				<?php if (!empty($errorMessage)): ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?php echo htmlspecialchars($errorMessage); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php endif; ?>
				
       			<div class="row" width="100%">
				   <div class="accordion" id="accordionSettings">

						<!-- Status & Remarks -->
						<div class="accordion-item" style="background-color: #FFF;">
							<h2 class="accordion-header">
								<a class="accordion-button collapsed" href="#" style="color: #black; background-color: #fff;"  onMouseOver="this.style.color='#FFF'" onMouseOut="this.style.color='#000'" data-bs-toggle="collapse" data-bs-target="#collapseNote" aria-expanded="false" aria-controls="collapseNote" data-bs-parent="#accordionSettings">
									<h6 class="mb-0">Status & Remarks</h6>
								</a>
							</h2>
							<div id="collapseNote" class="accordion-collapse collapse" data-bs-parent="#accordionSettings">
								<div class="accordion-body p-0">
									<div class="ttr-unit">
										<?php include('../includes/layouts/custom-layouts/custom-status.php') ?>
									</div>
								</div>
							</div>
						</div> <!-- Status & Remarks -->

						<!-- Unit of Measurement -->
						<div class="accordion-item" style="background-color: #FFF;">    
							<h2 class="accordion-header" style="color: #000!important;">
								<a class="accordion-button collapsed" href="#" style="color: #000!important; background-color: #fff;" onMouseOver="this.style.color='#FFF'" onMouseOut="this.style.color='#000'" data-bs-toggle="collapse" data-bs-target="#collapseUnit" aria-expanded="true" aria-controls="collapseUnit" data-bs-parent="#accordionSettings">
									<h6 class="mb-0">Unit of Measurement</h6>
								</a>
							</h2>
							<div id="collapseUnit" class="accordion-collapse collapse" data-bs-parent="#accordionSettings">
								<div class="accordion-body p-0">
									<div class="ttr-unit">
										<?php include('../includes/layouts/custom-layouts/custom-unit.php') ?>
									</div>
								</div>
							</div>
						</div> <!-- Unit of Measurement -->

						<!-- Estimated Useful Life -->
						<div class="accordion-item" style="background-color: #FFF;">    
							<h2 class="accordion-header">
								<a class="accordion-button collapsed" href="#" style="color: #black; background-color: #fff;" onMouseOver="this.style.color='#FFF'" onMouseOut="this.style.color='#000'" data-bs-toggle="collapse" data-bs-target="#collapseLife" aria-expanded="false" aria-controls="collapseLife" data-bs-parent="#accordionSettings">
								<h6 class="mb-0">Estimated Useful Life</h6>
								</a>
							</h2>
							<div id="collapseLife" class="accordion-collapse collapse" data-bs-parent="#accordionSettings">
								<div class="accordion-body p-0">
									<div class="ttr-unit">
										<?php include('../includes/layouts/custom-layouts/custom-est-life.php') ?>
									</div>
								</div>
							</div>
						</div> <!-- Estimated Useful Life -->
						

						<!-- Designation -->
						<div class="accordion-item" style="background-color: #FFF;">
							<h2 class="accordion-header">
								<a class="accordion-button collapsed" href="#" style="color: #black; background-color: #fff;"  onMouseOver="this.style.color='#FFF'" onMouseOut="this.style.color='#000'" data-bs-toggle="collapse" data-bs-target="#collapseDesignation" aria-expanded="false" aria-controls="collapseDesignation" data-bs-parent="#accordionSettings">
									<h6 class="mb-0">Designation </h6>
								</a>
							</h2>
							<div id="collapseDesignation" class="accordion-collapse collapse" data-bs-parent="#accordionSettings">
								<div class="accordion-body p-0">
									<div class="ttr-unit">
										<?php include('../includes/layouts/custom-layouts/custom-designation.php') ?>
									</div>
								</div>
							</div>
						</div> <!-- Designation -->

					</div> <!-- accordion -->
        		</div> <!-- row -->
    		</div> <!-- widget-inner -->
		</div> <!-- widget-box -->
	</div> <!-- container-fluid -->
</main>
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

	<script>
        document.addEventListener('DOMContentLoaded', function() {
        const accordionButtons = document.querySelectorAll('.accordion-button');

            accordionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    accordionButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to the clicked button
                    this.classList.toggle('active');
                });
            });

            // Listen for accordion collapse events
            const accordions = document.querySelectorAll('.accordion-collapse');
            accordions.forEach(accordion => {
                accordion.addEventListener('hidden.bs.collapse', function() {
                    // Remove active class when accordion is collapsed
                    accordionButtons.forEach(btn => btn.classList.remove('active'));
                });
            });
        });
	</script> <!-- components (customize.php) -->

</body>
</html>