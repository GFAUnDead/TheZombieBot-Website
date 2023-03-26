<?php
// Check if the units and city are specified in the URL
$units = $_GET['units'] ?? 'metric';
$city = $_GET['city'] ?? 'Sydney';

// API URL for the specified units and city
$url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&units=$units&appid=(REDACTED)";

// Retrieve the JSON data from the API
$jsonData = @file_get_contents($url);
if (!$jsonData) {
    die("Unable to retrieve weather data.");
}

// Convert the JSON data into a PHP array
$data = json_decode($jsonData, true);

// Check if the API returned an error
if ($data['cod'] !== 200) {
    die("Unable to retrieve weather data.");
}

// Convert wind direction from degrees to textual representation
function getWindDirection($deg) {
    $cardinalDirections = array(
        'N' => array(337.5, 22.5),
        'NE' => array(22.5, 67.5),
        'E' => array(67.5, 112.5),
        'SE' => array(112.5, 157.5),
        'S' => array(157.5, 202.5),
        'SW' => array(202.5, 247.5),
        'W' => array(247.5, 292.5),
        'NW' => array(292.5, 337.5)
    );
    foreach ($cardinalDirections as $dir => $angles) {
        if ($deg >= $angles[0] && $deg < $angles[1]) {
            return $dir;
        }
    }
    return 'N/A';
}

// Extract the weather information from the API data
$description = $data['weather'][0]['description'];
$temperatureC = round($data['main']['temp'], 1);
$temperatureF = round($temperatureC * 9 / 5 + 32, 1);
$windSpeed = round($data['wind']['speed'] * 3.6, 1);
$windSpeedMPH = round($windSpeed / 1.609344, 2);
$windDirection = getWindDirection($data['wind']['deg']);

echo "The weather in {$data['name']}, {$data['sys']['country']}: {$description} with a temperature of {$temperatureC}°C ({$temperatureF}°F). Wind is blowing from the {$windDirection} at {$windSpeed}kph ({$windSpeedMPH}mph) and the humidity is {$data['main']['humidity']}%.";
?>