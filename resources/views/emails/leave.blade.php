@component('mail::message')

Dear {{ $details['linemanagername'] }} 
# {{ $details['title'] }}
for {{ $details['requestername'] }} 
  
The body of your message. 
   
# {{ $details['body'] }}

@component('mail::button', ['url' => 'link'])
Button Text
@endcomponent
   
Thanks,<br>
{{ config('app.name') }}
@endcomponent