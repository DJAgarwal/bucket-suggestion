@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="m-0">Bucket Suggestion</h5>
                        <a href="{{ route('buckets.create') }}" class="btn btn-primary ms-auto">Create Bucket</a>
                        <a href="{{ route('balls.create') }}" class="btn btn-primary ms-2">Create Ball</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <p>Bucket Count: {{$bucket_count}}</p>
                    <p>Total Capacity: {{$total_capacity}}</p>
                    <div class="table-responsive col-md-6" style="margin-top:10px;">
                    <form method="post" action="{{ route('ball-suggestion.store') }}">
                        @csrf
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Ball</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($balls_list as $bl)
                                <tr>
                                    <td>{{$bl->colour}}</td>
                                    <td>{{$bl->size}}</td>
                                    <td>
                                        <input type="hidden" class="form-control" name="id[]" value="{{$bl->id}}">
                                        <input type="number" class="form-control" name="quantity[]" min="0" value="0">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Place balls in bucket</button>
                    </form">
                    </div>
                    <div class="table-responsive col-md-6" style="margin-top:10px;">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            @foreach($buckets_list as $bl)
                                <tr>
                                    <td>Bucket {{$bl->id}}</td>
                                    <td>
                                        @foreach($ballsCountPerBucket as $bcpb)
                                        {{$bcpb}}
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection