<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Rol;
use App\Models\BranchOffice;
use App\Models\Pet;
use App\Models\Cage;
use App\Models\User;
use App\Models\Token;
use App\Models\Pelicula;
use App\Http\Controllers\CodesController;
use App\Http\Controllers\AuthController;

class ViewsController extends Controller
{

    private $AuthController;
    private $CodesController;

    public function __construct()
    {
        $this->AuthController = app(AuthController::class);
        $this->CodesController = app(CodesController::class);
    }

    public function __invoke(Request $request)
    {
        return "Welcome to our homepage";
    }

    public function loginView(Request $request)
    {
        return view('Auth.login');
    }

    public function dashboardView()
    {
        return view('components.dashboard');
    }

    public function verifyCode(Request $request)
    {
        if (!$request->hasValidSignature()) {
            $this->AuthController->changeStatusCodesUser();
            $this->CodesController->deleteCodes(Auth::user()->id);
            Session::flush();
            Auth::logout();
            abort(419);
        }
        return view('components.verifyCode');
    }


    public function vistaPelicula()
    {

        $peliculas = Pelicula::where('status','=',1)->get();

        return view('components.peliculas.peliculas',compact('peliculas'));
    }

    public function notificationToken()
    {
        $tokendelete = Token::select(
            'users.name',
            'token_permission.user_id',
            'token_permission.id',
            'token_permission.status'
        )->join('users','users.id','=','token_permission.user_id')
        ->where('requestToken','=',1)->where('method','=','delete')->get();

        $tokenupdate = Token::select(
            'users.name',
            'token_permission.user_id',
            'token_permission.id',
            'token_permission.status'
        )->join('users','users.id','=','token_permission.user_id')
         ->where('requestToken','=',1)->where('method','=','update')->get();

        return view('components.notificacion',compact('tokendelete','tokenupdate'));
    }

    public function denegadoView()
    {
        return view('components.denegado');
    }
}
