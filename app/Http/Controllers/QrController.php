<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Events\QrValidate;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Broadcast;

class QrController extends Controller
{
    public function generateQrCode()
    {
        $user = User::find(Auth::user()->id);
        $user->status_qr = 1;
        $user->save();
        $codigoQR = QrCode::size(200)->generate($user);
        return view('components.verifyCodeQr',compact('codigoQR'));
    }

    public function detectarQr()
    {
        event(new QrValidate('qr validate'));
    }

    public function detectarMessage()
    {
        event(new NewMessage('hello world'));

        return response()->json(['message'=>'evento enviado']);
    }


}
