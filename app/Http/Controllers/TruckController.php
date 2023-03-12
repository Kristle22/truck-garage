<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Models\Truck;
use App\Models\Mechanic;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

        // _dd(now()->format('Y'));
        // _dd(Date('Y'));

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->sort) {
            if ('maker' == $request->sort && 'asc' == $request->sort_dir) {
                $trucks = Truck::orderBy('maker')->get();
            }
            else if ('maker' == $request->sort && 'desc' == $request->sort_dir) {
                $trucks = Truck::orderBy('maker', 'desc')->get();
            }
            else if ('plate' == $request->sort && 'asc' == $request->sort_dir) {
                $trucks = Truck::orderBy('plate')->get();
            }
            else if ('plate' == $request->sort && 'desc' == $request->sort_dir) {
                $trucks = Truck::orderBy('plate', 'desc')->get();
            }
            else if ('make_year' == $request->sort && 'asc' == $request->sort_dir) {
                $trucks = Truck::orderBy('make_year')->get();
            }
            else if ('make_year' == $request->sort && 'desc' == $request->sort_dir) {
                $trucks = Truck::orderBy('make_year', 'desc')->get();
            }
            else {
                $trucks = Truck::all();  
            }
        }
        else if ($request->filter && 'mechanic' == $request->filter) {
            $trucks = Truck::where('mechanic_id', $request->mechanic_id)->get();
        } 
        else if ($request->search && 'all' == $request->search) {

            $words = explode(' ', $request->s);
            if (count($words) == 1) {
            $trucks = Truck::where('maker', 'like', '%'.$request->s.'%')
            ->orWhere('plate', 'like', '%'.$request->s.'%')
            ->orWhere('make_year', 'like', '%'.$request->s.'%')->get();
            } elseif (count($words) == 2) {
                $trucks = Truck::where(function($query) use ($words) {
                    $query->where('maker', 'like', '%'.$words[0].'%')
                    ->orWhere('plate', 'like', '%'.$words[0].'%')
                    ->orWhere('make_year', 'like', '%'.$words[0].'%');
                    })
                ->where(function($query) use ($words) {
                $query->where('maker', 'like', '%'.$words[1].'%')
                ->orWhere('plate', 'like', '%'.$words[1].'%')
                ->orWhere('make_year', 'like', '%'.$words[1].'%');
                })->get();
            } else {
                $trucks = Truck::where(function($query) use ($words) {
                    $query->where('maker', 'like', '%'.$words[0].'%')
                    ->orWhere('plate', 'like', '%'.$words[0].'%')
                    ->orWhere('make_year', 'like', '%'.$words[0].'%');
                    })
                ->where(function($query) use ($words) {
                $query->where('maker', 'like', '%'.$words[1].'%')
                ->orWhere('plate', 'like', '%'.$words[1].'%')
                ->orWhere('make_year', 'like', '%'.$words[1].'%');
                })
                ->where(function($query) use ($words) {
                $query->where('maker', 'like', '%'.$words[2].'%')
                ->orWhere('plate', 'like', '%'.$words[2].'%')
                ->orWhere('make_year', 'like', '%'.$words[2].'%');
                })->get();
            } 
        }
        else {
            $trucks = Truck::all(); 
        }

        $mechanics = Mechanic::all();

        return view('truck.index', [
            'trucks' => $trucks,
            'sortDirection' => $request->sort_dir ?? 'asc',
            'mechanics' => $mechanics,
            'mechanicId' => $request->mechanic_id ?? '0',
            's' => $request->s ?? ''
        ]);

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
