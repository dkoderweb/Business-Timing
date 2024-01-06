@extends('layouts.app')

@section('content')
    <h1>Businesses</h1>
    <a href="{{ route('businesses.create') }}" class="btn btn-primary mb-3">Add Business</a>

    <table class="table" id="business-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Logo</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection

@section('script')

<script>
    $(document).ready(function () {
        $('#business-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('businesses.index') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone_number', name: 'phone_number' },
                { data: 'logo', name: 'logo', render: function (data) {
                    return data ? '<img src="storage/' + data + '" alt="Logo" height="50">' : 'No Logo';
                }},
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
    @if((session()->has('success')))
        $(document).ready(function(){
            toastr.success("{{session()->get('success')}} ")
        });
    @endif 
</script>
@endsection
