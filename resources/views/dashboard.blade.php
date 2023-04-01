@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

    <div class="img-responsive img-fluid w-100 bg-image" 
     style=" background-position: center;
  background-repeat: no-repeat;
  background-size: cover; background-image: url('/nrccover.png');
            height: 100vh">
    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-4 mb-6">
                    <div class="text">
                        {{-- @foreach ($users as $user) --}}
                        {{-- <h3>Welcome <b>{{$user->name}}</b> </h3> --}}
                        {{-- @endforeach --}}
                    </div>
                </div>
            </div>
            <br>
          
            
            <div class="content">
              <div class="row">
                <!-- <div class="container-fluid"> -->
                    <div  class="card mx-4 col-md-8">
                      <div style=" background-color: #ffb678 !important;" class="card-header card-header-primary">
                        <h4 class="card-title "><strong>{{__('welcome.personalInformation')}}</strong></h4>
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
                            <strong>{{__('welcome.fullName')}}: </strong> {{$user->name}}
                                <br>
                                <!-- <strong>{{__('welcome.birthDate')}}: </strong> {{$user->birth_date}}
                                <br> -->
                                <strong>{{__('welcome.email')}}: </strong> {{$user->email}}
                                <br>
                                <strong>{{__('welcome.employeeId')}}: </strong> {{$user->employee_number}}
                                <br>
                                <strong>{{__('welcome.contractType')}}: </strong> {{$user->contract}}
                                <br>
                                <strong>{{__('welcome.office')}}: </strong> {{$user->office}}
                              </div>
                              <div class="col">

                                <strong>{{__('welcome.position')}}: </strong> {{$user->position}}
                                  <br>
                                  <strong>{{__('welcome.grade')}}: </strong> {{$user->grade}}
                                  <br>
                                  <strong>{{__('welcome.joinedDate')}}: </strong> {{$user->joined_date}}
                                  <br>
                                <strong>{{__('welcome.lineManager')}}: </strong> {{$user->linemanager}}
                              </div>
                        </div>
                        
                      </div>
                    </div>
                    <!-- <div class="card mx-3 col-md-3 ">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('welcome.leaves')}} - {{__('welcome.remainingBalance')}}</h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                    
                          <div class="row">
                              <div class="col">
                                  <strong>{{__('welcome.annualLeave')}}:</strong> {{$balance1}}
                                  <br>
                                  <strong>{{__('welcome.sickLeave')}}:</strong> {{$balance2}}
                                  <br>
                                <strong>{{__('welcome.compensationLeaveDays')}}:</strong> {{$balance18}}

                                </div>

                          </div>
                </div>
            </div> -->
            </div>
            <div class="row">
            <div class="card ml-4 mr-4 col-md-4 ">
                        <div style=" background-color: #ffb678 !important;"  class="card-header card-header-primary">
                          <h4 class="card-title "><strong>{{__('welcome.leaves')}} - {{__('welcome.remainingBalance')}}</strong></h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                    
                          <div class="row">
                              <div class="col">
                                  <strong>{{__('welcome.annualLeave')}}:</strong> {{$balance1}}
                                  <br>
                                  <strong>{{__('welcome.sickLeave')}}:</strong> {{$balance2}}
                                  <br>
                                <strong>{{__('welcome.compensationLeaveDays')}}:</strong> {{$balance18}} - <a href="{{ route('comlists.index') }}"><strong>({{__('comlists.dashboard')}})</strong></a>

                                </div>

                          </div>
                </div>
            </div>
            </div>
            <!-- <div class="container-fluid">
            <div class="row">
           
                    <div class="card bg-light  mt-5 ml-5 mx-5   mr-5 col-2">
                    <img class="mt-4 mb-3 img-fluid mx-auto d-block" style="max-width: 50%; height: 40%;" src="{{url('/running-solid.png')}}"  alt="Card image">
                     <h4 class="text-center">Leave</h4>
                    </div>

                    <div class="card bg-light  mt-5  ml-5 col-2">
                    <img class="mt-4 mb-3 img-fluid mx-auto d-block" style="max-width: 40%; height: 40%;" src="{{url('/adjust-solid.png')}}"  alt="Card image">
                    <h4 class="mb-0 text-center">Overtime</h4>
                    </div>
                    
            </div>
            </div> -->
            

    
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
