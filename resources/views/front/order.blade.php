@extends('layouts.app')
@section('content')
<div class="container col-11 col-md-10 col-xl-8 mt-5 cart-blade">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-md-3 p-0">
            <h4 class="card-header text-body">
                Your order, dear <b>{{Auth::user()->name}}</b>
            </h4>
            <div class="card-body text-body">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Procedure</th>
                            <th>Date</th>
                            <th>Master</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cart as $id => $appointment)
                        <tr class="one--appointment" valign="middle">
                            <td >{{$appointment['procedureId'][1]}}</td>
                            <td>
                                <span class="appointment--start">{{$appointment['appointmentDate'][0]}}</span>
                                <span>-</span>
                                <span class="appointment--end">{{$appointment['appointmentDate'][1]}}</span>
                            </td>
                            <td class="master--id" data-master-id="{{$appointment['masterId'][0]}}">{{$appointment['masterId'][1]}}</td>
                            <td class="procedure--id" data-procedure-id="{{$appointment['procedureId'][0]}}">{{$appointment['procedureId'][2]}}</td>
                            <td class="d-flex flex-column flex-sm-row align-center gap-1">
                                <a href=" {{route('front-salon-master', [$appointment['masterId'][0], str_replace(' ', '+', $appointment['appointmentDate'][0])]).'#'.$appointment['procedureId'][0]}}" class="btn btn-secondary">Edit date</a>
                                <form action="{{route('client-delete-appointment', $id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                <div class="btn btn-success order--appointments">Confirm</div>
            </div>
        </div>
    </div>
</div>
@endsection
