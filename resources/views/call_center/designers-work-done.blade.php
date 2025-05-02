@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Designer Work Done</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Order ID</th>
                            <th class="text-center">Work Type</th>
                            <th class="text-center">Amount Paid for Design (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $i => $entry)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $entry->user->name }}</td>
                                <td class="text-center">{{ $entry->order_id }}</td>
                                <td>{{ $entry->order->workType->name ?? '-' }}</td>
                                <td class="text-center">
                                    Rs. {{ number_format($entry->order->workType->designPayment->amount ?? 0, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
