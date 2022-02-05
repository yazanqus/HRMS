@extends('layouts.app', ['activePage' => 'holidays', 'titlePage' => ('holidays')])

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
                          <h4 class="card-title ">Holiday Caladner</h4>
                          @php
                          $user = Auth::user()
                      @endphp
                      @if ($user->hradmin == 'yes')
                          <div   div class="col-12 text-right">
                            <a href="{{route('admin.holidays.create')}}" class="btn btn-sm btn-primary">Add Holiday</a>
                          </div>
                          @endif
                        </div>
                        <div class="card-body table-responsive-md">
                          <div class="row">
                        <table class="table table-hover text-nowrap table-Secondary">
                        <thead>
                            <tr>
                              <th class="text-center" scope="col">Name</th>
                              <th class="text-center" scope="col">Description</th>
                              <th class="text-center" scope="col">Start Date</th>
                              <th class="text-center" scope="col">Last Date</th>
                              <th class="text-center" scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($holidays as $holiday)
                            <tr>
                              <td class="text-center">{{ $holiday->name }}</td>
                              <td class="text-center">{{ $holiday->desc }}</td>
                              <td class="text-center">{{ $holiday->start_date }}</td>
                              <td class="text-center">{{ $holiday->end_date }}</td>
                              <td class="text-center">
                                <div class="btn-group dropright">
                                <button class="btn btn-secondary dropdown-toggle justify-content-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                </button>
                                <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                  <div class="justify-content-center"><a class="dropdown-item justify-content-center" href="/storage/files/{{$holiday->name}}.pdf" target="_blank">View</a></div>
                                  <div class="justify-content-center"><a class="dropdown-item justify-content-center" href="{{ route('admin.holidays.edit', $holiday) }}"  >Edit</a></div>
                                  <form method="POST" action="{{ route('admin.holidays.destroy', $holiday) }}" class="text-center" >
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </div>
                                </form>
                                </div>
                              </div>
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
