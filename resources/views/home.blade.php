@extends('layouts.app')

@section('content')
<div class="container">
    <div class="movie-list">
        @foreach($movies as $movie)
            <movie id="{{ $movie['id'] }}"></movie>
        @endforeach
    </div>
</div>
@endsection
