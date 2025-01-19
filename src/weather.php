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

function getApiKey() {
    // Using __DIR__ ensures the path is always relative
    // to the directory of the current file.
    $api_config = __DIR__ . "/../config/weather-api-config.xml";
    if (!file_exists($api_config)) {
        throw new Exception("API configuration file not found");
    }
    
    $file = file_get_contents($api_config);
    $xml = simplexml_load_string($file);
    return $xml->apiKey;
}

function fetchWeatherData($location) {
    try {
        $apiKey = getApiKey();
        $url = sprintf(
            "https://api.openweathermap.org/data/2.5/weather?q=%s&appid=%s&units=metric",
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
        
        curl_close($ch);
        return json_decode($response, true);
        
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
?>
