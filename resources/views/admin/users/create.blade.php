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
                                  <form class="form-outline" autocomplete="off" action="{{ route('admin.users.store') }}" method="POST">
                                      @csrf

                                      <div class="row justify-content-between text-left">
                                          <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                              <label class="form-control-label required px-1">Full Name</label>
                                              <input class="form-control form-outline {{ $errors->has('name') ? ' is-invalid' : '' }} " type="text" id="name"  value="{{ old('name') }}" name="name" placeholder="">
                                               @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                               @endif
                                            </div>
                                          <div class="form-group col-sm-6 flex-column d-flex">
                                              <label class="form-control-label px-1">Birth Date</label>
                                              <input class="form-control form-outline" type="date" value="{{ old('birth_date') }}" name="birth_date" id="birth_date" placeholder="" >
                                            </div>
                                      </div>
                                      <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Position</label> <input class="form-control form-outline" type="text" id="position"  value="{{ old('position') }}" name="position" placeholder="" > </div>
                   
                                        <div class="form-group col-sm-6 flex-column d-flex {{ $errors->has('office') ? ' has-danger' : '' }}"> <label class="dropdown form-control-label required px-1 {{ $errors->has('joined_date') ? ' is-invalid' : '' }}">Office</label>
                                        <select class="form-control form-outline" id="office" name="office" aria-label="Default select example" >
                                          
                                          <option value selected disabled ="">Choose office..</option>
                                        
                                          <option value="AO2" @if (old('office') == "AO2") {{ 'selected' }} @endif >AO2</option>
                                          <option value="AO3" @if (old('office') == "AO3") {{ 'selected' }} @endif>AO3</option>
                                          <option value="AO4" @if (old('office') == "AO4") {{ 'selected' }} @endif>AO4</option>
                                          <option value="AO6" @if (old('office') == "AO6") {{ 'selected' }} @endif>AO6</option>
                                          <option value="AO7" @if (old('office') == "AO7") {{ 'selected' }} @endif>AO7</option>
                                          
                                        </select>
                                        @if ($errors->has('office'))
                                                <span id="office-error" class="error text-danger" for="input-office">{{ $errors->first('office') }}</span>
                                               @endif
                                        </div>

                                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Department</label> <input class="form-control form-outline" type="text" id="department"  value="{{ old('department') }}" name="department" placeholder="" > </div>
                      
                                      </div>
                                      <div class="row justify-content-between text-left">
                                        <div class="form-group {{ $errors->has('joined_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">Join Date</label>
                                            <input class="form-control form-outline {{ $errors->has('joined_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('joined_date') }}" name="joined_date" id="joined_date" placeholder="" >
                                            @if ($errors->has('joined_date'))
                                                <span id="joined_date-error" class="error text-danger" for="input-joined_date">{{ $errors->first('joined_date') }}</span>
                                               @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('employee_number') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">Employee ID</label>
                                            <input class="form-control form-outline {{ $errors->has('employee_number') ? ' is-invalid' : '' }}" type="text" value="{{ old('employee_number') }}" name= "employee_number" autocomplete="Employee ID" id="employee_number"  placeholder="" >
                                            @if ($errors->has('employee_number'))
                                                <span id="employee_number-error" class="error text-danger" for="input-employee_number">{{ $errors->first('employee_number') }}</span>
                                               @endif
                                        </div>
                                      </div>
                                      <div class="row justify-content-between text-left">
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Line Manager</label><input class="form-control form-outline" type="text" list="FavoriteColor" id="color" placeholder="Choose Manager Name.."
                                            name="linemanager" value="{{ old('linemanager') }}" autocomplete="off">
                                        <datalist id="FavoriteColor">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"> </option>
                                            @endforeach
                                        </datalist>
                                     </div>
                                     @php
                                $authuser = Auth::user();
                                @endphp
                                @if ($authuser->superadmin == "yes")
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label  px-1">HR admin <small>(Permission on HRMS)</small></label> <div class="form-check">
                                            <input  class="btn-check" type="radio" name="hradmin" Value="no" id="test1" checked>
                                            <label class="form-check-label" for="test1">
                                              Not Admin
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="hradmin" Value="yes" id="test2" >
                                            <label class="form-check-label" for="test2">
                                              Admin
                                            </label>
                                          </div> 
                                        </div>
                                        @endif

                                        <div class="form-group {{ $errors->has('contract') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex"> <label class="form-control-label required px-1">Contract Type</label> <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="Regular" id="regular" @if (old('contract') == "Regular") {{ 'checked' }} @endif>
                                            <label class="form-check-label" for="regular">
                                              Regular Contract
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="Service" id="sc" @if (old('contract') == "Service") {{ 'checked' }} @endif>
                                            <label class="form-check-label" for="sc">
                                              Service Contract
                                            </label>
                                          </div> 
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="NA" id="na" @if (old('contract') == "NA") {{ 'checked' }} @endif>
                                            <label class="form-check-label" for="na">
                                              Not Available
                                            </label>
                                          </div> 
                                        </div>

                                      </div>
                                      <div class="row justify-content-between text-left">
                                          <div class="form-group col-sm-6 flex-column d-flex">
                                              <label class="form-control-label px-1">Email</label>
                                               <input class="form-control form-outline"  type="email" id="email"  name="email" autocomplete="off" value="{{ old('email') }}" readonly placeholder="Email is used for Okta sign in" >
                                             </div>
                                          <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                              <label class="form-control-label required  px-1">Password <small>(When signing using Employee ID)</small></label>
                                               <div class="input-group">
                                                   <input class="form-control form-outline  {{ $errors->has('password') ? ' is-invalid' : '' }} "  type="password" readonly onfocus="this.removeAttribute('readonly');" id="password" autocomplete="off"
                                                   name="password" autocomplete="new-password" placeholder="">
                                                   {{-- @if ($errors->has('password'))
                                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                               @endif --}}
                                                   <div class="input-group-append">
                                                    <div class="input-group-text ">
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
                                       <br>
                                      <div class="row justify-content-center">
                                          <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block">Create</button> </div>
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
                <br>
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
