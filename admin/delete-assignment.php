<?php include('../includes/session.php'); ?>
<?php

	if (isset($_GET['id'])) {
		$assignment_id = $_GET['id'];

		$model->archiveAssignment($assignment_id);
								
        $_SESSION['successMessage'] = "Assignment record archived succesfully!";
        header("Location: inventory-assignment.php");
        exit();
	}

?>