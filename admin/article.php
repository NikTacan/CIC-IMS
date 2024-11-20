<?php include('../includes/session.php'); ?>
<?php include('../includes/alert.php'); ?>

<?php 
	$articles = $model->displayArticleWithCount();
?>

<?php include('../includes/layouts/main-layouts/html-head.php') ?>

	<title>Article | <?php echo $customize['sys_name']; ?></title>

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
				<li class="show" style="margin-top: 0px;">
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
                    <h2 class="p-0 mb-0">Article</h2>

                    <!-- Button aligned to the right -->
                    <button type="button" class="btn green radius-xl" style="background-color: #5ADA86;" data-toggle="modal" data-target="#insert-article">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-lg-inline">&nbsp;&nbsp;ADD ARTICLE</span>
                    </button>
                </div>
            </div>
        </div> <!-- Header and Button Row -->

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="widget-inner">

						<!-- Alert notification -->
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
						<?php endif; ?> <!-- Alert notification -->

						<!-- Insert/Create new article form or record -->
						<div id="insert-article" class="modal fade" role="dialog">
							<form class="insert-article m-b30" method="POST" enctype="multipart/form-data">
								<div class="modal-dialog modal-md">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">&nbsp;Add Article Record</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="form-group col-12" style="padding-bottom: 15px;">
													<div class="row">
														<div class="form-group col-12">
															<label class="col-form-label">Article Name</label>
															<input class="form-control" type="text" name="article_name" value="" placeholder="Enter article name" maxlength="30" required>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<input type="submit" class="btn green radius-xl outline" name="insert-article" value="Save">
											<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</form>
						</div> <!-- Insert/Create new article form or record -->
						
						<div class="table-responsive">
							<table id="table" class="table hover" style="width:100%">
								<thead>
									<tr>
										<th class="col-1">#</th>
										<th>Article Name</th>
										<th class="col-2">Inventory Count</th>
										<th class="col-sm-1 col-md-2 text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($articles)): ?>
										<?php foreach ($articles as $key => $article): ?>
											<?php $article_id = $article['id']; ?>
											<tr>
												<td><?php echo $key + 1 ?></td>
												<td><?php echo $article['article_name']; ?></td>
												<td><?php echo $article['inventory_count']; ?></td>

												<td>
													<center>
														<button class="btn green mb-1" id="<?php echo $article_id;?>" onclick="window.location.href='article-view.php?id=<?php echo $article_id;?>'" type="submit" name="view"  style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="View">
																<i class="ti-search" style="font-size: 12px;"></i>
															</span>
														</button>
														<button class="btn blue mb-1" data-toggle="modal" data-target="#update-<?php echo $article_id; ?>"  style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="Update">
																<i class="ti-marker-alt" style="font-size: 12px;"></i>
															</span>
														</button>
														<button class="btn red mb-1" data-toggle="modal" data-target="#delete-<?php echo $article_id; ?>" style="width: 50px; height: 37px;">
															<span data-toggle="tooltip" title="Delete">
																<i class="ti-archive" style="font-size: 12px;"></i>
															</span>
														</button>
													</center>
												</td>
											</tr>

											<!-- Update article record form/modal -->
											<div id="update-<?php echo $article_id; ?>" class="modal fade" role="dialog">
												<form class="edit-profile m-b30" method="POST" enctype="multipart/form-data">
													<div class="modal-dialog modal-md">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Update Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="article_id" value="<?php echo $article_id ?>">
																	<div class="form-group col-12" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-12">
																				<label class="col-form-label">Article Name</label>
																				<input class="form-control" type="text" name="article_name" value="<?php echo $article['article_name']; ?>" maxlength="30" required>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="update-article" value="Save Changes">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Update article record form/modal -->

											<!-- Delete article record form/modal -->
											<div id="delete-<?php echo $article_id; ?>" class="modal fade" role="dialog">
												<form class="edit-profile m-b30" method="POST">
													<div class="modal-dialog modal-md">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Delete Record</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div><input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
															<div class="modal-body">
																<div class="row">
																	<input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
																	<div class="form-group col-12" style="padding-bottom: 15px;">
																		<div class="row">
																			<div class="form-group col-12">
																				<label class="col-form-label">Article Name</label>
																				<input class="form-control" type="text" name="article_name" value="<?php echo $article['article_name']; ?>" readonly>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<input type="submit" class="btn green radius-xl outline" name="delete-article" value="Delete" onClick="return confirm('Delete This Record?')">
																<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
															</div>
														</div>
													</div>
												</form>
											</div> <!-- Delete article record form/modal -->
											
										<?php endforeach; ?>
									<?php endif; ?> <!-- article table body endif -->

									<?php 
										
										/* Create article record controller */
										if (isset($_POST['insert-article'])) {
											$article_name = $_POST['article_name'];

											$model->insertArticle($article_name);

											$_SESSION['successMessage'] = "New article record added succesfully!";
											header("Location: article.php");
											exit();
										}

										/* Update article record controller */
										if (isset($_POST['update-article'])) {
											$article_id = $_POST['article_id'];
											$article_name = $_POST['article_name'];

											$old_values = $model->getArticleDetailByID($article_id);

											$model->updateArticle($article_name, $article_id);
											$logArticle = $model->logArticleUpdateTransaction($old_values, $_POST);

											$_SESSION['successMessage'] = "Article record updated succesfully!";
											header("Location: article.php");
											exit();
										}

										/* Delete article record controller */
										if (isset($_POST['delete-article'])) {
											$article_id = $_POST['article_id'];
											$article_name = $_POST['article_name'];

											$model->deleteArticle($article_id, $article_name);

											$_SESSION['successMessage'] = "Article record deleted succesfully!";
											header("Location: article.php");
											exit();
										}

									?>

								</tbody>
							</table>
						</div><br> <!-- table responsive end div -->

					</div> <!-- widget inner -->
				</div> <!-- widget box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<?php include('../includes/js/data-tables.php'); ?>

</body>
</html>