<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Models\Animal;
use App\Models\AnimalitoScheduleLimit;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('timezone');
        $this->resource = 'schedules';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::where('sorteo_type_id', '!=', 4)->whereNotIn('id', [25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58])->get();
        $resource = $this->resource;
        return view('schedules.index', compact('resource', 'schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $resource = $this->resource;
        return view('schedules.create', compact('resource'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        $data = $request->all();
        $schedule = Schedule::create($data);
        return redirect('/' . $this->resource);
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
        $resource = $this->resource;

        return view('schedules.edit', compact('resource', $schedule));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, $id)
    {

        $data = $request->all();
        $schedule = Schedule::find($id);
        $schedule->update($data);

        return redirect('/' . $this->resource);

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->role_id == 1) {
            $schedule = Schedule::find($id);
            $schedule->update(['status' => !!!$schedule->status]);
            return true;
        } else {
            return false;
        }
    }


    public function limits($schedule_id)
    {
        $schedule = Schedule::find($schedule_id);

        $animals = Animal::where('sorteo_type_id', $schedule->sorteo_type_id)->orderBy('number', "ASC")->get();
        $limits = AnimalitoScheduleLimit::where('schedule_id', $schedule->id)->get();

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

        return view('schedules.limits', compact('animals', 'schedule'));
    }

    public function limits_save(Request $request)
    {

        try {
            //code...

            $data = $request->all();
            $schedule_id = $data['schedule_id'];
            $animals = $data['animal'];

            // // dd($data);

            foreach ($animals as $animal_id => $limit) {

                // validar si ya existe el registro 
                $fund  = AnimalitoScheduleLimit::where('schedule_id', $schedule_id)->where('animal_id', $animal_id)->first();
                // dd($fund);

                if ($fund == null) {
                    if ($limit !== null) {
                        AnimalitoScheduleLimit::create(['schedule_id' => $schedule_id, 'animal_id' => $animal_id, 'limit' => $limit]);
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
}
