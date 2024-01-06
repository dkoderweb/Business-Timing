@extends('layouts.app')

@section('content')
    <h1>Edit Business</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('businesses.update', $business->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Use PUT method for updates -->
        <div class="form-group mb-3">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $business->name }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $business->email }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" class="form-control" value="{{ $business->phone_number }}" required>
        </div>
        <div class="form-group mb-3">
            @if($business->logo)
                <img src="{{ asset('storage/' . $business->logo) }}" alt="Current Logo" height="50">
                <br>
            @endif
            <input type="file" name="logo" class="form-control-file" >
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
