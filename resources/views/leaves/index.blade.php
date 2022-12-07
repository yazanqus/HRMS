@extends('layouts.app', ['activePage' => 'my-leaves', 'titlePage' => ('all leaves')])

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
                          <h4 class="card-title ">{{__('leaves.myLeaves')}}</h4>
                            <div class="col-12 text-right">
                              <a href="{{route('leaves.create')}}" class="btn btn-sm btn-primary">{{__('leaves.submitNewLeave')}}</a>
                            </div>
                        </div>

                        <div class="card-body table-responsive-md">

                        <table id="table_id" class="table table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                            <tr>
                            <th scope="col">{{__('leaves.id')}}</th>
                              <th scope="col">{{__('leaves.type')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.startDate')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.endDate')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.days')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.status')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.action')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                              <td><a href="{{ route('leaves.show', $leave) }}" >{{ $leave->id }}</a></td>
                              <td>{{ __("databaseLeaves.{$leave->leavetype->name}") }}</td>
                              <td class="text-center">{{ $leave->start_date }}</td>
                              <td class="text-center">{{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{__("databaseLeaves.$leave->status")}}</td>
                              <td class="text-center">
                                  @php
                                  if ($leave->status == 'Approved' || $leave->status == 'Declined by HR' || $leave->status == 'Cancelled' || $leave->status == 'Submitted by HR' || $leave->status == 'Declined by LM')
                                  {
                                      $variable='disabled';
                                  }
                                        else
                                        {
                                            $variable = 'notdisabled';
                                        }

                                  @endphp
                                  @if ($variable == 'notdisabled')

                                  <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal{{$leave->id}}"><i class="fas fa-minus-circle "></i> </button></div>
                                  @endif

                                  {{-- @if ($variable = 'notdisabled')
                                  <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-secondary " data-toggle="modal" data-target="#myModal{{$leave->id}}"><i class="fas fa-minus-circle "></i> </button></div>
                                  @endif --}}



                                {{-- <div class="btn-group dropright">
                                    <button class="btn btn-xs " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                    <div style="min-width: 7rem" class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                      <div class="text-center"><a class="dropdown-item text-center" href="{{ route('admin.users.show', $user) }}" target="_blank">View</a></div>
                                      <div class="text-center"><a class="dropdown-item text-center" href="{{ route('admin.users.edit', $user) }}" >Edit</a></div>
                                      <button type="button" class="dropdown-item text-center form-group btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal{{$user->id}}">Delete</button>

                                      <div class="text-center"><a class="form-group btn btn-sm btn-outline-primary" href="{{ route('leaves.show', $leave) }}" target="_blank">View</a></div>
                                      <div class="text-center"><a class="form-group btn btn-sm btn-outline-info" href="{{ route('leaves.edit', $leave) }}" >Edit</a></div>
                                      <div class="text-center"><button type="button" class=" form-group btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal{{$leave->id}}">Delete</button></div>


                                    </div>
                                  </div> --}}
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>

                        </div>
                      </div>
                      <!-- Modal -->
@foreach ($leaves as $leave)


<div id="myModal{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 style="color: red" class="modal-title">Attention!</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete leave ID: <strong>{{$leave->id}}</strong>.</p>
          <form method="POST" action="{{ route('leaves.destroy', $leave->id) }}" class="text-center" >
            {{-- @csrf
            @method('DELETE') --}}

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
                  </div>
              </div>
          </div>
 @endsection
 @push('scripts')

 <!-- DataTables  & Plugins -->
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

 <script>



    $(document).ready( function () {

      $('form').submit(function(){
$(this).find(':submit').attr('disabled','disabled');
});


    $('#table_id').DataTable({
        "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "order": [[0, "desc" ]],
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
