<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PeliculasController extends Controller
{
    public function addPeliculas(Request $request)
    {
        $request->validate([
            'titulo'=>'required',
            'descripcion'=>'required',
            'genero'=>'required',
            'duracion'=>'required',
            'imagen'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $pelicula = new Pelicula();
        $pelicula->titulo = $request->input('titulo');
        $pelicula->descripcion = $request->input('descripcion');
        $pelicula->genero = $request->input('genero');
        $pelicula->duracion = $request->input('duracion');
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            //dd($file);
            $disk = Storage::disk("do");
            $finalPath = 'img/';
            $filename = time() . '-' .$file->getClientOriginalName();
            $realPath = $file->getRealPath();
            $storage = Storage::disk("do")->put("/peliculas/img/".$filename, file_get_contents($realPath),'public');

            $urlp = Storage::disk('do')->url('/peliculas/img/'.$filename);
            //$uploadFile = $request->file('image')->move($finalPath, $filename);
            //$new_product->Img = $finalPath.$filename;
            $pelicula->imagen = $urlp;
        }
        if($pelicula->save())
        {
            return redirect('/peliculas')->with('msg','registrado correctamante');
        }
        return redirect('/peliculas')->with('msg','datos no validos');
    }

    public function updatePeliculas(Request $request, $id)
    {
        $request->validate([
            'titulo'=>'required',
            'descripcion'=>'required',
            'genero'=>'required',
            'duracion'=>'required',
            'imagen'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $pelicula = Pelicula::find($id);
        $pelicula->titulo = $request->input('titulo');
        $pelicula->descripcion = $request->input('descripcion');
        $pelicula->genero = $request->input('genero');
        $pelicula->duracion = $request->input('duracion');
        if($request->hasFile('image')){
            $file = $request->file('image');
            //dd($file);
            $disk = Storage::disk("do");
            $finalPath = 'img/';
            $filename = time() . '-' .$file->getClientOriginalName();
            $realPath = $file->getRealPath();
            $storage = Storage::disk("do")->put("/peliculas/img/".$filename, file_get_contents($realPath),'public');

            $urlp = Storage::disk('do')->url('/peliculas/img/'.$filename);
            //$uploadFile = $request->file('image')->move($finalPath, $filename);
            //$new_product->Img = $finalPath.$filename;
            $pelicula->imagen = $urlp;
        }
        if($pelicula->save())
        {
            $user = User::find(Auth::user()->id);
            $user->status_update = 0;
            if($user->save())
            {
                return redirect('/peliculas')->with('msg','registrado correctamante');
            }
        }
        return redirect('/peliculas')->with('msg','datos no validos');
    }

    public function changeStatusPelicula($id)
    {
        $pelicula = Pelicula::find($id);
        $pelicula->status = false;
        if($pelicula->save())
        {
            $user = User::find(Auth::user()->id);
            $user->status_delete = 0;
            if($user->save())
            {
                return redirect('/cages')->with('message','delete');
            }
        }
        return redirect('/cages')->with('message','BADREQUEST');
    }
}
