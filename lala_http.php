<?php


$host = 'https://sandbox-rest.lalamove.com/v2/quotations';    



    $body = array(
          "scheduleAt" => gmdate('Y-m-d\TH:i:s\Z', time() + 60 * 30), // ISOString with the format YYYY-MM-ddTHH:mm:ss.000Z at UTC time
          "serviceType" => "MOTORCYCLE",                              // string to pick the available service type
          "specialRequests" => array(),                               // array of strings available for the service type
          "requesterContact" => array(
            "name" => "Draco Yam",
            "phone" => "+60173301638"                                  // Phone number format must follow the format of your country
          ),  
          "stops" => array(
            array(
              "location" => array("lat" => "3.087775", "lng" => "101.636862"),
              "addresses" => array(
                "en_MY" => array(
                  "displayString" => "Suite 4.02, 4th Floor, Wisma Ali Bawal 1, 11, Lorong Tandang 51/204b, Pjs 51, 46050 Petaling Jaya, Selangor, Malaysia",
                  "country" => "MY"                                   // Country code must follow the country you are at
                )   
              )   
            ),  
            array(
              "location" => array("lat" => "3.109318", "lng" => "101.637151"),
              "addresses" => array(
                "en_MY" => array(
                  "displayString" => "Jalan 14/17, Seksyen 14, 46100 Petaling Jaya, Selangor, Malaysia",
                  "country" => "MY"                                   // Country code must follow the country you are at
                )   
              )   
            )   
          ),  
          "deliveries" => array(
            array(
              "toStop" => 1,
              "toContact" => array(
                "name" => "Brian Garcia",
                "phone" => "+60173301638"                              // Phone number format must follow the format of your country
              ),  
              "remarks" => "ORDER #: 1234, ITEM 1 x 1, ITEM 2 x 2"
            )   
          )   
        );
  //print_r(json_encode($body));exit;
  $apikey="";
    $time = time() * 1000;




$method="POST";

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
      "Authorization:  hmac ".$apikey.":".$time.":".getSignature($time,$method,$body),
      "X-LLM-Country: MY"
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   print_r($result) ;





 function getSignature($time,$method,$body)
  {
    //echo json_encode((object)$body;exit;
    $secret = '';
    $path="/v2/quotations";
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