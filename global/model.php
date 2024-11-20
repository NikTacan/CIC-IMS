<?php
	date_default_timezone_set('Asia/Manila');
	Class Model {
		private $server = "localhost";
		private $username = "root";
		private $password = "";
		private $dbname = "cic_ims";
		private $conn;

		public function __construct() {
			try {
				$this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);	
			} catch (Exception $e) {
				echo "Connection failed" . $e->getMessage();
			}
		}


		public function getUserInventory($userId) {
			$inventory = array();
			
			$query = "SELECT i.description, i.property_no, c.category_name, ia.qty, ia.status_id, ia.date_assigned
					  FROM inventory i
					  JOIN inventory_assignment ia ON i.property_no = ia.property_no
					  JOIN categories c ON i.category_id = c.id
					  WHERE ia.user_id = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $userId);
				$stmt->execute();
				$result = $stmt->get_result();
				
				while ($row = $result->fetch_assoc()) {
					$inventory[] = $row;
				}
				
				$stmt->close();
			}
			
			return $inventory;
		}
	
		public function getUserDetails($userId) {
			$query = "SELECT first_name, last_name FROM end_user WHERE id = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param("i", $userId);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_assoc();
		}


		  //==================================================================//
		 //			        SIGN-IN, USER FUNCTION MODEL 		     		 //
		//==================================================================//

		/* User sign-in */
		public function signIn($uname, $pword) {
			$response = [
				'success' => false,
				'message' => 'Account not found or invalid credentials',
				'data' => null
			];
			
			// Select status field along with role_id to confirm user status if applicable
			$query = "SELECT u.id, u.username, u.role_id, u.password, e.status 
					  FROM users u 
					  LEFT JOIN end_user e ON u.username = e.username
					  WHERE u.username = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('s', $uname);
				
				if ($stmt->execute()) {
					$result = $stmt->get_result();
					
					if ($result->num_rows === 1) {
						$row = $result->fetch_assoc();
						error_log("Found user with ID: " . $row['id']);
						
						// Check if the role is "user" and if account is inactive
						if ($row['role_id'] == 2 && $row['status'] != '1') {
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


		/* Reset user password to default (user-view.php) */
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

		/* Get user details based on <USER ID> (permission.php) */
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

		/* Insert new user record (user.php) */
		public function insertUser($user_role, $name, $username, $password, $date_created) {
			$query = "INSERT INTO users (role_id, username, password, date_created) VALUES (?, ?, ?, ?)";

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			if ($stmt = $this->conn->prepare($query)) {
				$date_created = date("Y-m-d H:i:s");

				$stmt->bind_param("issss", $user_role, $username, $hashed_password);
				$stmt->execute();
				$stmt->close();
			}
		}

		/*======================================
			CREATE END USER - NEW USER
		=====================================*/

		private function createEndUserNewUser($username, $password, $date_created) {
			$query = "INSERT INTO users (role_id, username, password, date_created) VALUES (?, ?, ?, ?)";
			$user_role = '2';

			if ($stmt = $this->conn->prepare($query)) {
				$date_created = date("Y-m-d H:i:s");

				$stmt->bind_param("isss", $user_role, $username, $password, $date_created);
				$stmt->execute();
				$stmt->close();
			}
		}


		/* Display/get user records (users.php) */
		public function displayUsers() {
			$data = null;
			$query = "SELECT users.*, roles.name as role_name FROM users
					  JOIN roles ON users.role_id = roles.id
					  ORDER BY users.id DESC";
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
		

		/* Update user record (users.php) */
		public function updateUser($user_role, $username, $password, $user_id) {
			$query = "UPDATE users SET role_id = ?, username = ?, password = ? WHERE id = ?";

			$hashed_default = password_hash($password, PASSWORD_DEFAULT);

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("issi", $user_role,  $username, $hashed_default, $user_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Delete user record (users.php) */
		public function deleteUser($id) {
			$query = "DELETE FROM users WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $id);
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

		

		/* Get user details based on <USER ID> (user-view.php) */
		public function getEndUserInfo($user_id) {
			$data = null;
			$query = "
				SELECT 
					eu.id AS end_user_id, 
					eu.username, 
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
					u.username AS user_username, 
					u.password, 
					u.date_created, 
					d.id AS designation_id, 
					d.designation_name
				FROM end_user eu
				LEFT JOIN users u ON eu.username = u.username
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

		// oct.26
		public function getUserIdByUsername($username) {
			$query = "SELECT id FROM end_user WHERE username = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $username); // Bind the username parameter
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();
				$stmt->close();
		
				return $row['id'] ?? null; // Return null if no user found
			}
			return null;
		}

		
		/*=============================================
						ROLES
		=============================================*/

		/* INSERT ROLE FUNCTION (role.php) */
		public function insertRoles($name, $description) {
			$query = "INSERT INTO roles (name, description, date_created) VALUES (?, ?, ?)";

			if ($stmt = $this->conn->prepare($query)) {
				$date_created = date("Y-m-d H:i:s");

				$stmt->bind_param("sss", $name, $description, $date_created);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* DISPLAY ROLE FUNCTION (role.php) */
		public function displayRoles() {
			$data = null;
			$query = "SELECT * FROM roles ORDER BY id ASC";
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


		

		/* UPDATE ROLE RECORD FUNCTION (role.php) */
		public function updateRole($name, $description, $id) {
			$query = "UPDATE roles SET name = ?, description = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ssi", $name, $description, $id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* DELETE ROLE ID FUNCTION (role.php) */
		public function deleteRole($id) {
			$query = "DELETE FROM roles WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/*=============================================
				PERMISSIONS, PERMISSION -> ROLE
		=============================================*/


		/* GET ALL PERMISSIONS RECORD FUNCTION (permission.php) */
		public function getAllPermissions() {
			$data = [];
			$query = "SELECT * FROM permission";
			
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


		/* SAVE ALL PERMISSIONS OF THE ROLE ID FUNCTION (permission.php) */
		public function saveRolePermissions($role_id, $module_permissions) {
			$deleteQuery = "DELETE FROM permission_role WHERE role_id = ?";
			
			if ($deleteStmt = $this->conn->prepare($deleteQuery)) {
				$deleteStmt->bind_param("i", $role_id);
				$deleteStmt->execute();
				$deleteStmt->close();

				$insertQuery = "INSERT INTO permission_role (role_id, permission_id, can_access, can_create, can_read, can_update, can_delete) VALUES (?, ?, ?, ?, ?, ?, ?)";

				foreach ($module_permissions as $module => $permissions) {
					$permission_id = $this->getPermissionIdFromModuleName($module);
	
					if ($insertStmt = $this->conn->prepare($insertQuery)) {
						$insertStmt->bind_param("iiiiiii", $role_id, $permission_id, $permissions['access'], $permissions['create'], $permissions['read'], $permissions['update'], $permissions['delete']);
						$insertStmt->execute();
						$insertStmt->close();
					}
				
				}
			}
		}

		/* GET PERMISSION ID OF SPECIFIC MODULE FUNCTION (saveRolePermissions()) */
		private function getPermissionIdFromModuleName($module)
		{
			$query = "SELECT id FROM permission WHERE module = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $module);
				$stmt->execute();
				$stmt->bind_result($permission_id);
				if ($stmt->fetch()) {
					$stmt->close();
					return $permission_id;
				}
				$stmt->close();
			}
			return false;
		}

		/* GET ALL PERMISSIONS OF ROLE ID FUNCTION (permission.php) */
		public function getAllRolePermissions($role_id) {
			$data = [];
			$query = "SELECT permission.module, permission_role.can_access, permission_role.can_create, permission_role.can_read, permission_role.can_update, permission_role.can_delete
					FROM permission_role
					INNER JOIN permission ON permission_role.permission_id = permission.id
					WHERE permission_role.role_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $role_id);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		/* GET ALL PERMISSIONS AND ROLE PERMISSIONS FUNCTION (middleware.php) */
		public function getAllPermissionAndRolePermissions($role_id, $module) {
			$query = "SELECT permission_role.*, permission.* FROM permission_role
					LEFT JOIN permission ON permission_role.permission_id = permission.id 
					WHERE permission_role.role_id = ? AND permission.module = ?";
			
			if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param("is", $role_id, $module);
			$stmt->execute();
			$result = $stmt->get_result();
			$permission = $result->fetch_assoc();
			$stmt->close();
			}
			return $permission;
		}


		
		/*=============================================
						INVENTORY 
		=============================================*/

		/*=============================================
					VERIFY UNIQUE KEY 
		=============================================*/

		/* Check if Inventory No. Exist in Inventory Record  (inventory.php) */
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

		/* Check if Property No. Exist in Inventory Record (inventory.php) */
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

		
		/* Check if Inventory No. Exist in Inventory Record  (inventory.php) */
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

		

		/* Get all Inventory Data from Database (inventory.php) */
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
		
		/* Update Inventory Record (inventory.php) */
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
			INVENTORY DETAILS BY ID
		===============================*/

		
		/* Get Inventory Details based on Inv ID (inventory.php) 
		public function getInventoryDetailsByInvId($inv_id) {
			$query = "SELECT * FROM inventory WHERE inv_id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $inv_id);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($row = $result->fetch_assoc()) {
					return $row;
				}
				$stmt->close();
			}
			return null;
		}*/
		

		/*==============================
			INVENTORY LOG TRANSACTION
		===============================*/

		/* Log Transaction Function */
		public function logTransactionInventoryUpdate($oldValues, $newValues) {
			$logMessage = "'s information has been updated. ";
			$account_id = $_SESSION['sess'];
			$description = $oldValues['description'];
			$inv_id = $oldValues['inv_id'];
		
			$changes = array();
		
			// Compare each field and collect changes
			if ($oldValues['inv_id'] != $newValues['inv_id']) {
				$changes[] = "Inventory No. changed from '{$oldValues['inv_id']}' to '{$newValues['inv_id']}'";
				$inv_id = $newValues['inv_id'];
			}
		
			// Repeat for all fields you want to track
			if ($oldValues['property_no'] != $newValues['property_no']) {
				$changes[] = "Property No. changed from '{$oldValues['property_no']}' to '{$newValues['property_no']}'";
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
				$this->logTransaction('inventory', 'UPDATE', $inv_id, $description, $account_id, $logMessage);
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

		/* Log inventory archive restore transaction function */
		public function logInventoryRestoreTransaction($inv_id, $description, $date_archived) {
			$logMessage = "'s record has been restored. Archived last <span class="."fw-bold"."> $date_archived</span> in Inventory archives.";
			$account_id = $_SESSION['sess'];
			
			$this->logTransaction('inventory', 'UPDATE', $inv_id, $description, $account_id, $logMessage);
		}	

		/*=====================================================================
						INVENTORY ASSIGNMENT FUNCTIONS
		=====================================================================*/

		// Method to get monthly assignment totals for the current year
		public function getMonthlyAssignments($year = null) {
			// Default to current year if no year is provided
			$year = $year ?: date('Y');
			
			$data = [];
			$query = "
				SELECT MONTH(date_added) AS month, COUNT(id) AS count
				FROM inventory_assignment
				WHERE YEAR(date_added) = ?
				GROUP BY MONTH(date_added)
				ORDER BY month";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $year); // Bind the year parameter to the query
				$stmt->execute();
				$result = $stmt->get_result();
				
				// Initialize all months with zero counts
				$allMonths = array_fill(1, 12, 0);
				
				while ($row = $result->fetch_assoc()) {
					// Force count to be an integer
					$allMonths[(int)$row['month']] = (int)$row['count'];  
				}
				$stmt->close();
			
				// Format the data into the desired structure
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

		
		
		
		


		// Method to get all inventory assignments
		public function getInventoryAssignment() {
			$data = [];
			$query = "SELECT a.id AS assignment_id, a.end_user, a.status, a.date_added, e.id AS end_user_id, e.username, n.id AS status_id, n.note_name, n.module, n.color
					FROM inventory_assignment a
					LEFT JOIN end_user e ON a.end_user = e.id
					LEFT JOIN note n ON a.status = n.id
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

		// Method to get all transferred inventory assignments
		public function getInventoryAssignmentTransferred() {
			$data = [];
			$query = "SELECT i.id AS transfer_id, i.*, e1.username AS old_username, e2.username AS new_username
					FROM inventory_transfer i
					LEFT JOIN end_user e1 ON i.old_end_user = e1.id
					LEFT JOIN end_user e2 ON i.new_end_user = e2.id
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


		/* Insert inventory assignment record (inventory-assignment.php) */
		public function insertAssignment($endUser) {
			$date_added = date("Y-m-d H:i:s");
			
			$query = "INSERT INTO inventory_assignment (end_user, date_added) VALUES (?, ?)";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $endUser, $date_added);
				$stmt->execute();
				$assignment_id = $stmt->insert_id; // Get the ID of the newly inserted record
				$stmt->close();
			} else {
				// Handle error if needed
				die('Error: ' . $this->conn->error);
			}

			$endUser = $this->getEndUserDetailByID($endUser);
			$endUserName = $endUser['username'];

			$logMessage = " have new <b>Inventory assignment</b>.";
			$account_id = $_SESSION['sess'];
		
			$this->logTransaction('assignment', 'INSERT', $endUserName, $endUserName, $account_id, $logMessage);
			
			return $assignment_id;
		}

		/* Insert inventory assignment for inventory transfer record (inventory-assignment-view.php) */
		public function insertAssignmentTransfer($newEndUser, $oldEndUser) {
			$date_added = date("Y-m-d H:i:s");
			$query = "INSERT INTO inventory_transfer (new_end_user, old_end_user, date_added, date_transferred) VALUES (?, ?, ?, ?)";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ssss", $newEndUser, $oldEndUser, $date_added, $date_added);
				$stmt->execute();
				$assignment_id = $stmt->insert_id; 
				$stmt->close();
			} else {
				// Handle error if needed
				die('Error: ' . $this->conn->error);
			}

			$newEndUserDetail = $this->getEndUserDetailByID($newEndUser);
			$newEndUserName = $newEndUserDetail['username'];

			$oldEndUserDetail = $this->getEndUserDetailByID($oldEndUser);
			$oldEndUserName = $oldEndUserDetail['username'];
		
			$logMessage = "'s properties transferred to " . $newEndUserName . " <b>Inventory assignment</b>.";
			$account_id = $_SESSION['sess'];
		
			$this->logTransaction('assignment', 'INSERT', $oldEndUserName, $oldEndUserName, $account_id, $logMessage);
			
			return $assignment_id;
		}
		
		

		/* Update Inventoy assignment record function (assignment.php) */
		public function updateAssignment($endUser, $status, $assignment_id) {
			$query = "UPDATE inventory_assignment SET end_user = ?, status = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sii", $endUser, $status, $assignment_id);
				$stmt->execute();
				$stmt->close();
			}
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
		
		public function archivetransferedAssignment($transfer_id) {
			$assignmentInfo = $this->getAssignmentTransferDetailById($transfer_id);
			$assignment_id = $assignmentInfo['assignment_id']; // Fetch assignment ID
			$endUserId = $assignmentInfo['new_end_user']; // Assuming new_end_user is the end user ID
			$endUserName = $assignmentInfo['new_username']; // Assuming new_username is the end user name
			$status = $assignmentInfo['note_name']; // Assuming note_name is the status name
			$date_added = $assignmentInfo['date_added'];
			$date_archived = date("Y-m-d H:i:s");
		
			$query = "INSERT INTO inventory_assignment_archive (assignment_id, end_user, status, date_added, date_archived) VALUES (?, ?, ?, ?, ?)";
		
			if ($stmt = $this->conn->prepare($query)) {
				// Combine ID and name into separate variables before passing them to bind_param
				$endUser = $endUserId . ' ' . $endUserName;
				
				// Adjust bind_param types to match combined variables
				$stmt->bind_param("issss", $assignment_id, $endUser, $status, $date_added, $date_archived);
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
		
			$logMessage = "'s inventory transferred assignment record has been archived.";
			$account_id = $_SESSION['sess'];
			$this->logTransaction('assignment', 'ARCHIVE', $assignment_id, $endUserName, $account_id, $logMessage);
		
			$this->archiveAssignmentItems($assignment_id); // Then archive the items belong to assignment record 
		}
		
		

		/* Archive inventory assignment items function (ics.php) */
		public function archiveAssignmentItems($assignment_id) {
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

		/* Delete assignment record after succesfull moving to archive */
		public function deleteAssignmentTransfer($assignment_id) {
			$query = "DELETE FROM inventory_transfer WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Get inventory assignment detail based on id (inventory-assignment.php) */
		public function getAssignmentDetailById($assignment_id) {
			$data = null;
			$query = "SELECT i.*, e.id AS end_user_id, e.*, n.id AS status_id, n.note_name, n.module, n.color
				FROM inventory_assignment i
				LEFT JOIN end_user e ON i.end_user = e.id
				LEFT JOIN note n ON i.status = n.id
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

		/* Get inventory assignment detail based on id (inventory-assignment.php) */
		public function getAssignmentTransferDetailById($transfer_id) {
			$data = null;
			$query = "SELECT i.*, e1.username AS old_username, e2.username AS new_username
					  FROM inventory_transfer i
					  LEFT JOIN end_user e1 ON i.old_end_user = e1.id
					  LEFT JOIN end_user e2 ON i.new_end_user = e2.id
					  WHERE i.id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $transfer_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}
		
		
		/* Check if Assignment ID already exist in assignment record */
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

		/* Check the property item status of specific assignment id */
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
		public function updateAssignmentPropertyItem($location, $updated_qty, $total_cost, $assignment_id, $property_no, $endUser, $description, $unit) {
			$query = "UPDATE inventory_assignment_item SET location = ?, qty = qty + ?, total_cost = total_cost + ? WHERE assignment_id = ? AND property_no = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sidis", $location, $updated_qty, $total_cost, $assignment_id, $property_no);
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
			$logMessage = "'s '$updated_qty $unit' has been assigned to <b>$endUser</b>.";
			$account_id = $_SESSION['sess'];

			$this->logTransaction('end_user', 'UPDATE', $endUser, $description, $account_id, $logMessage);
		}

		

		/* Update / return Qty per physical count to inventory record */
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
		public function insertAssignmentPropertyItem($assignment_id, $property_no, $description, $location, $unit, $updated_qty, $unit_cost, $total_cost, $acquisition_date, $end_user) {
			$query = "INSERT INTO inventory_assignment_item (assignment_id, property_no, description, location, unit, qty, unit_cost, total_cost, acquisition_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("issssssss", $assignment_id, $property_no, $description, $location, $unit, $updated_qty, $unit_cost, $total_cost, $acquisition_date);
				$stmt->execute();
				$stmt->close();

				$inv_id = $inventories['inv_id'];

				$logMessage = "'s  '$updated_qty $unit' has been assigned to <b>$end_user</b>.";
				$account_id = $_SESSION['sess'];

				$this->logTransaction('end_user', 'INSERT', $property_no, $description, $account_id, $logMessage);
			} else {
				die('Error: ' . $this->conn->error);
			}
		}

		/* (inventory-assignment-transfer.php)*/
		public function getAssignmentItemDetails($assignment_id, $property_no) {
			$query = "SELECT * FROM inventory_assignment_item WHERE assignment_id = ? AND property_no = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $assignment_id, $property_no);
				$stmt->execute();
				$result = $stmt->get_result();
				$details = $result->fetch_assoc();
				$stmt->close();
				return $details;

			} else {
				die('Error: ' . $this->conn->error);
			}
		}

		
		
		/*========================================
			INVENTORY ASSIGNMENT EDIT ITEMS
		==========================================*/

		// DISPLAY INVENTORY RECORD BASED ON ID (par-view.php)
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

		// Function to add inventory quantity back to qty_pcount (par-edit-inv)
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
			$endUserName = $assignment_detail['end_user_name'];

			$logMessage = "'s, '$qty $unitName' has been returned to inventory record from <b>$endUser inventory assignment</b>.";
			$account_id = $_SESSION['sess'];

			$this-> logTransaction('inventory', 'UPDATE', $property_no, $description, $account_id, $logMessage);
		}

		public function deleteAssignmentItems($property_no, $assignment_id) {

			$inventories = $this->getInventoryDetailByPropertyNo($property_no);
			$description = $inventories['description'];
			$inv_id = $inventories['inv_id'];
	
			$assignment_detail = $this->getAssignmentDetailById($assignment_id);
			$endUser = $assignment_detail['end_user'];
	
			$logMessage = "'s has been removed from $endUser assignments.";
			$account_id = $_SESSION['sess'];
	
			$this->logTransaction('end_user', 'UPDATE', $endUser, $description, $account_id, $logMessage);
	
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

			$logMessage = "'s from $endUserName <b>Inventory assignment</b> has been updated. '$qty $unit' to '$newQty $unit'.";
			$account_id = $_SESSION['sess'];

			$this-> logTransaction('end_user', 'UPDATE', $endUser, $description, $account_id, $logMessage);
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

			$logMessage = "'s from <b>$endUserName Inventory assignment</b> has been updated. Location:  '$location' to '$newLocation'.";
			$account_id = $_SESSION['sess'];

			$this-> logTransaction('end_user', 'UPDATE', $endUser, $description, $account_id, $logMessage);
		}

		/*===========================================
				Inventory Assignment Transfer
		============================================*/

		// Remove property assignment item
		public function removeAssignmentPropertyItem($assignment_id, $property_no) {
			$query = "DELETE FROM inventory_assignment_item WHERE assignment_id = ? AND property_no = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $assignment_id, $property_no);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Insert new property assignment if property no doesn't exist in assignment ID (inventory-assignment-add) X*/
		public function insertTransferPropertyItem($transfer_id, $property_no, $description, $location, $unit, $updated_qty, $unit_cost, $total_cost, $acquisition_date) {
			$query = "INSERT INTO inventory_transfer_item (transfer_id, property_no, description, location, unit, qty, unit_cost, total_cost, acquisition_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("issssidds", $transfer_id, $property_no, $description, $location, $unit, $updated_qty, $unit_cost, $total_cost, $acquisition_date);
				$stmt->execute();
				$stmt->close();

				// Get inventory number by property number
				$inventories = $this->getInventoryDetailByPropertyNo($property_no);
				$inv_id = $inventories['inv_id'];

				$assignmentDetail = $this->getAssignmentTransferDetailById($transfer_id);
				$newUsername = $assignmentDetail['new_username'];
				$oldUsername = $assignmentDetail['old_username'];

				$logMessage = "'s '$updated_qty $unit' has been tranferred. From '$oldUsername' to '$newUsername'.";
				$account_id = $_SESSION['sess'];

				$this->logTransaction('assignment', 'INSERT', $property_no, $description, $account_id, $logMessage);
			} else {
				die('Error: ' . $this->conn->error);
			}
		}

		/* Get inventory assignment detail based on id (inventory-assignment.php) */
		public function getTransferItemsById($transfer_id) {
			$data = null;
			$query = "SELECT * FROM inventory_transfer_item WHERE transfer_id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $transfer_id);
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

		// DISPLAY INVENTORY RECORD BASED ON ID (par-view.php)
		public function getInventoryTransferPropertyItems($transfer_id) {
			$data = null;
			$query = "SELECT * FROM inventory_transfer_item WHERE transfer_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $transfer_id);
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

		public function deleteAssignmentTransfertItems($property_no, $assignment_id, $description) {

	
			$assignment_detail = $this->getAssignmentTransferDetailById($assignment_id);
			$endUser = $assignment_detail['new_end_user_name'];
	
			$logMessage = "'s has been removed from $endUser assignments.";
			$account_id = $_SESSION['sess'];
	
			$this->logTransaction('end_user', 'UPDATE', $endUser, $description, $account_id, $logMessage);
	
			$query = "DELETE FROM inventory_transfer_item WHERE property_no = ? AND transfer_id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("si", $property_no, $assignment_id); 
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
		}

		/* Update the location of assigned property (inventory-assignment-edit.php) */
		public function updateAssignmentTransferItemLocation($assignment_id, $property_no, $newLocation, $location, $description) {

			$query = "UPDATE inventory_transfer_item SET location = ? WHERE assignment_id = ? AND property_no = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sis", $newLocation, $assignment_id, $property_no);
				$stmt->execute();
				$stmt->close();
			}

			$logMessage = "'s from $endUser <b>Inventory assignment</b> has been updated. Location:  '$location' to '$newLocation'.";
			$account_id = $_SESSION['sess'];

			$this-> logTransaction('end_user', 'UPDATE', $endUser, $description, $account_id, $logMessage);
		}

		/* Add property quantity back to inventory record */
		public function addInventoryQtyPcountFromAssignmentTransfer($property_no, $qty, $assignment_id, $end_user) {
			$query = "UPDATE inventory SET qty_pcount = qty_pcount + ? WHERE property_no = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $qty, $property_no);
				$stmt->execute();
				$stmt->close();
			}

			$assignment_items = $model->getTransferItemsById($assignment_id);
			$description = $assignment_items['description'];
			$unit = $assignment_items['unit'];


			$logMessage = "'s, '$qty $unit' has been returned to inventory record from <b>$end_user inventory assignment</b>.";
			$account_id = $_SESSION['sess'];

			$this-> logTransaction('inventory', 'UPDATE', $property_no, $description, $account_id, $logMessage);
		}

		/* Update proerty item if qty > 0 (inventory-assignment-add) */
		/* Update property item if qty > 0 (inventory-assignment-add) */
		public function updateAssignmentPropertyItemAfterTransfer($remaining_qty, $old_assignment_id, $property_no, $new_assignment_id) {
			$query = "UPDATE inventory_assignment_item SET qty = ?, total_cost = unit_cost * ? WHERE assignment_id = ? AND property_no = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("idis", $remaining_qty, $remaining_qty, $old_assignment_id, $property_no);
				$stmt->execute();
				$stmt->close();
			} else {
				die('Error: ' . $this->conn->error);
			}
		
			// Get inventory details by property no
			$inventories = $this->getInventoryDetailByPropertyNo($property_no);
			$description = $inventories['description'];
			$unit = $inventories['unit_name'];
			$inv_id = $inventories['inv_id'];

			$transferDetail = $this->getAssignmentTransferDetailById($new_assignment_id);
			$userName = $transferDetail['new_username'];
		
			$logMessage = "'s '$remaining_qty $unit' has been assigned to <b>$userName</b>.";
			$account_id = $_SESSION['sess'];
		
			$this->logTransaction('end_user', 'UPDATE', $userName, $description, $account_id, $logMessage);
		}

		public function getAssignmentTransferItemDetails($transfer_id, $property_no) {
			$query = "SELECT * FROM inventory_transfer_item WHERE transfer_id = ? AND property_no = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $transfer_id, $property_no);
				$stmt->execute();
				$result = $stmt->get_result();
				$details = $result->fetch_assoc();
				$stmt->close();
				return $details;

			} else {
				die('Error: ' . $this->conn->error);
			}
		}
		
		

		/*===========================================
					Assignment Acitivity logs
		============================================*/

		/* Log Assignment update transaction function */
		public function logTransactionAssignmentUpdate($oldValues, $newValues) {
			$logMessage = "'s <b>inventory assignment</b> has been updated. ";
			$account_id = $_SESSION['sess'];
			$end_user = $oldValues['end_user'];
			$assignment_id = $oldValues['id'];

			$endUserDetail = $this->getEndUserDetailByID($end_user);
			$oldEndUser = $endUserDetail['end_user_name'];

			$oldStatusDetail = $this->getNoteDetailByID($oldValues['status']);
			
			
			$changes = array();
			
			// Check if the end user is changed
			if ($oldValues['end_user'] !== $newValues['end_user']) {
				$endUserDetail = $this->getEndUserDetailByID($newValues['end_user']);
			
				$changes[] = "Accountable end user has been updated from '{$oldEndUser}' to '{$endUserDetail['end_user_name']}'";
			}

			// Check if the status is changed
			if ($oldValues['status'] !== $newValues['status']) {
				$newStatusDetail = $this->getNoteDetailByID($newValues['status']);

				$changes[] = "Status updated from '{$oldStatusDetail['note_name']}' to '{$newStatusDetail['note_name']}'";
			}
			

			if (!empty($changes)) {
				$logMessage = $logMessage . implode(', ', $changes);

				$this->logTransaction('assignment', 'UPDATE', $assignment_id, $oldEndUser, $account_id, $logMessage);
			}	
		}

		/* Log Inventory custodian slip archive restore transaction function */
		public function logAssignmentRestoreTransaction($assignment_id, $endUser, $date_archived) {
			$logMessage = "'s inventory assignment record has been restored, where archived last <b>$date_archived</b> in Inventory Assignment archives.";
			$account_id = $_SESSION['sess'];
			
			$this->logTransaction('assignment', 'INSERT', $assignment_id, $endUser, $account_id, $logMessage);
		}

		//Update inventory assignment transfer item qty(inventory-assignment-transfer-edit.php)
		public function updateAssignmentTransferItemsQty($assignment_id, $property_no, $newQty, $qty) {

			if($newQty == 0) {
				$cost = 1;
			} else {
				$cost = $newQty;
			}

			$query = "UPDATE inventory_transfer_item SET qty = ?, total_cost = unit_cost * ? WHERE assignment_id = ? AND property_no = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("iiis", $newQty, $cost, $assignment_id, $property_no);
				$stmt->execute();
				$stmt->close();
			}

			$inventories = $this->getInventoryDetailByPropertyNo($property_no);
			$description = $inventories['description'];
			$unit = $inventories['unit_name'];
			
			$endUser = $assignment_detail['end_user'];


			$logMessage = "'s from $endUser <b>Inventory assignment</b> has been updated. '$qty $unit' to '$newQty $unit'.";
			$account_id = $_SESSION['sess'];

			$this-> logTransaction('end_user', 'UPDATE', $endUser, $description, $account_id, $logMessage);
		}

		/*====================================================================
							INVENTORY ASSIGNMENT ARCHIVES
		====================================================================*/

		/* Get or display all inventory assignment archive */
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

		
		//RESTORE ICS RECORD (ics_archive.php)
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

		public function restoreAssignmentItems($assignment_id) {
			$assignmentItems = $this->getAssignmentItemsArchives($assignment_id);
		
			// INSERT new records
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
		
						// Corrected variable name here
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

		/* Insert new end user data (end-user.php) */
		public function createEndUser($username, $firstName, $middleName, $lastName, $birthday, $sex, $email, $password, $contact, $designation) {
			$query = "INSERT INTO end_user (username, first_name, middle_name, last_name, email, contact, designation, sex, birthday, status, date_registered) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$dateCreated = date("Y-m-d H:i:s");
			$statusActive = '1';
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sssssiissis", $username, $firstName, $middleName, $lastName, $email, $contact, $designation, $sex, $birthday, $statusActive, $dateCreated);
				if ($stmt->execute()) {
					$stmt->close();
					
					$logMessage = "'s has been added to <b>End user</b> records.";    
					$accountId = $_SESSION['sess'];
					$endUserName = $firstName . ' ' . $lastName;

					$this->logTransaction('end_user', 'INSERT', $endUserName, $endUserName, $accountId, $logMessage);
					$this->createEndUserNewUser($username, $hashedPassword, $date_created);
		
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
		
		public function oldusername($username) {
			$query = "SELECT COUNT(*) FROM end_user WHERE username = ?";
			
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
			$query = "SELECT e.id AS end_user_id, e.*, d.id AS designation_id, d.designation_name
				FROM end_user e
				LEFT JOIN designation d ON e.designation = d.id
				ORDER BY date_registered  DESC";
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

		/* Get/Display all end users data (end-user.php) */
		public function getEndUserWithCount() {
			$data = null;
			$query = "SELECT e.id AS end_user_id, e.* , SUM(a.qty) AS inventory_count, d.id AS designation_id, d.designation_name
				FROM end_user e
				LEFT JOIN inventory_assignment i ON i.end_user = e.id 
				LEFT JOIN inventory_assignment_item a ON a.assignment_id = i.id
				LEFT JOIN designation d ON e.designation = d.id
				ORDER BY date_registered  DESC";
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

		/* Update End user data (model.php) */
		public function updateEndUser($username, $firstName, $middleName, $lastName, $birthday, $sex, $email, $contact, $designation, $endUser_id) {
			
			// Proceed with update if username exists in users
			$query = "UPDATE end_user SET username = ?, first_name = ?, middle_name = ?, last_name = ?, email = ?, contact = ?, designation = ?, sex = ?, birthday = ? WHERE id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("sssssiissi", $username, $firstName, $middleName, $lastName, $email, $contact, $designation, $sex, $birthday, $endUser_id);
				$stmt->execute();
				$stmt->close();
			} else {
				echo "Error: " . $this->conn->error;
			}
		}
		
		

		/* Update End user data (model.php) */
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


		public function emailExists($username, $excludeUserId = null) {
			$query = "SELECT COUNT(*) FROM end_user WHERE username = ?";
			
			if ($excludeUserId !== null) {
				$query .= " AND id != ?";
			}
			
			if ($stmt = $this->conn->prepare($query)) {
				if ($excludeUserId !== null) {
					$stmt->bind_param("si", $username, $excludeUserId);
				} else {
					$stmt->bind_param("s", $username);
				}
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
		
				
		/* Delete end user record */
		public function deleteEndUser($endUser_id) {
			$endUser = $this->getEndUserDetailByID($endUser_id);
			$endUser_name = $endUser['end_user_name']; 
			$account_id = $_SESSION['sess'];
			$logMessage = "'s has been deleted from <b>End user</b> records.";
			
			$this->logTransaction('end_user', 'DELETE', $endUser_name, $endUser_name, $account_id, $logMessage); //Log transaction

			$query = "DELETE FROM end_user WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $endUser_id);
				$stmt->execute();
				$stmt->close();
			}
		}

		/* Get end user by Id (report-assignment.php) */
		public function getEndUserDetailByID($endUser_id) {
			$data = null;
			$query = "SELECT e.*, d.id AS designation_id, d.designation_name
					FROM end_user e 
					LEFT JOIN designation d ON e.designation = d.id 
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

		/* Get transferred inventory assignment belong to End User (report-assignment.php)*/
		public function getEndUserTransferredAssignment($endUser) {
			$data = null;
			$query = "SELECT t.*, i.*, e.*
					FROM inventory_transfer t
					LEFT JOIN inventory_transfer_item i ON t.id = i.transfer_id
					LEFT JOIN end_user e ON t.new_end_user = e.id
					WHERE t.new_end_user = ?";

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
			$query = "SELECT a.*, i.*, e.*
					FROM inventory_assignment a
					LEFT JOIN inventory_assignment_item i ON a.id = i.assignment_id
					LEFT JOIN end_user e ON a.end_user = e.id
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

		/* Get all transferred inventory assignments to end user (report-assignment.php) */
		public function getAllTransferredInventoryAssignment() {
			$data = null;
			$query = "SELECT t.*, i.*, e.username AS new_end_user
					FROM inventory_transfer t
					LEFT JOIN inventory_transfer_item i ON t.id = i.transfer_id
					LEFT JOIN end_user e ON t.new_end_user = e.id
					ORDER BY t.date_transferred DESC";

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

		/*================================================
					END USER INVENTORY
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
		
		

		/*===========================================
				Fund Cluster Acitivity logs
		============================================*/

		/* Log Fund Cluster update transaction function */
		public function logEndUserUpdateTransaction($oldValues, $newValues) {
			$logMessage = " end user's record has been updated. ";
			$account_id = $_SESSION['sess'];
			$endUsername = $oldValues['username'];
			
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
		
		/* Get all category details (inventory.php)*/
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

		/* Get category detail by Category id */
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
		
		/* Get location detail by Location id */
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

		/* Get total count of assignment */
		public function getTotalAssignmentRecords() {
			// Assuming $this->conn is a valid database connection
			$query = "SELECT (SELECT COUNT(*) FROM inventory_assignment) AS total_assignment, 
							 (SELECT COUNT(*) FROM inventory_transfer) AS total_transfer";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
		
				if ($result) {
					$row = $result->fetch_assoc();
					if ($row) {
						$totalRecords = $row['total_assignment'] + $row['total_transfer'];
						$stmt->close();
						return $totalRecords;
					} else {
						// Handle case where fetch_assoc returns false
						$stmt->close();
						throw new Exception("No records found.");
					}
				} else {
					// Handle case where get_result returns false
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
				WHERE i.remark = ? AND i.date_added BETWEEN ? AND ?
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
				WHERE i.date_added BETWEEN ? AND ? ORDER BY i.date_added ASC";
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
			$query = "SELECT i.*, c.*, e.username
					  FROM inventory_assignment i
					  LEFT JOIN inventory_assignment_item c ON i.id = c.assignment_id
					  LEFT JOIN end_user e ON i.end_user = e.id
					  WHERE i.end_user = ? AND i.date_added BETWEEN ? AND ?";

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

		/* Get all inventory assignment of end user */
		public function getEndUserTransferredAssignmentReport($end_user, $fromDate, $toDate) {
			$data = null;
			$query = "SELECT t.*, i.*, e.username
					  FROM inventory_transfer t
					  LEFT JOIN inventory_transfer_item i ON t.id = i.transfer_id
					  LEFT JOIN end_user e ON t.new_end_user = e.id
					  WHERE t.new_end_user = ? AND t.date_transferred BETWEEN ? AND ?";

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
			$query = "SELECT i.*, c.*, e.username
					  FROM inventory_assignment i
					  LEFT JOIN inventory_assignment_item c ON i.id = c.assignment_id
					  LEFT JOIN end_user e ON i.end_user = e.id
					  WHERE i.date_added BETWEEN ? AND ?";

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

		/* All end user assignment */
		public function getAllEndUserTransferredAssignmentReport($fromDate, $toDate) {
			$data = null;
			$query = "SELECT t.*, i.*, e.username AS new_end_user
					  FROM inventory_transfer t
					  LEFT JOIN inventory_transfer_item i ON t.id = i.transfer_id
					  LEFT JOIN end_user e ON t.new_end_user = e.id
					  WHERE t.date_transferred BETWEEN ? AND ?";

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
		
			$query = "SELECT a.*, i.*, e.*, n.id AS status_id, n.note_name, n.module, n.color
					  FROM inventory_assignment a
					  LEFT JOIN inventory_assignment_item i ON a.id = i.assignment_id
					  LEFT JOIN end_user e ON a.end_user = e.id
					  LEFT JOIN note n ON a.status = n.id
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

		public function displayPropertyTransfer($property_no) {
			$data = null;
		
			$query = "SELECT t.*, i.*, e.*
					  FROM inventory_transfer_item i
					  LEFT JOIN inventory_transfer t ON i.transfer_id = t.id
					  LEFT JOIN end_user e ON t.new_end_user = e.id
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

		// DISPLAY INVENTORY RECORD BASED ON ID (inventory-view.php)
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

		//UPDATE INVENTORY RECORD (ics-add-inv)
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

		public function displayICSView($ics_id) {
			$data = null;
			$query = "SELECT * FROM inventory WHERE inv_id = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $ics_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_assoc();
				$stmt->close();
			}
			return $data;
		}
		

		/* Add inventory quantity back to inventory qty_pcount */
		public function addInventoryQtyPcount($inv_id, $qty, $ics_id) {
			$query = "UPDATE inventory SET qty_pcount = qty_pcount + ? WHERE inv_id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("is", $qty, $inv_id);
				$stmt->execute();
				$stmt->close();
			}

			$inventories = $this->getInventoryDetailByInvNo($inv_id);
			$description = $inventories['description'];
			$unit = $inventories['unit'];

			$ics = $this->displayICSView($ics_id);
			$ics_no = $ics['ics_no'];

			$logMessage = "'s, '$qty $unit' has been returned to inventory record from ICS No. $ics_no";
			$account_id = $_SESSION['sess'];

			$this-> logTransaction('inventory', 'UPDATE', $inv_id, $description, $account_id, $logMessage);

		}

		/*=============================================
						I N V E N T O R Y
		=============================================*/

		// Function to retrieve current inventory details by inv_id
		private function getInventoryDetailByInvNo($inv_id) {
			$query = "SELECT * FROM inventory WHERE inv_id = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $inv_id);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($row = $result->fetch_assoc()) {
					return $row;
				}
				$stmt->close();
			}
			return null;
		}

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

	
		// DELETE ACTIVITY LOGS / HISTORY
		public function deleteActivityLogs($ids) {
			$query = "DELETE FROM history_log WHERE id IN (";
			$placeholders = implode(',', array_fill(0, count($ids), '?'));
			$query .= $placeholders . ")";
			
			if ($stmt = $this->conn->prepare($query)) {
				// Dynamically bind parameters based on the number of IDs
				$types = str_repeat('i', count($ids));
				$stmt->bind_param($types, ...$ids); // Using the splat operator to unpack the array
				$stmt->execute();
				$stmt->close();
			}
		}
	

		// DISPLAY INVENTORY RECORDS WITH RELATED INFORMATION
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

		

		// FETCH ALL ARCHIVED
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

		//DELETE INVENTORY FROM ARCHIVE RECORD
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

		//DELETE INVENTORY FROM ARCHIVE RECORD
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
		
		
		/* Category count */
		public function getCategoryData() {
			$data = array();
		
			$query = "SELECT c.category_name, getEndUser 
					  FROM category c
					  LEFT JOIN inventory i ON i.category = c.id
					  GROUP BY c.id";
		
			$result = $this->conn->query($query);
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$data[$row['category_name']] = $row['category_count'];
				}
			}
			return $data;
		}

		/* Count inventory remarks (inventory.php) */
		public function getRemarkData() {
			$data = array();
			
			$query = "SELECT n.note_name AS remark, COUNT(*) AS remark_count
					  FROM inventory i
					  LEFT JOIN note n ON i.remark = n.id
					  GROUP BY i.remark";
			
			$result = $this->conn->query($query);
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$data[$row['remark']] = $row['remark_count'];
				}
			}
			return $data;
		}
		

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

		/* Insert new designation record (custom-est-life.php) */
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

		/* dili ma delete ang assignment kung naay naka assign*/
		public function gassignitem($assignment_id) {
			$data = null;
			$query = "SELECT * FROM inventory_assignment WHERE end_user = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_all(MYSQLI_ASSOC);
				$stmt->close();
			}
			return $data;
		}

		public function gtransferitem($assignment_id) {
			$data = null;
			$query = "SELECT * FROM inventory_transfer WHERE new_end_user = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $assignment_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$data = $result->fetch_all(MYSQLI_ASSOC);
				$stmt->close();
			}
			return $data;
		}

		/* Get inventory assignment detail based on id (inventory-assignment.php) */
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
		
		public function getTransferTotalQty($transfer_id) {
			$total_qty = 0;
			$query = "SELECT SUM(qty) AS total_qty FROM inventory_transfer_item WHERE transfer_id = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $transfer_id);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if ($row = $result->fetch_assoc()) {
					$total_qty = $row['total_qty'];
				}
				
				$stmt->close();
			}
			
			return $total_qty;
		}


		public function getAssignmentTransQty($transferredAssignment) {
			$total_qty = 0;
			$query = "SELECT SUM(qty) AS total_qty FROM inventory_transfer_item WHERE transfer_id = ?";
			
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $transferredAssignment);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if ($row = $result->fetch_assoc()) {
					$total_qty = $row['total_qty'];
				}
				
				$stmt->close();
			}
			
			return $total_qty;
		}

		public function hasAssignments($endUser_id) {
			$query = "SELECT i.qty 
					  FROM inventory_assignment_item i
					  JOIN inventory_assignment a ON i.assignment_id = a.id
					  WHERE a.end_user = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param('i', $endUser_id);
			$stmt->execute();
			$result = $stmt->get_result();
			
			// Check if there are any rows returned
			return $result->num_rows > 0;
		}
	
		public function deleteEndUser1($endUser_id) {
			$query = "DELETE FROM end_users WHERE id = ?";
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param('i', $endUser_id);  // 'i' indicates that the parameter is an integer
			$stmt->execute();
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
			$query = "SELECT a.id AS assignment_id, a.end_user, a.status, a.date_added, e.id AS end_user_id, e.username
					FROM inventory_assignment a
					INNER JOIN end_user e ON a.end_user = e.id
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
		public function getHistoryLogByEndUser($end_user) {
			$data = null;
			$query = "SELECT * FROM history_log 
						WHERE module = ? AND item_no = ?
						ORDER BY date_time DESC";
			
			$module = "assignment";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("ss", $module, $end_user);
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
		
		
		
		


	}		
			
?>

