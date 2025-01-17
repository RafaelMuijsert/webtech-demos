<?php
function getApiKey() {
    $api_config = "../config/api_config.xml";
    if (!file_exists($api_config)) {
        throw new Exception("API configuration file not found");
    }
    
    $file = file_get_contents($api_config);
    $xml = simplexml_load_string($file);
    return $xml->apiKey;
}

function fetchWeatherData($city) {
    try {
        $apiKey = getApiKey();
        $url = sprintf(
            "https://api.openweathermap.org/data/2.5/weather?q=%s&appid=%s&units=metric",
            urlencode($city),
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