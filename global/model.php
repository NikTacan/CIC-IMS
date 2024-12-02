<?php
	date_default_timezone_set('Asia/Manila');
	Class Model {
		private $server = "localhost";
		private $username = "root";
		private $password = "cicims";
		private $dbname = "cic_ims";
		private $conn;

		public function __construct() {
			try {
				$this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);	
			} catch (Exception $e) {
				echo "Connection failed" . $e->getMessage();
			}
		}


		
		  //==================================================================//
		 //			        SIGN-IN, USER FUNCTION MODEL 		     		 //
		//==================================================================//

		/* User sign-in (../index.php)*/
		public function signIn($uname, $pword) {
			$response = [
				'success' => false,
				'message' => 'Account not found or invalid credentials',
				'data' => null
			];
		
			// Select status field along with role_id to confirm user status if applicable
			$query = "SELECT u.id, u.username, u.role_id, u.password, e.status AS end_user_status, s.status AS sub_admin_status
					  FROM users u 
					  LEFT JOIN end_user e ON u.id = e.user_id
					  LEFT JOIN sub_admin s ON u.id = s.user_id
					  WHERE u.username = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('s', $uname);
		
				if ($stmt->execute()) {
					$result = $stmt->get_result();
		
					if ($result->num_rows === 1) {
						$row = $result->fetch_assoc();
						error_log("Found user with ID: " . $row['id']);
		
						// Check if the account is inactive based on role
						if (($row['role_id'] == 3 && $row['end_user_status'] != '1') || ($row['role_id'] == 2 && $row['sub_admin_status'] != '1')) {
							$response['message'] = 'Account is inactive';
							error_log("Inactive account for username: " . $uname);
						} elseif (password_verify($pword, $row['password'])) {
							// Proceed with login if active user or admin
							$response['success'] = true;
							$response['data'] = $row;
							$response['message'] = 'Login successful';
							error_log("Login successful for user: " . $uname);
						} else {
							$response['message'] = 'Invalid password';
							error_log("Password verification failed for username: " . $uname);
						}
					} else {
						$response['message'] = 'No matching user found';
						error_log("No matching user found for username: " . $uname);
					}
				} else {
					$response['message'] = "Failed to execute statement: " . $stmt->error;
					error_log($response['message']);
				}
				$stmt->close();
		
			} else {
				$response['message'] = "Failed to prepare statement: " . $this->conn->error;
				error_log($response['message']);
			}
		
			return $response;
		}
		


		/* Reset user password to default (user/user-view && admin/end-user) */
		public function resetUserPassword($user_id) {
			$query = "UPDATE users SET password = ? WHERE id = ?";
			$default_password = '12345';
			$hashed_default = password_hash($default_password, PASSWORD_DEFAULT);

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $hashed_default, $user_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Update user password (user-view.php) */
		public function updateUserPassword($user_id, $password) {
			$query = "UPDATE users SET password = ? WHERE id = ?";
			$hashed_default = password_hash($password, PASSWORD_DEFAULT);

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $hashed_default, $user_id);
				if ($stmt->execute()) {
					error_log("Password updated for user ID: " . $user_id);
				} else {
					error_log("Failed to update password for user ID: " . $user_id . ". Error: " . $stmt->error);
				}
				$stmt->close();
			} else {
				error_log("Failed to prepare password update statement: " . $this->conn->error);
			}
		}

		/* Get user details based on <USER ID> (user-view) */
		public function getUserInfo($user_id) {
			$data = null;
			$query = "SELECT * FROM users WHERE id = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $user_id);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					$data = $result->fetch_assoc();
				}
				$stmt->close();
			}
			return $data;
		}
		
		/*=============================================
						USER MANAGEMENT 
		=============================================*/

		/* ========================================
						SUB ADMIN
		========================================= */

		public function getSubAdmin() {
			$data = null;
			$query = "SELECT s.id AS sub_admin_id, s.user_id, s.first_name, s.middle_name, s.last_name, s.contact, s.designation, s.sex, s.status, s.date_registered, 
			d.id AS designation_id, d.designation_name, 
			u.id AS user_id, u.role_id, u.username, u.password, u.date_created  
				FROM sub_admin s
				LEFT JOIN designation d ON s.designation = d.id
				LEFT JOIN users u ON s.user_id = u.id
				ORDER BY s.date_registered  DESC";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get sub admin by Id (sub-admin) */
		public function getSubAdminByID($subAdmin_id) {
			$data = null;
			$query = "SELECT s.*, d.id AS designation_id, d.designation_name
					FROM sub_admin s 
					LEFT JOIN designation d ON s.designation = d.id 
					WHERE s.id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $subAdmin_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}
		

		/* Insert new end user data (end-user.php) */
		public function createSubAdmin($username, $firstName, $middleName, $lastName, $sex, $password, $contact, $designation) {
			// First, insert the user into the 'users' table
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$dateCreated = date("Y-m-d H:i:s");
			$user_role = '2'; // sub_admin
		
			$query = "INSERT INTO users (role_id, username, password, date_created) VALUES (?, ?, ?, ?)";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("isss", $user_role, $username, $hashedPassword, $dateCreated);
				$stmt->execute();
				$user_id = $this->conn->insert_id;  // Get the inserted user's ID
				$stmt->close();
			} else {
				return false;
			}
		
			// Now insert the sub_admin using the user_id from the 'users' table
			$query = "INSERT INTO sub_admin (user_id, first_name, middle_name, last_name, contact, sex, designation, status, date_registered) 
					  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$statusActive = '1'; // active

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("isssisiis", $user_id, $firstName, $middleName, $lastName, $contact, $sex,$designation,  $statusActive, $dateCreated);
				if ($stmt->execute()) {
					$stmt->close();
		
					// Log transaction
					$logMessage = "'s has been added to <b>Sub Admin</b> records.";    
					$accountId = $_SESSION['sess'];
					$SudAdminName = $firstName . ' ' . $lastName;
					$this->logTransaction('sub_admin', 'INSERT', $SudAdminName, $SudAdminName, $accountId, $logMessage);
		
					return true;
				} else {
					$stmt->close();
					return false;
				}
			}
		
			return false;
		}
		

		/* Update End user data (end-user.php) */
		public function updateSubAdminStatus($status, $subAdmin_id) {
			// Get current user details
		
			$query = "UPDATE sub_admin SET status = ? WHERE id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ii", $status, $subAdmin_id);
				$stmt->execute();
				$stmt->close();
			} else {
				echo "Error: " . $this->conn->error;
			}
		}

		/* Update End user data (end-user.php) */
		public function updateSubAdmin($username, $firstName, $middleName, $lastName, $sex, $contact, $designation, $subAdmin_id) {
			
			$query = "UPDATE users SET username = ? WHERE id = (SELECT user_id FROM sub_admin WHERE id = ?)";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $username, $subAdmin_id);
				$stmt->execute();
				$stmt->close();
			}
		
			$query = "UPDATE sub_admin SET first_name = ?, middle_name = ?, last_name = ?, contact = ?, sex = ?, designation = ? WHERE id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ssssssi", $firstName, $middleName, $lastName, $contact, $sex, $designation, $subAdmin_id);
				$stmt->execute();
				$stmt->close();
			}
		}
		

		/*===========================================
				End Users Acitivity logs
		============================================*/

		/* Log Fund Cluster update transaction function */
		public function logEndSubAdminUpdateTransaction($oldValues, $newValues) {
			$logMessage = " Sub admin's record has been updated. ";
			$account_id = $_SESSION['sess'];
			$subAdminUsername = $oldValues['username'];
			
			$changes = array();
			
			// Check if the End user name is changed
			if ($oldValues['username'] != $newValues['username']) {
				$changes[] = "Username changed from '{$oldValues['username']}' to '{$newValues['username']}'";
			}

			// Check if the End user first name is changed
			if ($oldValues['first_name'] != $newValues['firstname']) {
				$changes[] = "First name changed from '{$oldValues['first_name']}' to '{$newValues['firstname']}'";
			}

			// Check if the End user middle name is changed
			if ($oldValues['middle_name'] != $newValues['middlename']) {
				$changes[] = "Middle name changed from '{$oldValues['middle_name']}' to '{$newValues['middlename']}'";
			}
			
			// Check if the End user last name is changed
			if ($oldValues['last_name'] != $newValues['lastname']) {
				$changes[] = "Last name changed from '{$oldValues['last_name']}' to '{$newValues['lastname']}'";
			}

			// Check if the sex is changed
			if ($oldValues['sex'] != $newValues['sex']) {
				$changes[] = "Sex changed from '{$oldValues['sex']}' to '{$newValues['sex']}'";
			}

			// Check if the contact is changed
			if ($oldValues['contact'] != $newValues['contact']) {
				$changes[] = "Contact updated from '{$oldValues['contact']}' to '{$newValues['contact']}'";
			}

			// Check if the designation is changed
			if ($oldValues['designation'] != $newValues['designation']) {
				$changes[] = "Designation updated from '{$oldValues['designation']}' to '{$newValues['designation']}'";
			}
			
			if (!empty($changes)) {
				$logMessage = $logMessage . implode(', ', $changes);

				$this->logTransaction('sub_admin', 'UPDATE', $subAdminUsername, $subAdminUsername, $account_id, $logMessage);
			}	
		}

		/*======================================
			CREATE END USER - NEW USER
		=====================================*/


		/* Update user record (admin/end-user && user/user-view) */
		public function updateUser($user_role, $username, $password, $user_id) {
			$query = "UPDATE users SET role_id = ?, username = ?, password = ? WHERE id = ?";

			$hashed_default = password_hash($password, PASSWORD_DEFAULT);

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("issi", $user_role,  $username, $hashed_default, $user_id);
				$stmt->execute();
				$stmt->close();
			}
		}


		/* Update user personal details (user-view.php) */
		public function updateUserInfo($username, $firstname, $middlename, $lastname, $sex, $birthday, $contact, $email, $user_id) {
			$query = "UPDATE users SET first_name = ?, middle_name = ?, last_name = ?, username = ?, email = ?, contact = ?, sex = ?, birthday = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sssssissi", $firstname, $middlename, $lastname, $username, $email, $contact, $sex, $birthday, $user_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Update user personal details (user-view.php) */
		public function updateUserUsername($username, $user_id) {
			$query = "UPDATE users SET username = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $username, $user_id);
				$stmt->execute();
				$stmt->close();
			}
		}


		/* Get user details based on <USER ID> (user-view.php) */
		public function getEndUserInfo($user_id) {
			$data = null;
			$query = "
				SELECT 
					eu.id AS end_user_id, 
					eu.user_id, 
					eu.first_name, 
					eu.middle_name, 
					eu.last_name, 
					eu.email, 
					eu.contact, 
					eu.designation, 
					eu.sex, 
					eu.birthday, 
					eu.status, 
					eu.date_registered, 
					u.id AS user_id, 
					u.role_id, 
					u.username,
					u.password, 
					u.date_created, 
					d.id AS designation_id, 
					d.designation_name
				FROM end_user eu
				LEFT JOIN users u ON eu.user_id = u.id
				LEFT JOIN designation d ON eu.designation = d.id
				WHERE u.id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $user_id);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					$data = $result->fetch_assoc();
				}
				$stmt->close();
			}
			return $data;
		}
		
		// Get admin info (user-view)
		public function getAdminInfo($user_id) {
			$data = null;
			$query = "SELECT * FROM users WHERE id = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $user_id);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result->num_rows > 0) {
					$data = $result->fetch_assoc();
				}
				$stmt->close();
			}
			return $data;
		}

		/* ==========================================
						DASHBOARD
		============================================*/

		
		// Method to get monthly assignment totals for the current year
		public function getMonthlyAssignments($year = null) {
			$year = $year ?: date('Y');
			
			$data = [];
			$query = "
				SELECT MONTH(date_added) AS month, COUNT(id) AS count
				FROM inventory_assignment
				WHERE YEAR(date_added) = ?
				GROUP BY MONTH(date_added)
				ORDER BY month";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $year); 
				$stmt->execute();
				$result = $stmt->get_result();
				
				// Initialize all months with zero counts
				$allMonths = array_fill(1, 12, 0);
				
				while ($row = $result->fetch_assoc()) {
					$allMonths[(int)$row['month']] = (int)$row['count'];  
				}
				$stmt->close();
			
				foreach ($allMonths as $month => $count) {
					$data[] = ['month' => $month, 'count' => $count];
				}
			}
			return $data;
		}

		
		// Method to get available years for assignments
		public function getAvailableYears() {
			$years = [];
			$query = "
				SELECT DISTINCT YEAR(date_added) AS year
				FROM inventory_assignment
				ORDER BY year DESC";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				
				// Fetch the years from the result
				while ($row = $result->fetch_assoc()) {
					$years[] = $row['year'];
				}
				$stmt->close();
			}
			return $years;
		}

		



		/*=============================================
						INVENTORY 
		=============================================*/

		/*=============================================
					VERIFY UNIQUE KEY 
		=============================================*/

		/* Check if Inventory Exist (history.php) */
		public function checkInvNoExist($inv_id) {
			$data = null;
			$query = "SELECT * FROM inventory WHERE inv_id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $inv_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Check if Property No. Exist (inventory.php && archive.php) */
		public function checkPropertyNoExist($property_no) {
			$data = null;
			$query = "SELECT * FROM inventory WHERE property_no = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $property_no);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		
		/* Check if Inventory is assigned  (inventory.php) */
		public function checkPropertyNoAssignment($property_no) {
			$query = "SELECT COUNT(*) as assigned FROM inventory_assignment_item WHERE property_no = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $property_no);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
				return $data['assigned'] > 0;
			}
			return false;
		}

		/*==============================
			INVENTORY PRIMARY CRUD
		===============================*/

		/* Insert Inventory Record (inventory.php) */
		public function insertInventory($property_no, $category, $location, $article, $description, $qty_pcard, $qty_pcount, $unit, $cost, $est_life, $acquired_date, $remark) {
			$query = "INSERT INTO inventory (property_no, category, location, article, description,  qty_pcard, qty_pcount, unit, unit_cost, est_life, acquisition_date, date_added, remark) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$account_id = $_SESSION['sess'];
			$date_added = date("Y-m-d H:i:s");

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("siiisiiidissi", $property_no, $category, $location, $article, $description, $qty_pcard, $qty_pcount, $unit, $cost, $est_life, $acquired_date, $date_added, $remark);
				$stmt->execute();
				$stmt->close();
			}
			$logMessage = "'s has been added to the Inventory record.";
			
			$this->logTransaction('inventory', 'INSERT', $property_no, $description, $account_id, $logMessage); //Log transaction
		}

		

		/* Get all Inventory Data from Database (inventory.php && report) */
		public function getAllInventory() {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id 
			ORDER BY i.date_added DESC";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Update Inventory Record (inventory.php) */
		public function updateInventory($property_no, $article, $description, $category, $location, $qty_pcard, $qty_pcount, $unit, $cost, $est_life, $acquired_date, $remark, $inv_id) {

			$query = "UPDATE inventory SET  property_no = ?, category = ?, location = ?, article = ?, description = ?, qty_pcard = ?, qty_pcount = ?, unit = ?, unit_cost = ?, est_life = ?, acquisition_date = ?, remark =? WHERE inv_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("siiisiiidisii",  $property_no, $category, $location, $article, $description, $qty_pcard, $qty_pcount, $unit, $cost, $est_life, $acquired_date, $remark, $inv_id);
				$stmt->execute();	
				$stmt->close();
			}
		}
		
		/* Archive Inventory Record (inventory.php) */
		public function archiveInventory($inv_id) {
			// Retrieve inventory details before deleting
			$inventoryInfo = $this->getInventoryByInvId($inv_id);
		
			// Extract necessary information for archiving
			$inv_id = $inventoryInfo['inv_id'];
			$property_no = $inventoryInfo['property_no'];

			$category = $inventoryInfo['category_id'] . ' ' .  $inventoryInfo['category_name'];
			$location = $inventoryInfo['location_id'] . ' ' . $inventoryInfo['location_name'];
			$article = $inventoryInfo['article_id'] . ' ' . $inventoryInfo['article_name'];
			$description = $inventoryInfo['description'];
			$qty_pcard = $inventoryInfo['qty_pcard'];
			$qty_pcount = $inventoryInfo['qty_pcount'];
			$unit = $inventoryInfo['unit_id'] . ' ' . $inventoryInfo['unit_name'];
			$unit_cost = $inventoryInfo['unit_cost'];
			$est_life = $inventoryInfo['est_life_id'] . ' ' . $inventoryInfo['est_life'];
			$acquired_date = $inventoryInfo['acquisition_date'];
			$remark = $inventoryInfo['remark_id'] . ' ' . $inventoryInfo['note_name'];
			$date_archived = date("Y-m-d H:i:s");
		
		
			$query = "INSERT INTO archive_inventory (inv_id, property_no, category, location, article, description, qty_pcard, qty_pcount, unit, unit_cost, est_life, acquisition_date, remark, date_archived) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ssssssiisdssss", $inv_id, $property_no, $category, $location, $article, $description, $qty_pcard, $qty_pcount, $unit, $unit_cost, $est_life, $acquired_date, $remark, $date_archived);
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
		
			$this->deleteInventory($inv_id); // Delete inventory record after archive
		}
		

		/* Delete Inventory Record (inventory.php) */
		public function deleteInventory($inv_id) {

			$inventoryInfo = $this->getInventoryByInvId($inv_id);
			$inv_id = $inventoryInfo['inv_id'];
			$inv_name = $inventoryInfo['description'];
			$account_id = $_SESSION['sess'];

			$logMessage = "has been moved to Inventory archived.";

			$this->logTransaction('inventory', 'ARCHIVE', $inv_id, $inv_name, $account_id, $logMessage); //Log record before deletion
			$deleteQuery = "DELETE FROM inventory WHERE inv_id = ?";

			if ($stmt = $this->conn->prepare($deleteQuery)) {
				$stmt->bind_param("i", $inv_id);
				$stmt->execute();
				$stmt->close();
			}		
			
		}


		/*==============================
			INVENTORY LOG TRANSACTION
		===============================*/

		/* Log Transaction Function */
		public function logTransactionInventoryUpdate($oldValues, $newValues) {
			$logMessage = "'s information has been updated. ";
			$account_id = $_SESSION['sess'];
			$description = $oldValues['description'];
			$property_no = $oldValues['property_no'];
		
			$changes = array();
		
			// Compare each field and collect changes
			if ($oldValues['inv_id'] != $newValues['inv_id']) {
				$changes[] = "Inventory No. changed from '{$oldValues['inv_id']}' to '{$newValues['inv_id']}'";
			}
		
			// Repeat for all fields you want to track
			if ($oldValues['property_no'] != $newValues['property_no']) {
				$changes[] = "Property No. changed from '{$oldValues['property_no']}' to '{$newValues['property_no']}'";
				$property_no = $newValues['property_no'];

			}
			if ($oldValues['category_id'] != $newValues['category']) {
				$oldCategoryName = $oldValues['category_name'];
				$newCategoryName = $this->getCategoryDetailByID($newValues['category']);
				$changes[] = "Category changed from '{$oldCategoryName}' to '{$newCategoryName['category_name']}' ";
			}
			if ($oldValues['location_id'] != $newValues['location']) {
				$oldLocationName = $oldValues['location_name'];
				$newLocationName = $this->getLocationDetailsById($newValues['location']);
				$changes[] = "Location changed from '{$oldLocationName}' to '{$newLocationName['location_name']}' ";
			}
			if ($oldValues['description'] != $newValues['description']) {
				$changes[] = "Description changed from '{$oldValues['description']}' to '{$newValues['description']}'";
				$description = $newValues['description'];
			}
			if ($oldValues['qty_pcard'] != $newValues['qty_pcard']) {
				$changes[] = "Quantity per Property Card updated from '{$oldValues['qty_pcard']}' to '{$newValues['qty_pcard']}'";
			}
			if ($oldValues['qty_pcount'] != $newValues['qty_pcount']) {
				$changes[] = "Quantity per Physical Count updated from '{$oldValues['qty_pcount']}' to '{$newValues['qty_pcount']}'";
			}
			if ($oldValues['unit_id'] != $newValues['unit']) {
				$oldUnit = $oldValues['unit_name'];
				$newUnit = $this->getUnitDetailByID($newValues['unit']);
				$changes[] = "Unit of measurement changed from '{$oldUnit}' to '{$newUnit['unit_name']}' ";
			}
			if ($oldValues['unit_cost'] != $newValues['cost']) {
				$changes[] = "Unit of Cost updated from '{$oldValues['unit_cost']}' to '{$newValues['cost']}'";
			}
			if ($oldValues['est_life_id'] != $newValues['est_life']) {
				$oldEstlife = $oldValues['est_life'];
				$newEstlife = $this->getEstLifeDetailByID($newValues['est_life']);
				$changes[] = "Estimated useful life changed from '{$oldEstlife}' to '{$newEstlife['est_life']}' ";
			}
			if ($oldValues['acquisition_date'] != $newValues['acquired_date']) {
				$changes[] = "Acquisition Date updated from '{$oldValues['acquisition_date']}' to '{$newValues['acquired_date']}'";
			}
			if ($oldValues['remark_id'] != $newValues['remark']) {
				$oldRemark = $oldValues['note_name'];
				$newRemark = $this->getNoteDetailByID($newValues['remark']);
				$changes[] = "Remark changed from '{$oldRemark}' to '{$newRemark['note_name']}' ";
			}
		
			if (!empty($changes)) {
				$logMessage = $logMessage . implode(', ', $changes);
				$this->logTransaction('inventory', 'UPDATE', $property_no, $description, $account_id, $logMessage);
			}
		}
		

		/* Get activity logs of item no (inventory-view.php) */
		public function displayInvNoLog($inv_id) {
			$data = null;
			$query = "SELECT * FROM history_log WHERE item_no = ? ORDER BY date_time DESC";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $inv_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Log inventory archive restore transaction function (archive-inventory.php)*/
		public function logInventoryRestoreTransaction($inv_id, $description, $date_archived) {
			$logMessage = "'s record has been restored. Archived last <span class="."fw-bold"."> $date_archived</span> in Inventory archives.";
			$account_id = $_SESSION['sess'];
			
			$this->logTransaction('inventory', 'UPDATE', $inv_id, $description, $account_id, $logMessage);
		}	

		/*=====================================================================
						INVENTORY ASSIGNMENT FUNCTIONS
		=====================================================================*/	

		// Method to get all inventory assignment (inventory-assignment.php)
		public function getInventoryAssignment() {
			$data = [];
			$query = "SELECT a.id AS assignment_id, a.end_user, a.status, a.date_added, e.id AS end_user_id, e.user_id, e.first_name, e.last_name, n.id AS status_id, n.note_name, n.module, n.color, u.username
					FROM inventory_assignment a
					LEFT JOIN end_user e ON a.end_user = e.id
					LEFT JOIN note n ON a.status = n.id
					LEFT JOIN users u ON e.user_id = u.id
					ORDER BY a.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}


		/* Insert inventory assignment record (inventory-assignment.php) */
		public function insertAssignment($endUser) {
			$date_added = date("Y-m-d H:i:s");
			
			$query = "INSERT INTO inventory_assignment (end_user, date_added) VALUES (?, ?)";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $endUser, $date_added);
				$stmt->execute();
				$assignment_id = $stmt->insert_id;
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}

			$endUser = $this->getEndUserDetailByID($endUser);
			$endUserName = $endUser['username'];

			$logMessage = " have new <b>Inventory assignment</b>.";
			$account_id = $_SESSION['sess'];
		
			$this->logTransaction('assignment', 'INSERT', $assignment_id, $endUserName, $account_id, $logMessage);
			
			return $assignment_id;
		}

		/* Archive inventory assignment record function (inventory-assignment.php) */
		public function archiveAssignment($assignment_id) {
			$assignmentInfo = $this->getAssignmentDetailById($assignment_id);
			$endUserId = $assignmentInfo['end_user_id'];
			$endUserName = $assignmentInfo['username'];
			$statusId = $assignmentInfo['status_id'];
			$statusName = $assignmentInfo['note_name'];
			$date_added = $assignmentInfo['date_added'];
			$date_archived = date("Y-m-d H:i:s");
		
			$query = "INSERT INTO inventory_assignment_archive (assignment_id, end_user, status, date_added, date_archived) VALUES (?, ?, ?, ?, ?)";
		
			if ($stmt = $this->conn->prepare($query)) {
				// Combine ID and name into separate variables before passing them to bind_param
				$endUser = $endUserId . ' ' . $endUserName;
				$status = $statusId . ' ' . $statusName;
				
				// Adjust bind_param types to match combined variables
				$stmt->bind_param("issss", $assignment_id, $endUser, $status, $date_added, $date_archived);
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
		
			$logMessage = "'s inventory assignment record has been archived.";
			$account_id = $_SESSION['sess'];
			$this->logTransaction('assignment', 'ARCHIVE', $assignment_id, $endUserName, $account_id, $logMessage);
		
			$this->archiveAssignmentItems($assignment_id); // Then archive the items belong to assignment record 
		}
		
		
		/* Archive inventory assignment items function (ics.php) */
		private function archiveAssignmentItems($assignment_id) {
			$assignmentItems = $this->getAssignmentItemsById($assignment_id);

			$insertQuery = "INSERT INTO inventory_assignment_archive_items (assignment_id, property_no, description, unit, qty, unit_cost, total_cost, acquisition_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		
			if ($insertStmt = $this->conn->prepare($insertQuery)) {
				if (!empty($assignmentItems)) {
					foreach ($assignmentItems as $items) {
						$property_no = $items['property_no'];
						$description = $items['description'];
						$unit = $items['unit'];
						$qty = $items['qty'];
						$unit_cost = $items['unit_cost'];
						$total_cost = $items['total_cost'];
						$acquisition_date = $items['acquisition_date'];
		
						$insertStmt->bind_param("isssssss", $assignment_id, $property_no, $description, $unit, $qty, $unit_cost, $total_cost, $acquisition_date);
						$insertStmt->execute();
					}
				}
				$insertStmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
			$this->deleteAssignment($assignment_id);
		}

		/* Delete assignment record after succesfull moving to archive */
		public function deleteAssignment($assignment_id) {
			$query = "DELETE FROM inventory_assignment WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$stmt->close();
			}
		}


		/* Get inventory assignment detail based on id (inventory-assignment.php) */
		public function getAssignmentDetailById($assignment_id) {
			$data = null;
			$query = "SELECT i.id AS assignment_id, i.end_user, i.status, i.date_added,
						e.id AS end_user_id, user_id, e.first_name, e.last_name,
						n.id AS status_id, n.note_name, n.module, n.color,
						u.username
				FROM inventory_assignment i
				LEFT JOIN end_user e ON i.end_user = e.id
				LEFT JOIN note n ON i.status = n.id
				LEFT JOIN users u ON e.user_id = u.id
				WHERE i.id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}
		
		
		/* Check if Assignment ID already exist in assignment record (archive-assignment.php) */
		public function checkAssignmentIdExist($assignment_id) {
			$data = null;
			$query = "SELECT * FROM inventory_assignment WHERE id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		/*=========================================================
				INVENTORY ASSIGNMENT ADDED ITEMS 
		==========================================================*/

		/* Check the property item status of specific assignment id (inventory-assignment-add) */
		public function checkAssignmentItemStatus($assignment_id, $property_no) {
			$data = null;
			$query = "SELECT * FROM inventory_assignment_item WHERE assignment_id = ? AND property_no = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $assignment_id, $property_no);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Update property item if qty > 0 (inventory-assignment-add) */
		public function updateAssignmentPropertyItem($location, $updated_qty, $total_cost, $assignment_id, $property_no, $endUser, $description, $unit, $end_user_id) {
			$query = "UPDATE inventory_assignment_item SET location = ?, qty = qty + ?, total_cost = total_cost + ? WHERE assignment_id = ? AND property_no = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sidis", $location, $updated_qty, $total_cost, $assignment_id, $property_no);
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
			$logMessage = " '$updated_qty $unit' has been added to <b>$endUser</b>.";

			$this->logTransaction('end_user', 'UPDATE', $endUser, $description, $end_user_id, $logMessage);
		}

		

		/* Update / return Qty per physical count to inventory record (inventory-assignment-add && create)*/
		public function updateInventoryQtyPcountAfterAssigned($updated_qtyPcount, $property_no) {
			$query = "UPDATE inventory SET qty_pcount = ? WHERE property_no = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $updated_qtyPcount, $property_no);
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
		}

		/* Insert new property assignment if property no doesn't exist in assignment ID (inventory-assignment-add) X*/
		public function insertAssignmentPropertyItem($assignment_id, $property_no, $description, $location, $unit, $updated_qty, $unit_cost, $total_cost, $acquisition_date, $end_user_name, $end_user_id) {
			$query = "INSERT INTO inventory_assignment_item (assignment_id, property_no, description, location, unit, qty, unit_cost, total_cost, acquisition_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("issssssss", $assignment_id, $property_no, $description, $location, $unit, $updated_qty, $unit_cost, $total_cost, $acquisition_date);
				$stmt->execute();
				$stmt->close();

				$logMessage = "'s  '$updated_qty $unit' has been assigned to <b>$end_user_name</b>.";

				$this->logTransaction('inventory', 'INSERT', $property_no, $description, $end_user_id, $logMessage);
			} else {
				die('Error: ' . $this->conn->error);
			}
		}

	
		
		/*========================================
			INVENTORY ASSIGNMENT EDIT ITEMS
		==========================================*/

		// get assignment property items based on id (inventory-assignment-edit)
		public function getAssignmentPropertyItems($assignment_id) {
			$data = null;
			$query = "SELECT * FROM inventory_assignment_item WHERE assignment_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		// Function to add inventory quantity back to qty_pcount (inventory-assignment-edit)
		public function addInventoryQtyPcountFromAssignment($property_no, $qty, $assignment_id) {
			$query = "UPDATE inventory SET qty_pcount = qty_pcount + ? WHERE property_no = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $qty, $property_no);
				$stmt->execute();
				$stmt->close();
			}

			$inventories = $this->getInventoryDetailByPropertyNo($property_no);
			$description = $inventories['description'];
			$unit = $inventories['unit'];
			
			$unitDetail = $this->getUnitDetailByID($unit);
			$unitName = $unitDetail['unit_name'];

			$assignment_detail = $this->getAssignmentDetailById($assignment_id);
			$endUserName = $assignment_detail['username'];

			$logMessage = "'s, '$qty $unitName' has been returned to inventory record from <b>$endUserName inventory assignment</b>.";
			$account_id = $_SESSION['sess'];

			$this-> logTransaction('inventory', 'RETURNED', $property_no, $description, $account_id, $logMessage);
		}

		// Delete assignment items if returned/unchecked (inventory-assignment-edit)
		public function deleteAssignmentItems($property_no, $assignment_id) {

			$inventories = $this->getInventoryDetailByPropertyNo($property_no);
			$description = $inventories['description'];
			$inv_id = $inventories['inv_id'];
	
			$assignment_detail = $this->getAssignmentDetailById($assignment_id);
			$endUserId = $assignment_detail['end_user_id'];
			$endUsername = $assignment_detail['username'];
	
			$logMessage = "'s has been removed from <b>$endUsername assignments</b>.";
	
			$this->logTransaction('assignment', 'DELETE', $property_no, $description, $endUserId, $logMessage);
	
			$query = "DELETE FROM inventory_assignment_item WHERE property_no = ? AND assignment_id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $property_no, $assignment_id); 
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
		}

		//UPDATE INVENTORY RECORD (inventory-asignment-edit.php)
		public function updateAssignmentItemsQty($assignment_id, $property_no, $newQty, $qty) {

			if($newQty == 0) {
				$cost = 1;
			} else {
				$cost = $newQty;
			}

			$query = "UPDATE inventory_assignment_item SET qty = ?, total_cost = unit_cost * ? WHERE assignment_id = ? AND property_no = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("iiis", $newQty, $cost, $assignment_id, $property_no);
				$stmt->execute();
				$stmt->close();
			}

			$inventories = $this->getInventoryDetailByPropertyNo($property_no);
			$description = $inventories['description'];
			$unit = $inventories['unit_name'];
			
			$assignment_detail = $this->getAssignmentDetailById($assignment_id);
			$endUserName = $assignment_detail['username'];
			$endUserId = $assignment_detail['end_user_id'];

			$logMessage = "'s from <b>$endUserName Inventory assignment</b> has been updated. From '$qty $unit' to '$newQty $unit'.";

			$this-> logTransaction('assignment', 'UPDATE', $assignment_id, $description, $endUserId, $logMessage);
		}

		/* Update the location of assigned property (inventory-assignment-edit.php) */
		public function updateAssignmentItemsLocation($assignment_id, $property_no, $newLocation, $location) {

			$query = "UPDATE inventory_assignment_item SET location = ? WHERE assignment_id = ? AND property_no = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sis", $newLocation, $assignment_id, $property_no);
				$stmt->execute();
				$stmt->close();
			}

			$inventories = $this->getInventoryDetailByPropertyNo($property_no);
			$description = $inventories['description'];
			$unit = $inventories['unit'];
			
			$assignment_detail = $this->getAssignmentDetailById($assignment_id);
			$endUser = $assignment_detail['username'];
			$endUserId = $assignment_detail['end_user_id'];

			$logMessage = "'s from <b>$endUser Inventory assignment</b> has been updated. Location:  '$location' to '$newLocation'.";

			$this-> logTransaction('assignment', 'UPDATE', $assignment_id, $description, $endUserId, $logMessage);
		}
	

		/*===========================================
					Assignment Acitivity logs
		============================================*/


		/* Log Inventory custodian slip archive restore transaction function (archive-assignment) */
		public function logAssignmentRestoreTransaction($assignment_id, $endUser, $date_archived) {
			$logMessage = "'s inventory assignment record has been restored, where archived last <b>$date_archived</b> in Inventory Assignment archives.";
			$account_id = $_SESSION['sess'];
			
			$this->logTransaction('assignment', 'INSERT', $assignment_id, $endUser, $account_id, $logMessage);
		}

		
		/*====================================================================
							INVENTORY ASSIGNMENT ARCHIVES
		====================================================================*/

		/* Get or display all inventory assignment archive (archive-assignment) */
		public function getAssignmentArchives() {
			$data = null;
			$query = "SELECT * FROM inventory_assignment_archive ";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		// Get assigned items of archive assignment (archive-assignment)
		public function getAssignmentItemsArchives($assignment_id) {
			$data = null;
			$query = "SELECT * FROM inventory_assignment_archive_items WHERE assignment_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		
		// Restore arhived assignment (archive-assignment)
		public function restoreAssignment($assignment_id, $end_user, $date_added, $archive_id) {
			$date_added = date("Y-m-d H:i:s");
			$status = "0";

			$query = "INSERT INTO inventory_assignment (id, end_user, status, date_added) VALUES (?, ?, ?, ?)";

			if ($restoreStmt = $this->conn->prepare($query)) {
				$restoreStmt->bind_param("iiss", $assignment_id, $end_user, $status, $date_added);
				$restoreStmt->execute();
				$restoreStmt->close();
			}
					
			$this->restoreAssignmentItems($assignment_id);		
		}

		private function restoreAssignmentItems($assignment_id) {
			$assignmentItems = $this->getAssignmentItemsArchives($assignment_id);
		
			$query = "INSERT INTO inventory_assignment_item (assignment_id, property_no, description, unit, qty, unit_cost, total_cost, acquisition_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		
			if ($insertStmt = $this->conn->prepare($query)) {
				if (!empty($assignmentItems)) {
					foreach ($assignmentItems as $assignmentItem) {
						$property_no = $assignmentItem['property_no'];
						$description = $assignmentItem['description'];
						$unit = $assignmentItem['unit'];
						$qty = $assignmentItem['qty'];
						$unit_cost = $assignmentItem['unit_cost'];
						$total_cost = $assignmentItem['total_cost'];
						$acquisition_date = $assignmentItem['acquisition_date'];
						$insertStmt->bind_param("isssssss", $assignment_id, $property_no, $description, $unit, $qty, $unit_cost, $total_cost, $acquisition_date);
						$insertStmt->execute();
					}
				}
				$insertStmt->close();
						
				$deleteQuery = "DELETE FROM inventory_assignment_archive WHERE assignment_id = ?";
	
				if ($stmt = $this->conn->prepare($deleteQuery)) {
					$stmt->bind_param("i", $assignment_id);
					$stmt->execute();
					$stmt->close();
				} 
					
			} else {
				die('Error: ' . $this->conn->error);
			}
		}
		
		
		  /*==================================================================//
		 //			        END USER FUNCTION MODEL 		     		     //
		//==================================================================*/

		/*===========================================
				END USERS PRIMARY CRUD
		===========================================*/

		public function createEndUser($username, $firstName, $middleName, $lastName, $birthday, $sex, $email, $password, $contact, $designation) {
			
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$dateCreated = date("Y-m-d H:i:s");
			$user_role = '3'; // end_user role
		
			$query = "INSERT INTO users (role_id, username, password, date_created) VALUES (?, ?, ?, ?)";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("isss", $user_role, $username, $hashedPassword, $dateCreated);
				if (!$stmt->execute()) {
					$stmt->close();
					return false; 
				}
				$user_id = $this->conn->insert_id;  // Get the inserted user's ID
				$stmt->close();
			} else {
				return false; 
			}
		
			// Now insert the end_user using the user_id from the 'users' table
			$query = "INSERT INTO end_user (user_id, first_name, middle_name, last_name, email, contact, designation, sex, birthday, status, date_registered) 
					  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$statusActive = '1';
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("issssiissis", $user_id, $firstName, $middleName, $lastName, $email, $contact, $designation, $sex, $birthday, $statusActive, $dateCreated);
				if ($stmt->execute()) {
					$stmt->close();
		
					// Log transaction
					$logMessage = "'s has been added to <b>End User</b> records.";
					$accountId = $_SESSION['sess'];
					$endUserName = $firstName . ' ' . $lastName;
					$this->logTransaction('end_user', 'INSERT', $endUserName, $endUserName, $accountId, $logMessage);
		
					return true;
				} else {
					$stmt->close();
					return false; 
				}
			}
		
			return false;
		}
		
		

		/* checked if the username is already exist */
		public function usernameExists($username) {
			$query = "SELECT COUNT(*) FROM users WHERE username = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $username);
				$stmt->execute();
				$stmt->bind_result($count);
				$stmt->fetch();
				$stmt->close();
				
				return $count > 0;
			} else {
				// Handle error
				return false;
			}
		}	
		
		
		/* Get/Display all end users data (end-user.php) */
		public function getEndUser() {
			$data = null;
			$query = "SELECT e.id AS end_user_id, e.user_id, e.first_name, e.middle_name, e.last_name, e.email, e.contact, e.designation, e.sex, e.birthday, e.status, e.date_registered, d.id AS designation_id, d.designation_name, u.id AS user_id, u.role_id, u.username, u.password, u.date_created  
				FROM end_user e
				LEFT JOIN designation d ON e.designation = d.id
				LEFT JOIN users u ON e.user_id = u.id
				ORDER BY e.date_registered  DESC";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}


		/* Update End user data (end-user.php) */
		public function updateEndUser($username, $firstName, $middleName, $lastName, $birthday, $sex, $email, $contact, $designation, $endUser_id) {
			
			$query = "UPDATE users SET username = ? WHERE id = (SELECT user_id FROM end_user WHERE id = ?)";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $username, $endUser_id);
				$stmt->execute();
				$stmt->close();
			}
		
			$query = "UPDATE end_user SET first_name = ?, middle_name = ?, last_name = ?, email = ?, contact = ?, designation = ?, sex = ?, birthday = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ssssiissi", $firstName, $middleName, $lastName, $email, $contact, $designation, $sex, $birthday, $endUser_id);
				$stmt->execute();
				$stmt->close();
			}
		}
		

		/* Update End user data (end-user.php) */
		public function updateEndUserStatus($status, $endUser_id) {
			// Get current user details
		
			$query = "UPDATE end_user SET status = ? WHERE id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ii", $status, $endUser_id);
				$stmt->execute();
				$stmt->close();
			} else {
				echo "Error: " . $this->conn->error;
			}
		}

		/* Get end user by Id (report-assignment && end-user) */
		public function getEndUserDetailByID($endUser_id) {
			$data = null;
			$query = "SELECT e.*, d.id AS designation_id, d.designation_name, u.username
					FROM end_user e
					LEFT JOIN designation d ON e.designation = d.id
					LEFT JOIN users u ON e.user_id = u.id
					WHERE e.id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $endUser_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		/* Get all inventory detail belong to particular End User (report-assignment.php)*/
		public function getEndUserAssignment($endUser) {
			$data = null;
			$query = "SELECT a.*, i.*, e.*
				FROM inventory_assignment i
				LEFT JOIN inventory_assignment_item a ON i.id = a.assignment_id
				LEFT JOIN end_user e ON i.end_user = e.id
				WHERE i.end_user = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $endUser);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		
		/* Get all inventory assignments to end user (report-assignment.php) */
		public function getAllInventoryAssignment() {
			$data = null;
			$query = "SELECT a.*, i.*, e.*, u.username
					FROM inventory_assignment a
					LEFT JOIN inventory_assignment_item i ON a.id = i.assignment_id
					LEFT JOIN end_user e ON a.end_user = e.id
					LEFT JOIN users u ON e.user_id = u.id
					ORDER BY a.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		

		/*===========================================
				End Users Acitivity logs
		============================================*/

		/* Log Fund Cluster update transaction function */
		public function logEndUserUpdateTransaction($oldValues, $newValues) {
			$logMessage = " end user's record has been updated. ";
			$account_id = $_SESSION['sess'];
			$endUsername = $newValues['username'];
			
			$changes = array();
			
			// Check if the End user name is changed
			if ($oldValues['username'] != $newValues['username']) {
				$changes[] = "Username changed from '{$oldValues['username']}' to '{$newValues['username']}'";
			}

			// Check if the End user first name is changed
			if ($oldValues['first_name'] != $newValues['firstname']) {
				$changes[] = "First name changed from '{$oldValues['first_name']}' to '{$newValues['firstname']}'";
			}

			// Check if the End user middle name is changed
			if ($oldValues['middle_name'] != $newValues['middlename']) {
				$changes[] = "Middle name changed from '{$oldValues['middle_name']}' to '{$newValues['middlename']}'";
			}
			
			// Check if the End user last name is changed
			if ($oldValues['last_name'] != $newValues['lastname']) {
				$changes[] = "Last name changed from '{$oldValues['last_name']}' to '{$newValues['lastname']}'";
			}

			// Check if the birthday is changed
			if ($oldValues['birthday'] != $newValues['birthday']) {
				$changes[] = "Birthday changed from '{$oldValues['birthday']}' to '{$newValues['birthday']}'";
			}

			// Check if the sex is changed
			if ($oldValues['sex'] != $newValues['sex']) {
				$changes[] = "Sex changed from '{$oldValues['sex']}' to '{$newValues['sex']}'";
			}

			// Check if the email is changed
			if ($oldValues['email'] != $newValues['email']) {
				$changes[] = "Email changed from '{$oldValues['email']}' to '{$newValues['email']}'";
			}

			// Check if the contact is changed
			if ($oldValues['contact'] != $newValues['contact']) {
				$changes[] = "Contact updated from '{$oldValues['contact']}' to '{$newValues['contact']}'";
			}

			// Check if the designation is changed
			if ($oldValues['designation'] != $newValues['designation']) {
				$changes[] = "Designation updated from '{$oldValues['designation']}' to '{$newValues['designation']}'";
			}
			
			if (!empty($changes)) {
				$logMessage = $logMessage . implode(', ', $changes);

				$this->logTransaction('end_user', 'UPDATE', $endUsername, $endUsername, $account_id, $logMessage);
			}	
		}


		 /*==================================================================//
		 				      CATEGORIES FUNCTION MODEL 		     		 
		//==================================================================*/

		/*===========================================
					Category Fetch  Detail
		============================================*/
		
		/* Get all category details (inventory || category.php)*/
		public function displayCategories() {
			$data = null;
			$query = "SELECT * FROM category ORDER BY id DESC";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get category detail by Category id (category-view && report)*/
		public function getCategoryDetailByID($category_id) {
			$data = null;
			$query = "SELECT * FROM category WHERE id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $category_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		/* Get all inventory detail belong to category name (category-view.php)*/
		public function getCategoryInventories($category_id) {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			WHERE i.category = ? 
			ORDER BY i.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $category_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/*===========================================
				CATEGORIES PRIMARY CRUD
		===========================================*/

		/* Insert new category record (category.php) */
		public function insertCategory($category_name) {
			$query = "INSERT INTO category (category_name) VALUES (?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $category_name);
				$stmt->execute();
				$stmt->close();
			}

			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been added to the Category records.";
			
			$this->logTransaction('category', 'INSERT', $category_name, $category_name, $account_id, $logMessage); //Log transaction
		}

		/* Get/Display all category record with inventory counts (category.php) */
		public function displayCategoriesWithCount() {
			$data = null;
			
			$query = "SELECT c.id, c.category_name, COUNT(i.inv_id) AS inventory_count
					FROM category c
					LEFT JOIN inventory i ON c.id = i.category
					GROUP BY c.id, c.category_name
					ORDER BY c.id DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}


		/* Update category record (category.php) */
		public function updateCategory($category_name, $category_id) {
			$query = "UPDATE category SET category_name = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $category_name, $category_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Delete category record (category.php) */
		public function deleteCategory($category_id) {
			$category = $this->getCategoryDetailByID($category_id);
			$category_name = $category['category_name']; 
			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been deleted from Category records.";
			
			$this->logTransaction('category', 'DELETE', $category_name, $category_name, $account_id, $logMessage); //Log transaction

			$query = "DELETE FROM category WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $category_id);
				$stmt->execute();
				$stmt->close();
			}
		}


		/*===========================================
					Category Acitivity logs
		============================================*/

		/* Log Fund Cluster update transaction function */
		public function logCategoryUpdateTransaction($oldValues, $newValues) {
			$logMessage = "'s record has been updated. ";
			$account_id = $_SESSION['sess'];
			$category_name = $oldValues['category_name'];
			
			$changes = array();
			
			// Check if the Category name is changed
			if ($oldValues['category_name'] !== $newValues['category_name']) {
				$changes[] = "Category name changed from '{$oldValues['category_name']}' to '{$newValues['category_name']}'";
			}
			
			if (!empty($changes)) {
				$logMessage = $logMessage . implode(', ', $changes);

				$this->logTransaction('category', 'UPDATE', $category_name, $category_name, $account_id, $logMessage);
			}	
		}

		/* ========================================================
					 ARTICLE FUNCTION MODEL
		========================================================= */
		/* ==================================
					ARTICLE QUERY
		=================================== */

		/* Get all articlle record (inventory.php) */
		public function getArticles() {
			$data = null;
			$query = "SELECT * FROM article ORDER BY id DESC";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		/* Get articfle detail by article id */
		public function getArticleDetailByID($article_id) {
			$data = null;
			$query = "SELECT * FROM article WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $article_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		/* Get all inventory detail belong to article name (article-view.php)*/
		public function getArticleInventories($article_id) {
			$data = null;
			$query = "SELECT i.*, a.id AS article_id, a.article_name
			FROM inventory i
			LEFT JOIN article a ON i.article = a.id
			WHERE i.article = ? 
			ORDER BY i.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $article_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get/Display all article record with inventory counts (article.php) */
		public function displayArticleWithCount() {
			$data = null;
			
			$query = "SELECT a.id, a.article_name, COUNT(i.inv_id) AS inventory_count
					FROM article a
					LEFT JOIN inventory i ON a.id = i.article
					GROUP BY a.id, a.article_name
					ORDER BY a.id DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* ==================================
					ARTICLE CRUD
		==================================== */

		/* Insert new article record (article.php) */
		public function insertArticle($article_name) {
			$query = "INSERT INTO article (article_name) VALUES (?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $article_name);
				$stmt->execute();
				$stmt->close();
			}

			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been added to the Article records.";
			
			$this->logTransaction('article', 'INSERT', $article_name, $article_name, $account_id, $logMessage); //Log transaction
		}

		/* Update Article record (article.php) */
		public function updateArticle($article_name, $article_id) {
			$query = "UPDATE article SET article_name = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $article_name, $article_id);
				$stmt->execute();
				$stmt->close();
			}
		}


		/* Delete article record (article.php) */
		public function deleteArticle($article_id, $article_name) {
			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been deleted from Article records.";
			
			$this->logTransaction('article', 'DELETE', $article_name, $article_name, $account_id, $logMessage); //Log transaction

			$query = "DELETE FROM article WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $article_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/*===========================================
					Article Acitivity logs
		============================================*/

		/* Log Fund Cluster update transaction function */
		public function logArticleUpdateTransaction($oldValues, $newValues) {
			$logMessage = "'s record has been updated. ";
			$account_id = $_SESSION['sess'];
			$article_name = $oldValues['article_name'];
			
			$changes = array();
			
			// Check if the Category name is changed
			if ($oldValues['article_name'] !== $newValues['article_name']) {
				$changes[] = "Article name changed from '{$oldValues['article_name']}' to '{$newValues['article_name']}'";
			}
			
			if (!empty($changes)) {
				$logMessage = $logMessage . implode(', ', $changes);

				$this->logTransaction('article', 'UPDATE', $article_name, $article_name, $account_id, $logMessage);
			}	
		}


		/*========================================================
		 		        LOCATION FUNCTION MODEL 		     		
		=========================================================*/

		/*===========================================
					Location Fetch  Detail
		============================================*/

		/* Get all location data (inventory.php)*/
		public function getLocations() {
			$data = null;
			$getLocation = "SELECT * FROM location ORDER BY id DESC";
			
			if ($stmt = $this->conn->prepare($getLocation)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		/* Get location detail by Location id (location-view && report)*/
		public function getLocationDetailsById($location_id) {

			$query = "SELECT * FROM location WHERE id = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $location_id);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($row = $result->fetch_assoc()) {
					return $row;
				}
				$stmt->close();
			}
			return null;
		}

		/* Get all inventory detail belong to location name (location-view.php)*/
		public function getInventoryLocations($location_id) {
			$data = null;
			$query = "SELECT i.*, l.*, c.* 
					  FROM inventory i 
					  LEFT JOIN location l ON i.location = l.id
					  LEFT JOIN category c ON i.category = c.id
					  WHERE i.location = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $location_id);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		

		/*===========================================
				LOCATIONS PRIMARY CRUD
		===========================================*/
		
		/* Insert new location record (location.php) */
		public function insertLocation($location_name) {
			$insertLocation = "INSERT INTO location (location_name) VALUES (?)";

			if ($stmt = $this->conn->prepare($insertLocation)) {
				$stmt->bind_param("s", $location_name);
				$stmt->execute();
				$stmt->close();
			}

			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been added to the Location record.";
			
			$this->logTransaction('location', 'INSERT', $location_name, $location_name, $account_id, $logMessage); //Log transaction
		}


		/* Get/Display all location record with inventory counts (location.php) */
		public function getLocationWithCounts() {
			$data = null;
			
			$locationQuery = "SELECT l.id AS location_id, l.location_name, COUNT(i.inv_id) AS inventory_count
					FROM location l
					LEFT JOIN inventory i ON l.id = i.location
					GROUP BY l.id, l.location_name
					ORDER BY l.id DESC";

			if ($stmt = $this->conn->prepare($locationQuery)) {
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Update location record (location.php) */
		public function updateLocation($location_name, $location_id) {
			$updateLocation = "UPDATE location SET location_name = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($updateLocation)) {
				$stmt->bind_param("si", $location_name, $location_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Delete location record (location.php) */
		public function deleteLocation($location_id) {
			$location = $this->getLocationDetailsById($location_id);
			$location_name = $location['location_name']; 
			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been deleted from Location records.";
			
			$this->logTransaction('location', 'DELETE', $location_name, $location_name, $account_id, $logMessage); //Log transaction

			$query = "DELETE FROM location WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $location_id);
				$stmt->execute();
				$stmt->close();
			}
		}


		/*===========================================
					Location Acitivity logs
		============================================*/

		/* Log Fund Cluster update transaction function */
		public function logLocationUpdateTransaction($oldValues, $newValues) {
			$logMessage = "'s record has been updated. ";
			$account_id = $_SESSION['sess'];
			$location_name = $oldValues['location_name'];
			
			$changes = array();
			
			// Check if the location name is changed
			if ($oldValues['location_name'] !== $newValues['location_name']) {
				$changes[] = "Location name changed from '{$oldValues['location_name']}' to '{$newValues['location_name']}'";
			}
			
			if (!empty($changes)) {
				$logMessage = $logMessage . implode(', ', $changes);

				$this->logTransaction('location', 'UPDATE', $location_name, $location_name, $account_id, $logMessage);
			}	
		}
		

		 /*==================================================================//
		 				      COMPONENTS FUNCTION MODEL 		     		 
		//==================================================================*/

		/*===========================================
					Estimated Useful Life
		============================================*/

		/* Get/Display all estmated useful life details (customize.php && custom-est-life.php)*/
		public function displayEstLife() {
			$data = null;
			$query = "SELECT * FROM estimated_life ORDER BY id DESC";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get estimated useful life details by ID */
		public function getEstLifeDetailByID($estlife_id) {
			$data = null;
			$query = "SELECT * FROM estimated_life WHERE id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $estlife_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		/* Insert new estimated useful life record (custom-est-life.php) */
		public function insertEstLife($estlife_name) {
			$query = "INSERT INTO estimated_life (est_life) VALUES (?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $estlife_name);
				$stmt->execute();
				$stmt->close();
			}

			$account_id = $_SESSION['sess'];
			$logMessage = " has been added to Estimated useful life records.";
			
			$this->logTransaction('component', 'INSERT', $estlife_name, $estlife_name, $account_id, $logMessage); //Log transaction
		}

		/* Delete estimated useful life record (custom-est-life.php) */
		public function deleteEstLife($estlife_id) {
			$estlife = $this->getEstLifeDetailByID($estlife_id);
			$estlife_name = $estlife['est_life'];
			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been deleted from Estimated useful life records.";
			
			$this->logTransaction('component', 'DELETE', $estlife_name, $estlife_name, $account_id, $logMessage); //Log transaction
		
			$query = "DELETE FROM estimated_life WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $estlife_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/*=======================================================
		Status and Remarks (customize.php && custom-est-life.php)
		========================================================*/

		/* Get status and remarks details by ID */
		public function getNoteDetailByID($note_id) {
			$data = null;
			$query = "SELECT * FROM note WHERE id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $note_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		/* Display notes from particular modulde (inventory.php, ics.php, par.php) */
		public function displayModuleNotes($module) {
			$data = null;
			$query = "SELECT * FROM note WHERE module = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $module);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get/Display notes from particular modulde name */
		public function displayInvNotes($module, $note_name) {
			$data = null;
			$query = "SELECT * FROM note WHERE module = ? AND note_name = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $module, $note_name);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get particular note detail (report-inventory.php) */
		public function getNoteDetail($module, $note_name) {
			$data = null;
			$query = "SELECT * FROM note WHERE module = ? AND note_name = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $module, $note_name);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc(); // Fetch only the first result
				$stmt->close();
			}
			return $data;
		}

		/* Get/Display all status and remarks details */
		public function displayNotes() {
			$data = null;
			$query = "SELECT * FROM note ORDER BY module ASC";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Insert new status and remarks record */
		public function insertNote($note_name, $module, $color) {
			$query = "INSERT INTO note (note_name, module, color) VALUES (?, ?, ?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sss", $note_name, $module, $color);
				$stmt->execute();
				$stmt->close();
			}

			$account_id = $_SESSION['sess'];
			$logMessage = " note for " . strtoupper($module) . " module has been added to status and remark records.";
			
			$this->logTransaction('component', 'INSERT', $note_name, $note_name, $account_id, $logMessage); //Log transaction
		}

		/* Delete status and ramark record */
		public function deleteNote($note_id) {
			$note = $this->getNoteDetailByID($note_id);
			$note_name = $note['note_name'];
			$module = $note['module'];
			$account_id = $_SESSION['sess'];
			$logMessage = "'s in " . strtoupper($module) . " module has been deleted from status and remark records.";
			
			$this->logTransaction('component', 'DELETE', $note_name, $note_name, $account_id, $logMessage); //Log transaction
		
			$query = "DELETE FROM note WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $note_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/*===========================================================
			Unit of Measurement (customize.php && custom-unit.php)
		============================================================*/

		/* Get estimated useful life details by ID */
		public function getUnitDetailByID($unit_id) {
			$data = null;
			$query = "SELECT * FROM unit WHERE id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $unit_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		/* Insert new unit of measurement record */
		public function insertUnit($unit_name) {
			$query = "INSERT INTO unit (unit_name) VALUES (?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $unit_name);
				$stmt->execute();
				$stmt->close();
			}

			$account_id = $_SESSION['sess'];
			$logMessage = " has been added to Unit of measurement records.";
			
			$this->logTransaction('component', 'INSERT', $unit_name, $unit_name, $account_id, $logMessage); //Log transaction
		
		}

		//DISPLAY UNIT RECORD
		public function displayUnits() {
			$data = null;
			$query = "SELECT * FROM unit ORDER BY id DESC";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Delete unit of measurement record */
		public function deleteUnit($unit_id) {
			$unit = $this->getUnitDetailByID($unit_id);
			$unit_name = $unit['unit_name'];
			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been deleted from Unit of measurement records.";
			
			$this->logTransaction('component', 'DELETE', $unit_name, $unit_name, $account_id, $logMessage); //Log transaction
		
			$query = "DELETE FROM unit WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $unit_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Get total count of assignment (index.php) */
		public function getTotalAssignmentRecords() {
			// Assuming $this->conn is a valid database connection
			$query = "SELECT (SELECT COUNT(*) FROM inventory_assignment) AS total_assignment";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
		
				if ($result) {
					$row = $result->fetch_assoc();
					if ($row) {
						$totalRecords = $row['total_assignment'];
						$stmt->close();
						return $totalRecords;
					} else {
						$stmt->close();
						throw new Exception("No records found.");
					}
				} else {
					$stmt->close();
					throw new Exception("Error retrieving result set.");
				}
			} else {
				// Handle case where prepare returns false
				throw new Exception("Error preparing statement: " . $this->conn->error);
			}
		}

		/*===========================================
					END USER DASHBOARD
		==========================================*/
		
		public function getTotalInventoryAssignedToUser($account_id) {
			$query = "SELECT SUM(i.qty) AS total_qty
					  FROM inventory_assignment a
					  LEFT JOIN inventory_assignment_item i ON a.id = i.assignment_id
					  WHERE a.end_user = ? AND i.qty > 0"; // Ensures only items with quantity > 0 are counted
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $account_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();
				$stmt->close();
		
				return $row['total_qty'] ?? 0; // Return 0 if no records found
			}
			return 0;
		}

		public function getTotalAssignmentToUser($account_id) {
			$query = "SELECT COUNT(*) as total_assignment FROM inventory_assignment
					  WHERE end_user = ?"; // Ensures only items with quantity > 0 are counted
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $account_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();
        		$totalRecords = $row['total_assignment'];
				$stmt->close();
				return $totalRecords ?? 0;
			}
			return 0;
		}

		public function getTotalLocationByEndUser($end_user_id) {
			$totalLocation = 0;
			$query = "SELECT COUNT(DISTINCT iai.location) AS total_categories
					  FROM inventory_assignment ia
					  INNER JOIN inventory_assignment_item iai ON iai.assignment_id = ia.id
					  WHERE ia.end_user = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $end_user_id);
				$stmt->execute();
				$stmt->bind_result($totalLocation);
				$stmt->fetch();
				$stmt->close();
			}
			return $totalLocation;
		}
		
		
		/*=============================================
						R E P O R T S
		=============================================*/

		/*==============================
			INVENTORY REPORTS
		==============================*/

		/* Get for inventory report a Specific remark from fromDate -> toDate */
		public function getInvSpecificRemarkSpecificDateReport($remarks, $fromDate, $toDate) {
			$data = null;
			$query = "SELECT i.*, a.id AS article_id, a.article_name, c.id AS category_id, c.category_name, e.id AS estlife_id, e.est_life AS estlife_name, u.id AS unit_id, u.unit_name, n.id AS note_id, n.module, n.note_name, n.color
				FROM inventory i 
				LEFT JOIN note n ON i.remark = n.id
				LEFT JOIN article a ON i.article = a.id
				LEFT JOIN category c ON i.category = c.id
				LEFT JOIN unit u ON i.unit = u.id
				LEFT JOIN estimated_life e ON i.est_life = e.id 
				WHERE i.remark = ? AND DATE(i.date_added) BETWEEN ? AND ?
				ORDER BY i.date_added ASC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sss", $remarks, $fromDate, $toDate);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		

		/* Get for inventory report a all remark from fromDate -> toDate */
		public function getInvAllRemarkSpecificDateReport($fromDate, $toDate) {
			$data = null;
			$query = "SELECT i.*, u.unit_name, e.est_life AS estlife_name, n.note_name, n.color, a.id AS article_id, a.article_name, c.id AS category_id, c.category_name
				FROM inventory i
				LEFT JOIN article a ON i.article = a.id
				LEFT JOIN category c ON i.category = c.id
				LEFT JOIN unit u ON i.unit = u.id
				LEFT JOIN estimated_life e ON i.est_life = e.id
				LEFT JOIN note n ON i.remark = n.id 
				WHERE DATE(i.date_added) BETWEEN ? AND ? ORDER BY i.date_added ASC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $fromDate, $toDate);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get for inventory report a all remark from fromDate -> toDate */
		public function getInvSpecificRemarkAllDateReport($remark) {
			$data = null;
			$query = "SELECT i.*, a.article_name, c.category_name, l.location_name, e.est_life AS estlife_name, u.unit_name, n.id AS note_id, n.note_name, n.color
				FROM inventory i
				LEFT JOIN article a ON i.article = a.id
				LEFT JOIN category c ON i.category = c.id
				LEFT JOIN location l ON i.location = l.id
				LEFT JOIN unit u ON i.unit = u.id
				LEFT JOIN estimated_life e ON i.est_life = e.id
				LEFT JOIN note n ON i.remark = n.id
				WHERE i.remark = ? 
				ORDER BY date_added ASC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $remark);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/*====================================
			INVENTORY ASSIGNMENT REPORTS
		====================================*/

		/* Get all inventory assignment of end user */
		public function getEndUserAssignmentReport($end_user, $fromDate, $toDate) {
			$data = null;
			$query = "SELECT i.*, c.*, e.user_id, u.username
					  FROM inventory_assignment i
					  LEFT JOIN inventory_assignment_item c ON i.id = c.assignment_id
					  LEFT JOIN end_user e ON i.end_user = e.id
					  LEFT JOIN users u ON e.user_id = u.id
					  WHERE i.end_user = ? AND DATE(i.date_added) BETWEEN ? AND ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sss", $end_user, $fromDate, $toDate);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}


		/* All end user assignment */
		public function getAllEndUserAssignmentReport($fromDate, $toDate) {
			$data = null;
			$query = "SELECT i.*, c.*, e.user_id, u.username
					  FROM inventory_assignment i
					  LEFT JOIN inventory_assignment_item c ON i.id = c.assignment_id
					  LEFT JOIN end_user e ON i.end_user = e.id
					  LEFT JOIN users u ON e.user_id = u.id
					  WHERE DATE(i.date_added) BETWEEN ? AND ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $fromDate, $toDate);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/*====================================
				CATEGORY REPORTS
		====================================*/

		
		/* Get for inventory report all category from fromDate -> toDate */
		public function getInventoryAllCategorySpecificDateReport($fromDate, $toDate) {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id
			 WHERE i.date_added BETWEEN ? AND ? ORDER BY i.category ASC";
			 
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $fromDate, $toDate);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get for inventory specific category from fromDate -> toDate */
		public function getInventorySpecificCategorySpecificDateReport($category, $fromDate, $toDate) {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id
			WHERE i.category = ? AND i.date_added BETWEEN ? AND ? ORDER BY i.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sss", $category, $fromDate, $toDate);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		/* Get for inventory specific category from fromDate -> toDate */
		public function getInventorySpecificCategoryAllDateReport($category) {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id
			WHERE i.category = ?
			ORDER BY i.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $category);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get all Inventory Data order by category from Database (report-category.php) */
		public function getAllInventoryOrderByCategory() {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id 
			ORDER BY i.date_added DESC";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		
		/*====================================
				LOCATION REPORTS
		====================================*/

		
		/* Get for inventory report all location from fromDate -> toDate */
		public function getInventoryAllLocationSpecificDateReport($fromDate, $toDate) {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id 
			WHERE i.date_added BETWEEN ? AND ? ORDER BY i.location ASC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $fromDate, $toDate);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get for inventory specific location from fromDate -> toDate */
		public function getInventorySpecificLocationSpecificDateReport($location, $fromDate, $toDate) {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id  
			WHERE i.location = ? AND i.date_added BETWEEN ? AND ? ORDER BY i.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sss", $location, $fromDate, $toDate);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		/* Get for inventory specific category from fromDate -> toDate */
		public function getInventorySpecificLocationAllDateReport($location) {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id
			WHERE i.location = ? ORDER BY i.date_added ASC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $location);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get all Inventory Data from Database (report-category.php) */
		public function getInventoryAllLocationAllDate() {
			$data = null;
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name AS remark_name, n.module, n.color
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id 
			ORDER BY i.location ASC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/*========================================================
					CONTENT MANAGEMENT FUNCTION MODEL 		     		
		=========================================================*/

		/*===========================================
				System Content Fetch  Detail
		============================================*/
		
		/* Get current logo filename (updateImage($newImageFullName)) */
		private function getCurrentLogoFileName() {
			$query = "SELECT logo_file FROM system_content WHERE id = 1";
	
			if ($result = $this->conn->query($query)) {
				$row = $result->fetch_assoc();
				return $row['logo_file'];
			}
			return null;
		}

		/* Get current logo background image filename  (system-content.php && ..index.php)*/
		private function getCurrentLoginBgFileName() {
			$query = "SELECT login_image FROM system_content WHERE id = 1";
	
			if ($result = $this->conn->query($query)) {
				$row = $result->fetch_assoc();
				return $row['login_image'];
			}
	
			return null;
		}

		/*===========================================
			CONTENT MANAGEMENT UPDATE FUNCTIONS
		===========================================*/

		/* Display system_content details */
		public function displayReportEdit() {
			$data = null;
			$query = "SELECT * FROM system_content WHERE id = 1";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				if ($row = $result->fetch_assoc()) {
					return $row;
				}
				$stmt->close();
			}
			return null;
		}
	
		/* Update system logo (system-content.php) */
		public function updateImage($newImageFullName) {
			$currentImageFullName = $this->getCurrentLogoFileName();
	
			if (!empty($currentImageFullName)) {
				$currentImagePath = "../assets/images/" . $currentImageFullName;
				if (file_exists($currentImagePath)) {
					unlink($currentImagePath);
				}
			}
	
			$query = "UPDATE system_content SET logo_file = ? WHERE id = 1";
	
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $newImageFullName);
				$stmt->execute();
				$stmt->close();
			} else {
				return $this->conn->error;
			}

			$update_name = "System logo";
			$account_id = $_SESSION['sess'];
			$logMessage = " has been updated.";
			
			$this->logTransaction('system_content', 'UPDATE', $update_name, $update_name, $account_id, $logMessage); //Log transaction
		}

		/* Update system name and address (system-content.php) */
		public function updateContent($sysname, $address) {
			$query = "UPDATE system_content SET sys_name = ?, address = ? WHERE id = 1";
	
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $sysname, $address);
				$stmt->execute();
				$stmt->close();
				return true;
			} else {
				return $this->conn->error;
			}
		}

		/* Update system background image (system-content.php) */
		public function updateLoginBg($newImageFullName) {
			$currentImageFullName = $this->getCurrentLoginBgFileName();
	
			if (!empty($currentImageFullName)) {
				$currentImagePath = "../assets/images/" . $currentImageFullName;
				if (file_exists($currentImagePath)) {
					unlink($currentImagePath);
				}
			}
	
			$query = "UPDATE system_content SET login_image = ? WHERE id = 1";
	
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $newImageFullName);
				$stmt->execute();
				$stmt->close();
			} else {
				return $this->conn->error;
			}

			$update_name = "System background image";
			$account_id = $_SESSION['sess'];
			$logMessage = " has been updated.";
			
			$this->logTransaction('system_content', 'UPDATE', $update_name, $update_name, $account_id, $logMessage); //Log transaction
		
		}

		/* Update system theme */
		public function updateSystemTheme($selectedTheme) {
			$query = "UPDATE system_content SET theme = ? WHERE id = 1";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $selectedTheme);
				$stmt->execute();
				$stmt->close();
				return true;
			} else {
				return false;
			}
		}


		/*===========================================
				Content Management Acitivity logs
		============================================*/

		/* Log system content update transaction function */
		public function logContentUpdateTransaction($oldValues, $newValues) {
			$logMessage = " has been updated. ";
			$account_id = $_SESSION['sess'];
			$system_name = "System content";
			
			$changes = array();
			
			// Check if the Category name is changed
			if ($oldValues['sys_name'] !== $newValues['sys_name']) {
				$changes[] = "System name updated from <span class="."fw-bold".">'{$oldValues['sys_name']}' </span> to <span class="."fw-bold".">'{$newValues['sys_name']}'</span>";
			}

			if ($oldValues['address'] !== $newValues['address']) {
				$changes[] = "Address has been updated from <span class="."fw-bold".">'{$oldValues['address']}' </span> to <span class="."fw-bold".">'{$newValues['address']}'</span>";
			}
			
			if (!empty($changes)) {
				$logMessage = $logMessage . implode(', ', $changes);

				$this->logTransaction('system_content', 'UPDATE', $system_name, $system_name, $account_id, $logMessage);
			}	
		}


		/*==================================================
					INVENTORY ASSIGNMENT VIEW 
		===================================================*/

		public function displayPropertyAsssignments($property_no) {
			$data = null;
		
			$query = "SELECT a.*, i.*, e.*, n.id AS status_id, n.note_name, n.module, n.color, u.username
					  FROM inventory_assignment a
					  LEFT JOIN inventory_assignment_item i ON a.id = i.assignment_id
					  LEFT JOIN end_user e ON a.end_user = e.id
					  LEFT JOIN note n ON a.status = n.id
					  LEFT JOIN users u ON e.user_id = u.id
					  WHERE i.property_no = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $property_no);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}


		// DISPLAY INVENTORY RECORD BASED ON ID (inventory-view.php)
		public function getInventoryByInvNo($inv_id) {
			$data = null;
			$query = "SELECT i.*, c.*, l.*, a.*, u.*, e.*, n.*
			FROM inventory i
			LEFT JOIN category c ON i.category = c.id
			LEFT JOIN location l ON i.location = l.id
			LEFT JOIN article a ON i.article = a.id
			LEFT JOIN unit u ON i.unit = u.id
			LEFT JOIN estimated_life e ON i.est_life = e.id
			LEFT JOIN note n ON i.remark = n.id 
			WHERE i.inv_id = ?
			ORDER BY i.date_added";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $inv_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		// DISPLAY INVENTORY RECORD BASED ON ID (inventory-view.php)
		public function getInventoryByInvId($inv_id) {
			$query = "SELECT i.*, c.id AS category_id, c.category_name, l.id AS location_id, l.location_name, a.id AS article_id, a.article_name, u.id AS unit_id, u.unit_name, e.id AS est_life_id, e.est_life, n.id AS remark_id, n.module, n.note_name, n.color
					  FROM inventory i
					  LEFT JOIN category c ON i.category = c.id
					  LEFT JOIN location l ON i.location = l.id
					  LEFT JOIN article a ON i.article = a.id
					  LEFT JOIN unit u ON i.unit = u.id
					  LEFT JOIN estimated_life e ON i.est_life = e.id
					  LEFT JOIN note n ON i.remark = n.id
					  WHERE i.inv_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $inv_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
				return $data;
			} else {
				return null;
			}
		}

		// DISPLAY INVENTORY RECORD BASED ON ID (inventory-assignment-add.php)
		public function getInventoryDetailsByInvId($inv_id) {
			$query = "SELECT i.*, c.id as category_id, c.category_name, l.id as location_id, l.location_name, u.id as unit_id, u.unit_name, e.id as est_life_id, e.est_life, n.id as note_id, n.note_name
					  FROM inventory i
					  LEFT JOIN category c ON i.category = c.id
					  LEFT JOIN location l ON i.location = l.id
					  LEFT JOIN unit u ON i.unit = u.id
					  LEFT JOIN estimated_life e ON i.est_life = e.id
					  LEFT JOIN note n ON i.remark = n.id
					  WHERE i.inv_id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $inv_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = [];
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
				return $data;
			} else {
				return [];
			}
		}

		//UPDATE INVENTORY RECORD (inventory-assignment-add)
		public function updateInventoryQtyPcount($updated_qtyPcount, $inv_id) {
			$query = "UPDATE inventory SET qty_pcount = ? WHERE inv_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $updated_qtyPcount, $inv_id);
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
		}

	
		/*=============================================
						I N V E N T O R Y
		=============================================*/

		public function getInventoryDetailByPropertyNo($property_no) {
			$data = null;
			$query = "SELECT i.*, u.id AS unit_id, u.unit_name, c.id AS category_id, c.category_name, a.id AS article_id, a.article_name, l.id AS location_id, l.location_name, e.id AS estlife_id, e.est_life, n.id AS note_id, n.note_name, n.color, n.module
					FROM inventory i
					LEFT JOIN unit u ON i.unit = u.id
					LEFT JOIN category c ON i.category = c.id
					LEFT JOIN article a ON i.article = a.id
					LEFT JOIN location l ON i.location = l.id
					LEFT JOIN estimated_life e ON i.est_life = e.id
					LEFT JOIN note n ON i.remark = n.id 
					WHERE i.property_no = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $property_no);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

	
		public function deleteAssignmentLog($assignment_id) {
			$query = "DELETE FROM history_log 
					WHERE module = ? AND item_no = ?";

			$module = 'assignment';

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $module, $assignment_id);
				$stmt->execute();
				$stmt->close();
			}
		}


	

		// DISPLAY INVENTORY RECORDS WITH RELATED INFORMATION (report-inventory)
		public function displayInventoryWithDetails() {
			$data = null;
			
			$query = "SELECT i.*, u.unit_name, a.article_name, c.category_name, e.est_life AS estlife_name, n.note_name, n.color
					FROM inventory i
					LEFT JOIN article a ON i.article = a.id
					LEFT JOIN unit u ON i.unit = u.id
					LEFT JOIN category c ON i.category = c.id
					LEFT JOIN estimated_life e ON i.est_life = e.id
					LEFT JOIN note n ON i.remark = n.id
					ORDER BY i.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}

				$stmt->close();
			}

			return $data;
		}

			
		// FETCH SELECTED INVENTORY
		public function getInventory($inv_id) {
			$data = null;
			$query = "SELECT * FROM inventory WHERE inv_id = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $inv_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		

		// FETCH ALL ARCHIVED (archive-inventory)
		public function getInventoryArchives() {
			$data = null;
			$query = "SELECT * FROM archive_inventory ";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		//DELETE INVENTORY FROM ARCHIVE RECORD (archive-inventory)
		public function deleteArchive($archive_id, $inv_id) {
			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been deleted from inventory archive.";

			$this->logTransaction('inventory', 'DELETE', $inv_id, $inv_id, $account_id, $logMessage);
			
			$deleteQuery = "DELETE FROM archive_inventory WHERE id = ?";

			if ($stmt = $this->conn->prepare($deleteQuery)) {
				$stmt->bind_param("i", $archive_id);
				$stmt->execute();
				$stmt->close();
			}		
			
		}	

		//DELETE INVENTORY FROM ARCHIVE RECORD (archive-assignment)
		public function deleteAssignmentArchive($archive_id, $end_user) {
			$account_id = $_SESSION['sess'];
			$logMessage = "'s <b>inventory assignment archive</b> has been deleted.";

			$endUserDetail = $this->getEndUserDetailByID($end_user);
			$endUserName = $endUserDetail['end_user_name'];

			$this->logTransaction('assignment', 'DELETE', $endUserName, $endUserName, $account_id, $logMessage);
			
			$deleteQuery = "DELETE FROM inventory_assignment_archive WHERE id = ?";

			if ($stmt = $this->conn->prepare($deleteQuery)) {
				$stmt->bind_param("i", $archive_id);
				$stmt->execute();
				$stmt->close();
			}		
			
		}	


		/* =================================================
							ARCHIVES
		================================================= */
		

		/*=============================================
						ACTIVITY LOGS
		=============================================*/

		// Log Inventory Transaction Function
		private function logTransaction($module, $transactionType, $item_no, $description, $account_id, $logMessage) {			
			$query = "INSERT INTO history_log (module, transaction_type, item_no, description, user_id, log_message, date_time) VALUES (?, ?, ?, ?, ?, ?, NOW())";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ssssis", $module, $transactionType, $item_no, $description, $account_id, $logMessage);
				$stmt->execute();
				$stmt->close();
			}
		}
	

		/* Get all record from history_log */
		public function displayHistoryLog() {
			$data = null;
			$query = "SELECT * FROM history_log ORDER BY date_time DESC";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		
		  /*==================================================================//
		 //			        END USER FUNCTION MODEL 		     		 //
		//==================================================================*/

		/*===========================================
				END USERS PRIMARY CRUD
		===========================================*/

		/*===========================================
					DESIGNATION
		============================================*/

		/* Insert new designation record (custom-designation.php) */
		public function insertDesignation($designation_name) {
			$query = "INSERT INTO designation (designation_name) VALUES (?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $designation_name);
				$stmt->execute();
				$stmt->close();
			}

			$account_id = $_SESSION['sess'];
			$logMessage = " has been added to Designation records.";
			
			$this->logTransaction('component', 'INSERT', $designation_name, $designation_name, $account_id, $logMessage); //Log transaction
		}

		/* Get/Display all estmated useful life details (customize.php && custom-est-life.php)*/
		public function getDesignation() {
			$data = null;
			$query = "SELECT * FROM designation ORDER BY id DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get estimated useful life details by ID */
		public function getDesignationDetailByID($des_id) {
			$data = null;
			$query = "SELECT * FROM designation WHERE id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $des_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}

		/* Delete estimated useful life record (custom-est-life.php) */
		public function deleteDesignation($designation_id) {
			$designation = $this->getDesignationDetailByID($designation_id);

			$designation_name = $designation['des_name'];
			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been deleted from Designation records.";
			
			$this->logTransaction('component', 'DELETE', $designation_name, $designation_name, $account_id, $logMessage); //Log transaction
		
			$query = "DELETE FROM designation WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $designation_id);
				$stmt->execute();
				$stmt->close();
			}
		}


		/* Get inventory assignment detail based on id (inventory-assignment-view.php) */
		public function getAssignmentItemsById($assignment_id) {
			$data = [];
			$query = "SELECT * FROM inventory_assignment_item WHERE assignment_id = ? AND qty > 0";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				
				$stmt->close();
			}
			
			return $data;
		}

		// (inventory-assignment-view)
		public function getAssignmentItemQty($assignment_id) {
		$data = [];
		$query = "SELECT a.qty AS quantity
					FROM inventory_assignment_item a
					WHERE a.assignment_id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id); // Bind the assignment_id parameter
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row['quantity']; // Store only the quantity in the data array
				}
				$stmt->close();
			}
			return $data;
		}

		// (inventory-assignment.php)
		public function getAssignmentTotalQty($assignment_id) {
			$total_qty = 0;
			$query = "SELECT SUM(qty) AS total_qty FROM inventory_assignment_item WHERE assignment_id = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if ($row = $result->fetch_assoc()) {
					$total_qty = $row['total_qty'];
				}
				
				$stmt->close();
			}
			
			return $total_qty;
		}
	

		/*=====================================================
						END USER INTERFACE
		=====================================================*/

		/*---------------- DASHBOARD --------------------------*/

		/* Get total count of inventory */
		public function getTotalInventoryRecords() {
    		$query = "SELECT COUNT(*) as total_records FROM inventory";
    
    		if ($stmt = $this->conn->prepare($query)) {
        		$stmt->execute();
        		$result = $stmt->get_result();
        		$row = $result->fetch_assoc();
        		$totalRecords = $row['total_records'];
        		$stmt->close();
        
        		return $totalRecords;
    		}

    		return 0;
		}

		/* Get total count of inventory */
		public function getTotalEndUserRecords() {
    		$query = "SELECT COUNT(*) as total_records FROM end_user";
    
    		if ($stmt = $this->conn->prepare($query)) {
        		$stmt->execute();
        		$result = $stmt->get_result();
        		$row = $result->fetch_assoc();
        		$totalRecords = $row['total_records'];
        		$stmt->close();
        
        		return $totalRecords;
    		}

    		return 0;
		}

		/* Get total count of categories */
		public function getTotalCategories() {
    		$query = "SELECT COUNT(*) as total_categories FROM category";
    
    		if ($stmt = $this->conn->prepare($query)) {
        		$stmt->execute();
        		$result = $stmt->get_result();
        		$row = $result->fetch_assoc();
        		$totalRecords = $row['total_categories'];
        		$stmt->close();
        		return $totalRecords;
    		}

    		return 0; // Return 0 if there is an error
		}

		/* Get total count of inventory */
		public function getTotalArticleRecords() {
    		$query = "SELECT COUNT(*) as total_records FROM article";
    
    		if ($stmt = $this->conn->prepare($query)) {
        		$stmt->execute();
        		$result = $stmt->get_result();
        		$row = $result->fetch_assoc();
        		$totalRecords = $row['total_records'];
        		$stmt->close();
        
        		return $totalRecords;
    		}

    		return 0;
		}

		/* Get total count of location */
		public function getTotalLocationRecords() {
    		$query = "SELECT COUNT(*) as total_location FROM location";
    
    		if ($stmt = $this->conn->prepare($query)) {
        		$stmt->execute();
        		$result = $stmt->get_result();
        		$row = $result->fetch_assoc();
        		$totalRecords = $row['total_location'];
        		$stmt->close();
        		return $totalRecords;
    		}
    		return 0;
		}

		/* =========================================================
					END USER INVENTORY MODULE
		==========================================================*/

		/* Get all inventory detail belong to location name (location-view.php)*/
		public function getEndUserInventoryInfo($assignment_id) {
			$query = "SELECT * FROM inventory_assignment_item WHERE id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
				return $data;
			} else {
				return null;
			}
		}

		/* ========================================
			END USER UI (INVENTORY ASSIGNMENT)
		=========================================*/

		// Method to get all inventory assignments
		public function getInventoryAssignmentByEndUserId($end_user_id) {
			$data = [];
			$query = "SELECT a.id AS assignment_id, a.end_user, a.status, a.date_added, e.id AS end_user_id, e.user_id, u.username
					FROM inventory_assignment a
					LEFT JOIN end_user e ON a.end_user = e.id
					LEFT JOIN users u ON e.user_id = u.id
					WHERE a.end_user = ?
					ORDER BY a.date_added DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $end_user_id);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/*======================================
				END USER UI (LOCATION)
		=======================================*/

		public function getLocationDetailsByEndUser($end_user_id) {
			$data = [];
			$query = "SELECT iai.location AS location_name, COUNT(iai.location) AS inventory_count
					  FROM inventory_assignment ia
					  INNER JOIN inventory_assignment_item iai ON ia.id = iai.assignment_id
					  WHERE ia.end_user = ?
					  GROUP BY iai.location";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $end_user_id);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		// Add a method to fetch inventory based on location
		public function getInventoryByLocation($end_user_id, $location) {
			$data = [];
			$query = "SELECT i.id AS item_id, i.assignment_id, i.property_no, i.description, i.unit, i.qty, i.unit_cost, i.total_cost, i.acquisition_date
					FROM inventory_assignment a
					INNER JOIN inventory_assignment_item i ON a.id = i.assignment_id
					WHERE a.end_user = ? AND i.location = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $end_user_id, $location);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* Get all record from history_log */
		public function getHistoryLogByEndUser($end_user_id) {
			$data = null;
			$query = "SELECT * FROM history_log 
						WHERE user_id = ?
						ORDER BY date_time DESC";
			

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $end_user_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		public function getAssignmentDates($end_user_id) {
			$dates = [];
			$query = "SELECT a.date_added, a.id AS assignment_id 
					  FROM inventory_assignment a
					  WHERE a.end_user = ?
					  ORDER BY a.date_added ASC";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $end_user_id);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					// Store both date and assignment_id
					$dates[] = [
						'date' => $row['date_added'], 
						'assignment_id' => $row['assignment_id']
					];
				}
				$stmt->close();
			}
			return $dates; // Return both date and assignment_id
		}

		
		

		
		/*================================================
					END USER (INVENTORY)
		=================================================*/

		public function getInventoryByEndUserId($end_user_id) {
			$data = [];
			$query = "SELECT i.id AS item_id, i.property_no, i.description, i.location, i.unit, i.qty, i.unit_cost, i.total_cost, i.acquisition_date, a.date_added
					  FROM inventory_assignment a
					  INNER JOIN inventory_assignment_item i ON a.id = i.assignment_id
					  WHERE a.end_user = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $end_user_id);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		


	}		
			
?>

