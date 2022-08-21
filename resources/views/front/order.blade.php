@extends('layouts.app')
@section('content')
<div class="container col-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <h4 class="card-header text-body">
                Your order, dear <b>{{Auth::user()->name}}</b>
            </h4>
            <div class="card-body text-body">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col-4">Procedure</th>
                            <th scope="col-3">Date</th>
                            <th scope="col-3">Master</th>
                            <th scope="col-3">Price</th>
                        </tr>
                    <tbody>
                        </thead>
                        @forelse ($cart as $id => $appointment)
                        <tr class="one--appointment" valign="middle">
                            <td >{{$appointment['procedureId'][1]}}</td>
                            <td>
                                <div class="appointment--start">{{$appointment['appointmentDate'][0]}}</div>
                                <div class="appointment--end">{{$appointment['appointmentDate'][1]}}</div>
                            </td>
                            <td class="master--id" data-master-id="{{$appointment['masterId'][0]}}">{{$appointment['masterId'][1]}}</td>
                            <td class="procedure--id" data-procedure-id="{{$appointment['procedureId'][0]}}">{{$appointment['procedureId'][2]}}</td>
                            <td class="col-1">
                                <a href="" class="btn btn-secondary">EDITAS NEPADARYTAS</a>
                            </td>
                            <td class="col-1">
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
