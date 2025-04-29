<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\SustainabilityCalculator;

class ProductController extends Controller
{
    protected $scorer;

    public function __construct(SustainabilityCalculator $scorer)
    {
        $this->scorer = $scorer;
    }

    public function show(Request $request)
    {
        $barcode = $request->query('barcode');
        $response = Http::get("https://world.openfoodfacts.org/api/v0/product/{$barcode}.json");
        $product = $response->successful() && $response['status'] === 1 ? $response['product'] : null;

        $result = $this->scorer->calculateScores($product);
        $scores = $result['scores'];
        $totalScore = $result['totalScore'];

        return view('product_views.result', compact('barcode', 'product', 'scores', 'totalScore'));
    }
}
