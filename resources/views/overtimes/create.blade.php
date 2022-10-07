@extends('layouts.app', ['activePage' => 'createleave', 'titlePage' => ('creating leave')])

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
                        <h4 class="card-title ">New Overtime</h4>
                    </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">New Overtime</h3>
                                      <form action="{{ route('overtimes.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row justify-content-between text-left">
                                        <div id="type" class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-1">Overtime Type</label>
                                        @php
                                        $user = Auth::user();
                                        if($user->contract == "Service")
                                        {
                                          $contract='service';
                                        }
                                        else
                                        {
                                          $contract='notservice';
                                        }

                                        @endphp
                                        @if ($contract=='service')
                                        <div class="form-check">
                                                <input  class="btn-check" type="radio" name="type" id="holiday" Value="SC-overtime"  >
                                                <label class="form-check-label" id="holidaylabel" for="holiday">
                                                  Service Contract Overtime
                                                </label>
                                              </div>
                                        @endif
                                        @if ($contract=='notservice')
                                          
                                        
                                            
                                                 
                                                 <div class="form-check">
                                                <input  class="btn-check"  type="radio" name="type" id="weekday" Value="weekday">
                                                <label class="form-check-label" id="weekdaylabel" for="weekday">
                                                  Weekday <small>(Sun to Thu)</small>
                                                </label>
                                              </div>
                                              <div class="form-check">
                                                <input  class="btn-check" type="radio" name="type" id="weekend" Value="week-end"  >
                                                <label class="form-check-label" id="weekendlabel" for="weekend">
                                                  Week-end <small>(Fri or Sat)</small>
                                                </label>
                                              </div>
                                              <div class="form-check">
                                                <input  class="btn-check" type="radio" name="type" id="holiday" Value="holiday"  >
                                                <label class="form-check-label" id="holidaylabel" for="holiday">
                                                  Holiday
                                                </label>
                                              </div>
                                              @endif
                                            </div>

                                          <div class="form-group  {{ $errors->has('date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex" >
                                              <label for="date" class="form-control-label required px-1" >Date</label>
                                              <div class="input-group">
                                              <input   onkeydown="event.preventDefault()" id="datepicker" placeholder="Choose Overtime Type first" name="date" type="text" autocomplete="off" class="form-control form-outline {{ $errors->has('date') ? ' is-invalid' : '' }}" />
                                              <div class="input-group-append">
                                                  <div class="input-group-text ">
                                                    <i class="fas fa-calendar-alt"></i>
                                                  </div>
                                                </div>
                                              </div>
                                              @if ($errors->has('date'))
                                                 <span id="date-error" class="error text-danger" for="input-date">{{ $errors->first('date') }}</span>
                                                @endif
                                          </div>


<!-- <section class="container">
  <h2 class="py-2">Datepicker in Bootstrap 5</h2>
  <form class="row">
    <label for="date" class="col-1 col-form-label">Date</label>
    <div class="col-5">
      <div class="input-group date" id="datepicker">
        <input type="text" name="date" class="form-control" id="date"/>
        <span class="input-group-append">
          <span class="input-group-text bg-light d-block">
            <i class="fa fa-calendar"></i>
          </span>
        </span>
      </div>
    </div>
  </form>
</section> -->



                                          {{-- <div class="row justify-content-between text-left"> --}}
                                              <div class="form-group {{ $errors->has('start_hour') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                  <label class="form-control-label required px-1" >Start Hour</label>
                                                  <input type="time" name="start_hour" class="form-control form-outline {{ $errors->has('start_hour') ? ' is-invalid' : '' }}" />
                                                  @if ($errors->has('start_hour'))
                                                 <span id="start_hour-error" class="error text-danger" for="input-start_hour">{{ $errors->first('start_hour') }}</span>
                                                @endif
                                              </div>
                                                <div class="form-group {{ $errors->has('end_hour') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label required px-1" >End Hour</label>
                                                    <input type="time" name="end_hour" class="form-control form-outline {{ $errors->has('end_hour') ? ' is-invalid' : '' }}" />
                                                    @if ($errors->has('end_hour'))
                                                 <span id="end_hour-error" class="error text-danger" for="input-end_hour">{{ $errors->first('end_hour') }}</span>
                                                @endif
                                                </div>
                                                {{-- new row --}}
                                                <div class="form-group {{ $errors->has('reason') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label required px-1" >Reason/Comment</label>
                                                    <input type="text" id="reason" autocomplete="off" name="reason" placeholder="" class="form-control form-outline {{ $errors->has('reason') ? ' is-invalid' : '' }} " />
                                                    @if ($errors->has('reason'))
                                                 <span id="reason-error" class="error text-danger" for="input-reason">{{ $errors->first('reason') }}</span>
                                                @endif
                                                </div>
                                                  <div class="form-group {{ $errors->has('file') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                      <label class="form-control-label  px-1" >Attachment <small>(Image or PDF - 3 MB Max)</small></label>
                                                      <input  type="file" name="file" id="file" class="form-control-file form-outline {{ $errors->has('file') ? ' is-invalid' : '' }}" />
                                                      @if ($errors->has('file'))
                                                 <span id="file-error" class="error text-danger" for="input-file">{{ $errors->first('file') }}</span>
                                                @endif

                                                  </div>
                                                  
                                          {{-- </div> --}}
                                        </div>
                                        <br>
                                        <div class="row justify-content-center">
                                            <div class="justify-content-center form-group col-sm-2"> <button type="submit" class="btn bg-gradient-primary btn-block">Submit</button> </div>
                                            <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('leaves.index')}}" >Cancel</a> </div>
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
                <br>

                <style>
                    .required:after {
                      content:" *";
                      color: red;
                    }
                  </style>



    </div>
  </div>
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
<script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
    ></script>
<script>



$(document).ready(function() {

  

 

var weekday;
  
$("input[name=type]:radio").change(function(){
    if ($("#weekday").prop("checked")) {
      $('#weekend').hide();
      $('#weekendlabel').hide();
      $('#holiday').hide();
      $('#holidaylabel').hide();
      weekday = "5,6";
      $('#datepicker').datepicker({ 
    format: 'yyyy-mm-dd',
    weekStart: 0,
    clearBtn: true,
    autoclose: true,
    todayHighlight: true,
daysOfWeekDisabled: weekday
  });
    }
   else if ($("#weekend").prop("checked")) {
     weekday = "0,1,2,3,4";
     $('#weekday').hide();
      $('#weekdaylabel').hide();
      $('#holiday').hide();
      $('#holidaylabel').hide();
      $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
    weekStart: 0,
    clearBtn: true,
    autoclose: true,
    todayHighlight: true,
daysOfWeekDisabled: weekday
  });
    }
    else if ($("#holiday").prop("checked"))
    {
      $('#weekday').hide();
      $('#weekdaylabel').hide();
      $('#weekend').hide();
      $('#weekendlabel').hide();
      $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
    weekStart: 0,
    clearBtn: true,
    autoclose: true,
    todayHighlight: true,

  });
    }

  });


});

    </script>

@endpush
