@extends('layouts.app')
@section('content')
<div class="container col-12 col-sm-10 col-xl-8 mt-5">
    <div class="row">
        <div class="card border-danger m-0 m-sm-3 p-0 p-sm-3">
            <h4 class="card-header text-body">
                <b>Filter</b>
            </h4>
               <div class="filter-options">
            <div class="card-body text-body" >
                <form method="get" action="{{route('front-masters')}}">
             
                    <label for="filter-masters">Choose salon:</label>
                    <select  class="col-sm-4 col-md-4 col-lg-3"name="filter_masters" id="filter-masters">
                    <option value='' @if($salons[1] == null) selected @endif>All</option>
                        @foreach ($salons[0] as $salon)
                        <option value="{{$salon->id}}" @if($salons[1] == $salon->id) selected @endif>{{$salon->name}}</option>
                        @endforeach
                    </select>
                 
                    <button class="btn btn-danger" type="submit">GO!</button>
                </form>
            </div>
               </div>
        </div>
    </div>
</div>
<div class="container col-12 col-sm-10 col-xl-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-0 m-sm-3 p-0 p-sm-3">
            <h4 class="card-header text-body">
                <b>Our Lovely Masters</b>
            </h4>
            <div class="card-body text-body">
                @forelse ($masters as $master)
                <div class="card col-12  d-flex flex-column flex-md-row align-center gap-md-5 gap-2 mb-5">
                    <div class="master-image bg-danger col-12 col-sm-10 col-md-6 col-lg-5 mt-3 mt-md-0">
                        <img src="{{$master->file_path}}" class="card-img-top" alt="{{$master->salon_name}}"></img>
                    </div>
                    <div class="card-body align-center justify-content-center gap-3 flex-column flex-xl-row col-12 col-sm-10 col-sm-6 col-lg-7">
                        <div class="d-flex flex-column justify-content-center col-12 col-xl-7">
                            <h5 class="card-title text-danger"><b>{{$master->master_name}} {{$master->surname}}</b></h5>
                            <p class="card-text">At the moment is working in <b>{{$master->salon_name}}</b>.</p>
                        </div>
                        <div class="d-flex justify-content-center col-12 col-xl-5 mt-3 mt-xl-0">
                            <a href="{{route('front-salon-master', $master->id)}}" class="btn btn-danger">Choose this master</a>
                        </div>
                    </div>-
                </div>
                @empty
                <div> No masters added yet.</div>
                @endforelse

            </div>
        </div>
    </div>
</div>
@endsection
