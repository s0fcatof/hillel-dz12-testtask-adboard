<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdController
{
    public function index()
    {
        $ads = Ad::with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('ads', compact('ads'));
    }

    public function create()
    {
        return view('ads.edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required']
        ]);

        $data = $request->all();

        $ad = new Ad();
        $ad->title = $data['title'];
        $ad->description = $data['description'];
        $ad->author_id = Auth::user()->id;
        $ad->save();

        return view('ads.show', compact('ad'));
    }

    public function show(Ad $ad)
    {
        return view('ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        return view('ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required']
        ]);

        $ad->update($request->all());

        return view('ads.show', compact('ad'));
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        return redirect()->route('ads.index');
    }
}
