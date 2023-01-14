@extends('layouts.app')
@section('content')
<div class="container col-12 col-sm-11 p-0 p-sm-1 col-md-9 col-lg-8 mt-5">
        <div class="card border-danger mb-3 p-1 p-md-3">
            <h4 class="card-header text-body">
                <b>Our Services</b>
            </h4>
            <div class="card-body text-body">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    <tbody>
                        </thead>
                        @forelse ($procedures as $procedure)
                        <tr valign="middle" class="mb-2">
                            <td>{{$procedure->ruby_service}}</td>
                            <td>{{floor($procedure->minutes / 60)}}h. {{$procedure->minutes - (floor($procedure->minutes / 60))* 60}} min.</td>
                            <td>{{$procedure->price}} eur.</td>
                            <td class="d-flex flex-column flex-sm-row gap-2">
                                <a href="{{route('procedures-edit', $procedure)}}" class="btn btn-secondary">Edit</a>
                                <form action="{{route('procedures-delete', $procedure)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection
