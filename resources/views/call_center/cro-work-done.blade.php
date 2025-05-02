@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Call Center Work</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Order Count</th>
                            <th class="text-center">Orders Type</th>
                            <th class="text-center">Month Starting</th>
                            <th class="text-center">Target Status</th>
                            <th class="text-center">Target Complete Date</th>
                            <th class="text-center">Target</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($callCenterWorks as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->user->name }}</td>
                                <td class="text-center">{{ $item->order_count }}</td>
                                <td class="text-center">{{ $item->target->target_category }}</td>
                                <td class="text-center">{{ $item->month }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $item->status->color() }}">
                                        {{ $item->status->toString() }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $item->complete_date ?? '-' }}</td>
                                <td class="text-center">{{ $item->target->target }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
