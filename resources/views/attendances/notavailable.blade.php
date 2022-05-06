@extends('layouts.app', ['activePage' => 'attendnace', 'titlePage' => ('attendnace')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col ml-3">
                    <div class="text">
                        {{-- @foreach ($users as $user) --}}
                        <br>
                        <h3>
                             <b>{{$user->name}} </b>
                             <br>


                             <b>{{$user->employee_number}}</b>
                             <br>
                             {{$month}}

                         </h3>
                        {{-- @endforeach --}}
                    </div>
                </div>


            </div>
            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">

                        {{-- <h4 class="card-title ">Attendance - <b>{{$attendances->month}}</b></h4> --}}
                      </div>
                      <div class="card-body">
                          {{-- <div class="row">
                              <div   div class="col-12 text-right">
                                <a href="{{route('admin.users.edit', $user)}}" class="btn btn-sm btn-primary">Edit</a>
                              </div>
                          </div> --}}

                          <table class="table table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                    <th class="text-center">Day</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Check in</th>
                                    <th class="text-center">Check out</th>
                                    <th class="text-center">Leave or Overtime ID</th>
                                    <th class="text-center">Comment</th>
                                    <th class="text-center">Submit</th>
                                </tr>
                              </thead>
                              <tbody>


                              </tbody>

                          </table>



                      </div>
                    </div>



                </div>
            </div>
        </div>
    </div>





@endsection

@push('scripts')




@endpush
