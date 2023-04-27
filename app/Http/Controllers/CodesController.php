<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Code;
use App\Http\Controllers\EncryptController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CodesController extends Controller
{
    private $EncryptController;

    public function __construct()
    {
        $this->EncryptController = app(EncryptController::class);
    }

    public function saveCodeEmail($id,$codes){
        $code = new Code();
        $code->code_email = $this->EncryptController->encrypt($codes);
        $code->user_id = $id;
        $code->save();
    }

    public function deleteCodes($id)
    {
        $codes = Code::where('user_id','=',$id)->get();
        foreach($codes as $code)
        {
            $code->delete();
        }
    }


    public function validateCodeView(Request $request)
    {
        $request->validate([
            'codigo'=>'required',
        ]);
        $userCodes  = Code::where('user_id','=',Auth::user()->id)->get();
        if(!$userCodes)
        {
            return redirect('/verificarCode')->with('msg','BADREQUEST');
        }
        foreach($userCodes as $user)
        {
            if($this->EncryptController->decrypt($user->code_email) == $request->codigo)
            {
                $user = User::find(Auth::user()->id);
                $user->status_code = true;
                $user->save();
                if($user->save())
                {
                    self::deleteCodes(Auth::user()->id);
                    if(Auth::user()->rol_id == 1)
                    {
                        return redirect('/QrView');
                    }
                    return redirect('/dashboard')->with('msg', 'Bienvenid@');
                }
                return back()->with('msg','ocurrio un error');
            }
        }
    }
}
