<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TodoList;

class TodoListController extends Controller
{
    public function index()
    {
        return TodoList::all();
    }

    public function show($id)
    {
        $list = TodoList::where('listId', $id)->get();
        if (!$list) return response()->json([], 200);
        return $list;
    }

    public function store(Request $request)
    {
        $data = $request->only(['id','name','is_custom','data']);
        if (!isset($data['id'])) return response()->json(['error'=>'id required'],400);
        $list = TodoList::updateOrCreate(['id'=>$data['id']], $data);
        return response()->json($list, 201);
    }

    public function update(Request $request, $id)
    {   $lists = [];
        
        foreach ($request->data as $key => $data) {
            $list = isset($data['id']) ? TodoList::where('id', $data['id'])->first() : new TodoList();
           \Log::info(serialize($data));
            $list->listId = $id;
            $list->text = $data['text'] ?? null;
            $list->desc = $data['desc'] ?? null;
            $list->color = $data['color'] ?? null;
            $list->is_custom = $data['is_custom'] ?? false;
            $list->checked = $data['checked'];
            $list->alarm = $data['alarm'] ?? false;
            $list->save();    
            $lists[] = $list;
        }
         return response()->json($lists,200);
       
    }

    public function destroy($id)
    {
        $list = TodoList::find($id);
        if (!$list) return response()->json([], 200);
        $list->delete();
        return response()->json([],204);
    }

    public function clear()
    {
        TodoList::query()->delete();
        return response()->json([],204);
    }
}
