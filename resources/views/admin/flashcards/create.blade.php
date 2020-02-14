@extends('layouts.app')
@section('content')
    <h3 align="center">FlashCards</h3>
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
        <a href="{{ route('admin.flashcard.index') }}" class="btn btn-secondary" style="margin-bottom: 10px;
        margin-right:120px;background-color: seagreen">Back</a>
    </div>
    <div class="container">
    <form method="post" action="{{ route('admin.flashcard.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" style="font-weight: bold">Word</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="word" placeholder="Input text">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label" style="font-weight: bold">Select Profile Image</label>
            <div class="col-sm-10">
                <input type="file" name="upload_path">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" style="font-weight: bold">Type</label>
            <div class="col-sm-10">
                <select name="type_id" class="form-control">
                    <option name="type_id" value="1">Radio button</option>
                    <option name="type_id" value="2">Input text</option>
                </select>
            </div>
        </div>
        <div class="form-group row" id="type1">
            <label class="col-sm-2 col-form-label" style="font-weight: bold">Answers of type Radio</label>
            <div class="col-sm-10">
                <input type="radio" name="chosen_answer" value="0">
                    <input type="text" class="form-control" name="answers_input[]" placeholder="Input Text"><br>
                <input type="radio" name="chosen_answer" value="1">
                    <input type="text" class="form-control" name="answers_input[]" placeholder="Input Text"><br>
                <input type="radio" name="chosen_answer" value="2">
                    <input type="text" class="form-control" name="answers_input[]" placeholder="Input Text"><br>
            </div>
        </div>
        <div class="form-group row d-none" id="type2">
            <label class="col-sm-2 col-form-label" style="font-weight: bold">Answers of type Input text</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="value_input" placeholder="Input Text">
            </div>
        </div>

        <div class="form-group row" style="margin-left: 16%">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </form>
    </div>
    <script>
        $(document).ready(function(){
            $('select').on('change', function() {
                var type = this.value;
                console.log(type);
                if (type == 2) {
                    $('#type1').addClass('d-none');
                    $('#type2').removeClass('d-none');
                }
                if (type == 1) {
                    $('#type1').removeClass('d-none');
                    $('#type2').addClass('d-none');
                }
            });
        });
    </script>
@endsection
