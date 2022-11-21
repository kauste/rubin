<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Master;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    
    public function rate(Request $request){

        $validator = Validator::make($request->all(), [
            'rating' => ['required', 'integer', 'min:1', 'max:5']
        ]);
        if($validator->fails()){
            abort(404);
        };
        $rating = new Rating;
        $rating->user_id = Auth::user()->id;
        $rating->rate = $request->rating;
        $rating->master_id = $request->masterId;
        $rating->save();
        
        $newRating = round(Rating::where('master_id', $request->masterId)->avg('rate'), 2);
        return response()->json([
            'message' => 'Thank you for rating.',
            'newRating' => $newRating
        ]);
    }
}
