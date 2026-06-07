<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;

class GoalController extends Controller
{
    public function all(){
        try {

            $goals = Goal::all();

            return response()->json(['data' => $goals], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ] , 400);
        }
    }
}
