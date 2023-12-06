@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="m-0">Ball Create</h5>
                        <a href="{{ url()->previous() }}" class="btn btn-primary ms-auto">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form method="post" action="{{ route('balls.store') }}">
                    @csrf
                    <div class="form-group col-md-6">
                        <label for="colour">Ball Colour:</label>
                        <input type="text" class="form-control @error('colour') is-invalid @enderror" id="colour" name="colour" value="{{ old('colour') }}" required>
                        @error('colour')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="size">Ball Size:</label>
                        <input type="number" min="0" class="form-control @error('size') is-invalid @enderror" id="size" name="size" value="{{ old('size') }}" required>
                        @error('size')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection