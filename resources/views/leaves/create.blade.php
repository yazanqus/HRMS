@extends('layouts.app', ['activePage' => 'createleave', 'titlePage' => ('creating leave')])

@section('content')
  <div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title ">New Leave</h4>
                    <p class="card-category">Submit a new leave</p>
                </div>
                    <div class="container py-5 h-100">
                      <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-10 col-xl-10">
                          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">New Leave</h3>
                              <form action="{{ route('leaves.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                  <div class="col-md-6 mb-6">

                                    <div class="form-outline">
                                      <input type="date" name="start_date" class="form-control form-control-lg" />
                                      <label class="form-label" >Start date</label>
                                    </div>

                                  </div>

                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="date" name="end_date" class="form-control form-control-lg" />
                                        <label class="form-label" >End date</label>
                                      </div>

                                    </div>

                                    <div class="col-md-6 mb-6">

                                        <div class="form-outline">
{{--
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Action
                                                </button>
                                                <div class="dropdown-menu">
                                                  <a class="dropdown-item" href="#">Action</a>
                                                  <a class="dropdown-item" href="#">Another action</a>
                                                  <a class="dropdown-item" href="#">Something else here</a>
                                                  <div class="dropdown-divider"></div>
                                                  <a class="dropdown-item" href="#">Separated link</a>
                                                </div>
                                              </div>


                                              <div class="btn-group">
                                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Action
                                                </button>
                                                <div class="dropdown-menu">
                                                  <a class="dropdown-item" href="#">Action</a>
                                                  <a class="dropdown-item" href="#">Another action</a>
                                                  <a class="dropdown-item" href="#">Something else here</a>
                                                  <div class="dropdown-divider"></div>
                                                  <a class="dropdown-item" href="#">Separated link</a>
                                                </div>
                                              </div>

                                              <div class="btn-group">
                                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Action
                                                </button>
                                                <div class="dropdown-menu">
                                                  <a class="dropdown-item" href="#">Action</a>
                                                  <a class="dropdown-item" href="#">Another action</a>
                                                  <a class="dropdown-item" href="#">Something else here</a>
                                                  <div class="dropdown-divider"></div>
                                                  <a class="dropdown-item" href="#">Separated link</a>
                                                </div>
                                              </div> --}}

                                            <select
                                            class="form-control{{ $errors->has('room_id') ? ' is-invalid' : '' }}"
                                            name="leavetype_id" id="input-room_id" type="text"
                                            placeholder="{{ __('Leave Type') }}"
                                            required>
                                            @foreach ($leavetypes as $leavetype)
                                                <option value="{{ $leavetype->id }}"> {{$leavetype->name}} </option>
                                            @endforeach
                                        </select>

                                        </div>

                                      </div>

                                </div>

                                {{-- <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Room') }}</label>
                                    <div class="col-sm-7">
                                      <div class="form-group{{ $errors->has('room_id') ? ' has-danger' : '' }}">
                                        <select
                                        class="form-control{{ $errors->has('room_id') ? ' is-invalid' : '' }}"
                                        name="room_id" id="input-room_id" type="text"
                                        placeholder="{{ __('Room') }}"
                                        required>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}"> {{$room->number}} </option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('room_id'))
                                          <span id="room_id-error" class="error text-danger" for="input-room_id">{{ $errors->first('room_id') }}</span>
                                        @endif
                                      </div>
                                    </div>
                                  </div> --}}

                                {{-- <div class="row">
                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="text" name="unit" class="form-control form-control-lg" />
                                        <label class="form-label" >Unit</label>
                                      </div>

                                    </div>

                                      <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="text" name="position" class="form-control form-control-lg" />
                                          <label class="form-label" >Position</label>
                                        </div>

                                      </div>

                                 </div> --}}
                                  <br>
                                  {{-- <div class="row">
                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="date" name="joined_date" class="form-control form-control-lg" />
                                        <label class="form-label" >Joined Date</label>
                                      </div>

                                    </div>

                                    <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="text" name="employee_number" class="form-control form-control-lg" />
                                          <label class="form-label" >Employee Number</label>
                                        </div>

                                      </div>

                                 </div> --}}



                                <div class="mt-4 pt-2">
                                  <input class="btn btn-primary btn-lg" type="submit" value="Add" />
                                </div>

                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>



            </div>
          </div>


    </div>
  </div>
@endsection
