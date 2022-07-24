@extends('layouts.app')
@section('content')
<div class="container col-4 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-4 ">
            <h4 class="card-header text-body">Edit procedure</h4>
            <div class="card-body text-body">
                <form class="p-3" method="post" action="{{route('procedures-update', $procedure)}}">
                    <div class=" form-row">
                        <div class="form-group col-md-12 mb-4">
                            <label for="procedure_title">
                                <h5>Procedure title</h5>
                            </label>
                            <input type="text" name="procedure_title" class="form-control" id="procedure_title" value="{{old('procedure_title', $procedure->ruby_service)}}">
                        </div>
                        <div class="form-group col-md-8 mt-4 center">
                            <label>
                                <h5>Procedure duration</h5>
                            </label>
                            <div class="d-flex" style="column-gap:30px;">
                                <div>
                                    <label for="hours"><i>Hours</i></label>
                                    <div class="d-flex" style="column-gap:10px; align-items:baseline">
                                        <input type="text" name="hours" class="form-control" id="hours" value="{{old('hours', $procedure->hours)}}">
                                        <span>h.</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="minutes"><i>Minutes</i></label>
                                    <div class="d-flex" style="column-gap:10px; align-items:baseline">
                                        <input type="text" name="minutes" class="form-control" id="minutes" value="{{old('minutes', $procedure->minutes)}}">
                                        <span>min.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-8 mt-4 center">
                            <label>
                                <h5>Price</h5>
                            </label>
                            <div class="d-flex" style="column-gap:30px;">
                                <div>
                                    <label for="euros"><i>Euros</i></label>
                                    <div class="d-flex" style="column-gap:10px; align-items:baseline">
                                        <input type="text" name="euros" class="form-control" id="euros" value="{{old('euros', $procedure->euros)}}">
                                        <span>eur.</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="cents"><i>Cents</i></label>
                                    <div class="d-flex" style="column-gap:10px; align-items:baseline">
                                        <input type="text" name="cents" class="form-control" id="cents" value="{{old('cents', $procedure->cents) }}">
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
