<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Ball,Bucket};

class BallController extends Controller
{
    public function create()
    {
        return view('balls.create');
    }

    public function store(Request $request)
    {
        Bucket::query()->update(['current_capacity' => \DB::raw('capacity')]);
        Ball::create([
            'size' => $request->input('size'),
            'colour' => $request->input('colour'),
        ]);
        return redirect()->route('index')->with('success', 'Balls created successfully');
    }
}