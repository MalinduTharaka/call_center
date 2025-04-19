@extends('layouts.app')
@section('content')


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mb-0"> Orders</h4>
                    </div>
                    <div class="card-body">
                            <div id="basicwizard">

                                <ul class="nav nav-pills nav-justified form-wizard-header mb-4">
                                    <li class="nav-item">
                                        <a href="#basictab1" class="nav-link rounded-0 py-2"> 
                                            <i class="ri-account-circle-line fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Boosting</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#basictab2" class="nav-link rounded-0 py-2">
                                            <i class="ri-profile-line fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Designs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#basictab3" class="nav-link rounded-0 py-2">
                                            <i class="ri-check-double-line fw-normal fs-20 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Video</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content b-0 mb-0">
                                    <div class="tab-pane tab-panebtn" id="basictab1">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="col-3 mb-3">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control search-input" placeholder="Search orders..." data-target-table="#basictab1 table">
                                                        <button class="btn btn-primary search-btn">Search</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>C/E</th>
                                                                <th>Invoice</th>
                                                                <th>Name<br/>Company</th>
                                                                <th>O/N</th>
                                                                <th>Contact</th>
                                                                <th>Work<br/>Type</th>
                                                                <th>Page</th>
                                                                <th>Work<br/>Status</th>
                                                                <th>Payment</th>
                                                                <th>Cash</th>
                                                                <th>Advertiser</th>
                                                                <th>Package Amount</th>
                                                                <th>Service</th>
                                                                <th>Tax</th>
                                                                <th>FB Fee</th>
                                                                <th>Advance</th>
                                                                <th>Details</th>
                                                                <th>Add<br/>Link</th>
                                                                <th>slip</th>
                                                                {{-- <th>Action</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orders as $order)
                                                                @if ($order->ps == '1' && $order->order_type == 'boosting')

                                                                    <tr class="fw-semibold" data-order-id="{{ $order->id }}">
                                                                        <form action="/orders/boosting/update/{{ $order->id }}" method="post">
                                                                            @csrf
                                                                            @method('put')
                                                                        <td>{{ $order->date }}</td>
                                                                        <td>
                                                                            <span class="badge fs-5 display-mode
                                                                                @if($order->ce == 'c') bg-primary
                                                                                @elseif($order->ce == 'e') bg-danger
                                                                                @endif">
                                                                                {{ $order->ce}}
                                                                            </span>
                                                                            <select name="ce" class="form-select edit-mode">
                                                                                <option value="" selected>Select</option>
                                                                                <option value="c" @if($order->ce == 'c') selected @endif>c</option>
                                                                                <option value="e" @if($order->ce == 'e') selected @endif>e</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <span class="display-mode">{{ $order->invoice }}</span>
                                                                            <input type="text" name="inv" class="form-control edit-mode" value="{{ $order->invoice }}" hidden>
                                                                        </td>
                                                                        <td>
                                                                            <span class="display-mode">{{$order->name}}</span>
                                                                            <input type="text" name="name" class="form-control edit-mode" value="{{ $order->name }}">
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge fs-5
                                                                                @if($order->old_new == 'old') bg-primary
                                                                                @elseif($order->old_new == 'new') bg-warning
                                                                                @endif">
                                                                                {{ $order->old_new}}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="display-mode">{{$order->contact}}</span>
                                                                            <input type="text" name="contact" class="form-control edit-mode" value="{{ $order->contact }}">
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge fs-5 display-mode
                                                                                @if(!$order->work_type == '') bg-dark
                                                                                @endif">
                                                                                {{ $order->work_type }}
                                                                            </span>
                                                                            <select name="work_type" class="form-select edit-mode">
                                                                                <option value="" selected>Select</option>
                                                                                @foreach ($work_types as $work_type)
                                                                                    @if ($work_type->order_type == 'boosting')
                                                                                    <option value="{{$work_type->name}}" @if($order->work_type == $work_type->name) selected @endif>{{$work_type->name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </td>

                                                                        <td><span class="badge fs-5 bg-dark">{{ $order->page }}</span></td>
                                                                        <td>
                                                                            <span class="badge fs-5 display-mode
                                                                                @if($order->work_status == 'done') bg-primary
                                                                                @elseif($order->work_status == 'pending') bg-danger
                                                                                @elseif($order->work_status == 'send to customer') bg-warning
                                                                                @elseif($order->work_status == 'send to designer') bg-dark
                                                                                @endif">
                                                                                {{ $order->work_status }}
                                                                            </span>
                                                                            <select name="work_status" class="form-select edit-mode">
                                                                                <option value="" selected>Select</option>
                                                                                <option value="done" @if($order->work_status == 'done') selected @endif>done</option>
                                                                                <option value="pending" @if($order->work_status == 'pending') selected @endif>pending</option>
                                                                                <option value="send to customer" @if($order->work_status == 'send to customer') selected @endif>send to customer</option>
                                                                                <option value="send to designer" @if($order->work_status == 'send to designer') selected @endif>send to designer</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge fs-5 display-mode
                                                                                @if($order->payment_status == 'done') bg-primary
                                                                                @elseif($order->payment_status == 'pending') bg-danger
                                                                                @elseif($order->payment_status == 'rejected') bg-warning
                                                                                @elseif($order->payment_status == 'partial') bg-warning
                                                                                @endif">
                                                                                {{ $order->payment_status }}
                                                                            </span>
                                                                            <select name="payment_status" class="form-select edit-mode">
                                                                                <option value="done" @if($order->payment_status == 'done') selected @endif>done</option>
                                                                                <option value="" selected>Select</option>
                                                                                <option value="partial" @if($order->payment_status == 'partial') selected @endif>partial</option>
                                                                                <option value="pending" @if($order->payment_status == 'pending') selected @endif>pending</option>
                                                                                <option value="rejected" @if($order->payment_status == 'rejected') selected @endif>rejected</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge fs-5  display-mode
                                                                                @if($order->cash == 1.00) bg-warning bg-gradient
                                                                                @elseif ($order->cash == 0.00) text-dark
                                                                                @endif">
                                                                                {{ $order->cash == 1.00 ? 'Cash' : 'None Cash' }}
                                                                            </span>
                                                                            <select name="cash" class="form-select edit-mode">
                                                                                <option value="1" @if($order->cash == 1) selected @endif>cash payment</option>
                                                                                <option value="0" @if($order->cash == 0) selected @endif>none cash payment</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>{{ $order->advertiser_id }}</td>
                                                                        <td>{{ $order->package_amt }}</td>
                                                                        <td>{{ $order->service }}</td>
                                                                        <td>{{ $order->tax }}</td>
                                                                        <td>
                                                                            @if($order->payment_status == 'partial')
                                                                                {{ $order->advance - ($order->tax + $order->service) }}
                                                                            @elseif($order->payment_status == 'done')
                                                                                {{ $order->package_amt }}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <span class="display-mode">{{$order->advance}}</span>
                                                                            <input type="number" class="form-control edit-mode" name="advance" value="{{$order->advance}}">
                                                                        </td>
                                                                        <td>{{ $order->details }}</td>
                                                                        <td>
                                                                            <a href="{{ $order->add_acc_id }}" target="_blank">
                                                                                {{ $order->add_acc_id }}
                                                                            </a>
                                                                        </td>

                                                                        <td>
                                                                            @include('includes.slip-view')
                                                                        </td>
                                                                        {{-- <td>
                                                                            <button type="button" class="btn btn-primary edit-btn">Edit</button>
                                                                            <button type="button" class="btn btn-primary done-btnb">Done</button>
                                                                        </td> --}}
                                                                    </form>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>

                                    <div class="tab-pane tab-panebtn" id="basictab2">
                                        <div class="row">
                                            <div class="col-12">
                                                    <div class="col-3 mb-3">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control search-input" placeholder="Search orders..." 
                                                                data-target-table="#basictab2 table">
                                                            <button class="btn btn-primary search-btn">Search</button>
                                                        </div>
                                                    </div>
                                                    <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>C/E</th>
                                                                <th>Invoice</th>
                                                                <th>Name<br/>Company</th>
                                                                <th>Contact</th>
                                                                <th>Work<br/>Type</th>
                                                                <th>Work<br/>Status</th>
                                                                <th>Payment</th>
                                                                <th>Designer</th>
                                                                <th>Amount</th>
                                                                <th>Advance</th>
                                                                <th>Slip</th>
                                                                {{-- <th>Action</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($orders as $order)
                                                        @if ($order->ps == '1' && $order->order_type == 'designs')

                                                                <tr data-order-id="{{ $order->id }}">
                                                                    <form action="/orders/designs/update/{{ $order->id }}" method="post">
                                                                        @csrf
                                                                        @method('put')
                                                                    <td>{{$order->date}}</td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode
                                                                            @if($order->ce == 'c') bg-primary
                                                                            @elseif($order->ce == 'e') bg-danger
                                                                            @endif">
                                                                            {{ $order->ce}}
                                                                        </span>
                                                                        <select name="ce" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="c" @if($order->ce == 'c') selected @endif>c</option>
                                                                            <option value="e" @if($order->ce == 'e') selected @endif>e</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{ $order->invoice }}</span>
                                                                        <input type="text" name="inv" class="form-control edit-mode" value="{{ $order->invoice }}" hidden>
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->name}}</span>
                                                                        <input type="text" name="name" class="form-control edit-mode" value="{{ $order->name }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->contact}}</span>
                                                                        <input type="text" name="contact" class="form-control edit-mode" value="{{ $order->contact }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode
                                                                            @if(!$order->work_type == '') bg-dark
                                                                            @endif">
                                                                            {{ $order->work_type }}
                                                                        </span>
                                                                        <select name="work_type" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            @foreach ($work_types as $work_type)
                                                                                @if ($work_type->order_type == 'designs')
                                                                                <option value="{{$work_type->name}}" @if($order->work_type == $work_type->name) selected @endif>{{$work_type->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode
                                                                            @if($order->work_status == 'done') bg-primary
                                                                            @elseif($order->work_status == 'pending') bg-danger
                                                                            @elseif($order->work_status == 'send to customer') bg-warning
                                                                            @elseif($order->work_status == 'send to designer') bg-dark
                                                                            @endif">
                                                                            {{ $order->work_status }}
                                                                        </span>
                                                                        <select name="work_status" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="done" @if($order->work_status == 'done') selected @endif>done</option>
                                                                            <option value="pending" @if($order->work_status == 'pending') selected @endif>pending</option>
                                                                            <option value="send to customer" @if($order->work_status == 'send to customer') selected @endif>send to customer</option>
                                                                            <option value="send to designer" @if($order->work_status == 'send to designer') selected @endif>send to designer</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode
                                                                            @if($order->payment_status == 'done') bg-primary
                                                                            @elseif($order->payment_status == 'pending') bg-danger
                                                                            @elseif($order->payment_status == 'rejected') bg-warning
                                                                            @elseif($order->payment_status == 'partial') bg-warning
                                                                            @endif">
                                                                            {{ $order->payment_status }}
                                                                        </span>
                                                                        <select name="payment_status" class="form-select edit-mode">
                                                                            <option value="done" @if($order->payment_status == 'done') selected @endif>done</option>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="partial" @if($order->payment_status == 'partial') selected @endif>partial</option>
                                                                            <option value="pending" @if($order->payment_status == 'pending') selected @endif>pending</option>
                                                                            <option value="rejected" @if($order->payment_status == 'rejected') selected @endif>rejected</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>{{$order->designer_id}}</td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->amount}}</span>
                                                                        <input type="text" name="amount" class="form-control edit-mode" value="{{ $order->amount }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->advance}}</span>
                                                                        <input type="number" class="form-control edit-mode" name="advance" value="{{$order->advance}}">
                                                                    </td>
                                                                    <td>
                                                                        @include('includes.slip-view')
                                                                    </td>
                                                                    {{-- <td>
                                                                        <button type="button" class="btn btn-primary edit-btn">Edit</button>
                                                                        <button type="button" class="btn btn-primary done-btnd">Done</button>
                                                                    </td> --}}
                                                                </form>
                                                                </tr>

                                                            @endif                      
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>

                                    <div class="tab-pane tab-panebtn" id="basictab3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="col-3 mb-3">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control search-input" placeholder="Search orders..." 
                                                               data-target-table="#basictab3 table">
                                                        <button class="btn btn-primary search-btn">Search</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                <table class="table table-hover table-centered table-bordered border-primary mb-0">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>C/E</th>
                                                            <th>Invoice</th>
                                                            <th>Name<br/>Company</th>
                                                            <th>Contact</th>
                                                            <th>Amount</th>
                                                            <th>Our<br/>Amount</th>
                                                            <th>Style</th>
                                                            <th>Script</th>
                                                            <th>Shoot</th>
                                                            <th>Time</th>
                                                            <th>Work<br/>Status</th>
                                                            <th>Payment</th>
                                                            <th>Cash</th>
                                                            <th>Designer</th>
                                                            <th>Advance</th>
                                                            <th>Slip</th>
                                                            {{-- <th>Action</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($orders as $order)
                                                        @if ($order->ps == '1' && $order->order_type == 'video')
                                                            <tr data-order-id="{{ $order->id }}">
                                                                <form action="/orders/video/update/{{ $order->id }}" method="post">
                                                                    @csrf
                                                                    @method('put')
                                                                    <td>
                                                                        <span>{{$order->date}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode 
                                                                            @if($order->ce == 'c') bg-primary
                                                                            @elseif($order->ce == 'e') bg-danger
                                                                            @endif">
                                                                            {{ $order->ce}}
                                                                        </span>
                                                                        <select name="ce" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="c" @if($order->ce == 'c') selected @endif>c</option>
                                                                            <option value="e" @if($order->ce == 'e') selected @endif>e</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span >{{ $order->invoice }}</span>
                                                                        <input type="text" name="inv" class="form-control edit-mode" value="{{ $order->invoice }}" hidden>
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->name}}</span>
                                                                        <input type="text" name="name" class="form-control edit-mode" value="{{ $order->name }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->contact}}</span>
                                                                        <input type="text" name="contact" class="form-control edit-mode" value="{{ $order->contact }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->amount}}</span>
                                                                        <input type="text" name="amount" class="form-control edit-mode" value="{{ $order->amount }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->our_amount}}</span>
                                                                        <input type="text" name="our_amount" class="form-control edit-mode" value="{{ $order->our_amount }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode 
                                                                            @if(!$order->work_type == '') bg-dark
                                                                            @endif">
                                                                            {{ $order->work_type }}
                                                                        </span>
                                                                        <select name="work_type" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            @foreach ($work_types as $work_type)
                                                                                @if ($work_type->order_type == 'video')
                                                                                <option value="{{$work_type->name}}" @if($order->work_type == $work_type->name) selected @endif>{{$work_type->name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode 
                                                                            @if($order->script == 'done') bg-primary
                                                                            @elseif($order->script == 'pending') bg-danger
                                                                            @elseif($order->script == 'send to customer') bg-warning
                                                                            @elseif($order->script == 'send to designer') bg-dark
                                                                            @endif">
                                                                            {{ $order->script }}
                                                                        </span>
                                                                        <select name="script" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="done" @if($order->script == 'done') selected @endif>done</option>
                                                                            <option value="pending" @if($order->script == 'pending') selected @endif>pending</option>
                                                                            <option value="send to customer" @if($order->script == 'send to customer') selected @endif>send to customer</option>
                                                                            <option value="send to designer" @if($order->script == 'send to designer') selected @endif>send to designer</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode 
                                                                            @if($order->shoot == 'done') bg-primary
                                                                            @elseif($order->shoot == 'pending') bg-danger
                                                                            @elseif($order->shoot == 'send to customer') bg-warning
                                                                            @elseif($order->shoot == 'send to designer') bg-dark
                                                                            @endif">
                                                                            {{ $order->shoot }}
                                                                        </span>
                                                                        <select name="shoot" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="done" @if($order->shoot == 'done') selected @endif>done</option>
                                                                            <option value="pending" @if($order->shoot == 'pending') selected @endif>pending</option>
                                                                            <option value="send to customer" @if($order->shoot == 'send to customer') selected @endif>send to customer</option>
                                                                            <option value="send to designer" @if($order->shoot == 'send to designer') selected @endif>send to designer</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><span>{{$order->video_time}}</span></td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode 
                                                                            @if($order->work_status == 'done') bg-primary
                                                                            @elseif($order->work_status == 'pending') bg-danger
                                                                            @elseif($order->work_status == 'send to customer') bg-warning
                                                                            @elseif($order->work_status == 'send to designer') bg-dark
                                                                            @endif">
                                                                            {{ $order->work_status }}
                                                                        </span>
                                                                        <select name="work_status" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="done" @if($order->work_status == 'done') selected @endif>done</option>
                                                                            <option value="pending" @if($order->work_status == 'pending') selected @endif>pending</option>
                                                                            <option value="send to customer" @if($order->work_status == 'send to customer') selected @endif>send to customer</option>
                                                                            <option value="send to designer" @if($order->work_status == 'send to designer') selected @endif>send to designer</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode 
                                                                            @if($order->payment_status == 'done') bg-primary
                                                                            @elseif($order->payment_status == 'pending') bg-danger
                                                                            @elseif($order->payment_status == 'rejected') bg-warning
                                                                            @elseif($order->payment_status == 'partial') bg-warning
                                                                            @endif">
                                                                            {{ $order->payment_status }}
                                                                        </span>
                                                                        <select name="payment_status" class="form-select edit-mode">
                                                                            <option value="done" @if($order->payment_status == 'done') selected @endif>done</option>
                                                                            <option value="" selected>Select</option>
                                                                            <option value="partial" @if($order->payment_status == 'partial') selected @endif>partial</option>
                                                                            <option value="pending" @if($order->payment_status == 'pending') selected @endif>pending</option>
                                                                            <option value="rejected" @if($order->payment_status == 'rejected') selected @endif>rejected</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode 
                                                                            @if($order->cash == 1.00) bg-warning bg-gradient
                                                                            @elseif ($order->cash == 0.00) text-dark
                                                                            @endif">
                                                                            {{ $order->cash == 1.00 ? 'Cash' : 'None Cash' }}
                                                                        </span>
                                                                        <select name="cash" class="form-select edit-mode">
                                                                            <option value="1" @if($order->cash == 1) selected @endif>cash payment</option>
                                                                            <option value="0" @if($order->cash == 0) selected @endif>none cash payment</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>{{$order->designer_id}}</td>
                                                                    <td>
                                                                        <span class="display-mode">{{$order->advance}}</span>
                                                                        <input type="number" class="form-control edit-mode" name="advance" value="{{$order->advance}}">
                                                                    </td>
                                                                    <td>
                                                                        @include('includes.slip-view')
                                                                    </td>
                                                                    {{-- <td>
                                                                        <button type="button" class="btn btn-primary edit-btn display-mode">Edit</button>
                                                                        <button type="button" class="btn btn-primary done-btnv edit-mode">Done</button>
                                                                    </td> --}}
                                                                </form>
                                                            </tr>
                                                        @endif                      
                                                        @endforeach
                                                    </tbody>

                                                    <style>
                                                        .display-mode {
                                                            display: inline-block;
                                                        }

                                                        .edit-mode {
                                                            display: none;
                                                        }

                                                        tr.editing .display-mode {
                                                            display: none;
                                                        }

                                                        tr.editing .edit-mode {
                                                            display: block;
                                                        }

                                                        tr.editing .edit-mode.btn {
                                                            display: inline-block;
                                                        }
                                                    </style>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- tab-content -->
                            </div> <!-- end #basicwizard-->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Function to activate tabs
                function activateTab(tabHash) {
                    // Remove active classes from all tabs and panes
                    document.querySelectorAll('.nav-link, .tab-panebtn').forEach(el => {
                        el.classList.remove('active', 'show');
                    });

                    // Activate matching tab
                    const tabLink = document.querySelector(`[href="${tabHash}"]`);
                    if(tabLink) {
                        tabLink.classList.add('active');
                        // Activate corresponding pane
                        const pane = document.querySelector(tabHash);
                        if(pane) pane.classList.add('active', 'show');
                    }
                }

                // Set default tab if no hash exists
                if(!window.location.hash) {
                    window.location.hash = '#basictab1';
                } else {
                    activateTab(window.location.hash);
                }

                // Update tabs when hash changes
                window.addEventListener('hashchange', () => {
                    activateTab(window.location.hash);
                });

                // Handle manual tab clicks
                document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        window.location.hash = this.getAttribute('href');
                    });
                });
            });
        </script>

        <!-- Add this JavaScript at the end of your existing script -->
    <script>
        // Search functionality
        document.querySelectorAll('.search-btn').forEach(button => {
            button.addEventListener('click', function () {
                const input = this.closest('.input-group').querySelector('.search-input');
                performSearch(input);
            });
        });

        document.querySelectorAll('.search-input').forEach(input => {
            input.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    performSearch(this);
                }
            });
        });

        function performSearch(input) {
            const searchTerm = input.value.toLowerCase();
            const tableSelector = input.dataset.targetTable;
            const table = document.querySelector(tableSelector);
            if (!table) return;

            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let matches = false;

                cells.forEach(cell => {
                    // Check both display and edit values
                    const displayValue = cell.querySelector('.display-mode')?.textContent?.toLowerCase() || '';
                    const editValue = cell.querySelector('.edit-mode')?.value?.toLowerCase() || '';

                    if (displayValue.includes(searchTerm) || editValue.includes(searchTerm)) {
                        matches = true;
                    }
                });

                row.style.display = matches ? '' : 'none';
            });
        }
    </script>
@endsection