<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camara;
use App\Estadistica;
use App\ZonaHoraria;
use App\Sesion;
use App\Centro;
use App\User;
use Carbon\Carbon;

class ApiTokenController extends Controller
{

    public function getToken(Request $request)
    {
        $userId = \CRUDBooster::myId();
        $user = User::findOrFail($userId);

        $token = $user->generateToken();
        return view('token.index', compact('token'));
    }

    public function login(Request $request)
    {
        if (!isset($request->email, $request->token)) {
            $object = collect([
                'status' => false,
                'msg' => 'Login Failed',
            ]);
            return response()->json($object, 401);
        }
        $user = User::where('email', $request->email)->where('api_token', $request->token)->first();
        if (!$user) {
            $object = collect([
                'status' => false,
                'msg' => 'Login Failed',
            ]);
            return response()->json($object, 401);
        }
        // $object = new stdClass;
        $object = collect([
            'status' => true,
            'msg' => 'Login OK',
        ]);
        return response()->json($object, 200);
    }

    public function estadisticas(Request $request)
    {
        \Log::info($request);
        $from = $request->dateRange['startDate'];
        $to = $request->dateRange['endDate'];
        // dd($request->userId);
        $estadisticas = [];
        if (isset($from, $to)) {
            $estadisticas = Estadistica::select('id', 'id_bio_camara', 'voltaje', 'consumo', 'created_at')
                ->whereRaw("created_at >= ? AND created_at <= ?", array($from . " 00:00:00", $to . " 23:59:59"))
                ->whereHas('camara', function ($q) use ($request) {
                    $q->where('id_cms_users', $request->userId);
                })
                ->with(['camara' => function ($q) use ($request) {
                    $q->select('id', 'id_cms_users', 'nombre','id_bio_centro')->where('id_cms_users', $request->userId);
                }])
                ->with(['camara.centro' => function ($q) {
                    $q->select('id','descripcion');
                }])
                ->withCount('sesiones')
                ->get();
        } else {
            $estadisticas = Estadistica::select('id', 'id_bio_camara', 'voltaje', 'consumo', 'created_at')
                ->whereHas('camara', function ($q) use ($request) {
                    $q->where('id_cms_users', $request->userId);
                })
                ->with(['camara' => function ($q) use ($request) {
                    $q->select('id', 'id_cms_users', 'nombre')->where('id_cms_users', $request->userId);
                }])
                ->withCount('sesiones')
                ->get();
        }
        $schema = array();
        foreach ($request->fields as $key => $value) {
            $type = $this->getDataType($value['name']);
            array_push($schema,array('name' => $value['name'], 'dataType' => $type));
        };

        $rows = array();
        foreach ($estadisticas as $key => $value) {
            //    $value->camara = $value->camara->nombre;
            $array = $value->toArray();
            $array['camara'] = $value->camara->nombre;
            $array['centro'] = $value->camara->centro->descripcion;
            $array['fecha'] = Carbon::createFromTimeString($value->created_at)->format('Ymd');
            $array['hora'] = Carbon::createFromTimeString($value->created_at)->format('H');
            $array = array_map('strval', $array);
            //    dd( array_values($request->fields));
            $ar = $this->getOrderedArray($array, array_values($request->fields));
            $v = array('values' => $ar);
            array_push($rows, $v);
        }
        $object = collect([
            'schema' => $schema,
            'rows' => $rows,
            'cachedData' => false
        ]);
        // $data = array('schema' => $schema, 'rows' => $rows,'cachedData' => false);


        return response()->json($object,200);
    }

    public function usuarios()
    {
        $users = User::select('id', 'name', 'email', 'status')
            ->with(['camaras' => function ($q) {
                $q->select('id_cms_users', 'id_mac', 'nombre', 'descripcion', 'voltaje', 'amperaje_promedio', 'mail');
            }])->get();
        return response()->json(['users' => $users]);
    }

    protected function getOrderedArray($array, $order)
    {
        $orderedarray = [];
        $ord = $this->array_values_recursive($order); 
        // dd();
        // return array_only($array, $ord);
        foreach($ord as $key => $v) {
            // dd($v['name']);
            // $i = $v['name'];
            $orderedarray[$key] = $array[$v] ;
        }

        return $orderedarray;
    }

    protected function array_values_recursive($ary)
    {
        $lst = array();
        foreach (array_keys($ary) as $k) {
            $v = $ary[$k];
            if (is_scalar($v)) {
                $lst[] = $v;
            } elseif (is_array($v)) {
                $lst = array_merge(
                    $lst,
                    $this->array_values_recursive($v)
                );
            }
        }
        return $lst;
    }

    protected function getDataType($field)
    {
        // var_dump($field);
        // $d = '';
        if($field == 'camara' || $field == 'fecha') {
            return "STRING";
        } elseif ($field == 'sesiones_count' || $field == 'fallas' || $field == 'amperaje' || $field == 'voltaje' || $field == 'fallasVoltaje' || $field == 'horasUso') {
            return 'NUMBER';
        }
        return '';
    }
}
