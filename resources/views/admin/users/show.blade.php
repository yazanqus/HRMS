@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col ml-3">
                    <div class="text">
                        {{-- @foreach ($users as $user) --}}
                        <br>
                        <h3>
                             <b>{{$user->name}}
                                 <a href="{{route('admin.users.edit', $user)}}" role="button" class="btn btn-sm btn-outline-primary">Edit
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
                                {{-- @if ($authuser->id !== $userid) --}}
                                @if ($userstatus == 'suspended')

                                <a href="{{route('admin.users.removesuspend', $user)}}" role="button" class="btn btn-sm btn-outline-success">Activate
                                    <i class="ml-2 fas fa-lg fa-check-circle"></i>
                                </a>
                                @endif
                                {{-- @endif --}}
                                @if ($userstatus !== 'suspended' && $sus=='1')

                                <a href="{{route('admin.users.suspend', $user)}}" role="button" class="btn btn-sm btn-outline-warning">Suspend
                                    <i class="ml-2 fas fa-lg fa-minus-circle"></i>
                                </a>
                                @endif



                            </b>
                         </h3>
                        {{-- @endforeach --}}
                    </div>
                </div>

                <div class="col ml-3">
                    <div class="mr-2 text-right">
                        {{-- @foreach ($users as $user) --}}
                        <br>
                        <h3>

                                <a href="{{route('admin.users.edit', $user)}}" role="button" data-toggle="modal" data-target="#myModal{{$user->id}}" class="btn btn-sm btn-outline-danger">Delete
                                    <i class="ml-2 fas fa-lg fa-user-times"></i>
                                </a>

                            </b>
                         </h3>
                        {{-- @endforeach --}}
                    </div>
                </div>




            </div>
            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">Personal information</h4>
                        <p class="card-category"></p>
                      </div>
                      <div class="card-body">
                          {{-- <div class="row">
                              <div   div class="col-12 text-right">
                                <a href="{{route('admin.users.edit', $user)}}" class="btn btn-sm btn-primary">Edit</a>
                              </div>
                          </div> --}}
                        <div class="row">
                            <div class="col">
                                <strong>Full Name: </strong> {{$user->name}}
                                <br>
                                <strong>Birth date: </strong> {{$user->birth_date}}
                                <br>
                                <strong>Email: </strong> {{$user->email}}
                                <br>
                                <strong>Employee ID: </strong> {{$user->employee_number}}
                              </div>
                              <div class="col">
                                <strong>Position: </strong> {{$user->position}}
                                <br>
                                <strong>Grade: </strong> {{$user->grade}}
                                <br>
                                <strong>Joined Date: </strong> {{$user->joined_date}}
                                <br>
                              <strong>Line Manager: </strong> {{$user->linemanager}}
                              </div>
                        </div>
                        {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">Additionl information</h4>
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
                                    @php
                                    if ($user->usertype_id == "2") {
                                      $role = "Line Manager";
                                    }
                                    else {
                                        $role = "Staff";
                                    }
                                    @endphp
                                  <strong>Role</strong> <small>(Staff or Line Manger)</small>: {{$role}}
                                  <br>
                                  @php
                                      if ($user->hradmin == "yes") {
                                      $admin = "Admin";
                                    }

                                    else {
                                        $admin = "Not Admin";
                                    }
                                  @endphp
                                  <strong>Permission in HR System:</strong> {{$admin}}
                                </div>
                                <div class="col">
                                  <strong>User Created on System at:</strong> {{$user->created_at}}
                                  <br>
                                  <strong>Info last updated:</strong> {{$user->updated_at}}
                                </div>
                          </div>
                          {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-header card-header-primary ">
                          <h4 class="mt-1 card-title mr-2 ">Leaves - Remaining balance</h4>
                          <div class="col-12 text-left ">
                            <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="mb-0 btn btn-sm btn-outline-primary">Edit  <i class="ml-2  fas fa-lg fa-list-ol"></i></a>
                          </div>
                          {{-- <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="btn btn-sm btn-outline-primary">Edit  <i class="ml-2 fas fa-lg fa-user-cog"></i></a> --}}

                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div   div class="col-12 text-right">
                                  <a href="#" class="btn btn-sm btn-primary">Add Holiday</a>
                                </div>
                            </div> --}}
                          <div class="row">
                              <div class="col">
                                  <strong>Annual Leave:</strong> {{$balance1}}
                                  <br>
                                  <strong>Sick leave:</strong> {{$balance2}}
                                  <br>
                                  <strong>Sick leave 30% deduction:</strong> {{$balance3}}
                                    <br>
                                    <strong>Sick leave 20% deduction</strong> {{$balance4}}
                                    <br>
                                  <strong>Marriage leave:</strong> {{$balance5}}
                                    <br>
                                    <strong>Welfare leave:</strong> {{$balance12}}
                                </div>

                                <div class="col">
                                    <strong>Unpaid leave:</strong> {{$balance15}}
                                    <br>
                                    <strong>Maternity leave:</strong> {{$balance8}}
                                    <br>
                                    <strong>Paternity leave:</strong> {{$balance9}}
                                    <br>
                                  <strong>Compassionate - Second degree:</strong> {{$balance7}}
                                  <br>
                                {{-- <strong>Annual Leave:</strong> {{$balance1}}
                                  <br> --}}
                                  <strong>Compassionate - First degree:</strong> {{$balance6}}
                                  <br>
                                  <strong>Compansetion:</strong> {{$balance18}}
                                  </div>

                          </div>
                </div>
            </div>

            <div class="card">
                <!-- <div class="card-header card-header-primary">
                    {{-- <a href="/storage/files/{{$holiday->name}}.pdf" target="_blank">{{ $holiday->name }}</a> --}}
                  <h4 class="card-title ">

                <a href="{{route('admin.users.allstaffattendance',$user)}}" target="_blank">Attendances</a>

                    </h4>
                  <p class="card-category"></p>
                </div> -->

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



<div id="myModal{{$user->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 style="color: red" class="modal-title">Attention!</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete: <br><strong>{{$user->name}}</strong>.</p>
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
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
  {{-- <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script> --}}
  <script>

    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function () {
      myInput.focus()
    });
    </script>
@endpush
