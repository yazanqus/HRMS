@extends('layouts.app', ['activePage' => 'attendnace', 'titlePage' => ('attendnace')])

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
                <div class="row">
                <div class="col">
                    <div class="text-center">
                        {{-- @foreach ($users as $user) --}}

                        <h2>

                             {{$month}}

                         </h2>
                        {{-- @endforeach --}}
                    </div>
                </div>
            </div>




            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">

                        {{-- <h4 class="card-title ">Attendance - <b>{{$attendances->month}}</b></h4> --}}
                      </div>
                      <div class="card-body">
                          {{-- <div class="row">
                              <div   div class="col-12 text-right">
                                <a href="{{route('admin.users.edit', $user)}}" class="btn btn-sm btn-primary">Edit</a>
                              </div>
                          </div> --}}

                          <table class="table table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                    <th class="text-center">Day</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Check in</th>
                                    <th class="text-center">Check out</th>
                                    <th class="text-center">Leave or Overtime ID</th>
                                    <th class="text-center">Comment</th>
                                    <th class="text-center">Submit</th>
                                </tr>
                              </thead>
                              <tbody>
                                  @foreach ($attendances as $attendance)
                                  <form action="{{ route('attendances.update', $attendance) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                  <tr>
                                      <td class="text-center">
                                        {{ $attendance->sign }}
                                      </td>
                                      <td class="text-center" >
                                          {{ $attendance->day }}
                                        </td>
                                        <td class="text-center">
                                                @if (isset($attendance->start_hour))
                                                 {{ $attendance->start_hour }}
                                                @endif
                                            @if (!isset($attendance->start_hour))
                                            <div class="form-group {{ $errors->has('start_hour') ? ' has-danger' : '' }}">
                                            <input class="form-control form-outline {{ $errors->has('start_hour') ? 'is-invalid' : '' }}" type="time" id="start_hour"  name="start_hour" placeholder="" {{ ($attendance->sign == "Friday" OR $attendance->sign == "Saturday")  ? 'disabled' : '' }}>
                                            </div>
                                            @endif
                                          </td>
                                          <td class="text-center">
                                            @if (isset($attendance->end_hour))
                                            {{ $attendance->end_hour }}
                                            @endif
                                            @if (!isset($attendance->end_hour))
                                            <div class="form-group {{ $errors->has('end_hour') ? ' has-danger' : '' }} ">
                                            <input class="form-control form-outline {{ $errors->has('end_hour') ? 'is-invalid' : '' }}" type="time" id="end_hour"  name="end_hour" placeholder="" {{ ($attendance->sign == "Friday" OR $attendance->sign == "Saturday")  ? 'disabled' : '' }}>
                                            </div>
                                            @endif
                                           </td>
                                           <td class="text-center">
                                            @if (isset($attendance->leave_overtime_id))
                                            {{ $attendance->leave_overtime_id }}
                                            @endif
                                            @if (!isset($attendance->leave_overtime_id))
                                             <input class="form-control form-outline" type="text" id="leave_overtime_id"  name="leave_overtime_id" placeholder="" {{ ($attendance->sign == "Friday" OR $attendance->sign == "Saturday")  ? 'disabled' : '' }}>
                                             @endif
                                           </td>
                                           <td class="text-center">
                                            @if (isset($attendance->remarks))
                                            {{ $attendance->remarks }}
                                            @endif
                                            @if (!isset($attendance->remarks))
                                             <input class="form-control form-outline" type="text" id="remarks"  name="remarks" placeholder="" {{ ($attendance->sign == "Friday" OR $attendance->sign == "Saturday")  ? 'disabled' : '' }}>
                                             @endif
                                           </td>
                                           {{-- submitting button --}}
                                           <td class="text-center">
                                            @if ( $attendance->status !== "Approved")
                                            @if ($attendance->status !== "Pending LM Approval")
                                            @if ($attendance->status !== "Pending HR Approval")
                                               @if (isset($attendance->start_hour))
                                               <form action="{{ route('attendances.destroy', $attendance) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                               <button type="submit" class="btn btn-outline-danger btn-block"  >Clear</button>
                                               </form>
                                               @endif
                                               @if (!isset($attendance->start_hour))

                                               <button type="submit" class="btn btn-outline-primary btn-block" {{ ($attendance->sign == "Friday" OR $attendance->sign == "Saturday")  ? 'disabled' : '' }}>Set</button>

                                               @endif
                                               @endif
                                               @endif
                                               @endif
                                           </td>
                                           {{-- end submitting button --}}
                                        </tr>
                                    </form>

                                    @endforeach

                              </tbody>

                          </table>



                      </div>
                    </div>


                    <div class="card">
                        <div class="card-header card-header-primary ">
                           <h5>Status: <strong>{{$attendance->status}}</strong> </h5>
                            @if (!isset($attendance->status))
                                Status: <strong>Attendance not submitted yet</strong>
                            @endif
                            @if ( $attendance->status !== "Approved")
                            @if ($attendance->status !== "Pending LM Approval")
                            @if ($attendance->status !== "Pending HR Approval")
                            <h4 class="mt-1 card-text mr-2 text-center"> <a href="{{ route('attendances.submit', ['user'=>$user,'month'=>$attendance->month]) }}">Submit <strong>{{$attendance->month}}</strong> attendance</a> </h4>
                            @endif
                            @endif
                            @endif
                          <div class="col-12 text-left ">
                            {{-- <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="mb-0 btn btn-sm btn-outline-primary">Edit  <i class="ml-2  fas fa-lg fa-list-ol"></i></a> --}}
                          </div>
                          {{-- <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="btn btn-sm btn-outline-primary">Edit  <i class="ml-2 fas fa-lg fa-user-cog"></i></a> --}}
                        </div>
            </div>
                </div>
            </div>
        </div>
    </div>





@endsection

@push('scripts')




@endpush
