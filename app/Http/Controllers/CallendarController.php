<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apointment;
use App\Models\Procedure;
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
        $procedureDuration = Procedure::where('id', $request->procedureId)
                            ->select('minutes')
                            ->first()->minutes;

        $appointments = Apointment::where('master_id', $request->masterId)
                    ->whereDate('appointment_start', $request->date)
                    ->orderBy('appointment_start', 'asc')
                    ->select('appointment_start', 'appointment_end')
                    ->get();
        $freeTimeStarts = Carbon::parse('10:00')->format('H:i');
        $freeTimeEnds = Carbon::parse('20:00')->format('H:i');
        $freeTimes = [];
        if(count($appointments) == 0){
            $freeTimes[] = [$freeTimeStarts, $freeTimeEnds];
        } else {
            foreach($appointments as $appointment){
               $appointmentStart = Carbon::parse($appointment['appointment_start'])->format('H:i');
               $appointmentEnds = Carbon::parse($appointment['appointment_end'])->format('H:i');
                if($appointmentStart == $freeTimeStarts){
                    $freeTimeStarts = $appointmentEnds;
                }
                else {
                    $freeTimes[] = [$freeTimeStarts, $appointmentStart];
                    $freeTimeStarts = $appointmentEnds;
                }
             }
             if($freeTimeStarts != $freeTimeEnds){
                $freeTimes[] = [$freeTimeStarts, $freeTimeEnds];
             }
        }
        $appointmentTimes = [];
        foreach($freeTimes as $freeTime){
            $endTimeCarbon = Carbon::createFromTimeString($freeTime[1]);

            $timeCarbon = Carbon::createFromTimeString($freeTime[0]);
            
            while($endTimeCarbon >= $timeCarbon->addMinutes($procedureDuration)){
                $thisEnds = $timeCarbon->format('H:i');
                $thisStarts = $timeCarbon->subMinutes($procedureDuration)->format('H:i');
                $appointmentTimes[] = [$thisStarts, $thisEnds];
                
                $timeCarbon->addMinutes(30)->format('H:i');
             };
        }

        $html = view('parts.day')->with(['date' =>$request->date, 'freeTimes' => $freeTimes, 'appointmentTimes'=> $appointmentTimes])->render();
  
        return response()->json([
            'html'=> $html,
        ]);
    }
}
