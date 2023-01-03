<?php 
  
namespace App\Http\Controllers\Auth; 
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Mail\ResetPassword as MailResetPassword;
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
  
class ForgotPasswordController extends Controller
{
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth.forgetPassword');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
  
          $token = Str::random(64);
          
          $name = User::where('email',$request->email)->value('name');
          $employee =  User::where('email',$request->email)->value('employee_number');

          $details = [
            'token' => $token,
            'name' => $name,
            'employee' => $employee
        ];
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);

            Mail::to($request->email)->send(new MailResetPassword($details));
  
          // Mail::send('email.forgetPassword', ['name' => $name, 'token' => $token], function($message) use($request){
          //     $message->to($request->email);
          //     $message->subject('Reset Password');
          //     $message->markdown('emails.leave');
              
          // });
  
          return back()->with('message', 'We have sent you a reset-password email, open the link in the email to continue, you can close this page now. تم ارسال ايميل لتعيين كلمة السر , يرجى فتح الرابط في الايميل لاستكمال عملية تعيين كلمة السر , يمكنك اغلاق هذه الصفحة الآن');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
            return redirect()->back()->with("error", "No reset password request for this email address");
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
          
          User::where('email', $request->email)
          ->update(['email_verified_at' => Carbon::now()]);

          return redirect('/login')->with("success", "Your password has been changed!");
      }
}