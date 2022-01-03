@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

          <div class="content">
              <div class="container-fluid">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title ">Users</h4>
                      <p class="card-category"> Here you can manage users</p>
                    </div>
                    <div class="card-body">
                                      <div class="row">
                        <div class="col-12 text-right">
                          <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-primary">Add user</a>
                        </div>
                      </div>
                      <div class="row">
                    <table class="table table-striped table-Secondary">
                    <thead>
                        <tr>
                          <th scope="col">Name</th>
                          <th scope="col">Emplyee ID</th>
                          <th scope="col">Position</th>
                          <th scope="col">Join Date</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $user)
                        <tr>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->employee_number }}</td>
                          <td>{{ $user->position }}</td>
                          <td>{{ $user->joined_date }}</td>
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
