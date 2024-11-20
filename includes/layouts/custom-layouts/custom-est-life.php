	<!-- START OF UNIT OF ESTIMATED USEFUL LIFE MODULE -->
	<div style="border-top: 2px solid #5ADA86;"></div>

<div class="row">
	<div class="col-lg-12 m-b30">
		<div class="widget-box">

			<button type="button" class="btn green radius-xl mt-2 me-3 mb-3" style="float: right; background-color: #5ADA86;" data-toggle="modal" data-target="#insert-estlife">
				<i class="fa fa-plus"></i><span>&nbsp;&nbsp;ADD ESTIMATE</span>
			</button>

			<div class="widget-inner">

				<!-- Insert estimated useful life record modal/form -->
				<div id="insert-estlife" class="modal fade" role="dialog">
					<form class="edit-profile m-b30" method="POST" enctype="multipart/form-data">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">Add Record</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="form-group col-12" style="padding-bottom: 15px;">
											<div class="row">
												<div class="form-group col-12">
													<label class="col-form-label">Estimated Life</label>
													<input class="form-control" type="text" name="estlife_name" value="" maxlenght="30" placeholder="Enter estimated useful life name" required>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<input type="submit" class="btn green radius-xl outline" name="insert-estlife" value="Save Changes">
									<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</form>
				</div> <!-- Insert estimated useful life record modal/form -->
				
			
				<div class="table-responsive">
					<table id="table-second" class="table hover" style="width:100%">
						<thead>
							<tr>
								<th class="col-1">#</th>
								<th>Estimated Useful Life</th>
								<th width="5%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($estlifes = $model->displayEstLife())): ?>
								<?php foreach ($estlifes as $key => $estlife): ?>
									<?php $eslLife_id = $estlife['id']; ?>

									<tr>
										<td><?php echo $key + 1 ?></td>
										<td><?php echo $estlife['est_life']; ?></td>
										<td>
											<center>
												<button data-toggle="modal" data-target="#delete-estlife-<?php echo $eslLife_id; ?>" class="btn red" style="width: 50px; height: 37px;">
													<span data-toggle="tooltip" title="Delete">
														<i class="ti-archive" style="font-size: 12px;"></i>
													</span>
												</button>
											</center>
										</td>
									</tr>

									<!-- Delete estimated useful life -->
									<div id="delete-estlife-<?php echo $eslLife_id; ?>" class="modal fade" role="dialog">
										<form class="delete-form m-b30" method="POST">
											<div class="modal-dialog modal-md">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Delete Record</h4>
														<button type="button" class="close" data-dismiss="modal">&times;</button>
													</div><input type="hidden" name="estlife_id" value="<?php echo $eslLife_id; ?>">
													<div class="modal-body">
														<div class="row">
															<input type="hidden" name="estlife_id" value="<?php echo $eslLife_id ?>">
															<div class="form-group col-12" style="padding-bottom: 15px;">
																<div class="row">
																	<div class="form-group col-12">
																		<label class="col-form-label">Estimated Useful Life</label>
																		<input class="form-control" type="text" name="estlife_name" value="<?php echo $estlife['est_life']; ?>" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input type="submit" class="btn green radius-xl outline" name="delete-estlife" value="Delete">
														<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</form>
									</div> <!-- delete-modal -->

								<?php endforeach; ?>
							<?php endif; ?> <!-- estimated useful life endif -->
							
						</tbody>
					</table>
				</div> <!-- Table Responsive (end) -->

				<?php 

					/* Insert estimated useful life record controller */
					if (isset($_POST['insert-estlife'])) {
						$estlife_name = $_POST['estlife_name'];

						$model->insertEstLife($estlife_name);

						$_SESSION['successMessage'] = "New estimated useful life added succesfully!";
						header("Location: customize.php");
						exit();
					}

					/* Delete estimated useful life record controller */
					if (isset($_POST['delete-estlife'])) {
						$estlife_id = $_POST['estlife_id'];
						$model->deleteEstLife($estlife_id);	

						$_SESSION['successMessage'] = "Estimated useful life record deleted succesfully!";
						header("Location: customize.php");
						exit();
					}

				?>
				
			</div> <!-- widget-inner -->
		</div> <!-- widget-box -->
	</div> <!-- col-lg-12 -->
</div> <!-- row -->