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
                    <div style=" background-color: #ffb678 !important;" class="card-header card-header-primary">
                    
                        <h4 class="card-title "> <i class="mr-2 fas fa-search"></i>{{__('advancedSearchLeave.advancedSearchForStaffLeaves')}}</h4>
                      </div>

                    <div class="card-body table-responsive-md">
                        <div class="container py-3 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                              <div class="col-12 col-lg-10 col-xl-10">
                                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                  <div class="card-body p-4 p-md-5">
                                    
                                  <form class="form-outline" autocomplete="off" action="{{ route('admin.leaves.search') }}" method="POST" target="__blank">
                                      @csrf

                                      <div class="row justify-content-between text-left">
                                      <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label  px-1">{{__('advancedSearchLeave.staffName')}}</label>
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
                                     
                                      </div>


                                      <div class="row justify-content-between text-left">
                                      <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label  px-1">{{__('advancedSearchLeave.leavetype')}}</label>
                                        <select
                                                    class="form-control selectpicker" data-size="7" data-style="btn btn-outline-secondary"
                                                    name="leavetype_id[]" id="leavetype_id" type="text" multiple
                                                    placeholder="{{ __('Leave Type') }}"
                                                    >
                                                   

                                                    <option value="1">{{__('createLeave.AnnualLeave')}}</option>
                                                    <option value="2">{{__('createLeave.SickLeave')}}</option>
                                                    <option value="20">{{__('createLeave.SickLeaveFirsthalf')}}</option>
                                                    <option value="21">{{__('createLeave.SickLeaveSecondhalf')}}</option>
                                                    <option value="13">{{__('createLeave.AnnualleaveFirsthalf')}}</option>
                                                    <option value="14">{{__('createLeave.AnnualleaveSecondhalf')}}</option>
                                                    <option value="15">{{__('createLeave.Unpaidleave')}}</option>
                                                    <option value="16">{{__('createLeave.UnpaidleaveFirsthalf')}}</option>
                                                    <option value="17">{{__('createLeave.UnpaidleaveSecondhalf')}}</option>
                                                    <option value="18">{{__('createLeave.Compensation')}}</option>
                                                    <option value="19">{{__('createLeave.Compensationhours')}}</option>
                                                    <option value="3">{{__('createLeave.Sickleave30%deduction')}}</option>
                                                    <option value="4">{{__('createLeave.Sickleave20%deduction')}}</option>
                                                    <option value="5">{{__('createLeave.Marriageleave')}}</option>
                                                    <option value="6">{{__('createLeave.CompassionateFirstdegreerelative')}}</option>
                                                    <option value="7">{{__('createLeave.CompassionateSeconddegreerelative')}}</option>
                                                    <option value="8">{{__('createLeave.Maternityleave')}}</option>
                                                    <option value="9">{{__('createLeave.Paternityleave')}}</option>
                                                    <option value="12">{{__('createLeave.Welfareleave')}}</option>
                                                    <option value="10">{{__('createLeave.PilgrimageIslamicleave')}}</option>
                                                    <option value="11">{{__('createLeave.PilgrimageChristianleave')}}</option>


                                                </select>
                                     </div>
                                     
                                      </div>
                                      
                              
                                      <div class="row justify-content-between text-left">
                                        <div class="form-group {{ $errors->has('start_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">{{__('advancedSearchLeave.leaveStartDate')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('start_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('start_date') }}" name="start_date" id="start_date" placeholder="" >
                                            @if ($errors->has('start_date'))
                                                <span id="start_date-error" class="error text-danger" for="input-start_date">{{ $errors->first('start_date') }}</span>
                                               @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('end_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">{{__('advancedSearchLeave.leaveEndDate')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('end_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('end_date') }}" name="end_date" id="end_date" placeholder="" >
                                            @if ($errors->has('end_date'))
                                                <span id="end_date-error" class="error text-danger" for="input-end_date">{{ $errors->first('end_date') }}</span>
                                               @endif
                                        </div>
                                      </div>


                                      {{-- MUST ADD requirepd for radio check --}}
                                       <br>
                                      <div class="row justify-content-center">
                                          <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block">{{__('advancedSearchLeave.view')}}</button> </div>
                                          <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.allstaffleaves.index')}}" >{{__('advancedSearchLeave.cancel')}}</a> </div>
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
<script src="{{ asset('select/js/bootstrap-select.min.js')}}"></script>
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
