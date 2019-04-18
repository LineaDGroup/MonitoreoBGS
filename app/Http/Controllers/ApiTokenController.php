<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camara;
use App\Estadistica;
use App\ZonaHoraria;
use App\Sesion;
use App\Centro;
use App\User;

class ApiTokenController extends Controller
{

    public function getToken(Request $request)
    {
        $userId = \CRUDBooster::myId();
        $user = User::findOrFail($userId);
        
        $token = $user->generateToken();
        return view('token.index',compact('token'));
    }

    public function login(Request $request)
    {
        if(!isset($request->email,$request->token)) {
            return response()->json(['email or token not send'],422);
        }
        $user = User::where('email',$request->email)->where('api_token',$request->token)->first();
        if(!$user) {
            return response()->json(['email or token invalid'],422);
        }
        return response()->json(['msg' => true],200);
    }

    public function estadisticas(Request $request)
    {
        $from = $request->dateRange['startDate'];
        $to = $request->dateRange['endDate'];
        // dd($request->userId);
        $estadisticas = [];
        if (isset($from, $to)) {
            $estadisticas = Estadistica::select('id','id_bio_camara','voltaje','consumo','created_at')
            ->whereRaw("created_at >= ? AND created_at <= ?", array($from." 00:00:00", $to." 23:59:59"))
            ->whereHas('camara', function($q) use ($request) {
                $q->where('id_cms_users',$request->userId);
            })
            ->with(['camara' => function($q) use ($request) {
                $q->select('id','id_cms_users','nombre')->where('id_cms_users',$request->userId);;
            }])
            ->withCount('sesiones')
            ->get();
        } else {
            $estadisticas = Estadistica::select('id','id_bio_camara','voltaje','consumo','created_at')
            ->whereHas('camara', function($q) use ($request) {
                $q->where('id_cms_users',$request->userId);
            })
            ->with(['camara' => function($q) use ($request) {
                $q->select('id','id_cms_users','nombre')->where('id_cms_users',$request->userId);;
            }])
            ->withCount('sesiones')
            ->get();
        }
        $schema = array(array('name' => 'camara','dataType' => 'STRING'),
                        array('name'=> 'fecha','dataType' => 'STRING'),
                        array('name'=> 'sesiones','dataType' => 'NUMBER'),
                        array('name'=> 'fallas','dataType' => 'NUMBER'),
                        array('name'=> 'amperaje','dataType' => 'NUMBER'),
                        array('name'=> 'voltaje','dataType' => 'NUMBER'),
                        array('name'=> 'fallasVoltaje','dataType' => 'NUMBER'),
                        array('name'=> 'horasUso','dataType' => 'NUMBER')
        ); 

        $rows = array();
        foreach ($estadisticas as $key => $value) {
        //    $value->camara = $value->camara->nombre;
           $array = $value->toArray();
           $array['camara'] = $value->camara->nombre;  
           $v = array('values' => array_values($array));
           array_push($rows,$v);
        }
        $data = array('schema' => $schema,'rows' => $rows);

        return response()->json(['estadisticas' => $data]);
    }

    public function usuarios()
    {
        $users = User::select('id','name','email','status')
                 ->with(['camaras' => function($q) {
                    $q->select('id_cms_users','id_mac','nombre','descripcion','voltaje','amperaje_promedio','mail');
                 }])->get();
        return response()->json(['users' => $users]);
    }
}
