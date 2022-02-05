@extends('layouts.app', ['activePage' => 'policies', 'titlePage' => ('policies')])

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
                          <h4 class="card-title ">HR Policies</h4>
                          @php
                          $user = Auth::user()
                      @endphp
                      @if ($user->hradmin == 'yes')
                             <div   div class="col-12 text-right">
                                <a href="{{route('admin.policies.create')}}" class="btn btn-sm btn-primary">Add Policy</a>
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
                              <th class="text-center" scope="col">Created date</th>
                              <th class="text-center" scope="col">Last updated</th>
                              <th class="text-center" scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($policies as $policy)
                            <tr>
                              <td class="text-center">{{ $policy->name }}</td>
                              <td class="text-center">{{ $policy->desc }}</td>
                              <td class="text-center">{{ $policy->created_date }}</td>
                              <td class="text-center">{{ $policy->lastupdate_date }}</td>
                              <td class="text-center">
                                <div class="btn-group dropright">
                                <button class="btn btn-secondary dropdown-toggle justify-content-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                </button>
                                <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                  <div class="justify-content-center"><a class="dropdown-item justify-content-center" href="/storage/files/{{$policy->name}}.pdf" target="_blank">View</a></div>
                                  @if ($user->hradmin == 'yes')
                                  <div class="justify-content-center"><a class="dropdown-item justify-content-center" href="{{ route('admin.policies.edit', $policy) }}"  >Edit</a></div>
                                  <form method="POST" action="{{ route('admin.policies.destroy', $policy) }}" class="text-center" >
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </div>
                                </form>
                                  @endif
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
