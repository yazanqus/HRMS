@extends('layouts.app', ['activePage' => 'overtime', 'titlePage' => ('overtime')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mb-6">
                    <div class="text">
                        {{-- @foreach ($users as $user) --}}
                        {{-- <h3>Welcome <b>{{$user->name}}</b> </h3> --}}
                        {{-- @endforeach --}}
                    </div>
                </div>
            </div>
            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">Overtime Details</h4>
                        <p class="card-category"></p>
                      </div>
                      <div class="card-body">
                          {{-- <div class="row">
                              <div   div class="col-12 text-right">
                                <a href="#" class="btn btn-sm btn-primary">Add Holiday</a>
                              </div>
                          </div> --}}
                        <div class="row">
                            <div class="col">
                                <strong>Overtime ID: </strong> {{$overtime->id}}
                                <br>
                                <strong>Overtime Status: </strong> {{$overtime->status}}
                                <br>
                                <strong>Overtime Date: </strong> {{$overtime->date}}
                                <br>
                                <strong>Overtime Start Hour: </strong> {{$overtime->start_hour}}
                                <br>
                                <strong>Overtime End Hour: </strong> {{$overtime->end_hour}}
                              </div>
                              <div class="col">

                                <strong>Overtime hours: </strong> {{$overtime->hours}}
                                  <br>
                                  <strong>Overtime Type: </strong> {{$overtime->type}}
                                  <br>
                                  <strong>Overtime Creation Date: </strong> {{$overtime->created_at}}

                              </div>
                        </div>
                        {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">Overtime reason</h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div   div class="col-12 text-right">
                                  <a href="#" class="btn btn-sm btn-primary">Add Holiday</a>
                                </div>
                            </div> --}}
                          <div class="row">
                              <div class="col">
                                  <strong>{{$overtime->reason}}</strong>
                                </div>

                          </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header card-header-primary">
                    {{-- <a href="/storage/files/{{$holiday->name}}.pdf" target="_blank">{{ $holiday->name }}</a> --}}
                  <h4 class="card-title ">
                    @php
                    if (isset($overtime->path))
                    {
                        $variableee='1';

                    }

                    else
                    {
                        $variableee ='2';
                    }
                @endphp
                @if ($variableee=='1')

                <a href="/storage/overtimes/{{basename($overtime->path)}}" target="_blank">Attachement</a>
                @endif
                @if ($variableee == '2')
                No Attachement
                @endif
                    </h4>
                  <p class="card-category"></p>
                </div>

    </div>

    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">Approval workflow - Current status: <strong>{{$overtime->status}}</strong></h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            
                          <div class="row">
                              <div class="col">
                              Submitted by: <strong>{{$overtime->user->name}}</strong>
                                  <br>
                                  Approved/Declined by Line manager: <strong>{{$overtime->lmapprover}}</strong>
                                  <br>
                                  Approved/Declined by HR: <strong>{{$overtime->hrapprover}}</strong>
                                </div>

                          </div>
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Leaves - Taken</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col">
                          <strong>Annual Leave:</strong> {{$balance1}}
                          <br>
                          <strong>Sick leave:</strong> {{$balance2}}

                        </div>

                  </div>
        </div>
    </div> --}}
        </div>
    </div>
    </div>
</div>
@endsection

@push('js')
  {{-- <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script> --}}
@endpush
