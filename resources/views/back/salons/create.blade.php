@extends('layouts.app')
@section('content')
<div class="container col-5 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-4 ">
            <h4 class="card-header text-body">Create New Salon</h4>
            <div class="card-body text-body">
                <form class="p-3" method="post" action="{{route('salons-store')}}">
                    <div class=" form-row">
                        <div class="form-group col-md-6 mb-4">
                            <label for="salon_title">
                                <h5>Salon title</h5>
                            </label>
                            <input type="text" name="salon_title" class="form-control" id="salon_title" value="{{old('salon_title')}}">
                        </div>
                        <div class="form-group mb-3">
                            <h5>Address</h5>
                            <div class="d-flex" style="column-gap:10px">
                                <div class=" col-4">
                                    <label for="street"><i>Street</i></label>
                                    <div class="d-flex" style="align-items:flex-end; gap:2px">
                                        <input type="text" class="form-control" id="street" name="street" value="{{old('street')}}">
                                        <div>str.</div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="street_num"><i>Street number</i></label>
                                    <input type="text" class="form-control " id="street_num" name="street_num" value="{{old('street_num')}}">
                                </div>
                                <div class="col-2">
                                    <label for="flat_num"><i>Flat number</i></label>
                                    <input type="text" class="form-control" id="flat_num" name="flat_num" value="{{old('flat_num')}}">
                                </div>
                                <div class="col-4">
                                    <label for="city"><i>City</i></label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{old('city')}}">
                                </div>
                            </div>
                            <div class="form-group col-md-6 mt-4">
                                <label>
                                    <h5>Telephone number</h5>
                                </label>
                                <div class="d-flex" style="column-gap:10px; font-size: 20px;">
                                    <div>+370</div>
                                    <input type="text" name="tel_num" class="form-control" id="tel_num" value="{{old('tel_num')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                    @method('post')
                    <button type="submit" class="btn btn-danger col-4 mt-4" style="margin-left:50%; transform: translateX(-50%);">Create</button>
                </form>
                <p class="card-text"></p>
            </div>
        </div>
    </div>
</div>
@endsection