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
                                    <h4 class="card-title">{{__('allUsers.allUsers')}}</h4>
                                        <div class="col-12 text-right">

                                          <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-primary">{{__('allUsers.createNewUser')}}</a>
                                          <a href="{{route('admin.alluserssearch.cond')}}" class="btn btn-sm ml-2 btn-success">{{__('allStaffLeaves.advancedSearch')}} <i class="ml-2 fas fa-search"></i> </a>
                                          <a href="{{route('admin.allusersbalanceexport.cond')}}" class="btn btn-sm ml-2 btn-info">{{__('allStaffLeaves.balanceexport')}} <i class="ml-2 fas fa-file-excel"></i> </a>
                                          @if ($user->name == "HR Test")
                                          <!-- <a href="{{route('admin.users.importshow')}}" class="btn btn-sm ml-2 btn-success">Import <i class="ml-2 fas fa-file-excel"></i> </a> -->
                                          <!-- <a href="{{route('admin.users.createbalance')}}" class="btn btn-sm ml-2 btn-success">Create Balance <i class="ml-2 fas fa-file-excel"></i> </a> -->
                                          @endif
                                          <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn ml-2 btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Export <i class="ml-2 fas fa-file-excel"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                              <a class="dropdown-item" href="{{route('admin.users.export')}}">{{__('allUsers.allUsers')}}</i></a>
                                              <!-- <a class="dropdown-item" href="{{route('attendances.export')}}">All Attendances </i></a> -->
                                            </div>
                                        </div>

                                        </div>
                                    </div>


                                      <div class="card-body table-responsive-md">
                                          <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                                            <thead>
                                              <tr style=" background-color: #ffb678 !important;">
                                              
                                              <th style="width: 20%" scope="col">{{__('allUsers.name')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.employeeId')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.position')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.office')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.joinDate')}}</th>
                                              <th style="width: 20%" scope="col">{{__('allUsers.lineManager')}}</th>
                                         
                                             
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                <tr>
                                                  <td>
                                                      @if ($user->status == 'suspended')
                                                      <i class="fas fa-minus-circle"></i>
                                                      @endif
                                                      <a style = "color: #007bff;" href="{{ route('admin.users.show', $user) }}" >{{ $user->name }}</a>
                                                    </td>
                                                  <td>{{ $user->employee_number }}</td>
                                                  <td>{{ $user->position }}</td>
                                                  <td>{{ $user->office }}</td>
                                                  <td>{{ $user->joined_date }}</td>
                                                  <td>{{ $user->linemanager }}</td>
                                               
                                              

                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                              <th style="width: 20%" scope="col">{{__('allUsers.name')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.employeeId')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.position')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.office')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.joinDate')}}</th>
                                              <th style="width: 20%" scope="col">{{__('allUsers.lineManager')}}</th>
                                              
                                            

                                              </tr>
                                            </tfoot>
                                          </table>
                                      </div>


                          </div>





<!-- Modal -->
{{-- @foreach ($users as $user)


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
@php
    if ($user->name != Auth::user()->name)
    {
        $variablee='1';

    }
    else
    {
        $variablee ='2';
    }
@endphp
@if ($variablee=='2')
          <strong style="color: red">Logged in user can't be deleted<br> </strong> <br>
        @endif
        @if ($variablee=='1')
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="text-center" >
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete">
            </div>
        </form>
        @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach --}}

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
        "order": [[1, "desc" ]],
    });
});
  </script>


<script>

var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
});
</script>
@endpush



