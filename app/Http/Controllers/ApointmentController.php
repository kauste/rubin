<?php

namespace App\Http\Controllers;

use App\Models\Apointment;
use App\Http\Requests\StoreApointmentRequest;
use App\Http\Requests\UpdateApointmentRequest;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApointmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApointmentRequest $request)
    {
        //
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
}
