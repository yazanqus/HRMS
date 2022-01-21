@extends('layouts.app', ['activePage' => 'create-new-user', 'titlePage' => ('users create')])

@section('content')
  <div class="content">
    <div class="container-fluid">



        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title ">{{$user->name}}</h4>
                    <p class="card-category">Edit information</p>
                </div>

                    <div class="container py-5 h-100">
                      <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-10 col-xl-10">
                          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">User information</h3>

                              {{-- this can be used for create user --}}

                              {{-- <form class="form-card" action="{{ route('admin.users.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">First name<span class="text-danger"> *</span></label> <input type="text" id="fname" name="fname" placeholder="Enter your first name" onblur="validate(1)"> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Last name<span class="text-danger"> *</span></label> <input type="text" id="lname" name="lname" placeholder="Enter your last name" onblur="validate(2)"> </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Business email<span class="text-danger"> *</span></label> <input type="text" id="email" name="email" placeholder="" onblur="validate(3)"> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Phone number<span class="text-danger"> *</span></label> <input type="text" id="mob" name="mob" placeholder="" onblur="validate(4)"> </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Job title<span class="text-danger"> *</span></label> <input type="text" id="job" name="job" placeholder="" onblur="validate(5)"> </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-12 flex-column d-flex"> <label class="form-control-label px-3">What would you be using Flinks for?<span class="text-danger"> *</span></label> <input type="text" id="ans" name="ans" placeholder="" onblur="validate(6)"> </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="form-group col-sm-6"> <button type="submit" class="btn-block btn-primary">Request a demo</button> </div>
                                </div>
                            </form> --}}

                            <form class="form-card" action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Name</label> <input type="text" id="name" value="{{$user->name}}" name="name" placeholder=""> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Birth Date</label> <input type="date" id="birth_date" value="{{$user->birth_date}}" name="birth_date" placeholder="" > </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Employee ID</label> <input type="text" id="employee_id"  value="{{$user->employee_number}}" name="employee_number" placeholder="" > </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Join Date</label> <input type="date" id="joined_date" value="{{$user->joined_date}}" name="joined_date" placeholder="" > </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Unit</label> <input type="text" id="unit" value="{{$user->unit}}" name="unit" placeholder="" > </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-3">Position</label> <input type="text" id="position" value="{{$user->position}}" name="position" placeholder="" > </div>
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
                                                    @foreach ($users as $user)
                                                        <option value="{{$user->name}}"> </option>
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
                                            <input class="btn-check" type="radio" name="hradmin" Value="1" id="test1">
                                            <label class="form-check-label" for="test1">
                                              Not Admin
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input class="btn-check" type="radio" name="hradmin" Value="2" id="test2" >
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


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title ">{{$user->name}}</h4>
                    <p class="card-category">Edit information</p>
                </div>
                    <div class="container py-5 h-100">
                      <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-10 col-xl-10">
                          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">User information
                              </h3>
                              <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                  <div class="col-md-6 mb-6">

                                    <div class="form-outline">
                                      <input type="text" name="name" class="form-control form-control-lg" />
                                      <label class="form-label" >Name</label>
                                    </div>

                                  </div>

                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="date" name="birth_date" class="form-control form-control-lg" />
                                        <label class="form-label" >Birth date</label>
                                      </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="text" name="unit" class="form-control form-control-lg" />
                                        <label class="form-label" >Unit</label>
                                      </div>

                                    </div>

                                      <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="text" name="position" class="form-control form-control-lg" />
                                          <label class="form-label" >Position</label>
                                        </div>

                                      </div>

                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-md-6 mb-6">

                                        <div class="form-group">
                                            <input type="text" list="FavoriteColor" id="color" name="linemanager" autocomplete="off">

                                                <datalist id="FavoriteColor">
                                                    @foreach ($users as $user)

                                                        <option value="{{$user->name}}"> </option>

                                                    @endforeach

                                                </datalist>
                                                </p>




                                            {{-- <select

                                            class="form-control"
                                            name="linemanager" id="input-room_id" type="text"
                                            placeholder="{{ __('Line Manager') }}"
                                            required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"> {{$user->name}} </option>
                                            @endforeach
                                        </select> --}}
                                        <label class="form-label" >Line Manager</label>

                                          </div>


                                      {{-- <div class="form-outline">
                                        <input type="text" name="linemanager" class="form-control form-control-lg" />
                                        <label class="form-label" >Line Manager</label>
                                      </div> --}}

                                    </div>

                                    <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="Radio" name="hradmin" Value="yes" class="form-control form-control-lg" />Yes
                                          <input type="Radio" name="hradmin" Value="no" class="form-control form-control-lg" Checked/>No
                                          <label class="form-label" >HR Admin on the system</label>
                                        </div>

                                      </div>




                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="date" name="joined_date" class="form-control form-control-lg" />
                                        <label class="form-label" >Joined Date</label>
                                      </div>

                                    </div>

                                    <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="text" name="employee_number" class="form-control form-control-lg" />
                                          <label class="form-label" >Employee Number</label>
                                        </div>

                                      </div>

                                      <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="password" name="password" class="form-control form-control-lg" />
                                          <label class="form-label" >Password</label>
                                        </div>

                                      </div>

                                  </div>



                                <div class="mt-4 pt-2">
                                  <input class="btn btn-primary btn-lg" type="submit" value="Add" />
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
