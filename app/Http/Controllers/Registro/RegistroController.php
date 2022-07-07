<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class RegistroController extends Controller
{
    public function registro(Request $request){
        try{
            $pass = Hash::make($request->pass);

            if(User::create([
                'name' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => $pass,
                'type' => 0,
            ])){
        return response()->json(['status' => true, 'meesage' => 'Se ha guardado con exito.']);
            }else{
        return response()->json(['status' => true, 'meesage' => 'No se guardo.']);
            }          
        }catch (Exception $e) {
    return response()->json(['status' => false, 'meesage' => 'Ha ocurrido un error.']);
        }



        
    }


    public function registroAdmin(Request $request){
        try{
            $pass = Hash::make($request->pass);

            if(User::create([
                'name' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => $pass,
                'type' => 1,
            ])){
            return response()->json(['status' => true, 'meesage' => 'Se ha guardado con exito el admin.']);
            }else{
            return response()->json(['status' => true, 'meesage' => 'No se guardo el admin.']);
            }          
            }catch (Exception $e) {
        return response()->json(['status' => false, 'meesage' => 'Ha ocurrido un error.']);
        }



        
    }
}
