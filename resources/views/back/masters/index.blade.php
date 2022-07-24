@extends('layouts.app')
@section('content')
<div class="container col-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <h4 class="card-header text-body">
                <b>Our Lovely Masters</b>
            </h4>
            <div class="card-body text-body">
                @forelse ($masters as $master)
                <div class="card col-12 flex mb-5">
                    <div class="master-image bg-danger col-5">
                        <img src="{{ asset('img/'.$master->file_path) }}" class="card-img-top" alt="{{$master->salon->name}}"></img>
                    </div>
                    <div class="card-body align-center col-7">
                        <div>
                            <h5 class="card-title text-danger"><b>{{$master->name}} {{$master->surname}}</b></h5>
                            <p class="card-text">At the moment is working in <b>{{$master->salon->name}}</b>.</p>
                        </div>
                        <div class="flex-end-column">
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
