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
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">New Leave</h4>
                      </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">New Leave</h3>
                                      <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <div class="form-outline">
                                                    <label class="form-control-label px-1">Leave type</label>
                                                    <select
                                                    class="form-control selectpicker" data-size="5" data-style="btn btn-outline-secondary"
                                                    name="leavetype_id" id="leavetype_id" type="text"
                                                    placeholder="{{ __('Leave Type') }}"
                                                    required>
                                                    @foreach ($leavetypes as $leavetype)
                                                        <option value="{{ $leavetype->id }}"> {{$leavetype->name}} </option>
                                                    @endforeach
                                                </select>
                                                </div>
                                              </div>
                                        </div>

                                        <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('start_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label required px-1">Start date</label>
                                                 <input class="form-control form-outline  {{ $errors->has('start_date') ? ' is-invalid' : '' }} " type="date" id="start_date"  name="start_date" placeholder="">
                                                 @if ($errors->has('start_date'))
                                                <span id="start_date-error" class="error text-danger" for="input-start_date">{{ $errors->first('start_date') }}</span>
                                               @endif
                                                </div>
                                            <div class="form-group  {{ $errors->has('end_date') ? ' has-danger' : '' }}  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">End date</label>
                                                 <input class="form-control form-outline {{ $errors->has('end_date') ? ' is-invalid' : '' }}" type="date" name="end_date" id="end_date" placeholder="" >
                                                 @if ($errors->has('end_date'))
                                                 <span id="end_date-error" class="error text-danger" for="input-end_date">{{ $errors->first('end_date') }}</span>
                                                @endif
                                                </div>

                                                <div class="form-group col-sm-4 flex-column d-flex">
                                                    <label  id="hourslabel" class="form-control-label required px-1">Hours <small>(Between 1 and 7)</small></label>
                                                    <span  id="minus" class="minus">-</span>
                                                    <input  type="text" id="hours" name="hours" required readonly value="1"/>
                                                    <span  class="plus" id="plus">+</span>
                                                    
                                                    <!-- <select
                                                    class="form-control selectpicker" data-size="7" data-style="btn btn-outline-secondary"
                                                    name="hours" id="hours" type="text"
                                                    required>
                                                   
                                                        <option value="0.125"> 1 Hour </option>
                                                        <option value="0.25"> 2 Hours </option>
                                                        <option value="0.375"> 3 Hours </option>
                                                        <option value="0.5"> 4 Hours </option>
                                                        <option value="0.625"> 5 Hours </option>
                                                        <option value="0.75"> 6 Hours </option>
                                                        <option value="0.875"> 7 Hours </option>
                                                    
                                                </select> -->
                                                </div>

                                                <!-- <div class="number">
                                                    
                                                  </div> -->

                                                
                                        </div>

                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label px-1">Reason/Comment</small></label>
                                                 <input class="form-control form-outline" type="text" id="reason" autocomplete="off" name="reason" placeholder="">

                                                </div>
                                            <div class="form-group {{ $errors->has('file') ? ' has-danger' : '' }}  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Attachment <small>(Image or PDF - 3 MB Max)</small></label>
                                                 <input class="form-control-file form-outline {{ $errors->has('file') ? ' is-invalid' : '' }}" type="file" name="file" id="file" placeholder="" >
                                                 @if ($errors->has('file'))
                                                 <span id="file-error" class="error text-danger" for="input-file">{{ $errors->first('file') }}</span>
                                                @endif
                                                </div>
                                            {{-- <a href="#" id="output" class="btn btn-sm btn-primary"></a> --}}

                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-4 flex-column d-flex">
                                                 <label id="labelnumofdays" class="form-control-label  px-1">Total Number of Days</label>
                                                 <input class="form-control form-outline " type="text" id="numofdays" readonly name="numofdays" placeholder="Enter Start date and End date...">
                                                </div>
                                            {{-- <a href="#" id="output" class="btn btn-sm btn-primary"></a> --}}

                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="justify-content-center form-group col-sm-2"> <button type="submit" class=" disable btn bg-gradient-primary btn-block">Submit</button> </div>
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
		
			
                  </style>

                  





    </div>
  </div>

@endsection

@push('scripts')
<script src="{{ asset('select/js/bootstrap-select.min.js')}}"></script>



<script>
$(document).ready(function() {
  $('#hourslabel').hide();
        $('#hours').hide();
        $('#minus').hide();
        $('#plus').hide();

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
  $('.dropdown-toggle').prop('disabled', true);
  

  
  if ($(this).val() == '3' || $(this).val() == '4')
  {
    sickpercentage = "yes";
    

  }

    else if ($(this).val() == '13' || $(this).val() == '14' || $(this).val() == '16' || $(this).val() == '17' ) {
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
var wholeWeeks = daa / 7 | 0;

// Estimate business days as number of whole weeks * 5
if (s.getDay() != 5 && s.getDay() != 6) {
var days = wholeWeeks * 5 + 1;
}
else
{
    var days = wholeWeeks * 5;
}
if (daa % 7) {
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

{{-- <script>
function comparedates()
{
    var date1=new Date(document.getElementById('start_date').value);
    var date2=new Date(document.getElementById('end_date').value);

    var Difference_In_Time = date2.getTime() - date1.getTime();
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

    var result;

    result=Difference_In_Days;
    document.getElementById('output').style.color='green';

    if()
}
</script> --}}
@endpush
