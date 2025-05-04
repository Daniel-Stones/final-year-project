<?php

namespace App\Services;

class SustainabilityCalculator
{
    protected DistanceCalculator $distance;
    protected CarbonCalculator $carbon;

    public function __construct(DistanceCalculator $distance, CarbonCalculator $carbon)
    {
        $this->distance = $distance;
        $this->carbon = $carbon;
    }

    public function calculateScores($product)
    {
        $scores = [
            'packaging' => ['score' => 0, 'percent' => 0, 'text' => 'Packaging: No Data'],
            'palm_oil' => ['score' => 0, 'percent' => 0, 'text' => 'Palm oil: No Data'],
            'organic' => ['score' => 0, 'percent' => 0, 'text' => 'Organic: No Data'],
            'origin' => ['score' => 0, 'percent' => 0, 'text' => 'Origin distance: No Data'],
            'emissions' => ['score' => 0, 'percent' => 0, 'text' => 'Transport Emissions: No Data'],
        ];

        if (!$product) {
            return ['scores' => $scores, 'totalScore' => 0];
        }

        $packaging = $product['packaging'] ?? '';
        if (str_contains(strtolower($packaging), 'paper') || str_contains(strtolower($packaging), 'cardboard')) {
            $scores['packaging'] = ['score' => 2, 'percent' => 100, 'text' => 'Packaging: Cardboard'];
        } elseif (str_contains(strtolower($packaging), 'plastic')) {
            $scores['packaging'] = ['score' => 1, 'percent' => 50, 'text' => 'Packaging: Plastic'];
        }


        if (isset($product['ingredients_analysis_tags']) && is_array($product['ingredients_analysis_tags'])) {
            if (in_array('en:palm-oil', $product['ingredients_analysis_tags'])) {
                $scores['palm_oil'] = ['score' => 0, 'percent' => 0, 'text' => 'Palm oil: Found'];
            } else {
                $scores['palm_oil'] = ['score' => 2, 'percent' => 100, 'text' => 'Palm oil: None'];
            }
        }


        $labels = $product['labels_tags'] ?? [];
        if (collect($labels)->some(fn($label) => str_contains(strtolower($label), 'organic') || str_contains(strtolower($label), 'bio'))) {
            $scores['organic'] = ['score' => 2, 'percent' => 100, 'text' => 'Organic: Yes'];
        }


        $origin = $product['origins'] ?? '';
        $weightKg = $this->parseWeightToKg($product['quantity'] ?? '');

        if ($origin) {
            $originLower = strtolower($origin);
            $isDomestic = str_contains($originLower, 'united kingdom') || str_contains($originLower, 'uk');

            if ($isDomestic) {
                // Use fixed average domestic distance 150km
                $distanceKm = 150;

                $contributions = [
                    'rail' => 0.08,
                    'road' => 0.80,
                    'water' => 0.12,
                ];

                $rail = $this->carbon->estimateFromDistance($distanceKm, 'train', $weightKg * $contributions['rail']);
                $road = $this->carbon->estimateFromDistance($distanceKm, 'truck', $weightKg * $contributions['road']);
                $water = $this->carbon->estimateFromDistance($distanceKm, 'ship', $weightKg * $contributions['water']);

                $totalCarbon = $rail + $road + $water;
                $scores['origin'] = ['score' => 2, 'percent' => 100, 'text' => 'Origin: Domestic'];

            } else {
                $originCoords = $this->distance->getCoordinates($origin);
                $ukCoords = $this->distance->getCoordinates("United Kingdom");

                if ($originCoords && $ukCoords) {
                    $distanceKm = $this->distance->haversine($originCoords[0], $originCoords[1], $ukCoords[0], $ukCoords[1]);

                    $contributions = [
                        'air' => 0.0016,
                        'rail' => 0.0990,
                        'road' => 0.3097,
                        'water' => 0.5897,
                    ];

                    $air = $this->carbon->estimateFromDistance($distanceKm, 'plane', $weightKg * $contributions['air']);
                    $rail = $this->carbon->estimateFromDistance($distanceKm, 'train', $weightKg * $contributions['rail']);
                    $road = $this->carbon->estimateFromDistance($distanceKm, 'truck', $weightKg * $contributions['road']);
                    $water = $this->carbon->estimateFromDistance($distanceKm, 'ship', $weightKg * $contributions['water']);

                    $totalCarbon = $air + $rail + $road + $water;

                    $scores['origin'] = ['score' => 0, 'percent' => 0, 'text' => 'Origin: International'];
                }
            }
            $emissionsScore = match (true) {
                $totalCarbon <= 50 => 2,
                $totalCarbon <= 200 => 1,
                default => 0,
            };
        
            // Calculate inverse percentage (lower emissions = higher percent)
            $emissionsPercent = max(0, min(100, 100 - ($totalCarbon / 2))); 
        
            $scores['emissions'] = [
                'score' => $emissionsScore,
                'percent' => $emissionsPercent,
                'text' => 'Transport Emissions: ' . round($totalCarbon, 2) . ' kg CO₂e',
            ];
        }

        $totalScore = min(array_sum(array_column($scores, 'score')), 10);
        return ['scores' => $scores, 'totalScore' => $totalScore];
    }

    protected function parseWeightToKg($quantity): float
    {
        if (!$quantity || !is_string($quantity)) {
            return 1.0; // Default to 1kg
        }

        preg_match('/([\d.,]+)\s*(g|kg)/i', strtolower($quantity), $matches);

        if (!isset($matches[1]) || !isset($matches[2])) {
            return 1.0; // Fallback
        }

        $value = floatval(str_replace(',', '.', $matches[1]));
        $unit = trim($matches[2]);

        return $unit === 'g' ? $value / 1000 : $value;
    }
}