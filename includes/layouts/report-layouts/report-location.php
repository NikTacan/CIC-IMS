	<!-- Location form -->
	<div id="location_form" style="display: none;">
		<form method="POST" >
			<div class="row justify-content-center align-items-center">
				<div class="form-group col-md-12 col-lg-2">
					<label class="col-form-label">Locations</label>
					<select class="form-control form-control-sm" name="location" required>
						<option value="" selected disabled hidden>-- Select location --</option>
						<option value="all_location">All Locations</option>
						<?php if(!empty($locations = $model->getLocations())):  ?>
							<?php foreach ($locations as $location):  ?>
									
							<option value="<?php echo $location['id']; ?>"><?php echo $location['location_name']; ?></option>

							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>		
					
			<!-- All Dates checkbox -->
			<div class="form-group col-md-1 col-lg-1 d-flex flex-column align-items-center">
				<label class="text-center">All Dates</label>
				<input class="btn btn-sm btn-primary all-location-checkbox text-center mt-2" type="checkbox" id="all-dates-btn">
			</div>

			<!-- Pick Dates checkbox -->
			<div class="form-group col-md-1 col-lg-1 d-flex flex-column align-items-center">
				<label class="text-center">Pick Dates</label>
				<input class="btn btn-sm btn-primary pick-location-checkbox text-center mt-2" type="checkbox" id="pick-dates-btn">
			</div>

		</div> <!-- row -->

		<!-- Pick Dates section -->
		<div class="row justify-content-center align-items-center" id="pick-dates-location" style="display: none;">
		
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
				<button class="btn green btn-xs radius-lg" type="submit" name="report-location-specific-dates" id="report-location-specific-dates" onclick="this.form.submit()">
					<span class="text">submit</span><span class="icon text-white-50"></span>
				</button>
			</div>
		</div> <!-- Pick Dates section -->

		<!-- All Dates section -->
		<div class="row justify-content-center align-items-center" id="all-dates-location" style="display: none;">
			<!-- Submit Button -->
			<div class="form-group col-md-6 col-lg-1" style="margin-top: 20px;">
				<button class="btn green btn-xs radius-lg" type="submit" name="report-location-all-dates" id="report-location-all-dates" onclick="this.form.submit()">
					<span class="text">submit</span><span class="icon text-white-50"></span>
				</button>
			</div>
		</div> <!-- All Dates section -->

	</form> 
</div> <!-- location report form -->

<!-- Specific dates && All/Specific remark -->
<?php
if (isset($_POST['report-location-specific-dates'])):
	$fromDate = $_POST['from_date'];
	$toDate = $_POST['to_date'];
	$location = $_POST['location'];
?>
	
	<!-- All location && Specific dates -->
	<?php if($location == 'all_location'): ?>

		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">All Locations<br>
				<span class="fw-light" style="font-size: 16px;">
					In between <?php echo date('F d, Y', strtotime($fromDate)); ?> to <?php echo date('F d, Y', strtotime($toDate)); ?>
				</span>
			</h3> <!-- Header title -->
		</div>

		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-location-allLocation-specificDate" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-location-allLocation-specificDate">
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
						<th class="col-2">Location</th>
						<th class="col-4">Description</th>
						<th class="col-1">Property No</th>
						<th class="col-1">Remark</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Unit Value</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Acquisiton Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($locations = $model->getInventoryAllLocationSpecificDateReport($fromDate, $toDate))): ?>
						<?php foreach ($locations as $location): ?>
						<tr>
							<td> <?php if(empty($location['location'])): ?> <span class="text-decoration-underline fw-light"> Unassigned</span> <?php else: echo $location['location_name']; ?> <?php endif; ?></td>
							<td> <?php echo $location['description'] ?></td>
							<td> <?php echo $location['property_no'] ?></td>
							<td>
								<?php if(!empty($rows = $model->displayInvNotes('inventory', $location['remark_name']))): ?>
									<?php foreach ($rows as $note): ?>
										<span style="font-size: 11px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $location['unit_name'] ?></td>
							<td> <?php echo $location['unit_cost'] ?></td>
							<td> <?php echo $location['qty_pcard'] ?></td>
							<td> <?php echo $location['qty_pcount'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($location['acquisition_date'])) ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table> <br>
		</div>  <!-- All location -->
	
	<!-- Specific location -->
	<?php else: ?>

		<?php
			$locationDetail = $model->getLocationDetailsByID($location);
			$locationName = $locationDetail['location_name']; 
		?>
		
		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">Location Report<br>
				<span class="fw-normal" style="font-size: 22px; text-decoration: underline;">&nbsp;&nbsp;&nbsp;<?php echo $locationName; ?>&nbsp;&nbsp;&nbsp;</span> <br>
				<span class="fw-light" style="font-size: 16px;">
					In between <?php echo date('F d, Y', strtotime($fromDate)); ?> to <?php echo date('F d, Y', strtotime($toDate)); ?>
				</span>
			</h3> <!-- Header title -->
		</div>

		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-location-specificLocation-specificDate" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-location-specificLocation-specificDate">
					<input type="text" name="location" value="<?php echo $location ?>" hidden/>
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
						<th class="col-2">Property No</th>
						<th class="col-4">Description</th>
						<th class="col-2">Article</th>
						<th class="col-1">Remark</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Unit Value</th>
						<th class="col-2">Acquisiton Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($locations = $model->getInventorySpecificLocationSpecificDateReport($location, $fromDate, $toDate))): ?>
						<?php foreach ($locations as $location): ?>
						<tr>
							<td> <?php echo $location['property_no'] ?></td>
							<td> <?php echo $location['description'] ?></td>
							<td> <?php echo $location['article_name'] ?></td>
							<td>
								<?php if(!empty($rows = $model->displayInvNotes('inventory', $location['remark_name']))): ?>
									<?php foreach ($rows as $note): ?>
										<span style="font-size: 13px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $location['unit_name'] ?></td>
							<td> <?php echo $location['qty_pcard'] ?></td>
							<td> <?php echo $location['qty_pcount'] ?></td>
							<td> <?php echo $location['unit_cost'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($location['acquisition_date'])) ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table> <br> <!-- Table -->
		</div>

	<?php endif; ?> <!-- Specific location -->
<?php endif; ?> <!-- Specific dates && All/Specific location -->


<!-- All dates && All/Specific location -->
<?php
if (isset($_POST['report-location-all-dates'])):
	$date_now = date("Y-m-d H:i:s");
	$location = $_POST['location'];
?>
	
	<!-- All location && All dates -->
	<?php if($location == 'all_location'): ?>

		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">All Locations<br>
				<span class="fw-light" style="font-size: 16px;">
					As of <?php echo date('F d, Y', strtotime($date_now)); ?> 
				</span>
			</h3> <!-- Header title -->
		</div>

		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-location-allLocation-allDate" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-location-allLocation-allDate">
					<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
					<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
				</button>
			</form>
		</div> <br> <br>
		<!-- Download report button -->

		<!-- Table -->
		<div class="row table-responsive p-0 m-0">
			<table class="table table-striped table-hover" id="table" style="width:100%">
				<thead>
					<tr>
						<th class="col-1">Location</th>
						<th class="col-4">Description</th>
						<th class="col-2">Property No</th>
						<th class="col-1">Remark</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Unit Value</th>
						<th class="col-2">Acquisiton Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($locations = $model->getInventoryAllLocationAllDate())): ?>
						<?php foreach ($locations as $location): ?>
						<?php $inv_location = $location['location_name']; ?>
						<tr>
							<td> <?php if(empty($location['location_name'])): ?> <span class="text-decoration-underline fw-light">unassigned</span> <?php else: echo $location['location_name']; ?> <?php endif; ?></td>
							<td> <?php echo $location['description'] ?></td>
							<td> <?php echo $location['property_no'] ?></td>
							<td>
								<?php if(!empty($rows = $model->displayInvNotes('inventory', $location['remark_name']))): ?>
									<?php foreach ($rows as $note): ?>
										<span style="font-size: 13px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $location['unit_name'] ?></td>
							<td> <?php echo $location['qty_pcard'] ?></td>
							<td> <?php echo $location['qty_pcount'] ?></td>
							<td> <?php echo $location['unit_cost'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($location['acquisition_date'])); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table> <br>
		</div>
	<!-- All Location -->
	
	<!-- Specific location -->
	<?php else: ?>

		<?php
			$locationDetail = $model->getLocationDetailsByID($location);
			$locationName = $locationDetail['location_name']; 
		?>
		
		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">Location Report<br>
				<span class="fw-normal" style="font-size: 22px; text-decoration: underline;">&nbsp;&nbsp;&nbsp;<?php echo $locationName; ?>&nbsp;&nbsp;&nbsp;</span> <br>
				<span class="fw-light" style="font-size: 16px;">
					As of <?php echo date('F d, Y', strtotime($date_now)); ?>
				</span>
			</h3> 
		</div><!-- Header title -->
			
		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-location-specificLocation-allDate.php" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-location-specificLocation-allDate">
					<input type="text" name="location" value="<?php echo $location ?>" hidden/>
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
						<th class="col-2">Property No</th>
						<th class="col-4">Description</th>
						<th class="col-2">Article</th>
						<th class="col-1">Remark</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Unit Value</th>
						<th class="col-2">Acquisiton Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($locations = $model->getInventorySpecificLocationAllDateReport($location))): ?>
						<?php foreach ($locations as $location): ?>
						<tr>
							<td> <?php echo $location['property_no'] ?></td>
							<td> <?php echo $location['description'] ?></td>
							<td> <?php echo $location['article_name'] ?></td>
							<td>
								<?php if(!empty($rows = $model->displayInvNotes('inventory', $location['remark_name']))): ?>
									<?php foreach ($rows as $note): ?>
										<span style="font-size: 11px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $location['unit_name'] ?></td>
							<td> <?php echo $location['qty_pcard'] ?></td>
							<td> <?php echo $location['qty_pcount'] ?></td>
							<td> <?php echo $location['unit_cost'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($location['acquisition_date'])); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table> <br> 
		</div> <!-- Table -->

	<?php endif; ?> <!-- Specific remark -->
<?php endif; ?> <!-- Specific dates && All/Specific remark -->
