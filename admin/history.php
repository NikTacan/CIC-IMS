<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>
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
					<div class="accordion accordion-flush" id="accordionSettings">
						<div class="accordion-item">
							<h2 class="accordion-header">
							<button class="accordion-button ps-3.5 py-1 collapsed" style="text-color: #FFFFFF; color: #FFFFFF;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings" ><i class="fa fa-solid fa-gear me-2 pe-3" aria-hidden="true"></i>
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
				<li class="show" style="margin-top: 0px;">
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

		<h2 class="title-head">Activity Logs<span> </span></h2>

		<div class="row">
			<div class="col-lg-12 m-b30">
			
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

						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="deleteLogs">
							<div class="row float-right">
								<div class="col float-right">
									<button type="submit" class="btn red" name="deleteRows" id="deleteButton" style="display: none;">
										Delete Selected
									</button>
								</div>
							</div>
							<br><br>
		
							<div class="table-reponsive">	
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

										<?php if (!empty($logs = $model->displayHistoryLog())): ?>
											<?php foreach ($logs as $log): ?>
												<?php 	
													$module = $log['module'];
													$transaction_type = $log['transaction_type'];
													$item_no = $log['item_no'];
													$user_id = $log['user_id'];
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
													
													<!-- If module is inventory -->
													<?php if($module == 'inventory'): ?>
														<?php if($transaction_type == 'INSERT' || $transaction_type == 'UPDATE'): ?>
															<td class="col-1">

																<?php if($model->checkInvNoExist($item_no)): ?>
																<a href="inventory-view.php?id=<?php echo $item_no; ?>" class="btn green mt-1" style="width: 50px; height: 37px;">
																	<span data-toggle="tooltip">
																		<i class="ti-search" style="font-size: 12px;"></i>
																	</span>
																</a>
																<?php else: ?>
																	<a href="inventory.php" class="btn green mt-1" style="width: 50px; height: 37px;">
																	<span data-toggle="tooltip">
																		<i class="ti-search" style="font-size: 12px;"></i>
																	</span>
																	</a>
																<?php endif; ?>

															</td>
														<?php elseif($transaction_type == 'ARCHIVE' || $transaction_type == 'DELETE'): ?>
															<td class="col-1">
																<a href="archive-inventory" class="btn green mt-1" style="width: 50px; height: 37px;">
																	<span data-toggle="tooltip">
																		<i class="ti-search" style="font-size: 12px;"></i>
																	</span>
																</a>
															</td>
														<?php else: ?>
															<td></td>
														<?php endif; ?> <!-- If module is inventory -->
													
													<!-- If module is Assignment -->
													<?php elseif($module == 'assignment'): ?>
														<?php if($transaction_type == 'INSERT'): ?>
															<td class="col-1">
																<a href="inventory-assignment" class="btn green mt-1" style="width: 50px; height: 37px;">
																	<span data-toggle="tooltip">
																		<i class="ti-search" style="font-size: 12px;"></i>
																	</span>
																</a>
															</td>
														<?php elseif($transaction_type == 'UPDATE'): ?>
															<td class="col-1">
																<a href="inventory-assignment-view.php?id=<?php echo $item_no ?>" class="btn green mt-1" style="width: 50px; height: 37px;">
																	<span data-toggle="tooltip">
																		<i class="ti-search" style="font-size: 12px;"></i>
																	</span>
																</a>
															</td>
														<?php elseif($transaction_type == 'ARCHIVE' || $transaction_type == 'DELETE'): ?>
															<td class="col-1">
																<a href="archive-assignment" class="btn green mt-1" style="width: 50px; height: 37px;">
																	<span data-toggle="tooltip">
																		<i class="ti-search" style="font-size: 12px;"></i>
																	</span>
																</a>
															</td>
														<?php else: ?>
															<td></td>
														<?php endif; ?> <!-- If module is Assignment -->


													<!-- If module is End User -->
													<?php elseif($module == 'end_user'): ?>
														<td class="col-1">
															<a href="end-user" class="btn green mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</a>
														</td> <!-- If module is End User -->
													
													<!-- If module is Category -->
													<?php elseif($module == 'category'): ?>
														<td class="col-1">
															<a href="category" class="btn green mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</a>
														</td> <!-- If module is category -->

													<!-- If module is Category -->
													<?php elseif($module == 'article'): ?>
														<td class="col-1">
															<a href="article" class="btn green mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</a>
														</td> <!-- If module is category -->

													<!-- If module is location -->
													<?php elseif($module == 'location'): ?>
														<td class="col-1">
															<a href="location" class="btn green mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</a>
														</td> <!-- If module is location -->

													<!-- If module is general content -->
													<?php elseif($module == 'system_content'): ?>
														<td class="col-1">
															<a href="system-content" class="btn green mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</a>
														</td> <!-- If module is general content -->
														
													<!-- If module is component -->
													<?php elseif($module == 'component'): ?>
														<td class="col-1">
															<a href="customize" class="btn green mt-1" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</a>
														</td> <!-- If module is component -->

													<?php else: ?>
														<td></td>
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
									$_SESSION['successMessage'] = "Activity log deleted successfully!";
									header("Location: history.php");
									exit();
								} else {
									$_SESSION['errorMessage'] = "No row(s) selected for deletion!";
									header("Location: history.php");
									exit();
								}
								ob_end_flush(); 

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