@extends('layouts.app', ['activePage' => 'overtime', 'titlePage' => ('overtime')])

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
                          <h4 class="card-title ">My overtimes</h4>
                          {{-- <p class="card-category">Here you can see the history of overtimes</p> --}}
                          <div class="col-12 text-right">
                            <a href="{{route('overtimes.create')}}" class="btn btn-sm btn-primary">Submit a new Overtime</a>
                          </div>
                        </div>
                        <div class="card-body table-responsive-md">


                        <table id="table_id" class="table table-bordered table-hover text-nowrap table-Secondary table-striped">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                              <th scope="col">Type</th>
                              <th class="text-center" scope="col">Date</th>
                              <th class="text-center" scope="col">Start Hour</th>
                              <th class="text-center" scope="col">End Hour</th>
                              <th class="text-center" scope="col">Hours</th>
                              <th class="text-center" scope="col">Status</th>
                              <th class="text-center" scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($overtimes as $overtime)
                            <tr>
                                <td><a href="{{ route('overtimes.show', $overtime) }}" >{{ $overtime->id }}</a></td>
                              <td>{{ $overtime->type }}</td>
                              <td class="text-center">{{ $overtime->date }}</td>
                              <td class="text-center">{{ $overtime->start_hour }}</td>
                              <td class="text-center">{{ $overtime->end_hour }}</td>
                              <td class="text-center">{{ $overtime->hours }}</td>
                              <td class="text-center">{{ $overtime->status }}</td>
                              <td class="text-center">
                                @php
                                if ($overtime->status == 'Approved' || $overtime->status == 'Declined by HR')
                                {
                                    $variable='disabled';
                                }
                                      else
                                      {
                                          $variable = 'notdisabled';
                                      }

                                @endphp
                                @if ($variable == 'notdisabled')

                                <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal{{$overtime->id}}"><i class="fas fa-minus-circle "></i> </button></div>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>

                        </div>
                      </div>

                      @foreach ($overtimes as $overtime)


<div id="myModal{{$overtime->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 style="color: red" class="modal-title">Attention!</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete overtime ID: <strong>{{$overtime->id}}</strong>.</p>
          <form method="POST" action="{{ route('overtimes.destroy', $overtime->id) }}" class="text-center" >
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
