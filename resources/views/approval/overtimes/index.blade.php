@extends('layouts.app', ['activePage' => 'approval', 'titlePage' => ('approval')])

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
                              <h4 class="card-title ">Overtimes pending your approval</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>
                            <div class="card-body table-responsive-md ">
                              <div class="row">
                            <table class="table table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th class="text-center" scope="col">Date</th>
                                    <th class="text-center" scope="col">Start Hour</th>
                                    <th class="text-center" scope="col">End Hour</th>
                                    <th  class="text-center"scope="col">Hours</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col ">Approve</th>
                                    <th class="text-center" scope="col">Decline</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($overtimes as $overtime)
                                <tr>
                                  <td>{{ $overtime->user->name }}</td>
                                  <td class="text-center">{{ $overtime->date }}</td>
                                  <td class="text-center">{{ $overtime->start_hour }}</td>
                                  <td class="text-center">{{ $overtime->end_hour }}</td>
                                  <td class="text-center">{{ $overtime->hours }}</td>
                                  <td class="text-center">{{ $overtime->status }}</td>
                                  <td class="text-center">
                                      <a class="btn btn-success"
                                      href="{{route('overtimes.approved',$overtime->id)}}">Approve</a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-danger" href="{{route('overtimes.declined',$overtime->id)}}">Decline</a>
                                    </td>
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
