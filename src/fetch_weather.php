<?php

/*
 * 
 * 
 */

header('Content-Type: application/json');
require_once 'weather_api.php';

if (!isset($_GET['city'])) {
    echo json_encode(['error' => 'City parameter is required']);
    exit;
}

$city = $_GET['city'];
$weatherData = fetchWeatherData($city);
echo json_encode($weatherData);
?>