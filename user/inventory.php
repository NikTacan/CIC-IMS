<?php include('../includes/session.php'); ?>

<?php
	$inventories = $model->getInventoryByEndUserId($end_user_id);
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

<title>Inventory | <?php echo $customize['sys_name']; ?></title>

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
			<li class="show" style="margin-top: 0px;">
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
			<li class="" style="margin-top: 0px;">
				<a href="history" class="ttr-material-button">
					<span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
					<span class="ttr-label">Activity Logs</span>
				</a>
			</li>
		</ul>
	</nav>
</div>
</div>
<main class="ttr-wrapper">
	<div class="container-fluid">

		<div class="ttr-container-header row col-lg-12 mb-3">
			<div class="d-flex justify-content-between mx-0 px-0">
				<div class="float-left">
					<h2 class="p-0 ms-2 mb-0">Inventory</h2>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				<div class="widget-box">
					<div class="widget-inner">
						<div style="padding: 10px;"></div>	

						
						<!-- Inventory table -->
						<div class="table-responsive">
							<table id="table" class="table hover" style="width:100%">
								<thead>
									<tr>
										<th width="140">Property No.</th>
										<th class="col-7">Description</th>
										<th>Date Added</th>
										<th class="col-1">Action</th>
									</tr>	
								</thead>
								<tbody>
									<?php if (!empty($inventories)): ?>
										<?php foreach ($inventories as $inventory): ?>
											<?php $inv_id = $inventory['item_id']; ?>

											<tr>
												<td><?php echo $inventory['property_no']; ?></td>
												<td class="description-cell"><?php echo $inventory['description']; ?></td>												
												<td><?php echo date('M. d, Y g:i A', strtotime($inventory['date_added'])); ?></td>

												<td>
													<center>
														<button id="<?php echo $inv_id;?>" onclick="window.location.href='inventory-view.php?id=<?php echo $inv_id; ?>'" type="submit" name="view" class="btn green mt-1" style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="View">
																<i class="ti-search" style="font-size: 12px;"></i>
															</span>
														</button>
													</center>
												</td>
											</tr>

										<?php endforeach; ?> <!-- table data end foreach -->
									<?php endif; ?> <!-- table data end if -->
									
								</tbody>
							</table>
						</div> <!-- table-responsive -->
							
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