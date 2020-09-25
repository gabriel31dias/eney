<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SmsController;
use App\Validatestoken;

class SmsValidController extends Controller
{
    
    public function sendSmsToken($telefone){
      $sms = new SmsController();
      $generatetoken = rand(100,1000);
      $newtoken = new Validatestoken();
      $newtoken->token = $generatetoken;
      $newtoken->save();
      //return   $sms->sendSinglesms('0030015529',$telefone,'O seu token do WebApp é'.$generatetoken );
      return    $newtoken->all();
   }

   public function verificatoken($token){
      $sms = new Validatestoken();
      $sms = $sms->where('token',$token)->first();
       
      if(isset($sms->id)){
          return 'true';
      }else{
          return 'false'; 
      }

      return response()->json( $sms);

   }

}
