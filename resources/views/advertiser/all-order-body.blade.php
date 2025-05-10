@foreach ($orders as $order)
    <tr class="fw-semibold" data-order-id="{{ $order->id }}" data-add-acc="{{ $order->add_acc }}">
        <form action="/advertisers_all_order/update/{{ $order->id }}" method="post">
            @csrf
            @method('put')
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at->format('Y-m-d') }}</td>
            <td>
                <span
                    class="badge fs-5 display-mode
                    @if ($order->ce == 'c') bg-primary
                    @elseif($order->ce == 'e') bg-danger @endif">
                    {{ $order->ce }}
                </span>
            </td>
            <td>
                <span>{{ $order->invoice }}</span>
            </td>
            <td>
                <span class="fs-5">{{ $order->plUser->name ?? '-' }}</span>
            </td>
            <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                {{ $order->name }}
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
                <span>{{ $order->contact }}</span>
            </td>
            <td>
                <span
                    class="badge fs-5
                    @if (!$order->workType->name == '') bg-dark @endif">
                    {{ $order->workType->name ?? '-' }}
                </span>
            </td>

            <td>
                <span
                    class="badge fs-5 bg-dark display-mode">{{ $order->page }}</span>
                <select name="page"
                    class="form-select edit-mode">
                    <option value="" selected>Select</option>
                    <option value="new"
                        @if ($order->page == 'new') selected @endif>
                        new</option>
                    <option value="our"
                        @if ($order->page == 'our') selected @endif>
                        our</option>
                    <option value="existing"
                        @if ($order->page == 'existing') selected @endif>
                        existing
                    </option>
                </select>
            </td>
            <td>
                <span
                    class="badge fs-5 display-mode
                    @if ($order->work_status == 'done') bg-primary
                    @elseif($order->work_status == 'pending') bg-danger
                    @elseif($order->work_status == 'send to customer') bg-warning
                    @elseif($order->work_status == 'send to designer') bg-dark
                    @elseif($order->work_status == 'error') bg-danger @elseif($order->work_status == '')
                        @else
                        bg-info @endif">
                    {{ $order->work_status }}
                </span>
                <select name="work_status"
                    class="form-select edit-mode">
                    <option value="" selected>Select</option>
                    <option value="done"
                        @if ($order->work_status == 'done') selected @endif>
                        done</option>
                    <option value="pending"
                        @if ($order->work_status == 'pending') selected @endif>
                        pending</option>
                    <option value="send to customer"
                        @if ($order->work_status == 'send to customer') selected @endif>
                        send to customer</option>
                    <option value="send to designer"
                        @if ($order->work_status == 'send to designer') selected @endif>
                        send to designer</option>
                    <option value="error"
                        @if ($order->work_status == 'error') selected @endif>
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
                    class="badge fs-5
                    @if ($order->cash == 1.0) bg-warning bg-gradient
                    @elseif ($order->cash == 0.0) text-dark @endif">
                    {{ $order->cash == 1.0 ? 'Cash' : 'None Cash' }}
                </span>
            </td>
            <td>
                <span class="badge bg-dark fs-5 display-mode advertiser-name">
                    {{ $order->advertiser->name ?? 'N/A' }}
                </span>
                <select name="advertiser_id" class="form-select edit-mode">
                    <option value="" selected>Select</option>
                    @foreach ($users as $user)
                        @if ($user->role == 'adv' || $user->role == 'admin')
                            <option value="{{ $user->id }}"
                                @if ($order->advertiser_id == $user->id) selected @endif>
                                {{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td>{{ $order->package_amt + $order->service + $order->tax }}</td>
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
                <span">{{ $order->advance }}</span>
            </td>
            <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                <span
                    class="display-mode">{{ $order->details }}</span>
                <input type="text" name="details"
                    class="form-control edit-mode" style="width: 50px;"
                    value="{{ $order->details }}">
            </td>
            <td>
                @if (empty($order->add_acc_id))
                    <span class="display-mode">Not Added</span>
                @else
                    <a href="{{ $order->add_acc_id }}"
                        target="_blank"
                        class="btn btn-info display-mode">
                        <i class="ri-arrow-up-circle-line "></i>
                    </a>
                @endif
                <input type="text" name="add_acc_id"
                    class="form-control edit-mode"
                    value="{{ $order->add_acc_id }}">
            </td>
            <td>
                @if ($order->work_status != 'advertise pending' || Auth::user()->id == $order->advertiser_id)
                    <button type="button" class="btn btn-primary edit-btn">Edit</button>
                @endif

                <button type="button" class="btn btn-primary done-btnb" data-order-id="{{ $order->id }}">Done</button>
                <button type="button" class="btn btn-warning cancel-btn"><i class="bi bi-x-circle"></i></button>
            </td>
        </form>
    </tr>
@endforeach