@extends('layout')

@section('content')
    <h2 style="text-align: center">@if(isset($ad)) Updating @else Creating @endif Ad</h2>
    <form action="@if(isset($ad)) {{ route('ads.update', ['ad' => $ad->id]) }} @else {{ route('ads.store') }} @endif" method="post">
        @if(isset($ad)) @method('put') @endif
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="@if(isset($ad)) {{ old('title', $ad->title) }} @else {{ old('title') }} @endif">
            @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">@if(isset($ad)) {{ old('description', $ad->description) }} @else {{ old('description') }} @endif</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">@if(isset($ad)) Save @else Create @endif Ad</button>
    </form>
@endsection
