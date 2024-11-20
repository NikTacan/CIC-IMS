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

						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="deleteLogs">
							<div class="row float-right">
								<div class="col float-right">
									<button type="submit" class="btn red" name="deleteRows" id="deleteButton" style="display: none;">
										Delete Selected
									</button>
								</div>
							</div>
							<br><br>

							<div class="row table-reponsive">	
								<table id="table" class="table" style="width:100%">
									<thead>
										<tr>
											<th class="text-center"><input type="checkbox" name="logs-master-checkbox"></th>
											<th class="col-8">Activity</th>
											<th >Date & Time</th>
											<th class="col-1">Action</th>
										</tr>
									</thead>
									<tbody>

										<?php if (!empty($logs = $model->getHistoryLogByEndUser($session_name))): ?>
											<?php foreach ($logs as $log): ?>
												<?php 	
													$module = $log['module'];
													$transaction_type = $log['transaction_type'];
													$item_no = $log['item_no'];

												?>

												<tr>
													<td class="text-center"><input class="me-3" type="checkbox" name="delete[]" value="<?php echo $log['id']; ?>"></td>
													<td>
														<span class="text-bold">
															<?php echo mb_strimwidth($log['description'], 0, 40, '...'); ?>
														</span>
														<span class="text-normal"><?php echo $log['log_message']; ?></span>
													</td>
													<td><?php echo date('M d, Y g:i A', strtotime($log['date_time'])); ?></td>
													
													<!-- If module is Assignment -->
													<?php if($module == 'assignment'): ?>
														<?php if($transaction_type == 'INSERT'): ?>
															<td class="col-1">
																<a href="inventory-assignment" class="btn green mt-1" style="width: 50px; height: 37px;">
																	<span data-toggle="tooltip">
																		<i class="ti-search" style="font-size: 12px;"></i>
																	</span>
																</a>
															</td>
														<?php else: ?>
															<td></td>
														<?php endif; ?> <!-- If module is Assignment -->
													<?php endif; ?>

												</tr>

											<?php endforeach; ?>
										<?php endif; ?> <!-- activity logs table data endif -->
										
									</tbody>
								</table>
							</div> <!-- table responsive end div -->
						</form> <!-- Delete logs form -->
								
						<?php 

						
							if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteRows']) && isset($_POST['delete'])) {
								$ids = $_POST['delete'];

								if (!empty($ids)) {
									$model->deleteActivityLogs($ids);
									echo "<script>alert('Activity logs are deleted!');window.open('history', '_self')</script>";
								} else {
									echo "<script>alert('No rows selected for deletion!');</script>";
								}
								
							}

						?>

					</div> <!-- widget-inner -->		
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const masterCheckbox = document.querySelector("input[name='logs-master-checkbox']");
			const checkboxes = document.querySelectorAll("input[name='delete[]']");
			const deleteButton = document.getElementById("deleteButton");

			// Toggle all checkboxes when the master checkbox is clicked
			masterCheckbox.addEventListener("change", function () {
				checkboxes.forEach(checkbox => checkbox.checked = masterCheckbox.checked);
				toggleDeleteButton();
			});

			// Show delete button when at least one checkbox is selected
			checkboxes.forEach(checkbox => {
				checkbox.addEventListener("change", toggleDeleteButton);
			});

			function toggleDeleteButton() {
				const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
				deleteButton.style.display = anyChecked ? "inline-block" : "none";
			}

			// Confirm deletion
			deleteButton.addEventListener("click", function (event) {
				if (!confirm("Are you sure you want to delete the selected logs?")) {
					event.preventDefault();
				}
			});
		});
	</script>

</body>
</html>