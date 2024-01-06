@extends('layouts.app')

@section('content')
<style>
    .remove-image-button {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 1; /* Ensures the button appears above the image */
    }
</style>
<h1>Edit Branch - {{ $branch->name }}</h1>

<!-- Display all validation errors at the top -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('branches.update', $branch->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="mb-3 col-lg-6">
            <label for="business_id" class="form-label">Business</label>
            <select name="business_id" class="form-control" required>
                @foreach($businesses as $business)
                <option value="{{ $business->id }}" @if($branch->business_id == $business->id) selected @endif>{{ $business->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-lg-6">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $branch->name }}" required>
        </div>

        <!-- Repeat the following block for each weekday -->
        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
        <div class="mb-3 col-lg-6">
            <label class="form-label">{{ ucfirst($day) }} Timing</label>
            <label class="text-danger">
                Close
                <input type="checkbox" name="{{ $day }}_closed" class="form-check-input" @if(isset($branch->{$day.'_timing'}) && $branch->{$day.'_timing'}['closed'] === true) checked @endif>


            </label>
            <div class="weekday-timing-container">
                <!-- JavaScript will dynamically add fields here -->
                @if(!$branch->{$day.'_closed'} && is_array($branch->{$day.'_timing'}['timing']))
                @foreach($branch->{$day.'_timing'}['timing'] as $timing)
                <div class="input-group mb-3">
                    <input type="time" name="{{ $day }}_timing_start[]" class="form-control" placeholder="Start Time" required value="{{ $timing['start'] ?? '' }}">
                    <input type="time" name="{{ $day }}_timing_end[]" class="form-control" placeholder="End Time" required value="{{ $timing['end'] ?? '' }}">
                    <button type="button" class="btn btn-danger remove-timing-button">Remove</button>
                </div>
                @endforeach
                @endif
            </div>
            <button type="button" class="btn btn-primary add-timing-button" data-day="{{ $day }}">+</button>
        </div>
        @endforeach

        <div class="mb-3 col-lg-12">
            <label for="name" class="form-label">Closing Dates</label>
            <div class="closing_date_container row">
                @if(is_array($branch->date_close))
                @foreach($branch->date_close as $closingDate)
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <input type="date" name="closing_dates[]" class="form-control" required value="{{ $closingDate }}">
                        <button type="button" class="btn btn-danger remove-closing-date-button">Remove</button>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <button type="button" class="btn btn-primary closing_date">+</button>
        </div>

        <div class="mb-3 col-lg-12">
            <label for="images" class="form-label">Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
            <div class="image-preview-container mt-3">
                <!-- Images will be displayed here -->
                @if(is_array(json_decode($branch->images, true)))
                @foreach(json_decode($branch->images, true) as $image)
                <div class="d-inline-block position-relative mr-2">
                    <button type="button" class="btn btn-danger btn-sm remove-image-button">Remove</button>
                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>
@endsection

@section('script')
<script>
    // Define the addTimingField function
    function addTimingField(container, day) {
        var newField = $('<div>').html(
            $('<div>').addClass('input-group mb-3').append(
                $('<input>').attr({
                    type: 'time',
                    name: day + '_timing_start[]',
                    class: 'form-control',
                    placeholder: 'Start Time',
                    required: true
                }),
                $('<input>').attr({
                    type: 'time',
                    name: day + '_timing_end[]',
                    class: 'form-control',
                    placeholder: 'End Time',
                    required: true
                }),
                $('<button>').attr({
                    type: 'button',
                    class: 'btn btn-danger remove-timing-button'
                }).text('Remove')
            )
        );

        container.append(newField);
    }

    // Define the removeTimingField function
    function removeTimingField(button) {
        $(button).parent().remove();
    }

    // Define the addClosingDateField function
    function addClosingDateField() {
        var container = $('.closing_date_container');
        var newField = $('<div class="col-lg-4">').html(
            $('<div>').addClass('input-group mb-3').append(
                $('<input>').attr({
                    type: 'date',
                    name: 'closing_dates[]',
                    class: 'form-control',
                    required: true
                }),
                $('<button>').attr({
                    type: 'button',
                    class: 'btn btn-danger remove-closing-date-button'
                }).text('Remove')
            )
        );

        container.append(newField);
    }

    // Define the removeClosingDateField function
    function removeClosingDateField(button) {
        $(button).parent().remove();
    }

    // Define the addImagePreview function
    function addImagePreview(imageUrl) {
        var container = $('.image-preview-container');
        var newPreview = $('<div class="d-inline-block position-relative mr-2">').append(
            $('<button>').attr({
                type: 'button',
                class: 'btn btn-danger btn-sm remove-image-button'
            }).text('Remove').css({
                position: 'absolute',
                top: '0',
                right: '0'
            }),
            $('<img>').attr({
                src: imageUrl,
                class: 'img-thumbnail',
                style: 'max-width: 100px; max-height: 100px;'
            })
        );

        container.append(newPreview);
    }


    // Define the removeImagePreview function
    function removeImagePreview(button) {
        $(button).parent().remove();
    }

    // ... Your existing functions

    // Then, use the functions
    $(document).ready(function() {
        // Add event listener for all add-timing-button elements
        $('.add-timing-button').on('click', function() {
            var container = $(this).prev('.weekday-timing-container');
            var day = $(this).data('day');
            addTimingField(container, day);
        });

        // Add event listener for all remove-timing-button elements
        $(document).on('click', '.remove-timing-button', function() {
            removeTimingField(this);
        });

        // Add event listener for the add-closing-date-button
        $('.closing_date').on('click', function() {
            addClosingDateField();
        });

        // Add event listener for the remove-closing-date-button
        $(document).on('click', '.remove-closing-date-button', function() {
            removeClosingDateField(this);
        });

        // Add event listener for the change event of the images input
        $('input[name="images[]"]').on('change', function() {
            var files = $(this).prop('files');
            $('.image-preview-container').empty(); // Clear previous previews
            for (var i = 0; i < files.length; i++) {
                var imageUrl = URL.createObjectURL(files[i]);
                addImagePreview(imageUrl);
            }
        });

        // Add event listener for removing image previews
        $(document).on('click', '.remove-image-button', function() {
            removeImagePreview(this);
        });

        // ... Your existing functions
    });

    // ... Your existing functions
</script>
@endsection
