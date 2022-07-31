@extends('layouts.app')
@section('content')
<div class="container col-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-1 m-3 p-3">
            <h4 class="card-header text-body">
                <b>Filter</b>
            </h4>
               <div class="filter-options">
            <div class="card-body text-body" >
                <form method="get" action="{{route('front-masters')}}">
             
                    <label for="filter-masters">Choose salon:</label>
                    <select  class="col-2"name="filter_masters" id="filter-masters">
                        @foreach ($salons as $salon)
                        <option value="{{$salon->id}}">{{$salon->name}}</option>
                        @endforeach
                    </select>
                 
                    <button class="btn btn-danger" type="submit">GO!</button>
                </form>
            </div>
               </div>
        </div>
    </div>
</div>
<div class="container col-8 mt-1">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">

            <h4 class="card-header text-body">
                <b>Our Lovely Masters</b>
            </h4>
            <div class="card-body text-body">
                @forelse ($masters as $master)
                <div class="card col-12 flex mb-5">
                    <div class="master-image bg-danger col-5">
                        <img src="{{$master->file_path}}" class="card-img-top" alt="{{$master->salon_name}}"></img>
                    </div>
                    <div class="card-body align-center col-7">
                        <div>
                            <h5 class="card-title text-danger"><b>{{$master->master_name}} {{$master->surname}}</b></h5>
                            <p class="card-text">At the moment is working in <b>{{$master->salon_name}}</b>.</p>
                        </div>
                        <div class="flex-end-column">
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
