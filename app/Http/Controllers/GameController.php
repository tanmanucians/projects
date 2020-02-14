<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\GameFlashcard;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Score;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $games = Game::all();
        $scores = Score::orderBy('score', 'DESC')->take(5)->get();
        return view('games.index', compact('games', 'scores'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        //destroy old data
        session()->forget('timeStart');
        session()->forget('countTime_array');

        $now = time();
            //
        session()->put('timeStart', $now);
        //array declara containing timer
        session()->put('countTime_array', []);
        $game = Game::find($id);

        $flashcards = GameFlashcard::where('game_id', '=', $id)->count();
        $score = Score::where('game_id', '=', $id)->orderBy('score', 'DESC')->take(1)->get();     
        
        return view('games.show', compact('game', 'flashcards', 'score'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFlashcard($id)
    {
        return view('games.flashcard', compact('id'));
    }

    public function getFlashcard($id)
    {
        $flashcards = Game::find($id)->flashcards;
        $data = [];
        $dataAnswer = [];
        foreach ($flashcards as $flashcard) {
            array_push($data, $flashcard);
            array_push($dataAnswer, $flashcard->answerOptions);
         }
         return response()->json($flashcards, 200);
    }

    public function countTime(Request $request)
    {

        $oldtime = session()->get('timeStart');
        //return $oldtime;
        $spend_time = 0;//time_diff($oldtime, time());
        //push a value into a array
        session()->push('countTime_array', $spend_time);
        return session()->get('countTime_array');

    }

    public function result()
    {

        $countTime_array = session()->get('countTime_array');

        return view('games.result', compact('countTime_array'));
        //unset($_SESSION["timeStart"]);countTime_array
        //session_destroy();

    }

    public function checkAnswer(Request $request){
        $flashcard = Flashcard::find($request->flashcard_id);
        $right_answer_option_id = $flashcard->answer->right_answer_option_id;

        if ($request->answer_id == $right_answer_option_id) {
            return response()->json('true', 200);
        }
        else{
         return response()->json('false', 200);
        }

    }
    
    public function submitScore(Request $request){
        
        $scores = new Score;
        $scores->game_id = $request->game_id;
        $scores->user_id = Auth::user()->id;
        $scores->score = $request->score;
        $scores->created_by = Auth::user()->name;
        $scores->updated_by = Auth::user()->name;
        $scores->save();

        return response()->json('success', 200);
    }
    
}
