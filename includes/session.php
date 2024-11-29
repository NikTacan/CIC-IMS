<?php

    ob_start();
    session_start(); 

    include('../global/model.php');
    $model = new Model();

    // Check session status
    if (isset($_SESSION['sess'])) {
        $session_name = $_SESSION['session_name'];
        $session_role = $_SESSION['userPermissions'];
    } else {
        echo "<script>alert('You are not logged in. Redirecting to login page.');window.open('../index.php', '_self');</script>";
        exit;
    }

    $account_id = $_SESSION['sess'];
    $customize = $model->displayReportEdit();
    $theme_id = $customize['theme'];
    $userInfo = $model->getUserInfo($account_id);

    if ($userInfo['role_id'] == 3) {
        $endUserAllInfo = $model->getEndUserInfo($account_id);
        $end_user_id = $endUserAllInfo['end_user_id'];
    }
    
    
?>