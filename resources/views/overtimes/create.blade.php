@extends('layouts.app', ['activePage' => 'createleave', 'titlePage' => ('creating leave')])

@section('content')
  <div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title ">New Overtime</h4>
                    <p class="card-category">Submit a new overtime</p>
                </div>
                    <div class="container py-5 h-100">
                      <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-10 col-xl-10">
                          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">New Overtime</h3>
                              <form action="{{ route('overtimes.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Overtime Type<small>(Permission on HRMS)</small></label> <div class="form-check">
                                        <input  class="btn-check"  type="radio" name="type" id="weekday" Value="weekday" >
                                        <label class="form-check-label" for="weekday">
                                          Weekday overtime
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input  class="btn-check" type="radio" name="type" id="weekend" Value="weekend"  >
                                        <label class="form-check-label" for="weekend">
                                          Weekend overtime
                                        </label>
                                      </div> </div>
                                  <div class="col-md-6 mb-6">

                                    <div class="form-outline ">

                                      <input id="date" name="date" type="text" autocomplete="off" class="form-control  form-control-lg" />

                                      <label for="date" class="form-label" >Date</label>
                                    </div>

                                  </div>

                                  <div class="col-md-6 mb-6">

                                    <div class="form-outline">
                                      <input type="time" name="start_hour" class="form-control form-control-lg" />
                                      <label class="form-label" >Start Hour</label>
                                    </div>

                                  </div>

                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="time" name="end_hour" class="form-control form-control-lg" />
                                        <label class="form-label" >End Hour</label>
                                      </div>

                                    </div>



                                </div>





                                <div class="mt-4 pt-2">
                                  <input class="btn btn-primary btn-lg" type="submit" value="Add" />
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


    </div>
  </div>
@endsection

@push('scripts')

  <!-- DataTables  & Plugins -->
{{--class="datepicker"
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

  <script>

// $(document).ready(function() {

//     // else if  (this.value == 'weekday')
//     // {

//     // }
//   });
// });

$(document).ready(function(){
$(".datepicker").datepicker("update", new Date());
$("input[type=radio][name=type]").change (function() {
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

if  (this.value == 'weekday') {
    var options={
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        weekStart: 0,
    daysOfWeekDisabled: "5,6",
    daysOfWeekHighlighted: "5,6"
      };
}

else if (this.value == 'weekend')
{
    var options={
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        weekStart: 0,
    daysOfWeekDisabled: "0,1,2,3,4",
    daysOfWeekHighlighted: "0,1,2,3,4"
      };
}
date_input.datepicker(options);

    });
});
</script>
@endpush
