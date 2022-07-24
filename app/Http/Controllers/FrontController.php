<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Front;
use App\Models\Salon;
use App\Models\Master;
use App\Models\Procedure;
use DB;
class FrontController extends Controller
{
  public function salons(){
    $salons = Salon::all();
    return view('front.salons', ['salons' => $salons]);
  }
  public function procedures(){
    $procedures = Procedure::all();
    return view('front.procedures', ['procedures' => $procedures]);
  }
  public function masters(){
    $masters = Master::all();
    $salons = Salon::all();
    return view('front.masters', ['masters'=> $masters, 'salons'=>$salons]);
  }
  public function salonMasters(Salon $salon){
        $salonMasters = DB::table('masters')
            ->join('salons', 'masters.salon_id', '=', 'salons.id')
            ->select('salons.name as salon_name', 'masters.id as master_id', 'masters.name as master_name', 'masters.*', 'salons.*')
            ->where('masters.salon_id', $salon->id)
            ->get();
             return view('front.salonMasters', ['masters' => $salonMasters, 'salon'=> $salon]);
  }
  public function salonMasterProcedures (Request $request, Salon $salon){
        $procedures = Procedure::all();
        $master = DB::table('masters')
        ->join('salons', 'masters.salon_id', '=', 'salons.id')
        ->select('salons.name as salon_name', 'masters.id as master_id', 'salons.id as salon_id', 'masters.*', 'salons.*')
        ->where('masters.id', $request->id)
        ->first();

        return view('front.masterProcedures', ['procedures'=> $procedures, 'master'=> $master, 'salon'=> $salon]);
  }
}
