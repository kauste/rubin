<div class="card-header callendar-blade align-center">
    <div class="row">
        <b>{{$data}}</b>
    </div>
</div>
<div class="card-body align-center callendar-row">
    <divclass="table table-borderless callendar">
        <div class="row">
            @foreach ($scheduleTime as $halfHour)
            <div class="col-3 callendar-day">{{$halfHour}}</div>
            @endforeach
        </div>
    </table>
</div>
