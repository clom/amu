<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminScheduleController extends Controller
{
    public function index(Request $req){
        return response()->json([],200);
    }

    public function show(Request $req, $id){
        return response()->json([],200);
    }

    public function store(Request $req){
        return response()->json([],201);
    }

    public function update(Request $req, $id){
        return response()->json([],204);
    }

    public function destroy(Request $req, $id){
        return response()->json([],200);
    }
}
