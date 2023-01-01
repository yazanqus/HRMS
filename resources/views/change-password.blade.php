@extends('layouts.app',['activePage' => 'welcome', 'titlePage' => ('welcome')])
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
                <div style=" background-color: #ffb678 !important;" class="card-header card-header-primary">
                    <h4 class="card-title ">{{__('changepassword.changepassword')}}</h4>
                    {{-- <p class="card-category"> Here you can manage users</p> --}}
                  </div>

                <div class="card-body table-responsive-md">

                        <div class="col-md-10 offset-2">
                            <div class="panel panel-default mr-5">
                                <div class="panel-body">
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">{{ $error }}</div>
                                        @endforeach
                                    @endif
                                    @php
                                        $user=Auth::user();
                                    @endphp




                                    <div class="container py-1 h-100">
                                        <div class="row justify-content-center align-items-center h-100">
                                          <div class="col-12 col-lg-10 col-xl-10">
                                            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                              <div class="card-body p-4 p-md-4">

                                                <form class="form-horizontal" autocomplete="off" method="POST" action="{{ route('changePasswordPost') }}">
                                                    {{ csrf_field() }}

                                                    <div class="row justify-content-between  text-left">
                                                        <div class="form-group row {{ $errors->has('current-password') ? ' has-error' : '' }}  flex-column d-flex">
                                                            <label for="new-password" class="mt-1 col-sm-11 form-control-label required px-1">{{__('changepassword.currentpassword')}}</label>
                                                            <div class="input-group">
                                                            <input class=" form-control form-outline" type="password" id="current-password"  name="current-password" required>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text">
                                                                  <i class="fas fa-eye-slash" id="eye1"></i>
                                                                </div>
                                                              </div>
                                                        </div>
                                                             @if ($errors->has('current-password'))
                                                             <strong>{{ $errors->first('current-password') }}</strong>
                                                             @endif
                                                          </div>
                                                        </div>
                                                        <br>




                                                          <div class="row justify-content-between text-left">
                                                          <div class="form-group row {{ $errors->has('new-password') ? ' has-error' : '' }}  flex-column d-flex">
                                                            <label for="new-password" class="mt-1 col-sm-11 form-control-label required px-1">{{__('changepassword.newpassword')}}</label>
                                                            <div class="input-group">
                                                            <input class=" form-control form-outline " type="password" id="new-password"  name="new-password" required>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text  ">
                                                                  <i class="fas fa-eye-slash " id="eye2" ></i>
                                                                </div>
                                                              </div>
                                                        </div>
                                                             @if ($errors->has('new-password'))

                                                             {{-- <strong>{{ $errors->first('new-password') }}</strong> --}}

                                                             @endif
                                                          </div>
                                                        </div>

                                                          <div class="row justify-content-between text-left">
                                                          <div class="form-group row flex-column d-flex">
                                                            <label for="new-password-confirm" class=" mt-1 col-sm-11 form-control-label required px-1">{{__('changepassword.confirmpassword')}}</label>
                                                            <div class="input-group">
                                                            <input class=" form-control form-outline " type="password" id="new-password-confirm"  name="new-password_confirmation" required>
                                                            <div class="input-group-append">
                                                                <div class="input-group-text  ">
                                                                  <i class="fas fa-eye-slash " id="eye3"></i>
                                                                </div>
                                                              </div>
                                                        </div>

                                                          </div>

                                                    </div>
<div class="row justify-content-center">
<div class="  form-group col-sm-3">
                                                        <!-- <div class=" col-md-6 col-md-offset-4"> -->
                                                            <button type="submit" class="btn btn-block btn-primary">
                                                            {{__('changepassword.changethepass')}}
                                                            </button>
                                                        <!-- </div> -->
                                                    </div>
</div>
                                                    
                                                </form>

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
</div>
@endsection

@push('scripts')

<script>



    $("#eye1").on('click',function() {

        if($(this).hasClass('fa-eye-slash')){

          $(this).removeClass('fa-eye-slash');

          $(this).addClass('fa-eye');

          $('#current-password').attr('type','text');

        }else{

          $(this).removeClass('fa-eye');

          $(this).addClass('fa-eye-slash');

          $('#current-password').attr('type','password');
        }
    });


    $("#eye2").on('click',function() {

if($(this).hasClass('fa-eye-slash')){

  $(this).removeClass('fa-eye-slash');

  $(this).addClass('fa-eye');

  $('#new-password').attr('type','text');

}else{

  $(this).removeClass('fa-eye');

  $(this).addClass('fa-eye-slash');

  $('#new-password').attr('type','password');
}
});

$("#eye3").on('click',function() {

if($(this).hasClass('fa-eye-slash')){

  $(this).removeClass('fa-eye-slash');

  $(this).addClass('fa-eye');

  $('#new-password-confirm').attr('type','text');

}else{

  $(this).removeClass('fa-eye');

  $(this).addClass('fa-eye-slash');

  $('#new-password-confirm').attr('type','password');
}
});



$(document).ready(function() {
  $('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});
});
//   $(".reveal1").on('click',function() {
//     var $pwd = $(".pwd1");
//     if ($pwd.attr('type') === 'password') {
//         $pwd.attr('type', 'text');
//     } else {
//         $pwd.attr('type', 'password');
//     }
//     $(this).toggleClass("fa-eye fa-eye-slash");
// });

// $(".reveal2").on('click',function() {
//     var $pwd = $(".pwd2");
//     if ($pwd.attr('type') === 'password') {
//         $pwd.attr('type', 'text');
//     } else {
//         $pwd.attr('type', 'password');
//     }
//     $(this).toggleClass("fa-eye fa-eye-slash");
// });

// $(".reveal3").on('click',function() {
//     var $pwd = $(".pwd3");
//     if ($pwd.attr('type') === 'password') {
//         $pwd.attr('type', 'text');
//     } else {
//         $pwd.attr('type', 'password');
//     }
//     $(this).toggleClass("fa-eye fa-eye-slash");
// });
</script>

@endpush
