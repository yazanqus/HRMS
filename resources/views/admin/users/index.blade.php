@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

          <div class="content">
              <div class="container-fluid">

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

                          <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable with default features</h3>
                              </div>
                                  <div class="card-body">
                                      <table id="table_id" class="table table-bordered table-striped">
                                        <thead>
                                          <tr>
                                          {{-- <th scope="col"> @sortablelink('name')</th> --}}
                                          <th scope="col">Name</th>
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
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
              </div>
          </div>
 @endsection

@push('scripts')

  <!-- DataTables  & Plugins -->


  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>


  <script>
    $(document).ready( function () {
    $('#table_id').DataTable();
} );
  </script>
@endpush



