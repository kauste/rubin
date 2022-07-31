<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CallendarController extends Controller
{
    public function nextMonth (Request $request){
 
        $dateOf = Carbon::parse($request->monthValue);
        $nextMonthDay = $dateOf ->addMonth();
        $monthNum = $nextMonthDay->month;
        $nextMonthName = $nextMonthDay->isoFormat('MMMM');
        $year = $nextMonthDay->isoFormat('YYYY');

        $tempDate = Carbon::createFromDate($nextMonthDay->year, $nextMonthDay->month, 1);
        $skip = $tempDate->dayOfWeek;
        for($i = 0; $i < $skip; $i++){
            $tempDate->subDay();
        }

        $thisMonth = [];
        do{
            $week = [];
            foreach(range(1, 7) as $_) {
              $week[] = [$tempDate->day, Carbon::createFromDate($year, $nextMonthDay->month, $tempDate->day)->format('Y-m-d')];
                $tempDate->addDay();
            }
            $thisMonth[] = $week;
        }while($tempDate->month == $nextMonthDay->month);

        $today = Carbon::today()->setTimezone('Europe/Vilnius')->toArray();
        
        $html = view('parts.callendar')->with([
            'thisMonth' =>  $thisMonth,
            'monthName' => $nextMonthName,
            'monthNum'=> $monthNum,
            'todayDay'=> $today,
            'year' => $year
            ])->render();

        return response()->json([
            'html'=> $html,
        ]);
    }

    public function previousMonth (Request $request){

        $dateOf = Carbon::parse($request->monthValue);
        $previousMonthDay = $dateOf ->subMonth();
        $monthNum = $previousMonthDay->month;
        $previousMonthName = $previousMonthDay->isoFormat('MMMM');
        $year = $previousMonthDay->isoFormat('YYYY');
        
        $tempDate = Carbon::createFromDate($previousMonthDay->year, $previousMonthDay->month, 1);
        $skip = $tempDate->dayOfWeek;
        for($i = 0; $i < $skip; $i++){
            $tempDate->subDay();
        }

        $thisMonth = [];
        do{
            $week = [];
            foreach(range(1, 7) as $_) {
              $week[] = [$tempDate->day, Carbon::createFromDate($year, $previousMonthDay->month, $tempDate->day)->format('Y-m-d')];
                $tempDate->addDay();
            }
            $thisMonth[] = $week;
        }while($tempDate->month == $previousMonthDay->month);

        $today = Carbon::today()->setTimezone('Europe/Vilnius')->toArray(); 

        $html = view('parts.callendar')->with([
            'thisMonth' =>  $thisMonth,
            'monthName' => $previousMonthName,
            'monthNum'=> $monthNum,
            'todayDay'=> $today,
            'year' => $year
            ])->render();

        return response()->json([
            'html'=> $html,
        ]);
    }
    public function showDay(Request $request){
        $scheduleTime = [];
        $i = 0;
        do{
            $min = $i * 30;
            $i++;
            $date = Carbon::parse('10:00')->addMinutes($min)->format('H:i');
            $scheduleTime[] = $date;
        }while($date != '19:30');
       
        $html = view('parts.day')->with(['data' =>$request->data, 'scheduleTime'=> $scheduleTime])->render();
    
  
        return response()->json([
            'html'=> $html,
        ]);
    }
}
