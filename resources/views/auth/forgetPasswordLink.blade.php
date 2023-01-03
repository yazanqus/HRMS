@extends('layouts.app')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col">
          @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
              <div class="card">
                  <div class="card-header">Reset Password</div>
                  <div class="card-body">
  
                      <form action="{{ route('reset.password.post') }}" method="POST">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
  
                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row ">
                              <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                              <div class="col-md-6">
                              <div class="input-group">
                                  <input type="password" id="password" class="form-control" name="password" required autofocus>
                                  <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                  <i class="fas fa-eye-slash" id="eye1"></i>
                                                                </div>
                                                              </div>
                                                              </div>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm New Password</label>
                              <div class="col-md-6">
                              <div class="input-group">
                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                  <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                  <i class="fas fa-eye-slash" id="eye2"></i>
                                                                </div>
                                                              </div>
                                                              </div>
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Reset Password
                              </button>
                          </div>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection

@push('scripts')

<script>



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


    $("#eye2").on('click',function() {

if($(this).hasClass('fa-eye-slash')){

  $(this).removeClass('fa-eye-slash');

  $(this).addClass('fa-eye');

  $('#password-confirm').attr('type','text');

}else{

  $(this).removeClass('fa-eye');

  $(this).addClass('fa-eye-slash');

  $('#password-confirm').attr('type','password');
}
});





</script>

@endpush