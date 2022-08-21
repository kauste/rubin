<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Salon;
use Illuminate\Http\Request;
use Validator;
use Image;

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
        $salons = Salon::all();
        return view('back.masters.index', ['masters' => $masters, 'salons'=> $salons]);
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
            'image.*' => 'required',
            'image.*' => [ 'image|mimes:jpg,gif,svg,jpeg,png', 'max:2048'],
            'salon_id'=> 'numeric',

        ],
        [
            'master_name.required' => 'Master name is required!',
            'master_name.min' => 'Master name should be at least 3 symbols length!',
            'master_name.max' => 'Master name should not exceed 50 symbols!',
            'master_surname.required' => 'Master surname is required!',
            'master_surname.min' => 'Master surname should be at least 3 symbols length!',
            'master_surname.max' => 'Master surname should not exceed 50 symbols!',
            'image.max' => 'Picture name should not exceed 100 symbols!',
        ]
        );

       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }
       if(!$request->image){
        return redirect()->back()->with('message', 'Picture is required!');
    }

    $image = $request->file('image');
    $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
    $ext  = $image-> getClientOriginalExtension();
    $file = $name . '-' . md5($name) . '.' . $ext;
    $img = Image::make($image);
    $img->save(public_path('img/'). $file);


        $master = New Master;
        $master->name = $request->master_name;
        $master->surname = $request->master_surname;
        $master->file_path = asset('img'). '/'. $file;
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
        $salons = Salon::all();
        return view('back.masters.edit', ['master'=> $master, 'salons'=> $salons]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterRequest  $request
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Master $master)
    {
        
        $validator = Validator::make($request->all(),
        [
            'master_name' => ['required', 'min:3', 'max:50'],
            'master_name' => ['required', 'min:3', 'max:50'],
            
            'image' => [ 'mimes:jpg,gif,svg,jpeg,png', 'max:2048'],
            'salon_id'=> 'numeric',

        ],
        [
            'master_name.required' => 'Master name is required!',
            'master_name.min' => 'Master name should be at least 3 symbols length!',
            'master_name.max' => 'Master name should not exceed 50 symbols!',
            'master_surname.required' => 'Master surname is required!',
            'master_surname.min' => 'Master surname should be at least 3 symbols length!',
            'master_surname.max' => 'Master surname should not exceed 50 symbols!',
            'image.max' => 'Picture name should not exceed 100 symbols!',
        ]
        );

       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }
       
    
        if($request->image){
            //istrinam nuotrauka is publicku
            $pic_asset = $master->file_path;
            $name = pathinfo($pic_asset, PATHINFO_FILENAME);
            $ext = pathinfo($pic_asset, PATHINFO_EXTENSION);
            $pic_path = public_path() . '/img/'. $name . '.' .$ext;
            
            if (file_exists($pic_path)) {
                unlink($pic_path);
            }
            //idedam nauja
            $image = $request->file('image');
            $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $ext  = $image-> getClientOriginalExtension();
            $file = $name . '-' . md5($name) . '.' . $ext;
            $img = Image::make($image);
            $img->save(public_path('img/'). $file);
            //linkas i duombaze
            $master->file_path = asset('img'). '/'. $file;
    }
    
   
        $master->name = $request->master_name;
        $master->surname = $request->master_surname;
        $master->salon_id = $request->salon_id;
        $master->save();

        return redirect()->route('masters-index')->with('message', 'Information about master is edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master  $master
     * @return \Illuminate\Http\Response
     */
    public function destroy(Master $master)
    {
        // if(!$master->procedures->count()){
            $pic_asset = $master->file_path;
            $name = pathinfo($pic_asset, PATHINFO_FILENAME);
            $ext = pathinfo($pic_asset, PATHINFO_EXTENSION);
            $pic_path = public_path() . '/img/'. $name . '.' .$ext;
            if (file_exists($pic_path)) {
                unlink($pic_path);
            }
            $master->delete();
            return redirect()->route('masters-index')->with('message','Master was deleted!');
        // }
        // return redirect()->back()->with('message','Master cannot be deleted, there is appointments booked for him!');
    }
}
