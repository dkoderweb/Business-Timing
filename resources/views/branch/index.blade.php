@extends('layouts.app')

@section('content')
    <h1>Branches</h1>
    <a href="{{ route('branches.create') }}" class="btn btn-primary mb-3">Add Branch</a>

    <table class="table" id="branch-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Business</th>
                <th>Sunday Timing</th>
                <th>Monday Timing</th>
                <th>Tuesday Timing</th>
                <th>Wednesday Timing</th>
                <th>Thursday Timing</th>
                <th>Friday Timing</th>
                <th>Saturday Timing</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#branch-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('branches.index') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'business.name', name: 'business.name' },
                { data: 'sunday_timing', name: 'sunday_timing' },
                { data: 'monday_timing', name: 'monday_timing' },
                { data: 'tuesday_timing', name: 'tuesday_timing' },
                { data: 'wednesday_timing', name: 'wednesday_timing' },
                { data: 'thursday_timing', name: 'thursday_timing' },
                { data: 'friday_timing', name: 'friday_timing' },
                { data: 'saturday_timing', name: 'saturday_timing' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ],
        });

        // Add confirmation for delete button
        $('#branch-table').on('click', '.delete-button', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');

            if (confirm('Are you sure you want to delete this branch?')) {
                window.location.href = url;
            }
        });
    });
    @if((session()->has('success')))
        $(document).ready(function(){
            toastr.success("{{session()->get('success')}} ")
        });
    @endif 
</script>
@endsection
