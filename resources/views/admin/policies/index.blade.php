@extends('layouts.app', ['activePage' => 'policies', 'titlePage' => ('all users')])

@section('content')

          <div class="content">
              <div class="container-fluid">
                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title ">HR Policies</h4>
                      <p class="card-category"></p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div   div class="col-12 text-right">
                              <a href="{{route('admin.policies.create')}}" class="btn btn-sm btn-primary">Add Policy</a>
                            </div>
                        </div>
                      <div class="row">
                    <table class="table table-striped table-Secondary">
                    <thead>
                        <tr>
                          <th scope="col">Name</th>
                          <th scope="col">Desc</th>
                          <th scope="col">Created date</th>
                          <th scope="col">Last updated</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($policies as $policy)
                        <tr>
                          <td>{{ $policy->name }}</td>
                          <td>{{ $policy->desc }}</td>
                          <td>{{ $policy->created_date }}</td>
                          <td>{{ $policy->lastupdate_date }}</td>
                          <td>
                            <div class="btn-group dropright">
                            <button class="btn btn-secondary dropdown-toggle justify-content-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                              <div class="justify-content-center"><a class="dropdown-item justify-content-center" href="/storage/files/{{$policy->name}}.pdf" target="_blank">View</a></div>
                              <div class="justify-content-center"><a class="dropdown-item justify-content-center" href="{{ route('admin.policies.edit', $policy) }}"  >Edit</a></div>
                              <form method="POST" action="{{ route('admin.policies.destroy', $policy) }}" class="text-center" >
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

                      {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}

                    </div>
                  </div>
              </div>
          </div>
 @endsection
