@extends('layouts.app', ['activePage' => 'holidays', 'titlePage' => ('users create')])

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
                        <h4 class="card-title ">Add Holdiday Calander</h4>
                    </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Holiday details</h3>
                                      <form action="{{ route('admin.holidays.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row justify-content-between text-left">
                                          <div class="col-md-6 mb-6">
                                            <div class="form-outline">
                                              <input type="text" name="name" class="form-control form-control-lg" />
                                              <label class="form-label" >Name</label>
                                            </div>
                                          </div>
                                            <div class="col-md-6 mb-6">
                                              <div class="form-outline">
                                                <input type="text" name="desc" class="form-control form-control-lg" />
                                                <label class="form-label" >Desc</label>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-6">
                                              <div class="form-outline">
                                                <input type="date" name="start_date" class="form-control form-control-lg" />
                                                <label class="form-label" >Start Date</label>
                                              </div>
                                            </div>
                                              <div class="col-md-6 mb-6">
                                                <div class="form-outline">
                                                  <input type="date" name="end_date" class="form-control form-control-lg" />
                                                  <label class="form-label" >Last Date</label>
                                                </div>
                                              </div>
                                          </div>
                                        <div class="row">
                                            <div class="form-outline">
                                                <input type="file" name="file" class="form-control">
                                              </div>
                                          </div>
                                          <br>
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
