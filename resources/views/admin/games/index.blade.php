@extends('layouts.app')
@section('content')
    <h3 align="center">Games</h3>
    <div align="right">
        <a href="{{ route('admin.games.create') }}" class="btn btn-success btn-sm" style="margin-bottom: 10px;
        margin-right: 130px">Add</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success" style="width: 15%;margin-left: 9%;">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container">
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th width="10%">STT</th>
                <th>Name</th>
                <th width="20%">Action</th>
            </tr>
            @foreach ($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>{{ $game->name }}</td>
                    <td>
                        <form action="{{route('admin.games.destroy',$game->id)}}" method="post">
                            <a class="btn btn-primary" href="{{route('admin.games.edit',$game->id)}}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    {!! $games->links() !!}
@endsection
