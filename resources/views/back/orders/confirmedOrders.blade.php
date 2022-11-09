@extends('layouts.app')
@section('content')
<div class="container col-10 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            @include('parts.sortFilterSearch')
        </div>
        <div class="card border-danger mb-3 m-3 p-3">
            <h4 class="card-header text-body">
                <b>Booked appointments</b>
            </h4>
            <div class="card-body text-body bg-danger">
                <div class="table bg-danger">
                    @forelse ($appointments as $appointment)
                    <div class="one--appointment card border-danger m-3 p-3">
                        <h5 class="card-header"><b>Appointment number: {{$appointment['id']}}</b><span> Master: {{$appointment['master_name']}} {{$appointment['master_surname']}}</span></h5>
                        <div class="card-body conf-ord-grid">
                            <div><b>{{$appointment['procedure']}}</b></div>
                            <div>
                                <div class="appointment--start">{{$appointment['appointment_start']}}</div>
                                <div class="appointment--end">{{$appointment['appointment_start']}}</div>
                            </div>
                            <div>{{$appointment['user_name']}} {{$appointment['user_email']}}</div>
                            <div>{{$appointment['procedure_price']}}</div>
                            <div>
                                @if($appointment['state'] !== 6)
                                <form method="post" action="{{route('back-change-state', $appointment['id'])}}" class="input-group mb-3 d-flex">
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="state">State:</label>
                                    </div>
                                    <select class="custom-select border-danger" name="state" id="state">
                                        @foreach($states as $key => $state)
                                        @if($key !== 6)
                                        <option value="{{$key}}" @if($key==$appointment['state']) selected @endif>{{$state}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @csrf
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="submit">Change state!</button>
                                    </div>
                                </form>
                                @else
                                <div class="d-flex">
                                    <div>{{$states[$appointment['state']]}}</div>
                                    <form method="post" action="{{route('back-cliend-canceled-seen', $appointment['id'])}}" class="input-group mb-3 d-flex">
                                        @method('delete')
                                        @csrf
                                        <div class="input-group-append">
                                            <button class="btn btn-danger" type="submit">Seen</button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div>No apointments</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endsection
