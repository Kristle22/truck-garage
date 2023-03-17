<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Models\Truck;
use App\Models\Mechanic;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

        // _dd(now()->format('Y'));
        // _dd(Date('Y'));

class TruckController extends Controller
{
    const PAGE_COUNT = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->sort) {
            if ('maker' == $request->sort && 'asc' == $request->sort_dir) {
                $trucks = Truck::orderBy('maker')->paginate(self::PAGE_COUNT)->withQueryString()
;
            }
            else if ('maker' == $request->sort && 'desc' == $request->sort_dir) {
                $trucks = Truck::orderBy('maker', 'desc')->paginate(self::PAGE_COUNT)->withQueryString()
;
            }
            else if ('plate' == $request->sort && 'asc' == $request->sort_dir) {
                $trucks = Truck::orderBy('plate')->paginate(self::PAGE_COUNT)->withQueryString()
;
            }
            else if ('plate' == $request->sort && 'desc' == $request->sort_dir) {
                $trucks = Truck::orderBy('plate', 'desc')->paginate(self::PAGE_COUNT)->withQueryString()
;
            }
            else if ('make_year' == $request->sort && 'asc' == $request->sort_dir) {
                $trucks = Truck::orderBy('make_year')->paginate(self::PAGE_COUNT)->withQueryString()
;
            }
            else if ('make_year' == $request->sort && 'desc' == $request->sort_dir) {
                $trucks = Truck::orderBy('make_year', 'desc')->paginate(self::PAGE_COUNT)->withQueryString()
;
            }
            else {
                $trucks = Truck::paginate(self::PAGE_COUNT)->withQueryString()
;  
            }
        }
        else if ($request->filter && 'mechanic' == $request->filter) {
            $trucks = Truck::where('mechanic_id', $request->mechanic_id)->paginate(self::PAGE_COUNT)->withQueryString()
;
        } 
        else if ($request->search && 'all' == $request->search) {

            $words = explode(' ', $request->s);
            if (count($words) == 1) {
            $trucks = Truck::where('maker', 'like', '%'.$request->s.'%')
            ->orWhere('plate', 'like', '%'.$request->s.'%')
            ->orWhere('make_year', 'like', '%'.$request->s.'%')->paginate(self::PAGE_COUNT)->withQueryString()
;
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
                })->paginate(self::PAGE_COUNT)->withQueryString()
;
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
                })->paginate(self::PAGE_COUNT)->withQueryString()
;
            } 
        }
        else {
            $trucks = Truck::orderBy('created_at', 'desc')->paginate(self::PAGE_COUNT)->withQueryString()
; 
        }

        $mechanics = Mechanic::paginate(self::PAGE_COUNT)->withQueryString()
;

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
        $mechanics = Mechanic::orderBy('surname')->paginate(self::PAGE_COUNT)->withQueryString()
;;
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

        $file = $request->file('truck_photo');
        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $name = rand(1000000, 9999999).'_'.rand(1000000, 9999999);
            $name .= '.'.$ext;

            $destinationPath = public_path().'/truck-images/';
            $file->move($destinationPath, $name);
            $truck->photo = asset('/truck-images/'.$name);
            
            // image intervention (composer require intervention/image)
            // $img = Image::make($destinationPath.$name);
            // $img->gamma(5.6)->flip('v');
            // $img->save($destinationPath.$name);
        }

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
        return view('truck.show', compact('truck'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function edit(Truck $truck)
    {
        $mechanics = Mechanic::orderBy('surname')->paginate(self::PAGE_COUNT)->withQueryString()
;;
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

        $file = $request->file('truck_photo');

        if ($file) {
            $ext = $file->getClientOriginalExtension();
            $name = rand(1000000, 9999999).'_'.rand(1000000, 9999999);
            $name .= '.'.$ext;
            $destinationPath = public_path().'/truck-images/';

            $file->move($destinationPath, $name);

            $oldPhoto = $truck->photo ?? '@@@';
            $truck->photo = asset('/truck-images/'.$name);

            // Trinam sena, jeigu ji yra
            $oldName = explode('/', $oldPhoto);
            $oldName = array_pop($oldName);
            if (file_exists($destinationPath.$oldName)) {
                unlink($destinationPath.$oldName);
            }
        }
        if ($request->truck_photo_deleted) {
            $destinationPath = public_path().'/truck-images/';
            $oldPhoto = $truck->photo ?? '@@@';
            $truck->photo = null;
            $oldName = explode('/', $oldPhoto);
            $oldName = array_pop($oldName);
            if (file_exists($destinationPath.$oldName)) {
                unlink($destinationPath.$oldName);
            }
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
        $destinationPath = public_path().'/truck-images/';
        $oldPhoto = $truck->photo ?? '@@@';

        // Trinam sena, jeigu ji yra
        $oldName = explode('/', $oldPhoto);
        $oldName = array_pop($oldName);
        if (file_exists($destinationPath.$oldName)) {
            unlink($destinationPath.$oldName);
         }

        $truck->delete();
        return redirect()->route('truck.index')->with('success_message', 'Sunkvezimis sekmingai ištrintas.');;
    }

    public function pdf(Truck $truck) {
        $pdf = Pdf::loadView('truck.pdf', compact('truck'));
        return $pdf->download(ucfirst($truck->maker).'-'.$truck->make_year.'.pdf');
    }

}
