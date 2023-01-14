@extends('layouts.app')
@section('content')
<div class="container col-12 col-sm-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3 mt-5">
    <div class="row">
        <div class="card border-danger m-0 m-sm-3 p-2 p-sm-4">
            <h4 class="card-header text-body">Create New Salon</h4>
            <div class="card-body text-body">
                <form class="p-3" method="post" action="{{route('salons-store')}}">
                    <div class=" form-row">
                        <div class="form-group mb-3">
                            <label for="salon_title" class="fw-bold">Salon title</label>
                            <input type="text" name="salon_title" class="form-control" id="salon_title" value="{{old('salon_title')}}">
                        </div>
                        <div class="form-group mb-3">
                            <div class="fw-bold">Address</div>
                            <div>
                                <div>
                                    <label for="street"><i>Street</i></label>
                                    <div class="d-flex align-items-end gap-2" >
                                        <input type="text" class="form-control" id="street" name="street" value="{{old('street')}}">
                                        <span>str.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-5">
                                <div>
                                    <label for="street_num"><i>Street number</i></label>
                                    <input type="text" class="form-control " id="street_num" name="street_num" value="{{old('street_num')}}">
                                </div>
                                <div>
                                    <label for="flat_num"><i>Flat number</i></label>
                                    <input type="text" class="form-control" id="flat_num" name="flat_num" value="{{old('flat_num')}}">
                                </div>
                            </div>
                            <div>
                                <div class="col-4">
                                    <label for="city"><i>City</i></label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{old('city')}}">
                                </div>
                            </div>
                        </div>
                            <div class="form-group col-12">
                                <label class="fw-bold">Telephone number</label>
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