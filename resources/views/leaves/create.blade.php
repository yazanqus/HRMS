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
                                            {{-- <a href="#" id="output" class="btn btn-sm btn-primary"></a> --}}

                                        </div>

                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label px-1">Reason/Comment<small>(Optional)</small></label>
                                                 <input class="form-control form-outline" type="text" id="reason" autocomplete="off" name="reason" placeholder="">

                                                </div>
                                            <div class="form-group   col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">Attachment <small>(Image or PDF)</small></label>
                                                 <input class="form-control-file form-outline" type="file" name="file" id="file" placeholder="" >

                                                </div>
                                            {{-- <a href="#" id="output" class="btn btn-sm btn-primary"></a> --}}

                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group  col-sm-4 flex-column d-flex">
                                                 <label id="labelnumofdays" class="form-control-label  px-1">Number of Days</label>
                                                 <input class="form-control form-outline " type="text" id="numofdays" readonly name="numofdays" placeholder="Enter Start date and End date...">
                                                </div>
                                            {{-- <a href="#" id="output" class="btn btn-sm btn-primary"></a> --}}

                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="justify-content-center form-group col-sm-2"> <button type="submit" class="btn bg-gradient-primary btn-block">Submit</button> </div>
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
<script src="{{ asset('select/js/bootstrap-select.min.js')}}"></script>



<script>
$(document).ready(function() {
$('#leavetype_id').on('change',function(){
    if ($(this).val() == '13' || $(this).val() == '14' || $(this).val() == '16' || $(this).val() == '17' || $(this).val() == '19'  ) {
        $('#end_date').prop('readonly',true);
        $('#numofdays').hide();
        $('#labelnumofdays').hide();
    }
    else {
        $('#end_date').prop('readonly',false);
        $('#numofdays').show();
        $('#labelnumofdays').show();
    }
    if ($('#end_date').is('[readonly]')) {
   var myInput = $('#start_date');
   myInput.change(function() {
       $('#end_date').val(myInput.val());
   });
    }
});

$('#end_date,#start_date').on('change',function(){
var start = $('#start_date').val();
var end = $('#end_date').val();

// end - start returns difference in milliseconds
var startt = new Date(start);
var endd = new Date (end);
var diff = endd - startt ;
// get days
var days = diff/1000/60/60/24 + 1 || 0;


$('#numofdays').val(days);


});

});
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
