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
                                            <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">Name</label>
                                                <input class="form-control form-outline {{ $errors->has('name') ? ' is-invalid' : '' }} " type="text" id="name" value="{{$user->name}}" name="name" placeholder="">
                                                @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                               @endif
                                            </div>
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Birth Date</label>
                                                <input class="form-control form-outline" type="date" id="birth_date" value="{{$user->birth_date}}" name="birth_date" placeholder="" >
                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Position</label> <input class="form-control form-outline" type="text" id="position" value="{{$user->position}}" name="position" placeholder="" > </div>

                                            <div class="form-group col-sm-6 flex-column d-flex {{ $errors->has('office') ? ' has-danger' : '' }}"> <label class="dropdown form-control-label required px-1 {{ $errors->has('joined_date') ? ' is-invalid' : '' }}">Office</label>
                                        <select class="form-control form-outline"  id="office" name="office" aria-label="Default select example" >
                                          
                                          <option value selected disabled ="">Choose office..</option>
                                        
                                          <option value="AO2" @if ($user->office == "AO2") {{ 'selected' }} @endif>AO2</option>
                                          <option value="AO3" @if ($user->office == "AO3") {{ 'selected' }} @endif>AO3</option>
                                          <option value="AO4" @if ($user->office == "AO4") {{ 'selected' }} @endif>AO4</option>
                                          <option value="AO6" @if ($user->office == "AO6") {{ 'selected' }} @endif>AO6</option>
                                          <option value="AO7" @if ($user->office == "AO7") {{ 'selected' }} @endif>AO7</option>
                                          
                                        </select>
                                        @if ($errors->has('office'))
                                                <span id="office-error" class="error text-danger" for="input-office">{{ $errors->first('office') }}</span>
                                               @endif
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Department</label> <input class="form-control form-outline" type="text" id="department"  value="{{ $user->department }}" name="department" placeholder="" > </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('joined_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">Join Date</label>
                                                <input class="form-control form-outline {{ $errors->has('joined_date') ? ' is-invalid' : '' }}" type="date" id="joined_date" value="{{$user->joined_date}}" name="joined_date" placeholder="" >
                                                @if ($errors->has('joined_date'))
                                                <span id="joined_date-error" class="error text-danger" for="input-joined_date">{{ $errors->first('joined_date') }}</span>
                                               @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('employee_number') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">Employee ID</label>
                                                <input class="form-control form-outline {{ $errors->has('employee_number') ? ' is-invalid' : '' }}" type="text" id="employee_id"  value="{{$user->employee_number}}" name="employee_number" placeholder="" >
                                                @if ($errors->has('employee_number'))
                                                <span id="employee_number-error" class="error text-danger" for="input-employee_number">{{ $errors->first('employee_number') }}</span>
                                               @endif
                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Line Manager</label>
                                                <input class="form-control form-outline" type="text" list="FavoriteColor" id="linemanager"  value="{{$user->linemanager}}" name="linemanager" placeholder="" autocomplete="off">
                                                        <datalist id="FavoriteColor">
                                                            @foreach ($userss as $userr)
                                                                <option value="{{$userr->name}}"> </option>
                                                            @endforeach
                                                        </datalist>
                                                        </p>
                                        </div>

                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <!-- {{-- <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Line Manager</label>
                                                <input type="text" list="FavoriteColor" id="linemanager"  value="{{$user->linemanager}}" name="linemanager" placeholder="" autocomplete="off">
                                                        <datalist id="FavoriteColor">
                                                            @foreach ($userss as $userr)
                                                                <option value="{{$userr->name}}"> </option>
                                                            @endforeach
                                                        </datalist>
                                                        </p>
                                        </div> --}} -->
                                        <!-- @php
                                        if ($user->usertype_id == "2") {
                                      $role = "Line Manager";
                                    }
                                    else {
                                        $role = "Staff";
                                    }
                                            @endphp
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Role <small>(Currently: {{$role}})</small></label>
                                                <div class="form-check">
                                                    <input class="btn-check" type="radio" name="usertype_id" Value="1" id="flexCheckDefault" {{ $role=='Staff' ? ' checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                      Staff
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input class="btn-check" type="radio" name="usertype_id" Value="2" id="flexCheckChecked" {{ $role=='Line Manager' ? ' checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                      Line Manager
                                                    </label>
                                                  </div>
                                            </div> -->
                                        @php
                                        if ($user->hradmin == "yes") {
                                      $admin = "Admin";
                                    }

                                    else {
                                        $admin = "Not Admin";
                                    }
                                            @endphp

                                            @if ($hruser->superadmin == "yes")
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Role <small>(Currently: {{$admin}})</small></label>
                                                <div class="form-check">
                                                    <input class="btn-check" type="radio" name="hradmin" Value="no" id="test1" {{ $admin=='Not Admin' ? ' checked' : '' }}>
                                                    <label class="form-check-label" for="test1">
                                                      Not Admin
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input class="btn-check" type="radio" name="hradmin" Value="yes" id="test2" {{ $admin=='Admin' ? ' checked' : '' }} >
                                                    <label class="form-check-label" for="test2">
                                                      Admin
                                                    </label>
                                                  </div>
                                            </div>
                                            @endif
                                            @php
                                        if ($user->contract == "Regular") {
                                      $contract = "Regular";
                                    }

                                    elseif ($user->contract == "Service") {
                                        $contract = "Service";
                                    }
                                    elseif ($user->contract == "NA") {
                                      $contract = "NA";
                                    }
                                            @endphp
                                            <div class="form-group {{ $errors->has('contract') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex"> <label class="form-control-label required px-1">Contract Type</label> <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="Regular" id="regular" {{ $contract=='Regular' ? ' checked' : '' }}>
                                            <label class="form-check-label" for="regular">
                                              Regular Contract
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="Service" id="sc" {{ $contract=='Service' ? ' checked' : '' }}>
                                            <label class="form-check-label" for="sc">
                                              Service Contract
                                            </label>
                                          </div> 
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="NA" id="na" {{ $contract=='NA' ? ' checked' : '' }}>
                                            <label class="form-check-label" for="na">
                                              Not Available
                                            </label>
                                          </div> 
                                        </div>

                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Email</label>
                                                <input class="form-control form-outline {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" id="email" value="{{$user->email}}" name="email" autocomplete="off" placeholder=""  >
                                               @if ($errors->has('email'))
                                                 <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group  {{ $errors->has('password') ? ' has-danger' : '' }}  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">Password <small>(Change User Password)</small></label>
                                                <div class="input-group">
                                                    <input class="form-control form-outline  {{ $errors->has('password') ? ' is-invalid' : '' }} "  type="password" id="password" autocomplete="off"
                                                    name="password"  autocomplete="new-password" placeholder="Can't view, Only Reset is possible">
                                                    {{-- @if ($errors->has('password'))
                                                 <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                                @endif --}}
                                                    <div class="input-group-append">
                                                     <div class="input-group-text  ">
                                                       <i class="fas fa-eye-slash" id="eye1"></i>
                                                     </div>
                                                   </div>
                                                 </div>
                                                 @if ($errors->has('password'))
                                              <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                             @endif
                                                </div>
                                        </div>
                                        {{-- MUST ADD requirepd for radio check --}}
                                        <div class="row justify-content-center">
                                            <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block">Update User Info</button> </div>
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
                <style>
                    .required:after {
                      content:" *";
                      color: red;
                    }
                    i{
                                                        cursor:pointer;
                                                    }
                  </style>







    </div>
  </div>
@endsection
@push('scripts')

<script>


$(document).ready(function() {
  $('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});
});

  $("#eye1").on('click',function() {

if($(this).hasClass('fa-eye-slash')){

  $(this).removeClass('fa-eye-slash');

  $(this).addClass('fa-eye');

  $('#password').attr('type','text');

}else{

  $(this).removeClass('fa-eye');

  $(this).addClass('fa-eye-slash');

  $('#password').attr('type','password');
}
});
</script>

@endpush
