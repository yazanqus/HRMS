@extends('layouts.app', ['activePage' => 'create-new-user', 'titlePage' => ('users create')])

@section('content')
  <div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title ">Employees</h4>
                    <p class="card-category">Add a new Employee</p>
                </div>
                    <div class="container py-5 h-100">
                      <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-10 col-xl-10">
                          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Onboarding details</h3>
                              <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                  <div class="col-md-6 mb-6">

                                    <div class="form-outline">
                                      <input type="text" name="name" class="form-control form-control-lg" />
                                      <label class="form-label" >Name</label>
                                    </div>

                                  </div>

                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="date" name="birth_date" class="form-control form-control-lg" />
                                        <label class="form-label" >Birth date</label>
                                      </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="text" name="unit" class="form-control form-control-lg" />
                                        <label class="form-label" >Unit</label>
                                      </div>

                                    </div>

                                      <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="text" name="position" class="form-control form-control-lg" />
                                          <label class="form-label" >Position</label>
                                        </div>

                                      </div>

                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-md-6 mb-6">

                                        <div class="form-group">
                                            <input type="text" list="FavoriteColor" id="color" name="linemanager" autocomplete="off">

                                                <datalist id="FavoriteColor">
                                                    @foreach ($users as $user)

                                                        <option value="{{$user->name}}"> </option>

                                                    @endforeach

                                                </datalist>
                                                </p>




                                            {{-- <select

                                            class="form-control"
                                            name="linemanager" id="input-room_id" type="text"
                                            placeholder="{{ __('Line Manager') }}"
                                            required>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"> {{$user->name}} </option>
                                            @endforeach
                                        </select> --}}
                                        <label class="form-label" >Line Manager</label>

                                          </div>


                                      {{-- <div class="form-outline">
                                        <input type="text" name="linemanager" class="form-control form-control-lg" />
                                        <label class="form-label" >Line Manager</label>
                                      </div> --}}

                                    </div>


                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="date" name="joined_date" class="form-control form-control-lg" />
                                        <label class="form-label" >Joined Date</label>
                                      </div>

                                    </div>

                                    <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="text" name="employee_number" class="form-control form-control-lg" />
                                          <label class="form-label" >Employee Number</label>
                                        </div>

                                      </div>

                                      <div class="col-md-6 mb-6">

                                        <div class="form-outline">
                                          <input type="password" name="password" class="form-control form-control-lg" />
                                          <label class="form-label" >Password</label>
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
