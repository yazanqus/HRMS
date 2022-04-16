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
                                            <input class="form-control form-outline" type="time" id="start_hour"  name="start_hour" placeholder="">
                                            @endif
                                          </td>
                                          <td class="text-center">
                                            @if (isset($attendance->end_hour))
                                            {{ $attendance->end_hour }}
                                            @endif
                                            @if (!isset($attendance->end_hour))
                                             <input class="form-control form-outline" type="time" id="end_hour"  name="end_hour" placeholder="">
                                             @endif
                                           </td>
                                           <td class="text-center">
                                            @if (isset($attendance->leave_overtime_id))
                                            {{ $attendance->leave_overtime_id }}
                                            @endif
                                            @if (!isset($attendance->leave_overtime_id))
                                             <input class="form-control form-outline" type="text" id="leave_overtime_id"  name="leave_overtime_id" placeholder="">
                                             @endif
                                           </td>
                                           <td class="text-center">
                                            @if (isset($attendance->remarks))
                                            {{ $attendance->remarks }}
                                            @endif
                                            @if (!isset($attendance->remarks))
                                             <input class="form-control form-outline" type="text" id="remarks"  name="remarks" placeholder="">
                                             @endif
                                           </td>
                                           <td class="text-center">
                                             <button type="submit" class="btn bg-gradient-primary btn-block">Submit</button>
                                           </td>
                                        </tr>
                                    </form>
                                    @endforeach

                              </tbody>

                          </table>



                      </div>
                    </div>


                    <div class="card">
                        <div class="card-header card-header-primary ">
                          <h4 class="mt-1 card-title mr-2 ">Leaves - Remaining balance</h4>
                          <div class="col-12 text-left ">
                            {{-- <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="mb-0 btn btn-sm btn-outline-primary">Edit  <i class="ml-2  fas fa-lg fa-list-ol"></i></a> --}}
                          </div>
                          {{-- <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="btn btn-sm btn-outline-primary">Edit  <i class="ml-2 fas fa-lg fa-user-cog"></i></a> --}}

                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div   div class="col-12 text-right">
                                  <a href="#" class="btn btn-sm btn-primary">Add Holiday</a>
                                </div>
                            </div> --}}
                          <div class="row">
                              <div class="col">
                                  <strong>Annual Leave:</strong>
                                  <br>
                                  <strong>Sick leave:</strong>
                                  <br>
                                  <strong>Sick leave 30% deduction:</strong>
                                    <br>
                                    <strong>Sick leave 20% deduction</strong>
                                    <br>
                                  <strong>Marriage leave:</strong>
                                    <br>
                                    <strong>Welfare leave:</strong>
                                </div>

                                <div class="col">
                                    <strong>Unpaid leave:</strong>
                                    <br>
                                    <strong>Maternity leave:</strong>
                                    <br>
                                    <strong>Paternity leave:</strong>
                                    <br>
                                  <strong>Compassionate - Second degree:</strong>
                                  <br>
                                {{-- <strong>Annual Leave:</strong>
                                  <br> --}}
                                  <strong>Compassionate - First degree:</strong>
                                  <br>
                                  <strong>Compansetion:</strong>
                                  </div>

                          </div>
                </div>
            </div>


                </div>
            </div>
        </div>
    </div>





@endsection

@push('scripts')

@endpush
