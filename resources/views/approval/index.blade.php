@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

          <div class="content">
              <div class="container-fluid">

                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title ">Leaves pending approval</h4>
                      {{-- <p class="card-category"> Here you can manage users</p> --}}
                    </div>
                    <div class="card-body">

                      <div class="row">
                    <table class="table table-striped table-Secondary">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">start date</th>
                            <th scope="col">end date</th>
                            <th scope="col">Days</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($leaves as $leave)
                        <tr>
                          <td>{{ $leave->user->name }}</td>
                          <td>{{ $leave->start_date }}</td>
                          <td>{{ $leave->end_date }}</td>
                          <td>{{ $leave->days }}</td>
                          <td>{{ $leave->status }}</td>
                          <td>edit</td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
                        {{-- @foreach ($users as $user)
                          <div class="col-md-3">
                            <div class="card text-center"  style="width: 18rem;">
                              <img class="card-img-top" src="..." alt="Card image cap">
                              <div class="card-body" >
                                <h5 class="card-title">{{$user->name}}</h5>
                                <p class="card-text">{{$user->employee_number}}</p>
                                <p class="card-text">{{$user->position}}</p>
                                <a href="#" class="btn btn-primary">Profile</a>
                              </div>
                            </div>
                          </div>
                          @endforeach --}}
                      </div>
                    </div>
                  </div>
              </div>
          </div>
 @endsection
