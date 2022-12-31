@extends('layouts.app', ['activePage' => 'my-leaves', 'titlePage' => ('all leaves')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mb-6">
                    <div class="text">
                      
                    </div>
                </div>
            </div>
            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{__('leaveShow.leaveDetails')}}</h4>
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
                            <strong>{{__('leaveShow.leaveId')}}: </strong> {{$leave->id}}
                                <br>
                                <strong>{{__('leaveShow.leaveStatus')}}: </strong> {{__("databaseLeaves.$leave->status")}}
                                <br>
                                @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                                <strong>{{__('leaveShow.leaveStartDate')}}: </strong>{{__("databaseLeaves.$startdayname")}} {{$leave->start_date}}
                                <br>
                                <strong>{{__('leaveShow.leaveEndDate')}}: </strong>{{__("databaseLeaves.$enddayname")}} {{$leave->end_date}}
                              </div>
                              <div class="col">

                                <strong>{{__('leaveShow.leaveDays')}}: </strong> {{$leave->days}}
                                  <br>
                                  <strong>{{__('leaveShow.leaveHours')}}: </strong> {{$leave->hours}}
                                  <br>
                                  <strong>{{__('leaveShow.leaveType')}}: </strong> {{ __("databaseLeaves.{$leave->leavetype->name}") }}
                                  <br>
                                  <strong>{{__('leaveShow.leaveCreationDate')}}: </strong> {{$leave->created_at}}

                              </div>
                        </div>
                        {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('leaveShow.leaveReason')}}</h4>
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
                                  <strong>{{$leave->reason}}</strong>
                                </div>

                          </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header card-header-primary">
                    {{-- <a href="/storage/files/{{$holiday->name}}.pdf" target="_blank">{{ $holiday->name }}</a> --}}
                  <h4 class="card-title ">
                    @php
                    if (isset($leave->path))
                    {
                        $variableee='1';

                    }

                    else
                    {
                        $variableee ='2';
                    }
                @endphp
                @if ($variableee=='1')

                <a href="/storage/leaves/{{basename($leave->path)}}" target="_blank">{{__('leaveShow.attachment')}}</a>
                @endif
                @if ($variableee == '2')
                {{__('leaveShow.noAttachment')}}
                @endif
                    </h4>
                  <p class="card-category"></p>
                </div>

    </div>

    <div class="card">
    <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('leaveShow.approvalWorlflowCurrentStatus')}}: <strong>{{__("databaseLeaves.$leave->status")}}</strong></h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                    
                          <div class="row">
                              <div class="col">
                              {{__('leaveShow.submittedBy')}}: <strong>{{$leave->user->name}}</strong>
                                  <br>
                                  {{__('leaveShow.approved')}}/{{__('leaveShow.declined')}} {{__('leaveShow.by')}} {{__('leaveShow.lineManager')}}: <strong>{{$leave->lmapprover}}</strong> - "<i>{{$leave->lmcomment}}</i>"
                                  <br>
                                  @if ($leave->exapprover != null)
                                  {{__('leaveShow.approved')}}/{{__('leaveShow.declined')}} {{__('leaveShow.by')}} {{__('leaveShow.extra')}}: <strong>{{$leave->exapprover}}</strong> - "<i>{{$leave->excomment}}</i>"
                                  <br>
                                  @endif
                                  {{__('leaveShow.approved')}}/{{__('leaveShow.declined')}} {{__('leaveShow.by')}} {{__('leaveShow.hr')}}: <strong>{{$leave->hrapprover}}</strong> - "<i>{{$leave->hrcomment}}</i>"
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
