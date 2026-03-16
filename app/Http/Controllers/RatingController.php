<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'article_id' => 'required',
        'rating' => 'required|integer|min:1|max:5'
    ]);

    Rating::updateOrCreate(
        [
            'user_id' => 1,
            'article_id' => $request->article_id
        ],
        [
            'rating' => $request->rating
        ]
    );

    return back();
}

}