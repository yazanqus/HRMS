@extends('layouts.app', ['activePage' => 'allstaffovertimes', 'titlePage' => ('allstaffovertimes')])

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
                          <h4 class="card-title ">All Staff Overtimes</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-sm">
                        <table  id="table_id" class="table table-bordered  table-responsive table-hover text-nowrap table-Secondary table-striped " >
                        <thead>
                            <tr>
                                <th style="width: 3%"scope="col">ID</th>
                                <th style="width: 10%" scope="col">Name</th>
                                <th style="width: 10%" class="text-center" scope="col">Type</th>
                                <th style="width: 10%" class="text-center" scope="col">Start Hour</th>
                                <th style="width: 10%" class="text-center" scope="col">End Hour</th>
                                <th style="width: 5%" class="text-center" scope="col">Hours</th>
                                <th style="width: 5%" class="text-center" scope="col">Hours <small>(Value)</small></th>
                                <th style="width: 10%" class="text-center" scope="col">Status</th>
                                <th style="width: 10%" class="text-center" scope="col">Line Manager</th>
                                <th style="width: 10%" class="text-center" scope="col">Date Created</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($overtimes as $overtime)
                            <tr>
                              <td>{{ $overtime->id }}</td>
                              <td>{{ $overtime->user->name }}</td>
                              <td class="text-center">{{ $overtime->type }}</td>
                              <td class="text-center">{{ $overtime->start_hour }}</td>
                              <td class="text-center">{{ $overtime->end_hour }}</td>
                              <td class="text-center">{{ $overtime->hours }}</td>
                              <td class="text-center">{{ $overtime->value }}</td>
                              <td class="text-center">{{ $overtime->status }}</td>
                              <td class="text-center">{{ $overtime->user->linemanager }}</td>
                              <td class="text-center">{{ $overtime->created_at }}</td>
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
            "order": [[9, "desc" ]]
        }
    );
} );
  </script>
@endpush
