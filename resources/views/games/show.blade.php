@extends('layouts.homepage')
@section('content')
    <div class=" mt-5 text-center">
        <h1 class="">{{$game->name}}</h1>
        <h3 class="">Number Card: {{$flashcards}}</h3>
    </div>
    <div class="text-center">
        @foreach($score as $score)
            <h3 class="text-warning">Highest marks: {{$score->score}}</h3>
        @endforeach
    
    <div class="text-center">
        <h3 class="text-warning">Toppic</h3>
    </div>
    <br>
    <a href="/games/{{$game->id}}/flashcard/">
        <div class="text-center">
            <button class="btn btn-info" style="width:160px" name="name">Play Now</button>
        </div>
    </a>
@endsection

