@foreach ($orders as $order)
    @if ($order->ps == '1' && $order->order_type == 'boosting')
        <tr class="fw-semibold" data-order-id="{{ $order->id }}" data-add-acc="{{ $order->add_acc }}">
            <form action="/orders/boosting/update/{{ $order->id }}" method="post">
                @csrf
                @method('put')
                <td>
                    <span class="display-mode">
                        @if ($order->add_acc == '1') Urgent
                        @elseif($order->add_acc == '2') Pending
                        @elseif($order->add_acc == '3') Continue
                        @elseif($order->add_acc == '4') Unknown
                        @endif
                    </span>
                    <select name="add_acc" class="form-select edit-mode">
                        <option value="4" @selected($order->add_acc == '4')>Unknown</option>
                        <option value="1" @selected($order->add_acc == '1')>Urgent</option>
                        <option value="2" @selected($order->add_acc == '2')>Pending</option>
                        <option value="3" @selected($order->add_acc == '3')>Continue</option>
                    </select>
                </td>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                <td>
                    <span
                        class="badge fs-5
                                                                                                                        @if ($order->ce == 'c') bg-primary
                                                                                                                        @elseif($order->ce == 'e') bg-danger @endif">
                        {{ $order->ce }}
                    </span>
                </td>
                <td>
                    <span>{{ $order->invoice }}</span>
                    <input type="text" name="inv" class="form-control edit-mode" value="{{ $order->invoice }}" hidden>
                </td>
                <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                    <span class="display-mode">{{ $order->name }}</span>
                    <input type="text" name="name" class="form-control edit-mode" value="{{ $order->name }}">
                </td>
                <td>
                    <span
                        class="badge fs-5
                                                                                                                        @if ($order->old_new == 'old') bg-primary
                                                                                                                        @elseif($order->old_new == 'new') bg-warning @endif">
                        {{ $order->old_new }}
                    </span>
                </td>
                <td>
                    <span class="display-mode">{{ $order->contact }}</span>
                    <input type="text" name="contact" class="form-control edit-mode" value="{{ $order->contact }}">
                </td>
                <td>
                    <span class="badge fs-5 bg-dark display-mode">{{ $order->page }}</span>
                    <select name="page" class="form-select edit-mode">
                        <option value="" selected>Select</option>
                        <option value="new" @if ($order->page == 'new') selected @endif>
                            new</option>
                        <option value="our" @if ($order->page == 'our') selected @endif>
                            our</option>
                        <option value="existing" @if ($order->page == 'existing') selected @endif>
                            existing
                        </option>
                    </select>
                </td>
                <td>
                    <span class="badge fs-5 display-mode
                                                                                                                        @if ($order->work_status == 'done') bg-primary
                                                                                                                        @elseif($order->work_status == 'pending') bg-danger
                                                                                                                        @elseif($order->work_status == 'send to customer') bg-warning
                                                                                                                        @elseif($order->work_status == 'send to designer') bg-dark
                                                                                                                        @elseif($order->work_status == 'error') bg-danger
                                                                                                                        @elseif($order->work_status == '')
                                                                                                                        @else
                                                                                            bg-info @endif">
                        {{ $order->work_status }}
                    </span>
                    <select name="work_status" class="form-select edit-mode">
                        <option value="" selected>Select</option>
                        <option value="done" @if ($order->work_status == 'done') selected @endif>
                            done</option>
                        <option value="pending" @if ($order->work_status == 'pending') selected @endif>
                            pending</option>
                        <option value="send to customer" @if ($order->work_status == 'send to customer') selected @endif>
                            send to customer</option>
                        <option value="send to designer" @if ($order->work_status == 'send to designer') selected @endif>
                            send to designer</option>
                        <option value="error" @if ($order->work_status == 'error') selected @endif>
                            error</option>
                    </select>
                </td>
                <td>
                    <span
                        class="badge fs-5 
                                                                                                                        @if ($order->payment_status == 'done') bg-primary
                                                                                                                        @elseif($order->payment_status == 'pending') bg-danger
                                                                                                                        @elseif($order->payment_status == 'rejected') bg-warning
                                                                                                                        @elseif($order->payment_status == 'partial') bg-warning @endif">
                        {{ $order->payment_status }}
                    </span>
                </td>




                <td>
                    <span
                        class="badge fs-5  display-mode
                                                                                                                        @if ($order->cash == 1.0) bg-warning bg-gradient
                                                                                                                        @elseif ($order->cash == 0.0) text-dark @endif">
                        {{ $order->cash == 1.0 ? 'Cash' : 'None Cash' }}
                    </span>
                    <select name="cash" class="form-select edit-mode">
                        <option value="1" @if ($order->cash == 1) selected @endif>
                            cash payment</option>
                        <option value="0" @if ($order->cash == 0) selected @endif>
                            none cash payment</option>
                    </select>
                </td>
                <td>
                    <span class="badge bg-dark fs-5">
                        {{ $order->advertiser->name ?? 'N/A' }}
                    </span>
                </td>
                <td>
                    <span
                        class="badge fs-5 display-mode
                                                                                        @if ($order->workType && $order->workType->name != '') bg-dark @endif">
                        {{ $order->workType?->name ?? '-' }}
                    </span>
                    <select name="work_type_id" class="form-select edit-mode">
                        <option value="" selected>Select</option>
                        @foreach ($work_types as $work_type)
                            @if ($work_type->order_type == 'boosting')
                                <option value="{{ $work_type->id }}" @if ($order->workType && $order->workType->name == $work_type->name)
                                selected @endif>
                                    {{ $work_type->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </td>
                <td>{{ $order->package_amt + $order->service + $order->tax }}
                </td>
                <td>{{ $order->package_amt }}</td>
                <td>{{ $order->service }}</td>
                <td>{{ $order->tax }}</td>
                <td>
                    @if ($order->payment_status == 'partial')
                        {{ $order->advance - ($order->tax + $order->service) }}
                    @elseif($order->payment_status == 'done')
                        {{ $order->package_amt }}
                    @endif
                </td>
                <td>
                    <span>{{ $order->advance }}</span>
                </td>
                <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                    <span class="display-mode">{{ $order->details }}</span>
                    <input type="text" name="details" class="form-control edit-mode" value="{{ $order->details }}">
                </td>
                <td>
                    @if (empty($order->add_acc_id))
                        Not Added
                    @else
                        <a href="{{ $order->add_acc_id }}" target="_blank" class="btn btn-info display-mode">
                            <i class="ri-arrow-up-circle-line "></i>
                        </a>
                    @endif
                </td>

                <td>
                    <button type="button" class="btn btn-success view-slip-btn" data-invoice="{{ $order->invoice }}"
                        data-bs-toggle="modal" data-bs-target="#viewSlipModal">
                        <i class="ri-eye-line"></i>
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-primary update-sheet-btn" data-id="{{ $order->id }}"
                        data-bs-toggle="modal" data-bs-target="#updateSheetModal">
                        <i class=" ri-arrow-up-circle-fill"></i>
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-primary edit-btn display-mode">Edit</button>
                    <button type="button" class="btn btn-primary done-btnb edit-mode">Done</button>
                </td>
            </form>
        </tr>
    @endif
@endforeach