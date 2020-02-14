<?php

namespace App\Http\Controllers\Admin;

use App\Models\Flashcard;
use App\Models\GameFlashcard;
use App\Models\Game;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class GameController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $games = Game::latest()->paginate(5);
        return view('admin.games.index', compact('games'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $flashcards = Flashcard::all();
        return view('admin.games.create', compact('flashcards'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        // game
        $game = new Game;
        $game->name = $request->name;
        $game->created_by = Auth::user()->name;
        $game->updated_by = Auth::user()->name;
        $game->save();

        // game_flashcard
        foreach ($request->flashcard as $m) {
            $game_flashcard = new GameFlashcard;
            $game_flashcard->game_id = $game->id;
            $game_flashcard->flashcard_id = $m;
            $game_flashcard->created_by = Auth::user()->name;
            $game_flashcard->updated_by = Auth::user()->name;
            $game_flashcard->save();
        }
        return redirect(route('admin.games.index'))->with('success', 'Data Added successfully');
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * @param Game $game
     * @param GameFlashcard $game_flashcard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Game $game, GameFlashcard $game_flashcard)
    {
        $flashcards = Flashcard::all();
        $game_flashcard = GameFlashcard::all();
        //return ($game->flashcards->pluck('id')->toArray());
        return view('admin.games.edit', compact('flashcards', 'game_flashcard', 'game'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'flashcard' => 'required|min:1',
        ]);
        $game = Game::find($id);
        $game->flashcards()->detach();
        $game->name = $request->name;
        $game->created_by = Auth::user()->name;
        $game->updated_by = Auth::user()->name;
        $game->save();

        // game_flashcard
        foreach ($request->flashcard as $m) {
            $game_flashcard = new GameFlashcard;
            $game_flashcard->game_id = $game->id;
            $game_flashcard->flashcard_id = $m;
            $game_flashcard->created_by = Auth::user()->name;
            $game_flashcard->updated_by = Auth::user()->name;
            $game_flashcard->save();
        }
        return redirect(route('admin.games.index'))->with('success', 'Update Data successfully');
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }


}

