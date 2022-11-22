@extends('layouts.app')
@section('content')
<div class="container col-10 col-xl-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <h4 class="card-header text-body">
                <b>Our Lovely Masters</b>
            </h4>
            <div class="card-body text-body">
                @forelse ($masters as $master)
                <div class="card col-12  d-flex flex-column flex-md-row align-center gap-md-5 gap-2 mb-5">
                    <div class="master-image bg-danger col-12 col-sm-10 col-md-6 col-lg-5 mt-3 mt-md-0">
                        <img src="{{$master->file_path}}" class="card-img-top" alt="{{$master->salon->name}}"></img>
                    </div>
                    <div class="card-body align-center justify-content-center gap-3 flex-column flex-xl-row col-10 col-sm-6 col-lg-7">
                        <div class="d-flex flex-column justify-content-center col-12 col-xl-7">
                            <h5 class="card-title text-danger"><b>{{$master->name}} {{$master->surname}}</b></h5>
                            <p class="card-text">At the moment is working in <b>{{$master->salon->name}}</b>.</p>
                        </div>
                        <div class="d-flex gap-2 justify-content-center col-12 col-xl-5 mt-3 mt-xl-0">
                            <a href="{{route('masters-edit', $master)}}" class="btn btn-secondary">Edit</a>
                            <form action="{{route('masters-delete', $master)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
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
