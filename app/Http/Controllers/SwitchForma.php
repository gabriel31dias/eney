<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\CieloCheckoutlink;
use App\Http\Controllers\RedeCheckoutlink;

class SwitchForma extends Controller
{

    private $user;
    private $iduser;

    public function __construct($iduser){
        $this->user = new User;
        $this->user->find($iduser)->first();
      
    }

   public function getForma(){

      $user =  $this->user;
    
      switch ($user->fpagamentoeletronico) {
        case 1:
            return new CieloCheckoutlink();
            break;
        case 2:
            return new RedeCheckoutlink();
            break;
       }

       return new CieloCheckoutlink();

   }
   
  


}
