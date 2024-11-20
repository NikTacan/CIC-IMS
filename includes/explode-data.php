<?php 
    function getNameFromField($data) {
        $parts = explode(' ', $data, 2);
        return isset($parts[1]) ? $parts[1] : $data;
    }

    function getNumberFromField($data) {
        $parts = explode(' ', $data, 2);
        return isset($parts[0]) ? $parts[0] : '';
    }
?>