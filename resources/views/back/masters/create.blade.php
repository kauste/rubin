@extends('layouts.app')
@section('content')
<div class="container col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-1 p-sm-2 p-md-3 p-lg-4">
            <h4 class="card-header text-body">Register new Master</h4>
            <div class="card-body text-body">
                <form class="p-3" method="post" enctype="multipart/form-data" action="{{route('masters-store')}}">
                    <div class=" form-row">
                        <div class="form-group col-md-12 mb-4">
                            <label class="fw-bold" for="master_name">Name</label>
                            <input type="text" name="master_name" class="form-control" id="master_name" value="{{old('master_name')}}">
                        </div>
                        <div class="form-group col-md-12 mb-4">
                            <label class="fw-bold" for="master_surname">Surame</label>
                            <input type="text" name="master_surname" class="form-control" id="master_surname" value="{{old('master_surname')}}">
                        </div>
                        <div class="form-group col-md-12 mb-4">
                            <label class="fw-bold" for="image">Image</label>
                            <input type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="form-control" id="image">
                        </div>
                        <div class="form-group col-md-12 mb-4">
                            <label class="fw-bold" for="master_salon">Whitch salon to register to?</label>
                                @forelse($salons as $salon)
                                <div>
                                <input type="radio" id="salon_id" name="salon_id" value="{{$salon->id}}">
                                <label for="salon_id">{{$salon->name}}</label>
                                </div>
                                @empty
                                <div class="text-danger"><b>No salons added at the moment. If you want to register new paster, please, register the salon first.</b></div>
                                @endforelse
                        </div>
                    </div>
                    @csrf
                    @method('post')
                    <button type="submit" class="btn btn-danger col-4 mt-4 center">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
