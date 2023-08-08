<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use DB;
use Nette\Utils\Strings;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function home()
    {
        $phimhot = Movie::withCount('episode')->where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->get();
        
        $country = Country::orderBy('id', 'DESC')->get();
        $category_home = Category::with(['movie' => function($q){$q->withCount('episode'); }])->orderBy('id', 'DESC')->where('status', 1)->get();
        return view('pages.home', compact('category', 'genre', 'country', 'category_home', 'phimhot','phimhot_sidebar'));
    }
    
    public function timkiem()
    {
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            
            $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
            $genre = Genre::orderBy('id', 'ASC')->get();
            $country = Country::orderBy('id', 'DESC')->get();
            $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take('5')->get();
            
            //lay phim theo trang
            $movie = Movie::where('title', 'LIKE', '%'.$search.'%' )->orWhere('name_eng', 'LIKE', '%'.$search.'%' )->orderBy('ngaycapnhat', 'DESC')->paginate(40);
            return view('pages.search', compact('category', 'genre', 'country', 'search', 'movie','phimhot_sidebar'));
        }else{
             return redirect()->to('/');
        }
        
    }
    public function locphim(){
        $sapxep = $_GET['oder'];
        $genre = $_GET['genre'];
        $country = $_GET['country'];
        $year = $_GET['year'];
        
       
        if ($sapxep=='' && $genre=='' && $country=='' && $year=='') {
            return redirect()->back();
        }else{
            
        }
    }
    
    public function category($slug)
    {
        //lay ra danh muc phim
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        //lay phim theo slug
        $cate_slug = Category::where('slug', $slug)->first();
        //lay phim theo trang
        $movie = Movie::where('category_id', $cate_slug->id)->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.category', compact('category', 'genre', 'country', 'cate_slug', 'movie','phimhot_sidebar'));
    }
    public function year($year)
    {
        //lay ra danh muc phim
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        //lay phim theo slug
        $year = $year;
        //lay phim theo trang
        $movie = Movie::where('year', $year)->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.year', compact('category', 'genre', 'country', 'year', 'movie','phimhot_sidebar'));
    }
    public function tag($tag)
    {
        //lay ra danh muc phim
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        //lay phim theo slug
        $tag = $tag;
        //lay phim theo trang
        $movie = Movie::where('tags','LIKE','%'.$tag.'%')->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.tag', compact('category', 'genre', 'country', 'tag', 'movie','phimhot_sidebar'));
    }
    public function genre($slug)
    {
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        $gen_slug = Genre::where('slug', $slug)->first();

        $movie_genre = Movie_Genre::where('genre_id',$gen_slug->id)->get();
        $many_genre = [];
        foreach($movie_genre as $key => $mov){
            $many_genre[] = $mov->movie_id;
        }
        
        $movie = Movie::whereIn('id', $many_genre)->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.genre', compact('category', 'genre', 'country', 'gen_slug', 'movie','phimhot_sidebar'));
    }
    public function country($slug)
    {
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();
        $count_slug = Country::where('slug', $slug)->first();

        $movie = Movie::where('country_id', $count_slug->id)->orderBy('ngaycapnhat', 'DESC')->paginate(40);
        return view('pages.country', compact('category', 'genre', 'country', 'count_slug', 'movie','phimhot_sidebar'));
    }
    public function movie($slug)
    {
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();

        $movie = Movie::with('category', 'country', 'genre')->where('slug', $slug)->where('status', 1)->first();
        //hien thi tap dau khi xem phim
        $episode_tapdau = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode', 'ASC')->take(1)->first();
        //phim lien quan
        $related = Movie::with('category', 'genre', 'country','movie_genre')->where('category_id', $movie->category->id)->orderBy('DB'::raw('RAND()'))->whereNotIn('slug', [$slug])->get();
        //lay 3 tapp moi nhat
        $episode= Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode', 'DESC')->take(3)->get();
        //lay tong tap phim da them
        $episode_current_list= Episode::with('movie')->where('movie_id',$movie->id)->get();
        $episode_current_lis_count = $episode_current_list->count();
        
        
        return view('pages.movie', compact('category', 'genre', 'country', 'movie', 'related','phimhot_sidebar','episode','episode_tapdau','episode_current_lis_count'));
    }
    
    public function watch($slug,$tap)
    {
        
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->get();
        $country = Country::orderBy('id', 'DESC')->get();
        $phimhot_sidebar = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('ngaycapnhat', 'DESC')->take(5)->get();

        $movie = Movie::with('category', 'country', 'genre')->where('slug', $slug)->where('status', 1)->first();
        //phim lien quan
        $related = Movie::with('category', 'genre', 'country','movie_genre','episode')->where('category_id', $movie->category->id)->orderBy('DB'::raw('RAND()'))->whereNotIn('slug', [$slug])->get();

        //lay tap phim hoac tap 1
        if (isset($tap)) {
            $tapphim = $tap;
            $tapphim = substr($tap, 4,20); //lay ky tu sau chu tap-
            $episode= Episode::where('movie_id',$movie->id)->where('episode', $tapphim)->first();
        } else {
            $tapphim = 1;
            $episode= Episode::where('movie_id',$movie->id)->where('episode', $tapphim)->first();
        }
        
        
        return view('pages.watch', compact('category', 'genre', 'country', 'movie', 'related','phimhot_sidebar','episode','tapphim'));
    }
    public function episode()
    {
        return view('pages.episode');
    }
}