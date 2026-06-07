<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepeatingEventByDate;

class RepeatingEventByDateController extends Controller
{
    public function index()
    {
        return RepeatingEventByDate::all();
    }

    public function show($date)
    {
        $re = RepeatingEventByDate::find($date);
        if (!$re) return response()->json([],200);
        return $re;
    }

    public function update(Request $request, $date)
    {
        $payload = $request->only(['data']);
        $re = RepeatingEventByDate::updateOrCreate(['date'=>$date], ['data'=>$payload['data'] ?? []]);
        return $re;
    }

    public function destroy($date)
    {
        $re = RepeatingEventByDate::find($date);
        if (!$re) return response()->json([],200);
        $re->delete();
        return response()->json([],204);
    }

    public function clear()
    {
        RepeatingEventByDate::query()->delete();
        return response()->json([],204);
    }
}
