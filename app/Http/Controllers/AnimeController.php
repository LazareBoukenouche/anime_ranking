<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Anime;
use App\Models\Review;
use DB;

class AnimeController extends Controller
{
    /**
     * Show all the animes.
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        $animes = DB::select("SELECT * FROM animes");
        return view('welcome', ["animes" => $animes]);
    }

    public function top()
    {
        // $rating = DB::select("SELECT AVG(rating) AS rating FROM review ORDER BY rating ASC");
        $animes = DB::select("SELECT animes.*,AVG(rating) AS rating
        FROM animes 
        JOIN review ON animes.id = review.anime_id
        GROUP BY animes.id, title, description, cover, updated_at, created_at
        ORDER BY rating DESC");
        return view('top', ["animes" => $animes]);
    }

    public function select($id) 
    {
        $anime = DB::select("SELECT animes.*,review.id AS hasReviewUserId FROM animes
        LEFT JOIN review ON review.anime_id = animes.id AND review.user_id = ?
        WHERE animes.id = ?",[Auth::user()->id, $id])[0];

        $rating = DB::select("SELECT AVG(rating) AS rating FROM review WHERE anime_id = ?",[$id])[0]->rating;

        // $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
        return view('anime', ["anime" => $anime,"rating" =>round($rating)]);

        
        
    }

    public function new_review($id) {

        if (Auth::check() === false) 
        {
            return redirect()->intended('/login');
        }

        $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
        return view("new_review",["anime" => $anime]);

        
    }

    public function create_review($anime_id, Request $request) 
    {
        
        $validated = $request->validate([
        "rating" => "required",
        "comment" => "required"
        ]);
        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->anime_id = $anime_id;
        $review->rating = $validated["rating"];
        $review->comment = $validated["comment"];
        $review->save();
        return redirect('/');
    }
}