@extends('layouts.app', ['activePage' => 'staffleaves', 'titlePage' => ('staffleaves')])

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
                        <h4 class="card-title ">{{__('staffleaves.myStaff')}}</h4>
                          {{-- <div class="col-12 text-right">
                            <a href="{{route('leaves.create')}}" class="btn btn-sm btn-primary">Submit a new Leave</a>
                          </div> --}}
                      </div>
                      <div class="card-body table-responsive-md">

                        <div class="row">
                      <table class="table table-hover table-responsive text-nowrap table-Secondary">
                      <thead>
                          <tr>
                            <th style="width: 10%" scope="col">{{__('staffleaves.name')}}</th>
                            <th style="width: 10%" scope="col">{{__('staffleaves.birthDate')}}</th>
                            <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.email')}}</th>
                            <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.employeeNumber')}}</th>
                            <th style="width: 30%" class="text-center" scope="col">{{__('staffleaves.position')}}</th>
                            <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.joinedDate')}}</th>

                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                          <tr>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>{{ $user->birth_date }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ $user->employee_number }}</td>
                            <td class="text-center">{{ $user->position }}</td>
                            <td class="text-center">{{ $user->joined_date }}</td>

                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->

                </div>


                  <div class="container-fluid">
                      <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('staffleaves.myStaffLeaves')}}</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">

                        <table id="table_id" class="table table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                            <tr>
                            <th scope="col">{{__('staffleaves.id-Leave')}}</th>
                                <th scope="col">{{__('staffleaves.name')}}</th>
                                <th class="text-center" scope="col">{{__('staffleaves.leaveType')}}</th>
                                <th class="text-center" scope="col">{{__('staffleaves.startDate')}}</th>
                                <th  class="text-center"scope="col">{{__('staffleaves.endDate')}}</th>
                                <th class="text-center" scope="col">{{__('staffleaves.days')}}</th>
                                <th class="text-center" scope="col">{{__('staffleaves.status')}}</th>
                                <th class="text-center" scope="col">{{__('staffleaves.dateCreated')}}</th>
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
                              <td class="text-center"> {{ $leave->created_at }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                        </div>
                      </div>
                  </div>

                  <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{__('staffleaves.myStaffOvertime')}}</h4>
                        {{-- <p class="card-category"> Here you can manage users</p> --}}
                      </div>
                      <div class="card-body table-responsive-md">

                      <table id="table_idd" class="table table-bordered table-hover text-nowrap table-Secondary table-striped">
                      <thead>
                          <tr>
                          <th scope="col">{{__('staffleaves.id-Overtime')}}</th>
                              <th scope="col">{{__('staffleaves.name')}}</th>
                              <th class="text-center" scope="col">{{__('staffleaves.overtimeType')}}</th>
                              <th class="text-center" scope="col">{{__('staffleaves.date')}}</th>
                              <th  class="text-center"scope="col">{{__('staffleaves.startHour')}}</th>
                              <th class="text-center" scope="col">{{__('staffleaves.endHour')}}</th>
                              <th class="text-center" scope="col">{{__('staffleaves.hours')}}</th>
                              <th class="text-center" scope="col">{{__('staffleaves.status')}}</th>
                              <th class="text-center" scope="col">{{__('staffleaves.dateCreated')}}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($overtimes as $overtime)
                          <tr>
                            <td><a href="{{ route('overtimes.show', $overtime) }}" >{{ $overtime->id }}</a></td>
                            <td>{{ $overtime->user ? $overtime->user->name : 'Deleted User' }}</td>
                            <td class="text-center">{{ $overtime->type }}</td>
                            <td class="text-center">{{ $overtime->date }}</td>
                            <td class="text-center">{{ $overtime->start_hour }}</td>
                            <td class="text-center">{{ $overtime->end_hour }}</td>
                            <td class="text-center">{{ $overtime->hours }}</td>
                            <td class="text-center">{{ $overtime->status }}</td>
                            <td class="text-center"> {{ $overtime->created_at }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                      </div>
                    </div>
                </div>
                <br>


              </div>
          </div>
 @endsection


 @push('scripts')

  <!-- DataTables  & Plugins -->


  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>


  <script>
    $(document).ready( function () {
    $('#table_id').DataTable(
        {
            "order": [[ 7, "desc" ]]
        }
    );
    $('#table_idd').DataTable(
        {
            "order": [[ 8, "desc" ]]
        }
    );
} );
  </script>
@endpush
