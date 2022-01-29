@extends('layouts.app', ['activePage' => 'overtime', 'titlePage' => ('overtime')])

@section('content')

          <div class="content">
              <div class="container-fluid">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title ">My overtimes</h4>
                      {{-- <p class="card-category">Here you can see the history of overtimes</p> --}}
                    </div>
                    <div class="card-body">
                                      <div class="row">
                        <div class="col-12 text-right">
                          <a href="{{route('overtimes.create')}}" class="btn btn-sm btn-primary">Submit a new Overtime</a>
                        </div>
                      </div>
                      <div class="row">
                    <table class="table table-striped table-Secondary">
                    <thead>
                        <tr>
                          <th scope="col">Date</th>
                          <th scope="col">Start Hour</th>
                          <th scope="col">End Hour</th>
                          <th scope="col">Hours</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($overtimes as $overtime)
                        <tr>
                          <td>{{ $overtime->date }}</td>
                          <td>{{ $overtime->start_hour }}</td>
                          <td>{{ $overtime->end_hour }}</td>
                          <td>{{ $overtime->hours }}</td>
                          <td>{{ $overtime->status }}</td>
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
