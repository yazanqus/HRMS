@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col ml-3">
                    <div class="text">
                        {{-- @foreach ($users as $user) --}}
                        <br>
                        <h3> <b>{{$user->name}} <a href="{{route('admin.users.edit', $user)}}" role="button" class="btn btn-sm btn-outline-primary">Edit  <i class="ml-2 fas fa-lg fa-user-cog"></i></a></b> </h3>
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
                                <a href="{{route('admin.users.edit', $user)}}" class="btn btn-sm btn-primary">Edit</a>
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
                              </div>
                              <div class="col">
                                <strong>Position: </strong> {{$user->position}}
                                <br>
                                <strong>Grade: </strong> {{$user->grade}}
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
                          <h4 class="card-title ">Additionl information</h4>
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
                                    @php
                                    if ($user->usertype_id == "2") {
                                      $role = "Line Manager";
                                    }
                                    else {
                                        $role = "Staff";
                                    }
                                    @endphp
                                  <strong>Role</strong> <small>(Staff or Line Manger)</small>: {{$role}}
                                  <br>
                                  @php
                                      if ($user->hradmin == "yes") {
                                      $admin = "Admin";
                                    }

                                    else {
                                        $admin = "Not Admin";
                                    }
                                  @endphp
                                  <strong>Permission in HR System:</strong> {{$admin}}
                                </div>
                                <div class="col">
                                  <strong>User Created on System at:</strong> {{$user->created_at}}
                                  <br>
                                  <strong>Info last updated:</strong> {{$user->updated_at}}
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
                                <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="btn btn-sm btn-outline-primary">Edit  <i class="ml-2 fas fa-lg fa-user-cog"></i></a>
                                  <strong>Annual Leave:</strong> {{$balance1}}
                                  <br>
                                  <strong>Sick leave:</strong> {{$balance2}}
                                  <br>
                                  <strong>Sick leave 30% deduction:</strong> {{$balance3}}
                                    <br>
                                    <strong>Sick leave 20% deduction</strong> {{$balance4}}
                                    <br>
                                  <strong>Marriage leave:</strong> {{$balance5}}
                                    <br>
                                    <strong>Welfare leave:</strong> {{$balance12}}
                                </div>

                                <div class="col">
                                    <strong>Unpaid leave:</strong> {{$balance15}}
                                    <br>
                                    <strong>Maternity leave:</strong> {{$balance8}}
                                    <br>
                                    <strong>Paternity leave:</strong> {{$balance9}}
                                    <br>
                                  <strong>Compassionate - Second degree:</strong> {{$balance7}}
                                  <br>
                                {{-- <strong>Annual Leave:</strong> {{$balance1}}
                                  <br> --}}
                                  <strong>Compassionate - First degree:</strong> {{$balance6}}
                                  <br>
                                  <strong>Compansetion:</strong> {{$balance18}}
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

@push('scripts')
  {{-- <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script> --}}
@endpush
