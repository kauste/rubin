@extends('layouts.app')
@section('content')
<div class="container col-10 col-xl-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <h4 class="card-header text-body">
                <b>Our Lovely Masters</b>
            </h4>
            <div class="card-body col-12 text-body">
                <h4 class=" text-danger">
                    <b>{{$salon->name}}</b>
                </h4>
                <p class="card-text mb-1">Adress: {{$salon->street}} str. {{$salon->street_number}}@if($salon->flat_number)-{{$salon->flat_number}}@endif, {{$salon->city}}</p>
                <p class="card-text">Tel num: +370 {{$salon->telephone_num}}</p>
                <a class="btn btn-secondary" href="{{route('front-salons')}}">Go back to list of salons</a>
            </div>
            <div class="card-body text-body">
                @forelse ($masters as $master)
                <div class="card col-12  d-flex flex-column flex-md-row align-center gap-md-5 gap-2 mb-5">
                    <div class="master-image bg-danger col-12 col-sm-10 col-md-6 col-lg-5 mt-3 mt-md-0">
                        <img src="{{$master->file_path}}" class="card-img-top" alt="{{$master->salon_name}}"></img>
                    </div>
                    <div class="card-body align-center justify-content-center gap-3 flex-column flex-xl-row col-10 col-sm-6 col-lg-7">
                        <div class="d-flex flex-column justify-content-center col-12 col-xl-7">
                            <h5 class="card-title text-danger"><b>{{$master->master_name}} {{$master->surname}}</b></h5>
                            <p class="card-text">At the moment is working in <b>{{$master->salon_name}}</b>.</p>
                        </div>
                        <div class=" d-flex justify-content-center col-12 col-xl-5 mt-3 mt-xl-0">
                            <a href="{{route('front-salon-master', $master->master_id)}}" class="btn btn-danger">Choose this master</a>
                        </div>
                    </div>
                </div>
                @empty
                <div> No masters added yet.</div>
                @endforelse

            </div>
        </div>
    </div>
</div>
@endsection
