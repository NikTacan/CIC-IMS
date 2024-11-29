<?php include('../includes/session.php'); ?>
<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Activity Logs | <?php echo $customize['sys_name']; ?></title>

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
					<a href="location" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
						<span class="ttr-label">Location</span>
					</a>
				</li>
				<li class="show" style="margin-top: 0px;">
					<a href="history" class="ttr-material-button">
						<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
						<span class="ttr-label">Activity Logs</span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
<main class="ttr-wrapper" style="background-color: #F3F3F3;">
	<div class="container-fluid">

		<h2 class="title-head">Activity Logs<span> </span></h2>

		<div class="row">
			<div class="col-lg-12 m-b30">
			
				<div class="widget-box">
					<div class="widget-inner">

							<div class="table-reponsive">	
								<table id="table" class="table hover" style="width:100%">
									<thead>
										<tr>
											<th class="col-9">Activity</th>
											<th >Date & Time</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($logs = $model->getHistoryLogByEndUser($end_user_id))): ?>
											<?php foreach ($logs as $log): ?>
												<tr>
													<td>
														<span class="text-bold">
															<?php echo mb_strimwidth($log['description'], 0, 40, '...'); ?>
														</span>
														<span class="text-normal"><?php echo $log['log_message']; ?></span>
													</td>
													<td><?php echo date('F d, Y   g:i A', strtotime($log['date_time'])); ?></td>
												</tr>

											<?php endforeach; ?>
										<?php endif; ?> <!-- activity logs table data endif -->
										
									</tbody>
								</table>
							</div> <!-- table responsive end div -->
								

					</div> <!-- widget-inner -->		
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

</body>
</html>