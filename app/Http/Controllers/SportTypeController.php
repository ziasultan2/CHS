<?php

namespace App\Http\Controllers;

use App\Http\Requests\SportTypeRequest;
use App\Http\Resources\SportTypeResource;
use App\Models\SportType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SportTypeController extends Controller
{
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $sportTypeQuery = SportType::query();
        $limit = Arr::get($searchParams, 'limit');
        $date = Arr::get($searchParams, 'date', '');
        if(!empty($date)){
            $sportTypeQuery->where('updated_at', $date);
        }
        return SportTypeResource::collection($sportTypeQuery->orderBy('updated_at', 'desc')->paginate($limit));
    }

    public function store(SportTypeRequest $request)
    {
        $limit = SportType::whereDate('created_at', now())->count();
        if($limit >= 10){
            return response()->json(['message' => 'You can only create 10 sport types per day'], 400);
        }
        $SportType = SportType::create(['name' => $request->name]);
        return response()->json([
            'success' => true,
            'data' => $SportType
        ], 201);
    }

    public function show(SportType $SportType)
    {
        return response()->json([
            'success' => true,
            'data' => $SportType
        ], 200);
    }

    public function update(SportTypeRequest $request, SportType $sportType)
    {
        $sportType->update([
            'name' => $request->name
        ]);
        return response()->json([
            'success' => true,
            'data' => $sportType
        ], 200);
    }

    public function destroy(SportType $sportType)
    {
        $sportType->delete();
        return response()->json([
            'success' => true,
        ], 204);
    }
}
