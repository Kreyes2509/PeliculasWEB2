<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Token;
use App\Models\User;
use App\Models\BranchOffice;
use App\Models\Cage;
use App\Models\Pet;
use App\Mail\enviarToken;
use App\Mail\solicitudToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Events\NotificationEvent;

class TokenValidateController extends Controller
{
    public function getTokensGenerate(Request $request,$id)
    {
        $token = new Token();
        $token->user_id = $id;
        $token->requestToken = 1;
        $token->method = $request->method;
        $token->save();
        $user = User::all();
        foreach($user as $users)
        {
            if($users->rol_id == 1 || $users->rol_id == 2)
            {
                Mail::to($users->email)->send(new solicitudToken("http://192.168.0.4/notification"));
            }
        }
        return back()->with('msg','solicitud enviada');
    }

    Public function generateTokenUpdate($id)
    {
        $userToken = Token::where('user_id','=',$id)->where('method','=','update')->first();
        if(!$userToken)
        {
            return redirect('/notification')->with('msg','error al generar el token');
        }
        $token = Str::random(5);
        $userToken->token_update = $token;
        $userToken->user_id = $id;
        $userToken->status = 0;
        $tipo = 'update';
        if($userToken->save())
        {
            $user = User::where('id','=',$id)->first();
            Mail::to($user->email)->send(new enviarToken($user,$token,$tipo));
            return redirect('/notification')->with('msg','token enviado');
        }
    }

    Public function generateTokenDelete($id)
    {
        $userToken = Token::where('user_id','=',$id)->where('method','=','delete')->first();
        if(!$userToken)
        {
            return redirect('/notification')->with('msg','error al generar el token');
        }
        $token = Str::random(5);
        $userToken->token_delete = $token;
        $userToken->user_id = $id;
        $userToken->status = 0;
        $tipo = 'delete';
        if($userToken->save())
        {
            $user = User::where('id','=',$id)->first();
            Mail::to($user->email)->send(new enviarToken($user,$token,$tipo));
            return redirect('/notification')->with('msg','token enviado');
        }
    }


    public function deleteTokens($method)
    {
        $users = Token::where('user_id','=',Auth::user()->id)->where('method','=',$method)->get();
        foreach($users as $user)
        {
            $user->delete();
        }
    }

    public function validateToken(Request $request)
    {
        $request->validate([
            'token'=>'required',
        ]);
        $userToken = Token::where('user_id','=',Auth::user()->id)->get();

        foreach($userToken as $user)
        {
            if($user->token_update == $request->token && $user->method == 'update')
            {
                $userUpdate = User::find(Auth::user()->id);
                $userUpdate->status_update = 1;
                $userUpdate->save();
                self::deleteTokens('update');
                return back()->with('msg','token validado');
            }
            elseif($user->token_delete == $request->token && $user->method == 'delete')
            {
                $userUpdate = User::find(Auth::user()->id);
                $userUpdate->status_delete = 1;
                $userUpdate->save();
                self::deleteTokens('delete');
                return back()->with('msg','token validado');
            }
        }
        return back()->with('msg','token incorrecto');
    }
}
