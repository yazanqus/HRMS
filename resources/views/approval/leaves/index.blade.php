@extends('layouts.app', ['activePage' => 'leavesapproval', 'titlePage' => ('leavesapproval')])

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
                              <h4 class="card-title ">{{__('leaveApproval.leavesPendingYourApproval')}}</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>
                            <div class="card-body table-responsive-md ">
                              <div class="row">
                            <table class="table table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                <th scope="col">{{__('leaveApproval.id')}}</th>
                                    <th scope="col">{{__('leaveApproval.name')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.leaveType')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.startDate')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.endDate')}}</th>
                                    <th  class="text-center"scope="col">{{__('leaveApproval.days')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.status')}}</th>
                                    <th class="text-center" scope="col ">{{__('leaveApproval.approve')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.decline')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($leaves as $leave)
                                <tr>
                                    <td><a href="{{ route('leaves.show', $leave) }}" >{{ $leave->id }}</a></td>
                                  <td>{{ $leave->user->name }}</td>
                                  <td class="text-center">{{ $leave->leavetype->name }}</td>
                                  <td class="text-center">{{ $leave->start_date }}</td>
                                  <td class="text-center">{{ $leave->end_date }}</td>
                                  <td class="text-center">{{ $leave->days }}</td>
                                  <td class="text-center">{{ $leave->status }}</td>
                                  <td class="text-center">
                                      <a id="buttonSelector" class="btn btn-success"
                                      href="{{route('leaves.approved',$leave->id)}}">{{__('leaveApproval.approve')}}</a>
                                    </td>
                                    <td class="text-center">
                                        <a id="buttonSelector" class="btn btn-danger" href="{{route('leaves.declined',$leave->id)}}">{{__('leaveApproval.decline')}}</a>
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
