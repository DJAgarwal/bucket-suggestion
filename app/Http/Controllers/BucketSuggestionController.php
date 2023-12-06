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
    $quantities = $request->input('quantity');
    $ballIds = $request->input('id');

    // Validate input arrays to ensure they have the same length
    if (count($quantities) != count($ballIds)) {
        return response()->json(['error' => 'Invalid input'], 400);
    }

    // Create an array to store the total quantity for each ball
    $totalQuantity = [];

    // Calculate total quantity for each ball based on the input
    foreach ($quantities as $key => $quantity) {
        $ballId = $ballIds[$key];
        $totalQuantity[$ballId] = ($totalQuantity[$ballId] ?? 0) + $quantity;
    }

    // Sort balls by quantity in descending order
    arsort($totalQuantity);

    // Initialize buckets with their capacities
    $buckets = [100, 120, 140];

    // Create an array to store the ball distribution in each bucket
    $ballDistribution = [];

    // Distribute balls to buckets
    foreach ($totalQuantity as $ballId => $quantity) {
        $allocated = false;
        foreach ($buckets as $key => $bucketCapacity) {
            if ($quantity <= $bucketCapacity) {
                $ballDistribution[$key][$ballId] = $quantity;
                $buckets[$key] -= $quantity;
                $allocated = true;
                break;
            }
        }

        // If a ball couldn't be allocated to any bucket, handle this case as needed
        if (!$allocated) {
            return response()->json(['error' => 'Not enough buckets for the balls'], 400);
        }
    }

    // Output the result
    foreach ($ballDistribution as $key => $distribution) {
        $bucketNumber = $key + 1;
        echo "Bucket $bucketNumber: ";
        foreach ($distribution as $ballId => $quantity) {
            echo "$quantity $ballId balls, ";
        }
        echo "\n";
    }
}
}
