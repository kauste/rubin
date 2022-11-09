@extends('layouts.app')
@section('content')
<div class="container col-10 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <h4 class="card-header text-body">
                Your confirmed orders, dear <b>{{Auth::user()->name}}</b>
            </h4>
            <div class="card-body text-body">
                <table class="table table-borderless">

                    @forelse ($appointments as $appointment)
                    <div class="one--appointment card border-danger m-3 p-3 front-conf-ord-grid">
                        <div><b>{{$appointment['procedure']}}</b></div>
                        <div>
                            <div class="appointment--start">{{$appointment['appointment_start']}}</div>
                            <div class="appointment--end">{{$appointment['appointment_start']}}</div>
                        </div>
                        <div><a href="{{route('front-salon-master', $appointment['master_id'])}}">{{$appointment['master_name']}} {{$appointment['master_surname']}}</a></div>
                        <div>{{$appointment['procedure_price']}}</div>
                        <div>{{$states[$appointment['state']]}}</div>
                        <div>
                            @if($appointment['state'] < 3) 
                            <form action="{{route('front-change-state', $appointment['id'])}}" method="post">
                                @csrf
                                <input type="hidden" name="state" value="6">
                                <button type="submit" class="btn btn-danger">Cancel</button>
                            </form>
                            @elseif($appointment['state'] > 2 && $appointment['state'] < 6) 
                            <form method="post" action="{{route('front-changed-state-seen', $appointment['id'])}}" class="input-group mb-3 d-flex">
                                @method('delete')
                                @csrf
                                <div class="input-group-append">
                                    <button class="btn btn-danger" type="submit">Confirm</button>
                                </div>
                            </form>
                            @else
                            <form action="{{route('front-change-state', $appointment['id'])}}" method="post">
                                @csrf
                                <input type="hidden" name="state" value="1">
                                <button type="submit" class="btn btn-danger">Renew</button>
                            </form>
                            @endif
                        </div>
                    </div>
            </div>
            @empty
            <div>No orders made yet.</div>
            @endforelse
            </table>
        </div>
    </div>
</div>
</div>
@endsection
