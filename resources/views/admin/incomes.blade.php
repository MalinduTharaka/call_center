@extends('layouts.app')
@section('content')

<div class="row mt-3">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="header-title">Income</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                    <li class="nav-item">
                        <a href="#todayincome" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                            Today
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#monthincome" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            This Month
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="todayincome">
                        <div class="row mt-2">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">Today Incomes</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">Boosting ({{ $boostCountToday }})</th>
                                                        <th rowspan="2">Designs ({{ $designCountToday }})<br>(Amount)</th>
                                                        <th colspan="2">Video ({{ $videoCountToday }})</th>
                                                        <th rowspan="2">Other Orders ({{ $otherCountToday }})<br>(Amount)</th>
                                                    </tr>
                                                    <tr>
                                                        <th>FB Fee</th>
                                                        <th>Service</th>
                                                        <th>Tax</th>
                                                        <th>Amount</th>
                                                        <th>Our Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Rs. {{$b_income_pkg_today}}/=</td>
                                                        <td>Rs. {{$b_income_service_today}}/=</td>
                                                        <td>Rs. {{$b_income_tax_today}}/=</td>
                                                        <td>Rs. {{$d_income_today}}/=</td>
                                                        <td>Rs. {{$v_income_amt_today}}/=</td>
                                                        <td>Rs. {{$v_income_our_amt_today}}/=</td>
                                                        <td>Rs. {{$o_income_today}}/=</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="monthincome">
                        <div class="row mt-2">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="header-title">Monthly Incomes</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">Boosting ({{ $boostCountMonth }})</th>
                                                        <th rowspan="2">Designs ({{ $designCountMonth }})<br>(Amount)</th>
                                                        <th colspan="2">Video ({{ $videoCountMonth }})</th>
                                                        <th rowspan="2">Other Orders ({{ $otherCountMonth }})<br>(Amount)</th>
                                                    </tr>
                                                    <tr>
                                                        <th>FB Fee</th>
                                                        <th>Service</th>
                                                        <th>Tax</th>
                                                        <th>Amount</th>
                                                        <th>Our Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Rs. {{$b_income_pkg_month}}/=</td>
                                                        <td>Rs. {{$b_income_service_month}}/=</td>
                                                        <td>Rs. {{$b_income_tax_month}}/=</td>
                                                        <td>Rs. {{$d_income_month}}/=</td>
                                                        <td>Rs. {{$v_income_amt_month}}/=</td>
                                                        <td>Rs. {{$v_income_our_amt_month}}/=</td>
                                                        <td>Rs. {{$o_income_month}}/=</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                    </div>
                </div>  
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->

@endsection