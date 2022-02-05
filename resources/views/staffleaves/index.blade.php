@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

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
                          <h4 class="card-title ">My staff leaves</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">

                        <table id="table_id" class="table table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th class="text-center" scope="col">Leave type</th>
                                <th class="text-center" scope="col">Start date</th>
                                <th  class="text-center"scope="col">End date</th>
                                <th class="text-center" scope="col">Days</th>
                                <th class="text-center" scope="col">Status</th>
                                <th class="text-center" scope="col">Date Created</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                                <td>{{ $leave->id }}</td>
                              <td>{{ $leave->user->name }}</td>
                              <td class="text-center">{{ $leave->leavetype->name }}</td>
                              <td class="text-center">{{ $leave->start_date }}</td>
                              <td class="text-center">{{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{ $leave->status }}</td>
                              <td class="text-center"> {{ $leave->created_at }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
 @endsection


 @push('scripts')

  <!-- DataTables  & Plugins -->


  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>


  <script>
    $(document).ready( function () {
    $('#table_id').DataTable(
        {
            "order": [[ 7, "desc" ]]
        }
    );
} );
  </script>
@endpush
