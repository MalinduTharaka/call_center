@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Call Center Work</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">User</th>
                    <th class="text-center">Order Count</th>
                    <th class="text-center">Orders Type</th>
                    <th class="text-center">Month Starting from 1st</th>
                    <th class="text-center">Target Status</th>
                    <th class="text-center">Target Complete Date</th>
                    <th class="text-center">Target</th>
                </tr>
            </thead>
            <tbody>
                @forelse($callCenterWorks as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->order_count }}</td>
                        <td>{{ $item->target->target_category }}</td>
                        <td>{{ $item->month }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $item->status->color() }}">{{ $item->status->toString() }}</span>
                        </td>
                        <td>{{ $item->complete_date }}</td>
                        <td>{{ $item->target->target }}</td>
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
