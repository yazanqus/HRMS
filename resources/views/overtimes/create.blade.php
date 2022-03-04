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
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label px-1">Overtime Type</label>
                                                 <div class="form-check">
                                                <input  class="btn-check"  type="radio" name="type" id="weekday" Value="weekday" checked>
                                                <label class="form-check-label" for="weekday">
                                                  Weekday <small>(Sun to Thu)</small>
                                                </label>
                                              </div>
                                              <div class="form-check">
                                                <input  class="btn-check" type="radio" name="type" id="weekend" Value="week-end"  >
                                                <label class="form-check-label" for="weekend">
                                                  Week-end <small>(Fri or Sat)</small>
                                                </label>
                                              </div>
                                              <div class="form-check">
                                                <input  class="btn-check" type="radio" name="type" id="holiday" Value="holiday"  >
                                                <label class="form-check-label" for="holiday">
                                                  Holiday
                                                </label>
                                              </div>
                                            </div>

                                          <div class="form-group {{ $errors->has('date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                              <label for="date" class="form-control-label required px-1" >Date</label>
                                              <input id="date" name="date" type="date" autocomplete="off" class="form-control form-outline {{ $errors->has('date') ? ' is-invalid' : '' }}" />
                                              @if ($errors->has('date'))
                                                 <span id="date-error" class="error text-danger" for="input-date">{{ $errors->first('date') }}</span>
                                                @endif
                                          </div>

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
                                                <div class="form-group  col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label  px-1" >Reason/Comment<small>(Optional)</small></label>
                                                    <input type="text" id="reason" autocomplete="off" name="reason" placeholder="" class="form-control form-outline " />

                                                </div>
                                                  <div class="form-group col-sm-6 flex-column d-flex">
                                                      <label class="form-control-label  px-1" >Attachment <small>(Image or PDF)</small></label>
                                                      <input  type="file" name="file" id="file" class="form-control-file form-outline" />

                                                  </div>
                                          {{-- </div> --}}
                                        </div>
                                        <br>
                                        <div class="row justify-content-center">
                                            <div class="form-group col-sm-2"> <button type="submit" class="btn bg-gradient-primary btn-block">Submit</button> </div>
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

  <!-- DataTables  & Plugins -->
{{--class="datepicker"
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

  {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script> --}}

  {{-- <script>

// $(document).ready(function() {

//     // else if  (this.value == 'weekday')
//     // {

//     // }
//   });
// });

$(document).ready(function(){
$(".datepicker").datepicker("update", new Date());
// $("input[type=radio][name=type]").change (function() {
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

// if  (this.value == 'weekday') {
    var options={
        format: 'yyyy/mm/dd',
        container: container,
        todayHighlight: true,
        autoclose: true,
        weekStart: 0,
    // daysOfWeekDisabled: "5,6",
    // daysOfWeekHighlighted: "5,6"
      };
// }

// else if (this.value == 'weekend')
// {
//     var options={
//         format: 'dd/mm/yyyy',
//         container: container,
//         todayHighlight: true,
//         autoclose: true,
//         weekStart: 0,
//     daysOfWeekDisabled: "0,1,2,3,4",
//     daysOfWeekHighlighted: "0,1,2,3,4"
//       };
// }
date_input.datepicker(options);

    // });
});
</script> --}}
@endpush
