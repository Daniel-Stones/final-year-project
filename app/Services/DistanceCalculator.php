<?php

namespace App\Services;

class DistanceCalculator
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_API_KEY');
    }

    public function getCoordinates(string $place): ?array
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($place) . "&key=" . $this->apiKey;
        $response = @file_get_contents($url);

        if (!$response) return null;

        $data = json_decode($response, true);
        if ($data['status'] === 'OK') {
            $loc = $data['results'][0]['geometry']['location'];
            return [$loc['lat'], $loc['lng']];
        }

        return null;
    }

    public function haversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; 
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $dLat = $lat2 - $lat1;
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 1);
    }
}
