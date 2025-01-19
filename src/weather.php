<?php

/**
 * Utility file used to get the current weather from OpenWeatherMap.
 * Reads API key from ../config/weather-api-config.xml.
 *
 * PHP version 8
 *
 * @category Webtech_Demo
 * @package  Webtech_Demo
 * @author   Toon van Gelderen <t.vangelderen@uva.nl>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

/**
 * Read the OpenWeatherMap API key from configuration file.
 *
 * @return string: the OpenWeatherMap API key.
 */
function getApiKey()
{
    // Using __DIR__ ensures the path is always relative
    // to the directory of the current file.
    $api_config = __DIR__ . "/../config/weather-api-config.xml";
    if (!file_exists($api_config)) {
        throw new Exception("API configuration file not found");
    }

    $file = file_get_contents($api_config);
    if ($file === false) {
        throw new Exception("Could not read API configuration file");
    }
    $xml = simplexml_load_string($file);
    if ($xml === false) {
        throw new Exception("API configuration file XML could not be parsed");
    }
    return $xml->apiKey;
}

/**
 * Query the OpenWeatherMap API for the current weather at location.
 *
 * @param string $location the location from which to read the weather.
 *
 * @return array<string, string>: the OpenWeatherMap API key.
 */
function fetchWeatherData($location)
{
    $URL = "https://api.openweathermap.org/"
         . "data/2.5/weather?q=%s&appid=%s&units=metric";

    try {
        $apiKey = getApiKey();
        $url = sprintf(
            $URL,
            urlencode($location),
            $apiKey
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception(curl_error($ch));
        }

        if ($response === true) {
            throw new Exception("API Response contains no data");
        }

        curl_close($ch);
        $data = json_decode($response, true);
        if (is_array($data) === false) {
            throw new Exception("API Response contains malformed data");
        }
        return $data;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
