@extends('layouts.app')
@section('content')
<div class="container col-12 col-sm-10 col-xl-9 col-xxl-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-0 m-sm-3 p-0 pb-2 p-sm-3">
            <div class="card col-12 flex mb-5">
                <div class="d-flex flex-column flex-md-row  master--info">
                    <div class="master-image bg-danger col-md-5">
                        <img src="{{$master->file_path}}" class="card-img-top" alt="{{$master->name}}"></img>
                    </div>
                    <div class="card-body card--body align-center d-block">
                        <div class="d-flex gap-4 justify-content-center align-center mt-5 mb-2">
                            <div>
                                <h5 class="card-title text-danger"><b>{{$master->name}} {{$master->surname}}</b></h5>
                                <p class="card-text">At the moment is working in <b>{{$salon->name}}</b>.</p>
                            </div>
                            <div class="col-3">
                                <a href="{{route('front-salons')}}" class="btn btn-outline-danger">Go back to salons list</a>
                            </div>
                            <div class="col-3">
                                <a href="{{route('front-salon-masters', $salon->id)}}" class="btn btn-outline-danger">Go back to this salon masters</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="flex">
                                <label class="rating--sum" for="comment">Rating: <b>{{$rating}}</b></label>
                                <div class=" rating-form rating--form">
                                    @for($i = 1; $i < 6; $i++) <div class="rating-item">
                                        <svg class="rating-star rating--star {{$i}}" data-rating="{{$i}}">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="flex">
                            <form method="post" action="{{route('front-comment-store', $master->id)}}">
                                <label for="comment">Write a comment</label>
                                <textarea name="comment" style="height:120px" rows="4" cols="50" wrap="off" id="comment" class="col-12 mb-2"></textarea>
                                <input type="hidden" name="master_id" value="{{$master->id}}">
                                @csrf
                                @method('post')
                                <button type="submit" class="btn btn-danger">Submit</button>
                                <a href="{{route('front-comments-list', [$master->id])}}" class="btn btn-outline-danger" style="margin-left:20px">Read comments</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="service--box">
            <div>
                <h4 class="card-header text-body">
                    <b>Choose service</b>
                </h4>
                <div class="card-body text-body">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col-1"></th>
                                <th scope="col-6">Service</th>
                                <th scope="col-2">Duration</th>
                                <th scope="col-3">Price</th>
                            </tr>
                        </thead>
                        @forelse ($procedures as $procedure)
                        <tr valign="middle">
                            <thead class="appointment--form align-middle procedures">
                                <td><input type="radio" name="procedure" value="{{$procedure->id}}"></td>
                                <td><label class="procedure--id" for="{{$procedure->id}}">{{$procedure->ruby_service}}</label></td>
                                <td>{{floor($procedure->minutes / 60)}}h. {{$procedure->minutes - (floor($procedure->minutes / 60))* 60}} min.</td>
                                <td>{{$procedure->price}} eur.</td>
                            </thead>
                        </tr>
                        @empty
                        <div>We are sorry, at the moment there is no services we can offer for you.</div>
                        @endforelse
                    </table>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-danger d-flex align-center center procedure--chosen">
                <span>Choose time<span>
                    <svg class="chevron">
                        <use xlink:href="#chevron"></use>
                    </svg>
                </button>
            </div>
        </div>
        <div class="callendar--box d-none">
            <h4 class="card-header text-body">
                Choose time for <b></b>
            </h4>
            <div class="card-body text-body callendar--include">
                @include('parts.callendar')
            </div>
            <div class="callendar--btn--box d-flex align-center justify-content-center center d-none">
                <button type="submit" class="btn btn-outline-danger back--to--procedures back">           
                    <svg class="chevron left">
                        <use xlink:href="#chevron"></use>
                    </svg>
                   <span>Back to procedures<span>
                </button>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
