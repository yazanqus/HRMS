@extends('layouts.app', ['activePage' => 'createuser', 'titlePage' => ('users create')])

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
                        <h4 class="card-title ">Create new user</h4>
                        {{-- <p class="card-category"> Here you can manage users</p> --}}
                      </div>

                    <div class="card-body table-responsive-md">
                        <div class="container py-3 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                              <div class="col-12 col-lg-10 col-xl-10">
                                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                  <div class="card-body p-4 p-md-5">
                                    <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">User information</h3>
                                  <form class="form-outline" action="{{ route('admin.users.store') }}" method="POST">
                                      @csrf
                                      <div class="row justify-content-between text-left">
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Name</label> <input class="form-control form-outline" type="text" id="name"  name="name" placeholder=""> </div>
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Birth Date</label> <input class="form-control form-outline" type="date" name="birth_date" id="birth_date" placeholder="" > </div>
                                      </div>
                                      <div class="row justify-content-between text-left">
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Position</label> <input class="form-control form-outline" type="text" id="position"  name="position" placeholder="" > </div>
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Grade</label> <input class="form-control form-outline" type="text" id="grade"  name="grade" placeholder="" > </div>
                                      </div>
                                      <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label  px-1">Join Date</label> <input class="form-control form-outline" type="date" name="joined_date" id="joined_date" placeholder="" > </div>
                                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label  px-1">Employee ID</label> <input class="form-control form-outline" type="text" name= "employee_number" autocomplete="off" id="employee_number"  placeholder="" > </div>
                                      </div>
                                      <div class="row justify-content-between text-left">
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Line Manager</label><input class="form-control form-outline" type="text" list="FavoriteColor" id="color"
                                            name="linemanager" autocomplete="off">
                                        <datalist id="FavoriteColor">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"> </option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">HR admin <small>(Permission on HRMS)</small></label> <div class="form-check">
                                            <input  class="btn-check" type="radio" name="hradmin" Value="no" id="test1">
                                            <label class="form-check-label" for="test1">
                                              Not Admin
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="hradmin" Value="yes" id="test2" >
                                            <label class="form-check-label" for="test2">
                                              Admin
                                            </label>
                                          </div> </div>
                                      </div>
                                      <div class="row justify-content-between text-left">
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Email</label> <input class="form-control form-outline"  type="email" id="email"  name="email" autocomplete="off" placeholder="" > </div>
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Password <small>(When signing using Employee ID)</small></label> <input class="form-control form-outline"  type="password" id="password" autocomplete="off" name="password" autocomplete="off" placeholder="" > </div>
                                      </div>
                                      {{-- MUST ADD requirepd for radio check --}}
                                      <div class="row justify-content-center">
                                          <div class="form-group col-sm-3"> <button type="submit" class="btn-block btn-primary">Create</button> </div>
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

                    {{-- <div class="container-fluid">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Add a new Employee</h4>
                            </div>
                            <div class="container py-5 h-100">
                                <div class="row justify-content-center align-items-center h-100">
                                    <div class="col-12 col-lg-10 col-xl-10">
                                        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                            <div class="card-body p-4 p-md-5">
                                                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Onboarding details</h3>
                                                <form action="{{ route('admin.users.store') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-outline">
                                                                <input type="text"
                                                                    class="form-control form-control-lg{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                                    name="name" />
                                                                <label class="form-label">Name</label>
                                                                @if ($errors->has('name'))
                                                                    <span id="name-error" class="error text-danger"
                                                                        for="input-name">{{ $errors->first('name') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-outline">
                                                                <input type="date" name="birth_date"
                                                                    class="form-control form-control-lg {{$errors->has('birth_date') ? 'is-invalid' : ''}}"/>
                                                                <label class="form-label">Birth date</label>
                                                                @if($errors->has('birth_date'))
                                                                  <span id="birth_date-error" class ="error text-danger"
                                                                    for="input-birth_date">{{$errors->first('birth_date')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-outline">
                                                                <input type="text" name="unit"
                                                                    class="form-control form-control-lg {{$errors->has('unit') ? 'is-invalid' : ''}}" />
                                                                <label class="form-label">Unit</label>
                                                                @if($errors->has('unit'))
                                                                <span id="unit-error" class ="error text-danger"
                                                                  for="input-unit">{{$errors->first('unit')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-outline">
                                                                <input type="text" name="position"
                                                                    class="form-control form-control-lg {{$errors->has('position' ? 'is-invalid' : '')}}" />
                                                                <label class="form-label">Position</label>
                                                                @if($errors->has('position'))
                                                                <span id="position-error" class ="error text-danger"
                                                                  for="input-position">{{$errors->first('position')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-group">
                                                                <input type="text" list="FavoriteColor" id="color"
                                                                    name="linemanager" autocomplete="off">
                                                                <datalist id="FavoriteColor">
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->name }}"> </option>
                                                                    @endforeach
                                                                </datalist>
                                                                </p>

                                                                <label class="form-label">Line Manager</label>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-outline">
                                                                <input type="Radio" name="hradmin" Value="yes"
                                                                    class="form-control form-control-lg" />Yes
                                                                <input type="Radio" name="hradmin" Value="no"
                                                                    class="form-control form-control-lg" Checked />No
                                                                <label class="form-label">HR Admin on the system</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-outline">
                                                                <input type="date" name="joined_date"
                                                                    class="form-control form-control-lg {{$errors->has('joined-date' ? 'is-invalid' : '')}}" />
                                                                <label class="form-label">Joined Date</label>
                                                                @if($errors->has('joined_date'))
                                                                <span id="joined_date-error" class ="error text-danger"
                                                                  for="input-joined_date">{{$errors->first('joined_date')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-outline">
                                                                <input type="text" name="employee_number"
                                                                    class="form-control form-control-lg {{$errors->has('employee_number' ? 'is-invalid' : '') }}" />
                                                                <label class="form-label">Employee Number</label>
                                                                @if($errors->has('employee_number'))
                                                                <span id="employee_number-error" class ="error text-danger"
                                                                  for="input-employee_number">{{$errors->first('employee_number')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-6">
                                                            <div class="form-outline">
                                                                <input type="password" name="password"
                                                                    class="form-control form-control-lg {{$errors->has('password' ? 'is-invalid' : '')}}" />
                                                                <label class="form-label">Password</label>
                                                                @if($errors->has('password'))
                                                                <span id="password-error" class ="error text-danger"
                                                                  for="input-password">{{$errors->first('password')}}</span>
                                                                @endif
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
                    </div> --}}


        </div>
    </div>
@endsection
