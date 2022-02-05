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
                        <h4 class="card-title ">New Leave</h4>
                      </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">New Leave</h3>
                                      <form action="{{ route('leaves.store') }}" method="POST">
                                        @csrf
                                        <div class="row justify-content-between text-left">
                                            <div class="col-md-6 mb-6">
                                                <div class="form-outline">
                                                    <label class="form-control-label px-1">Leave type</label>
                                                    <select
                                                    class="form-control selectpicker" data-size="4" data-style="btn btn-outline-secondary"
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
                                        <br>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">Start date</label> <input class="form-control form-outline" type="date" id="start_date"  name="start_date" placeholder=""> </div>
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">End date</label> <input class="form-control form-outline" type="date" name="end_date" id="end_date" placeholder="" > </div>
                                            {{-- <a href="#" id="output" class="btn btn-sm btn-primary"></a> --}}

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
<script src="{{ asset('select/js/bootstrap-select.min.js')}}"></script>

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
