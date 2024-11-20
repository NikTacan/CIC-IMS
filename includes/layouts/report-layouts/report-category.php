<!-- Category report form -->
<div id="category_form" style="display: none;">
	<form method="POST" >
		<div class="row justify-content-center align-items-center">

			<!-- Select Category option -->
			<div class="form-group col-md-12 col-lg-2">
				<label class="col-form-label">Categories</label>
				<select class="form-control form-control-sm" name="category" required>
					<option value="" selected disabled hidden>-- Select category --</option>
					<option value="all_category">All Catories</option>
					<?php if(!empty($categories = $model->displayCategories())):  ?>
						<?php foreach ($categories as $category):  ?>
								
						<option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>

						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div> <!-- Select Category option -->

					
			<!-- All Dates checkbox -->
			<div class="form-group col-md-1 col-lg-1 d-flex flex-column align-items-center">
				<label class="text-center">All Dates</label>
				<input class="btn btn-sm btn-primary all-category-checkbox text-center mt-2" type="checkbox" id="all-dates-btn">
			</div>

			<!-- Pick Dates checkbox -->
			<div class="form-group col-md-1 col-lg-1 d-flex flex-column align-items-center">
				<label class="text-center">Pick Dates</label>
				<input class="btn btn-sm btn-primary pick-category-checkbox text-center mt-2" type="checkbox" id="pick-dates-btn">
			</div>

		</div> <!-- row -->

		<!-- Pick Dates section -->
		<div class="row justify-content-center align-items-center" id="pick-dates-category" style="display: none;">
		
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
				<button class="btn green btn-xs radius-lg" type="submit" name="report-category-specific-dates" id="report-category-specific-dates" onclick="this.form.submit()">
					<span class="text">submit</span><span class="icon text-white-50"></span>
				</button>
			</div>
		</div> <!-- Pick Dates section -->

		<!-- All Dates section -->
		<div class="row justify-content-center align-items-center" id="all-dates-category" style="display: none;">
			<!-- Submit Button -->
			<div class="form-group col-md-6 col-lg-1" style="margin-top: 20px;">
				<button class="btn green btn-xs radius-lg" type="submit" name="report-category-all-dates" id="report-category-all-dates" onclick="this.form.submit()">
					<span class="text">submit</span><span class="icon text-white-50"></span>
				</button>
			</div>
		</div> <!-- All Dates section -->

	</form> 
</div> <!-- Category report form -->

<!-- Specific dates && All/Specific remark -->
<?php
if (isset($_POST['report-category-specific-dates'])):
	$fromDate = $_POST['from_date'];
	$toDate = $_POST['to_date'];
	$category = $_POST['category'];
?>
	
	<!-- All category && Specific dates -->
	<?php if($category == 'all_category'): ?>

		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">All Category<br>
				<span class="fw-light" style="font-size: 16px;">
					In between <?php echo date('F d, Y', strtotime($fromDate)); ?> to <?php echo date('F d, Y', strtotime($toDate)); ?>
				</span>
			</h3> 
		</div><!-- Header title -->
			
		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-category-allCategory-specificDate" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-category-allCategory-specificDate">
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
						<th class="col-1">Category</th>
						<th class="col-4">Description</th>
						<th class="col-2">Property No</th>
						<th class="col-1">Remark</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-2">Unit Value</th>
						<th class="col-2">Acquisiton Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($inventories = $model->getInventoryAllCategorySpecificDateReport($fromDate, $toDate))): ?>
						<?php foreach ($inventories as $inventory): ?>
						<tr>
							<td> <?php echo $inventory['category_name'] ?></td>
							
							<td> <?php echo $inventory['description'] ?></td>
							<td> <?php echo $inventory['property_no'] ?></td>
							<td>
								<?php if(!empty($notes = $model->displayInvNotes('inventory', $inventory['remark_name']))): ?>
									<?php foreach ($notes as $note): ?>
										<span style="font-size: 13px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $inventory['unit_name'] ?></td>
							<td> <?php echo $inventory['qty_pcard'] ?></td>
							<td> <?php echo $inventory['qty_pcount'] ?></td>
							<td> <?php echo $inventory['unit_cost'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($inventory['acquisition_date'])) ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table> <br>
		</div><!-- All remakrs -->
	
	<!-- Specific category -->
	<?php else: ?>

		<?php 
			$categoryDetail = $model->getCategoryDetailByID($category);
			$categoryName = $categoryDetail['category_name'];
		?>
		
		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">Category Report<br>
				<span class="fw-normal" style="font-size: 22px; text-decoration: underline;">&nbsp;&nbsp;&nbsp;<?php echo $categoryName; ?>&nbsp;&nbsp;&nbsp;</span> <br>
				<span class="fw-light" style="font-size: 16px;">
					In between <?php echo date('M. d, Y', strtotime($fromDate)); ?> to <?php echo date('M. d, Y', strtotime($toDate)); ?>
				</span>
			</h3> 
		</div> <!-- Header title -->
			
		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-category-specificCategory-specificDate" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-category-specificCategory-specificDate">
					<input type="text" name="category" value="<?php echo $category ?>" hidden/>
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
						<th class="col-1">Remark</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Unit Value</th>
						<th class="col-2">Acquisiton Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($categories = $model->getInventorySpecificCategorySpecificDateReport($category, $fromDate, $toDate))): ?>
						<?php foreach ($categories as $category): ?>
						<tr>
							<td> <?php echo $category['property_no'] ?></td>
							<td> <?php echo $category['description'] ?></td>
							<td>
								<?php if(!empty($rows = $model->displayInvNotes('inventory', $category['remark_name']))): ?>
									<?php foreach ($rows as $note): ?>
										<span style="font-size: 13px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $category['unit_name'] ?></td>
							<td> <?php echo $category['qty_pcard'] ?></td>
							<td> <?php echo $category['qty_pcount'] ?></td>
							<td> <?php echo $category['unit_cost'] ?></td>
							<td> <?php echo $category['acquisition_date'] ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div> <!-- Table -->

	<?php endif; ?> <!-- Specific remark -->
<?php endif; ?> <!-- Specific dates && All/Specific category -->


<!-- All dates && All/Specific category -->
<?php
if (isset($_POST['report-category-all-dates'])):
	$date_now = date("Y-m-d H:i:s");
	$category = $_POST['category'];
?>
	
	<!-- All category && All dates -->
	<?php if($category == 'all_category'): ?>

		<!-- Header title -->
		<div class="row header">
			<h3 class="text-center m-0">Overall Categories<br>
				<span class="fw-light" style="font-size: 16px;">
					As of <?php echo date('F d, Y', strtotime($date_now)); ?> 
				</span>
			</h3> 
		</div><!-- Header title -->
			
		<!-- Download report button -->
		<div class="row pb-2 me-2" style="float: right;">
			<form action="report/report-category-allCategory-allDate" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-category-allCategory-allDate">
					<input type="text" name="session_name" value="<?php echo $session_name; ?>" hidden/>
					<span class="text">Download </span><span class="icon text-white-50"><i class="fa fa-download ms-1"></i></span>
				</button>
			</form>
		</div> <br> <br>
		<!-- Download report button -->

		<!-- Table -->
		<div class="row table-responsive">
			<table class="table table-striped table-hover" id="table" style="width:100%">
				<thead>
					<tr>
						<th class="col-2">Property No</th>
						<th class="col-4">Description</th>
						<th class="col-1">Category</th>
						<th class="col-1">Remark</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Unit Value</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Acquisiton Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($inventories = $model->getAllInventoryOrderByCategory())): ?>
						<?php foreach ($inventories as $inventory): ?>
						<tr>
							<td> <?php echo $inventory['property_no'] ?></td>
							<td> <?php echo $inventory['description'] ?></td>
							<td> <?php echo $inventory['category_name'] ?></td>
							<td>
								<?php if(!empty($notes = $model->displayInvNotes('inventory', $inventory['remark_name']))): ?>
									<?php foreach ($notes as $note): ?>
										<span style="font-size: 11px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $inventory['unit_name'] ?></td>
							<td> <?php echo $inventory['unit_cost'] ?></td>
							<td> <?php echo $inventory['qty_pcard'] ?></td>
							<td> <?php echo $inventory['qty_pcount'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($inventory['acquisition_date'])); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div> <!-- All category - all date -->
	
	<!-- Specific category -->
	<?php else: ?>

		<?php 
			$categoryDetail = $model->getCategoryDetailByID($category);
			$categoryName = $categoryDetail['category_name'];
		?>
		
		<!-- Header title -->
		<div class="row header mb-2">
			<h3 class="text-center m-0">Category Report<br>
				<span class="fw-normal" style="font-size: 22px; text-decoration: underline;">&nbsp;&nbsp;&nbsp;<?php echo $categoryName; ?>&nbsp;&nbsp;&nbsp;</span> <br>
				<span class="fw-light" style="font-size: 16px;">
					As of <?php echo date('F d, Y', strtotime($date_now)); ?>
				</span>
			</h3> 
		</div><!-- Header title -->
			
		<!-- Download report button -->
		<div class="row mb-2 me-1" style="float: right;">
			<form action="report/report-category-specificCategory-allDate.php" method="post">
				<button class="btn blue green btn-xs radius-xl" name="report-category-specificCategory-allDate">
					<input type="text" name="category" value="<?php echo $category ?>" hidden/>
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
						<th class="col-1">Remark</th>
						<th class="col-1">Unit</th>
						<th class="col-1">Qty per<br>Property Card</th>
						<th class="col-1">Qty per<br>Physical Count</th>
						<th class="col-1">Unit Value</th>
						<th class="col-2">Acquisiton Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($categories = $model->getInventorySpecificCategoryAllDateReport($category))): ?>
						<?php foreach ($categories as $category): ?>
						<tr>
							<td> <?php echo $category['property_no'] ?></td>
							<td> <?php echo $category['description'] ?></td>
							<td>
								<?php if(!empty($rows = $model->displayInvNotes('inventory', $category['remark_name']))): ?>
									<?php foreach ($rows as $note): ?>
										<span style="font-size: 11px; color: white; padding: 5px; border-radius: 25px; background-color: <?php echo $note['color']; ?>;"><?php echo $note['note_name']; ?></span>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
							<td> <?php echo $category['unit_name'] ?></td>
							<td> <?php echo $category['qty_pcard'] ?></td>
							<td> <?php echo $category['qty_pcount'] ?></td>
							<td> <?php echo $category['unit_cost'] ?></td>
							<td> <?php echo date('M. d, Y', strtotime($category['acquisition_date'])); ?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div><!-- Table -->

	<?php endif; ?> <!-- Specific remark -->
<?php endif; ?> <!-- Specific dates && All/Specific remark -->
