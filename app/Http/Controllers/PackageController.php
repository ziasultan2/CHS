<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $packageQuery = Package::query();
        $limit = Arr::get($searchParams, 'limit');
        $date = Arr::get($searchParams, 'date', '');
        if(!empty($date)){
            $packageQuery->where('updated_at', $date);
        }
        $price = Arr::get($searchParams, 'price', '');
        if(!empty($price)){
            $packageQuery->where('price', $price);
        }
        return PackageResource::collection($packageQuery->orderBy('updated_at', 'desc')->paginate($limit));
    }

    public function store(PackageRequest $request)
    {
        $limit = Package::whereDate('created_at', now())->count();
        if($limit >= 8){
            return response()->json(['message' => 'You can only create 8 packages per day'], 400);
        }
        $package = Package::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'publish_date' => $request->publish_date,
            'session_time' => $request->session_time,
            'user_id' => Auth::user()->id,
        ]);
        return new PackageResource($package);
    }

    public function show(Package $package)
    {
        Return new PackageResource($package);
    }

    public function update(PackageRequest $request, Package $package)
    {
        $package->update($request->all());
        return new PackageResource($package);
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return response()->json([
            'success' => true,
        ], 204);
    }
}
