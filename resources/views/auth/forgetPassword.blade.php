@extends('layouts.app')
  
@section('content')

<div class="container" style="height: auto;">
        <div class="row align-items-center">

      <!-- /.login-logo -->
      <div style = "background-color: #ffffffbd; border-top: 3px solid #007bff;" class="card card-outline card-primary col-lg-4 col-md-6 col-sm-8 ml-2rem">
        <div class="card-header text-center">
          <p class="h1 mb-0" style="font-size:2.3rem;"> <img class="mb-0 ml-0" src="{{url('/hr360-3-noBG.png')}}"  alt="" style=" width:150px;height:50px;"></p>
        </div>
        <div  class="card-body text-center">
        @if (Session::has('message'))
                         <div id="message" class="alert alert-success" role="alert">
                            
                            {{ Session::get('message') }}
                        </div>
                    @endif


                    
          <p id="box1" class="login-box-msg pr-0 pb-3 pl-0">Reset your password / ادخل ايميل العمل</p>

          <form action="{{ route('forget.password.post') }}" method="post">
            @csrf

            <div id="box" class=" bmd-form-group">
                <div class="input-group mb-3">
                  <input type="text" id="email_address" name="email" required autofocus  class="form-control"
                    placeholder="E-Mail Address" >
                    <!-- @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif -->
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    
                    </div>
                  </div>
                </div>
                @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                      <br>
                                      <br>
                                  @endif
                
            </div>
            <div id="box2" class=" text-right">
                              <div class="col-12">
                                  <div class="checkbox ">
                                      <label >
                                          <a style = "color: #007bff;" href="{{ route('login') }}">Back to Login</a>
                                      </label>
                                  </div>
                              </div>
                          </div>
              <!-- /.col -->
              <div id="box3" class="row">
                  <div class="col-12">
                    <button type="submit" class="btn-1">Send Password Reset Link</button>
                  </div>
              </div>
              <!-- /.col -->
          </form>



        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->


      <style>
.btn-1 {
  border: none;
  width: 100%;
  height: 35px;
  color: white;
  background-color: #007bff;
  border-radius: 3px;
box-shadow: inset 0 0 0 0 #FF7602;
transition: ease-out 1.5s;

}
.btn-1.activate {
  box-shadow: inset 500px 0 0 0 #FF7602;
}

          </style>


</div>
</div>
<!-- 
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header">Reset Password</div>
                  <div class="card-body">
  
                    @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
  
                      <form action="{{ route('forget.password.post') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Send Password Reset Link
                              </button>
                          </div>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main> -->
@endsection

@push('scripts')
<script src="{{ asset('select/js/bootstrap-select.min.js')}}"></script>



<script>
$(document).ready(function() {


  $(document).on('click', '.btn-1', function () {
$(this).addClass('activate');
});
    if ($("#message").text().length < 1) {
     $('#box').show();
     $('#box1').show();
     $('#box2').show();
     $('#box3').show();
   }  

   if ($("#message").text().length > 1) {
     $('#box').hide();
     $('#box1').hide();
     $('#box2').hide();
     $('#box3').hide();

   }  

});




</script>


@endpush