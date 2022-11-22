@extends('layouts.app')
@section('content')
<div class="container col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 col-xxl-3 mt-5">
    <div class="row">
        <div class="card border-danger m-3 p-2 p-sm-4">
            <h4 class="card-header text-body">Edit Salon</h4>
            <div class="card-body text-body">
                <form class="p-3" method="post" action="{{route('salons-update', $salon)}}">
                    <div class=" form-row">
                        <div class="form-group mb-3">
                            <label for="salon_title" class="fw-bold">Salon title</label>
                            <input type="text" name="salon_title" class="form-control" id="salon_title" value="{{old('salon_title', $salon->name)}}">
                        </div>
                        <div class="form-group mb-3">
                            <div class="fw-bold">Address</div>
                            <div>
                                <div>
                                    <label for="street"><small>Street</small></label>
                                    <div class="d-flex align-items-end gap-2" >
                                        <input type="text" class="form-control" id="street" name="street" value="{{old('street', $salon->street)}}">
                                        <span>str.</spans>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-5 mb-3">
                                <div>
                                    <label for="street_num"><small>House nr.</small></label>
                                    <input type="text" class="form-control " id="street_num" name="street_num" value="{{old('street_num', $salon->street_number)}}">
                                </div>
                                <div>
                                    <label for="flat_num"><small>Flat nr.</small></label>
                                    <input type="text" class="form-control" id="flat_num" name="flat_num" value="{{old('flat_num', $salon->flat_number)}}">
                                </div>
                            </div>
                            <div>
                                <div>
                                    <label for="city"><small>City</small></label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{old('city', $salon->city)}}">
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <label class="fw-bold" for="tel_num">Telephone number</label>
                                <div class="d-flex" style="column-gap:10px; font-size: 20px;">
                                    <span>+370</span>
                                    <input type="text" name="tel_num" class="form-control" id="tel_num" value="{{old('tel_num', $salon->telephone_num)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @csrf
                    @method('put')
                    <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger col-4 mt-2">Edit</button>
                    </div>
                </form>
                <p class="card-text"></p>
            </div>
        </div>
    </div>
</div>
@endsection
