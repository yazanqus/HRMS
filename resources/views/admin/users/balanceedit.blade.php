@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

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
                        <h4 class="card-title ">Edit User Leave Balances</h4>
                      </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5"><strong>{{$user->name}}</strong> Leave Balances:</h3>
                                    <form class="form-card" action="{{ route('admin.users.update',$user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Annual Leave:</label>
                                                <input class="form-control form-outline " type="text" id="name" value="{{$balance1}}" name="name" placeholder="">

                                            </div>
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Unpaid leave:</label>
                                                <input class="form-control form-outline" type="text" id="birth_date" value="{{$balance15}}" name="birth_date" placeholder="" >
                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label px-1">Sick leave:</label>
                                                  <input class="form-control form-outline" type="text" id="position" value="{{$balance2}}" name="position" placeholder="" >
                                                 </div>
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label px-1">Maternity leave:</label>
                                                 <input class="form-control form-outline" type="text" id="grade" value="{{$balance8}}" name="grade" placeholder="" >
                                                 </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">Sick leave 30% Deduction:</label>
                                                <input class="form-control form-outline " type="text" id="joined_date" value="{{$balance3}}" name="joined_date" placeholder="" >

                                            </div>
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">Paternity leave:</label>
                                                <input class="form-control form-outline " type="text" id="employee_id"  value="{{$balance9}}" name="employee_number" placeholder="" >

                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">Sick leave 20% Deduction:</label>
                                                <input class="form-control form-outline " type="text" id="joined_date" value="{{$balance4}}" name="joined_date" placeholder="" >

                                            </div>
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">Compassionate - Second degree:</label>
                                                <input class="form-control form-outline " type="text" id="employee_id"  value="{{$balance7}}" name="employee_number" placeholder="" >

                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">Marriage leave:</label>
                                                <input class="form-control form-outline " type="text" id="joined_date" value="{{$balance5}}" name="joined_date" placeholder="" >

                                            </div>
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">Compassionate - First degree:</label>
                                                <input class="form-control form-outline " type="text" id="employee_id"  value="{{$balance6}}" name="employee_number" placeholder="" >

                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">Welfare leave:</label>
                                                <input class="form-control form-outline " type="text" id="joined_date" value="{{$balance12}}" name="joined_date" placeholder="" >

                                            </div>
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">Compansetion:</label>
                                                <input class="form-control form-outline " type="text" id="employee_id"  value="{{$balance18}}" name="employee_number" placeholder="" >

                                            </div>
                                        </div>
                                        {{-- erwrewr --}}

                                        {{-- <div class="row justify-content-between text-left"> --}}
                                            {{-- <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Line Manager</label>
                                                <input type="text" list="FavoriteColor" id="linemanager"  value="{{$user->linemanager}}" name="linemanager" placeholder="" autocomplete="off">
                                                        <datalist id="FavoriteColor">
                                                            @foreach ($userss as $userr)
                                                                <option value="{{$userr->name}}"> </option>
                                                            @endforeach
                                                        </datalist>
                                                        </p>
                                        </div> --}}

                                        {{-- MUST ADD requirepd for radio check --}}
                                        <br>
                                        <div class="row justify-content-center">
                                            <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block">Update Leave Balances</button> </div>
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
