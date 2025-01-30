<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}

function validateCoordinates($lat1, $lon1, $lat2, $lon2) {
    // Check if coordinates are numeric
    foreach(func_get_args() as $arg) {
        if(!is_numeric($arg)) return false;
    }
    // Check if longitudes in range
    foreach(array($lon1, $lon2) as $item) {
        if($item < -180 || $item > 180) return false;
    }
    // Check if latitudes are in range
    foreach(array($lat1, $lat2) as $item) {
        if($item < -90 || $item > 90) return false;
    }
    return true;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive data
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['lat1'], $input['lon1'], $input['lat2'], $input['lon2']) && validateCoordinates($input['lat1'], $input['lon1'], $input['lat2'], $input['lon2'])) {
        $lat1 = $input['lat1'];
        $lon1 = $input['lon1'];
        $lat2 = $input['lat2'];
        $lon2 = $input['lon2'];

        // Calculate distance
        $distance = calculateDistance($lat1, $lon1, $lat2, $lon2);
        $distance_km = floor($distance);
        $distance_m = floor(($distance - $distance_km) * 1000);

        // Respond with JSON
        echo json_encode([
            'distance_km' => $distance_km,
            'distance_m' => $distance_m
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

// Calculates distance using the haversine formula
function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // Radius of Earth in kilometers

    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    $dLat = $lat2 - $lat1;
    $dLon = $lon2 - $lon1;

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos($lat1) * cos($lat2) *
        sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c; // Distance in kilometers
}
