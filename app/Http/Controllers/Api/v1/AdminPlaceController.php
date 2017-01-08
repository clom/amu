<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class AdminPlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function isAdmin(){
        return Auth::user()->checkAdmin();
    }

    public function index(Request $req){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);

        $userData = DB::table('place')->get();

        return response()->json($userData,200);
    }

    public function show(Request $req, $id){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);

        $placeData = DB::table('place')
            ->where('id', $id)
            ->first();

        if(empty($placeData))
            return response()->json(['message'=>'no Place'], 404);

        return response()->json($placeData,200);
    }

    public function store(Request $req){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);

        $json = $req->json()->all();

        if(empty($json)){
            return response()->json(['message' => 'no request'],404);
        }
        $uuid = Uuid::generate();
        $uuid = $uuid = str_replace("-", "", $uuid);

        try{
            DB::table('place')
                ->insert([
                    'id' => $uuid,
                    'name' => $json['name'],
                    'created_at' => date('Y-m-d H:m:s'),
                    'updated_at' => date('Y-m-d H:m:s')
                ]);
        } catch (\Exception $ex){
            return response()->json(['message'=>'InternalServerError'], 500);
        }

        return response()->json(['id' => $uuid],201);
    }

    public function update(Request $req, $id){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);
        // check req
        $json = $req->json()->all();

        if(empty($json)){
            return response()->json(['message' => 'no request'],404);
        }

        // check place data
        $placeData = DB::table('place')
            ->where('id', $id)
            ->first();

        if(empty($placeData))
            return response()->json(['message'=>'no Place'], 404);

        // update action
        try{
            DB::table('place')
                ->where('id', $id)
                ->update([
                    'name' => isset($json['name'])? $json['name'] : $placeData->name,
                    'updated_at' => date('Y-m-d H:m:s')
                ]);
        } catch (\Exception $ex){
            return response()->json(['message'=>'InternalServerError'], 500);
        }

        return response()->json([],204);
    }

    public function destroy(Request $req, $id){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);

        // check place data
        $placeData = DB::table('place')
            ->where('id', $id)
            ->first();

        if(empty($placeData))
            return response()->json(['message'=>'no Place'], 404);

        // delete action
        try{
            DB::table('place')
                ->where('id', $id)
                ->delete();

        } catch (\Exception $ex){
            return response()->json(['message'=>'InternalServerError'], 500);
        }

        return response()->json([],200);
    }
}
