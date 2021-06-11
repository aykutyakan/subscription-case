<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MockApiController extends Controller
{
    const SUBSCRIPTONDAYS = 30;
    public function androidVerify(Request $request)
    {
        $result = [];
        list(, $token) = explode(" ", $request->header('Authorization'));

        if( base64_decode( $token ) == "android:password")
        {
            $result = $this->verifyReciept($request->reciept);
        } else {
            $result = [
                "errors" => "Kimlik bilgileri hatalı"
            ];
        }

        return response()->json($result);
        
    }
    
    public function iosVerify(Request $request)
    {
        $result = [];
        list(, $token) = explode(" ", $request->header('Authorization'));
        if( base64_decode( $token ) == "ios:password")
        {
            $result = $this->verifyReciept($request->reciept);
        } else {
            $result = [
                "errors" => "Kimlik bilgileri hatalı"
            ];
        }

        return response()->json($result);
    }

    private function verifyReciept($reciept)
    {
        return [
            "status" => $this->isValidRecieptCode($reciept) ?? false,
            "expired_date" => $this->generateExpireDate()
        ];
    }

    private function isValidRecieptCode($reciept)
    {
      return $reciept % 2 == 1 ? true : false;
    }

    private function generateExpireDate() 
    {
      $expiredDate = new \DateTime("now");
      $expiredDate->modify(self::SUBSCRIPTONDAYS." days");
      return $expiredDate->format("Y-m-d H:i:s");
    }
}