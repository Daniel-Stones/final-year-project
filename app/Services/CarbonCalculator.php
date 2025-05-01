<?php

namespace App\Services;

class CarbonCalculator
{
    // Emissions factors in kg CO₂e per tonne-km
    protected array $factors = [
        'truck' => 0.09696,   // Average laden diesel HGV
        'ship' => 0.01306,    // Refrigerated cargo ship
        'plane' => 1.099032,  // International refrigerated cargo plane
        'train' => 0.02779,   // Freight train
    ];

    public function estimateFromDistance(float $distanceKm, string $mode, float $weightKg): float
    {
        if (!isset($this->factors[$mode])) {
            throw new \InvalidArgumentException("Unsupported transport mode: $mode");
        }

        $factor = $this->factors[$mode];
        $tonnes = $weightKg / 1000;

        return $distanceKm * $tonnes * $factor;
    }
}
