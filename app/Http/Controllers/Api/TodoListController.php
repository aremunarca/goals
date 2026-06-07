<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoList;

class TodoListController extends Controller
{
    public function index()
    {
        return TodoList::where('user_id', Auth::id())->get();
    }

    public function show($id)
    {
        $list = TodoList::where('listId', $id)->where('user_id', Auth::id())->get();
        if (!$list) return response()->json([], 200);
        return $list;
    }

    public function store(Request $request)
    {
        $data = $request->only(['id','name','is_custom','data']);
        if (!isset($data['id'])) return response()->json(['error'=>'id required'],400);
        $data['user_id'] = Auth::id();
        $list = TodoList::updateOrCreate(['id' => $data['id'], 'user_id' => $data['user_id']], $data);
        return response()->json($list, 201);
    }

    public function update(Request $request, $id)
    {
        $lists = [];
        $userId = Auth::id();

        foreach ($request->data as $key => $data) {
            $list = isset($data['id']) ? TodoList::where('id', $data['id'])->where('user_id', $userId)->first() : new TodoList();
            \Log::info(serialize($data));
            $list->user_id = $userId;
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
        $list = TodoList::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$list) return response()->json([], 200);
        $list->delete();
        return response()->json([],204);
    }

    public function clear()
    {
        TodoList::where('user_id', Auth::id())->delete();
        return response()->json([],204);
    }
}
