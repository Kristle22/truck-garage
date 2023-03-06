<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Models\Truck;
use App\Models\Mechanic;
use Validator;
use Carbon\Carbon;

        // _dd(now()->format('Y'));
        // _dd(Date('Y'));

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trucks = Truck::all();
        return view('truck.index', ['trucks' => $trucks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mechanics = Mechanic::orderBy('surname')->get();;
        return view('truck.create', ['mechanics' => $mechanics]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTruckRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTruckRequest $request)
    {
        // maker: varchar(255)
        // plate: varchar(20)
        // make_year: tinyint(4) unsigned
        // mechanic_notices: text
        // mechanic_id : int(11)
        $minYear = Carbon::now()->subYears(40)->format('Y');
        $currYear = Carbon::now()->format('Y');

        $validator = Validator::make($request->all(),
       [
           'truck_maker' => ['required', 'min:3', 'max:255'],
           'truck_plate' => ['required', 'min:3', 'max:20'],
           'truck_make_year' => ['required', 'numeric', 'digits:4', 'between:'.$minYear.','.$currYear, 'max:'.$currYear],
           'truck_mechanic_notices' => ['required'],
           'mechanic_id' => ['required', 'integer', 'min:1'],
       ],
        [
        'truck_make_year.between' => 'Truck must be max 40 years old!'
        ]
       );
       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }

        $truck = new Truck;
        $truck->maker = $request->truck_maker;
        $truck->plate = $request->truck_plate;
        $truck->make_year = $request->truck_make_year;
        $truck->mechanic_notices = $request->truck_mechanic_notices;
        $truck->mechanic_id = $request->mechanic_id;
        $truck->save();
        return redirect()->route('truck.index')->with('success_message', 'Naujas sunkvezimas sekmingai pridetas!');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function show(Truck $truck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function edit(Truck $truck)
    {
        $mechanics = Mechanic::orderBy('surname')->get();;
        return view('truck.edit', compact('mechanics'), compact('truck'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTruckRequest  $request
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTruckRequest $request, Truck $truck)
    {
        $minYear = Carbon::now()->subYears(40)->format('Y');
        $currYear = Carbon::now()->format('Y');

        $validator = Validator::make($request->all(),
        [
            'truck_maker' => ['required', 'min:3', 'max:255'],
            'truck_plate' => ['required', 'min:3', 'max:20'],
            'truck_make_year' => ['required', 'numeric', 'digits:4', 'between:'.$minYear.','.$currYear, 'max:'.$currYear],
            'truck_mechanic_notices' => ['required'],
            'mechanic_id' => ['required', 'integer', 'min:1'],
        ],
         [
         'truck_make_year.between' => 'Truck must be max 40 years old!'
         ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $truck->maker = $request->truck_maker;
        $truck->plate = $request->truck_plate;
        $truck->make_year = $request->truck_make_year;
        $truck->mechanic_notices = $request->truck_mechanic_notices;
        $truck->mechanic_id = $request->mechanic_id;
        $truck->save();
        return redirect()->route('truck.index')->with('success_message', 'Sunkvezimio info sekmingai atnaujinta.');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truck $truck)
    {
        $truck->delete();
        return redirect()->route('truck.index')->with('success_message', 'Sunkvezimis sekmingai ištrintas.');;
    }
}
