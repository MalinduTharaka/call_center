<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceIdentification;

class DeviceController extends Controller
{
    public function verifyDevice(Request $request)
    {
        // Validate the entered code
        $request->validate([
            'code' => 'required|string',
        ]);

        // Check if the code matches
        if ($request->code !== 'pls123') {
            return response()->json(['error' => 'Invalid code'], 403);
        }

        // Generate unique device ID based on IP and User-Agent
        $deviceId = md5($request->ip() . $request->header('User-Agent'));

        // If the device doesn't exist in the DB, add it
        if (!DeviceIdentification::where('device_id', $deviceId)->exists()) {
            DeviceIdentification::create(['device_id' => $deviceId]);
        }

        // Send a success response and set a cookie for the device ID
        return response()->json(['success' => true])
                         ->cookie('device_id', $deviceId, 60 * 24 * 365); // Cookie will expire in 1 year
    }

    public function checkDevice(Request $request)
    {
        // Check if the device ID is present in the cookies
        $deviceId = $request->cookie('device_id');

        if ($deviceId && DeviceIdentification::where('device_id', $deviceId)->exists()) {
            return response()->json(['verified' => true]);
        }

        return response()->json(['verified' => false]);
    }
}
