@extends('layouts.app')
@section('content')
<div class="container col-12 col-sm-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 mt-5">
    <div class="row">
        <div class="card border-danger m-0 m-sm-3 p-0 p-sm-1 p-sm-2 p-md-3 p-lg-4">
            <h4 class="card-header text-body">Edit procedure</h4>
            <div class="card-body text-body">
                <form class="p-3" method="post" action="{{route('procedures-update', $procedure)}}">
                    <div class=" form-row">
                        <div class="form-group mb-3">
                            <label for="procedure_title" class="fw-bold">Procedure title</label>
                            <input type="text" name="procedure_title" class="form-control" id="procedure_title" value="{{old('procedure_title', $procedure->ruby_service)}}">
                        </div>
                        <div class="form-group mb-3">
                            <div class="fw-bold">Procedure duration</div>
                            <div class="d-flex gap-5 col-10 col-xl-9">
                                <div>
                                    <label for="hours"><small>Hours</small></label>
                                   <div class="d-flex gap-3 align-items-baseline">
                                        <input type="number" name="hours" class="form-control number-input-padding" id="hours" value="{{old('hours', $procedure->hours)}}">
                                        <span>h.</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="minutes"><small>Minutes</small></label>
                                    <div class="d-flex gap-3 align-items-baseline">
                                        <input type="number" name="minutes" class="form-control number-input-padding" id="minutes" value="{{old('minutes', $procedure->minutes)}}">
                                        <span>min.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="fw-bold">Price</div>
                            <div class="d-flex gap-5 col-10" >
                                <div>
                                    <label for="euros"><small>Euros</small></label>
                                    <div class="d-flex gap-3 align-items-baseline">
                                        <input type="number" name="euros" class="form-control number-input-padding" id="euros" value="{{old('euros', $procedure->euros)}}">
                                        <span>eur.</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="cents"><small>Cents</small></label>
                                    <div class="d-flex gap-3 align-items-baseline">
                                        <input type="number" name="cents" class="form-control number-input-padding" id="cents" value="{{old('cents', $procedure->cents) }}">
                                        <span>cents</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-danger col-4 mt-4 center">Edit</button>
                </form>
                <p class="card-text"></p>
            </div>
        </div>
    </div>
</div>
@endsection
