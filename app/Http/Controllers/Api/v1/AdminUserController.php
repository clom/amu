<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function isAdmin(){
        return Auth::user()->checkAdmin();
    }

    // user information
    public function index(Request $req){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);

        $userData = DB::table('users')->get();

        return response()->json($userData,200);
    }

    // get UserData
    public function show(Request $req, $id){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);

        $userData = DB::table('users')
            ->where('id', $id)
            ->first();

        return response()->json($userData,200);
    }

    public function update(Request $req, $id){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);

        // user check
        $userData = DB::table('users')
            ->where('id', $id)
            ->first();
        if(empty($userData))
            return response()->json(['message'=>'no user Data'], 404);
        // check permission
        $flag = true;
        if($userData->is_admin)
            $flag = false;
        try{
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'is_admin' => $flag
                ]);
        } catch (\Exception $ex){
            return response()->json(['message'=>'InternalServerError'], 500);
        }

        return response()->json([],204);
    }
}
