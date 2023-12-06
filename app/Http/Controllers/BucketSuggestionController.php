<?php

namespace App\Http\Controllers;
use App\Models\{Bucket,Ball};

use Illuminate\Http\Request;

class BucketSuggestionController extends Controller
{
    public function index()
    {
        $bucket_count = Bucket::count();
        $total_capacity = Bucket::sum('capacity');
        $balls_list = Ball::get();
        $buckets_list = Bucket::get();
        $ballsCountPerBucket = [];
        return view('index',compact('bucket_count','total_capacity','balls_list','buckets_list','ballsCountPerBucket'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $buckets = Bucket::orderBy('capacity')->get();
        for($i=0;$i<count($id);$i++) {
            $ball = Ball::find($id[$i]);
            $ball_total_size = $quantity[$i]*$ball->size;
            foreach($buckets as $bucket)
            {
                while($bucket->current_capacity >= $bucket->current_capacity ) {
                    $bucket->current_capacity += $ball_total_size;
                }
            }
        }
        \Log::info($bucket->current_capacity);
die;
        return redirect()->route('index')->with('ballsCountPerBucket', $ballsCountPerBucket);
    }

}
