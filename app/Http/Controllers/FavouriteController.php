<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use App\Models\Band;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function favourites()
    {
        $user = Auth::user();
        $favourites = Favourite::where('user_id', $user->id)->paginate(10);
        return view('favourites.favourites', ['favourites' => $favourites]);
    }

    public function store(Request $request)
    {
        $request->validate(['barcode' => 'required']);
        $user = Auth::user();
            Favourite::create([
                'user_id' => $user->id,
                'barcode' => $request->barcode,
            ]);
            
        return redirect()->back(); 
    }


    public function destroy(Request $request)
    {
        $request->validate(['barcode' => 'required']);

        $user = Auth::user();

        Favourite::where('user_id', $user->id)
            ->where('barcode', $request->barcode)
            ->delete();

        return redirect()->back(); 
    }


}
