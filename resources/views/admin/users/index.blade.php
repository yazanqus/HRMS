@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

          <div class="content">
              <div class="container-fluid">

                {{-- <div>
                    <div class="mx-auto pull-right">
                        <div class="">
                            <form action="{{ route('admin.users.index') }}" method="GET" role="search">

                                <div class="input-group">
                                    <span class="input-group-btn mr-5 mt-1">
                                        <button class="btn btn-info" type="submit" title="Search projects">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control mr-2" name="term" placeholder="Search projects" id="term">
                                    <a href="{{ route('admin.users.index') }}" class=" mt-1">
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
                            <form action="{{ route('admin.users.index') }}" method="GET" role="search">

                                <div class="input-group">
                                    <span class="input-group-btn mr-5 mt-1">
                                        <button class="btn btn-info" type="submit" title="Search projects">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control mr-2" name="id" placeholder="Search projects" id="id">
                                    <a href="{{ route('admin.users.index') }}" class=" mt-1">
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
                            <form action="{{ route('admin.users.index') }}" method="GET" role="search">

                                <div class="input-group">
                                    <span class="input-group-btn mr-5 mt-1">
                                        <button class="btn btn-info" type="submit" title="Search projects">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control mr-2" name="position" placeholder="Search projects" id="position">
                                    <a href="{{ route('admin.users.index') }}" class=" mt-1">
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
                </div> --}}

                <div class="card">
                    <div class="card-header card-header-primary">
                      <h3 class="card-title">Users</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right">
                              <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-primary">Add user</a>
                            </div>
                          </div>

                      <div class="row">
                          <table id="example1" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th scope="col"> @sortablelink('name')</th>
                              <th scope="col">Emplyee ID</th>
                              <th scope="col">Position</th>
                              <th scope="col">Join Date</th>
                              <th scope="col">Line Manager</th>
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
                                  <td>{{ $user->linemanager }}</td>
                                  <td>
                                    <div class="btn-group dropright">
                                        <button class="btn btn-secondary dropdown-toggle justify-content-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        </button>
                                        <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                          <div class="justify-content-center"><a class="dropdown-item justify-content-center" href="{{ route('admin.users.show', $user) }}" target="_blank">View</a></div>
                                          <div class="justify-content-center"><a class="dropdown-item justify-content-center" href="{{ route('admin.users.edit', $user) }}"  >Edit</a></div>
                                          <form method="POST" action="#" class="text-center" >
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
                            <tfoot>
                              <tr>
                                <th>Rendering engine</th>
                                <th>Browser</th>
                                <th>Platform(s)</th>
                                <th>Engine version</th>
                                <th>CSS grade</th>
                              </tr>
                            </tfoot>
                          </table>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
              </div>
          </div>
 @endsection

@push('scripts')

  <!-- DataTables  & Plugins -->

  <script src="{{ asset('adminlte/plugins//jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>



  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      });
    });
  </script>
@endpush



