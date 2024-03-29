@extends('layouts.app')
@section('content')
<div class="container col-12 col-sm-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 mt-5">
    <div class="row">
        <div class="card border-danger m-0 m-sm-3 p-0 p-sm-1 p-sm-2 p-md-3 p-lg-4">
            <h4 class="card-header text-body">Edit Master</h4>
            <div class="card-body text-body">
                <form class="p-3" method="post" enctype="multipart/form-data" action="{{route('masters-update', $master)}}">
                    <div class=" form-row">
                        <div class="form-group col-md-12 mb-4">
                            <label for="master_name" class="fw-bold">Name</label>
                            <input type="text" name="master_name" class="form-control" id="master_name" value="{{old('master_name', $master->name)}}">
                        </div>
                        <div class="form-group col-md-12 mb-4">
                            <label for="master_surname" class="fw-bold">Surame</label>
                            <input type="text" name="master_surname" class="form-control" id="master_surname" value="{{old('master_surname', $master->surname)}}">
                        </div>
                        <div class="form-group col-md-12 mb-4">
                            <label for="image" class="fw-bold">Image</label>
                            <input type="file" name="image" class="form-control" id="image" value="{{$master->file_path}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="master_salon" class="fw-bold">Whitch salon to register to?</label>
                            @forelse($salons as $salon)
                            <div>
                                <input type="radio" id="salon_id" name="salon_id" value="{{$salon->id}}" @if($salon->id == $master->salon_id) checked @endif>
                                <label for="salon_id">{{$salon->name}}</label>
                            </div>
                            @empty
                            <div class="text-danger"><b>No salons added at the moment. If you want to register new paster, please, register the salon first.</b></div>
                            @endforelse
                        </div>
                    </div>
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-danger col-4 mt-4 center">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
