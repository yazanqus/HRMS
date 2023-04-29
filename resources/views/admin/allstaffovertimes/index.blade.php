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
                @php
                            $hruser = Auth::user();
                            @endphp

                  <div class="container-fluid">
                      <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('allStaffOvertimes.allStaffOvertimes')}}</h4>
                          <div class="col-12 text-right">
                          <a href="{{route('admin.allovertimessearch.cond')}}" class="btn btn-sm ml-2 btn-success">{{__('allStaffLeaves.advancedSearch')}} <i class="ml-2 fas fa-search"></i> </a>
                          <a href="{{route('admin.overtimes.pdf')}}" class="btn btn-sm ml-2 btn-primary">{{__('allStaffOvertimes.pdfReport')}}<i class="ml-2 fas fa-file-pdf"></i> </a>  
                          <a href="{{route('admin.overtimes.export')}}" class="btn btn-sm ml-2 btn-secondary">{{__('allStaffOvertimes.excel')}}<i class="ml-2 fas fa-file-excel"></i> </a>
                          </div>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-sm">
                        <table  id="table_id" style="font-size: 14px;" class="table table-bordered  table-responsive table-hover text-nowrap table-Secondary table-striped " >
                        <thead>
                            <tr style=" background-color: #ffb678 !important;">
                                <th style="width: 3%"scope="col">{{__('allStaffOvertimes.id')}}</th>
                                <th style="width: 10%" scope="col">{{__('allStaffOvertimes.name')}}</th>
                                @if ($hruser->office == "AO2")
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.office')}}</th>
                                    @endif
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.type')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.date')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.startHour')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.endHour')}}</th>
                                <th style="width: 5%" class="text-center" scope="col">{{__('allStaffOvertimes.hours')}}</th>
                                <th style="width: 5%" class="text-center" scope="col">{{__('allStaffOvertimes.hours')}}<small>({{__('allStaffOvertimes.value')}})</small></th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.status')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.lineManager')}}</th>
                                <!-- <th style="width: 10%" class="text-center" scope="col">{{__('allStaffOvertimes.dateCreated')}}</th> -->
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($overtimes as $overtime)
                            <tr>
                              <td class="text-center"><a  href="{{ route('overtimes.show', encrypt($overtime->id)) }}" target="_blank"><strong>{{ $overtime->id }}</strong></a></td>
                              <td>
                                
                              <div class="dropdown">
  <a style="color: #007bff;"  type="button" id="dropdownMenu1" data-toggle="dropdown">
  {{ $overtime->user->name }}
  </a>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    <li role="presentation"><a class="ml-2" target="_blank" role="menuitem"  href="{{ route('admin.users.show', $overtime->user) }}">Staff Account </a></li>
  </ul>
</div>


                              <!-- <a style = "color: #007bff;" href="{{ route('admin.users.show', $overtime->user) }}" >{{ $overtime->user->name }}</a> -->
                            
                            </td>
                              @if ($hruser->office == "AO2")
                                  <td class="text-center">{{ $overtime->user->office }}</td>
                                    @endif
                              <td class="text-center">{{__("databaseLeaves.$overtime->type")}}</td>
                              @php
                              $dayname = Carbon\Carbon::parse($overtime->date)->format('l');
                              @endphp
                              <td class="text-center">{{__("databaseLeaves.$dayname")}} {{ $overtime->date }}</td>
                              <td class="text-center">{{ $overtime->start_hour }}</td>
                              <td class="text-center">{{ $overtime->end_hour }}</td>
                              <td class="text-center">{{ $overtime->hours }}</td>
                              <td class="text-center">{{ $overtime->value }}</td>
                              <td class="text-center">{{__("databaseLeaves.$overtime->status")}}</td>
                              <td class="text-center">{{ $overtime->lmapprover }}</td>
                              <!-- <td class="text-center">{{ $overtime->created_at }}</td> -->
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
            "order": [[0, "desc" ]]
        }
    );
} );
  </script>
@endpush
