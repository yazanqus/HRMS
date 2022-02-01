@extends('layouts.app', ['activePage' => 'overtime', 'titlePage' => ('overtime')])

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
                          <h4 class="card-title ">My overtimes</h4>
                          {{-- <p class="card-category">Here you can see the history of overtimes</p> --}}
                          <div class="col-12 text-right">
                            <a href="{{route('overtimes.create')}}" class="btn btn-sm btn-primary">Submit a new Overtime</a>
                          </div>
                        </div>
                        <div class="card-body table-responsive-md">

                          <div class="row">
                        <table class="table table-hover text-nowrap table-Secondary">
                        <thead>
                            <tr>
                              <th class="text-center" scope="col">Date</th>
                              <th class="text-center" scope="col">Start Hour</th>
                              <th class="text-center" scope="col">End Hour</th>
                              <th class="text-center" scope="col">Hours</th>
                              <th class="text-center" scope="col">Status</th>
                              <th class="text-center" scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($overtimes as $overtime)
                            <tr>
                              <td class="text-center">{{ $overtime->date }}</td>
                              <td class="text-center">{{ $overtime->start_hour }}</td>
                              <td class="text-center">{{ $overtime->end_hour }}</td>
                              <td class="text-center">{{ $overtime->hours }}</td>
                              <td class="text-center">{{ $overtime->status }}</td>
                              <td class="text-center">edit</td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
 @endsection
