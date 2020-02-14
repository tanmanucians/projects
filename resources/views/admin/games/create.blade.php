@extends('layouts.app')
@section('content')
    <h3 align="center">Games</h3>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div align="right">
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary" style="margin-bottom: 10px;
        margin-right:120px;background-color: seagreen">Back</a>
    </div>
    <div class="container">
        <form action="{{ Route('admin.games.store')}}" method="post">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" style="font-weight: bold">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" placeholder="Input text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" style="font-weight: bold">Select Flashcard</label>
                <div class="col-sm-10">
                    <select class="selectpicker form-control" multiple data-live-search="true" name="flashcard[]">
                        @foreach($flashcards as $flashcard)
                            <option value="{{$flashcard->id}}">{{$flashcard->word}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row" style="margin-left: 16%">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>

@endsection
