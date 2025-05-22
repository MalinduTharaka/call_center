@foreach ($orders as $order)
                                                        @if ($order->order_type == 'video')
                                                            <tr data-order-id="{{ $order->id }}">
                                                                <form action="/admin/orders/updateV/{{ $order->id }}" method="post">
                                                                    @csrf
                                                                    @method('put')
                                                                    <td>{{ $order->id }}</td>
                                                                    <td>
                                                                        <span>{{ $order->created_at->format('Y-m-d') }}</span>
                                                                    </td>
                                                                    <td>{{ $order->croUser->cc_name ?? '-' }}</td>
                                                                    <td>{{ $order->plUser->name ?? '-' }}</td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode
                                                                                    @if ($order->ce == 'c') bg-primary
                                                                                    @elseif($order->ce == 'e') bg-danger @endif">
                                                                            {{ $order->ce }}
                                                                        </span>
                                                                        <select name="ce" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="c" @if ($order->ce == 'c') selected @endif>
                                                                                c
                                                                            </option>
                                                                            <option value="e" @if ($order->ce == 'e') selected @endif>
                                                                                e
                                                                            </option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->invoice }}</span>
                                                                        <input type="text" name="inv" class="form-control edit-mode"
                                                                            value="{{ $order->invoice }}" hidden>
                                                                    </td>
                                                                    <td
                                                                        style="width: 150px; max-width: 150px; white-space: normal; word-wrap: break-word;">
                                                                        <span class="display-mode">{{ $order->name }}</span>
                                                                        <input type="text" name="name"
                                                                            class="form-control edit-mode"
                                                                            value="{{ $order->name }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{ $order->contact }}</span>
                                                                        <input type="text" name="contact"
                                                                            class="form-control edit-mode"
                                                                            value="{{ $order->contact }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{ $order->amount }}</span>
                                                                        <input type="text" name="amount"
                                                                            class="form-control edit-mode"
                                                                            value="{{ $order->amount }}">
                                                                        <input type="text" name="amountold"
                                                                            class="form-control edit-mode"
                                                                            value="{{ $order->amount }}" hidden>
                                                                    </td>
                                                                    <td>
                                                                        <span class="display-mode">{{ $order->our_amount }}</span>
                                                                        <input type="text" name="our_amount"
                                                                            class="form-control edit-mode"
                                                                            value="{{ $order->our_amount }}">
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge fs-5 display-mode
                                                                            @if ($order->workType && $order->workType->name != '') bg-dark @endif">
                                                                            {{ $order->workType?->name ?? '-' }}
                                                                        </span>
                                                                        <select name="work_type_id" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            @foreach ($work_types as $work_type)
                                                                                @if ($work_type->order_type == 'video')
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
                                                                                    @if ($order->script == 'done') bg-primary
                                                                                    @elseif($order->script == 'pending') bg-danger
                                                                                    @elseif($order->script == 'send to customer') bg-warning
                                                                                    @elseif($order->script == 'send to designer') bg-dark @endif">
                                                                            {{ $order->script }}
                                                                        </span>
                                                                        <select name="script" class="form-select edit-mode">
                                                                            <option value="" selected></option>
                                                                            <option value="done" @if ($order->script == 'done')
                                                                            selected @endif>
                                                                                done</option>
                                                                            <option value="pending" @if ($order->script == 'pending')
                                                                            selected @endif>
                                                                                pending</option>
                                                                            <option value="send to customer" @if ($order->script == 'send to customer') selected
                                                                            @endif>
                                                                                send to customer</option>
                                                                            <option value="send to designer" @if ($order->script == 'send to designer') selected
                                                                            @endif>
                                                                                send to designer</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge fs-5 display-mode 
                                                                                    @if ($order->shoot == 'done') bg-primary
                                                                                    @elseif($order->shoot == 'pending') bg-danger
                                                                                    @elseif($order->shoot == 'send to customer') bg-warning
                                                                                    @elseif($order->shoot == 'send to designer') bg-dark @endif">
                                                                            {{ $order->shoot }}
                                                                        </span>
                                                                        <select name="shoot" class="form-select edit-mode">
                                                                            <option value="" selected></option>
                                                                            <option value="done" @if ($order->shoot == 'done')
                                                                            selected @endif>
                                                                                done</option>
                                                                            <option value="pending" @if ($order->shoot == 'pending')
                                                                            selected @endif>
                                                                                pending</option>
                                                                            <option value="send to customer" @if ($order->shoot == 'send to customer') selected @endif>
                                                                                send to customer</option>
                                                                            <option value="send to designer" @if ($order->shoot == 'send to designer') selected @endif>
                                                                                send to designer</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->video_time }}</span>
                                                                        <input type="text" name="video_time"
                                                                            value="{{ $order->video_time }}" hidden>
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
                                                                        <select name="work_status" class="form-select edit-mode">
                                                                            <option value="" selected></option>
                                                                            <option value="done" @if ($order->work_status == 'done')
                                                                            selected @endif>
                                                                                done</option>
                                                                            <option value="pending" @if ($order->work_status == 'pending') selected @endif>
                                                                                pending</option>
                                                                            <option value="send to customer" @if ($order->work_status == 'send to customer') selected
                                                                            @endif>
                                                                                send to customer</option>
                                                                            <option value="send to designer" @if ($order->work_status == 'send to designer') selected
                                                                            @endif>
                                                                                send to designer</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge fs-5 display-mode
                                                                                    @if ($order->payment_status == 'done') bg-primary
                                                                                    @elseif($order->payment_status == 'pending') bg-danger
                                                                                    @elseif($order->payment_status == 'rejected') bg-warning
                                                                                    @elseif($order->payment_status == 'partial') bg-warning @endif">
                                                                            {{ $order->payment_status }}
                                                                        </span>
                                                                        <select name="payment_status" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            <option value="done" @if ($order->payment_status == 'done') selected @endif>
                                                                                done</option>
                                                                            <option value="pending" @if ($order->payment_status == 'pending') selected @endif>
                                                                                pending</option>
                                                                            <option value="rejected" @if ($order->payment_status == 'rejected') selected
                                                                            @endif>
                                                                                rejected</option>
                                                                            <option value="partial" @if ($order->payment_status == 'partial') selected @endif>
                                                                                partial</option>
                                                                        </select>
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
                                                                        <span class="badge bg-dark fs-5 display-mode">
                                                                            {{ $order->Editor->name ?? 'N/A' }}
                                                                        </span>
                                                                        <select name="editor_id" class="form-select edit-mode">
                                                                            <option value="" selected>Select</option>
                                                                            @foreach ($users as $user)
                                                                                @if ($user->role == 'vde')
                                                                                    <option value="{{ $user->id }}" @if ($order->editor_id == $user->id) selected @endif>
                                                                                        {{ $user->name }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ $order->advance }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-success view-slip-btn"
                                                                            data-invoice="{{ $order->invoice }}"
                                                                            data-bs-toggle="modal" data-bs-target="#viewSlipModal">
                                                                            <i class="ri-eye-line"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-primary edit-btn display-mode">Edit</button>
                                                                        <button type="button"
                                                                            class="btn btn-primary done-btnv edit-mode">Done</button>
                                                                    </td>
                                                                </form>
                                                            </tr>
                                                        @endif
                                                    @endforeach