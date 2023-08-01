<?php
namespace App\Repositories;

use App\Contracts\IRepository;
use App\Models\IdentificationType;

class IdentificationTypeRepository implements IRepository
{
    public function GetAll()
     {
        return IdentificationType::all();
        
     }
     public function Find($id)
     {
        return IdentificationType::find($id);
        
     }
     public function identification_type_exist( $identtificationtype)
     {
         return $identtificationtype!=null;
     }
     public function Store($request)
     {
        
     }
     public function Update($id, $request)
     {
        
     }
     public function Delete($id)
     {
        
     } 
}