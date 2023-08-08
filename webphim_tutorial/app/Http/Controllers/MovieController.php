<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie_Genre;
use App\Models\Episode;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Facades\File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Movie::with('category', 'movie_genre', 'country','genre' )->withCount('episode')->orderBy('id', 'DESC')->get();

        //doi thanh ma json de tim kiem phim
        $path = public_path()."/json/";
        if(!is_dir($path)){
            mkdir($path,077,true);
        }
        File::put($path.'movie.json',json_encode($list));
        
        return view('admincp.movie.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update_year(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }

    public function update_season(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }

    public function update_topview(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }

    public function filter_topview(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('ngaycapnhat','DESC')->take(10)->get();
        $output = '';
        foreach ($movie as $key => $mov){
            if($mov->resolution==0){
                    $text = 'HD';
            } elseif($mov->resolution==1){
                $text = 'SD';
            }elseif($mov->resolution==2){
                $text = 'HDCam';
            }elseif($mov->resolution==3){
                $text = 'Cam';
            } else{
                $text = 'FullHD';
            }
            $output .='<div class="item">
                            <a href="'.url('phim/'. $mov->slug).'" title="'.$mov->title. '">
                                <div class="item-link">
                                    <img src="'.url('uploads/movie/' . $mov->image).'"
                                        class="lazy post-thumb" alt="'. $mov->title.'"
                                        title="'. $mov->title.'" />
                                    <span class="is_trailer">
                                        '.$text.'
                                    </span>
                                </div>
                                <p class="title">'. $mov->title.'</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                            <div style="float: left;">
                                <span class="user-rate-image post-large-rate stars-large-vang"
                                    style="display: block;/* width: 100%; */">
                                    <span style="width: 0%"></span>
                                </span>
                            </div>
                        </div>';
        }
        return $output;
    }

    public function filter_default(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('ngaycapnhat','DESC')->take(10)->get();
        $output = '';
        foreach ($movie as $key => $mov){
            if($mov->resolution==0){
                    $text = 'HD';
            } elseif($mov->resolution==1){
                $text = 'SD';
            }elseif($mov->resolution==2){
                $text = 'HDCam';
            }elseif($mov->resolution==3){
                $text = 'Cam';
            } else{
                $text = 'FullHD';
            }
            $output .='<div class="item">
                            <a href="'.url('phim/'. $mov->slug).'" title="'.$mov->title. '">
                                <div class="item-link">
                                    <img src="'.url('uploads/movie/' . $mov->image).'"
                                        class="lazy post-thumb" alt="'. $mov->title.'"
                                        title="'. $mov->title.'" />
                                    <span class="is_trailer">
                                        '.$text.'
                                    </span>
                                </div>
                                <p class="title">'. $mov->title.'</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
                            <div style="float: left;">
                                <span class="user-rate-image post-large-rate stars-large-vang"
                                    style="display: block;/* width: 100%; */">
                                    <span style="width: 0%"></span>
                                </span>
                            </div>
                        </div>';
        }
        return $output;
    }

     
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $list_genre = Genre::all();
        return view('admincp.movie.form', compact('category', 'country', 'genre', 'list_genre'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->sotap = $data['sotap'];
        $movie->tags = $data['tags'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->trailer = $data['trailer'];
        $movie->resolution = $data['resolution'];
        $movie->subtitle = $data['subtitle'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->country_id = $data['country_id'];
        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
        
        //them the loai
        foreach($data['genre'] as $key =>$gen){
            $movie->genre_id = $gen[0];
        }
        
        //them hinh anh
        $get_image = $request->file('image');
        if ($get_image) {

            $get_name_image = $get_image->getClientOriginalName(); //hinhanh1.jpg
            $name_image = current(explode('.', $get_name_image)); //[0] => hinhanh . [1] => jpg
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension(); // hinhanh12569.jpg
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        
        //them nhieu the loai 
        $movie->movie_genre()->attach($data['genre']);
        
        return redirect()->route('movie.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        $list_genre = Genre::all();
        return view('admincp.movie.form', compact('category', 'country', 'genre', 'movie','list_genre','movie_genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->sotap = $data['sotap'];
        $movie->tags = $data['tags'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->trailer = $data['trailer'];
        $movie->resolution = $data['resolution'];
        $movie->subtitle = $data['subtitle'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->country_id = $data['country_id'];
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

        //them the loai
        foreach($data['genre'] as $key =>$gen){
            $movie->genre_id = $gen[0];
        }
        
        //them hinh anh
        $get_image = $request->file('image');
        if ($get_image) {
            if (file_exists('uploads/movie/' . $movie->image)) {
                unlink('uploads/movie/' . $movie->image);
            } else{
                $get_name_image = $get_image->getClientOriginalName(); //hinhanh1.jpg
                $name_image = current(explode('.', $get_name_image)); //[0] => hinhanh . [1] => jpg
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension(); // hinhanh12569.jpg
                $get_image->move('uploads/movie/', $new_image);
                $movie->image = $new_image;
            }
        }
        $movie->save();

        $movie->movie_genre()->sync($data['genre']);
        
        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie =  Movie::find($id);
        //xoa anh
        if (file_exists('uploads/movie/' . $movie->image)) {
            unlink('uploads/movie/' . $movie->image);
        }
        //xoa the loai
        
        Movie_Genre::whereIn('movie_id',[ $movie->id])->delete();
        //xoa tap phim
        Episode::whereIn('movie_id',[ $movie->id])->delete();
        $movie->delete();
        
        return redirect()->back();
    }
}