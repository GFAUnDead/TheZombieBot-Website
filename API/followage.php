<?php
$clientId = 'YOUR_CLIENT_ID';
$username = $_GET['user'];
$channel = $_GET['channel'];

// Check if the user and channel parameters are present in the URL
if (!$channel) {
    die("You have not specified a channel.");
}
if (!$username) {
    die("You have not specified a user.");
}

$url = "https://api.twitch.tv/helix/users?login=$username";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Client-ID: ' . $clientId
));
$jsonData = curl_exec($ch);
curl_close($ch);

if (!$jsonData) {
    die("Unable to retrieve user data.");
}

$data = json_decode($jsonData, true);

if (!isset($data['data'][0]['id'])) {
    die("Invalid user specified.");
}

$userId = $data['data'][0]['id'];
$url = "https://api.twitch.tv/helix/users/follows?from_id=$userId&to_id=$channel";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Client-ID: ' . $clientId
));
$jsonData = curl_exec($ch);
curl_close($ch);

if (!$jsonData) {
    die("Unable to retrieve followage data.");
}

$data = json_decode($jsonData, true);

if (!isset($data['data'][0]['followed_at'])) {
    die("$username is not following $channel.");
}

$followedAt = strtotime($data['data'][0]['followed_at']);
$now = time();
$diffSeconds = $now - $followedAt;
$diffMinutes = round($diffSeconds / 60);
$diffHours = round($diffMinutes / 60);
$diffDays = round($diffHours / 24);

if ($diffMinutes < 60) {
    $diffText = "$diffMinutes minute" . ($diffMinutes == 1 ? '' : 's');
} elseif ($diffHours < 24) {
    $diffText = "$diffHours hour" . ($diffHours == 1 ? '' : 's');
} else {
    $diffText = "$diffDays day" . ($diffDays == 1 ? '' : 's');
}

echo "$username has been following for: $diffText.";
?>