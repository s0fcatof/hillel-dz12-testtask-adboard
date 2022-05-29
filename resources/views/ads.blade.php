@extends('layout')

@section('content')
    <h2 style="text-align: center">Ads List</h2>
    @forelse($ads as $ad)
        <p><strong><a href="{{ route('ads.show', ['ad' => $ad->id]) }}">{{ $ad->title }}</a></strong> <small>by <i>{{ $ad->author->username }}</i> {{ $ad->created_at->diffForHumans() }} </small></p>
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
        <hr>
    @empty
        <p>No ads</p>
    @endforelse
    {{ $ads->links() }}
@endsection

@section('sidebar')
    <h2 style="text-align: center">Authentication</h2>
    @guest
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}">
                @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"  id="password" name="password">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    @endguest
    @auth
        <div style="text-align: center">
            <p>Hello, <strong>{{ \Illuminate\Support\Facades\Auth::user()->username }}</strong>!</p>
            <a href="{{ route('ads.create') }}" class="btn btn-secondary" role="button">Create Ad</a>
            <a href="{{ route('logout') }}" class="btn btn-danger" role="button">Logout</a>
        </div>
    @endauth
@endsection
