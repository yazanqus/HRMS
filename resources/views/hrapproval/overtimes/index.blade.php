@extends('layouts.app', ['activePage' => 'hrovertimesapproval', 'titlePage' => ('hrovertimesapproval')])

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

                  <div class="container-fluid">
                          <div class="card">
                            <div class="card-header card-header-primary">
                              <h4 class="card-title ">{{__('hrApprovalOvertime.overtimesPendingHrApproval')}}</h4>
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
                                  <th style="width: 3%" scope="col">{{__('hrApprovalOvertime.id')}}</th>
                                    <th style="width: 3%" scope="col">{{__('hrApprovalOvertime.name')}}</th>
                                    @if ($hruser->office == "AO2")
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.office')}}</th>
                                    @endif
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.type')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.date')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.startHour')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.endHour')}}</th>
                                    <th class="text-center"scope="col">{{__('hrApprovalOvertime.hours')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.status')}}</th>
                                    <th class="text-center" scope="col ">{{__('hrApprovalOvertime.approve')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.decline')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($overtimes as $overtime)
                                <tr>
                                    <td><a href="{{ route('overtimes.show', encrypt($overtime->id)) }}" >{{ $overtime->id }}</a></td>
                                    <td>{{ $overtime->user->name }}</td>
                                    @if ($hruser->office == "AO2")
                                  <td class="text-center">{{ $overtime->user->office }}</td>
                                    @endif
                                    <td class="text-center">{{ $overtime->type }}</td>
                                  <td class="text-center">{{ $overtime->date }}</td>
                                  <td class="text-center">{{ $overtime->start_hour }}</td>
                                  <td class="text-center">{{ $overtime->end_hour }}</td>
                                  <td class="text-center">{{ $overtime->hours }}</td>
                                  <td class="text-center">{{ $overtime->status }}</td>
                                  <td class="text-center">
                                      <a id="buttonSelector" class="btn btn-success"
                                      href="{{route('overtimes.hrapproved',$overtime->id)}}">Approve</a>
                                    </td>
                                    <td class="text-center">
                                        <a id="buttonSelector" class="btn btn-danger" href="{{route('overtimes.hrdeclined',$overtime->id)}}">Decline</a>
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
