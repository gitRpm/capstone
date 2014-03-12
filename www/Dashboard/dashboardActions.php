<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/dbo/connection.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/../util/chart/chart.php";
if ($_GET['data'] === 'barChart') {
    $barChart = new chart();
    $barChartInfo = array();
    foreach ($barChart->getBarChart() as $key => $val) {
        $barChartInfo[$key]['username'] = $val['user'];
        $barChartInfo[$key]['completed'] = $val['completed'];
        $barChartInfo[$key]['incomplete'] = $val['incomplete'];
        $barChartInfo[$key]['pastDue'] = $val['pastDue'];
    }
    echo json_encode($barChartInfo);
}

if ($_GET['data'] === 'pieChart') {
    $pieChart = new chart();
    echo json_encode($pieChart->getPieChart());
}

