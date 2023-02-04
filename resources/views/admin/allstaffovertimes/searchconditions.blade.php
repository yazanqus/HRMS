@extends('layouts.app', ['activePage' => 'allstaffovertimes', 'titlePage' => ('users create')])

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

            @php
$hruser = Auth::user();
@endphp

            <div class="container-fluid">

                <div class="card">
                    <div style=" background-color: #ffb678 !important;" class="card-header card-header-primary">
                    
                        <h4 class="card-title "> <i class="mr-2 fas fa-search"></i>{{__('advancedSearchOvertime.createReportForStaffOvertimes')}}</h4>
                      </div>

                    <div class="card-body table-responsive-md">
                        <div class="container py-3 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                              <div class="col-12 col-lg-10 col-xl-10">
                                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                  <div class="card-body p-4 p-md-5">
                                    
                                  <form class="form-outline" autocomplete="off" action="{{ route('admin.overtimes.search') }}" method="POST" target="__blank">
                                      @csrf

                                      <div class="row justify-content-between text-left">
                                      <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label  px-1">{{__('advancedSearchOvertime.staffName')}}</label>
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
                                     @if ($hruser->office == "AO2")
                                     <div class="form-group {{ $errors->has('office') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="test form-control-label  px-1">{{__('advancedSearchLeave.staffoffice')}}</label>
                                        <select
                                                    class=" test form-control form-outline   selectpicker" data-size="5" data-style="btn btn-outline-secondary"
                                                    name="office[]" id="office" type="text" multiple>

                                                    <option value="AO2">AO2</option>
                                                    <option value="AO3">AO3</option>
                                                    <option value="AO4">AO4</option>
                                                    <option value="AO6">AO6</option>
                                                    <option value="AO7">AO7</option>


                                                </select>
                                     </div>
                                     @endif
                                      </div>


                                      
                                      <div class="row justify-content-between text-left">
                                      <div class="form-group {{ $errors->has('overtime') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label  px-1">{{__('advancedSearchOvertime.overtimetype')}}</label>
                                        <select
                                                    class="form-control selectpicker" data-size="4" data-style="btn btn-outline-secondary"
                                                    name="overtime[]" id="overtime" type="text" multiple
                                                    placeholder="{{ __('Leave Type') }}"
                                                    >
                                                   

                                                    <option value="workday">{{__('createOvertime.workday')}}</option>
                                                    <option value="week-end">{{__('createOvertime.Week-end')}}</option>
                                                    <option value="holiday">{{__('createOvertime.Holiday')}}</option>
                                                    <option value="SC-overtime">{{__('createOvertime.ServiceContractOvertime')}}</option>
                                                  
                                                    
                                                    


                                                </select>
                                     </div>



                                     <div  class="form-group {{ $errors->has('status') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label  px-1">{{__('advancedSearchOvertime.overtimestatus')}}</label>
                                        <select
                                                    class="form-control form-outline   selectpicker" data-size="5" data-style="btn btn-outline-secondary"
                                                    name="status[]" id="status" type="text" multiple>
                                                   

                                                    <option value="Approved">Approved</option>
                                                    <option value="Declined by HR">Declined by HR</option>
                                                    <option value="Declined by LM">Declined by LM</option>
                                                    <option value="Pending HR Approval">Pending HR Approval</option>
                                                    <option value="Pending LM Approval">Pending LM Approval</option>


                                                </select>
                                     </div>
                                     
                                      </div>
                                      
                              
                                      <div class="row justify-content-between text-left">
                                        <div class="form-group {{ $errors->has('start_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">{{__('advancedSearchOvertime.overtimeStartDate')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('start_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('start_date') }}" name="start_date" id="start_date" placeholder="" >
                                            @if ($errors->has('start_date'))
                                                <span id="start_date-error" class="error text-danger" for="input-start_date">{{ $errors->first('start_date') }}</span>
                                               @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('end_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">{{__('advancedSearchOvertime.overtimeEndDate')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('end_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('end_date') }}" name="end_date" id="end_date" placeholder="" >
                                            @if ($errors->has('end_date'))
                                                <span id="end_date-error" class="error text-danger" for="input-end_date">{{ $errors->first('end_date') }}</span>
                                               @endif
                                        </div>
                                      </div>






                                      {{-- MUST ADD requirepd for radio check --}}
                                       <br>
                                      <div class="row justify-content-center">
                                          <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block">{{__('advancedSearchOvertime.view')}}</button> </div>
                                          <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.allstaffovertimes.index')}}" >{{__('advancedSearchOvertime.cancel')}}</a> </div>
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
  
  $(document).ready(function() {

$('#color').on('change',function(){

  
if ($('#color').val().length !== 0)
{
$(".test").hide();

}
else {
$(".test").show();
}


});

});
</script>

@endpush
