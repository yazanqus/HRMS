@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col ml-3">
                    <div class="text">
                        {{-- @foreach ($users as $user) --}}
                        <br>
                        <h3>
                             <b>{{$user->name}} </b>
                             <br>
                             <b>{{$user->employee_number}}</b>
                         </h3>
                        {{-- @endforeach --}}
                    </div>
                </div>


            </div>
            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">Attendance - <b>{{$attendance->month}}</b></h4>
                      </div>
                      <div class="card-body">
                          {{-- <div class="row">
                              <div   div class="col-12 text-right">
                                <a href="{{route('admin.users.edit', $user)}}" class="btn btn-sm btn-primary">Edit</a>
                              </div>
                          </div> --}}
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection

@push('scripts')

@endpush
