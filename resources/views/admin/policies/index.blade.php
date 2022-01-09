@extends('layouts.app', ['activePage' => 'policies', 'titlePage' => ('all users')])

@section('content')

          <div class="content">
              <div class="container-fluid">

                <div>
                    <div class="mx-auto pull-right">
                        <div class="">
                            <form action="{{ route('admin.policies.index') }}" method="GET" role="search">

                                <div class="input-group">
                                    <span class="input-group-btn mr-5 mt-1">
                                        <button class="btn btn-info" type="submit" title="Search projects">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control mr-2" name="term" placeholder="Search projects" id="term">
                                    <a href="{{ route('admin.policies.index') }}" class=" mt-1">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" type="button" title="Refresh page">
                                                <span class="fas fa-sync-alt"></span>
                                            </button>
                                        </span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mx-auto pull-right">
                        <div class="">
                            <form action="{{ route('admin.policies.index') }}" method="GET" role="search">

                                <div class="input-group">
                                    <span class="input-group-btn mr-5 mt-1">
                                        <button class="btn btn-info" type="submit" title="Search projects">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control mr-2" name="id" placeholder="Search projects" id="id">
                                    <a href="{{ route('admin.policies.index') }}" class=" mt-1">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" type="button" title="Refresh page">
                                                <span class="fas fa-sync-alt"></span>
                                            </button>
                                        </span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mx-auto pull-right">
                        <div class="">
                            <form action="{{ route('admin.policies.index') }}" method="GET" role="search">

                                <div class="input-group">
                                    <span class="input-group-btn mr-5 mt-1">
                                        <button class="btn btn-info" type="submit" title="Search projects">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control mr-2" name="position" placeholder="Search projects" id="position">
                                    <a href="{{ route('admin.policies.index') }}" class=" mt-1">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" type="button" title="Refresh page">
                                                <span class="fas fa-sync-alt"></span>
                                            </button>
                                        </span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




                  <div class="card">
                    <div class="card-header card-header-primary">
                      <h4 class="card-title ">Users</h4>
                      <p class="card-category"> Here you can manage users</p>
                    </div>
                    <div class="card-body">
                                      <div class="row">
                        <div class="col-12 text-right">
                          <a href="{{route('admin.policies.create')}}" class="btn btn-sm btn-primary">Add user</a>
                        </div>
                      </div>
                      <div class="row">
                    <table class="table table-striped table-Secondary">
                    <thead>
                        <tr>
                          <th scope="col">name</th>
                          <th scope="col">desc</th>

                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($policies as $policy)
                        <tr>
                          <td>{{ $policy->name }}</td>
                          <td>{{ $policy->desc }}</td>
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

                      <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe>

                    </div>
                  </div>
              </div>
          </div>
 @endsection
