<?php

namespace App\Http\Controllers;

use App\Config;
use App\Models\Animal;
use App\Models\Schedule;
use App\Models\UserAnimalitoSchedule;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class UserAnimalitoScheduleController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('timezone');
        $this->resource = 'schedules-admin';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::where('sorteo_type_id', '!=', 4)->whereNotIn('id', Config::BANEDSCHEDULES)->get();
        $resource = $this->resource;

        $dt = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone('America/Caracas'));
        $fecha =  $dt->format("Y-m-d");

        return view('user_schedule_limits.index', compact('schedules', 'resource', 'fecha'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::find($id);

        $animals = Animal::where('sorteo_type_id', $schedule->sorteo_type_id)->orderBy('number', "ASC")->get();
        $limits = UserAnimalitoSchedule::where('schedule_id', $schedule->id)->where('user_id', auth()->user()->id)->get();

        $animals = $animals->map(function ($v, $k)  use ($limits) {

            foreach ($limits as $key => $value) {
                if ($value->animal_id == $v->id) {
                    //  dd($v, $value);
                    $v->limit = $value->limit;
                }
            }

            return $v;
        });

        // dd($a);

        return view('user_schedule_limits.limits', compact('animals', 'schedule'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            //code...

            $data = $request->all();
            $schedule_id = $data['schedule_id'];
            $animals = $data['animal'];

            // // dd($data);

            foreach ($animals as $animal_id => $limit) {

                // validar si ya existe el registro 
                $fund  = UserAnimalitoSchedule::where('schedule_id', $schedule_id)->where('animal_id', $animal_id)->where('user_id', auth()->user()->id)->first();
                // dd($fund);

                if ($fund == null) {
                    if ($limit !== null) {
                        UserAnimalitoSchedule::create(['user_id' => auth()->user()->id, 'schedule_id' => $schedule_id, 'animal_id' => $animal_id, 'limit' => $limit]);
                    }
                } else {
                    $fund->limit = $limit;
                    $fund->update();
                }
            }

            return redirect()->back()->with('success', 'Nuevos Limites Guardados');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
