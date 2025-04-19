@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Call Center Work</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User ID</th>
                    <th>Order Count</th>
                    <th>Month</th>
                    <th>Complete Date</th>
                    <th>Target</th>
                </tr>
            </thead>
            <tbody>
                @forelse($callCenterWorks as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user_id }}</td>
                        <td>{{ $item->order_count }}</td>
                        <td>{{ $item->month }}</td>
                        <td>{{ $item->complete_date }}</td>
                        <td>{{ $item->target }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
