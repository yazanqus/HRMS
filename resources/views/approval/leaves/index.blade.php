@extends('layouts.app', ['activePage' => 'leavesapproval', 'titlePage' => ('leavesapproval')])

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
                              <h4 class="card-title ">Leaves pending your approval</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>
                            <div class="card-body table-responsive-md ">
                              <div class="row">
                            <table class="table table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th class="text-center" scope="col">Leave type</th>
                                    <th class="text-center" scope="col">Start date</th>
                                    <th class="text-center" scope="col">End date</th>
                                    <th  class="text-center"scope="col">Days</th>
                                    <th class="text-center" scope="col">Status</th>
                                    <th class="text-center" scope="col ">Approve</th>
                                    <th class="text-center" scope="col">Decline</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($leaves as $leave)
                                <tr>
                                    <td><a href="{{ route('leaves.show', $leave) }}" target="_blank">{{ $leave->id }}</a></td>
                                  <td>{{ $leave->user->name }}</td>
                                  <td class="text-center">{{ $leave->leavetype->name }}</td>
                                  <td class="text-center">{{ $leave->start_date }}</td>
                                  <td class="text-center">{{ $leave->end_date }}</td>
                                  <td class="text-center">{{ $leave->days }}</td>
                                  <td class="text-center">{{ $leave->status }}</td>
                                  <td class="text-center">
                                      <a class="btn btn-success"
                                      href="{{route('leaves.approved',$leave->id)}}">Approve</a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-danger" href="{{route('leaves.declined',$leave->id)}}">Decline</a>
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
