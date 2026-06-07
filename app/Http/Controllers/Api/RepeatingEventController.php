<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepeatingEvent;
use Illuminate\Support\Carbon;

class RepeatingEventController extends Controller
{
    public function index()
    {
        return RepeatingEvent::all();
    }

    public function show($id)
    {
        $re = RepeatingEvent::find($id);
        if (!$re) return response()->json([],200);
        return $re;
    }

    public function store(Request $request)
    {
        $data = $request->only(['id','type','start_date','repeating_rule','data']);
        if (!isset($data['id'])) return response()->json(['error'=>'id required'],400);
        $re = RepeatingEvent::updateOrCreate(['id'=>$data['id']], $data);
        return response()->json($re,201);
    }

    public function update(Request $request, $id)
    {
        $re = RepeatingEvent::find($id);
        if(is_null($re)){
            $re = new RepeatingEvent();
        }
        
        $re->id = $id;
        $re->type = $request->input('type');
        $re->start_date = Carbon::parse($request->start_date);
        $re->end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');
        $re->repeating_rule = $request->input('repeating_rule'); 
        $re->ocurrencesType = $request->input('ocurrencesType'); 
        $re->data = $request->input('data'); 
        $re->list_id = $request['data']['id']; 
        $re->save();
        
        return $re;
    }

    public function destroy($id)
    {
        $re = RepeatingEvent::find($id);
        if (!$re) return response()->json([],200);
        $re->delete();
        return response()->json([],204);
    }

    public function clear()
    {
        RepeatingEvent::query()->delete();
        return response()->json([],204);
    }
}
