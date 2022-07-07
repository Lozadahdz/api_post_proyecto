<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
class LoginController extends Controller
{
  public function login(Request $request)
  {

    $request->validate([
      'email' => 'required',
      'password' => 'required',
    ]);

    $user = User::where('email',$request->email)->get();
    if($user[0]->type == 0){
    
      if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        return response()->json(['status' => true, 'meesage' => 'Te has logeado con exito.', 'data' => Auth::user()]);
      }else{
        return response()->json(['status' => false, 'meesage' => 'Algo ha salido mal.']);
      }

    }else{
      return response()->json(['status' => false, 'message' => 'No tienes cuenta de usuario.']);

    }
    //return json_encode($user);
  }

  public function loginAdmin(Request $request)
  {

    $request->validate([
      'email' => 'required',
      'password' => 'required',
    ]);
    
    $user = User::where('email',$request->email)->get();
    if($user[0]->type == 1){

      if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        return response()->json(['status' => true, 'message' => 'Te has logeado con exito.', 'data' => Auth::user()]);
      }else{
        return response()->json(['status' => false, 'message' => 'Algo ha salido mal.']);
      }
    }else{
      return response()->json(['status' => false, 'message' => 'No tienes cuenta de administrador.']);
    }
    //return json_encode($user);
  }
  
}
