@extends('layouts.app')
@section('content')
<div class="container col-8 mt-5">
    <div class="row">
        <div class="card border-danger mb-3 m-3 p-3">
            <h4 class="card-header text-body">
                <b>Our Services</b>
            </h4>

            <div class="card-body text-body">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col-4">Service</th>
                            <th scope="col-3">Duration</th>
                            <th scope="col-3">Price</th>
                        </tr>
                    <tbody>
                        </thead>
                        @forelse ($procedures as $procedure)
                        <tr valign="middle">
                            <td>{{$procedure->ruby_service}}</td>
                            <td>{{floor($procedure->minutes / 60)}}h. {{$procedure->minutes - (floor($procedure->minutes / 60))* 60}} min.</td>
                            <td>{{$procedure->price}} eur.</td>
                            <td class="col-1">
                                <a href="{{route('procedures-edit', $procedure)}}" class="btn btn-secondary">Edit</a>
                            </td>
                            <td class="col-1">
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
</div>
@endsection
