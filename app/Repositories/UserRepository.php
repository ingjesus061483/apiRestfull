<?php
namespace App\Repositories;

use App\Contracts\IRepository;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
class UserRepository implements IRepository{
     public function GetAll()
     {
        return User::all();
        
     }
     public function Find($id)
     {
        return User::find($id);
     }
     public function Store($request)
     {
        $user=  User::create([                
            'name'=>$request->input('name'),                            
            'email'=>$request->input('email'),                
            'identification_type_id'=>$request->input('identification_type'),                                            
            'password'=>hash::make( $request->input('password')),                            
        ]);                             

     }
     public function user_exist( $user)
     {
         return $user!=null;
     }
     public function Update($id, $request)
     {
        $user=$this->Find($id); //User::find($id);            
        if(!$this->user_exist($user))// $user==null)
        {
            throw new Exception('user not found!');
            //return response()->json(['message'=>'user not found!','user'=>$user],404 );            
        } 
        $user->name=$request->input('name');                    
        $user-> identification_type_id=$request->input('identification_type');            
        $user->update();          
     }
     public function Delete($id)
     { 
        $user=User::find($id);
        if(!$this->user_exist($user)){            
            throw new Exception('user not found!');
            //return response()->json(['message'=>'user not found!','user'=>$user],404 );
        }
        $user->delete();
        
     }
}