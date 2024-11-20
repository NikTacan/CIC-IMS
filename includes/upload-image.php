<?php
	
	/* update logo (system-content.php) */
	if (isset($_POST['update-logo'])) {

		$newFileName = "report-logo";
		
		$file = $_FILES['logo-file'];

		$fileName = $file['name'];
		$fileType = $file['type'];
		$fileTmpName = $file['tmp_name'];
		$fileError = $file['error'];
		$fileSize = $file['size'];

		$fileExt = explode(".", $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array("jpg", "jpeg", "png");

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 1000000) {
					
					$imageFullName = $newFileName .".". uniqid("", true) . "." . $fileActualExt;
					$fileDestination = "../assets/images/" . $imageFullName;

					$model->updateImage($imageFullName);

					move_uploaded_file($fileTmpName, $fileDestination);

					$_SESSION['successMessage'] = "Image uploaded successfully!";
					header("Location: system-content.php");
					exit();
				} else {
					$_SESSION['errorMessage'] = "File is too big!";
					header("Location: system-content.php");
					exit();
				}
			} else {
				$_SESSION['errorMessage'] = "You had an error!";
				header("Location: system-content.php");
				exit();
			}
		} else {
			$_SESSION['errorMessage'] = "You need to upload a proper file type!";
			header("Location: system-content.php");
			exit();
		}
	} // update logo

	/* edit profile (user-view.php) */
	if (isset($_POST['update-profile'])) {

		$newFileName = "report-logo";
		
		$file = $_FILES['logo-file'];

		$fileName = $file['name'];
		$fileType = $file['type'];
		$fileTmpName = $file['tmp_name'];
		$fileError = $file['error'];
		$fileSize = $file['size'];

		$fileExt = explode(".", $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array("jpg", "jpeg", "png");

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 200000) {
					
					$imageFullName = $newFileName .".". uniqid("", true) . "." . $fileActualExt;
					$fileDestination = "../assets/images/" . $imageFullName;

					$model->updateImage($imageFullName);

					move_uploaded_file($fileTmpName, $fileDestination);

					echo "<script>alert('Image uploaded successfully!');window.open('system-content', '_self')</script>";
				} else {
					echo "File size is too big!";
					exit();
				}
			} else {
				echo "You had an error!";
				exit();
			}
		} else {
			echo "<script>alert('You need to upload a proper file type!')</script>";
			exit();
		}
	} // edit profile


	/* update login image background (system-content.php) */
	if (isset($_POST['update-login-image'])) {

		$newFileName = "login-image-background";
		
		$file = $_FILES['login-image-background'];

		$fileName = $file['name'];
		$fileType = $file['type'];
		$fileTmpName = $file['tmp_name'];
		$fileError = $file['error'];
		$fileSize = $file['size'];

		$fileExt = explode(".", $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array("jpg", "jpeg", "png");

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 5000000) {
					
					$imageFullName = $newFileName .".". uniqid("", true) . "." . $fileActualExt;
					$fileDestination = "../assets/images/" . $imageFullName;

					$model->updateLoginBg($imageFullName); // Update Login Background Image

					move_uploaded_file($fileTmpName, $fileDestination);

					$_SESSION['successMessage'] = "Image uploaded successfully!";
					header("Location: system-content.php");
					exit();
				} else {
					$_SESSION['errorMessage'] = "File is too big!";
					header("Location: system-content.php");
					exit();
				}
			} else {
				$_SESSION['errorMessage'] = "You had an error!";
				header("Location: system-content.php");
				exit();
			}
		} else {
			$_SESSION['errorMessage'] = "You need to upload a proper file type!";
			header("Location: system-content.php");
			exit();
		}
	} // update logo


	

?>