@extends('layouts.app')
@section('content')
<div class="container col-8 mt-5">
    <div class="row d-flex justify-content-center flex-wrap">
        @forelse ($salons as $salon)
        <div class="card border-danger mb-3 m-3" style="max-width: 18rem;">
            <h4 class="card-header text-body">
                <b>{{$salon->name}}</b>
            </h4>
            <div class="card-body text-body">
                <p class="card-text mb-1">{{$salon->street}} str. {{$salon->street_number}}@if($salon->flat_number)-{{$salon->flat_number}}@endif, {{$salon->city}}</p>
                <p class="card-text">+370 {{substr("$salon->telephone_num", 0, 3)}} {{substr("$salon->telephone_num", 3, 8)}}</p>
            </div>
            <div class="m-2"style="display:flex; column-gap:10px; align-items:center; justify-content:flex-end">
                <a href="{{route('salons-edit', $salon)}}" class="btn btn-secondary">Edit</a>
                <form action="{{route('salons-delete', $salon)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

        @empty
        <h3>No salons added yet</h3>
        @endforelse
    </div>
</div>
@endsection
