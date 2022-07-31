<div class="d-flex">
    <div class="callendar-blade">
        <div class="card-header text-body ">
            <div class="">
                <b>{{$year}}</b>
            </div>
            <div class="callendar-controls ">
                <span class="previous--month">Previous</span>
                <h4 class="now--month" data-month="{{$thisMonth[2][5][1]}}">{{$monthName}}</h4>
                <span class="next--month">Next</span>
            </div>
        </div>
        <div class="card-body align-center callendar-row">
            <table class="table table-borderless callendar">
                <thead>
                    <tr class="w3-theme">
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <thead>
                    @foreach ($thisMonth as $key => $week)
                    <tr>
                        @foreach($week as $key => $day)
                        <td>
                            <button data-time-data="{{$day[1]}}" class="date 
                                @if($todayDay['year'] == $year 
                                    && $todayDay['month'] == $monthNum
                                    && $todayDay['day'] ==$day[0]) 
                                    bg-danger 
                                @endif 
                                @if (!is_int($key / 7) && !is_int(($key + 1) / 7)) week--day  @endif
                                @if (is_int($key / 7)) bg-warning  no-hover @endif
                                @if (is_int(($key + 1)/ 7)) bg-secondary no-hover @endif
                    ">
                                {{$day[0]}}
                            </button>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </thead>
            </table>
        </div>
    </div>
    <div class=" callendar-blade day--appointments">
    </div>
</div>