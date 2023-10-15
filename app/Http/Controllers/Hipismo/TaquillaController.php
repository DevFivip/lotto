<?php

namespace App\Http\Controllers\Hipismo;

use App\Http\Controllers\Controller;
use App\Models\Hipismo\FixtureRace;
use App\Models\Hipismo\Race;
use App\Models\Hipismo\FixtureRaceHorse;
use App\Models\Hipismo\HipismoBanca;
use App\Models\Hipismo\HipismoBancaResultado;
use App\Models\Hipismo\HipismoRemate;
use App\Models\Hipismo\HipismoRemateHead;
use App\Models\Hipismo\Hipodromo;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaquillaController extends Controller
{
    //

    public function create()
    {

        $date = date('Y-m-d H:i:s');
        $comming_races = FixtureRace::with('hipodromo', 'race')->where('start_time', '>=', $date)->get();
        // dd( $date,$comming_races);
        // $horses = FixtureRaceHorse::where('fixture_race_id', $race_id)->get();
        return view('hipismo.taquilla.create', compact('comming_races'));
    }


    public function print($banca_id)
    {

        $banca = HipismoBanca::with([
            'fixturerace' => function ($f) {
                $f->with('race', 'hipodromo');
            },
            'user'
        ])->find($banca_id);
        return view('hipismo.taquilla.print', compact('banca'));
    }


    public function banca()
    {
        if (auth()->user()->role_id != 3) {
            return redirect()->back()->withErrors(['message' => "los admins no pueden realizar apuestas"])->withInput();
        }
        $admin_id = auth()->user()->parent_id;
        $admin = User::find($admin_id);
        $monto_banca = $admin->hipodromo_banca_unidad;

        $hipodromos = Hipodromo::where('status', 1)->get();
        return view('hipismo.taquilla.banca', compact('hipodromos', 'monto_banca'));
    }
    public function bancasave(Request $req)
    {
        $data = $req->all();

        $combinacion = '';
        switch ($data['type']) {
            case 1:

                foreach ($data['horses'] as $key => $value) {
                    if (isset($value['odd_1']) && !!$value['odd_1']) {
                        $combinacion .= $value['horse_number'];
                    } else {
                    }
                }

                break;

            case 2:

                foreach ($data['horses'] as $key => $value) {
                    if (isset($value['odd_1']) && !!$value['odd_1']) {
                        $combinacion .= $value['horse_number'] . '-';
                    }
                }

                foreach ($data['horses'] as $key => $value) {
                    if (isset($value['odd_2']) && !!$value['odd_2']) {
                        $combinacion .= $value['horse_number'];
                    }
                }

                break;

            case 3:

                foreach ($data['horses'] as $key => $value) {
                    if (isset($value['odd_1']) && !!$value['odd_1']) {
                        $combinacion .= $value['horse_number'] . '-';
                    }
                }

                foreach ($data['horses'] as $key => $value) {
                    if (isset($value['odd_2']) && !!$value['odd_2']) {
                        $combinacion .= $value['horse_number'] . '-';
                    }
                }

                foreach ($data['horses'] as $key => $value) {
                    if (isset($value['odd_3']) && !!$value['odd_3']) {
                        $combinacion .= $value['horse_number'];
                    }
                }

                break;

            default:
                dd('Error found');
                # code...
                break;
        }

        $banc = HipismoBanca::create([
            "code" => uniqid(),
            "user_id" => auth()->user()->id,
            "admin_id" => auth()->user()->parent_id,
            "fixture_race_id" => $data['fixture_race_id'],
            "apuesta_type" => $data['type'],
            "combinacion" => $combinacion,
            "unidades" => $data['unidades'],
            "moneda_id" => 1,
            "total" => $data['unidades'] * $data['precio_unidad'],
        ]);

        return response()->json([
            'valid' => true,
            'message' => 'Guardado correctamente',
            'data' => $banc,
        ], 200);
    }

    public function getCommingRaces($hipodromo_id)
    {
        $date = date('Y-m-d');
        $comming_races = Race::with('hipodromo', 'fixtures')->where('hipodromo_id', $hipodromo_id)->where('race_day', '>=', $date . " 00:00:00")->get();

        return response()->json([
            "valid" => true,
            "data" => $comming_races,
            "message" => "success"
        ]);
    }

    public function rematesave(Request $req)
    {
        try {
            $uuid = uniqid();
            $data = $req->all();
            // dd($data);
            if (isset($data['remateHorses'][0]['code'])) {
                // dd($data);
                //? UPDATE
                $rem = HipismoRemateHead::find($data['remateHorses'][0]['hipismo_remate_head_id']);
                $rem->total = $data['total'];
                $rem->pagado = $data['premio'];
                $rem->save();
            } else {
                //? CREATE
                $rem = HipismoRemateHead::create([
                    'total' => $data['total'],
                    'pagado' => $data['premio'],
                    'user_id' => auth()->user()->id,
                    'admin_id' => auth()->user()->parent_id,
                    'fixture_race_id' => $data['remateHorses'][0]['fixture_race_id'],
                ]);
            }

            foreach ($data['remateHorses'] as $k => $horses) {
                HipismoRemate::createOrUpdate($horses, $uuid, $rem->id);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'valid' => false,
                'message' => $th->getMessage()
            ], 402);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Guardado correctamente'
        ], 200);
    }
    public function getRemateCodes($fixture_race_id)
    {
        try {
            $auth = Auth::user();
            $data = HipismoRemate::select('code')->where([
                'fixture_race_id' => $fixture_race_id,
                'user_id' => $auth->id,
                'admin_id' => $auth->parent_id,
            ])->groupBy('code')->get();
        } catch (\Throwable $th) {
            return response()->json(['valid' => true, 'message' => $th->getMessage()]);
        }

        return response()->json(['valid' => true, 'message' => 'success', "data" => $data]);
    }

    public function remateView($code)
    {
        try {
            $data = HipismoRemate::with('horse')->where([
                'code' => $code
            ])->get();
        } catch (\Throwable $th) {
            return response()->json(['valid' => true, 'message' => $th->getMessage()]);
        }

        return response()->json(['valid' => true, 'message' => 'success', "data" => $data]);
    }
    public function remateEdit($code)
    {
        try {
            $detalles = HipismoRemate::with('horse')->where([
                'code' => $code
            ])->get();
            $remate = HipismoRemateHead::where([
                'id' => $detalles[0]->hipismo_remate_head_id
            ])->first();
        } catch (\Throwable $th) {
            return response()->json(['valid' => false, 'message' => $th->getMessage()]);
        }

        return view('hipismo.taquilla.edit', compact('detalles', 'remate'));
        // return response()->json(['valid' => true, 'message' => 'success', "data" => $data]);
    }

    public function dashboard(Request $request)
    {

        $data = $request->all();

        //? if (count($request->all()) > 1) {
        //?     $dt = new DateTime($data['fecha_inicio'] . " 00:00:00", new DateTimeZone('America/Caracas'));
        //?     if (isset($data['fecha_fin'])) {
        //?         $dt2 = new DateTime($data['fecha_fin'] . " 00:00:00", new DateTimeZone('America/Caracas'));
        //?     }
        //? } else {
        //?     $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        //?     $dt = $dt->setTimezone(new DateTimeZone("America/Caracas"));
        //? }


        $date = date('Y-m-d');
        //? if (isset($data['fecha_inicio']) && isset($data['fecha_fin'])) {
        //? }

        if (auth()->user()->role_id == 3) {
            $user_id = auth()->user()->id;


            $hipodromos = Hipodromo::with(["races" => function ($race) use ($date) {
                $race->where('race_day', '>=', $date . " 00:00:00")->with(['fixtures' => function ($fixture) {
                    return $fixture->with(['remates' => function ($rem) {
                        return $rem->where('user_id', auth()->user()->id)->with(['remates' => function ($odd) {
                            return $odd->with(['horse'])->get();
                        }])->get();
                    }])->get();
                }])->get();
            }])->get();

            $remates = HipismoRemate::with(['horse'])->where('user_id', auth()->user()->id)->where('created_at',  '>=', $date . " 00:00:00")->get();
            $totals = HipismoRemateHead::where('user_id', auth()->user()->id)->where('created_at',  '>=', $date . " 00:00:00")->get();


            $_remates = $remates->filter(function ($v, $k) {
                if ($v->horse->status == 1) {
                    return $v;
                }
            });


            $total = $_remates->sum('monto');
            $pagado = $totals->sum('pagado');


            $bancas_totales = DB::select("SELECT SUM(if(hipismo_banca_resultados.win > 1,hipismo_bancas.unidades * hipismo_banca_resultados.win,0)) AS premiototal, SUM(total) AS total FROM hipismo_bancas LEFT JOIN hipismo_banca_resultados ON hipismo_bancas.combinacion = hipismo_banca_resultados.combinacion AND hipismo_bancas.admin_id = hipismo_banca_resultados.admin_id WHERE hipismo_bancas.user_id = :user_id", ['user_id' => $user_id]);

            $bancas = HipismoBanca::select(
                'hipismo_bancas.id AS id',
                'hipismo_bancas.total',
                'hipismo_bancas.admin_id AS tabla1_admin_id',
                'hipismo_bancas.user_id',
                'hipismo_bancas.status',
                'hipismo_bancas.created_at AS tabla1_created_at',
                'hipismo_bancas.updated_at AS tabla1_updated_at',
                'hipismo_bancas.code',
                'hipismo_bancas.fixture_race_id AS fixture_race_id',
                'hipismo_bancas.moneda_id',
                'hipismo_bancas.apuesta_type',
                'hipismo_bancas.combinacion',
                'hipismo_bancas.unidades',
                'hipismo_banca_resultados.id AS tabla2_id',
                'hipismo_banca_resultados.win',
                'hipismo_banca_resultados.created_at AS tabla2_created_at',
                'hipismo_banca_resultados.updated_at AS tabla2_updated_at'
            )
                ->leftJoin('hipismo_banca_resultados', function ($join) {
                    $join->on('hipismo_bancas.combinacion', '=', 'hipismo_banca_resultados.combinacion')
                        ->on('hipismo_bancas.admin_id', '=', 'hipismo_banca_resultados.admin_id');
                })
                ->where('hipismo_bancas.user_id', '=', auth()->user()->id)
                ->with(['fixtureRace' => function ($f) {
                    // dd($f);
                    $f->with('hipodromo');
                }])
                ->orderBy('id', 'desc')
                ->paginate(50);
        }

        if (auth()->user()->role_id == 2) {

            $hipodromos = Hipodromo::with(["races" => function ($race) use ($date) {
                $race->where('race_day', '>=', $date . " 00:00:00")->with(['fixtures' => function ($fixture) {
                    return $fixture->with(['remates' => function ($rem) {
                        return $rem->where('admin_id', auth()->user()->id)->with(['remates' => function ($odd) {
                            return $odd->with(['horse'])->get();
                        }])->get();
                    }])->get();
                }])->get();
            }])->get();

            $remates = HipismoRemate::with(['horse'])->where('admin_id', auth()->user()->id)->where('created_at',  '>=', $date . " 00:00:00")->get();
            $totals = HipismoRemateHead::where('admin_id', auth()->user()->id)->where('created_at',  '>=', $date . " 00:00:00")->get();


            $_remates = $remates->filter(function ($v, $k) {
                if ($v->horse->status == 1) {
                    return $v;
                }
            });


            $total = $_remates->sum('monto');
            $pagado = $totals->sum('pagado');



            $admin_id = auth()->user()->id;
            $bancas_totales = DB::select("SELECT SUM(if(hipismo_banca_resultados.win > 1,hipismo_bancas.unidades * hipismo_banca_resultados.win,0)) AS premiototal, SUM(total) AS total FROM hipismo_bancas LEFT JOIN hipismo_banca_resultados ON hipismo_bancas.combinacion = hipismo_banca_resultados.combinacion AND hipismo_bancas.admin_id = hipismo_banca_resultados.admin_id WHERE hipismo_bancas.admin_id = :admin_id", ['admin_id' => $admin_id]);

            $bancas = HipismoBanca::select(
                'hipismo_bancas.id AS id',
                'hipismo_bancas.total',
                'hipismo_bancas.admin_id AS tabla1_admin_id',
                'hipismo_bancas.user_id',
                'hipismo_bancas.status',
                'hipismo_bancas.created_at AS tabla1_created_at',
                'hipismo_bancas.updated_at AS tabla1_updated_at',
                'hipismo_bancas.code',
                'hipismo_bancas.fixture_race_id AS fixture_race_id',
                'hipismo_bancas.moneda_id',
                'hipismo_bancas.apuesta_type',
                'hipismo_bancas.combinacion',
                'hipismo_bancas.unidades',
                'hipismo_banca_resultados.id AS tabla2_id',
                'hipismo_banca_resultados.win',
                'hipismo_banca_resultados.created_at AS tabla2_created_at',
                'hipismo_banca_resultados.updated_at AS tabla2_updated_at'
            )
                ->leftJoin('hipismo_banca_resultados', function ($join) {
                    $join->on('hipismo_bancas.combinacion', '=', 'hipismo_banca_resultados.combinacion')
                        ->on('hipismo_bancas.admin_id', '=', 'hipismo_banca_resultados.admin_id');
                })
                ->where('hipismo_bancas.admin_id', '=', auth()->user()->id)
                ->with(['fixtureRace' => function ($f) {
                    // dd($f);
                    $f->with('hipodromo');
                }])
                ->orderBy('id', 'desc')
                ->paginate(50);
        }

        if (auth()->user()->role_id == 1) {

            $hipodromos = Hipodromo::with(["races" => function ($race) use ($date) {
                $race->where('race_day', '>=', $date . " 00:00:00")->with(['fixtures' => function ($fixture) {
                    return $fixture->with(['remates' => function ($rem) {
                        return $rem->with(['remates' => function ($odd) {
                            return $odd->with(['horse'])->get();
                        }])->get();
                    }])->get();
                }])->get();
            }])->get();

            $remates = HipismoRemate::with(['horse'])->where('created_at',  '>=', $date . " 00:00:00")->get();
            $totals = HipismoRemateHead::where('user_id', auth()->user()->id)->where('created_at',  '>=', $date . " 00:00:00")->get();


            $_remates = $remates->filter(function ($v, $k) {
                if ($v->horse->status == 1) {
                    return $v;
                }
            });


            $total = $_remates->sum('monto');
            $pagado = $totals->sum('pagado');


            $bancas_totales = DB::select(DB::raw("SELECT SUM(if(hipismo_banca_resultados.win > 1,hipismo_bancas.unidades * hipismo_banca_resultados.win,0)) AS premiototal, SUM(total) AS total
            FROM hipismo_bancas
            LEFT JOIN hipismo_banca_resultados
            ON hipismo_bancas.combinacion = hipismo_banca_resultados.combinacion
                AND hipismo_bancas.admin_id = hipismo_banca_resultados.admin_id"));

            $bancas = HipismoBanca::select(
                'hipismo_bancas.id AS id',
                'hipismo_bancas.total',
                'hipismo_bancas.admin_id AS tabla1_admin_id',
                'hipismo_bancas.user_id',
                'hipismo_bancas.status',
                'hipismo_bancas.created_at AS tabla1_created_at',
                'hipismo_bancas.updated_at AS tabla1_updated_at',
                'hipismo_bancas.code',
                'hipismo_bancas.fixture_race_id AS fixture_race_id',
                'hipismo_bancas.moneda_id',
                'hipismo_bancas.apuesta_type',
                'hipismo_bancas.combinacion',
                'hipismo_bancas.unidades',
                'hipismo_banca_resultados.id AS tabla2_id',
                'hipismo_banca_resultados.win',
                'hipismo_banca_resultados.created_at AS tabla2_created_at',
                'hipismo_banca_resultados.updated_at AS tabla2_updated_at'
            )
                ->leftJoin('hipismo_banca_resultados', function ($join) {
                    $join->on('hipismo_bancas.combinacion', '=', 'hipismo_banca_resultados.combinacion')
                        ->on('hipismo_bancas.admin_id', '=', 'hipismo_banca_resultados.admin_id');
                })
                ->with(['fixtureRace' => function ($f) {
                    // dd($f);
                    $f->with('hipodromo');
                }])
                ->orderBy('id', 'desc')
                ->paginate(50);

            // dd($bancas);
        }

        return view('hipismo.dashboard', compact('remates', 'total', 'pagado', 'hipodromos', 'bancas', 'bancas_totales'));
    }
    public function bancadelete($banca_id)
    {
        try {
            $banca = HipismoBanca::find($banca_id);
            $banca->delete();
            return response()->json(['valid' => true, 'message' => 'Eliminado Correctamente']);
        } catch (\Throwable $th) {
            return response()->json(['valid' => false, 'message' => $th->getMessage()]);
            //throw $th;
        }
    }
}
