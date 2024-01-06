@extends('layouts.app')

@section('content')
    <h1>Branch Details</h1>
    <a href="{{ route('branches.index') }}" class="btn btn-secondary mb-3">Back to Branches</a>

    <div class="card">
        <div class="card-body">
            <h2>Timing</h2>
            <p><strong>Business:</strong> {{ $branch->business->name }}</p>
            <p><strong>Branch Name:</strong> {{ $branch->name }}</p>
            <p><strong>Status:</strong> {{ $branch->isClosedToday() ? 'Closed' : 'Open' }}</p>

            <p><strong>Sunday:</strong> {{ $branch->isDayClosed('sunday') ? 'Closed' : $branch->getFormattedTiming('sunday') }}</p>
            <p><strong>Monday:</strong> {{ $branch->isDayClosed('monday') ? 'Closed' : $branch->getFormattedTiming('monday') }}</p>
            <p><strong>Tuesday:</strong> {{ $branch->isDayClosed('tuesday') ? 'Closed' : $branch->getFormattedTiming('tuesday') }}</p>
            <p><strong>Wednesday:</strong> {{ $branch->isDayClosed('wednesday') ? 'Closed' : $branch->getFormattedTiming('wednesday') }}</p>
            <p><strong>Thursday:</strong> {{ $branch->isDayClosed('thursday') ? 'Closed' : $branch->getFormattedTiming('thursday') }}</p>
            <p><strong>Friday:</strong> {{ $branch->isDayClosed('friday') ? 'Closed' : $branch->getFormattedTiming('friday') }}</p>
            <p><strong>Saturday:</strong> {{ $branch->isDayClosed('saturday') ? 'Closed' : $branch->getFormattedTiming('saturday') }}</p>
        </div>
    </div>

    @if (!empty($branch->images))
        <div class="card mt-3">
            <div class="card-body">
                <h2>Images</h2>
                <div class="row">
                    @foreach (json_decode($branch->images) as $image)
                        <div class="col-md-4 mb-3">
                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid" alt="Branch Image">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
