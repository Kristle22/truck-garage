<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mechanic;

class MechanicJsController extends Controller
{
    const RESULTS_IN_PAGE = 5;

    public function index()
    {
        return view('mechanic_js.index');
    }

    public function list()
    {
        $mechanics = Mechanic::orderBy('created_at', 'desc')->paginate(self::RESULTS_IN_PAGE)->withQueryString();

        $html = view('mechanic_js.list', compact('mechanics'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    

    public function create()
    {
        $html = view('mechanic_js.create')->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function store(Request $request)
    {
        $mechanic = new Mechanic;
        $mechanic->name = $request->mechanic_name;
        $mechanic->surname = $request->mechanic_surname;
        $mechanic->save();
        
        $msgHtml = view('mechanic_js.messages', ['successMsg' => 'Valio, naujas mechanikas sėkmingai atvyko!'])->render(); 

        return response()->json([
            'hash' => 'list',
            'msg' => $msgHtml
        ]); 
    }

    public function edit(Mechanic $mechanic)
    {
        $html = view('mechanic_js.edit', compact('mechanic'))->render();

        return response()->json(compact('html'));
    }

    

    public function update(Request $request, Mechanic $mechanic)
    {
        $mechanic->name = $request->mechanic_name;
        $mechanic->surname = $request->mechanic_surname;
        $mechanic->save();

        return response()->json([
            'hash' => 'list'
        ]);
    }

    public function destroy(Mechanic $mechanic)
    {
        if($mechanic->getTrucks->count()){
            $msgHtml = view('mechanic_js.messages', ['infoMsg' => 'Nope! Šio mechaniko ištrinti negalima, nes jis turi užsakymų.'])->render();

            return response()->json([
                'msg' => $msgHtml
            ]);
        }
        $mechanic->delete();

        $msgHtml = view('mechanic_js.messages', ['successMsg' => 'Mechanikas sėkmingai ištrintas.'])->render();

        return response()->json([
            'hash' => 'list',
            'msg' => $msgHtml
        ]);
    }

}
