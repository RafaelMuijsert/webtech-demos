<?php

/**
 * Weather API endpoint.
 * Uses internal function to fetch weather data.
 *
 * PHP version 8
 *
 * @category Webtech_Demo
 * @package  Webtech_Demo
 * @author   Toon van Gelderen <t.vangelderen@uva.nl>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

require_once "../../src/weather.php";

header('Content-Type: application/json');

if (!isset($_GET['location'])) {
    echo json_encode(['error' => 'Location parameter is required']);
    exit;
}

$city = $_GET['location'];
$weatherData = fetchWeatherData($city);
echo json_encode($weatherData);
