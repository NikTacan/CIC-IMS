<?php include('../includes/session.php'); ?>

<?php
    // Get the year from the query string, default to the current year if not set
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');

    // Fetch monthly assignments for the selected year
    $monthlyAssignments = $model->getMonthlyAssignments($year);
    $availableYears = $model->getAvailableYears();

    $months = [];
    $assignmentCounts = [];

    foreach ($monthlyAssignments as $record) {
        $months[] = date('F', mktime(0, 0, 0, $record['month'], 1)); // Convert month number to month name
        $assignmentCounts[] = $record['count']; // Count data for the bar chart
    }

    // If the request is for JSON (AJAX), return it
    if (isset($_GET['year'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'months' => $months,
            'assignmentCounts' => $assignmentCounts
        ]);
        exit; 
    }
?>

<!-- html, head tag -->
<?php include('../includes/layouts/main-layouts/html-head.php'); ?>

    <title>Dashboard | <?php echo $customize['sys_name']; ?></title>

</head>
<body class="ttr-opened-sidebar ttr-pinned-sidebar" style="background-color: #F3F3F3;">

<!-- main header -->
<?php include('../includes/layouts/main-layouts/ttr-header.php') ?>

<nav class="ttr-sidebar-navi">
    <ul>
        <li style="padding-left: 20px; padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
            <span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Main Navigation</span>
        </li>
        <li class="show" style="margin-top: 0px;">
            <a href="index" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                <span class="ttr-label">Dashboard</span>
            </a>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="inventory" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-database" aria-hidden="true"></i></span>
                <span class="ttr-label">Inventory</span>
            </a>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="inventory-assignment" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-file-text" aria-hidden="true"></i></span>
                <span class="ttr-label">Assignment</span>
            </a>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="end-user" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-address-book" aria-hidden="true"></i></span>
                <span class="ttr-label">End Users</span>
            </a>
        </li>        
        <li class="" style="margin-top: 0px;">
            <a href="category" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-cubes" aria-hidden="true"></i></span>
                <span class="ttr-label">Categories</span>
            </a>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="article" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-cube" aria-hidden="true"></i></span>
                <span class="ttr-label">Article</span>
            </a>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="location" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                <span class="ttr-label">Location</span>
            </a>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="report.php" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></span>
                <span class="ttr-label">Report</span>
            </a>
        </li>
        <li style="padding-left: 20px; padding-top: 40px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
            <span class="ttr-label" style="color: #D5D6D8; font-weight: 500;">Admin Settings</span>
        </li>
        <li class="" style="margin-top: 0px;">
            <div class="accordion accordion-flush" id="accordionSettings">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button ps-3.5 py-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings" ><i class="fa fa-solid fa-gear me-2 pe-3" aria-hidden="true"></i>
                    Settings
                    </button>
                    </h2>
                <div id="collapseSettings" class="accordion-collapse collapse" data-bs-parent="#accordionSettings">
                <div class="accordion-body p-0">
                    <div class="">
                        <a href="system-content" class="ttr-material-button mx-0 my-0">
                            <span class="ttr-icon"></span>
                            <span class="ttr-label">General Content</span>
                        </a>
                    </div>
                    <div class="">
                        <a href="customize" class="ttr-material-button mx-0 my-0">
                            <span class="ttr-icon"></span>
                            <span class="ttr-label">Components</span>
                        </a>
                    </div>
                </div>
            </div>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="history" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
                <span class="ttr-label">Activity Logs</span>
            </a>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="archive-inventory" class="ttr-material-button">
                <span class="ttr-icon"><i class="ti-archive" aria-hidden="true"></i></span>
                <span class="ttr-label">Archives</span>
            </a>
        </li>
    </ul>
</nav>
</div> <!-- ttr-sidebar-wrapper content-scroll -->
</div> <!-- ttr-sidebar -->



<main class="ttr-wrapper" style="background-color: #F3F3F3;">
<div class="container-fluid">

    <!-- Header and Button Row -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Header aligned to the left -->
                <h2 class="p-0 mb-0">Dashboard</h2>
            </div>
        </div>
    </div>

    <div class="widget-box">
        <div class="widget-inner">
            <div class="row">

                <!-- Inventory count card -->
                <div class="col-sm-12 col-xl-4 mb-4">
                    <a href="inventory.php" style="text-decoration: none; color: inherit;"> 
                        <div class="card shadow h-100 py-2" style="border-left: 5px solid #4e73df;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php $totalInventoryRecords = $model->getTotalInventoryRecords(); ?>
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Inventory</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalInventoryRecords ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-database fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- Inventory count card -->

                <!-- Assignment Count Card -->
                <div class="col-sm-12 col-xl-4 mb-4">
                  <a href="inventory-assignment.php" style="text-decoration: none; color: inherit;">
                        <div class="card shadow h-100 py-2" style="border-left: 5px solid #FCD12A;" >
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php $totalAssignmentRecords = $model->getTotalAssignmentRecords(); ?>
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Assignment</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalAssignmentRecords ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-file-text fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>    
                </div> <!-- Assignment Count Card -->

                <!-- End User Count Card -->
                <div class="col-sm-12 col-xl-4 mb-4">
                  <a href="end-user.php" style="text-decoration: none; color: inherit;">
                        <div class="card shadow h-100 py-2" style="border-left: 5px solid #49AB5C;" >
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php $totalAssignmentRecords = $model->getTotalEndUserRecords(); ?>
                                        <div class="text-xs font-weight-bold text-green text-uppercase mb-1">
                                            End User</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalAssignmentRecords ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-address-book fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>    
                </div> <!-- End User Count Card -->

                <!-- Category card -->
                <div class="col-sm-12 col-xl-4 mb-4">
                    <a href="category.php" style="text-decoration: none; color: inherit;">
                        <div class="card shadow h-100 py-2" style="border-left: 5px solid #87CEEB;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php $totalCategoryRecords = $model->getTotalCategories(); ?>
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Category</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCategoryRecords ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-cubes fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- Category card -->

                 <!-- Article count card -->
                 <div class="col-sm-12 col-xl-4 mb-4">
                    <a href="article.php" style="text-decoration: none; color: inherit;">
                        <div class="card shadow h-100 py-2" style="border-left: 5px solid #F3BC2E;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php $totalCategoryRecords = $model->getTotalArticleRecords(); ?>
                                        <div class="text-xs font-weight-bold text-yellow text-uppercase mb-1">
                                            Article</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCategoryRecords ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-cube fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- Article Count card -->

                <!-- Location Count Card -->
                <div class="col-sm-12 col-xl-4 mb-4">
                    <a href="location.php" style="text-decoration: none; color: inherit;">
                        <div class="card shadow h-100 py-2" style="border-left: 5px solid #5ADA86;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php $totalLocationRecords = $model->getTotalLocationRecords(); ?>
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Location</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalLocationRecords ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-map-marker fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- Location Count Card -->

                

                <!-- Monthly Assignment Graph -->
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <div class="col-10">
                                <h6 class="m-0 font-weight-bold text-primary">Inventory Assignment Overview</h6>
                            </div>
                            <div class="col-2">
                                <select id="yearFilter" onchange="updateGraph()">
                                    <!-- Dynamically generate year options based on available years -->
                                    <?php foreach ($availableYears as $year): ?>
                                        <option value="<?php echo $year; ?>" <?php echo ($year == date('Y')) ? 'selected' : ''; ?>>
                                            <?php echo $year; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="monthlyAssignmentChart"></canvas>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>

            </div> <!-- row -->
        </div> <!-- widget-inner -->
    </div> <!-- widget-box -->
<div class="ttr-overlay"></div>

<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
<?php include('../includes/js/assignment-graph.php'); ?>
      
</body>

</html>