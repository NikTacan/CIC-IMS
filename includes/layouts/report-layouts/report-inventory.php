<!-- Inventory form -->
<div id="inventory_form" style="display: none;">
	<form method="POST" >

		<div class="row justify-content-center align-items-center">
			
			<!-- Select end user -->
			<div class="form-group col-md-12 col-lg-2">
				<label class="col-form-label">Inventory remarks</label>
				<select class="form-control form-control-sm" name="remark-inventory" required>
					<option value="" selected disabled hidden>-- Select remark --</option>
					<option value="all_remarks">All Remarks</option>
					
					<?php if(!empty($notes = $model->displayModuleNotes('inventory'))):  ?>
						<?php foreach ($notes as $note):  ?>

						<option style="font-size: 14px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']?>;" value="<?php echo $note['note_name']; ?>"><?php echo $note['note_name']; ?></option>

						<?php endforeach; ?>
					<?php endif; ?>
				
				</select>
			</div> <!-- Select end user -->
				
			<!-- All Dates checkbox -->
			<div class="form-group col-md-1 col-lg-1 d-flex flex-column align-items-center">
				<label class="text-center">All Dates</label>
				<input class="btn btn-sm btn-primary all-inventory-checkbox text-center mt-2" type="checkbox" id="all-dates-btn">
			</div>

			<!-- Pick Dates checkbox -->
			<div class="form-group col-md-1 col-lg-1 d-flex flex-column align-items-center">
				<label class="text-center">Pick Dates</label>
				<input class="btn btn-sm btn-primary pick-inventory-checkbox text-center mt-2" type="checkbox" id="pick-dates-btn">
			</div>

		</div> <!-- row -->

		<!-- Pick Dates section -->
		<div class="row justify-content-center align-items-center" id="pick-dates-inventory" style="display: none;">
		
			<!-- From Date -->
			<div class="form-group col-md-6 col-lg-2">
				<label>From Date</label>
				<input class="form-control form-control-sm" type="date" id="from_date" name="from_date" value="<?php echo isset($_POST['from_date']) ? $_POST['from_date'] : ''; ?>" />
			</div>
			
			<!-- To Date -->
			<div class="form-group col-md-6 col-lg-2">
				<label>To Date</label>
				<input class="form-control form-control-sm" type="date"  id="to_date" name="to_date" value="<?php echo isset($_POST['to_date']) ? $_POST['to_date'] : ''; ?>"/>
			</div>
			
			<!-- Submit Button -->
			<div class="form-group col-md-6 col-lg-1" style="margin-top: 35px;">
				<button class="btn green btn-xs radius-lg" type="submit" name="report-inventory-specific-dates" id="report-inventory-specific-dates" onclick="this.form.submit()">
					<span class="text">submit</span><span class="icon text-white-50"></span>
				</button>
			</div>
		</div> <!-- Pick Dates section -->

		<!-- All Dates section -->
		<div class="row justify-content-center align-items-center" id="all-dates-inventory" style="display: none;">
			<!-- Submit Button -->
			<div class="form-group col-md-6 col-lg-1" style="margin-top: 20px;">
				<button class="btn green btn-xs radius-lg" type="submit" name="report-inventory-all-dates" id="report-inventory-all-dates" onclick="this.form.submit()">
					<span class="text">submit</span><span class="icon text-white-50"></span>
				</button>
			</div>
		</div> <!-- All Dates section -->

	</form> 
</div> <!-- Inventory report form -->

<!-- Specific dates && All/Specific remark -->
<?php
if (isset($_POST['report-inventory-specific-dates'])):
	$fromDate = $_POST['from_date'];
	$toDate = $_POST['to_date'];
	$remarks = $_POST['remark-inventory'];

	$noteDetail = $model->getNoteDetail('inventory', $remarks);
?>
	
	<!-- All remarks && Specific dates -->
	<?php if($remarks == 'all_remarks'): ?>

		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">All Inventory Remarks<br>
				<span class="fw-light" style="font-size: 16px;">
					( In between <?php echo date('M. d, Y', strtotime($fromDate)); ?> to <?php echo date('M. d, Y', strtotime($toDate)); ?> )
				</span>
			</h3> <!-- Header title -->
		</div>

		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-inventory-allRemark-specificDate" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-inventory-allRemark-specificDate">
					<input type="date" name="from_date" value="<?php echo $fromDate; ?>" hidden/>
					<input type="date" name="to_date" value="<?php echo $toDate; ?>" hidden/>
					<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
					<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
				</button>
			</form>
		</div> <br> <br>
		<!-- Download report button -->

		<!-- Table -->
		<div class="row table-responsive m-0 p-0">
			<table class="table table-striped table-hover" id="table" style="width:100%">
				<thead>
					<tr>
						
						<th class="col-1">Property No.</th>
						<th class="col-3">Description</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Unit Value</th>
						<th class="col-1">Estimated <br> Useful Life</th>
						<th class="col-1">Acquisition Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($inventories = $model->getInvAllRemarkSpecificDateReport($fromDate, $toDate))): ?>
						<?php foreach ($inventories as $inventory): ?>
						<tr>
							
							<td><?php echo $inventory['property_no'] ?></td>
							<td><?php echo $inventory['description'] ?></td>
							<td> <?php echo $inventory['qty_pcard'] ?></td>
							<td> <?php echo $inventory['qty_pcount'] ?></td>
							<td> <?php echo $inventory['unit_name'] ?></td>
							<td> <?php echo $inventory['unit_cost'] ?></td>
							<td> <?php echo $inventory['estlife_name'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($inventory['acquisition_date'])); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table> <br>
		</div> 	<!-- All remakrs -->

	<!-- Specific remark -->
	<?php else: ?>

		<?php 
			$remarkId = $noteDetail['id'];
		?>
		
		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">Inventory Report <br>
				<?php if(!empty($notes = $model->displayInvNotes('inventory', $remarks))): ?>
					<?php foreach ($notes as $note): ?>
						<span style="font-size: 13px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
					<?php endforeach; ?>
				<?php endif; ?><br> 
				<span class="fw-light" style="font-size: 16px;">
					( In between <?php echo date('M. d, Y', strtotime($fromDate)); ?> to <?php echo date('M. d, Y', strtotime($toDate)); ?> )
				</span>
			</h3> <!-- Header title -->
		</div>

		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-inventory-specificRemark-specificDate" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-inventory-specificRemark-specificDate">
					<input type="text" name="remark" value="<?php echo $remarks ?>" hidden/>
					<input type="date" name="from_date" value="<?php echo $fromDate; ?>" hidden/>
					<input type="date" name="to_date" value="<?php echo $toDate; ?>" hidden/>
					<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
					<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
				</button>
			</form>
		</div>
		<!-- Download report button -->

		<!-- Table -->
		<div class="row table-responsive m-0 p-0">
			<table class="table table-striped table-hover" id="table" style="width:100%">
				<thead>
					<tr>
						
						<th class="col-1">Property No.</th>
						<th class="col-3">Description</th>
						<th class="col-1">Remark</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Unit Value</th>
						<th class="col-1">Estimated <br> Useful Life</th>
						<th class="col-2">Acquisition Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($inventories = $model->getInvSpecificRemarkSpecificDateReport($remarkId, $fromDate ,$toDate))): ?>
						<?php foreach ($inventories as $inventory): ?>
						<tr>
							
							<td> <?php echo $inventory['property_no'] ?></td>
							<td> <?php echo $inventory['description'] ?></td>
							<td>
								<?php if(!empty($rows = $model->displayInvNotes('inventory', $inventory['note_name']))): ?>
									<?php foreach ($rows as $note): ?>
										<span style="font-size: 12px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $inventory['qty_pcard'] ?></td>
							<td> <?php echo $inventory['qty_pcount'] ?></td>
							<td> <?php echo $inventory['unit_name'] ?></td>
							<td> <?php echo $inventory['unit_cost'] ?></td>
							<td> <?php echo $inventory['estlife_name'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($inventory['acquisition_date'])); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table> <br> <!-- Table -->
		</div>
		
	<?php endif; ?> <!-- Specific remark -->
<?php endif; ?> <!-- Specific dates && All/Specific remark -->

	
	<!-- All dates && All/Specific remark -->
	<?php
	if (isset($_POST['report-inventory-all-dates'])):
		$date_now = date("Y-m-d H:i:s");
		$remarks = $_POST['remark-inventory'];
		
		$noteDetail = $model->getNoteDetail('inventory', $remarks);

	?>
		
		<!-- All remarks && All dates -->
		<?php if($remarks == 'all_remarks'): ?>

			<!-- Header title -->
			<div class="row header">
				<h3 class="text-center m-0">All Inventory Records<br>
					<span class="fw-light" style="font-size: 16px;">
						As of <?php echo date('F d, Y', strtotime($date_now)); ?>
					</span>
				</h3> <!-- Header title -->
			</div>

			<!-- Download report button -->
			<div class="row mb-2 me-1" style="float: right;">
				<form action="report/report-inventory-allRemark-allDate" method="post">
					<button class="btn blue green btn-xs radius-xl" name="report-inventory-allRemark-allDate">
						<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
						<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
					</button>
				</form>
			</div> <br> <br>
			<!-- Download report button -->

			<!-- Table -->
			<div class="row table-responsive m-0 p-0">
				<table class="table table-striped table-hover" id="table" style="width:100%">
					<thead>
						<tr>
							
							<th class="col-1">Property No.</th>
							<th class="col-3">Description</th>
							<th class="col-1">Remark</th>
							<th class="col-1">Qty per<br>Property Card</th>
							<th class="col-1">Qty per<br>Physical Count</th>
							<th class="col-1">Unit</th>
							<th class="col-1">Unit Value</th>
							<th class="col-1">Estimated <br> Useful Life</th>
							<th class="col-1">Acquisition Date</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($inventories = $model->displayInventoryWithDetails())): ?>
							<?php foreach ($inventories as $inventory): ?>
							<tr>
								
								<td> <?php echo $inventory['property_no'] ?></td>
								<td> <?php echo $inventory['description'] ?></td>
								<td>
									<?php if(!empty($rows = $model->displayInvNotes('inventory', $inventory['note_name']))): ?>
										<?php foreach ($rows as $note): ?>
											<span style="font-size: 12px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
										<?php endforeach; ?>
									<?php endif; ?>
								</td>
								<td> <?php echo $inventory['qty_pcard'] ?></td>
								<td> <?php echo $inventory['qty_pcount'] ?></td>
								<td> <?php echo $inventory['unit_name'] ?></td>
								<td> <?php echo $inventory['unit_cost'] ?></td>
								<td> <?php echo $inventory['estlife_name'] ?></td>
								<td> <?php echo date('M. d, Y', strtotime($inventory['acquisition_date'])); ?></td>
							</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table> <br>
			</div>
		<!-- All remakrs -->
		
		<!-- Specific remark -->
		<?php else: ?>
		
			<?php
				$remarkId = $noteDetail['id'];
			?>

			<div class="row header"> 
				<!-- Header title -->
				<h3 class="text-center m-0">Inventory Report <br>
					<?php if(!empty($notes = $model->displayInvNotes('inventory', $remarks))): ?>
						<?php foreach ($notes as $note): ?>
							<span style="font-size: 13px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
						<?php endforeach; ?>
					<?php endif; ?><br> 
					<span class="fw-light" style="font-size: 16px;">
						( As of <?php echo date('F d, Y', strtotime($date_now)); ?> )
					</span>
				</h3> <!-- Header title -->
			</div>

			<!-- Download report button -->
			<div class="row mb-3 me-1" style="float: right;">
				<form action="report/report-inventory-specificRemark-allDate" method="post">
					<button class="btn blue green btn-xs radius-xl" name="report-inventory-specificRemark-allDate">
						<input type="text" name="remark" value="<?php echo $remarks ?>" hidden/>
						<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
						<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
					</button>
				</form>
			</div>
			<!-- Download report button -->

			<div class="row table-responsive m-0 p-0">
				<!-- Table -->
				<table class="table table-striped table-hover" id="table" style="width:100%">
					<thead>
						<tr>
							
							<th class="col-1">Property No.</th>
							<th class="col-3">Description</th>
							<th class="col-1">Remark</th>
							<th class="col-1">Qty per<br>Property Card</th>
							<th class="col-1">Qty per<br>Physical Count</th>
							<th class="col-1">Unit</th>
							<th class="col-1">Unit Value</th>
							<th class="col-1">Estimated <br> Useful Life</th>
							<th class="col-2">Acquisition Date</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($inventories = $model->getInvSpecificRemarkAllDateReport($remarkId))): ?>
							<?php foreach ($inventories as $inventory): ?>
							<tr>
								
								<td> <?php echo $inventory['property_no'] ?></td>
								<td> <?php echo $inventory['description'] ?></td>
								<td>
									<?php if(!empty($rows = $model->displayInvNotes('inventory', $inventory['note_name']))): ?>
										<?php foreach ($rows as $note): ?>
											<span style="font-size: 12px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
										<?php endforeach; ?>
									<?php endif; ?>
								</td>
								<td> <?php echo $inventory['qty_pcard'] ?></td>
								<td> <?php echo $inventory['qty_pcount'] ?></td>
								<td> <?php echo $inventory['unit_name'] ?></td>
								<td> <?php echo $inventory['unit_cost'] ?></td>
								<td> <?php echo $inventory['estlife_name'] ?></td>
								<td> <?php echo date('M. d, Y', strtotime($inventory['acquisition_date'])); ?></td>
							</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table> <br> <!-- Table -->
			</div>

		<?php endif; ?> <!-- Specific remark -->
	<?php endif; ?> <!-- All dates && All/Specific remark -->




