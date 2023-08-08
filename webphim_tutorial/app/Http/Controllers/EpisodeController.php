<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use Carbon\Carbon;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list_episode = Episode::with('movie')->orderBy('movie_id','DESC')->get();
        // return reponse()->json($list_episode);
        return view('admincp.episode.index',compact('list_episode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list_movie = Movie::orderBy('id','DESC')->pluck('title','id');
        return view('admincp.episode.form',compact('list_movie'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $episode_check = Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->count();
        if($episode_check>0){
            return redirect()->back();
        }else{
            $ep = new Episode();
            $ep->movie_id = $data['movie_id'];
            $ep->linkphim = $data['link'];
            $ep->episode = $data['episode'];
            $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $ep->save();
        }
        
        return redirect()->back();
    }
    public function add_episode($id){
        $movie = Movie::find($id);
        $list_episode = Episode::with('movie')->where('movie_id',$id)->orderBy('episode','DESC')->get();
        // return reponse()->json($list_episode);
        return view('admincp.episode.add_episode',compact('list_episode','movie'));
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
        $list_movie = Movie::orderBy('id','DESC')->pluck('title','id');
        $episode = Episode::find($id);
        return view('admincp.episode.form',compact('episode','list_movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $ep = Episode::find($id);
        $ep->movie_id = $data['movie_id'];
        $ep->linkphim = $data['link'];
        $ep->episode = $data['episode'];
        $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep->save();
        return redirect()->to('episode');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Episode::find($id)->delete();
        return redirect()->to('episode');
    }
    public function select_movie(){
        $id = $_GET['id'];
        $movie = Movie::find($id);
        $output='<option>---Chọn tập phim---</option>';
        
        
        
            if ($movie->thuocphim == 'phimbo') {
                for($i=1;$i<=$movie->sotap;$i++){
                    $output.='<option value="'.$i.'">'.$i.'</option>';
                }
            } else {
                $output.='<option value="full">full</option>';
            }
            
        echo $output;
    }
}