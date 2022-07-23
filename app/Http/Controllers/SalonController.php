<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;
use Validator;

class SalonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salons = Salon::all();
        return view('back.salons.index', ['salons'=> $salons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.salons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSalonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'salon_title' => ['required', 'min:6', 'max:30'],
            'street'=> ['required', 'min:2', 'max:30'],
            'street_num'=> ['required', 'min:1', 'max:6'],
            'flat_num'=> ['max:6'],
            'tel_num'=> ['required', 'digits:8', 'integer'],
            
        ],
        [
            'salon_title.required' => 'Salon title is required!',
            'salon_title.min' => 'Salon title should be at least 6 symbols length!',
            'salon_title.max' => 'Salon title should not exceed 30 symbols!',
            // 'salon_title.unique'=>'Salon title mus be unique!', // unikalus??????
            'street.required' => 'Street title is required!',
            'street.min' => 'Street title should be at least 2 symbols length!',
            'street.max' => 'Street title should not exceed 30 symbols!',
            'street_num.required' => 'Street number is required!',
            'street_num.min' => 'Street number should be at least 1 symbols length!',
            'street_num.max' => 'Street number should not exceed 6 symbols!',
            'flat_num.max'=>'Flat number should not exceed 6 symbols!',
            'tel_num.required'=> 'Telephone number ir required!',
            'tel_num.digits'=> 'Telephone number must be 8 digits length!',
            // 'tel_num.unique'=>'Salon title mus be unique!',
            'tel_num.integer'=> 'Telephone number should contain only numbers'
            
        ]
        );

       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }

        $salon = New Salon;
        $salon->name = $request->salon_title;
        $salon->street = $request->street;
        $salon->street_number= $request->street_num;
        $salon->city = $request->city;
        $salon->flat_number = $request->flat_num;
        $salon->telephone_num = $request->tel_num;
        $salon->save();

        return redirect()->route('salons-index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function show(Salon $salon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function edit(Salon $salon)
    {

        return view('back.salons.edit', ['salon'=> $salon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSalonRequest  $request
     * @param  \App\Models\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salon $salon)
    {
 
        $validator = Validator::make($request->all(),
        [
            'salon_title' => ['required', 'min:6', 'max:30'],
            'street'=> ['required', 'min:2', 'max:30'],
            'street_num'=> ['required', 'min:1', 'max:6'],
            'flat_num'=> ['max:6'],
            'tel_num'=> ['required', 'digits:8', 'integer'],
            
        ],
        [
            'salon_title.required' => 'Salon title is required!',
            'salon_title.min' => 'Salon title should be at least 6 symbols length!',
            'salon_title.max' => 'Salon title should not exceed 30 symbols!',
            // 'salon_title.unique'=>'Salon title mus be unique!', // unikalus??????
            'street.required' => 'Street title is required!',
            'street.min' => 'Street title should be at least 2 symbols length!',
            'street.max' => 'Street title should not exceed 30 symbols!',
            'street_num.required' => 'Street number is required!',
            'street_num.min' => 'Street number should be at least 1 symbols length!',
            'street_num.max' => 'Street number should not exceed 6 symbols!',
            'flat_num.max'=>'Flat number should not exceed 6 symbols!',
            'tel_num.required'=> 'Telephone number ir required!',
            'tel_num.digits'=> 'Telephone number must be 8 digits length!',
            // 'tel_num.unique'=>'Salon title mus be unique!',
            'tel_num.integer'=> 'Telephone number should contain only numbers',
            
        ]
        );

       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }

        $salon->name = $request->salon_title;
        $salon->street = $request->street;
        $salon->street_number= $request->street_num;
        $salon->city = $request->city;
        $salon->flat_number = $request->flat_num;
        $salon->telephone_num = $request->tel_num;
        $salon->save();

        return redirect()->route('salons-index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salon  $salon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Salon $salon)
    {
        $salon->delete();
        
        return redirect()->route('salons-index');
    }
}
