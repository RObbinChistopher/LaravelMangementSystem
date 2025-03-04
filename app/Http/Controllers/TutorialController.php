<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index(){
        $video = Tutorial::all();
        return response()->json($video);
    }

    public function videoCreate (Request $request){
        $video = new Tutorial();
        $video->urdu_link = $request->urdu_link;
        $video->english_link = $request->english_link;
        $video->save();
        return response()->json(['successFully' => 'create Successfully']);
    }

    public function editvideoLink(string $id)
    {
        $video = Tutorial::findOrFail($id);
        return response()->json($video);
    }
    public function videoUpdate (Request $request, string $id){
        $video = Tutorial::findOrFail($id);
        $video->urdu_link = $request->urdu_link;
        $video->english_link = $request->english_link;
        $video->save();
        return response()->json(['successFully' => 'Update Successfully']);
    }
    public function DeletevideoLink(string $id)
    {
        $video = Tutorial::findOrFail($id);
        $video->delete();
        return response()->json(['success' => 'Delete Successfully']);
    }
}
