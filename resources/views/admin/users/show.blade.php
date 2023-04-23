@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col ml-3">
                    <div class="text">
                        
                        <br>
                        <h3>
                        <a href="{{ URL::previous() }}"> <i style="font-size: 0.73em;" class="fas fa-arrow-alt-circle-left"></i> </a>
                             <b>{{$user->name}}
                                 <a href="{{route('admin.users.edit', $user)}}" role="button" class="btn btn-sm btn-outline-primary">{{__('showuser.edit')}}
                                  <i class="ml-2 fas fa-lg fa-user-cog"></i>
                                </a>

                                @php
                                $authuser = Auth::user();
                                $userstatus = $user->status;
                                if ($authuser->id != $user->id) {
                                    $sus='1';
                                }
                                else {
                                    $sus='2';
                                }
                                @endphp

                                @if ($authuser->office == "AO2")
                               
                                @if ($userstatus == 'suspended')

                                <a href="{{route('admin.users.removesuspend', $user)}}" role="button" class="btn btn-sm btn-outline-success">{{__('showuser.activate')}}
                                    <i class="ml-2 fas fa-lg fa-check-circle"></i>
                                </a>
                                @endif
                          
                                @if ($userstatus !== 'suspended' && $sus=='1')

                                <a href="{{route('admin.users.suspend', $user)}}" role="button" class="btn btn-sm btn-outline-warning">{{__('showuser.suspend')}}
                                    <i  class="ml-2 fas fa-lg fa-minus-circle"></i>
                                </a>
                                @endif
                                @endif



                            </b>
                         </h3>
                        
                    </div>
                </div>

                @if ($authuser->superadmin == "yes")
                @if ($sus =='1')
                <div class="col ml-3">
                    <div class="mr-2 text-right">
                     
                        <br>
                        <h3>

                                <a href="{{route('admin.users.edit', $user)}}" role="button" data-toggle="modal" data-target="#myModal{{$user->id}}" class="btn btn-sm btn-outline-danger">{{__('showuser.delete')}}
                                    <i class="ml-2 fas fa-lg fa-user-times"></i>
                                </a>

                            </b>
                         </h3>
                     
                    </div>
                </div>
                @endif
@endif



            </div>
            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{__('showuser.personalInformation')}}</h4>
                        <p class="card-category"></p>
                      </div>
                      <div class="card-body">
                          
                        <div class="row">
                            <div class="col">
                                <strong>{{__('showuser.fullName')}}: </strong> {{$user->name}}
                                <br>
                                <!-- <strong>{{__('showuser.birthDate')}}: </strong> {{$user->birth_date}}
                                <br> -->
                                <strong>{{__('showuser.email')}}: </strong> {{$user->email}}
                                <br>
                                <strong>{{__('showuser.employeeId')}}: </strong> {{$user->employee_number}}
                                <br>
                                <strong>{{__('showuser.contractType')}}: </strong> {{__("databaseLeaves.$user->contract")}}
                                <br>
                                <strong>{{__('showuser.office')}}: </strong> {{$user->office}}
                                
                              </div>
                              <div class="col">
                                <strong>{{__('showuser.position')}}: </strong> {{$user->position}}
                                <br>
                                <strong>{{__('showuser.department')}}: </strong> {{$user->department}}
                                <br>
                                <strong>{{__('showuser.grade')}}: </strong> {{$user->grade}}
                                <br>
                                <strong>{{__('showuser.joinedDate')}}: </strong> {{$user->joined_date}}
                                <br>
                              <strong>{{__('showuser.lineManager')}}: </strong> {{$user->linemanager}}
                              </div>
                        </div>
                      
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('showuser.additionlInformation')}}</h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                           
                          <div class="row">
                              <div class="col">
                                    @php
                                    if ($user->usertype_id == "2") {
                                      $role = "Line Manager";
                                    }
                                    else {
                                        $role = "Staff";
                                    }
                                    @endphp
                                  <strong>{{__('showuser.role')}}</strong> <small> ({{__('showuser.staffOrLineManager')}})</small>: {{$role}}
                                  <br>
                                  @php
                                      if ($user->hradmin == "yes") {
                                      $admin = "Admin";
                                    }

                                    else {
                                        $admin = "Not Admin";
                                    }
                                  @endphp
                                  <strong>{{__('showuser.permissionInHrSystem')}}:</strong> {{$admin}}
                                </div>
                                <div class="col">
                                  <strong>{{__('showuser.userCreatedOnSystemAt')}}:</strong> {{$user->created_at}}
                                  <br>
                                  <strong>{{__('showuser.infoLastUpdated')}}:</strong> {{$user->updated_at}}
                                </div>
                          </div>
                         
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header card-header-primary ">
                          <h4 class="mt-1 card-title mr-2 ">{{__('showuser.remainingBalance')}}</h4>

                          
                          @if ($authuser->superadmin == "yes")
                          
                            <div class="col-12 text-left ">
                              <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="mb-0 btn btn-sm btn-outline-primary">{{__('showuser.edit')}}  <i class="ml-2  fas fa-lg fa-list-ol"></i></a>
                            </div>
                          
                          @endif
           

                        </div>
                        <div class="card-body">
               
                          <div class="row">
                              <div class="col">
                              @if ($user->contract == "Service")
                              <strong>{{__('showuser.annualLeave')}}:</strong> {{$balance1}}
                              <br>
                                  <strong>{{__('showuser.compansetion')}}:</strong> {{$balance18}}

                              @endif
                                  
                                  @if ($user->contract !== "Service")
                                  <strong>{{__('showuser.annualLeave')}}:</strong> {{$balance1}}
                                  <br>
                                  

                                  <strong>{{__('showuser.sickLeave')}}:</strong> {{$balance2}}
                                  <br>
                                  <strong>{{__('showuser.sickLeave30%Deduction')}}:</strong> {{$balance3}}
                                    <br>
                                    <strong>{{__('showuser.sickLeave20%Deduction')}}:</strong> {{$balance4}}
                                    <br>
                                  <strong>{{__('showuser.marriageLeave')}}:</strong> {{$balance5}}
                                    <br>
                                    <strong>{{__('showuser.welfareLeave')}}:</strong> {{$balance12}}
                                </div>

                                <div class="col">
                                    <strong>{{__('showuser.unpaidLeave')}}:</strong> {{$balance15}}
                                    <br>
                                    <strong>{{__('showuser.maternityLeave')}}:</strong> {{$balance8}}
                                    <br>
                                    <strong>{{__('showuser.paternityLeave')}}:</strong> {{$balance9}}
                                    <br>
                                  <strong>{{__('showuser.compassionateSecondDegree')}}:</strong> {{$balance7}}
                                  <br>
                              
                                  <strong>{{__('showuser.compassionateFirstDegree')}}:</strong> {{$balance6}}
                                  <br>
                                  <strong>{{__('showuser.compansetion')}}:</strong> {{$balance18}}
                                  </div>
                                  @endif

                          </div>
                </div>
                
            </div>
            <br>

            
            <div class="container-fluid">
                      <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title "><strong>{{$user->name}}</strong> Leaves</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">

                        <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                            <tr style=" background-color: #ffb678 !important;">
                                <th style="width: 5%" scope="col">{{__('staffleaves.id-Leave')}}</th>
                               
                                <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.leaveType')}}</th>
                                <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.startDate')}}</th>
                                <th style="width: 20%"  class="text-center"scope="col">{{__('staffleaves.endDate')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.days')}}</th>
                                <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.status')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffLeaves.lineManager')}}</th>
                                <!-- <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.dateCreated')}}</th> -->
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                                <td><a href="{{ route('leaves.show', encrypt($leave->id)) }}" >{{ $leave->id }}</a></td>
                             
                                <td class="text-center">{{ $leave->leavetype->name }}</td>
                              @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                              <td class="text-center">{{__("databaseLeaves.$startdayname")}} {{ $leave->start_date }}</td>
                              <td class="text-center">{{__("databaseLeaves.$enddayname")}} {{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{ $leave->status }}</td>
                              <td class="text-center">{{ $leave->user ? $leave->lmapprover : '-' }}</td>
                              <!-- <td class="text-center"> {{ $leave->created_at }}</td> -->
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
                      <h4 class="card-title "><strong>{{$user->name}}</strong> Overtimes</h4>
                        {{-- <p class="card-category"> Here you can manage users</p> --}}
                      </div>
                      <div class="card-body table-responsive-md">

                      <table id="table_idd" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                      <thead>
                          <tr style=" background-color: #ffb678 !important;">
                          <th style="width: 10%" scope="col">{{__('staffleaves.id-Overtime')}}</th>
                             
                              <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.overtimeType')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.date')}}</th>
                              <th style="width: 10%"  class="text-center"scope="col">{{__('staffleaves.startHour')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.endHour')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.hours')}}</th>
                              <th style="width: 5%" class="text-center" scope="col">{{__('allStaffOvertimes.hours')}}<small>({{__('allStaffOvertimes.value')}})</small></th>
                              <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.status')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.lineManager')}}</th>
                              <!-- <th style="width: 15%" class="text-center" scope="col">{{__('staffleaves.dateCreated')}}</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($overtimes as $overtime)
                          <tr>
                            <td><a href="{{ route('overtimes.show', encrypt($overtime->id)) }}" >{{ $overtime->id }}</a></td>
                            
                            <td class="text-center">{{ $overtime->type }}</td>
                            @php
                              $dayname = Carbon\Carbon::parse($overtime->date)->format('l');
                              @endphp
                            <td class="text-center">{{__("databaseLeaves.$dayname")}} {{ $overtime->date }}</td>
                            <td class="text-center">{{ $overtime->start_hour }}</td>
                            <td class="text-center">{{ $overtime->end_hour }}</td>
                            <td class="text-center">{{ $overtime->hours }}</td>
                            <td class="text-center">{{ $overtime->value }}</td>
                            <td class="text-center">{{ $overtime->status }}</td>
                            <td class="text-center">{{ $overtime->lmapprover }}</td>
                            <!-- <td class="text-center"> {{ $overtime->created_at }}</td> -->
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                      </div>
                    </div>
                </div>






<div id="myModal{{$user->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 style="color: red" class="modal-title">{{__('showuser.Attention')}}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>{{__('showuser.sure')}}: <br><strong>{{$user->name}}</strong>.</p>
@php
    if ($user->name != Auth::user()->name)
    {
        $variablee='1';

    }

    else
    {
        $variablee ='2';
    }
@endphp

@if ($variablee=='2')
          <strong style="color: red">Logged in user can't be deleted<br> </strong> <br>

          {{-- <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="text-center" >
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete">
            </div>
        </form> --}}
        @endif
        @if ($variablee=='1')
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="text-center" >
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete">
            </div>
        </form>
        @endif
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('showuser.cancel')}}</button>
        </div>

      </div>

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

      $('#table_id').DataTable(
        {
            "order": [[ 0, "desc" ]],
            
        }
    );

    $('#table_idd').DataTable(
        {
            "order": [[ 0, "desc" ]]
        }
    );



      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
  <script>

    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function () {
      myInput.focus()
    });
    </script>
@endpush
