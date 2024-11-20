<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php 
	$Categories = $model->displayCategoriesWithCount();
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Category | <?php echo $customize['sys_name']; ?></title>

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
				<li class="show" style="margin-top: 0px;">
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
	<div class="container-fluid" style="margin-right: 50%;">

		<!-- Header and Button Row -->
		<div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Header aligned to the left -->
                    <h2 class="p-0 mb-0">Category</h2>

                    <!-- Button aligned to the right -->
                    <button type="button" class="btn green radius-xl" style="background-color: #5ADA86;" data-toggle="modal" data-target="#insert-category">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-lg-inline">&nbsp;&nbsp;ADD CATEGORY</span>
                    </button>
                </div>
            </div>
        </div>
		
		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
				
					<div class="widget-inner">

						<!-- Insert category modal/forms -->
						<div id="insert-category" class="modal fade" role="dialog">
							<form class="edit-profile m-b30" method="POST" enctype="multipart/form-data">
								<div class="modal-dialog modal-md">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">&nbsp;Add Category Record</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="form-group col-12" style="padding-bottom: 15px;">
													<div class="row">
														<div class="form-group col-12">
															<label class="col-form-label">Category Name</label>
															<input class="form-control" type="text" name="category_name" maxlength="30" value="" placeholder="Enter category name" required>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<input type="submit" class="btn green radius-xl outline" name="insert" value="Save">
											<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</form>
						</div> <!-- Insert category modal/forms -->
						
						<div class="table-responsive">
							<table id="table" class="table hover" style="width:100%">
								<thead>
									<tr>
										<th class="col-1">#</th>
										<th>Category Name</th>
										<th class="col-2">Inventory Count</th>
										<th class="col-sm-1 col-md-2 text-center">Action</th>
									</tr>
								</thead>
								<tbody>

									<?php if (!empty($Categories)): ?>
										<?php foreach ($Categories as $key => $category): ?>
											<?php $category_id = $category['id']; ?>
								
											<tr>
												<td><?php echo $key + 1 ?></td>
												<td><?php echo $category['category_name']; ?></td>
												<td><?php echo $category['inventory_count']; ?></td>

												<td>
													<center>
														<button class="btn green mb-1" id="<?php echo $category_id;?>" onclick="window.location.href='category-view.php?id=<?php echo $category_id;?>'" type="submit" name="view"  style="width: 50px; height: 37px;">
															<span data-toggle="tooltip">
																<i class="ti-search" style="font-size: 12px;"></i>
															</span>
														</button>
														<button class="btn blue mb-1" data-toggle="modal" data-target="#update-<?php echo $category_id; ?>"  style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="Update">
																<i class="ti-marker-alt" style="font-size: 12px;"></i>
															</span>
														</button>
														<button class="btn red mb-1" data-toggle="modal" data-target="#delete-<?php echo $category_id; ?>" style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="Delete">
																<i class="ti-archive" style="font-size: 12px;"></i>
															</span>
														</button>
													</center>
												</td>
											</tr>
									
											<!-- Update category record modal/form -->
											<div id="update-<?php echo $category_id; ?>" class="modal fade" role="dialog">
												<form class="edit-profile m-b30" method="POST" enctype="multipart/form-data">
													<div class="modal-dialog modal-md">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Update Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="category_id" value="<?php echo $category_id ?>">
																	<div class="form-group col-12" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-12">
																				<label class="col-form-label">Category Name</label>
																				<input class="form-control" type="text" name="category_name" value="<?php echo $category['category_name']; ?>" maxlength="30" required>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="update" value="Save Changes">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Update category record modal/form -->
									
											<!-- Delete category record modal/form -->
											<div id="delete-<?php echo $category_id; ?>" class="modal fade" role="dialog">
												<form class="edit-profile m-b30" method="POST">
													<div class="modal-dialog modal-md">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Delete Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div><input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
																	<div class="form-group col-12" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-12">
																				<label class="col-form-label">Category Name</label>
																				<input class="form-control" type="text" name="category_name" value="<?php echo $category['category_name']; ?>" readonly>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="delete" value="Delete" onClick="return confirm('Delete This Record?')">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Delete category record modal/form -->

										<?php endforeach; ?> <!-- category data endforeach -->
									<?php endif; ?> <!-- category data endif -->

									<?php
										$alertMessage = ""; 

										if (!empty($_SESSION['alertMessage'])) {
											$alertMessage = $_SESSION['alertMessage'];
											unset($_SESSION['alertMessage']);
										}


										/* Insert new category data controller */
										if (isset($_POST['insert'])) {
											$category_name = $_POST['category_name'];
			
											$model->insertCategory($category_name);
			
											$_SESSION['alertMessage'] = "Category has been added!";
											header("Location: category.php");
											exit();
											
										}

										/* Update category record controller */
										if (isset($_POST['update'])) {
											$category_id = $_POST['category_id'];
											$category_name = $_POST['category_name'];

											$old_values = $model->getCategoryDetailByID($category_id);

											$model->updateCategory($category_name, $category_id);
											$logCategory = $model->logCategoryUpdateTransaction($old_values, $_POST);

											$_SESSION['alertMessage'] = "Category record has been updated!";
											header("Location: category.php");
											exit();

										}

										/* Delete category record controller */
										if (isset($_POST['delete'])) {
											$category_id = $_POST['category_id'];

											$model->deleteCategory($category_id);

											$_SESSION['alertMessage'] = "Category record has been deleted!";
											header("Location: category.php");
											exit();
										}

										?> 
										
										<?php if (!empty($alertMessage)) { ?>
											<div class="alert alert-success alert-dismissible fade show" role="alert">
												<?php echo htmlspecialchars($alertMessage); ?>
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
										<?php } 
											ob_end_flush(); 
										?>
								</tbody>
							</table>
						</div><br> <!-- table-responsive end div -->

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