@extends('layouts.app', ['activePage' => 'allstaffleaves', 'titlePage' => ('users create')])

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6 mb-6">
                    <div class="text">
                        
                    </div>
                </div>
            </div>
            <br>



            <div class="container-fluid">

                <div class="card">
                    <div class="card-header card-header-primary">
                    
                        <h4 class="card-title "> <i class="mr-2 fas fa-file-pdf"></i>{{__('leavesPDF.createReportForStaffLeaves')}}</h4>
                      </div>

                    <div class="card-body table-responsive-md">
                        <div class="container py-3 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                              <div class="col-12 col-lg-10 col-xl-10">
                                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                  <div class="card-body p-4 p-md-5">
                                    
                                  <form class="form-outline" autocomplete="off" action="{{ route('admin.leaves.pdfshow') }}" method="POST" target="__blank">
                                      @csrf

                                      <div class="row justify-content-between text-left">
                                      <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label required px-1">{{__('leavesPDF.staffName')}}</label>
                                        <input class="form-control form-outline {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" list="FavoriteColor" id="color" placeholder="Choose Staff Name.."
                                            name="name" value="{{ old('name') }}" autocomplete="off">
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                               @endif
                                        <datalist id="FavoriteColor">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"> </option>
                                            @endforeach
                                        </datalist>
                                     </div>
                                     <!-- <div class="form-group col-sm-6 flex-column d-flex {{ $errors->has('leavetype') ? 'has-danger' : '' }}"> <label class="dropdown form-control-label required px-1 {{ $errors->has('leavetype') ? ' is-invalid' : '' }}">Leave type</label>
                                        <select class="form-control form-outline {{ $errors->has('leavetype') ? ' is-invalid' : '' }}" id="leavetype" name="leavetype" aria-label="Default select example" >
                                          
                                        <option value selected disabled ="">Select leave Type..</option>

                                          <option value="all" @if (old('leavetype') == "all") {{ 'selected' }} @endif>All leave types</option>
                                          <option value="annual" @if (old('leavetype') == "annual") {{ 'selected' }} @endif>Annual leaves</option>
                                          <option value="sick" @if (old('leavetype') == "sick") {{ 'selected' }} @endif>Sick leaves</option>
                                          <option value="welfare" @if (old('leavetype') == "welfare") {{ 'selected' }} @endif>Welfare leaves</option>
                                          <option value="compassionate" @if (old('leavetype') == "compassionate") {{ 'selected' }} @endif>Compassionate leaves</option>
                                          <option value="ternity" @if (old('leavetype') == "ternity") {{ 'selected' }} @endif>Maternity/Paternity leaves</option>
                                          <option value="unpaid" @if (old('leavetype') == "unpaid") {{ 'selected' }} @endif>Unpaid leaves</option>
                                          <option value="compansetion" @if (old('leavetype') == "compansetion") {{ 'selected' }} @endif>Compansetion leaves</option>
                                         
                                          
                                        </select>
                                        @if ($errors->has('leavetype'))
                                                <span id="leavetype-error" class="error text-danger" for="input-leavetype">{{ $errors->first('leavetype') }}</span>
                                               @endif
                                        </div> -->
                                      </div>
                                      
                              
                                      <div class="row justify-content-between text-left">
                                        <div class="form-group {{ $errors->has('start_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">{{__('leavesPDF.leaveStartDate')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('start_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('start_date') }}" name="start_date" id="start_date" placeholder="" >
                                            @if ($errors->has('start_date'))
                                                <span id="start_date-error" class="error text-danger" for="input-start_date">{{ $errors->first('start_date') }}</span>
                                               @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('end_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">{{__('leavesPDF.leaveEndDate')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('end_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('end_date') }}" name="end_date" id="end_date" placeholder="" >
                                            @if ($errors->has('end_date'))
                                                <span id="end_date-error" class="error text-danger" for="input-end_date">{{ $errors->first('end_date') }}</span>
                                               @endif
                                        </div>
                                      </div>


                                      {{-- MUST ADD requirepd for radio check --}}
                                       <br>
                                      <div class="row justify-content-center">
                                          <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block">{{__('leavesPDF.view')}}</button> </div>
                                          <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.allstaffleaves.index')}}" >{{__('leavesPDF.cancel')}}</a> </div>
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
