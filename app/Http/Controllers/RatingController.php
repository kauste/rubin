<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Master;
use Illuminate\Http\Request;
use Auth;

class RatingController extends Controller
{
    
    public function rate(Request $request, Master $master){
        dump($request);
        $rating = new Rating;
        $rating->user_id = Auth::user()->id;
        $rating->rate = $request->rating;
        $rating->master_id = $master->id;
        $rating->save();
        
        return redirect()->back()->with('message', 'Thank you for rating.');
    }
}
