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
        // \Log::info($request);
        $from = $request->dateRange['startDate'];
        $to = $request->dateRange['endDate'];
        // dd($request->userId);

        $rows = array();


        if (in_array(array('name' => "voltaje"), $request->fields) || in_array(array('name' => "sesiones_count"), $request->fields) || in_array(array('name' => "consumo"), $request->fields)) {
            $estadisticas = [];
            if (isset($from, $to)) {
                $estadisticas = Estadistica::select('id', 'id_bio_camara', 'voltaje', 'consumo', 'created_at')
                    ->whereRaw("created_at >= ? AND created_at <= ?", array($from . " 00:00:00", $to . " 23:59:59"))
                    ->where('consumo', '>=', 0.2)
                    ->whereHas('camara', function ($q) use ($request) {
                        $q->where('id_cms_users', $request->userId);
                    })
                    ->with(['camara' => function ($q) use ($request) {
                        $q->select('id', 'id_cms_users', 'nombre', 'id_bio_centro')->where('id_cms_users', $request->userId);
                    }])
                    ->with(['camara.centro' => function ($q) {
                        $q->select('id', 'descripcion');
                    }])
                    ->withCount('sesiones')
                    ->get();
            } else {
                $estadisticas = Estadistica::select('id', 'id_bio_camara', 'voltaje', 'consumo', 'created_at')
                    ->where('consumo', '>=', 0.2)
                    ->whereHas('camara', function ($q) use ($request) {
                        $q->where('id_cms_users', $request->userId);
                    })
                    ->with(['camara' => function ($q) use ($request) {
                        $q->select('id', 'id_cms_users', 'nombre')->where('id_cms_users', $request->userId);
                    }])
                    ->with(['camara.centro' => function ($q) {
                        $q->select('id', 'descripcion');
                    }])
                    ->withCount('sesiones')
                    ->get();
            }

            foreach ($estadisticas as $key => $value) {
                //    $value->camara = $value->camara->nombre;
                $array = $value->toArray();
                $array['camara'] = $value->camara->nombre;
                $array['centro'] = $value->camara->centro->descripcion;
                // $array['consumo'] = NULL;
                if(isset($value->created_at)) {
                    $array['fecha'] = Carbon::createFromTimeString($value->created_at)->format('Ymd');
                    $array['hora'] = Carbon::createFromTimeString($value->created_at)->format('H');
                }
                $array['fecha'] = $array['hora'] = null;

                $array = array_map('strval', $array);
                //    dd( array_values($request->fields));
                $ar = $this->getOrderedArray($array, array_values($request->fields));
                $v = array('values' => $ar);
                array_push($rows, $v);
            }
        }

        // ADDED DATA FROM STORE_PROCEDURE 
        if (in_array(array('name' => "tiempo_uso"), $request->fields)) {
            $reportesData = json_decode($this->reportes($request->userId, $from, $to, '1'));
            foreach ($reportesData as $key => $value) {
                $array = [];
                sscanf($value->consumo_diario, "%d:%d:%d", $hours, $minutes, $seconds);
                $time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
                $array['tiempo_uso'] = strval($time_seconds);
                $array['camara'] = $value->nom_camara;
                $array['centro'] = $value->desc_centro;
                if(isset($value->fecha)) {
                    $array['fecha'] = Carbon::createFromFormat('Y-m-d', $value->fecha)->format('Ymd');
                }
                else {
                    $array['fecha'] = null;
                }
                $ar = $this->getOrderedArray($array, array_values($request->fields));
                $v = array('values' => $ar);
                array_push($rows, $v);
            }
        }

        // ADDED DATA FROM STORE_PROCEDURE CHECK_FALLAS_VOLTAJE
        if (in_array(array('name' => "fallasVoltaje"), $request->fields)) {
            $reportesData = json_decode($this->reportes($request->userId, $from, $to, '3'));
            // dd($reportesData);
            foreach ($reportesData as $key => $value) {
                $array = [];
                $array['fallasVoltaje'] = strval($value->count);
                $array['camara'] = $value->nom_camara;
                $array['centro'] = $value->desc_centro;
                $array['clase_falla_voltaje'] = $value->clase;

                if(isset($value->fecha)) {
                    $array['fecha'] = Carbon::createFromFormat('Y-m-d', $value->fecha)->format('Ymd');
                }
                else {
                    $array['fecha'] = null;
                }
                $ar = $this->getOrderedArray($array, array_values($request->fields));
                $v = array('values' => $ar);
                array_push($rows, $v);
            }
        }


        // ADDED DATA FROM STORE_PROCEDURE CHECK_FALLAS_VOLTAJE
        if (in_array(array('name' => "fallas"), $request->fields)) {
            $reportesData = json_decode($this->reportes($request->userId, $from, $to, '2'));
            // dd($reportesData);
            foreach ($reportesData as $key => $value) {
                $array = [];
                $array['fallas'] = strval($value->count);
                $array['camara'] = $value->nom_camara;
                $array['centro'] = $value->desc_centro;
                $array['clase_falla'] = $value->clase;

                // $array['fecha'] = Carbon::createFromFormat('Y-m-d', $value->fecha)->format('Ymd');
                if(isset($value->fecha)) {
                    $array['fecha'] = Carbon::createFromFormat('Y-m-d', $value->fecha)->format('Ymd');
                }
                else {
                    $array['fecha'] = null;
                }
                $ar = $this->getOrderedArray($array, array_values($request->fields));
                $v = array('values' => $ar);
                array_push($rows, $v);
            }
        }

        // ADDED CAMARA, CENTRO O USUARIOS
        $validacion = [array('name' => 'centro'), array('name' => 'camara'), array('name' => 'usuario')];
        // Comprobamos que en REQUEST FIELDS tenemos solo camara, centro y/o usuario. 
        $checkCamaras = array_map(function ($f) use ($validacion) {
            return !in_array($f, $validacion);
        }, $request->fields);
        $onlyCamaras = !in_array(true, $checkCamaras);

        if ($onlyCamaras) {
            if (in_array(array('name' => "camara"), $request->fields) || in_array(array('name' => "centro"), $request->fields)) {

                $camaras = Camara::where('id_cms_users', $request->userId)
                    ->with(['centro' => function ($q) {
                        $q->select('id', 'descripcion');
                    }])
                    ->get();
                foreach ($camaras as $key => $value) {
                    $array = $value->toArray();
                    $array['camara'] = $value->nombre;
                    $array['centro'] = $value->centro->descripcion;
                    $ar = $this->getOrderedArray($array, array_values($request->fields));
                    $v = array('values' => $ar);
                    array_push($rows, $v);
                }
            }
        }

        // return response()->json($estadisticas, 200);

        $schema = array();
        foreach ($request->fields as $key => $value) {
            $type = $this->getDataType($value['name']);
            array_push($schema, array('name' => $value['name'], 'dataType' => $type));
        };

        $object = collect([
            'schema' => $schema,
            'rows' => $rows,
            'cachedData' => false
        ]);
        // $data = array('schema' => $schema, 'rows' => $rows,'cachedData' => false);


        return response()->json($object, 200);
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
        foreach ($ord as $key => $v) {
            // dd($v['name']);
            // $i = $v['name'];
            if ($array[$v] == NULL || $array[$v] == "") {
                $orderedarray[$key] = NULL;
            } else {
                $orderedarray[$key] = $array[$v];
            }
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
        if (
            $field == 'camara' ||
            $field == 'fecha' ||
            $field == 'centro' ||
            $field == 'clase_falla' ||
            $field == 'clase_falla_voltaje'
        ) {
            return "STRING";
        } elseif (
            $field == 'sesiones_count' ||
            $field == 'fallas' ||
            $field == 'consumo' ||
            $field == 'hora' ||
            $field == 'amperaje' ||
            $field == 'voltaje' ||
            $field == 'fallasVoltaje' ||
            $field == 'horasUso' ||
            $field == 'tiempo_uso'
        ) {
            return 'NUMBER';
        }
        return '';
    }

    public function reportes($iduser, $fechadesde, $fechahasta, $idreporte)
    {
        $fecha_desde = chr(39) . $fechadesde . chr(39);
        $fecha_hasta = chr(39) . $fechahasta . chr(39);
        $centro = "NULL";
        $camara = "NULL";

        $me = \DB::table('cms_users')->where('id', $iduser)->first();
        $user = chr(39) . $me->id . chr(39);

        $privilege = chr(39) . $me->id_cms_privileges . chr(39);
        // return json_encode($iduser);
        switch ($idreporte) {

            case '1':
                //horas deconsumo totales
                $sql = "call check_consumo(" . $centro . ", " . $camara . ", " . $fecha_desde . ", " . $fecha_hasta . "," . $user . "," . $privilege . ");";
                /* echo($sql);
			    exit(); */
                break;
            case '2':
                //Fallas
                $sql = "call check_fallas(" . $centro . ", " . $camara . ", " . $fecha_desde . ", " . $fecha_hasta . "," . $user . "," . $privilege . ");";
                break;
            case '3':
                //Fallas
                $sql = "call check_fallas_voltaje(" . $centro . ", " . $camara . ", " . $fecha_desde . ", " . $fecha_hasta . "," . $user . "," . $privilege . ");";
                break;
            default:
                return response()->json([]);
                break;
        }

        $result = \DB::select($sql);
        return json_encode($result);
    }

    public function medirFallas()
    {
        //http://localhost/biobarica/service/post.php?mac=33:44:55:88:aa:ff&fecha=220917&hora=000200&voltaje=224&consumo=0.00
        $mac = request('mac');
        $fecha = request('fecha');
        $hora = request('hora');
        $consumo = request('consumo');
        $voltaje = request('voltaje');
        
        $camara = Camara::where('id_mac',$mac)->first();
        $minutosRegistrados = $camara->minutosRegistrados;
        // Con fecha, hora y camara podemos obtener la estadistica y actualizarla. 
        $estadistica = Estadistica::where('fecha',$fecha)
        ->where('hora',$hora)
        ->where('id_bio_camara',$camara->id)
        ->first();
        if($consumo > 1) {
            // Si la camara tiene menos de 10 horas registradas sumamos el CONSUMO al amperaje_promedio            
            if($minutosRegistrados == null || $minutosRegistrados < 600) 
            {
                
                $porc = ($camara->amperaje_promedio*($minutosRegistrados/5)+$consumo)/(($minutosRegistrados/5)+1);
                $camara->amperaje_promedio += $porc;
                
                $porcVoltaje = ($camara->voltaje*($minutosRegistrados/5)+$voltaje)/(($minutosRegistrados/5)+1);
                $camara->voltaje += $porcVoltaje;
                
                $camara->minutosRegistrados += 5;  
                $camara->save(); 
                echo "PORCENTAJE:" . $porc;
                    
            } else {
                $c = $consumo * $voltaje; 
                $promedio = $camara->amperaje_promedio * $camara->voltaje; 
                $falla = abs($c - $promedio)/$promedio;
                if($falla > 0.05) {
                    echo "warning";
                    $estadistica->tipoFalla = 'warning';

                } elseif($falla  > 0.1) {
                    echo "danger";
                    $estadistica->tipoFalla = 'danger';
                }
                $estadistica->save();
            }
        }

        // VOLTAJE
        // $fallaVoltaje = ((((220+110)/2) - $voltaje) / $voltaje) * 100;
        // echo "Falla voltaje" . $fallaVoltaje; 
        return response()->json(['msg' => 'Success']);
    }
    public function medirFallasPrueba()
    {
        //http://localhost/biobarica/service/post.php?mac=33:44:55:88:aa:ff&fecha=220917&hora=000200&voltaje=224&consumo=0.00
       echo request('mac');
       echo request('fecha');
       echo request('hora');
       echo request('consumo');
       echo request('voltaje');

       exit;
    }

    public function resetCamara($id)
    {
        Camara::find($id)->update(['minutosRegistrados' => null,'voltaje' => null, 'amperaje_promedio'=> null]);
        // return "true";
        return redirect('/admin/bio_camara');
    }
}
