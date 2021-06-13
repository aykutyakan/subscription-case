<?php 
  
namespace App\Services\RecieptProvider;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class IosRecieptProvider implements RecieptProviderInterface {
    private $userName;
    private $password;
    private $reciept;

    public function setCredentials($userName, $password)
    {
      $this->userName = $userName;
      $this->password = $password;
      return $this;
    }
    public function setRecieptCode($reciept)
    {
      $this->reciept = $reciept;
      return $this;
    }

  /**
   * @return array
  */
  public function verify()
  {
      $client = new Client(['http_errors' => false]);
      $res = $client->request('GET', 'http://app.case.local/api/mock/ios-verify', [
          'auth' => [$this->userName, $this->password],
          'query' => [
            "reciept"=> $this->reciept
          ]
      ]);
      $resultArr = [];
      if($res->getStatusCode() == "200") {
        $resultArr = $this->generateResponse($res->getBody()->getContents());
      }else {
        $resultArr = (object) ["errors" => "Bilinmeye hata"];
      }
      return $resultArr;
  }

  private function generateResponse($content)
  {
    return json_decode($content);
  }

}