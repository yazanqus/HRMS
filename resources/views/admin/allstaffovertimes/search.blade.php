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
                          <h4 class="card-title ">All <strong>{{$name}}</strong> overtimes - Advanced Search Results</h4>
                          <div class="col-12 text-right">
                            Between <strong>{{$start_date}}</strong> and <strong>{{$end_date}}</strong>
                          </div>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">
                        <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                            <tr style=" background-color: #ffb678 !important;">
                            <th style="width: 3%"scope="col">{{__('allStaffOvertimes.id')}}</th>
                                <th style="width: 10%" scope="col">{{__('allStaffOvertimes.name')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.type')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.date')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.startHour')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.endHour')}}</th>
                                <th style="width: 5%" class="text-center" scope="col">{{__('allStaffOvertimes.hours')}}</th>
                                <th style="width: 5%" class="text-center" scope="col">{{__('allStaffOvertimes.hours')}}<small>({{__('allStaffOvertimes.value')}})</small></th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.status')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.lineManager')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.dateCreated')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($overtimes as $overtime)
                            <tr>
                              <td><a href="{{ route('overtimes.show', encrypt($overtime->id)) }}" target="_blank">{{ $overtime->id }}</a></td>
                              <td>{{ $overtime->user->name }}</td>
                              <td class="text-center">{{ $overtime->type }}</td>
                              <td class="text-center">{{ $overtime->date }}</td>
                              <td class="text-center">{{ $overtime->start_hour }}</td>
                              <td class="text-center">{{ $overtime->end_hour }}</td>
                              <td class="text-center">{{ $overtime->hours }}</td>
                              <td class="text-center">{{ $overtime->value }}</td>
                              <td class="text-center">{{ $overtime->status }}</td>
                              <td class="text-center">{{ $overtime->lmapprover }}</td>
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
            "order": [[8, "desc" ]]
        }
    );
} );
  </script>
@endpush
