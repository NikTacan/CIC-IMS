<?php include('../includes/session.php'); ?>
<?php include('../includes/layouts/main-layouts/html-head.php') ?>

    <title>Dashboard | <?php echo $customize['sys_name']; ?></title>

<style>
/* Remove blue outline from events */
.fc-event {
    border: none !important;
    background: none !important;
    text-align: center;
}

#year-select {
    width: 100px;
    height: 35px;
    margin-right: 10px;
    position: inherit;
}
</style>

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
            <a href="location" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                <span class="ttr-label">Location</span>
            </a>
        </li>
        <li class="" style="margin-top: 0px;">
            <a href="history" class="ttr-material-button">
                <span class="ttr-icon"><i class="fa fa-history" aria-hidden="true"></i></span>
                <span class="ttr-label">Activity Logs</span>
            </a>
        </li>
    </ul>
</nav>
</div> <!-- ttr-sidebar-wrapper content-scroll -->
</div> <!-- ttr-sidebar -->

<main class="ttr-wrapper" style="background-color: #F3F3F3;">
<div class="container-fluid">

    <div class="float-left">
        <h2 class="title-head float-left">Dashboard<span> </span></h2>
    </div>

    <div class="clearfix"></div>

    <div class="widget-box">
        <div class="widget-inner">
            <div class="row">

                <!-- inventory card -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 5px solid #4e73df;">
                        <a href="inventory">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php 
                                            $totalInventoryAssigned = $model->getTotalInventoryAssignedToUser($end_user_id);
                                        ?>
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Inventory Assigned</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalInventoryAssigned; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-database fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- inventory card -->

                <!-- Assignment Count Card -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 5px solid #FCD12A;" >
                        <a href="inventory-assignment">
                          <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php $totalAssignmentRecords = $model->getTotalAssignmentToUser($end_user_id); ?>
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Assignments</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalAssignmentRecords ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-database fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                             </div>
                        </a>
                    </div>
                </div> <!-- Assignment Count Card -->

                <!-- Location Count Card -->
                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card shadow h-100 py-2" style="border-left: 5px solid #87CEEB;">
                        <a href="location">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <?php $totalLocationRecords = $model->getTotalLocationByEndUser($end_user_id); ?>
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Location </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalLocationRecords ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-database fa-2x" style="color: #b7b7b7;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div> <!-- Location Count Card -->

                <!-- Calendar Overview -->
                <div class="col-12 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-primary mb-4">Assignment Calendar</h5>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

            
        
            </div> <!-- row -->
        </div> <!-- widget-inner -->
    </div> <!-- widget-box -->

</div> <!-- container-fluid -->
</main> <!-- ttr-wrapper -->
<div class="ttr-overlay"></div>

	<?php include('../includes/layouts/main-layouts/scripts.php'); ?>
	<script src="../dashboard/assets/js/main.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
            var availableYears = <?php echo json_encode($model->getAvailableYears($end_user_id)); ?>;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                contentHeight: 'auto',
                width: '100%',
                initialDate: today, // Start the calendar on today's month
                headerToolbar: {
                    left: 'title',
                    right: 'today,prev,next yearDropdown' // All buttons on the right
                },
                customButtons: {
                    yearDropdown: {
                        text: 'Year',
                        click: function () {
                            var existingDropdown = document.getElementById('year-select');

                            if (existingDropdown) {
                                existingDropdown.style.display =
                                    existingDropdown.style.display === 'none' ? 'inline-block' : 'none';
                            } else {
                                var dropdown = document.createElement('select');
                                dropdown.id = 'year-select';
                                dropdown.style.marginRight = '2px';

                                // Populate the dropdown with available years
                                availableYears.forEach(function (year) {
                                    var option = document.createElement('option');
                                    option.value = year;
                                    option.textContent = year;
                                    if (year === new Date().getFullYear()) option.selected = true;
                                    dropdown.appendChild(option);
                                });

                                dropdown.addEventListener('change', function () {
                                    var selectedYear = dropdown.value;
                                    calendar.gotoDate(`${selectedYear}-01-01`); // Jump to January 1 of the selected year
                                });

                                var headerToolbar = calendarEl.querySelector('.fc-toolbar-chunk:last-child');
                                headerToolbar.insertBefore(dropdown, headerToolbar.querySelector('.fc-yearDropdown-button'));
                            }
                        }
                    }
                },
                events: [
                    <?php
                    $dates = $model->getAssignmentDates($end_user_id);
                    foreach ($dates as $date) {
                        echo "{ 
                            title: 'New assignment',
                            start: '{$date['date']}', 
                            allDay: true,
                            assignmentId: '{$date['assignment_id']}'
                        },";
                    }
                    ?>
                ],
                eventContent: function (arg) {
                    return {
                        html: `
                            <a href="inventory-assignment-view.php?id=${arg.event.extendedProps.assignmentId}" 
                            class="event-link" style="outline: none; text-decoration: none;">
                            ${arg.event.title}
                            </a>
                        `
                    };
                },
                eventDidMount: function (arg) {
                    arg.el.style.whiteSpace = 'nowrap';
                    arg.el.style.overflow = 'hidden';
                    arg.el.style.textOverflow = 'ellipsis';
                }
            });

            calendar.render();
        });
    </script>






</body>
</html>

