<?php
function getCurrentUserId() {
    if (isset($_SESSION['user_id'])) {
        return $_SESSION['user_id'];
    } else {
        header("Location: index.php");
        exit();
    }
}
?>