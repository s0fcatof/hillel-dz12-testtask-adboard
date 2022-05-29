@extends('layout')

@section('content')
    <h2 style="text-align: center">Viewing Ad</h2>
    <p><strong>{{ $ad->title }}</strong> <small>by <i>{{ $ad->author->username }}</i> {{ $ad->created_at->diffForHumans() }} </small></p>
    {{ $ad->description }} <br><br>
    @can('update', $ad)
        <span style="float: left"><a href="{{ route('ads.edit', ['ad' => $ad->id]) }}" class="btn btn-outline-warning btn-sm" role="button">Edit</a></span>
    @endcan
    @can('delete', $ad)
        <form action="{{ route('ads.destroy', ['ad' => $ad->id]) }}" method="post">
            @method('delete')
            @csrf
            <input type="submit" class="btn btn-outline-danger btn-sm" role="button" value="Delete"/>
        </form>
    @endcan
@endsection
