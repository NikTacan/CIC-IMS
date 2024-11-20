
<!-- START OF UNIT OF ESTIMATED USEFUL LIFE MODULE -->
<div style="border-top: 2px solid #5ADA86;"></div>

<div class="row">
	<div class="col-lg-12 m-b30">
		<div class="widget-box">

			<!-- Add designation button -->
			<button type="button" class="btn green radius-xl mt-2 me-3 mb-3" style="float: right; background-color: #5ADA86;" data-toggle="modal" data-target="#create-designation">
			<i class="fa fa-plus"></i><span>&nbsp;&nbsp;ADD DESIGNATION</span>
			</button>
		
			<div class="widget-inner">

				<!-- Create designation modal/form -->
				<div id="create-designation" class="modal fade" role="dialog">
					<form class="create-designation m-b30" method="POST" enctype="multipart/form-data">
						<div class="modal-dialog modal-md">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">Add Designation</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="form-group col-12" style="padding-bottom: 15px;">
											<div class="row">
												<div class="form-group col-12">
													<label class="col-form-label">Designation</label>
													<input class="form-control" type="text" name="designation_name" value="" placeholder="Enter designation name" maxlenght="20" required>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<input type="submit" class="btn green radius-xl outline" name="create-designation" value="Create">
									<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</form>
				</div> <!-- Create designation modal/form -->
			
				<!-- Dedisnation record table -->
				<div class="table-responsive">
					<table id="table-second" class="table hover" style="width:100%">
						<thead>
							<tr>
								<th class="col-1">#</th>
								<th>Designation</th>
								<th width="5%">Action</th>
							</tr>
						</thead>
						<tbody>

							<?php if (!empty($designations = $model->getDesignation())): ?>
								<?php foreach ($designations as $key => $designation): ?>
									<?php $designation_id = $designation['id']; ?>

									<tr>
										<td><?php echo $key + 1 ?></td>
										<td><?php echo $designation['designation_name']; ?></td>
										<td>
											<center>
												<button data-toggle="modal" data-target="#delete-designation-<?php echo $designation_id; ?>" class="btn red" style="width: 50px; height: 37px;">
													<span data-toggle="tooltip" title="Delete">
														<i class="ti-archive" style="font-size: 12px;"></i>
													</span>
												</button>
											</center>
										</td>
									</tr>

									<!-- Delete designation form/modal -->
									<div id="delete-designation-<?php echo $designation_id; ?>" class="modal fade" role="dialog">
										<form class="delete-form m-b30" method="POST">
											<div class="modal-dialog modal-md">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Delete Record</h4>
														<button type="button" class="close" data-dismiss="modal">&times;</button>
													</div><input type="hidden" name="designation_id" value="<?php echo $designation_id; ?>">
													<div class="modal-body">
														<div class="row">
															<input type="hidden" name="designation_id" value="<?php echo $designation_id ?>">
															<div class="form-group col-12" style="padding-bottom: 15px;">
																<div class="row">
																	<div class="form-group col-12">
																		<label class="col-form-label">Designation</label>
																		<input class="form-control" type="text" name="designation_name" value="<?php echo $designation['designation_name']; ?>" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input type="submit" class="btn green radius-xl outline" name="delete-designation" value="Delete">
														<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</form>
									</div> <!-- Delete designation form/modal -->
									
								<?php endforeach; ?>
							<?php endif; ?> <!-- designation table data endif -->

							</tbody>
					</table>

					<?php 
						/* Create designation controller */
						if (isset($_POST['create-designation'])) {
							$designationName = $_POST['designation_name'];

							$model->insertDesignation($designationName);
							$_SESSION['successMessage'] = "New designation added succesfully!";
							header("Location: customize.php");
							exit();
							
						}

						/* Delete designation record controller */
						if (isset($_POST['delete-designation'])) {
							$designation_id = $_POST['designation_id'];
							$model->deleteDesignation($designation_id);	

							$_SESSION['successMessage'] = "Designation record deleted succesfully!";
							header("Location: customize.php");
							exit();
						}

					?>

				</div> <!-- Table Responsive (end) -->
			</div> <!-- widget-inner -->
		</div> <!-- widget-box -->
	</div> <!-- col -->
</div> <!-- row -->
