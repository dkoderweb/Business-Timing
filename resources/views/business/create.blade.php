@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-5">Create Business</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('businesses.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="logo">Logo:</label>
                <input type="file" name="logo" class="form-control-file" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
