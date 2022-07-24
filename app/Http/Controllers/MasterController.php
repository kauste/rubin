<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Salon;
use Illuminate\Http\Request;
use Validator;

class MasterController extends Controller
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
        $masters = Master::all();
        return view('back.masters.index', ['masters' => $masters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $salons = Salon::all();
        return view('back.masters.create', ['salons'=> $salons]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMasterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'master_name' => ['required', 'min:3', 'max:50'],
            'master_name' => ['required', 'min:3', 'max:50'],
            'master_image.*' => 'required',
            'master_image.*' => [ 'image|mimes:jpg,gif,svg,jpeg,png', 'max:2048'],
            'salon_id'=> 'numeric',

        ],
        [
            'master_name.required' => 'Master name is required!',
            'master_name.min' => 'Master name should be at least 3 symbols length!',
            'master_name.max' => 'Master name should not exceed 50 symbols!',
            'master_surname.required' => 'Master surname is required!',
            'master_surname.min' => 'Master surname should be at least 3 symbols length!',
            'master_surname.max' => 'Master surname should not exceed 50 symbols!',
            'master_image.max' => 'Picture name should not exceed 100 symbols!',
        ]
        );

       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }

       $name = md5($request->id).'_'. $request->name . $request->surname;
       $destinationPath = public_path('img/');
        $images = $request->file('image')->move($destinationPath, $name);
    
   
        $master = New Master;
        $master->name = $request->master_name;
        $master->surname = $request->master_surname;
        $master->file_path = $name;
        $master->salon_id = $request->salon_id;
        $master->save();

        return redirect()->route('masters-index')->with('message', 'Master is added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function show(Master $master)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function edit(Master $master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterRequest  $request
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterRequest $request, Master $master)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function destroy(Master $master)
    {
        $master->delete();
        return redirect()->route('masters-index')->with('message','Master was deleted!');
    }
}
