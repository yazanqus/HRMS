@extends('layouts.app', ['activePage' => 'hrleavesapproval', 'titlePage' => ('hrleavesapproval')])

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
                @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif
                  <div class="container-fluid">
                          <div class="card">
                            <div class="card-header card-header-primary">
                              <h4 class="card-title ">{{__('hrApprovalLeave.leavesPendinHrApproval')}}</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>

                            @php
                            $hruser = Auth::user();
                            @endphp
                            <div class="card-body table-responsive-md ">
                              <!-- <div class="row"> -->
                              <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                            <thead>
                                <tr>
                                <th style="width: 10%" scope="col">{{__('hrApprovalLeave.id')}}</th>
                                    <th style="width: 20%" scope="col">{{__('hrApprovalLeave.name')}}</th>
                                    @if ($hruser->office == "AO2")
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.office')}}</th>
                                    @endif
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.leaveType')}}</th>
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.startDate')}}</th>
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.endDate')}}</th>
                                    <th  style="width: 10%" class="text-center"scope="col">{{__('hrApprovalLeave.days')}}</th>
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.status')}}</th>
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.approve')}}</th>
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.decline')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($leaves as $leave)
                                <tr>
                                  <td><a href="{{ route('leaves.show', encrypt($leave->id)) }}" target="_blank">{{ $leave->id }}</a></td>
                                  <td>{{ $leave->user->name }}</td>
                                  @if ($hruser->office == "AO2")
                                  <td class="text-center">{{ $leave->user->office }}</td>
                                    @endif
                                  <td class="text-center">{{ __("databaseLeaves.{$leave->leavetype->name}") }}</td>
                                  @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                                  <td class="text-center">{{__("databaseLeaves.$startdayname")}} {{ $leave->start_date }}</td>
                                  <td class="text-center">{{__("databaseLeaves.$enddayname")}} {{ $leave->end_date }}</td>
                                  <td class="text-center">{{ $leave->days }}</td>
                                  <td class="text-center">{{__("databaseLeaves.$leave->status")}}</td>
                                  <td class="text-center">
                                      <a id="buttonSelector" class=" btn btn-success"
                                      href="{{route('leaves.hrapproved',$leave->id)}}">Approve</a>
                                    </td>
                                    <td class="text-center">
                                        <a id="buttonSelector" class=" btn btn-danger" href="{{route('leaves.hrdeclined',$leave->id)}}">Decline</a>
                                    </td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                              <!-- </div> -->
                            </div>
                          </div>
                  </div>
              </div>
          </div>
 @endsection

 @push('scripts')
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<script>

$(document).ready(function() {

    $('#table_id').DataTable(
        {
            "order": [[ 0, "desc" ]],
            
        }
    );

    $(document).on('click', '#buttonSelector', function () {
    $(this).addClass('disabled');
});

});

</script>

@endpush

