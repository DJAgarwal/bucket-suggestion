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
        $output = session('output', []);
        return view('index',compact('bucket_count','total_capacity','balls_list','buckets_list','output'));
    }

//     public function store(Request $request)
//     {
//         $id = $request->input('id');
//         $quantity = $request->input('quantity');
//         $buckets = Bucket::orderBy('capacity')->get();
//         for($i=0;$i<count($id);$i++) {
//             $ball = Ball::find($id[$i]);
//             $ball_total_size = $quantity[$i]*$ball->size;
//             foreach($buckets as $bucket)
//             {
//                 while($bucket->current_capacity >= $bucket->current_capacity ) {
//                     $bucket->current_capacity += $ball_total_size;
//                 }
//             }
//         }
//         \Log::info($bucket->current_capacity);
// die;
//         return redirect()->route('index')->with('ballsCountPerBucket', $ballsCountPerBucket);
//     }
    public function store(Request $request)
    {
        $buckets = Bucket::all();
        $ballIds = $request->input('id');
        $quantities = $request->input('quantity');
        $output = [];
        $buckets = $buckets->sortBy('capacity');

        foreach ($buckets as $bucket) {
            $balls = [];
            foreach ($ballIds as $index => $ballId) {
                $quantity = $quantities[$index];
                for ($i = 0; $i < $quantity; $i++) {
                    $ball = Ball::find($ballId);
                    if ($ball) {
                        $balls[] = $ball;
                    }
                }
            }

            $remainingCapacity = $bucket->capacity;
            $ballsInBucket = [];
            $colorQuantities = [];

            foreach ($balls as $ball) {
                if ($ball->size <= $remainingCapacity) {
                    $remainingCapacity -= $ball->size;
                    $color = $ball->colour;
                    $colorQuantities[$color] = ($colorQuantities[$color] ?? 0) + 1;
                }
            }
            $outputLine = "Bucket {$bucket->id}: ";
            foreach ($colorQuantities as $color => $quantity) {
                $ballsInBucket[] = "{$quantity} {$color}";
            }
            $outputLine .= implode(', ', $ballsInBucket) . " Balls";
            $output[] = $outputLine;
            if ($remainingCapacity <= 0) {
                continue;
            }
        }
        return redirect()->route('index')->with('output', $output);
    }
}
