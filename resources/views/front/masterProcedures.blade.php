@extends('layouts.app')
@section('content')
<div class="container col-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <div class="card col-12 flex mb-5">
                <div class="master-image bg-danger col-5">
                    <img src="{{ asset('img/'.$master->file_path) }}" class="card-img-top" alt="{{$master->salon_name}}"></img>
                </div>
                <div class="card-body align-center col-7">
                    <div>
                        <h5 class="card-title text-danger"><b>{{$master->name}} {{$master->surname}}</b></h5>
                        <p class="card-text">At the moment is working in <b>{{$master->salon_name}}</b>.</p>
                    </div>
                    <div class="flex-end-column col-3">
                        <a href="{{route('front-salons')}}" class="btn btn-outline-danger">Go back to salons list</a>
                    </div>
                    <div class="flex-end-column col-3">
                        <a href="{{route('front-salon-masters', [$salon])}}" class="btn btn-outline-danger">Go back to this salon masters</a>
                    </div>
                </div>
            </div>
            <h4 class="card-header text-body">
                <b>Services</b>
            </h4>
            <div class="card-body text-body">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col-1">Add</th>
                            <th scope="col-4">Service</th>
                            <th scope="col-3">Duration</th>
                            <th scope="col-3">Price</th>
                        </tr>
                    </thead>
                    <form action="" method="post" class="!imortant" style="width:100%; height:90px; !important">
                        @csrf
                        @method('post')
                            @forelse ($procedures as $procedure)
                            <tr valign="middle">
                                <td>
                                    <input type="checkbox" id="{{$procedure->ruby_service}}" name="procedure-{{$procedure->id}}" value="{{$procedure->minutes}}">
                                </td>
                                <td><label for="{{$procedure->ruby_service}}">{{$procedure->ruby_service}}</label></td>
                                <td>{{floor($procedure->minutes / 60)}}h. {{$procedure->minutes - (floor($procedure->minutes / 60))* 60}} min.</td>
                                <td>{{$procedure->price}} eur.</td>
                            </tr>
                            @empty
                            <div>We are sorry, at the moment there is no services we can offer for you.</div>
                            @endforelse
                            <tr>
                                <button type="submit" class="btn btn-danger col-12">Order</button>
                            </tr>
                    </form>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
