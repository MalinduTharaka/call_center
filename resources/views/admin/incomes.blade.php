@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="header-title">Monthly Incomes</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-centered mb-0">
                        <thead>
                            <tr>
                                <th>Boosting</th>
                                <th>Designs</th>
                                <th>Video</th>
                                <th>Other Orders</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Rs. {{$b_income}}/=</td>
                                <td>Rs. {{$d_income}}/=</td>
                                <td>Rs. {{$v_income}}/=</td>
                                <td>Rs. {{$o_income}}/=</td>
                                <td>Rs. {{($b_income + $d_income + $v_income + $o_income)}}/=</td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- end table-responsive-->

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->
@endsection