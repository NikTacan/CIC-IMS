<!-- Inventory Assignment form -->
<div id="assignment_form" style="display: none;">
    <form method="POST">

		<div class="row justify-content-center align-items-center">

			<!-- End Users select -->
			<div class="form-group col-md-12 col-lg-2" id="end-user-select">
				<label class="col-form-label">End Users</label>
				<select class="form-control form-control-sm" name="end_user" required>
					<option value="" selected disabled hidden>-- Select End User --</option>
					<option value="all_end_users">All End User</option>
					<?php if (!empty($endUsers = $model->getEndUser())): ?>
						<?php foreach ($endUsers as $endUser): ?>
							<option value="<?php echo $endUser['end_user_id']; ?>"><?php echo $endUser['username']; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div> <!-- End Users select -->

			<!-- All Dates checkbox -->
			<div class="form-group col-md-1 col-lg-1 d-flex flex-column align-items-center">
				<label class="text-center">All Dates</label>
				<input class="btn btn-sm btn-primary all-assignment-checkbox text-center mt-2" type="checkbox" id="all-dates-btn">
			</div>

			<!-- Pick Dates checkbox -->
			<div class="form-group col-md-1 col-lg-1 d-flex flex-column align-items-center">
				<label class="text-center">Pick Dates</label>
				<input class="btn btn-sm btn-primary pick-assignment-checkbox text-center mt-2" type="checkbox" id="pick-dates-btn">
			</div>

		</div> <!-- row -->

		<!-- Pick Dates section -->
		<div class="row justify-content-center align-items-center" id="pick-dates-assignment" style="display: none;">
		
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
				<button class="btn green btn-xs radius-lg" type="submit" name="report-assignment-specific-dates" id="report-assignment-specific-dates" onclick="this.form.submit()">
					<span class="text">submit</span><span class="icon text-white-50"></span>
				</button>
			</div>
		</div> <!-- Pick Dates section -->

		<!-- All Dates section -->
		<div class="row justify-content-center align-items-center" id="all-dates-assignment" style="display: none;">
			<!-- Submit Button -->
			<div class="form-group col-md-6 col-lg-1" style="margin-top: 20px;">
				<button class="btn green btn-xs radius-lg" type="submit" name="report-assignment-all-dates" id="report-assignment-all-dates" onclick="this.form.submit()">
					<span class="text">submit</span><span class="icon text-white-50"></span>
				</button>
			</div>
		</div> <!-- All Dates section -->

	</form> 
</div> <!-- Assignment form -->

	<!-- Specific dates && All/Specific end users -->
	<?php
	if (isset($_POST['report-assignment-specific-dates'])):
		$fromDate = $_POST['from_date'];
		$toDate = $_POST['to_date'];
		$end_user = $_POST['end_user']; ?>

		<!-- All end users && Spicific dates -->
		<?php if($end_user == 'all_end_users'): ?>

			<!-- Header title -->
			<div class="row header">
				<h3 class="text-center m-0">All Inventory Assignment<br>
					<span class="fw-light" style="font-size: 16px;">
						( In between <?php echo date('M. d, Y', strtotime($fromDate)); ?> to <?php echo date('M. d, Y', strtotime($toDate)); ?> )
					</span>
				</h3> 
			</div><!-- Header title -->
				
			<!-- Download report button -->
			<div class="row mb-2 me-1" style="float: right;">
				<form action="report/report-assignment-specificDate-allUser" method="post">
					<button class="btn blue green btn-xs radius-xl" name="report-assignment-specificDate-allUser">
						<input type="date" name="from_date" value="<?php echo $fromDate; ?>" hidden/>
						<input type="date" name="to_date" value="<?php echo $toDate; ?>" hidden/>
						<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
						<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
					</button>
				</form>
			</div> <!-- Download report button -->

			<!-- Table -->
			<div class="row table-responsive m-0 p-0">
				<table class="table table-striped table-hover" id="table" style="width:100%">
					<thead>
						<tr>
							<th class="col-2">Accountable End User</th>
							<th class="col-3">Description</th>
							<th class="col-2">Property No.</th>
							<th class="col-1">Qty</th>
							<th class="col-1">Unit</th>
							<th class="col-1">Unit Cost</th>
							<th class="col-2">Property Assigned Date</th>
						</tr>
					</thead>
					<tbody>
						<!-- Inventory Assignment Inventory Items -->
						<?php if (!empty($inventories = $model->getAllEndUserAssignmentReport($fromDate ,$toDate))): ?>
							<?php foreach ($inventories as $inventory): ?>
								<?php if(!empty($inventory['property_no'])): ?>
									<tr>
										<td> <?php echo $inventory['username'] ?></td>
										<td> <?php echo $inventory['description'] ?></td>
										<td> <?php echo $inventory['property_no'] ?></td>
										<td> <?php echo $inventory['qty'] ?></td>
										<td> <?php echo $inventory['unit'] ?></td>
										<td> <?php echo $inventory['unit_cost'] ?></td>
										<td width="70"> <?php echo date('F d, Y', strtotime($inventory['date_added'])); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?> <!-- Inventory Assignment Inventory Items -->

					</tbody>
				</table> <br> 
			</div> <!-- Table -->
		<!-- All end user -->		

		<!-- Specific end user -->
		<?php else: ?> 

			<?php 		
				$endUserDetail = $model->getEndUserDetailById($end_user);
				$endUsername = $endUserDetail['username'];	
			?>

			<!-- Header title -->
			<div class="row header">
				<h3 class="text-center m-0"><?php echo $endUsername ?><br>
					<span class="fw-light" style="font-size: 16px;">
						( In between <?php echo date('F d, Y', strtotime($fromDate)); ?> to <?php echo date('F d, Y', strtotime($toDate)); ?> )
					</span>
				</h3>
			</div> 
			
			<!-- Download report button -->
			<div class="row mb-2 me-1" style="float: right;">
				<form action="report/report-assignment-specificDate-specificUser" method="post">
					<button class="btn blue green btn-xs radius-xl" id="report-excel-assignment-specific" name="report-excel-assignment-specific">
						<input type="text" name="end_user" value="<?php echo $end_user; ?>" hidden/>
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
							<th class="col-2">Property No.</th>
							<th class="col-4">Description</th>
							<th class="col-1">Qty</th>
							<th class="col-1">Unit</th>
							<th class="col-1">Unit Cost</th>
							<th class="col-2">Property Assigned to End User</th>
						</tr>
					</thead>
					<tbody>

						<!-- Inventory Assignment -->
						<?php if (!empty($assignmentItems = $model->getEndUserAssignmentReport($end_user, $fromDate ,$toDate))): ?>
							<?php foreach ($assignmentItems as $assignmentItem): ?>
								<?php if(!empty($assignmentItem['property_no'])): ?>
								<tr>
									<td> <?php echo $assignmentItem['property_no'] ?></td>
									<td> <?php echo $assignmentItem['description'] ?></td>
									<td> <?php echo $assignmentItem['qty'] ?></td>
									<td> <?php echo $assignmentItem['unit'] ?></td>
									<td> <?php echo $assignmentItem['unit_cost'] ?></td>
									<td> <?php echo date('F d, Y', strtotime($assignmentItem['date_added'])); ?></td>
								</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?> <!-- Inventory Assignment -->
						
					</tbody>
				</table> <br> 
			</div> <!-- Table -->

		<?php endif; ?> <!-- Specific end user -->
	<?php endif; ?> <!-- Specific dates && All/Specific end users -->


	<!-- All dates && All/Specific end users -->
	<?php 
	if (isset($_POST['report-assignment-all-dates'])):
		$end_user = $_POST['end_user'];

	?>
	
		<!-- All end user -->
		<?php if($end_user == 'all_end_users'): ?>

			<div class="row header">
				<h3 class="text-center m-0"><?php echo ucwords(str_replace('_', ' ', $end_user)); ?><br>
					<span class="fw-light" style="font-size: 16px;">( overall property assignment )</span>
				</h3>
			</div> 
	
			<!-- Download report button-->
			<div class="row mb-2 me-1" style="float: right;">
				<form action="report/report-assignment-allDate-allUser" method="post">
					<button class="btn blue green btn-xs radius-xl" id="report-excel-assignment-all-all" name="report-excel-assignment-all-all">
						<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
						<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
					</button>
				</form>
			</div>
			<!-- Download report button-->	

			<!-- Overall inventory assignment of overall end users -->
			<div class="row table-responsive m-0 p-0">
				<table class="table table-striped table-hover" id="table" style="width:100%">
					<thead>
						<tr>
							<th class="col-2">Accountable End User</th>
							<th class="col-2">Property Number</th>
							<th class="col-3">Description</th>
							<th class="col-1">Quantity</th>
							<th class="col-1">Unit</th>
							<th class="col-1">Unit Cost</th>
							<th class="col-2">Property Assigned to End User</th>
						</tr>
					</thead>
					<tbody>
						<!-- Inventory assignment -->
						<?php if (!empty($assignmentItems = $model->getAllInventoryAssignment())): ?>
							<?php foreach ($assignmentItems as $assignmentItem): ?>
								<?php if(!empty($assignmentItem['property_no'])): ?>
									<tr>
										<td> <?php echo $assignmentItem['username'] ?></td>
										<td> <?php echo $assignmentItem['property_no'] ?></td>
										<td> <?php echo $assignmentItem['description'] ?></td>
										<td> <?php echo $assignmentItem['qty'] ?></td>
										<td> <?php echo $assignmentItem['unit'] ?></td>
										<td> <?php echo $assignmentItem['unit_cost'] ?></td>
										<td> <?php echo date('F d, Y', strtotime($assignmentItem['date_added'])); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?> <!-- Inventory assignment -->
					
					</tbody> 
				</table> <br> <!-- Overall inventory assignment of overall end users -->
			</div>			
			<!-- All end user -->

		<!-- Specific end user -->
		<?php else: ?>
			
			<?php 		
				$endUserDetail = $model->getEndUserDetailById($end_user);
				$endUsername = $endUserDetail['username'];	
			?>

			<div class="row header">
				<h3 class="text-center m-0"><?php echo $endUsername; ?><br>
					<span class="fw-light" style="font-size: 16px;">( All assigned properties )</span>
				</h3>
			</div> 
		
			<!-- Download report button -->
			<div class="row mb-2 me-1" style="float: right;">
				<form action="report/report-assignment-allDate-specificUser" method="post">
					<button class="btn blue green btn-xs radius-xl" id="report-excel-assignment-all" name="report-excel-assignment-all">
						<input type="text" name="end_user" value="<?php echo $end_user; ?>" hidden/>
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
							<th class="col-2">Property Number</th>
							<th class="col-4">Description</th>
							<th class="col-1">Quantity</th>
							<th class="col-1">Unit</th>
							<th class="col-1">Unit Cost</th>
							<th class="col-2">Property Assigned Date</th>
						</tr>
					</thead>
					<tbody>

						<!-- Inventory assignment -->
						<?php if(!empty($assignedItems = $model->getEndUserAssignment($end_user))): ?>
							<?php foreach ($assignedItems as $assignedItem): ?>
								<?php if(!empty($assignedItem['property_no'])): ?>
									<tr>
										<td> <?php echo $assignedItem['property_no'] ?></td>
										<td> <?php echo $assignedItem['description'] ?></td>
										<td> <?php echo $assignedItem['qty'] ?></td>
										<td> <?php echo $assignedItem['unit'] ?></td>
										<td> <?php echo $assignedItem['unit_cost'] ?></td>
										<td> <?php echo date('F d, Y', strtotime($assignedItem['date_added'])); ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?> <!-- Inventory assignment -->

					</tbody>
				</table> <br> <!-- Table -->
			</div>
		<?php endif?> <!-- Specific end user -->

	<?php endif; ?> <!-- All dates && All/Specific end users -->



			


