<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostUsers;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function savePost(Request $request){

        try{


            if(PostUsers::create([
                'id_user' => $request->id_user,
                'tittle' => $request->tittle,
                'description' => $request->description,
                'status' => 0,
                'created_at' => now(),
            ])){

            return response()->json(['status' => true, 'meesage' => 'Se ha guardado con exito el post.']);

            }else{

            return response()->json(['status' => true, 'meesage' => 'No se guardo el post.']);

            }        
                
            }catch (Exception $e) {
        
        return response()->json(['status' => false, 'meesage' => 'Ha ocurrido un error, contacta a un admin.']);

        }
    }


    public function allPosts(){

        try{

            $posts = PostUsers::select('post_users.*','u.*')
            ->leftJoin('users as u','u.id', '=', 'post_users.id_user')
            ->where('post_users.status', 1)
            ->orderBy('post_users.created_at','desc')
            ->get();

            /* $count = PostUsers::select('post_users.*','u.*')
            ->leftJoin('users as u','u.id', '=', 'post_users.id_user')
            ->orderBy('post_users.created_at','desc')
            ->count(); */

            foreach($posts as $post){
                $publicaciones[] =[    
                    'id_user' =>  $post->id_user,
                    'description' => $post->description,
                    'tittle' => $post->tittle,
                    'status' => $post->status,
                    'created_at' => $post->getFromDateAttribute(),
                    'name' => $post->name,
                    'lastname' => $post->lastname,
                ];
                //dd($posts[2]->getFromDateAttribute());
               //dd($post->created_at->diffForHumans());
               // $posts[$key]->created_at = $posts[$key]->getFromDateAttribute();
            }



            return $publicaciones;

        }catch(Exception $e){
            
        }
    }


    public function postValidate(Request $request){

        try{
            $posts = PostUsers::select('post_users.*','u.name','u.lastname')
            ->leftJoin('users as u','u.id', '=', 'post_users.id_user')
            ->where('post_users.status', '0')
            ->orderBy('post_users.created_at','desc')
            ->get();

            $count = PostUsers::select('post_users.*','u.name','u.lastname')
            ->leftJoin('users as u','u.id', '=', 'post_users.id_user')
            ->where('post_users.status', '0')
            ->orderBy('post_users.created_at','desc')
            ->count();

            $publicaciones = array();

            if($count != 0){
                foreach($posts as $post){
                    $publicaciones[] =[   
                        'id' => $post->id,
                        'id_user' =>  $post->id_user,
                        'description' => $post->description,
                        'tittle' => $post->tittle,
                        'status' => $post->status,
                        'created_at' => $post->getFromDateAttribute(),
                        'name' => $post->name,
                        'lastname' => $post->lastname,
                    ];
                    //dd($posts[2]->getFromDateAttribute());
                   //dd($post->created_at->diffForHumans());
                   // $posts[$key]->created_at = $posts[$key]->getFromDateAttribute();
                }

                return response()->json(['status' => false, 'meesage' => 'Todo ha salido con exito.' , 'data' => $publicaciones]);

            }else{
                return response()->json(['status' => false, 'meesage' => 'No hay publicaciones para mostrar.' , 'data' => $publicaciones]);
            }

        }catch(Exception $e){
            return response()->json(['status' => false, 'meesage' => 'Algo ha ocurrido, porfavor, ponte en contacto con un administrador.']);  
        }
    }


    public function mypost(Request $request){

        try{
            $posts = PostUsers::select('post_users.*','u.*')
            ->leftJoin('users as u','u.id', '=', 'post_users.id_user')
            ->where('post_users.id_user', $request->id )
            ->where('post_users.status', '0')
            ->orderBy('post_users.created_at','desc')
            ->get();

            $count = PostUsers::select('post_users.*','u.*')
            ->leftJoin('users as u','u.id', '=', 'post_users.id_user')
            ->where('post_users.id_user', $request->id )
            ->where('post_users.status', '0')
            ->orderBy('post_users.created_at','desc')
            ->count();


            $publicaciones = array();

            if($count != 0){

                foreach($posts as $post){
                    $publicaciones[] =[    
                        'id_user' =>  $post->id_user,
                        'description' => $post->description,
                        'tittle' => $post->tittle,
                        'status' => $post->status,
                        'created_at' => $post->getFromDateAttribute(),
                        'name' => $post->name,
                        'lastname' => $post->lastname,
                    ];
                    //dd($posts[2]->getFromDateAttribute());
                   //dd($post->created_at->diffForHumans());
                   // $posts[$key]->created_at = $posts[$key]->getFromDateAttribute();
                }

                return response()->json(['status' => false, 'meesage' => 'Todo ha salido con exito.' , 'data' => $publicaciones]);

            }else{
                return response()->json(['status' => false, 'meesage' => 'No hay publicaciones para mostrar.' , 'data' => $publicaciones]);
            }

        }catch(Exception $e){
            return response()->json(['status' => false, 'meesage' => 'Algo ha ocurrido, porfavor, ponte en contacto con un administrador.']);
        }
    }

    public function postAccept(Request $request){
       
        $post = PostUsers::where('id',$request[0])->get();
        $post[0]->status = 1;
        $post[0]->save();

        return $post;

    }


    //FALTA HACER VALIDACIONES 
    public function postDecline(Request $request){
        
    
                $post = PostUsers::where('id',$request->id)->update(['status' => 0,'comments' => $request->post['comments'] ]);
                
    
           
    
            return $post;
        
       
    }

    public function allUsers(Request $request){

        return response(User::all());

    }

    public function disableUser(Request $request){

        if($request->status == 1){

            $user = User::where('id',$request->id)->get();
            $user[0]->status = 0;
            $user[0]->save();

        }else{
            $user = User::where('id',$request->id)->get();
            $user[0]->status =1;
            $user[0]->save();
        }

        return $user;
    }

    public function updatePass(Request $request){
        try{
          
           $id = $request->user['id'];
           $passwordencrypt =  Hash::make($request->newPass['newpass']);

            $password = DB::table('users')->where('id',$id)->update(['password' => $passwordencrypt]);


        return response()->json(['status' => false, 'meessage' => 'Se ha cambiado la contraseña con exito.']);

           
        }catch(Exception $e){
            return response()->json(['status' => false, 'meesage' => 'Algo ha ocurrido, porfavor, ponte en contacto con un administrador.']);
        }
    }




}
