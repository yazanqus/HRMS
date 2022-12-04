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
                            <div class="card-body table-responsive-md ">
                              <div class="row">
                            <table class="table table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                <th scope="col">{{__('hrApprovalLeave.id')}}</th>
                                    <th scope="col">{{__('hrApprovalLeave.name')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalLeave.leaveType')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalLeave.startDate')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalLeave.endDate')}}</th>
                                    <th  class="text-center"scope="col">{{__('hrApprovalLeave.days')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalLeave.status')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalLeave.approve')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalLeave.decline')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($leaves as $leave)
                                <tr>
                                    <td><a href="{{ route('leaves.show', $leave) }}" target="_blank">{{ $leave->id }}</a></td>
                                  <td>{{ $leave->user->name }}</td>
                                  <td class="text-center">{{ $leave->leavetype->name }}</td>
                                  <td class="text-center">{{ $leave->start_date }}</td>
                                  <td class="text-center">{{ $leave->end_date }}</td>
                                  <td class="text-center">{{ $leave->days }}</td>
                                  <td class="text-center">{{ $leave->status }}</td>
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
                              </div>
                            </div>
                          </div>
                  </div>
              </div>
          </div>
 @endsection

 @push('scripts')

<script>

$(document).ready(function() {

  

    $(document).on('click', '#buttonSelector', function () {
    $(this).addClass('disabled');
});

});

</script>

@endpush

