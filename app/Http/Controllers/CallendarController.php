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
        $nextMonthName = $nextMonthDay->isoFormat('MMMM');
        $year = $nextMonthDay->isoFormat('YYYY');

        $tempDate = Carbon::createFromDate($nextMonthDay->year, $nextMonthDay->month, 1);
        $skip = $tempDate->dayOfWeek;
        for($i = 0; $i < $skip; $i++){
            $tempDate->subDay();
        }

        $thisMonth = [];
        $monthNum = Carbon::parse($request->monthValue);
        do{
            $week = [];
            foreach(range(1, 7) as $_) {
                if($tempDate->day == 1){
                    $monthNum->addMonth();
                }
              $week[] = [$tempDate->day, Carbon::createFromDate($year, $monthNum->month, $tempDate->day)->format('Y-m-d'), $monthNum->month];
              $tempDate->addDay();
            }
            $thisMonth[] = $week;
        }while($tempDate->month == $nextMonthDay->month);
        // $today = Carbon::now()->setTimezone('Europe/Vilnius')->toArray();
        $today = Carbon::now()->setTimezone('Europe/Vilnius')->toArray(); 
        $html = view('parts.callendar')->with([
            'thisMonth' =>  $thisMonth,
            'monthName' => $nextMonthName,
            'todayDay'=> $today,
            'year' => $year
            ])->render();

        return response()->json([
            'html'=> $html,
        ]);
    }

    public function previousMonth (Request $request){

        $dateOf = Carbon::parse($request->monthValue);
        $previousMonthDay = $dateOf->subMonth();

        $previousMonthName = $previousMonthDay->isoFormat('MMMM');
        $year = $previousMonthDay->isoFormat('YYYY');
        
        $tempDate = Carbon::createFromDate($previousMonthDay->year, $previousMonthDay->month, 1);
        $skip = $tempDate->dayOfWeek;
        for($i = 0; $i < $skip; $i++){
            $tempDate->subDay();
        }
        $monthNum = Carbon::parse($request->monthValue)->subMonths(2);
        $thisMonth = [];
        do{
            $week = [];
            foreach(range(1, 7) as $_) {
                if($tempDate->day == 1){
                    $monthNum->addMonth();
                }
              $week[] = [$tempDate->day, Carbon::createFromDate($year, $monthNum->month, $tempDate->day)->format('Y-m-d'), $monthNum->month];
                $tempDate->addDay();
            }
            $thisMonth[] = $week;
        }while($tempDate->month == $previousMonthDay->month);

        // $today = Carbon::now()->setTimezone('Europe/Vilnius')->toArray(); 
        $today = Carbon::now()->setTimezone('Europe/Vilnius')->toArray(); 
        $html = view('parts.callendar')->with([
            'thisMonth' =>  $thisMonth,
            'monthName' => $previousMonthName,
            'todayDay'=> $today,
            'year' => $year,
            ])->render();

        return response()->json([
            'html'=> $html,
        ]);
    }
    public function showDay(Request $request){
        //this master appointments today in this user cart
        $cart = collect(session()->get('cart', []));
        $cartForThisDayMaster = $cart->where('masterId', $request->masterId)
                                    ->filter(function ($value, $key) use ($request){
                                        return Carbon::parse($value['appointmentDate'])->format('Y-m-d') === $request->date;                             
                                    })
                                    ->map(function($appointment){
                                      
                                        $minutes = Procedure::where('id', $appointment['procedureId'])
                                                                    ->select('minutes')
                                                                    ->first()
                                                                    ->minutes;
                                        $appointment['appointment_start'] = $appointment['appointmentDate'];
                                        $appointment['appointment_end'] = Carbon::parse($appointment['appointmentDate'])->addMinutes($minutes)->format('Y-m-d H:i');
                                        return array_splice($appointment, -2);
                                    });

        //this master appointments today in data base
        $appointments = Apointment::where('master_id', $request->masterId)
                    ->whereDate('appointment_start', $request->date)
                    ->select('appointment_start', 'appointment_end')
                    ->get();
                    foreach($cartForThisDayMaster as $oneCartAppointment){
                        $cartAppointment = new Apointment;
                        $cartAppointment->appointment_start =  $oneCartAppointment['appointment_start'];
                        $cartAppointment->appointment_end = $oneCartAppointment['appointment_end'];
                        $appointments->push($cartAppointment);
                    }
        //filter appointments that are later than now
        $appointments = $appointments->filter(function ($value, $key) {
                                            return Carbon::create($value['appointment_start'])->greaterThanOrEqualTo(Carbon::now());
                                        })->sortBy('appointment_start');
        //when master is free this day
        $freeTimeStarts = Carbon::parse('10:00')->format('H:i');
        $freeTimeEnds = Carbon::parse('20:00')->format('H:i');
        $timeNow = Carbon::now();
        $dateNow = $timeNow->format('Y-m-d');

        if($dateNow === $request->date 
            && $timeNow->greaterThan(Carbon::create($dateNow . ' 10:00')))
        {
            $freeTimeStarts = Carbon::now()->addMinutes(30)->ceilMinute(30)->format('H:i');
        } 

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
        //availible appointment times
        $procedureDuration = Procedure::where('id', $request->procedureId)
        ->select('minutes')
        ->first()->minutes;

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
