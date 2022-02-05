@extends('layouts.app', ['activePage' => 'my-leaves', 'titlePage' => ('all leaves')])

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
                          <h4 class="card-title ">My leaves</h4>
                            <div class="col-12 text-right">
                              <a href="{{route('leaves.create')}}" class="btn btn-sm btn-primary">Submit a new Leave</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive-md">

                          <div class="row">
                        <table class="table table-hover text-nowrap table-Secondary">
                        <thead>
                            <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Name</th>
                              <th class="text-center" scope="col">Start date</th>
                              <th class="text-center" scope="col">End date</th>
                              <th class="text-center" scope="col">Days</th>
                              <th class="text-center" scope="col">Status</th>
                              <th class="text-center" scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                              <td>{{ $leave->id }}</td>
                              <td>{{ $leave->user->name }}</td>
                              <td class="text-center">{{ $leave->start_date }}</td>
                              <td class="text-center">{{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{ $leave->status }}</td>
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
