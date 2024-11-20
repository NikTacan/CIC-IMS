
<!-- START OF UNIT OF MEASUREMENT MODULE -->

<div class="row">
	<div class="col-lg-12 m-b30">
		<div style="border-top: 2px solid #5ADA86;"></div>
			<div class="widget-box">
				
				<button type="button" class="btn green radius-xl mt-2 me-3 mb-3" style="float: right; background-color: #5ADA86;" data-toggle="modal" data-target="#insert-account">
				<i class="fa fa-plus"></i>
				<span>&nbsp;&nbsp;ADD UNIT</span>
				</button>

				<div class="widget-inner">

					<!-- Insert unit measurement record modal/form -->
					<div id="insert-account" class="modal fade" role="dialog">
						<form class="edit-profile m-b30" method="POST" enctype="multipart/form-data">
							<div class="modal-dialog modal-md">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Add Unit Record</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="form-group col-12">
												<div class="row">
													<div class="form-group col-12">
														<label class="col-form-label">Unit Name</label>
														<input class="form-control" type="text" name="unit_name" value="" maxlenght="20" placeholder="Enter unit of measurement name" required>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<input type="submit" class="btn green radius-xl outline" name="insert" value="Save Changes">
										<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</form> 
					</div> <!-- Insert unit measurement record modal/form -->
			
				<div class="table-responsive"  style="margin-bottom: 0px; padding-bottom: 0px;">

					<table class="table hover" style="width:100%">
						<thead>
							<tr>
								<th class="col-1 col-md-1">#</th>
								<th>Unit of Measurement	</th>
								<th class="col-1 text-center">Action</th>
							</tr>
						</thead>
						<tbody>

							<?php if (!empty($units = $model->displayUnits())): ?>
								<?php foreach ($units as $key => $unit): ?>
									<?php $unit_id = $unit['id']; ?>
										
									<tr>
										<td><?php echo $key + 1 ?></td>
										<td><?php echo $unit['unit_name']; ?></td>
										<td>
											<center>
												<button data-toggle="modal" data-target="#delete-<?php echo $unit_id; ?>" class="btn red" style="width: 50px; height: 37px;" >
													<span data-toggle="tooltip" title="Delete">
														<i class="ti-archive" style="font-size: 12px;"></i>
													</span>
												</button>
											</center>
										</td>
									</tr>

									<!-- Delete unit -->
									<div id="delete-<?php echo $unit_id; ?>" class="modal fade" role="dialog">
										<form  class="edit-profile m-b30" method="POST">
											<div class="modal-dialog modal-md">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Delete Record</h4>
														<button type="button" class="close" data-dismiss="modal">&times;</button>
													</div><input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>">
													<div class="modal-body">
														<div class="row">
															<input type="hidden" name="unit_id" value="<?php echo $unit['id']; ?>">
															<div class="form-group col-12" >
																<div class="row">
																	<div class="form-group col-12">
																		<label class="col-form-label">Unit Name</label>
																		<input class="form-control" type="text" name="unit_name" value="<?php echo $unit['unit_name']; ?>" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input type="submit" class="btn green radius-xl outline" name="delete" value="Delete" onClick="return confirm('Delete This Unit?')">
														<button type="button" class="btn red outline radius-xl" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</form>
									</div> <!-- Delete unit -->

								<?php endforeach; ?>
							<?php endif; ?> <!-- unit of measurement table data endif -->
		
						</tbody>
					</table>
				</div> <!-- table-responsive end div -->


				<?php

					/* Insert unit of measurement record controller */
					if (isset($_POST['insert'])) {
						$unit_name = $_POST['unit_name'];

						$model->insertUnit($unit_name);

						$_SESSION['successMessage'] = "New unit of measurement added succesfully!";
                        header("Location: customize.php");
                        exit();
					}
					
					/* Delete unit of measurement record controller */ 
					if (isset($_POST['delete'])) {
						$unit_id = $_POST['unit_id'];
						$model->deleteUnit($unit_id);	
						
						$_SESSION['successMessage'] = "Unit of measurement deleted succesfully!";
                        header("Location: customize.php");
                        exit();
					}

				?>

			</div> <!-- widget-box -->
		</div> <!-- border-top -->
	</div> <!-- col-lg-12 -->
</div> <!-- row -->
