<?php
    include('../global/model.php');
    $model = new Model();

    $end_user_id = $_SESSION['user_id']; // or however you retrieve the current end user id
    $assignments = $model->getAssignmentDates($end_user_id);

    $events = [];
    foreach ($assignments as $assignment) {
        $events[] = [
            'title' => $assignment['id'], // or property_no or description
            'start' => $assignment['date_added'],
        ];
    }
    echo json_encode($events);
?>
