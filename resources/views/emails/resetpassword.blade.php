@component('mail::message')

Dear {{ $details['name'] }} 
# Request has been received to change the password of your HR360 account.
  <br>

@component('mail::button', ['url' => route('reset.password.get', $details['token'])])
Reset Password
@endcomponent
   

@endcomponent