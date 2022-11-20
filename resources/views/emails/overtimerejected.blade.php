@component('mail::message')

Dear {{ $details['requestername'] }} 
# {{ $details['title'] }}
Line Manager: <strong>{{ $details['linemanagername'] }}</strong> 
<br>
HR: <strong>{{ $details['hrname'] }}</strong> 
  <br>
  <br>


  @component('mail::table')
    | Hours      | {{ $details['hours'] }}         
    | ------------- |:-------------:
    | Date:      | {{ $details['dayname'] }} {{ $details['date'] }}      
    | From:      |  {{ $details['start_hour'] }}
    | To:      |  {{ $details['end_hour'] }}
    | Comment:      | {{ $details['comment'] }}
@endcomponent
<br>


@component('mail::button', ['url' => 'http://127.0.0.1:8000/overtimes'])
Check your overtime requests
@endcomponent

@endcomponent