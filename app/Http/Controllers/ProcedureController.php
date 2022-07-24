<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use Illuminate\Http\Request;
use Validator;

class ProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $procedures = Procedure::all();
        return view('back.procedures.index', ['procedures'=> $procedures]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.procedures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProcedureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $input = $request->all();
        if((int) $input['hours']){
            $input['minutes'] = $input['minutes'] + 60 * $input['hours'];
        }

        if((int) $input['cents']){
            $input['euros'] = $input['euros'] + $input['cents'] / 100;
        }
        
        $validator = Validator::make($input,
        [
            'procedure_title' => ['required', 'min:6', 'max:50'],
            'hours'=> 'numeric',
            'minutes'=>['required', 'min:30', 'max:720', 'numeric'],
            'euros'=> ['required', 'numeric', 'min:10'],
            'cents' ?? 0 => 'numeric',
        ],
        [
            'procedure_title.required' => 'Procedure title is required!',
            'procedure_title.min' => 'Procedure title should be at least 6 symbols length!',
            'procedure_title.max' => 'Procedure title should not exceed 50 symbols!',
            // 'salon_title.unique'=>'Salon title mus be unique!', // unikalus??????
            'minutes.required' => 'Time is required!',
            'minutes.min' => 'Procedure should last at least 30 minutes!',
            'minutes.max' => 'Procedure shoud not exceed 12 hours!',
            'minutes.numeric' => 'Time shoud be expressed in digits!',
            'euros.required' => 'Price is required!',
            'euros.numeric' => 'Price shoud be expressed in digits!',     
            'euros.min' => 'Price should last at least 10 euros!',       
        ]
        );

       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }

        $procedure = New Procedure;
        $procedure->ruby_service = $input['procedure_title'];
        $procedure->minutes = $input['minutes'];
        $procedure->price = $input['euros'];
        $procedure->save();

        return redirect()->route('procedures-index')->with('message', 'Procedure is added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function show(Procedure $procedure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function edit(Procedure $procedure)
    {
        $procedure->hours = floor($procedure->minutes / 60);
        $procedure->minutes = $procedure->minutes - ($procedure->hours * 60);
        $procedure->euros = floor($procedure->price);
        $procedure->cents = ($procedure->price - $procedure->euros) * 100;

       return view('back.procedures.edit', ['procedure'=> $procedure]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProcedureRequest  $request
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Procedure $procedure)
    {
        $input = $request->all();
        if((int) $input['hours']){
            $input['minutes'] = $input['minutes'] + 60 * $input['hours'];
        }

        if((int) $input['cents']){
            $input['euros'] = $input['euros'] + $input['cents'] / 100;
        }
        
        $validator = Validator::make($input,
        [
            'procedure_title' => ['required', 'min:6', 'max:50'],
            'hours'=> 'numeric',
            'minutes'=>['required', 'min:30', 'max:720', 'numeric'],
            'euros'=> ['required', 'numeric', 'min:10'],
            'cents' ?? 0 => 'numeric',
        ],
        [
            'procedure_title.required' => 'Procedure title is required!',
            'procedure_title.min' => 'Procedure title should be at least 6 symbols length!',
            'procedure_title.max' => 'Procedure title should not exceed 50 symbols!',
            // 'salon_title.unique'=>'Salon title mus be unique!', // unikalus??????
            'minutes.required' => 'Time is required!',
            'minutes.min' => 'Procedure should last at least 30 minutes!',
            'minutes.max' => 'Procedure shoud not exceed 12 hours!',
            'minutes.numeric' => 'Time shoud be expressed in digits!',
            'euros.required' => 'Price is required!',
            'euros.numeric' => 'Price shoud be expressed in digits!',     
            'euros.min' => 'Price should last at least 10 euros!',       
        ]
        );

       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }

        $procedure->ruby_service = $input['procedure_title'];
        $procedure->minutes = $input['minutes'];
        $procedure->price = $input['euros'];
        $procedure->save();

        return redirect()->route('procedures-index')->with('message', 'Information about procedure is edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Procedure $procedure)
    {
        $procedure->delete();
        return redirect()->route('procedures-index')->with('message', 'Salon is deleted!');
    }
}
