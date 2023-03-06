<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMechanicRequest;
use App\Http\Requests\UpdateMechanicRequest;
use App\Models\Mechanic;
use Validator;

class MechanicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mechanics = Mechanic::orderBy('surname')->get();
        // $mechanics = $mechanics->sortByDesc('surname');
        return view('mechanic.index', ['mechanics' => $mechanics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mechanic.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMechanicRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMechanicRequest $request)
    {
       $validator = Validator::make($request->all(),
       [
           'mechanic_name' => ['required', 'min:3', 'max:64'],
           'mechanic_surname' => ['required', 'min:2', 'max:64'],
       ],
        [
        'mechanic_surname.min' => 'Surname must consists of at least 2 characters.'
        ]
       );
       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }

        $mechanic = new Mechanic;
        $mechanic->name = $request->mechanic_name;
        $mechanic->surname = $request->mechanic_surname;
        $mechanic->save();
        return redirect()->route('mechanic.index')->with('success_message', 'Naujas mechanikas sekmingai priimtas!');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function show(Mechanic $mechanic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function edit(Mechanic $mechanic)
    {
        return view('mechanic.edit', ['mechanic' => $mechanic]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMechanicRequest  $request
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMechanicRequest $request, Mechanic $mechanic)
    {
        $validator = Validator::make($request->all(),
        [
            'mechanic_name' => ['required', 'min:3', 'max:64'],
            'mechanic_surname' => ['required', 'min:2', 'max:64'],
        ],
        [
        'mechanic_surname.min' => 'Surname must consists at least of 2 characters.'
        ]
        );
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $mechanic->name = $request->mechanic_name;
        $mechanic->surname = $request->mechanic_surname;
        $mechanic->save();
        return redirect()->route('mechanic.index')->with('success_message', 'Mechaniko info sekmingai atnaujinta.');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mechanic $mechanic)
    {
        if ($mechanic->getTrucks->count()) {
           
            return redirect()->route('mechanic.index')->with('info_message', 'Trinti negalima, nes turi sunkvezimiu.');

        }
        $mechanic->delete();
        return redirect()->route('mechanic.index')->with('success_message', 'Mechanikas sekmingai ištrintas.');;
    }
}
