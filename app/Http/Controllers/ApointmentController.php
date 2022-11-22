<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Master;
use App\Models\Procedure;
use App\Models\Apointment;
use Auth;
use Illuminate\Support\Facades\Validator;

class ApointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApointmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $validator = Validator::make($request->all(), [
                'appointments.*.masterId' => ['required', 'integer', 'exists:masters,id'],
                'appointments.*.procedureId' => ['required', 'integer', 'exists:procedures,id'],
                'appointments.*.appoitmentDate.start' => ['required', 'date'],
                'appointments.*.appoitmentDate.end' => ['required']
            ]);

            $validator->after(function ($validator) use ($request){
                foreach($request->appointments as $oneAppointment){
                    $master = Master::where('id', $oneAppointment['masterId'])
                                    ->select('name', 'surname')
                                    ->first();

                    $thisDay = Carbon::parse($oneAppointment['appoitmentDate']['start'])->format('Y-m-d');
                    $thisStarts = $oneAppointment['appoitmentDate']['start'];
                    $thisEnds = $thisDay .' '. $oneAppointment['appoitmentDate']['end'];
                    $thisPeriod = \Carbon\CarbonPeriod::create($thisStarts, '30 minutes', $thisEnds);

                    $masterBusyTimes = Apointment::where('master_id', $oneAppointment['masterId'])
                                ->whereDate('appointment_start', $thisDay)
                                ->select('appointment_start', 'appointment_end')
                                ->get();
                    foreach($masterBusyTimes as $busyTime){
                        $busyStart = $busyTime['appointment_start'];
                        $busyEnds = $busyTime['appointment_end'];
                        $busyPeriod = \Carbon\CarbonPeriod::create($busyStart, '30 minute', $busyEnds);
                        // dump($thisPeriod->overlaps($busyPeriod));
                        if ($thisPeriod->overlaps($busyPeriod)) {
                            $validator->errors()->add('msg','Sorry! '. $master->name . ' ' . $master->surname .' is busy between '. $thisStarts .' and ' . $thisEnds . '. Time may be taken just recently.');
                        }
                    }
               }
            });
            if($validator->fails()){
                $msgs = $validator->errors()->getMessages()['msg'];
                return response()->json(['msgs'=> $msgs]);
            }



        foreach($request->appointments as $oneAppointment){
            $thisDay = Carbon::parse($oneAppointment['appoitmentDate']['start'])->format('Y-m-d');
            $appointment = New Apointment;
            $appointment->procedure_id = $oneAppointment['procedureId'];
            $appointment->master_id = $oneAppointment['masterId'];
            $appointment->user_id = Auth::user()->id;
            $appointment->appointment_start = $oneAppointment['appoitmentDate']['start'];
            $appointment->appointment_end = $thisDay .' '. $oneAppointment['appoitmentDate']['end'];
            $appointment->save();
        }
       
        session()->put('cart', []);
        return response()->json([
            'message'=> 'Appintment(s) is (are) reserverd.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apointment  $apointment
     * @return \Illuminate\Http\Response
     */
    public function show(Apointment $apointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apointment  $apointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apointment $apointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApointmentRequest  $request
     * @param  \App\Models\Apointment  $apointment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApointmentRequest $request, Apointment $apointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apointment  $apointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apointment $apointment)
    {
        //
    }
    public function addToCart(Request $request){

        $cart = session()->get('cart', []);

        $validator = Validator::make($request->all(), [
            'masterId' => ['required', 'integer', 'exists:masters,id'],
            'appointment.procedureId'=>['required', 'integer', 'exists:procedures,id'],
            'appointment.dateTime'=>['required', 'date'],
        ]);
        $validator->after(function ($validator) use ($request, $cart){

            $master = Master::where('id',$request->masterId)
                            ->select('name', 'surname')
                            ->first();
            $procedureDuration = Procedure::where('id', $request['appointment']['procedureId'])
                            ->select('minutes')
                            ->first()
                            ->minutes;
            $thisDay = Carbon::parse($request['appointment']['dateTime'])->format('Y-m-d');
            $thisStarts = $request['appointment']['dateTime'];
            $thisEnds = Carbon::parse($request['appointment']['dateTime'])->addMinutes($procedureDuration);
            $thisPeriod = \Carbon\CarbonPeriod::create($thisStarts, '30 minutes', $thisEnds);

            $masterBusyTimes = Apointment::where('master_id', $request->masterId)
                                ->whereDate('appointment_start', $thisDay)
                                ->select('appointment_start', 'appointment_end')
                                ->get();
                             dump($request->masterId, 'lklnklb', $request->masterId) ;
            foreach($cart as $item){
                if($item['masterId'] == $request->masterId
                && str_contains($item['appointmentDate'], $thisDay)
                && Carbon::now()->isBefore(Carbon::parse($item['appointmentDate']))){
                    $cartProcedureDuration = Procedure::where('id', $item['procedureId'])
                                                    ->select('minutes')
                                                    ->first()
                                                    ->minutes;
                    $appointment = new Apointment;
                    $appointment->appointment_start = $item['appointmentDate'];
                    $appointment->appointment_end = Carbon::parse($item['appointmentDate'])->addMinutes($cartProcedureDuration)->format('Y-m-d H:i');
                    $masterBusyTimes->push($appointment);
                }
            }
            $masterBusyTimes = $masterBusyTimes->sortBy('appointment_start');

            foreach($masterBusyTimes as $busyTime){
                        $busyStart = $busyTime['appointment_start'];
                        $busyEnds = $busyTime['appointment_end'];
                        $busyPeriod = \Carbon\CarbonPeriod::create($busyStart, '30 minute', $busyEnds);
                        if ($thisPeriod->overlaps($busyPeriod)) {
                            $validator->errors()->add('msg','Sorry! '. $master->name . ' ' . $master->surname .' is busy between '. $thisStarts .' and ' . $thisEnds . '. Time may be taken just recently.');
                        }
                    }
        });
        if($validator->fails()){
            $msgs = $validator->errors()->getMessages()['msg'];
            return response()->json(['msgs'=> $msgs]);
        }
        
        $appointmentInfo = $request->appointment;
        $masterId = (int) $request->masterId;
        $procedureId = (int) $appointmentInfo['procedureId'];
        $appointmentDate = Carbon::create($appointmentInfo['dateTime'], 0, 'Europe/Vilnius')->format('Y-m-d H:i');
        $cart[] = [
            'masterId'=>$masterId,
            'procedureId'=>$procedureId,
            'appointmentDate'=> $appointmentDate];
        session()->put('cart', $cart);
            session()->put('message', '');
        return response()->json([
            'message'=> 'Appintment is in cart.',
        ]);
    }

    public function showNavCart (){
        $masters = Master::all()->toArray();
        $mastersSurnames = array_column($masters, 'surname', 'id');
        $mastersNames = array_column($masters, 'name', 'id');
        $procedures = Procedure::all()->toArray();
        $procedures= array_column($procedures, 'ruby_service', 'id');
        
        $cart = session()->get('cart', []);

        $html = view('parts.cart')->with([
            'cart'=> $cart,
            'procedures'=> $procedures,
            'mastersNames'=> $mastersNames,
            'mastersSurnames' => $mastersSurnames])->render();

          return response()->json([
            'html'=> $html,
        ]);
    }
    public function showMyOrder(){
        $masters = Master::all()->toArray();
        $mastersSurnames = array_column($masters, 'surname', 'id');
        $mastersNames = array_column($masters, 'name', 'id');
        $masters = array_map(fn($name, $surname) =>  $name . ' ' . $surname, $mastersNames, $mastersSurnames);
        $masters = array_combine(range(1, count($mastersSurnames)), $masters);

        $procedures = Procedure::all()->toArray();
        $proceduresNames= array_column($procedures, 'ruby_service', 'id');
        $proceduresPrice = array_column($procedures, 'price', 'id');
        $proceduresDuration = array_column($procedures, 'minutes', 'id');
        $procedures = array_map(fn($name, $price, $duration,) =>  [$name, $price, $duration], $proceduresNames, $proceduresPrice, $proceduresDuration);
        $procedures = array_combine(range(1, count($proceduresNames)), $procedures);

        $cart = session()->get('cart', []);
        
        $cart = collect([...$cart])-> map(function($appointment) use ($procedures, $masters) {
            $appointment['masterId']= [$appointment['masterId'], $masters[$appointment['masterId']]];
            $appointment['procedureId'] = [$appointment['procedureId'], ...$procedures[$appointment['procedureId']]];
            $appointment['appointmentDate'] = [$appointment['appointmentDate'], Carbon::create($appointment['appointmentDate'])->addMinutes($appointment['procedureId'][3])->format('H:i')]; 
            return $appointment;
        });
        return view('front.order', ['cart'=> $cart]);
    }
    public function clientDeleteAppointment(Request $request){
        $cart = session()->get('cart', []);
        unset($cart[$request->id]);
        $cart = array_values($cart);
        session()->put('cart', $cart);
        return redirect()->back()->with('message', 'Appointment deleted.');
        
    }

    public function confirmedOrders () {
        $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                    ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                    ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id')
            	                    ->where('user_id', Auth::user()->id)
                                    ->get();
    
        $appointments->map(function($appointment) {
            $appointment->appointment_day = Carbon::create($appointment->appointment_start)->format('Y-d-m');
            $appointment->appointment_start = Carbon::create($appointment->appointment_start)->format('H:i');
            $appointment->appointment_end = Carbon::create($appointment->appointment_end)->format('H:i');
            return $appointment;
        });
        return view('front.confirmedOrders', ['appointments'=> $appointments, 'states'=> Apointment::STATES]);
    }

    public function backConfirmedOrders (Request $request) {
        $states = Apointment::STATES;
        $masters = Master::all();
        if($request->sort){
            $sort = $request->sort; // kodel i masyva buvo kista??
            if($request->sort === 'date-asc'){
                $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                        ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                        ->join('users', 'apointments.user_id', 'users.id')
                                        ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                                        ->orderBy('appointment_start', 'asc')
                                        ->get();
            }
            elseif ($request->sort === 'date-desc'){
                $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                        ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                        ->join('users', 'apointments.user_id', 'users.id')
                                        ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                                        ->orderBy('appointment_start', 'desc')
                                        ->get();
            }
            elseif($request->sort === 'appointment-id-asc'){
                $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                        ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                        ->join('users', 'apointments.user_id', 'users.id')
                                        ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                                        ->orderBy('apointments.id', 'asc')
                                        ->get();
            }
            elseif($request->sort === 'appointment-id-desc'){
                $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                        ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                        ->join('users', 'apointments.user_id', 'users.id')
                                        ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                                        ->orderBy('apointments.id', 'desc')
                                        ->get();
                                        //ar geriau ne duomenu bazes, o kolekciju metodais???
            } else {
                $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                    ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                    ->join('users', 'apointments.user_id', 'users.id')
                                    ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                                    ->get();
            }
        } elseif($request->filter){
            $filter = (int) $request->filter;
            if($request->filter == 0){
                $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                ->join('users', 'apointments.user_id', 'users.id')
                ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                ->get();
            } else {
                $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                    ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                    ->join('users', 'apointments.user_id', 'users.id')
                                    ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                                    ->where('masters.id', '=', $request->filter)
                                    ->get();
            }
        } elseif($request->s){
            $search = $request->s;
            $words = explode(' ', trim($search));
            $words = array_slice($words, 0, 4);
            // dump($words);
            $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                        ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                        ->join('users', 'apointments.user_id', 'users.id')
                                        ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                                        ->where(function ($useWords) use ($words){
                                            foreach($words as $word){
                                                $useWords->where('masters.name', 'like', $word. '%')
                                                ->orWhere('masters.surname', 'like', $word. '%')
                                                ->orWhere('procedures.ruby_service', 'like', $word. '%')
                                                ->orWhere('users.name', 'like', $word. '%');
                                             }
                                        })
                                        ->get();
        }
        
        else{
            $appointments = Apointment::join('masters', 'apointments.master_id', 'masters.id')
                                        ->join('procedures', 'apointments.procedure_id', 'procedures.id')
                                        ->join('users', 'apointments.user_id', 'users.id')
                                        ->select('apointments.state', 'apointments.id as id', 'apointments.appointment_start', 'apointments.appointment_end', 'masters.name as master_name', 'masters.surname as master_surname', 'procedures.ruby_service as procedure', 'procedures.price as procedure_price', 'masters.id as master_id', 'users.id as user_id', 'users.name as user_name', 'users.email as user_email')
                                        ->get();

        }
        return view('back.orders.confirmedOrders', [
                                                    'appointments'=> $appointments,
                                                    'sort' => $sort ?? 'default',
                                                    'masters' => $masters,
                                                    'filter' => $filter ?? '0',
                                                    's' => $search ?? '',
                                                    'states' => $states
                                                    ]);
    }

    public function backChangeState(Request $request){
        Apointment::where('id', '=', $request->id)
                    ->update(['state'=> $request->state]);
        return redirect()->back()->with('message', 'State is updated!');
    }
    public function backClientCanceledSeen(Request $request){
        Apointment::where('id', '=', $request->id)
                    ->delete();
        return redirect()->back()->with('message', 'Appointment is deleted!');
    }

    public function frontChangeState(Request $request){
        Apointment::where('id', '=', $request->id)
                    ->update(['state'=> $request->state]);
        if($request->state == 6){
            return redirect()->back()->with('message', 'Appointment is canceled! It will be deleted once the administration see the it.');
        }
        else{
            return redirect()->back()->with('message', 'Appointment is renewed.');

        }
    }
    public function frontChangedStateSeen(Request $request){
        Apointment::where('id', '=', $request->id)
                    ->delete();
        return redirect()->back()->with('message', 'Thank you for confirmation!');
    }
}
