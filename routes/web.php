<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Anime;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// we use the list method of the class AnimeController
// to list all the anime(s)
Route::get('/', [AnimeController::class, 'list']);

// we use the select method of the class AnimeController
// to view a specific anime
Route::get('/anime/{id}', [AnimeController::class,'select']);


// we use the sort method of the class AnimeController
// to sort the animes 
Route::get('/top', [AnimeController::class,'top']);

// we use the new_review method of the class AnimeController
// to display the form for typing a review
Route::get('/anime/{id}/new_review', [AnimeController::class,'new_review']);

// we use the create_review method of the class AnimeController
// to create a review of an anime
Route::post('/anime/{id}/new_review', [AnimeController::class,'create_review']);

// we use the add_to_watch_list method of the class AnimeController
// to add an anime to the watchlist of the user
Route::post('/anime/{id}/add_to_watch_list',[AnimeController::class,'add_to_watch_list']);

// we use the display_watch_list method of the class AnimeController
// to display the watchlist
Route::get('/watchlist',[AnimeController::class,'display_watch_list']);

// we use the login method of the class UserController
// to log in 
Route::get('/login', [UserController::class,'login']); 

// we use the check_login method of the class UserController
// to validate the user trying to log in
Route::post('/login', [UserController::class,'check_login']); 

// we use the signup method of the class UserController
// to create an account 
Route::get('/signup', [UserController::class,'signup']); 

// we use the check_signup method of the class UserController
// to validate the account
Route::post('/signup', [UserController::class,'check_signup']); 

// we use the signout method of the class UserController
// to disconnect the user 
Route::post('/signout', [UserController::class,'signout']); 

