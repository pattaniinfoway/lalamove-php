<?php


//$host = 'https://sandbox-rest.lalamove.com/v2/orders/'.'90944138-0495-9211-5200-273612447021';    


$host = 'https://sandbox-rest.lalamove.com/v2/orders/'.'{customerOrderId}';
   
  $apikey="344436c58795461f99ec1321852a09c3";
    $time = time() * 1000;




$method="GET";

$curl = curl_init();
   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($body)
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($body)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                
         break;
      default:
         
   }
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $host);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'X-Request-ID: '.uniqid(),
      'Content-Type: application/json',
      "Authorization:  hmac ".$apikey.":".$time.":".getSignature($time,$method),
      "X-LLM-Country: MY"
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   print_r($result) ;





 function getSignature($time,$method)
  {
    //echo json_encode((object)$body;exit;
    $secret = 'MCwCAQACBQDPDVk7AgMBAAECBDiSbEkCAwDf1QIDAOzPAgILOQICVhkCAwDP';
   // $path="/v2/orders/".'90944138-0495-9211-5200-273612447021';
     $path="/v2/orders/".'{customerOrderId}';
    $_encryptBody = '';
    if ($method == "GET") {
      $_encryptBody = $time."\r\n".$method."\r\n".$path."\r\n\r\n";
    } else {
      $_encryptBody = $time."\r\n".$method."\r\n".$path."\r\n\r\n".json_encode($body);
      //print_r($body);exit;
    }
    return hash_hmac("sha256", $_encryptBody, $secret);
  }

?>