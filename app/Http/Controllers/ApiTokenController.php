<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camara;
use App\Estadistica;
use App\ZonaHoraria;
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

    public function centros(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        if (isset($from, $to)) {
            $centros = Centro::select('id','descripcion')
            ->with(['camaras.estadisticas' => function($q) use ($from, $to) {
                $q->whereRaw("created_at >= ? AND created_at <= ?", 
                array($from." 00:00:00", $to." 23:59:59"));
            }])
            // ->whereHas('camaras.estadisticas', function ($q) use ($from, $to) {
            //     // $q->select('id_bio_camara','voltaje','consumo','ip','created_at')->whereBetween('created_at', [$from, $to]);
            //     $q->whereRaw("created_at >= ? AND created_at <= ?", 
            //     array($from." 00:00:00", $to." 23:59:59"));
            // })
            ->get();
        } else {
            $centros = Centro::with('camaras.estadisticas')
            ->whereHas('camaras.estadisticas')            
            ->count();
        }
        return response()->json(['centros' => $centros]);
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
