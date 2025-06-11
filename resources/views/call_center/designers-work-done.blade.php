@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <h4 class="mb-4">Designer Work Done</h4>

        {{-- FILTER FORM --}}
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('designer.work.index') }}" class="row g-2 align-items-end">
                    <div class="col-auto">
                        <label class="form-label">Month‑Year</label>
                        <input type="month" name="month_year" class="form-control form-control-sm"
                            value="{{ request('month_year') }}" />
                    </div>

                    <div class="col-auto">
                        <label class="form-label">User</label>
                        <select name="user_id" class="form-select form-select-sm">
                            <option value="">All</option>
                            @foreach($users as $user)
                                @if ($user->role == 'dsg')
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endif
                                
                            @endforeach
                        </select>
                    </div>

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
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($entries as $i => $entry)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $entry->user->name }}</td>
                                    <td class="text-center">{{ $entry->order_id }}</td>
                                    <td>{{ $entry->order->workType->name ?? '-' }}</td>

                                    {{-- Amount Field --}}
                                    <td class="text-center">
                                        <span id="amount-display-{{ $entry->id }}">
                                            Rs. {{ number_format($entry->amount, 2) }}
                                        </span>

                                        <form id="amount-form-{{ $entry->id }}"
                                            action="{{ route('designer.work.update', $entry->id) }}" method="POST"
                                            class="d-none d-inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="amount" value="{{ $entry->amount }}" step="0.01"
                                                class="form-control form-control-sm d-inline-block w-auto" />
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                onclick="toggleEdit({{ $entry->id }}, false)">Cancel</button>
                                        </form>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning"
                                            onclick="toggleEdit({{ $entry->id }}, true)">Edit</button>

                                        <form action="{{ route('designer.work.destroy', $entry->id) }}" method="POST"
                                            class="d-inline ms-1" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for toggling amount edit --}}
    <script>
        function toggleEdit(id, show) {
            const display = document.getElementById('amount-display-' + id);
            const form = document.getElementById('amount-form-' + id);

            if (show) {
                display.classList.add('d-none');
                form.classList.remove('d-none');
            } else {
                display.classList.remove('d-none');
                form.classList.add('d-none');
            }
        }
    </script>
@endsection