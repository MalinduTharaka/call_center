@foreach ($orders as $order)
                                                            @if ($order->ps == '1' && $order->order_type == 'designs')
                                                                <tr data-order-id="{{ $order->id }}">
                                                                    <form action="/orders/designs/update/{{ $order->id }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('put')
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
                                                                            <span
                                                                                class="display-mode">{{ $order->invoice }}</span>
                                                                            <input type="text" name="inv"
                                                                                class="form-control edit-mode"
                                                                                value="{{ $order->invoice }}" hidden>
                                                                        </td>
                                                                        <td style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                                                            <span>{{ $order->name }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span>{{ $order->contact }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge fs-5 display-mode
                                                                                @if ($order->workType && $order->workType->name != '') bg-dark @endif">
                                                                                {{ $order->workType?->name ?? '-' }}
                                                                            </span>
                                                                            <select name="work_type_id" class="form-select edit-mode">
                                                                                <option value="" selected>Select</option>
                                                                                @foreach ($work_types as $work_type)
                                                                                    @if ($work_type->order_type == 'designs')
                                                                                        <option value="{{ $work_type->id }}"
                                                                                            @if ($order->workType && $order->workType->name == $work_type->name) selected @endif>
                                                                                            {{ $work_type->name }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge fs-5 display-mode
                                                                                                            @if ($order->work_status == 'done') bg-primary
                                                                                                            @elseif($order->work_status == 'pending') bg-danger
                                                                                                            @elseif($order->work_status == 'send to customer') bg-warning
                                                                                                            @elseif($order->work_status == 'send to designer') bg-dark @endif">
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
                                                                        <td>{{ $order->Designer->name ?? '-' }}</td>
                                                                        <td>
                                                                            @if ($order->d_img)
                                                                                <!-- Thumbnail with modal trigger -->
                                                                                <button type="button" class="btn btn-success view-slip-btn"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#designPreviewModal-{{ $order->id }}">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </button>
                                                                            @else
                                                                                —
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <span>{{ $order->amount }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span>{{ $order->advance }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge fs-5  display-mode
                                                                                                            @if ($order->cash == 1.0) bg-warning bg-gradient
                                                                                                            @elseif ($order->cash == 0.0) text-dark @endif">
                                                                                {{ $order->cash == 1.0 ? 'Cash' : 'None Cash' }}
                                                                            </span>
                                                                            <select name="cash"
                                                                                class="form-select edit-mode">
                                                                                <option value="1"
                                                                                    @if ($order->cash == 1) selected @endif>
                                                                                    cash payment</option>
                                                                                <option value="0"
                                                                                    @if ($order->cash == 0) selected @endif>
                                                                                    none cash payment</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-success view-slip-btn" 
                                                                                    data-invoice="{{ $order->invoice }}" 
                                                                                    data-bs-toggle="modal" 
                                                                                    data-bs-target="#viewSlipModal">
                                                                                <i class="ri-eye-line"></i>
                                                                            </button>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button"
                                                                                class="btn btn-primary edit-btn display-mode">Edit</button>
                                                                            <button type="button"
                                                                                class="btn btn-primary done-btnd edit-mode">Done</button>
                                                                        </td>
                                                                    </form>
                                                                </tr>
                                                            @endif
                                                        @endforeach