@extends('layouts.app', ['activePage' => 'create-new-user', 'titlePage' => ('users create')])

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
                        <h4 class="card-title ">Edit User information</h4>
                      </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">{{$user->name}}</h3>
                                    <form class="form-card" action="{{ route('admin.users.update',$user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Name</label> <input type="text" id="name" value="{{$user->name}}" name="name" placeholder=""> </div>
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Birth Date</label> <input type="date" id="birth_date" value="{{$user->birth_date}}" name="birth_date" placeholder="" > </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Position</label> <input type="text" id="position" value="{{$user->position}}" name="position" placeholder="" > </div>
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Grade</label> <input type="text" id="grade" value="{{$user->grade}}" name="grade" placeholder="" > </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Join Date</label> <input type="date" id="joined_date" value="{{$user->joined_date}}" name="joined_date" placeholder="" > </div>
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Employee ID</label> <input type="text" id="employee_id"  value="{{$user->employee_number}}" name="employee_number" placeholder="" > </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Grade</label> <input type="text" id="grade" value="{{$user->grade}}" name="grade" placeholder="" > </div>
                                            @php
                                        if ($user->usertype_id == '1') {
                                          $role = "Staff";
                                        }
                                        elseif ($user->usertype_id == '2') {
                                          $role = "Line Manager";
                                        }
                                        else {
                                            $role = "undefined";
                                        }
                                            @endphp
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-3">Role <small>(Currently: {{$role}})</small></label>
                                                <div class="form-check">
                                                    <input class="btn-check" type="radio" name="usertype_id" Value="1" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                      Staff
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input class="btn-check" type="radio" name="usertype_id" Value="2" id="flexCheckChecked">
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                      Line Manager
                                                    </label>
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-3">Line Manager</label>
                                                <input type="text" list="FavoriteColor" id="linemanager"  value="{{$user->linemanager}}" name="linemanager" placeholder="" autocomplete="off">
                                                        <datalist id="FavoriteColor">
                                                            @foreach ($userss as $userr)
                                                                <option value="{{$userr->name}}"> </option>
                                                            @endforeach
                                                        </datalist>
                                                        </p>
                                        </div>
                                        @php
                                        if ($user->hradmin == 'no') {
                                          $admin = "Not admin";
                                        }
                                      elseif ($user->hradmin == 'yes') {
                                          $admin = "Admin";
                                        }
                                        else {
                                            $admin = "Undefined";
                                        }
                                            @endphp
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-3">Role <small>(Currently: {{$admin}})</small></label>
                                                <div class="form-check">
                                                    <input class="btn-check" type="radio" name="hradmin" Value="no" id="test1">
                                                    <label class="form-check-label" for="test1">
                                                      Not Admin
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input class="btn-check" type="radio" name="hradmin" Value="yes" id="test2" >
                                                    <label class="form-check-label" for="test2">
                                                      Admin
                                                    </label>
                                                  </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Email</label> <input type="email" id="email" value="{{$user->email}}" name="email" autocomplete="off" placeholder="" > </div>
                                        </div>
                                        {{-- MUST ADD requirepd for radio check --}}
                                        <div class="row justify-content-center">
                                            <div class="form-group col-sm-3"> <button type="submit" class="btn-block btn-primary">Update Staff Info</button> </div>
                                            <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.users.index')}}" >Cancel</a> </div>
                                        </div>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>








    </div>
  </div>
@endsection
