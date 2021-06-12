<?php 

namespace App\Services\RecieptProvider;

use App\Http\Controllers\MockApiController;
use GuzzleHttp\Client;
class AndroidRecieptProvider implements RecieptProviderInterface {

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
      $client = new Client();
      $res = $client->request('GET', 'https://app.case.local/api/mock-android-verify', [
          'auth' => [$this->userName, $this->password],
          'query' => [
            "reciept"=> $this->reciept
          ]
      ]);
      $resultArr = [];
      if($res->getStatusCode() == "200") {
          $resultArr = $this->generateResponse($res->getBody()->getContents());
      }
      return $resultArr;
  }

  private function generateResponse($content)
  {
    return json_decode($content);
  }

}