@extends('layouts.app', ['activePage' => 'createleave', 'titlePage' => ('creating leave')])

@section('content')
  <div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title ">New Overtime</h4>
                    <p class="card-category">Submit a new overtime</p>
                </div>
                    <div class="container py-5 h-100">
                      <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-10 col-xl-10">
                          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">New Overtime</h3>
                              <form action="{{ route('overtimes.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                  <div class="col-md-6 mb-6">

                                    <div class="form-outline">
                                      <input type="date" name="date" class="form-control form-control-lg" />
                                      <label class="form-label" >Date</label>
                                    </div>

                                  </div>

                                  <div class="col-md-6 mb-6">

                                    <div class="form-outline">
                                      <input type="time" name="start_hour" class="form-control form-control-lg" />
                                      <label class="form-label" >Start Hour</label>
                                    </div>

                                  </div>

                                    <div class="col-md-6 mb-6">

                                      <div class="form-outline">
                                        <input type="time" name="end_hour" class="form-control form-control-lg" />
                                        <label class="form-label" >End Hour</label>
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
