@component('mail::message')

Dear {{ $details['requestername'] }} 
# {{ $details['title'] }}
Line Manager: <strong>{{ $details['linemanagername'] }}</strong> 
<br>
HR: <strong>{{ $details['hrname'] }}</strong> 
  <br>
  <br>


  @component('mail::table')
    | Days      | {{ $details['days'] }}         
    | ------------- |:-------------:
    | From:      | {{ $details['startdayname'] }} {{ $details['start_date'] }}      
    | To:      | {{ $details['enddayname'] }} {{ $details['end_date'] }}
    | Comment:      | {{ $details['comment'] }}
@endcomponent
<br>

@component('mail::button', ['url' => 'http://127.0.0.1:8000/leaves'])
Check your leave requests
@endcomponent

@endcomponent