<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageBookingRequest;
use App\Models\PackageBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageBookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = PackageBooking::where('user_id', Auth::user()->id)->with('package')->get();
        return response()->json($bookings);
    }

    public function store(PackageBookingRequest $request)
    {
        $bookedPackage = PackageBooking::create([
            'package_id' => $request->package_id,
            'user_id' => Auth::user()->id,
        ]);
        return response()->json([
            'message' => 'Package booked successfully',
            'data' => $bookedPackage,
        ], 201);
    }

    public function show($id)
    {
        //
    }
}
