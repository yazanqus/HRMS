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
                        <h4 class="card-title ">{{__('overtimeshow.overtimeDetails')}}</h4>
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
                                <strong>{{__('overtimeshow.overtimeId')}}: </strong> {{$overtime->id}}
                                <br>
                                <strong>{{__('overtimeshow.overtimeStatus')}}: </strong> {{__("databaseLeaves.$overtime->status")}}
                                <br>
                                @php
                              $dayname = Carbon\Carbon::parse($overtime->date)->format('l');
                              @endphp
                                <strong>{{__('overtimeshow.overtimeDate')}}: </strong>{{__("databaseLeaves.$dayname")}} {{$overtime->date}}
                                <br>
                                <strong>{{__('overtimeshow.overtimestarthour')}}: </strong> {{$overtime->start_hour}}
                                <br>
                                <strong>{{__('overtimeshow.overtimeendhour')}}: </strong> {{$overtime->end_hour}}
                              </div>
                              <div class="col">

                                <strong>{{__('overtimeshow.overtimeHours')}}: </strong> {{$overtime->hours}}
                                  <br>
                                  <strong>{{__('overtimeshow.overtimeType')}}: </strong> {{__("databaseLeaves.$overtime->type")}}
                                  <br>
                                  <strong>{{__('overtimeshow.overtimeCreationDate')}}: </strong> {{$overtime->created_at}}

                              </div>
                        </div>
                        {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('overtimeshow.overtimeReason')}}</h4>
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

                <a href="/storage/overtimes/{{basename($overtime->path)}}" target="_blank">{{__('overtimeshow.attachment')}}</a>
                @endif
                @if ($variableee == '2')
                {{__('overtimeshow.noAttachment')}}
                @endif
                    </h4>
                  <p class="card-category"></p>
                </div>

    </div>

    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('overtimeshow.approvalWorlflowCurrentStatus')}} <strong>{{__("databaseLeaves.$overtime->status")}}</strong></h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            
                          <div class="row">
                              <div class="col">
                              {{__('overtimeshow.submittedBy')}}: <strong>{{$overtime->user->name}}</strong>
                                  <br>
                                  {{__('overtimeshow.approved')}}/{{__('overtimeshow.declined')}} {{__('overtimeshow.by')}} {{__('overtimeshow.lineManager')}}: <strong>{{$overtime->lmapprover}}</strong> - "<i>{{$overtime->lmcomment}}</i>"
                                  <br>
                                  {{__('overtimeshow.approved')}}/{{__('overtimeshow.declined')}} {{__('overtimeshow.by')}} {{__('overtimeshow.hr')}}: <strong>{{$overtime->hrapprover}}</strong>
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
