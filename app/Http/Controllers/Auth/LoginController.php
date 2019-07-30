<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function index()
    {
        return view('home');

    }
    public function redirectPath()
    {
        switch(auth()->user()->profile_id){
            case 1:
                $this->redirectTo= route('admin');
                return $this->redirectTo;
                break;

            case 2:
                if(auth()->user()->div_id == 1){
                    $this->redirectTo= route('bodega');
                    return $this->redirectTo;
                }else{
                    $this->redirectTo= route('bodega.almacen',auth()->user()->div_id);
                    return $this->redirectTo;
                }
                break;
        }
    }
}
