<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Slip;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class SlipController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Adjust mime types and file size as needed
            'inv' => 'required|exists:orders,invoice',  // Ensure invoice exists
            'bank' => 'required|string',
            'payment_type' => 'required|in:completed,partial',
        ]);

        // Find the invoice (inv) in the orders table based on the provided inv
        $order = Order::where('invoice', $request->inv)->first();

        if ($order) {
            // Ensure the file exists before attempting to store it
            if ($request->hasFile('slip') && $request->file('slip')->isValid()) {
                // Store the slip image in the 'public/slips' directory in storage
                $path = $request->file('slip')->store('slips', 'public');

                // Create the slip record
                $slip = Slip::create([
                    'order_id' => $request->inv,
                    'slip_path' => $path,
                    'bank' => $request->bank,
                ]);

                // Update the payment status based on payment_type
                if ($request->payment_type == 'completed') {
                    Order::where('invoice', $request->inv)->update(['payment_status' => 'done', 'advance' => 0]);
                    $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
                    $invoice->update(['status' => 'paid']);
                } elseif ($request->payment_type == 'partial') {
                    // Fetch all orders related to the invoice
                    $orders = Order::where('invoice', $request->inv)->get();
                    $totalOrders = $orders->count();

                    // Retrieve advance inputs (assuming they are coming from the request)
                    $advanceb = $request->advanceb;
                    $advanced = $request->advanced;
                    $advancev = $request->advancev;

                    $invoice = Invoice::where('inv', $request->inv)->firstOrFail();
                    $advance = $advanceb + $advanced + $advancev;

                    if (empty($invoice->amt1)) {
                        // If amt1 is empty, update amt1
                        $invoice->update(['amt1' => $advance]);
                    } elseif (empty($invoice->amt2)) {
                        // If amt1 is not empty but amt2 is empty, update amt2
                        $invoice->update(['amt2' => $advance]);
                    } elseif (empty($invoice->amt3)) {
                        // If amt1 and amt2 are not empty but amt3 is empty, update amt3
                        $invoice->update(['amt3' => $advance]);
                    }



                    // Case 1: Only one advance input is provided
                    if ($advanceb && !$advanced && !$advancev) {
                        // Divide advanceb evenly among all orders
                        $divided = $advanceb / $totalOrders;
                        foreach ($orders as $order) {
                            $order->advance = $divided;
                            $order->payment_status = 'partial';
                            $order->save();
                        }
                    } elseif (!$advanceb && $advanced && !$advancev) {
                        $divided = $advanced / $totalOrders;
                        foreach ($orders as $order) {
                            $order->advance = $divided;
                            $order->payment_status = 'partial';
                            $order->save();
                        }
                    } elseif (!$advanceb && !$advanced && $advancev) {
                        $divided = $advancev / $totalOrders;
                        foreach ($orders as $order) {
                            $order->advance = $divided;
                            $order->payment_status = 'partial';
                            $order->save();
                        }
                    }
                    // Case 2: Two of the advance inputs are provided
                    elseif ($advanceb && $advanced && !$advancev) {
                        // Count rows for each order type
                        $boostingCount = $orders->where('order_type', 'boosting')->count();
                        $designsCount = $orders->where('order_type', 'designs')->count();

                        if ($boostingCount > 0) {
                            $dividedBoost = $advanceb / $boostingCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'boosting') {
                                    $order->advance = $dividedBoost;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }

                        if ($designsCount > 0) {
                            $dividedDesign = $advanced / $designsCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'designs') {
                                    $order->advance = $dividedDesign;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }
                    } elseif ($advanceb && $advancev && !$advanced) {
                        $boostingCount = $orders->where('order_type', 'boosting')->count();
                        $videoCount = $orders->where('order_type', 'video')->count();

                        if ($boostingCount > 0) {
                            $dividedBoost = $advanceb / $boostingCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'boosting') {
                                    $order->advance = $dividedBoost;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }

                        if ($videoCount > 0) {
                            $dividedVideo = $advancev / $videoCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'video') {
                                    $order->advance = $dividedVideo;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }
                    } elseif ($advanced && $advancev && !$advanceb) {
                        $designsCount = $orders->where('order_type', 'designs')->count();
                        $videoCount = $orders->where('order_type', 'video')->count();

                        if ($designsCount > 0) {
                            $dividedDesign = $advanced / $designsCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'designs') {
                                    $order->advance = $dividedDesign;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }

                        if ($videoCount > 0) {
                            $dividedVideo = $advancev / $videoCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'video') {
                                    $order->advance = $dividedVideo;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }
                    }
                    // Case 3: All three advance inputs are provided
                    elseif ($advanceb && $advanced && $advancev) {
                        $boostingCount = $orders->where('order_type', 'boosting')->count();
                        $designsCount = $orders->where('order_type', 'designs')->count();
                        $videoCount = $orders->where('order_type', 'video')->count();

                        if ($boostingCount > 0) {
                            $dividedBoost = $advanceb / $boostingCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'boosting') {
                                    $order->advance = $dividedBoost;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }

                        if ($designsCount > 0) {
                            $dividedDesign = $advanced / $designsCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'designs') {
                                    $order->advance = $dividedDesign;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }

                        if ($videoCount > 0) {
                            $dividedVideo = $advancev / $videoCount;
                            foreach ($orders as $order) {
                                if ($order->order_type == 'video') {
                                    $order->advance = $dividedVideo;
                                    $order->payment_status = 'partial';
                                    $order->save();
                                }
                            }
                        }
                    }
                }

                return redirect()->back()->with('success', 'Payment slip uploaded successfully.')->with('slip_path', $path);

            } else {
                return redirect()->back()->with('error', 'File upload failed or no file provided.');

            }
        }

        // Return an error if the order was not found
        return redirect()->back()->with('error', 'Invoice not found in the order records.');

    }


}
