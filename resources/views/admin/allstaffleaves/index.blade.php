@extends('layouts.app', ['activePage' => 'allstaffleaves', 'titlePage' => ('allstaffleaves')])

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
                          <h4 class="card-title ">All Staff leaves</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">
                        <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                            <tr>
                                <th style="width: 3%" scope="col">ID</th>
                                <th style="width: 10%" scope="col">Name</th>
                                <th style="width: 10%" class="text-center" scope="col">Leave type</th>
                                <th style="width: 10%" class="text-center" scope="col">Start date</th>
                                <th style="width: 10%" class="text-center" scope="col">End date</th>
                                <th style="width: 3%" class="text-center" scope="col">Days</th>
                                <th style="width: 10%" class="text-center" scope="col">Status</th>
                                <th style="width: 10%" class="text-center" scope="col">Line Manager</th>
                                <th style="width: 10%" class="text-center" scope="col">Date Created</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                              <td><a href="{{ route('leaves.show', $leave) }}" >{{ $leave->id }}</a></td>
                              <td>{{ $leave->user ? $leave->user->name : 'Deleted User' }}</td>
                              <td class="text-center">{{ $leave->leavetype->name }}</td>
                              <td class="text-center">{{ $leave->start_date }}</td>
                              <td class="text-center">{{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{ $leave->status }}</td>
                              <td class="text-center">{{ $leave->user ? $leave->user->linemanager : '-' }}</td>
                              <td class="text-center">{{ $leave->created_at }}</td>
                              {{-- <td>edit</td> --}}
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
            "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "order": [[8, "desc" ]]
        }
    );
} );
  </script>
@endpush
