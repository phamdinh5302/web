<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
//Admin controller
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'home'])->name('homepage');
Route::get('/danhmuc/{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/theloai/{slug}', [IndexController::class, 'genre'])->name('genre');
Route::get('/quocgia/{slug}', [IndexController::class, 'country'])->name('country');

Route::get('/phim/{slug}', [IndexController::class, 'movie'])->name('movie');
Route::get('/xem-phim/{slug}/{tap}', [IndexController::class, 'watch'])->name('watch');
Route::get('/so-tap', [IndexController::class, 'episode'])->name('so-tap');
Route::get('/nam/{year}', [IndexController::class, 'year'])->name('nam');
Route::get('/tag/{tag}', [IndexController::class, 'tag']);
Route::get('/tim-kiem', [IndexController::class, 'timkiem'])->name('tim-kiem');
Route::get('/locphim', [IndexController::class, 'locphim'])->name('locphim');


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//route admin
Route::resource('category', CategoryController::class);
Route::post('resorting',[CategoryController::class,'resorting'])->name('resorting');
Route::resource('genre', GenreController::class);
Route::resource('country', CountryController::class);

//them tap phim
Route::get('add-episode/{id}', [EpisodeController::class, 'add_episode'])->name('add-episode');
Route::resource('episode', EpisodeController::class);
Route::get('/select-movie', [EpisodeController::class, 'select_movie'])->name('select-movie');

Route::resource('movie', MovieController::class);
Route::get('/update-year-phim', [MovieController::class, 'update_year'])->name('update-year-phim');
Route::get('/update-topview-phim', [MovieController::class, 'update_topview'])->name('update-topview-phim');
Route::post('/filter-topview-phim', [MovieController::class, 'filter_topview'])->name('filter-topview-phim');
Route::get('/filter-topview-default', [MovieController::class, 'filter_default'])->name('filter-topview-default');
Route::get('/update-season-phim', [MovieController::class, 'update_season'])->name('update-season-phim');