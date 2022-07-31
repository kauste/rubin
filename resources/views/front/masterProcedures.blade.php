@extends('layouts.app')
@section('content')
<div class="container col-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <div class="card col-12 flex mb-5">
                <div class="master-image bg-danger col-5">
                    <img src="{{$master->file_path}}" class="card-img-top" alt="{{$master->name}}"></img>
                </div>
                <div class="card-body align-center d-block">
                    <div class="d-flex mt-5 mb-2">
                        <div>
                            <h5 class="card-title text-danger"><b>{{$master->name}} {{$master->surname}}</b></h5>
                            <p class="card-text">At the moment is working in <b>{{$salon->name}}</b>.</p>
                        </div>
                        <div class="flex-end-column">
                            <a href="{{route('front-salons')}}" class="btn btn-outline-danger">Go back to salons list</a>
                        </div>
                        <div class="flex-end-column ">
                            <a href="{{route('front-salon-masters', $salon->id)}}" class="btn btn-outline-danger">Go back to this salon masters</a>
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
            <div class="callendar--include">
            @include('parts.callendar')
            </div>
            <h4 class="card-header text-body">
                <b>Services</b>
            </h4>
            <div class="card-body text-body">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col-4">Service</th>
                            <th scope="col-3">Duration</th>
                            <th scope="col-3">Price</th>
                            <th class="flex-end" scope="col-2">Amount</th>
                            <th scope="col-1"></th>
                        </tr>
                    </thead>
                    @forelse ($procedures as $procedure)
                    <tr valign="middle">
                        <form action="" method="post">
                            <td><label for="{{$procedure->ruby_service}}">{{$procedure->ruby_service}}</label></td>
                            <td>{{floor($procedure->minutes / 60)}}h. {{$procedure->minutes - (floor($procedure->minutes / 60))* 60}} min.</td>
                            <td>{{$procedure->price}} eur.</td>

                            <td class="flex-end"><input class="col-3" type="number" min="0" step="1"></td>
                            @csrf
                            @method('post')
                            <td><button type="submit" class="btn btn-danger col-12">Add to cart</button></td>

                        </form>
                    </tr>
                    @empty
                    <div>We are sorry, at the moment there is no services we can offer for you.</div>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
