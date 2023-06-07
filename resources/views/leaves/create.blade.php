@extends('layouts.app', ['activePage' => 'my-leaves', 'titlePage' => ('creating leave')])

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

                <div class="container-fluid">
                    <div class="card">
                      <div style=" background-color: #ffb678 !important;" class="card-header card-header-primary">
                        <h4 class="card-title "><a href="{{ URL::previous() }}"> <i  class="fas fa-arrow-alt-circle-left"></i> </a>{{__('createLeave.newLeave')}}</h4>
                      </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-1 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-4">
                                     
                                      <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <div class="form-outline">
                                                    <label class="form-control-label required px-1">{{__('createLeave.leaveType')}}</label>
                                                    <a class="text" style="color: #5a8efc;" id="reset" href="" > {{__('createLeave.changetype')}}
                                                    <i class="fas fa-sync-alt" style="color: #5a8efc;"></i>
                                                    </a>
                                                    <select
                                                    class="form-control selectpicker" data-size="6" data-style="btn btn-outline-secondary"
                                                    name="leavetype_id" id="leavetype_id" type="text"
                                                    placeholder="{{ __('Leave Type') }}"
                                                    required>
                                                    <!-- @foreach ($leavetypes as $leavetype)
                                                        <option value="{{ $leavetype->id }}"> {{__("databaseLeaves.$leavetype->name")}} </option>
                                                    @endforeach -->

                                                    @php
                                        $user = Auth::user();
                                        @endphp
                                        @if($user->contract == "Service")
                                        <option value="1">{{__('createLeave.AnnualLeave')}}</option>
                                        <option value="13">{{__('createLeave.AnnualleaveFirsthalf')}}</option>
                                                    <option value="14">{{__('createLeave.AnnualleaveSecondhalf')}}</option>
                                                    <option value="15">{{__('createLeave.Unpaidleave')}}</option>
                                                    <option value="16">{{__('createLeave.UnpaidleaveFirsthalf')}}</option>
                                                    <option value="17">{{__('createLeave.UnpaidleaveSecondhalf')}}</option>
                                                    <option value="18">{{__('createLeave.Compensation')}}</option>
                                                    <option value="19">{{__('createLeave.Compensationhours')}}</option>
                                        @endif
                                     

                                        @if($user->contract !== "Service")

                                       



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
                                                    @endif

                                                </select>
                                                
                                                </div>
                                              </div>
   
                                        </div>

                                        <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('start_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label required px-1">{{__('createLeave.startDate')}}</label>
                                                 <input class="form-control form-outline  {{ $errors->has('start_date') ? ' is-invalid' : '' }} " type="date" id="start_date"  name="start_date" placeholder="">
                                                 @if ($errors->has('start_date'))
                                                <span id="start_date-error" class="error text-danger" for="input-start_date">{{ $errors->first('start_date') }}</span>
                                               @endif
                                                </div>
                                            <div class="form-group  {{ $errors->has('end_date') ? ' has-danger' : '' }}  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">{{__('createLeave.endDate')}}</label>
                                                 <input class="form-control form-outline {{ $errors->has('end_date') ? ' is-invalid' : '' }}" type="date" name="end_date" id="end_date" placeholder="" >
                                                 @if ($errors->has('end_date'))
                                                 <span id="end_date-error" class="error text-danger" for="input-end_date">{{ $errors->first('end_date') }}</span>
                                                @endif
                                                </div>

                                                <div class="form-group col-sm-4 flex-column d-flex">
                                                    <label  id="hourslabel" class="form-control-label required px-1">{{__('createLeave.hours')}}<small>({{__('createLeave.between')}} 1 {{__('createLeave.and')}} 7)</small></label>
                                                    <span  id="minus" class="minus">-</span>
                                                    <input  type="text" id="hours" name="hours" required readonly value="1"/>
                                                    <span  class="plus" id="plus">+</span>
                                                    
                                                    
                                                </div>


                                                
                                        </div>

                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label px-1">{{__('createLeave.reason')}}/{{__('createLeave.comment')}}</small></label>
                                                 <input class="form-control form-outline" type="text" id="reason" autocomplete="off" name="reason" placeholder="">

                                                </div>
                                            <div class="form-group {{ $errors->has('file') ? ' has-danger' : '' }}  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">{{__('createLeave.attachment')}} <small>(Image or PDF - 3 MB Max)</small></label>
                                                 <input class="form-control-file form-outline {{ $errors->has('file') ? ' is-invalid' : '' }}" type="file" name="file" id="file" placeholder="" >
                                                 @if ($errors->has('file'))
                                                 <span id="file-error" class="error text-danger" for="input-file">{{ $errors->first('file') }}</span>
                                                @endif
                                                <br>
                                               
                                        <h5 class= 'sicknote' style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>{{__('createOvertime.sicknote')}}</h5>
                                        
                                        
                                                </div>
                                                
                                            {{-- <a href="#" id="output" class="btn btn-sm btn-primary"></a> --}}

                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-4 flex-column d-flex">
                                                 <label id="labelnumofdays" class="form-control-label  px-1">{{__('createLeave.totalNumberOfDays')}}</label>
                                                 <input class="form-control form-outline " type="text" id="numofdays" readonly name="numofdays" placeholder="{{__('createLeave.enterStartDateAndEndDate')}}">
                                                </div>
                                            {{-- <a href="#" id="output" class="btn btn-sm btn-primary"></a> --}}
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="justify-content-center form-group col-sm-2"> <button type="submit" class="disabled btn-1">{{__('createLeave.submit')}}</button> </div>
                                            <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('leaves.index')}}" >{{__('createLeave.cancel')}}</a> </div>
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

                    	span {cursor:pointer; }
		.number{
			margin:20px;
		}
		.minus, .plus{
			width:40px;
			height:20px;
			background:#CFD1D4;
			border-radius:4px;
			padding:0px 0px 0px 0px;
			border:0px solid #ddd;
      display: inline-block;
      vertical-align: middle;
      text-align: center;
		}

    .btn-1 {
  border: none;
  width: 100%;
  height: 100%;
  color: white;
  background-color: #FF7602;
  border-radius: 4px;
  box-shadow: inset 0 0 0 0 #14489e;

}
.btn-1.activate {
  box-shadow: inset 500px 0 0 0 #14489e;
  transition: all 2s;
 

}
		
			
                  </style>

                  





    </div>
  </div>

@endsection

@push('scripts')
<script src="{{ asset('select/js/bootstrap-select.min.js')}}"></script>



<script>
$(document).ready(function() {

 

$(document).on('click', '.btn-1', function () {
  // $(this).find(':submit').attr('disabled','disabled');
$(this).addClass('activate');
$(this).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> `
      );
      
});

// $(document).on('change', 'leavetype_id', function () {
//   $("input[type=date]").val("");
// });
$('.sicknote').hide();
  $('#hourslabel').hide();
        $('#hours').hide();
        $('#minus').hide();
        $('#plus').hide();
$('#reset').hide();

  var sickpercentage;
//   $('.disable').click(function(){
//    $(this).prop('disabled', true);
// });

$('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});


$('#leavetype_id').on('change',function(){

  // $('#leavetype_id').prop("disabled", true); 
  // $('#leavetype_id').prop('disabled', 'disabled');
  $('#start_date').val("");
  $('#end_date').val("");
  $('.dropdown-toggle').prop('disabled', true);
  $('#reset').show();

  if ($(this).val() == '3' || $(this).val() == '4' || $(this).val() == '2' || $(this).val() == '20' || $(this).val() == '21')
    {
      $('.sicknote').show();
     }
     
  if ($(this).val() == '3' || $(this).val() == '4' || $(this).val() == '15')
  {
    sickpercentage = "yes";
    

  }

    else if ($(this).val() == '13' || $(this).val() == '14' || $(this).val() == '16' || $(this).val() == '17' || $(this).val() == '20' || $(this).val() == '21' ) {
        $('#end_date').prop('readonly',true);
        $('#numofdays').hide();
        $('#labelnumofdays').hide();
        sickpercentage = "no";
    }
//19 is the comensation hour leave
    else if ($(this).val() == '19') {
      $('#end_date').prop('readonly',true);
        $('#numofdays').hide();
        $('#labelnumofdays').hide();
        sickpercentage = "no";
        $('#hourslabel').show();
        $('#hours').show();
        $('#minus').show();
        $('#plus').show();
    }
    
    else {
        $('#end_date').prop('readonly',false);
        $('#numofdays').show();
        $('#labelnumofdays').show();
        $('#hourslabel').hide();
        $('#hours').hide();
        $('#minus').hide();
        $('#plus').hide();
        sickpercentage = "no";
    }
    if ($('#end_date').is('[readonly]')) {
      //make the text in end_date the same as start_date
   var myInput = $('#start_date');
   myInput.change(function() {
       $('#end_date').val(myInput.val());
   });
    }
});



$('#end_date,#start_date').on('change',function(){



var start = $('#start_date').val();
var end = $('#end_date').val();

// Copy date objects so don't modify originals
var s = new Date(start);
var e = new Date(end);

// Set time to midday to avoid dalight saving and browser quirks
// s.setHours(12,0,0,0);
// e.setHours(12,0,0,0);

// Get the difference in whole days
// var daa = Math.round((e - s) / 8.64e7);
var difff = e - s;
var daa = difff/1000/60/60/24 + 1 || 0;

// Get the difference in whole weeks
var wholeWeeks = daa / 20 | 0;

// Estimate business days as number of whole weeks * 5
if (s.getDay() != 5 && s.getDay() != 6) {
var days = wholeWeeks * 5 + 1;
}
else
{
    var days = wholeWeeks * 5;
}
if (daa % 20) {
  s.setDate(s.getDate() + wholeWeeks * 7);

  while (s < e) {
    s.setDate(s.getDate() + 1);

    // If day isn't a Sunday or Saturday, add to business days
    if (s.getDay() != 5 && s.getDay() != 6) {
      ++days;
    }
  }
}

if (sickpercentage == 'yes')
{ 
  $("#numofdays").val(daa);
}
  else {
    $("#numofdays").val(days);
  }
// if (days > 0) {
    
    
//   } else {
//     $("#numofdays").val(0);
//   }


// end - start returns difference in milliseconds
// var startt = new Date(start);
// var endd = new Date(end);
// var diff = endd - startt ;
// // get days
// var days = diff/1000/60/60/24 + 1 || 0;
// if (days > 0) {
//     $("#numofdays").val(days);
//   } else {
//     $("#numofdays").val(0);
//   }




});


$('.minus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 1 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('.plus').click(function () {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
        if ($input.val() == '8')
        {
          alert('Sorry, the maximum value was reached');
          $("plus").prop('disabled', true);
          $input.val(7);
        }
				$input.change();
				return false;
			});
// function dateDifference(start, end) {

// // Copy date objects so don't modify originals
// var s = new Date(+start);
// var e = new Date(+end);

// // Set time to midday to avoid dalight saving and browser quirks
// s.setHours(12,0,0,0);
// e.setHours(12,0,0,0);

// // Get the difference in whole days
// var totalDays = Math.round((e - s) / 8.64e7);

// // Get the difference in whole weeks
// var wholeWeeks = totalDays / 7 | 0;

// // Estimate business days as number of whole weeks * 5
// var days = wholeWeeks * 5;

// // If not even number of weeks, calc remaining weekend days
// if (totalDays % 7) {
//   s.setDate(s.getDate() + wholeWeeks * 7);

//   while (s < e) {
//     s.setDate(s.getDate() + 1);

//     // If day isn't a Sunday or Saturday, add to business days
//     if (s.getDay() != 0 && s.getDay() != 6) {
//       ++days;
//     }
//   }
// }
// return days;
// }

});


// asdasdasdasdasdasd



</script>


@endpush
