@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Designer Work Done</h4>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Order ID</th>
            <th>Work Type</th>
            <th>Amount Paid for Design (Rs.)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($entries as $i => $entry)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $entry->user->name }}</td>
              <td>{{ $entry->order_id }}</td>
              <td>{{ $entry->order->workType->name }}</td>
              <td>
                {{$entry->order->workType->designPayment->amount }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>
@endsection
