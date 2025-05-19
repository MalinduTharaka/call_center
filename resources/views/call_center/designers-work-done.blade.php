@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <h4 class="mb-4">Designer Work Done</h4>

        {{-- FILTER FORM --}}
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('designer.work.index') }}" class="row g-2 align-items-end">
                    {{-- Month‑Year --}}
                    <div class="col-auto">
                        <label class="form-label">Month‑Year</label>
                        <input type="month" name="month_year" class="form-control form-control-sm"
                            value="{{ request('month_year') }}" />
                    </div>

                    {{-- User --}}
                    <div class="col-auto">
                        <label class="form-label">User</label>
                        <select name="user_id" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('designer.work.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                    </div>
                </form>

            </div>
        </div>

        {{-- RESULTS TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle mb-0">
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
                            @forelse($entries as $i => $entry)
                                                    <tr>
                                                        <td class="text-center">{{ $i + 1 }}</td>
                                                        <td>{{ $entry->user->name }}</td>
                                                        <td class="text-center">{{ $entry->order_id }}</td>
                                                        <td>
                                                            {{ $entry->order->workType->name ?? '-' }}
                                                        </td>
                                                        <td class="text-center">
                                                            Rs. {{ number_format(
                                    $entry->order->workType->designPayment->amount ?? 0,
                                    2
                                ) }}
                                                        </td>
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection