@extends('layouts.app', ['activePage' => 'overtimesapproval', 'titlePage' => ('overtimesapproval')])

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
                              <h4 class="card-title ">{{__('overtimeApproval.overtimesPendingYourApproval')}}</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>
                            <div class="card-body table-responsive-md ">
                              <div class="row">
                            <table class="table table-responsive  table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                    <th style="width: 3%" scope="col">{{__('overtimeApproval.id')}}</th>
                                    <th style="width: 3%" scope="col">{{__('overtimeApproval.name')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.overtimeType')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.date')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.startHour')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.endHour')}}</th>
                                    <th  class="text-center"scope="col">{{__('overtimeApproval.hours')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.status')}}</th>
                                    <th class="text-center" scope="col ">{{__('overtimeApproval.approve')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.decline')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($overtimes as $overtime)
                                <tr>
                                    <td><a href="{{ route('overtimes.show', encrypt($overtime->id)) }}" >{{ $overtime->id }}</a></td>
                                  <td>{{ $overtime->user->name }}</td>
                                  <td class="text-center">{{ $overtime->type }}</td>
                                  <td class="text-center">{{ $overtime->date }}</td>
                                  <td class="text-center">{{ $overtime->start_hour }}</td>
                                  <td class="text-center">{{ $overtime->end_hour }}</td>
                                  <td class="text-center">{{ $overtime->hours }}</td>
                                  <td class="text-center">{{ $overtime->status }}</td>
                                  <td class="text-center">
                                      <a id="buttonSelector" class="btn btn-success"
                                      href="{{route('overtimes.approved',$overtime->id)}}">Approve</a>
                                    </td>
                                    <td class="text-center">
                                        <a id="buttonSelector" class="btn btn-danger" href="{{route('overtimes.declined',$overtime->id)}}">Decline</a>
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
