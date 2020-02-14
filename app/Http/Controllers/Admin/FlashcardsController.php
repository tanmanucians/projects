<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Models\AnswerOption;
use App\Models\Flashcard;
use App\models\Type;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $flashcards = Flashcard::latest()->paginate(5);
         $types = Type::all();
        return view('admin.flashcards.index', compact('flashcards','types'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $answer_option = new AnswerOption;
        return view('admin.flashcards.create',compact('answer_option'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
        ]);
        if ($request->upload_path) {
            $upload_path = $request->file('upload_path');
            $new_name = rand() . '.' . $upload_path->getClientOriginalExtension();
            $upload_path->move(public_path('images'), $new_name);
        }

        // Flashcard
        if ($request->type_id == 1){
            //flashcard
            $flashcard = new Flashcard;
            $flashcard->type_id = $request->type_id;
            $flashcard->word = $request->word;
            $flashcard->upload_path = $request->file('upload_path') ? $new_name : null;
            $flashcard->created_by = Auth::user()->name;
            $flashcard->updated_by = Auth::user()->name;
            $flashcard->save();

            //answerOptions
            $chosen_answer = null;
              // print($request->answers_input);
              // die();
              foreach($request->answers_input as $key =>  $v) {
               $answer_option = new AnswerOption;
                $answer_option->flashcard_id = $flashcard->id;
                $answer_option->value = $v;
                $answer_option->created_by = Auth::user()->name;
                $answer_option->updated_by = Auth::user()->name;
                $answer_option->save();

                if ($key == $request->chosen_answer){
                    $chosen_answer = $answer_option->id;
                }
              }
            // Answer
          $answer = new Answer;
          $answer->flashcard_id = $flashcard->id;
          $answer->type_id = $request->type_id;
          $answer->right_answer_option_id = $chosen_answer;
          $answer->created_by = Auth::user()->name;
          $answer->updated_by = Auth::user()->name;
          $answer->save();
            return redirect(route('admin.flashcard.index'))->with('success', 'Data Added successfully');
        } else {
            $flashcard = new Flashcard;
            $flashcard->word = $request->word;
            $flashcard->upload_path = $request->file('upload_path') ? $new_name : null;
            $flashcard->type_id = $request->type_id;
            $flashcard->created_by = Auth::user()->name;
            $flashcard->updated_by = Auth::user()->name;
            $flashcard->save();

            // Answer Option
            $answer_option = new AnswerOption;
            $answer_option->flashcard_id = $flashcard->id;
            $answer_option->value = $request->value_input;
            $answer_option->created_by = Auth::user()->name;
            $answer_option->updated_by = Auth::user()->name;
            $answer_option->save();

            // Answer
            $answer = new Answer;
            $answer->flashcard_id = $flashcard->id;
            $answer->type_id = $request->type_id;
            $answer->right_answer_option_id = $answer_option->id;
            $answer->created_by = Auth::user()->name;
            $answer->updated_by = Auth::user()->name;
            $answer->save();
            return redirect(route('admin.flashcard.index'))->with('success', 'Data Added successfully');
        }
    }

    /**
     * @param Flashcard $flashcard
     */
    public function show(Flashcard $flashcard)
    {
        //
    }

    /**
     * @param Flashcard $flashcard
     */
    public function edit(Flashcard $flashcard)
    {
        //
    }

    /**
     * @param Request $request
     * @param Flashcard $flashcard
     */
    public function update(Request $request, Flashcard $flashcard)
    {
        //
    }

    /**
     * @param Flashcard $flashcard
     */
    public function destroy(Flashcard $flashcard)
    {
        //
    }
}
