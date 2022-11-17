@component('mail::message')

Dear {{ $details['linemanagername'] }} 
# {{ $details['title'] }}
for <strong>{{ $details['requestername'] }}</strong> 
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

@component('mail::button', ['url' => 'http://127.0.0.1:8000/leaves/approval'])
Approve/Decline
@endcomponent
   

@endcomponent