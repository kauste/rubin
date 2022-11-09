<div class="card-header callendar-blade align-center">
    <div class="row">
        <b class="appointment--date">{{$date}}</b>
    </div>
</div>
<div class="card-body align-center">
    <div>
        <h5 class="card-header text-body">
            Masters' free time this day
        </h5>
        <div class="card-body text-body">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col-2">Starts</th>
                        <th scope="col-5">Ends</th>
                    </tr>
                </thead>
                <div class="row">
                    @foreach ($freeTimes as $key => $freeTime)
                    <tr valign="middle">
                        <thead>
                            <td class="free--time--starts">{{$freeTime[0]}}</td>
                            <td class="free--time--ends">{{$freeTime[1]}}</td>
                        </thead>
                    </tr>
                    @endforeach
                </div>
            </table>
        </div>
    </div>
</div>
<div class="card-body align-center">
    <div>
        <h5 class="card-header text-body">
            Availible appointments for this procedure
        </h5>
        <div class="card-body text-body">
            <table class="table table-borderless availible--appointments">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col-2">Starts</th>
                        <th scope="col-5">Ends</th>
                    </tr>
                </thead>
                <div class="row">
                    @foreach ($appointmentTimes as $appointmentTime)
                    <tr valign="middle">
                        <thead>
                            <td><input class="free--time" type="radio" id="{{$key}}" name="free-time" value="{{$key}}" /></td>
                            <td class="appointment--starts">{{$appointmentTime[0]}}</td>
                            <td class="appointment--ends">{{$appointmentTime[1]}}</td>
                        </thead>
                    </tr>
                    @endforeach
                </div>
            </table>
            <div class="d-flex justify-content-center center">
                <button type="button" class="btn btn-danger col-8 add--to--cart">Add to cart</button>
            </div>
        </div>
    </div>
</div>
