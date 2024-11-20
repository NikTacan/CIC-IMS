<?php
session_start();
include('global/model.php');

if (isset($_SESSION['sess'])) {
    echo "<script>window.open('admin/index.php','_self');</script>";
}

$model = new Model();
$customize = $model->displayReportEdit();
$theme_id = $customize['theme'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta property="og:image" content="assets/images/cover.png" />
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="assets/images/<?php echo $customize['logo_file']; ?>" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/<?php echo $customize['logo_file']; ?>" />
    <title><?php echo $customize['sys_name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/css/assets.css">
    <link rel="stylesheet" type="text/css" href="assets/css/typography.css">
    <link rel="stylesheet" type="text/css" href="../dashboard/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
</head>
<body id="bg">
    <div class="page-wraper">
        <div id="loading-icon-bx"></div>
        <div class="account-form">

            <!-- page theme -->
            <div class="
                <?php if($theme_id == '1'): ?> 
                    account-heads
                <?php elseif($theme_id == '2'): ?> 
                    account-headss
                <?php else: ?> 
                    account-headsss
                <?php endif; ?>" 
                style="background-image:url(assets/images/<?php echo $customize['login_image']; ?>);">
                <div class="login"></div>
                <img src="assets/images/<?php echo $customize['logo_file']; ?>" class="login-logo" alt="logo">
            </div> <!-- page theme -->

            <div class="account-form-inner">
                <div class="account-container">

                    <h2 class="title-head text-center mt-3">
                        <?php echo $customize['sys_name'] ?>
                    </h2>

                    <form class="contact-bx" method="POST">
                        <div class="row placeani">
                            <div class="col-lg-12">
                                <div class="form-group col-12">
                                    <div class="row">
                                        <label class="col-form-label">Username</label>
                                        <input class="form-control" name="username" type="text"  placeholder="Enter your Username" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group col-12">
                                    <div class="row"> 
                                        <label class="col-form-label">Password</label>
                                        <input class="form-control" name="password" type="password" minlength="4" maxlength="20" placeholder="Enter your Password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6"></div><br>
                            <div class="col-lg-12 m-b30">
                                <div id="submit-button">
                                    <button name="submit" type="submit" value="Submit" class="btn btn-success btn-block">Login</button>
                                </div>
                                <br>
                            </div>
                        </div>
                    </form>

                    <?php

                        // Initialize an error message variable
                        $error_message = '';

                        // Submit Log-in
                        if (isset($_POST['submit'])) {
                            $uname = trim($_POST['username']);
                            $pword = $_POST['password'];

                            if (empty($uname) || empty($pword)) {
                                $error_message = "Please fill in all fields.";
                            } else {
                                $response = $model->signIn($uname, $pword);

                                if ($response['success']) {
                                    // Store user data in session
                                    $_SESSION['sess'] = $response['data']['id'];
                                    $_SESSION['session_name'] = $response['data']['username'];
                                    $_SESSION['userPermissions'] = $response['data']['role_id'];

                                    // Log the successful login attempt
                                    error_log("User {$uname} with role_id {$response['data']['role_id']} logged in successfully.");

                                    // Role-based redirection
                                    if ($response['data']['role_id'] == 1) {
                                        header("Location: admin/index.php");
                                    } elseif ($response['data']['role_id'] == 2) {
                                        header("Location: user/index.php");
                                    } else {
                                        header("Location: default/index.php");
                                    }
                                    exit();
                                } else {
                                    $error_message = $response['message'];
                                    error_log("Failed login attempt for user {$uname}: {$response['message']}");
                                }
                            }
                        }

                        // Display error message if there is one
                        if (!empty($error_message)) {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                            <?php
                        }
                    ?>




                </div> <!-- account-container -->
            </div> <!-- account-form-inner -->
        </div> <!-- account-form -->
    </div> <!-- page-wrapper -->
</body>
</html>
