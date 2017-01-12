<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminScheduleController extends Controller
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

        $Data = DB::table('schedule')->get();

        return response()->json($Data,200);
    }

    public function show(Request $req, $id){
        $scheduleData = DB::table('schedule')
            ->where('id', $id)
            ->first();

        if(empty($scheduleData))
            return response()->json(['message'=>'no info'], 404);

        return response()->json($scheduleData,200);
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
            DB::table('schedule')
                ->insert([
                    'id' => $uuid,
                    'name' => $json['name'],
                    'startDate' => date('Y-m-d H:i:s', strtotime('-9 hour',strtotime($json['startDate']))),
                    'endDate' => date('Y-m-d H:i:s', strtotime('-9 hour',strtotime($json['endDate']))),
                    'isDefault' => $json['isDefault'],
                    'isStopWeekend' => $json['isStopWeekend'],
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
        $data = DB::table('schedule')
            ->where('id', $id)
            ->first();

        if(empty($data))
            return response()->json(['message'=>'no Info'], 404);

        // update action
        try{
            DB::table('schedule')
                ->where('id', $id)
                ->update([
                    'name' => isset($json['name'])? $json['name'] : $data->name,
                    'startDate' => isset($json['startDate'])? date('Y-m-d H:i:s', strtotime('-9 hour',strtotime($json['startDate']))) : $data->startDate,
                    'endDate' => isset($json['endDate'])? date('Y-m-d H:i:s', strtotime('-9 hour',strtotime($json['endDate']))) : $data->endDate,
                    'isDefault' => isset($json['isDefault'])? $json['isDefault'] : $data->isdefault,
                    'isStopWeekend' => isset($json['isStopWeekend'])? $json['isStopWeekend'] : $data->isdefault,
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

        // check schedule data
        $Data = DB::table('schedule')
            ->where('id', $id)
            ->first();

        if(empty($Data))
            return response()->json(['message'=>'no schedule'], 404);

        // delete action
        try{
            DB::table('schedule')
                ->where('id', $id)
                ->delete();

        } catch (\Exception $ex){
            return response()->json(['message'=>'InternalServerError'], 500);
        }

        return response()->json([],200);
    }
}
