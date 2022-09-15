<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Master;
use App\Models\Procedure;
use App\Models\Apointment;
use Auth;

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
        
        foreach($request->appointments as $oneAppointment){
            
            $appointment = New Apointment;
            $appointment->procedure_id = $oneAppointment['procedureId'];
            $appointment->master_id = $oneAppointment['masterId'];
            $appointment->user_id = Auth::user()->id;
            $appointment->appointment_start = $oneAppointment['appoitmentDate']['start'];
            $appointment->appointment_end = $oneAppointment['appoitmentDate']['end'];
            $appointment->save();
            dump($oneAppointment['appoitmentDate']['end']);
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
        $appointmentInfo = $request->appointment;
        $masterId = (int) $request->masterId;
        $procedureId = (int) $appointmentInfo['procedureId'];
        
        $appointmentDate = Carbon::create($appointmentInfo['dateTime'], 0, 'Europe/Vilnius')->format('Y-m-d H:i');
        dump($appointmentDate);
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
            $appointment['appointmentDate'] = [$appointment['appointmentDate'], Carbon::create($appointment['appointmentDate'])->addMinutes($appointment['procedureId'][3])]; 
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
}
