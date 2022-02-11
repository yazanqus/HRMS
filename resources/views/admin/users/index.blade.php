@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

          <div class="content">
              <div class="container-fluid">


                <div class="row">
                    <div class="col-md-6 mb-6">
                        <div class="text">

                        </div>
                    </div>
                </div>
                <br>


                          <div class="container-fluid">
                                <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">All users</h4>
                                        <div class="col-12 text-right">
                                          <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-primary">Create a new user</a>
                                        </div>
                                    </div>
                                      <div class="card-body table-responsive-md">
                                          <table id="table_id" class="table table-bordered table-hover text-nowrap table-Secondary table-striped">
                                            <thead>
                                              <tr>
                                              {{-- <th scope="col"> @sortablelink('name')</th> --}}
                                              <th scope="col">Name</th>
                                              <th scope="col">Emplyee ID</th>
                                              <th scope="col">Position</th>
                                              <th scope="col">Join Date</th>
                                              <th scope="col">Line Manager</th>
                                              <th class="text-center" scope="col">Admin<small> (on HR System)</small></th>
                                              <th class="text-center" scope="col">Date Created</th>
                                              <th class="text-center" scope="col">Action</th>
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
                                                  <td class="text-center" >{{ $user->hradmin }}</td>
                                                  <td class="text-center" >{{ $user->created_at }}</td>
                                                  <td class="text-center">
                                                    <div class="btn-group dropright">
                                                        <button class="btn btn-xs " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-bars"></i>
                                                        </button>
                                                        <div style="min-width: 7rem" class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                                          {{-- <div class="text-center"><a class="dropdown-item text-center" href="{{ route('admin.users.show', $user) }}" target="_blank">View</a></div>
                                                          <div class="text-center"><a class="dropdown-item text-center" href="{{ route('admin.users.edit', $user) }}" >Edit</a></div>
                                                          <button type="button" class="dropdown-item text-center form-group btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal{{$user->id}}">Delete</button> --}}

                                                          <div class="text-center"><a class="form-group btn btn-sm btn-outline-primary" href="{{ route('admin.users.show', $user) }}" target="_blank">View</a></div>
                                                          <div class="text-center"><a class="form-group btn btn-sm btn-outline-info" href="{{ route('admin.users.edit', $user) }}" >Edit</a></div>
                                                          <div class="text-center"><button type="button" class=" form-group btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal{{$user->id}}">Delete</button></div>


                                                        </div>
                                                      </div>
                                                  </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Emplyee ID</th>
                                            <th scope="col">Position</th>
                                            <th scope="col">Join Date</th>
                                            <th scope="col">Line Manager</th>
                                            <th class="text-center" scope="col">Admin<small> (on HR System)</small></th>
                                            <th class="text-center" scope="col">Date Created</th>
                                            <th class="text-center" scope="col">Action</th>
                                              </tr>
                                            </tfoot>
                                          </table>
                                      </div>


                          </div>





<!-- Modal -->
@foreach ($users as $user)


<div id="myModal{{$user->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 style="color: red" class="modal-title">Attention!</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete: <br><strong>{{$user->name}}</strong>.</p>
          <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="text-center" >
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete">
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>
  @endforeach

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
    $('#table_id').DataTable({
        "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "order": [[6, "desc" ]],
    });
});
  </script>


<script>

var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})
</script>
@endpush



