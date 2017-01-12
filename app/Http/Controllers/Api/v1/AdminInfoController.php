<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class AdminInfoController extends Controller
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

        $query = $req->input('q') != null ? $req->input('q') : null;
        $limit = $req->input('li') != null ? $req->input('li') : 10;
        $offset = $req->input('off') != null ? $req->input('off') : 0;

        $sql = DB::table('infolog');

        if(empty($query)){
            $word = explode(" ", $query);
            foreach ($word as $value){
                $sql->where('name', $query);
            }
        }

        $infoData = $sql
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json($infoData,200);
    }

    public function show(Request $req, $id){
        if(!$this->isAdmin())
            return response()->json(['message'=>'no Admin user'], 403);

        $infoData = DB::table('infolog')
            ->where('id', $id)
            ->first();

        if(empty($infoData))
            return response()->json(['message'=>'no info'], 404);

        return response()->json($infoData,200);
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
            DB::table('infolog')
                ->insert([
                    'id' => $uuid,
                    'name' => $json['name'],
                    'status' => $json['status'],
                    'is_topAlert' => $json['is_topAlert'],
                    'description' => $json['description'],
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

        // check info data
        $infoData = DB::table('infolog')
            ->where('id', $id)
            ->first();

        if(empty($infoData))
            return response()->json(['message'=>'no Info'], 404);

        // update action
        try{
            DB::table('infolog')
                ->where('id', $id)
                ->update([
                    'name' => isset($json['name'])? $json['name'] : $infoData->name,
                    'status' => isset($json['status'])? $json['status'] : $infoData->status,
                    'is_topAlert' => isset($json['is_topAlert'])? $json['is_topAlert'] : $infoData->is_topAlert,
                    'description' => isset($json['description'])? $json['description'] : $infoData->description,
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

        // check info data
        $placeData = DB::table('infolog')
            ->where('id', $id)
            ->first();

        if(empty($placeData))
            return response()->json(['message'=>'no info'], 404);

        // delete action
        try{
            DB::table('infolog')
                ->where('id', $id)
                ->delete();

        } catch (\Exception $ex){
            return response()->json(['message'=>'InternalServerError'], 500);
        }

        return response()->json([],200);
    }
}
