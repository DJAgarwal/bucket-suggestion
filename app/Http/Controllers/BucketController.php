<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Bucket};

class BucketController extends Controller
{
    public function create()
    {
        return view('buckets.create');
    }

    public function store(Request $request)
    {
        Bucket::query()->update(['current_capacity' => \DB::raw('capacity')]);
        $bucket = Bucket::create([
            'capacity' => $request->input('capacity'),
            'current_capacity' => $request->input('capacity'),
        ]);
        return redirect()->route('index')->with('success', 'Bucket created successfully');
}
}
