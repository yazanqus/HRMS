@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('Material Dashboard')])

@section('content')
    <div class="container" style="height: auto;">
        <div class="row align-items-center">

      <!-- /.login-logo -->
      <div style = "background-color: #ffffffbd;  "class="card card-outline card-primary col-lg-4 col-md-6 col-sm-8 ml-2rem">
     
        <div class="card-header text-center">
          <p class="h1 mb-0" style="font-size:2.3rem;"> <img class="mb-0 ml-0" src="{{url('/hr360-3-noBG.png')}}"  alt="" style=" width:150px;height:50px;"></p>
          @if (session('success'))
          <br>
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        </div>
        <div class="card-body text-center">
          <!-- <p class="login-box-msg pr-0 pb-3 pl-0">Sign in to start your session</p> -->

          <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="bmd-form-group{{ $errors->has('employee_number') ? ' has' : '' }}">
                <div class="input-group mb-3">
                  <input type="text" name="employee_number"  class="form-control"
                    placeholder="{{ __('Employee Number') }}" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-id-badge"></i>
                      
                    </div>
                  </div>
                </div>
                {{-- @if ($errors->has('employee_number'))
                                    <div id="employee_number-error" class="error text-danger value="{{ old('employee_number', '') }} mr-3 pl-3" for="employee_number"
                                        style="display: block;">
                                        <strong>{{ $errors->first('employee_number') }}</strong>
                                    </div>
                                @endif --}}
            </div>



            <div class="input-group mb-2">
              <input type="password" name="password" class="form-control pwd" placeholder="Password" required>


              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">
             
                <div class="container ">
                    <div class="check-primary text-left  pwd">
                      <input type="checkbox" class="reveal">
                      <label>
                        Show password
                      </label>
                      
                    </div>
                    <!-- <div class=" text-right">
                              <div class="col-12">
                                  <div class="checkbox ">
                                      <label >
                                          <a href="{{ route('forget.password.get') }}">Forgot your Password?</a>
                                      </label>
                                  </div>
                              </div>
                          </div> -->
                </div>
     
            </div>
            @if($errors->any())
            <div class="alert " style="color:red; font-weight:bold; padding-bottom: 0.2rem;"  >{{$errors->first()}}</></div>
@endif

                          <div class="form-group mb-0 row text-right">
                              <div class="col">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('forget.password.get') }}">Forgot your Password?</a>
                                      </label>
                                  </div>
                              </div>
                          </div>
            {{-- @if ($errors->has('employee_number'))
                                    <div id="employee_number-error" class="mb-1 error text-danger mr-3 pl-3" for="employee_number"
                                        style="display: block;">
                                        <strong>{{ $errors->first('employee_number') }}</strong>
                                    </div>
                                @endif --}}
              <!-- /.col -->
              <div class="row">
                  <div class="col-12">
                    <button type="submit" class="mb-2 btn-1 ">Sign in</button>
                  </div>
              </div>
              <!-- /.col -->
          </form>

          <style>
.btn-1 {
  border: none;
  width: 100%;
  height: 100%;
  color: white;
  background-color: #007bff;
  border-radius: 3px;
box-shadow: inset 0 0 0 0 #14489e;
transition: ease-out 0.9s;

}
.btn-1.activate {
  box-shadow: inset 500px 0 0 0 #14489e;
}

          </style>

          <!-- <div class="social-auth-links text-center ">
            <a href="#" class="btn btn-block btn-outline-primary">
              <i class="fab fa-faecebook"></i>SSO - Sign in with Okta
            </a>
            {{-- <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a> --}}
          </div> -->
          <!-- /.social-auth-links -->

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->





</div>
</div>









@endsection

@push('scripts')

<script>
  $(document).ready(function() {

    $(document).on('click', '.btn-1', function () {
$(this).addClass('activate');
});

$(document).on('click', '#buttonSelector', function () {
$(this).addClass('disabled');
});
$('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});
});
  $(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
    } else {
        $pwd.attr('type', 'password');
    }
});
</script>

@endpush
