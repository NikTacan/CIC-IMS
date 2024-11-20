<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Datatables bootstrap -->
	<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/dataTables.bootstrap4.min.css">

	<!-- Calendar -->
	<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/main.min.css">

	<!-- Select / search (end-user.php) -->
	<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/select2.min.css">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/bootstrap.css">

	<!-- Assets (vendors) -->
	<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/assets.css">

	<!-- Typography -->
	<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/typography.css">

	<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/shortcodes/shortcodes.css">

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	
	<!-- theme 1 (green, black) -->
	<?php if($theme_id == '1'): ?> 
		<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/dashboard.css">

	<!-- theme 2 (maroon, white) -->	
	<?php elseif($theme_id == '2'): ?>
		<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/dashboard-1.css">

	<!-- theme 2 (grey, white) -->	
	<?php elseif($theme_id == '3'): ?>
		<link rel="stylesheet" type="text/css" href="../dashboard/assets/css/dashboard-2.css">
	<?php endif; ?>


	<link rel="icon" href="../assets/images/<?php echo $customize['logo_file']; ?>" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="../assets/images/<?php echo $customize['logo_file']; ?>" />

	
	