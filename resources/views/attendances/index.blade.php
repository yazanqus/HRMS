@extends('layouts.app', ['activePage' => 'attendnace', 'titlePage' => __('attendnace')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mb-6">
                    <div class="text">
                        {{-- @foreach ($users as $user) --}}
                        {{-- <h4>Welcome <b>{{$user->name}}</b> </h4> --}}
                        {{-- @endforeach --}}
                    </div>
                </div>
            </div>
            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h5 class="card-text ">My Attendance - <strong>2022</strong></h5>
                            {{-- <p class="card-category">Here you can see the history of overtimes</p> --}}
                          </div>

<div class="card-body">

                            <div class="card-deck" >
                                <div class="card text-center ml-4 mb-4  mr-4 " style=" height: 6rem;">
                                  <div class="card-body card-body-primary align-items-center d-flex justify-content-center"  >
                                    <h4 class="card-text ">January</h4>
                                  </div>
                                </div>
                                <div class="card mb-4 mr-4">
                                    <div class="card-body text-center card-body-primary align-items-center d-flex justify-content-center">
                                      <h4 class="card-text text-center">January</h4>
                                      <p class="card-category text-center"></p>
                                    </div>
                                  </div>
                                  <div class="card text-center mb-4 mr-4">
                                    <div class="card-body card-body-primary align-items-center d-flex justify-content-center">
                                      <h4 class="card-text">January</h4>
                                    </div>
                                  </div>
                                </div>
                                <div class="card-deck">
                                    <div class="card text-center ml-4 mb-4 mr-4 " style=" height: 6rem;">
                                      <div class="card-body card-body-primary align-items-center d-flex justify-content-center">
                                        <h4 class="card-text">January</h4>
                                      </div>
                                    </div>
                                    <div class="card mb-4 mr-4">
                                        <div class="card-body text-center card-body-primary align-items-center d-flex justify-content-center">
                                          <h4 class="card-text text-center">January</h4>
                                          <p class="card-category text-center"></p>
                                        </div>
                                      </div>
                                      <div class="card text-center mb-4 mr-4">
                                        <div class="card-body card-body-primary align-items-center d-flex justify-content-center">
                                          <h4 class="card-text">January</h4>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="card-deck">
                                        <div class="card text-center ml-4 mb-4 mr-4" style=" height: 6rem;">
                                          <div class="card-body card-body-primary align-items-center d-flex justify-content-center">
                                            <h4 class="card-text">January</h4>
                                          </div>
                                        </div>
                                        <div class="card mb-4 mr-4">
                                            <div class="card-body text-center card-body-primary align-items-center d-flex justify-content-center">
                                              <h4 class="card-text text-center">January</h4>
                                              <p class="card-category text-center"></p>
                                            </div>
                                          </div>
                                          <div class="card text-center mb-4 mr-4">
                                            <div class="card-body card-body-primary align-items-center d-flex justify-content-center">
                                              <h4 class="card-text">January</h4>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card-deck">
                                            <div class="card text-center ml-4 mb-4 mr-4" style=" height: 6rem;">
                                              <div class="card-body card-body-primary align-items-center d-flex justify-content-center">
                                                <h4 class="card-text">January</h4>
                                              </div>
                                            </div>
                                            <div class="card mb-4 mr-4">
                                                <div class="card-body text-center card-body-primary align-items-center d-flex justify-content-center">
                                                  <h4 class="card-text text-center">January</h4>
                                                  <p class="card-category text-center"></p>
                                                </div>
                                              </div>
                                              <div class="card text-center mb-4 mr-4">
                                                <div class="card-body card-body-primary align-items-center d-flex justify-content-center">
                                                  <h4 class="card-text">January</h4>
                                                </div>
                                              </div>
                                            </div>
</div>
                    </div>

                    {{-- <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-text ">Leaves - Remaining balance</h4>

                        </div>
                        <div class="card-body">

                          <div class="row">
                              <div class="col">
                                  <strong>Annual Leave:</strong> {{$balance1}}
                                  <br>
                                  <strong>Sick leave:</strong> {{$balance2}}
                                  <br>
                                  <strong>Compensation leave:</strong> {{$balance18}}

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
