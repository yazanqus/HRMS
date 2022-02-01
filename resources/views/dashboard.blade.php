@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

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
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">Personal information</h4>
                        <p class="card-category"></p>
                      </div>
                      <div class="card-body">
                          {{-- <div class="row">
                              <div   div class="col-12 text-right">
                                <a href="#" class="btn btn-sm btn-primary">Add Holiday</a>
                              </div>
                          </div> --}}
                        <div class="row">
                            <div class="col">
                                Full Name: {{$user->name}}
                                <br>
                                Birth date: {{$user->birth_date}}
                                <br>
                                Unit: {{$user->unit}}
                                <br>
                                Employee ID: {{$user->employee_number}}
                              </div>
                              <div class="col">
                                Position: {{$user->position}}
                                  <br>
                                Line Manager: {{$user->linemanager}}
                              </div>
                        </div>
                        {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">Leave Balance</h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div   div class="col-12 text-right">
                                  <a href="#" class="btn btn-sm btn-primary">Add Holiday</a>
                                </div>
                            </div> --}}
                          <div class="row">
                              <div class="col">
                                  Remaining: {{$balance}}
                                </div>
                                <div class="col">
                                  Leaves Taken: {{$user->linemanager}}
                                </div>
                          </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@push('js')
  {{-- <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script> --}}
@endpush
