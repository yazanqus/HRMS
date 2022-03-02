@extends('layouts.app', ['activePage' => 'allactivities', 'titlePage' => ('allactivities')])

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
                          <h4 class="card-title ">All Staff balances</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">
                          <div class="row">


                        <table class="table table-hover text-nowrap table-Secondar">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Description</th>
                                <th class="text-center" scope="col">Causer</th>
                                <th class="text-center" scope="col">prop</th>
                                <th class="text-center" scope="col">created at </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($allactivity as $activity)
                            <tr>

                              <td class="text-center">{{ $activity->description }}</td>
                              <td class="text-center">{{ optional($activity->causer)->name }}</td>
                              <td class="text-center">{{ $activity->properties }}</td>
                              <td class="text-center">{{ $activity->created_at }}</td>
                              <td>edit</td>
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
