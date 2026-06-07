<?php
namespace App\Traits;
use App\Helpers\Api as ApiHelper;

trait ApiController
{
    public function curlIntranet($token)
    {   
        $headers = [
            'Authorization: Bearer ' .$token,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, env('APP_URL_INTRANET').'/api/users/me');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        
        $response = (array) json_decode(curl_exec($ch));
        
        return $response;
    }
}
