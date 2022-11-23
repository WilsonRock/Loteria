<?php

namespace App\Http\Controllers;
use App\Supports\PathsS3;
use Illuminate\Support\Facades\Log;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Resources\VideoResource;
use App\Http\Controllers\Videos;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VideoResource::collection(Video::latest()->paginate());
        // $Videos=Videos::latest()->orderBy('score', 'asc')->paginate();
        //return $Videos; //
        //return VideosResource::collection(Videos::latest()->paginate());
    }
    public function create(Request $request)
    {
        $videos = new Video();
/*         $request->validate([
            'image' => 'required|image',
        ]); */
        //return dd($request);
      //  $image = Storage::disk('s3')->put(PathsS3::getPathFiles(), $request->image);
        try {
            $videos->title= $request->input('title');
            //$videos->score= $request->input('score');
            $videos->category= $request->input('category');
            $videos->link= $request->input('link');
            $videos->id_game="1";
          //  $videos->image = $image;
            //$videos->image= $request->input('image');
          /*   $videos->description= $request->input('description'); */

            ///////////////////////////
            $res = $videos->save();
           // $contact = Videos::create($request->all());

           return response($res, 200);
        } catch(\Exception $e) {
            dd($e);
            Log::error($e);
            return response()->json(['error'=>'Ha ocurrido un error inesperado'], 500);
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function show(Videos $videos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $product=Videos::find($id);
        $product->update($request->all());
        //$product->count = $request->count;
        //return dd($request->count);
        //$product->save();
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return Product::destroy($id);
        $res = Videos::destroy($id);
        if ($res) {
            return response()->json(['message' => 'Video Eliminado']);
        }

        return response()->json(['message' => 'Error no se pudo eliminar el video'], 500);

    }
}
