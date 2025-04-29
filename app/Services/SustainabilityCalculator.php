<?php

namespace App\Services;

class SustainabilityCalculator
{
    public function calculateScores($product)
    {
        $scores = [
            'packaging' => ['score' => 0, 'percent' => 0, 'text' => 'Packaging: No Data'],
            'palm_oil' => ['score' => 0, 'percent' => 0, 'text' => 'Palm oil: No Data'],
            'organic' => ['score' => 0, 'percent' => 0, 'text' => 'Organic: No Data'],
            'origin' => ['score' => 0, 'percent' => 0, 'text' => 'Origin distance: No Data'],
        ];

        if (!$product) {
            return ['scores' => $scores, 'totalScore' => 0];
        }

        // Packaging
        $packaging = $product['packaging'] ?? '';
        if (str_contains(strtolower($packaging), 'paper') || str_contains(strtolower($packaging), 'cardboard')) {
            $scores['packaging'] = ['score' => 2, 'percent' => 100, 'text' => 'Packaging: Cardboard'];
        } elseif (str_contains(strtolower($packaging), 'plastic')) {
            $scores['packaging'] = ['score' => 1, 'percent' => 50, 'text' => 'Packaging: Plastic'];
        }

        // Palm Oil
        if (isset($product['ingredients_analysis_tags']) && is_array($product['ingredients_analysis_tags'])) {
            if (in_array('en:palm-oil', $product['ingredients_analysis_tags'])) {
                $scores['palm_oil'] = ['score' => 0, 'percent' => 0, 'text' => 'Palm oil: Found'];
            } else {
                $scores['palm_oil'] = ['score' => 2, 'percent' => 100, 'text' => 'Palm oil: None'];
            }
        }

        // Organic
        $labels = $product['labels_tags'] ?? [];
        if (collect($labels)->some(fn($label) => str_contains(strtolower($label), 'organic') || str_contains(strtolower($label), 'bio'))) {
            $scores['organic'] = ['score' => 2, 'percent' => 100, 'text' => 'Organic: Yes'];
        }

        // Origin
        $origins = $product['origins'] ?? '';
        if (str_contains(strtolower($origins), 'united kingdom') || str_contains(strtolower($origins), 'uk')) {
            $scores['origin'] = ['score' => 2, 'percent' => 100, 'text' => 'Origin distance: Domestic'];
        } elseif ($origins) {
            $scores['origin'] = ['score' => 1, 'percent' => 50, 'text' => 'Origin distance: International'];
        }

        $totalScore = min(array_sum(array_column($scores, 'score')), 10);
        return ['scores' => $scores, 'totalScore' => $totalScore];
    }
}
