@extends('layout')

@section('content')
    <h3 style="text-align: center">@isset($ad) Updating @else Creating @endisset Ad</h3>
    <form action="@isset($ad) {{ route('ads.update', ['ad' => $ad->id]) }} @else {{ route('ads.store') }} @endisset" method="post">
        @isset($ad) @method('put') @endisset
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="@isset($ad) {{ old('title', $ad->title) }} @else {{ old('title') }} @endisset">
            @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">@isset($ad) {{ old('description', $ad->description) }} @else {{ old('description') }} @endisset</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">@isset($ad) Save @else Create @endisset Ad</button>
    </form>
@endsection
