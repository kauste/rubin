@extends('layouts.app')
@section('content')
<div class="container col-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <div class="card col-12 flex mb-5">
                <div class="master-image bg-danger col-5">
                    <img src="{{ asset('img/'.$master->file_path) }}" class="card-img-top" alt="{{$master->salon_name}}"></img>
                </div>
                <div class="card-body align-center d-block">
                    <div class="d-flex mt-5 mb-2">
                        <div>
                            <h5 class="card-title text-danger"><b>{{$master->name}} {{$master->surname}}</b></h5>
                            <p class="card-text">At the moment is working in <b>{{$master->salon_name}}</b>.</p>
                        </div>
                        <div class="flex-end-column">
                            <a href="{{route('front-salons')}}" class="btn btn-outline-danger">Go back to salons list</a>
                        </div>
                        <div class="flex-end-column ">
                            <a href="{{route('front-salon-masters', $master->id)}}" class="btn btn-outline-danger">Go back to this salon masters</a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <form action="{{route('front-comment-store', $master->id)}}" method="post">
                            <label for="comment">Write a comment</label>
                            <textarea name="comment" style="height:120px" rows="4" cols="50" wrap="off" id="comment" class="col-12 mb-2"></textarea>
                            <input type="hidden" name="master_id" value="{{$master->id}}">
                            @csrf
                            @method('post')
                            <button type="submit" class="btn btn-danger">Submit</button>
                            <a href="{{route('front-salon-master', $master->id)}}" class="btn btn-outline-danger" style="margin-left:20px">Go back to this master appointments<a>
                        </form>

                    </div>

                </div>
            </div>
            <div class="container col-12 mt-2">
                <div class="row">
                    <div class="list-group p-4 bg-danger" style="display:inline-block">
                        @forelse($comments as $comment)

                        <a class="list-group-item list-group-item-action " style="float:left; width:45%; margin:1.5%">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-1 text-danger"><b>{{$comment->user_name}}</b></h5>
                                <div>{{$comment->comment_created_at}}</div>
                            </div>
                            <p class="mb-1">{{$comment->comment}}</p>
                            @empty
                            <div>No comments added yet</div>
                        </a>

                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
