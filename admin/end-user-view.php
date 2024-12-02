<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php
	if (isset($_GET['id'])) {
		$endUserId = $_GET['id'];
		$endUserDetail = $model->getEndUserDetailByID($endUserId);
	
		$assignedItems = $model->getEndUserAssignment($endUserId);
	}
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>End User| <?php echo $customize['sys_name']; ?></title>

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
				<li class="show" style="margin-top: 0px;">
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
				<?php if($userInfo['role_id'] == 1): ?>
				<li style="padding-left: 20px; padding-top: 40px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
					<span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Admin Settings</span>
				</li>
				<li class="" style="margin-top: 0px;">
					<a href="sub-admin" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-address-book" aria-hidden="true"></i></span>
						<span class="ttr-label">Sub Admin</span>
					</a>
				</li>
				<li class="" style="margin-top: 0px;">
					<div class="accordion accordion-flush" id="accordionSettings">
						<div class="accordion-item">
							<h2 class="accordion-header">
							<button class="accordion-button ps-3.5 py-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings" ><i class="fa fa-solid fa-gear me-2 pe-3" aria-hidden="true"></i>
							Settings
							</button>
							</h2>
						<div id="collapseSettings" class="accordion-collapse collapse" data-bs-parent="#accordionSettings">
						<div class="accordion-body p-0">
							<div class="">
								<a href="system-content" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">General Content</span>
								</a>
							</div>
							<div class="">
								<a href="customize" class="ttr-material-button mx-0 my-0">
									<span class="ttr-icon"></span>
									<span class="ttr-label">Components</span>
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
				<?php else: ?>
				<li class="" style="margin-top: 0px;">
					<a href="history" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
						<span class="ttr-label">Activity Logs</span>
					</a>
				</li>
				<?php endif; ?>
			</ul>
		</nav>
	</div>
</div>
<main class="ttr-wrapper" style="background-color: #F3F3F3;">
	<div class="container-fluid">

		<!-- Header title -->
		<div class="ttr-main-header">
			<div class="float-left">
				<h2 class="title-head float-left">End User<span class="fw-normal"> Details</span></h2>
			</div><br><br><br>
		</div> <!-- Header title -->

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div id="preloader"></div>
					<div class="widget-inner">
						<div class="row" width="100%">
							
							<h2 class="text-center"><?php echo $endUserDetail['first_name'] . ' ' . $endUserDetail['last_name'] ; ?><br>
								<span class="fw-light mt-0 pt-0" style="font-size: 21px;"><?php echo $endUserDetail['designation_name']; ?></span>
							</h2>
							<div class="mt-3"></div>	

							<table id="table" class="table table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<th>Property No.</th>
										<th class="col-4">Description</th>
										<th width="50">Quantity</th>
										<th width="40">Unit</th>
										<th>Unit Cost</th>
										<th width="150">Assigned to <br>End User</th>
										<th width="40">View</th>
									</tr>
								</thead>
								<tbody>
									
									<!-- Inventory assignment record -->
									<?php if(!empty($assignedItems)): ?>
										<?php foreach ($assignedItems as $itemInfo): ?>
											<?php $assignment_id = $itemInfo['assignment_id']; ?>

											<tr>
												<td><?php echo $itemInfo['property_no']; ?></td>
												<td>
													<?php
														// Split the description into an array of words
														$words = explode(' ', $itemInfo['description']);

														// Display the first 5 words
														echo implode(' ', array_slice($words, 0, 7));
													?>
												</td>
												<td><?php echo $itemInfo['qty']; ?></td>
												<td><?php echo $itemInfo['unit']; ?></td>
												<td><?php echo $itemInfo['unit_cost']; ?></td>
												<td><?php echo date('M. d, Y g:i A', strtotime($itemInfo['date_added'])); ?></td>
												<td>
													<center>
														<button onclick="window.location.href='inventory-assignment-view.php?id=<?php echo $assignment_id; ?>'" type="submit" name="view" class="btn green" style="width: 50px; height: 37px;">
															<span data-toggle="tooltip">
																<i class="ti-search" style="font-size: 12px;"></i>
															</span>
														</button>
												</center>
												</td>
											</tr>

										<?php endforeach; ?>
									<?php endif; ?> <!-- Inventory assignment record -->

								</tbody>	
							</table>
							
						</div> <!-- row -->
					</div> <!-- widget-inner -->
				</div> <!-- widger-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>
	<?php include('../includes/js/preloader.php'); ?>

</body>
</html>