<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Front;
use App\Models\Salon;
use App\Models\Master;
use App\Models\Procedure;
use App\Models\Rating;
use DB;
use Carbon\Carbon;
class FrontController extends Controller
{
  public function salons(){
    $salons = Salon::orderBy('name', 'asc')->get();
    return view('front.salons', ['salons' => $salons]);
  }
  public function procedures(){
    $procedures = Procedure::all();
    return view('front.procedures', ['procedures' => $procedures]);
  }
  public function masters(Request $request){

    $salons = Salon::all();
    if($request->filter_masters){
        $masters = DB::table('masters')
              ->join('salons', 'masters.salon_id', '=', 'salons.id')
              ->select('masters.*', 'salons.name as salon_name', 'masters.name as master_name','salons.id as salon_id')
              ->where('salons.id', $request->filter_masters)
              ->get();
    }
    if(!isset($masters)){
        $masters = DB::table('masters')
        ->join('salons', 'masters.salon_id', '=', 'salons.id')
        ->select('masters.*', 'salons.name as salon_name', 'masters.name as master_name','salons.id as salon_id')
        ->get();
    }

    return view('front.masters', ['masters'=> $masters, 'salons'=>$salons]);
  }
  public function salonMasters(Request $request){
        $salonMasters = DB::table('masters')
            ->join('salons', 'masters.salon_id', '=', 'salons.id')
            ->select('masters.*', 'salons.*', 'salons.name as salon_name', 'masters.id as master_id', 'masters.name as master_name')
            ->where('masters.salon_id', $request->id)
            ->get();
          
            $salon = Salon::where('salons.id', $request->id)->first();

             return view('front.salonMasters', ['masters' => $salonMasters, 'salon'=> $salon]);
  }
  public function salonMasterProcedures (Request $request){
 
        $procedures = Procedure::all();
        $master = Master::where('masters.id', $request->id)
        ->first();
     
        $salon = Salon::where('salons.id', $master->salon_id)
        ->first();
        //gaunu dabartini laika
        $today = Carbon::today()->setTimezone('Europe/Vilnius');
        $monthNum = $today->month;
        $monthName = $today->isoFormat('MMMM');
        $year = $today->isoFormat('YYYY');
        //paprasau formato
        $tempDate = Carbon::createFromDate($today->year, $today->month, 1);
        $skip = $tempDate->dayOfWeek;
        for($i = 0; $i < $skip; $i++){
            $tempDate->subDay();
        }
        //sudedu i areju dienas nuo pirmadienio iki sekmadienio
        $thisMonth = [];
        do{
            $week = [];
            foreach(range(1, 7) as $_) {
              $week[] = [$tempDate->day, Carbon::createFromDate($year, $today->month, $tempDate->day)->format('Y-m-d')];
                $tempDate->addDay();
            }
            $thisMonth[] = $week;
        }while($tempDate->month == $today->month);
        //kiti duomenys
        $today = $today->toArray();

        $rating = round(Rating::where('master_id', $request->id)->avg('rate'), 2);
        
        return view('front.masterProcedures', [
          'procedures'=> $procedures, 
          'master'=> $master, 
          'salon'=> $salon, 
          'thisMonth' =>  $thisMonth,
          'monthName' => $monthName,
          'monthNum'=> $monthNum,
          'todayDay'=> $today,
          'year' => $year,
          'rating'=> $rating,
        ]);
  }
}
