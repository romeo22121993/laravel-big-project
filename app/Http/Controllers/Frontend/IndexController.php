<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class IndexController extends Controller
{

    public function __construct( ) {
//        $this->middleware('auth');
    }

    /**
     * Main home page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function Index(){
        return view('frontend.index');
    }

    /**
     * Function for user log out
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function UserLogout(){
        Auth::logout();
        return Redirect()->route('login');
    }

    /**
     * Function for log in
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginForm(){
        return view('auth.admin_login', ['guard' => 'admin']);
    }

    /**
     * Custom login form function
     *
     * @param Request $request
     * @return mixed
     */
    public function CustomLogin( Request $request ) {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if ( Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
        else {
            return redirect()->route("admin.login")->withErrors(['msg' => 'Login details are not valid']);
        }

    }

    /**
     * Custom login form function
     *
     * @param Request $request
     * @return mixed
     */
    public function TestEmail( Request $request ) {
        $request->validate([
            'email'    => 'required'
        ]);


        $email = $request->email;
        $to_name = 'fff';
        $to_email = $email;
        $data = array('name'=> "Ogbonna Vitalis(sender_name)", "body" => "A test mail");
        Mail::send( 'emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject( 'Laravel Test Mail');
            $message->from( 'roman.b.upqode@gmail.com', 'Test Mail');
        });


        return redirect()->route('dashboard')->withErrors(['msg' => 'Login details are not valid']);

    }


}
