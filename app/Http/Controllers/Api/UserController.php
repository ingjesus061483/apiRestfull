<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\IdentificationType;
use App\Repositories\IdentificationTypeRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    protected IdentificationTypeRepository $_identificationTypeRepository;
    protected UserRepository $_userRepository;
    public function __construct(UserRepository $userRepository,IdentificationTypeRepository $identificationTypeRepository) {
        $this->_userRepository = $userRepository;
        $this->_identificationTypeRepository=$identificationTypeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=$this->_userRepository->GetAll();
        return response()->json($users);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {    
        try
        {
            $validacion=$request->validate([               
                'name'=>'required',
                'email'=>'required|email|max:255|unique:users',
                'password'=>'required',  
                'identification_type'=>'required'          
            ]);             
            $identification_type=$this->_identificationTypeRepository->Find($request->input('identification_type')); //IdentificationType::find($request->input('identification_type'));
            if(!$this->_identificationTypeRepository->identification_type_exist($identification_type)) {//$identification_type==null){
                throw new Exception('identification type is not found');
            }   
            $this->_userRepository->Store($request);         
                                
            return response()->json(['message'=>'user created!']);        
        }       
        catch(Exception $ex) 
        {            
            return response()->json(['ErrorMessage'=>$ex->getMessage()],400);
        }               
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user=$this->_userRepository->Find($id);
        if(!$this->_userRepository->user_exist($user) ){            
            return response()->json(['message'=>'user not found!','user'=>$user],404 );
        }
        return response()->json(['message'=>'user found!','user'=>$user]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        try
        {
            $validacion=$request->validate([                               
                'name'=>'required',                                       
                'identification_type'=>'required',           
            ]);                
            $identification_type=$this->_identificationTypeRepository->Find($request->input('identification_type'));// IdentificationType::find($request->input('identification_type'));            
            if(!$this->_identificationTypeRepository->identification_type_exist($identification_type))// $identification_type==null)
            {                
                throw new Exception('identification type is not found');            
            }                        
            $this->_userRepository->Update($id ,$request);
       /*     $user=$this->_userRepository->Find($id); //User::find($id);            
            if( ! $this->_userRepository->user_exist($user))// $user==null)
            {
                return response()->json(['message'=>'user not found!','user'=>$user],404 );            
            }            
       
            $user->name=$request->input('name');                    
            $user-> identification_type_id=$request->input('identification_type');            
            $user->update();            */
            return response()->json(['message'=>'user updated!']);        
        }
        catch(exception $ex)        
        {
            return response()->json(['message'=>$ex->getMessage()],400);        
        }
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        try
        {
            $this->_userRepository->Delete($id);
            return response()->json(['message'=>'user deleted!']);        //
        }
        catch(Exception $ex)
        {
            return response()->json(['message'=>$ex->getMessage()],400);        
        }
           /*    $user=User::find($id);
        if($user==null){            
            return response()->json(['message'=>'user not found!','user'=>$user],404 );
        }
        $user->delete();*/
    
    }
}
