<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptController extends Controller
{
    public function encrypt($codigo)
    {
        $cadenaEncriptada = Crypt::encryptString($codigo);
        return $cadenaEncriptada;
    }

    public function decrypt($codigo)
    {
        try {
            $cadenaDesencriptada = Crypt::decryptString($codigo);
            return $cadenaDesencriptada;
        }
        catch(\Exception $e){
            return false;
        }
    }
}
