<!-- header & styles -->
<?php include('../includes/layouts/main-layouts/head-section.php') ?>

<?php 

	if (isset($_GET['id'])) {
		$article_id = $_GET['id'];
		
		$articleDetail = $model->getArticleDetailByID($article_id);
		$articleName = $articleDetail['article_name'];

		$articleProperties = $model->getArticleInventories($article_id);
	}

?>

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

		<div class="ttr-main-header">
			<div class="float-left">
				<h2 class="title-head float-left">Article<span> </span></h2>
			</div><br><br><br>
		</div>

		<div class="row">
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div id="preloader"></div>
					<div class="widget-inner">
						<div class="row" width="100%">
							
							<h2 class="text-center"><?php echo $articleName ?></h2>

							<div class="mt-3"></div>								
							<table id="table" class="table table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											
											<th class="col-4">Description</th>
											<th>Article</th>
											<th>Property No.</th>
											<th class="col-1">Action</th>
										</tr>
									</thead>
									<tbody>

										<?php if(!empty($articleProperties)): ?>
											<?php foreach ($articleProperties as $articleProperty): ?>
												<?php $inv_no = $articleProperty['inv_id']; ?>
												
												<tr>
												
													<td>
														<?php
															// Split the description into an array of words
															$words = explode(' ', $articleProperty['description']);

															// Display the first 5 words
															echo implode(' ', array_slice($words, 0, 7));
														?>
													</td>
													<td><?php echo $articleProperty['article_name']; ?></td>
													<td><?php echo $articleProperty['property_no']; ?></td>
													<td>
														<center>
															<button id="<?php echo $inv_no;?>" onclick="window.location.href='inventory-view.php?id=<?php echo $inv_no ?>'" type="submit" name="view" class="btn green" style="width: 50px; height: 37px;">
																<span data-toggle="tooltip">
																	<i class="ti-search" style="font-size: 12px;"></i>
																</span>
															</button>
													</center>
													</td>
												</tr>

											<?php endforeach; ?>
										<?php endif; ?> <!-- article table data endif -->

									</tbody>	
							</table> 
							
						</div> <!-- row -->
					</div> <!-- widget-inner -->
				</div> <!-- widget-box -->
			</div> <!-- col-lg-12 -->
		</div> <!-- row -->
	</div> <!-- container-fluid -->
</main>

<!-- header & styles -->
<?php include('../includes/layouts/main-layouts/footer.php') ?>