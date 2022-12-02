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
                                <strong>Full Name: </strong> {{$user->name}}
                                <br>
                                <strong>Birth date: </strong> {{$user->birth_date}}
                                <br>
                                <strong>Email: </strong> {{$user->email}}
                                <br>
                                <strong>Employee ID: </strong> {{$user->employee_number}}
                                <br>
                                <strong>Contract Type: </strong> {{$user->contract}}
                                <br>
                                <strong>Office: </strong> {{$user->office}}
                              </div>
                              <div class="col">

                                <strong>Position: </strong> {{$user->position}}
                                  <br>
                                  <strong>Joined Date: </strong> {{$user->joined_date}}
                                  <br>
                                <strong>Line Manager: </strong> {{$user->linemanager}}
                              </div>
                        </div>
                        {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">Leaves - Remaining balance</h4>
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
                                  <strong>Annual Leave:</strong> {{$balance1}}
                                  <br>
                                  <strong>Sick leave:</strong> {{$balance2}}
                                  <br>
                                  <strong>Compensation leave days:</strong> {{$balance18}}

                                </div>

                          </div>
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Leaves - Taken</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col">
                          <strong>Annual Leave:</strong> {{$balance1}}
                          <br>
                          <strong>Sick leave:</strong> {{$balance2}}

                        </div>

                  </div>
        </div>
    </div> --}}
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
