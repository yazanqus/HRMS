@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('Material Dashboard')])

@section('content')
    <div class="container" style="height: auto;">
        <div class="row align-items-center">

      <!-- /.login-logo -->
      <div class="card card-outline card-primary col-lg-4 col-md-6 col-sm-8 ml-2rem">
     
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
          <p class="login-box-msg pr-0 pb-3 pl-0">Sign in to start your session</p>

          <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="bmd-form-group{{ $errors->has('employee_number') ? ' has' : '' }}">
                <div class="input-group mb-3">
                  <input type="text" name="employee_number"  class="form-control"
                    placeholder="{{ __('Employee Number') }}" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-id-badge"></i>
                      {{-- <span class="fas fa-envelope"></span> --}}
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



            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control pwd" placeholder="Password" required>


              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">
              {{-- <div class="col-2"> --}}
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
              {{-- </div> --}}
            </div>
            @if($errors->any())
            <div class="alert " style="color:red; font-weight:bold; padding-bottom: 0.2rem;"  >{{$errors->first()}}</></div>
@endif

                          <div class="form-group row">
                              <div class="col">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('forget.password.get') }}">Forgot your Password?</a>
                                      </label>
                                  </div>
                              </div>
                          </div>
            {{-- @if ($errors->has('employee_number'))
                                    <div id="employee_number-error" class="mb-2 error text-danger mr-3 pl-3" for="employee_number"
                                        style="display: block;">
                                        <strong>{{ $errors->first('employee_number') }}</strong>
                                    </div>
                                @endif --}}
              <!-- /.col -->
              <div class="row">
                  <div class="col-12">
                    <button type="submit" class="btn bg-gradient-primary btn-block">Sign In</button>
                  </div>
              </div>
              <!-- /.col -->
          </form>

          <!-- <div class="social-auth-links text-center ">
            <a href="#" class="btn btn-block btn-outline-primary">
              <i class="fab fa-faecebook"></i>SSO - Sign in with Okta
            </a>
            {{-- <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a> --}}
          </div> -->
          <!-- /.social-auth-links -->
{{--
          <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p>
          <p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
          </p> --}}
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->





</div>
</div>




{{--
            <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                <form class="form" method="POST" action="{{ route('login') }}">
                    @csrf
                  <div class="color-head" style="margin: 0 0 -73px 0; background-color:#ff9400; height: 50px; border-radius: 5px;"></div>
                    <div class="card card-login card-hidden mb-3">

                        <div class="card-body">

                            <div class="bmd-form-group{{ $errors->has('employee_number') ? ' has-danger' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="employee_number" name="employee_number" class="form-control"
                                        placeholder="{{ __('Employee Number...') }}"
                                        value="{{ old('employee_number', '') }}" required>
                                </div>
                                @if ($errors->has('employee_number'))
                                    <div id="employee_number-error" class="error text-danger pl-3" for="employee_number"
                                        style="display: block;">
                                        <strong>{{ $errors->first('employee_number') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="{{ __('Password...') }}"
                                        value="{{ !$errors->has('password') ? 'secret' : '' }}" required>
                                </div>
                                @if ($errors->has('password'))
                                    <div id="password-error" class="error text-danger pl-3" for="password"
                                        style="display: block;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-check mr-auto ml-3 mt-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>

                            <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <a href="{{ route('forget.password.get') }}">Reset Password</a>
                                      </label>
                                  </div>
                              </div>
                          </div>

                        </div>
                        <div class="card-footer justify-content-center">
                            <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Lets Go') }}</button>
                        </div>
                    </div>
                </form>
                <div class="row">

                    <div class="btn btn-danger">
                        <a href="{{ route('login-okta') }}" class="text-light">
                            {{ __('Login With OKTA') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}




@endsection

@push('scripts')

<script>
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
