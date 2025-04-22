@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="header-title">Invoices</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-centered mb-0 table-bordered border-primary">
                        <thead class="table-purple">
                            <tr>
                                <th>INV</th>
                                <th>CRO</th>
                                <th>Call Center</th>
                                <th>Conatct</th>
                                <th>Due Date</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->inv }}</td>
                                    <td>{{ $invoice->user->name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->callCenter->cc_name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->contact }}</td>
                                    <td>{{ $invoice->due_date }}</td>
                                    <td>{{ $invoice->total }}</td>
                                    <td>{{ ($invoice->amt1+$invoice->amt2+$invoice->amt3) }}</td>
                                    <td>
                                        <a href="{{ route('invoices.view', $invoice->inv) }}" class="btn btn-primary">View</a>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->

@endsection