<?php

  namespace App\Services\RecieptProvider;

  interface BaseRecieptProvider {
    
     public function verify();

     public function setCredentials($userName, $password);

     public function setRecieptCode($reciept);
    
  }