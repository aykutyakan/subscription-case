<?php

  namespace App\Services\RecieptProvider;

  interface RecieptProviderInterface {
    
     public function verify();

     public function setCredentials($userName, $password);

     public function setRecieptCode($reciept);
    
  }