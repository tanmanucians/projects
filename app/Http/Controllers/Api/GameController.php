<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Score;
use App\Models\Flashcard;
use App\Models\Game_Flashcard;
use DB;
use App\Account;


class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $games = Game::all();
       $data = [];
       foreach ($games as $game) {
            array_push($data, [
                'id'=>$game->id,
                'name' => $game->name,
                'upload_path' => $game->image
            ]);
        }
       return response()->json($data);
    } 
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request ,$id)
   {
       $game=Game::find($id);
       $data=[];

        $data['id'] = $game->id;
        $data['name'] = $game->name;
        $data['upload_path'] = $game->image;
        $data['score'] = $game->maxScore;
        $data['flashcard_total'] = $game->total;
        $data['flashcard_id'] = $game->flashcardIds;   
       // dd( $game); 
    return response()->json($data);
   }

}
