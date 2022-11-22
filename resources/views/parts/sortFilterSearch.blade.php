  <h5 class="card-header">Sort filter search</h5>
  <div class="card-body">
      <div class="d-flex flex-column flex-lg-row justify-content-between">
          <div class="col-lg-6"">
              <form method="get" action="{{route('back-confirmed-orders')}}" class="input-group mb-3">
                  <div class="input-group-append col-3 col-sm-2 col-lg-auto">
                      <label class="input-group-text" for="sort">Sort by:</label>
                  </div>
                  <select class="custom-select border-danger col-7 col-md-5 col-lg-auto" name="sort" id="sort">
                      <option value="default" @if($sort==='default' ) selected @endif>Default</option>
                      <option value="date-asc" @if($sort==='date-asc' ) selected @endif>Date, earlyest first</option>
                      <option value="date-desc" @if($sort==='date-desc' ) selected @endif>Date, latest first</option>
                      <option value="appointment-id-asc" @if($sort==='appointment-id-asc' ) selected @endif>Appointment id, smallest first</option>
                      <option value="appointment-id-desc" @if($sort==='appointment-id-desc' ) selected @endif>Appointment id, biggest first</option>
                  </select>
                  <div class="input-group-append col-2 col-lg-auto">
                      <button class="btn btn-danger" type="submit">Go!</button>
                  </div>
              </form>
          </div>
          <div class="col-lg-6">
              <form method="get" action="{{route('back-confirmed-orders')}}" class="input-group mb-3">
                  <div class="input-group-append col-3 col-sm-2 col-lg-auto">
                      <label class="input-group-text" for="filter">Filter by:</label>
                  </div>
                  <select class="custom-select border-danger col-7 col-md-5 col-lg-auto" name="filter" id="filter">
                      <option value="0" @if($filter==0) selected @endif>No filter</option>
                      @foreach($masters as $master)
                      <option value="{{$master->id}}" @if($filter==$master->id) selected @endif>{{$master->name}} {{$master->surname}}</option>
                      @endforeach
                  </select>
                  <div class="input-group-append col-lg-auto">
                      <button class="btn btn-danger" type="submit">Go!</button>
                  </div>
              </form>
          </div>
      </div>
      <div>
          <form method="get" action="{{route('back-confirmed-orders')}}" class="input-group mb-3 align-middle">
              <div class="input-group-append col-3 col-sm-2 col-lg-auto">
                  <label class="input-group-text" for="s">Search:</label>
              </div>
              <input type="text" class="form-control col-7 col-lg-auto" id="s" name="s" value="{{$s}}">
              <div class="input-group-append col-2 col-lg-auto">
                  <button class="btn btn-danger" type="submit">Go!</button>
              </div>
          </form>
      </div>
  </div>
