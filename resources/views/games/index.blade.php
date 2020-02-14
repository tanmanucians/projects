@extends('layouts.homepage')
@section('content')
<div style="float:left; margin-left:30%;"  >
    <div class="d-flex justify-content-center" style="padding-top: 40px">
        <h1 class='mt-3 '>Game FlashCard</h1>
    </div>
    <div class="d-flex justify-content-center">
            <h5 class="text-warning">Please choose your game</h5>
    </div>
    <br>
    <tr>
        @foreach ($games as $game)
            <div class="text-center">
                <a href="/games/{{$game->id}}">
                    <button class="btn btn-info" style="width:160px" name ="name" >{{ $game->name}}</button>
                </a>
            </div>
            <br>
        @endforeach
    </tr>
</div>
    <div style="float:right; margin-right:6%; padding-top:60px">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Game Name</th>
                <th scope="col">Score</th>
                </tr>
            </thead>
            <tbody>

                @foreach($scores as $score)
                <tr>
                    <th scope="row">{{$score ->id}}</th>
                    <td>{{$score->users->name}}</td>
                    <td>{{$score->games->name}}</td>
                    <td>{{$score->score}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    
@endsection
