<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Anime;
use App\Models\Review;
use App\Models\Watchlist;
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
        $anime = DB::select("SELECT * FROM animes
        WHERE id = ?",[$id])[0];
        $has_review = false;
        $in_watchlist = false;

        if (Auth::user()) {
            // check if the user has reviewed the anime
            $review = DB::select("SELECT * FROM review WHERE user_id = ? AND anime_id = ?",[Auth::user()->id,$id]);
            
            $has_review = (count($review) > 0);
            
            // check if the user has added the anime to his watchlist
            $watchlist = DB::select("SELECT * FROM watchlist WHERE user_id = ? AND anime_id = ?",[Auth::user()->id,$id]);
        
            $in_watchlist = (count($watchlist) > 0);
        }
        
        

        $rating = DB::select("SELECT AVG(rating) AS rating FROM review WHERE anime_id = ?",[$id])[0]->rating;

        // $anime = DB::select("SELECT * FROM animes WHERE id = ?", [$id])[0];
        return view('anime', ["anime" => $anime,"rating" =>round($rating),
        "has_review" => $has_review,"in_watchlist" => $in_watchlist]);

        
        
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

    // public function new_watch_list() 
    // {
    //     if (Auth::check() === false) 
    //     {
    //         return redirect()->intended('/login');
    //     }
        
    //     return view("new_watch_list");
    // }

    public function add_to_watch_list($id, Request $request) 
    {
        
        $watchlist = new Watchlist();
        $watchlist->user_id = Auth::user()->id;
        $watchlist->anime_id = $id;
        
        $watchlist->save();
        return redirect("/anime/$id");
    }

    public function delete_from_watch_list($id, Request $request) 
    {

    }

    public function display_watch_list()
    {
        $animes = DB::select("SELECT * FROM watchlist 
        JOIN animes ON animes.id = anime_id
        WHERE user_id = ?",[Auth::user()->id]);

        return view('/watchlist', ["animes" => $animes]);
    }
}