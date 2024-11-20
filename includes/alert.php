<?php 

	$successMessage = "";
	$errorMessage = "";

	if (!empty($_SESSION['successMessage'])) {
		$successMessage = $_SESSION['successMessage'];
		unset($_SESSION['successMessage']); 
	}
	
	if (!empty($_SESSION['errorMessage'])) {
		$errorMessage = $_SESSION['errorMessage'];
		unset($_SESSION['errorMessage']); 
	}
    
?>