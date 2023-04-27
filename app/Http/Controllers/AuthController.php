<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Mail\enviarCorreo;
use App\Models\User;
use App\Http\Controllers\CodesController;
use Illuminate\Support\Facades\DB;
use PDO;

class AuthController extends Controller
{

    private $CodesController;

    public function __construct()
    {
        $this->CodesController = app(CodesController::class);
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'=>'required',
                'password'=>'required',
            ]);

            $credentials = $request->only('email', 'password');

            $user = User::where("email", "=",$request->email)->first();

            $clientIP = $request->ip();

            $vpn = ['192.168.0.1','192.168.0.2','192.168.0.3','192.168.0.4',
            '192.168.0.5','192.168.0.6','192.168.0.7','192.168.0.8',
            '192.168.0.9','192.168.0.10','192.168.0.11','192.168.0.12'];

            if(!$user)
            {
                return redirect('/login')->with('msg', 'el usuario no existe');
            }
            if (Auth::attempt($credentials)) {

                $user = User::where("email", "=",$request->email)->first();

                if($user->status == 0)
                {
                    return redirect('/login')->with('msg', 'usuario deshabilitado');
                }

                if(Auth::user()->rol_id == 1)
                {
                    foreach($vpn as $vpnip)
                    {
                        if($clientIP == $vpnip)
                        {
                            if(self::sendEmail($user) == true)
                            {
                                return redirect('/login')->with('msg','Codigo de autentificacion enviado al correo');
                            }
                        }
                    }
                    self::signOut();
                    return redirect('/login')->with('msg','Este usuario solo puede acceder por vpn');
                }
                elseif(Auth::user()->rol_id == 2)
                {
                    if(self::sendEmail($user) == true)
                    {
                        return redirect('/login')->with('msg','Codigo de autentificacion enviado al correo');
                    }
                }
                elseif(Auth::user()->rol_id == 3)
                {
                    foreach($vpn as $vpnip)
                    {
                        if($clientIP == $vpnip)
                        {
                            self::signOut();
                            return redirect('/login')->with('msg','Este usuario no puede acceder por la vpn');
                        }
                    }
                    return redirect('/dashboard')->with('msg', 'Bienvenid@');
                }
            }
            return redirect()->back()->with('msg', 'credenciales no validas');

        } catch (\Exception $e) {
            return redirect('/login')->with('msg','error al conectar con la base de datos');
        }
    }

    public function signOut()
    {
        $this->CodesController->deleteCodes(Auth::user()->id);
        self::changeStatusCodesUser();
        Session::flush();
        Auth::logout();
        return redirect('/login');
    }

    public function sendEmail(User $user)
    {
        $code = rand(1000,10000);

        $url=URL::temporarySignedRoute('verifyCode', now()->addMinutes(5));

        $this->CodesController->saveCodeEmail(Auth::user()->id,$code);

        Mail::to(Auth::user()->email)->send(new enviarCorreo($user,$code,$url));

        return true;
    }

    public function changeStatusCodesUser()
    {
        $user = User::find(Auth::user()->id);
        $user->status_code = false;
        $user->status_qr = false;
        $user->save();
    }
}
