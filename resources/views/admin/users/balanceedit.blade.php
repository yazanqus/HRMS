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
                        <h4 class="card-title "><a href="{{ URL::previous() }}"> <i  class="fas fa-arrow-alt-circle-left"></i> </a>{{__('balanceedit.edit')}}</h4>
                      </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5"><strong>{{$user->name}}</strong> {{__('balanceedit.leaves')}}:</h3>
                                    <form class="form-card" action="{{ route('admin.users.balanceupdate',$user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">{{__('balanceedit.annualLeave')}}:</label>
                                                <input class="form-control form-outline " type="text" id="annual_leave" value="{{$balance1}}" name="annual_leave" placeholder="">

                                            </div>
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">{{__('balanceedit.unpaidLeave')}}:</label>
                                                <input class="form-control form-outline" type="text" id="unpaid_leave" value="{{$balance15}}" name="unpaid_leave" placeholder="" >
                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label px-1">{{__('balanceedit.sickLeave')}}:</label>
                                                  <input class="form-control form-outline" type="text" id="sick_leave" value="{{$balance2}}" name="sick_leave" placeholder="" >
                                                 </div>
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label px-1">{{__('balanceedit.maternityLeave')}}:</label>
                                                 <input class="form-control form-outline" type="text" id="maternity_leave" value="{{$balance8}}" name="maternity_leave" placeholder="" >
                                                 </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">{{__('balanceedit.sickLeave30%Deduction')}}:</label>
                                                <input class="form-control form-outline " type="text" id="sick_leave30" value="{{$balance3}}" name="sick_leave30" placeholder="" >

                                            </div>
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">{{__('balanceedit.paternityLeave')}}:</label>
                                                <input class="form-control form-outline " type="text" id="paternity_leave"  value="{{$balance9}}" name="paternity_leave" placeholder="" >

                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">{{__('balanceedit.sickLeave20%Deduction')}}:</label>
                                                <input class="form-control form-outline " type="text" id="sick_leave20" value="{{$balance4}}" name="sick_leave20" placeholder="" >

                                            </div>
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">{{__('balanceedit.compassionateSecondDegree')}}:</label>
                                                <input class="form-control form-outline " type="text" id="compassion_second"  value="{{$balance7}}" name="compassion_second" placeholder="" >

                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">{{__('balanceedit.marriageLeave')}}:</label>
                                                <input class="form-control form-outline " type="text" id="marriage_leave" value="{{$balance5}}" name="marriage_leave" placeholder="" >

                                            </div>
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">{{__('balanceedit.compassionateFirstDegree')}}:</label>
                                                <input class="form-control form-outline " type="text" id="compassion_first"  value="{{$balance6}}" name="compassion_first" placeholder="" >

                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">{{__('balanceedit.welfareLeave')}}:</label>
                                                <input class="form-control form-outline " type="text" id="welfare_leave" value="{{$balance12}}" name="welfare_leave" placeholder="" >

                                            </div>
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label  px-1">{{__('balanceedit.compansetion')}}:</label>
                                                <input class="form-control form-outline " type="text" id="compansention"  value="{{$balance18}}" name="compansention" placeholder="" >

                                            </div>
                                        </div>
                                 

                                       
                                           

                                        {{-- MUST ADD requirepd for radio check --}}
                                        <br>
                                        <div class="row justify-content-center">
                                            <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block">{{__('balanceedit.update')}}</button> </div>
                                            <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.users.index')}}" >{{__('balanceedit.cancel')}}</a> </div>
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
