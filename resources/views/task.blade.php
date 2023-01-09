@extends('layouts.app')
@section('content')
<div class="container col-10 col-xl-8 mt-2">
    <div class="d-flex align-items-center col-12 justify-content-end gap-3">
        <form class="d-flex gap-2 align-items-center" action="{{route('mail')}}" method="post">
            <label class="col-form-label" for="ëmail">Ask for login data</label>
                <input class="form-control input-danger-focus border" name="email" type="email" id="email" placeholder="Your email" required></input>
                @csrf
                <button class="btn btn-danger" type="submit">Send</button>
        </form>
    <a class="text-black" href="https://github.com/kauste/rubin" target="_blank">See the code</a>
    </div>
    <div class="row mt-5">
        <div class="card border-danger mb-3 m-3 p-3">
            <h1 class="card-header text-body bg-danger d-flex justify-content-center">
                <b>Beauty salon</b>
            </h1>
            <div class="card-body text-body">
                <div class="p-3 d-flex justify-content-center">
                    <div class="border-bottom border-danger">Create a web platform where customers can order beauty services.</div>
                </div>
                <div class="d-flex justify-content-center gap-5">
                    <div class="card col-5">
                        <h3 class="card-header text-body">
                            <b>Administration area</b>
                        </h3>
                        <div class="card-body text-body">
                            <ul class="task-list">
                                <li>View, creation, editing and deletion of <b>beauty salon</b> <i>address, name, phone number</i></li>
                                <li>View, creation, editing and deletion of <b>service</b> <i>name, duration, price</i></li>
                                <li>View, creation, editing and deletion of <b>master</b> <i>name, surname, last name, salon where he works (from the list in point 1)</i>. The ability to see the assessment of the master.</li>
                                <li>Ability to view, confirm or cancel user <b>orders</b>.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card col-5">
                        <h3 class="card-header text-body">
                            <b>User area</b>
                        </h3>
                        <div class="card-body text-body">
                            <ul class="task-list">
                                <li>Choose a salon, a master working in that salon, a service from the lists, then order the service by specifying the date and time</li>
                                <li>To evaluate the master</li>
                                <li>See the list of masters and filter them by salon name.</li>
                                <li>See your orders and their status (whether confirmed or canceled) and the possibility to cancel yourself.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
