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
    private $cod_estabelecimento;

    public function __construct($iduser){
        $this->user = new User;
        $this->user = $this->user->where('codigo_estabelecimento',$iduser)->first();
        $this->cod_estabelecimento = $iduser;
    }

   public function getForma(){

      $user =  $this->user;
    
      switch ($user->fpagamentoeletronico) {
        case 1:
           // return new CieloCheckoutlink();
           return new CieloCheckoutlink( $this->cod_estabelecimento);
            break;
        case 2:
            return new PagseguroCheckout( $this->cod_estabelecimento);
            break;
       }

       return new CieloCheckoutlink( $this->cod_estabelecimento);

   }

   


   public static function getcodeloja($req){
    //  $tt =  $this->temp; 

    if(isset($req->order_number)){
        $auxvend = explode("-", $req->order_number);
        return  $auxvend[0];
    }

    if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
        ///Se for pagseguro entra aqui

     //   $venda = SwitchForma::requestVenda($_POST['notificationCode']);
      //  $auxvend = explode("-", $venda->reference);
        ///return $auxvend[0];

        return "gabriel";
        // pega a loja
        
    }
    


    if(isset($req->reference)){
       // $auxvend = explode("-", $req->reference);
       // return  $auxvend[0];
       return "abriel";
    }
    return $req;

 
    

   }


   public static function requestVenda($codevenda){

          ///https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/0AB8B171-DFAA-4003-8C8E-0D1CE58C8A1A?email=gabrieldias@keemail.me&token=B401968342C944079D49933B107A188A

       $getemail_token = SwitchForma::getemailtoken($codevenda);//passa o token do pag seguro 
       $url =  "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/".$codevenda.$getemail_token;
       $curl = curl_init($url);
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       $transaction= curl_exec($curl);
       if($transaction == 'Unauthorized'){
        //TRANSAÇÃO NÃO AUTORIZADA
          exit;
       }
       curl_close($curl);
       $transaction_obj = simplexml_load_string($transaction);
       return $transaction_obj;
     
   }

   public static function getemailtoken(){
        //pesquisa no calback de venda pagseguro e manda pra porra do sevidor pra obter de tablhes da venda
        return "?email=gabrieldias@keemail.me&token=B401968342C944079D49933B107A188A";

   }
   
  


}
