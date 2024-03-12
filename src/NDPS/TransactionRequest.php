<?php
namespace NDPS;

require_once 'AtomAES.php';
date_default_timezone_set('Asia/Kolkata');

/**
 * Version 1.0
 */
class TransactionRequest
{
    private $merchId;
    private $password;
    private $merchTxnId;
    private $merchTxnDate;
    private $amount;
    private $product;
    private $custAccNo;
    private $txnCurrency;
    private $custEmail;
    private $custMobile;
    private $udf1;
    private $udf2;
    private $udf3;
    private $udf4;
    private $udf5;
    private $requestEncypritonKey;
    private $responseEncryptionKey;
    private $isLive;
    private $auth_url = "";



    

    public function getIsLive()
    {
        return $this->isLive;
    }
    
    public function setIsLive($isLive)
    {
        $this->isLive = $isLive;
    }
    

    
    public function getMerchId()
    {
        return $this->merchId;
    }

    public function setMerchId($merchId)
    {
        $this->merchId = $merchId;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getMerchTxnId()
    {
        return $this->merchTxnId;
    }
    
    public function setMerchTxnId($merchTxnId)
    {
        $this->merchTxnId = $merchTxnId;
    }

    public function getMerchTxnDate()
    {
        return $this->merchTxnDate;
    }
    
    public function setMerchTxnDate($merchTxnDate)
    {
        $this->merchTxnDate = $merchTxnDate;
    }

    public function getAmount()
    {
        return $this->amount;
    }
    
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getProduct()
    {
        return $this->product;
    }
    
    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function getCustAccNo()
    {
        return $this->custAccNo;
    }
    
    public function setCustAccNo($custAccNo)
    {
        $this->custAccNo = $custAccNo;
    }

    public function getTxnCurrency()
    {
        return $this->txnCurrency;
    }
    
    public function setTxnCurrency($txnCurrency)
    {
        $this->txnCurrency = $txnCurrency;
    }

    public function getCustEmail()
    {
        return $this->custEmail;
    }
    
    public function setCustEmail($custEmail)
    {
        $this->custEmail = $custEmail;
    }

    public function getCustMobile()
    {
        return $this->custMobile;
    }
    
    public function setCustMobile($custMobile)
    {
        $this->custMobile = $custMobile;
    }

    public function getUDF1()
    {
        return $this->udf1;
    }
    
    public function setUDF1($udf1)
    {
        $this->udf1 = $udf1;
    }

    public function getUDF2()
    {
        return $this->udf2;
    }
    
    public function setUDF2($udf2)
    {
        $this->udf2 = $udf2;
    }

    public function getUDF3()
    {
        return $this->udf3;
    }
    
    public function setUDF3($udf3)
    {
        $this->udf3 = $udf3;
    }

    public function getUDF4()
    {
        return $this->udf4;
    }
    
    public function setUDF4($udf4)
    {
        $this->udf4 = $udf4;
    }

    public function getUDF5()
    {
        return $this->udf5;
    }
    
    public function setUDF5($udf5)
    {
        $this->udf5 = $udf5;
    }

    public function getRequestEncypritonKey()
    {
        return $this->requestEncypritonKey;
    }
    
    public function setRequestEncypritonKey($requestEncypritonKey)
    {
        $this->requestEncypritonKey = $requestEncypritonKey;
    }

    public function getResponseEncryptionKey()
    {
        return $this->responseEncryptionKey;
    }
    
    public function setResponseEncryptionKey($responseEncryptionKey)
    {
        $this->responseEncryptionKey = $responseEncryptionKey;
    }






    public function getAtomtokenId(){
        if($this->isLive == "true"){
            $this->auth_url = "https://payment1.atomtech.in/ots/aipay/auth";
        }
        else{
            $this->auth_url = "https://caller.atomtech.in/ots/aipay/auth";
        }

        $jsondata = '{
            "payInstrument": {
              "headDetails": {
                "version": "OTSv1.1",
                "api": "AUTH",
                "platform": "FLASH"
              },
              "merchDetails": {
                "merchId": "'. $this->merchId .'",
                "userId": "",
                "password": "'. $this->password .'",
                "merchTxnId": "'. $this->merchTxnId .'",
                "merchTxnDate": "'. $this->merchTxnDate .'"
              },
              "payDetails": {
                "amount": "'. $this->amount .'",
                "product": "'. $this->product .'",
                "custAccNo": "'. $this->custAccNo .'",
                "txnCurrency": "'. $this->txnCurrency .'"
              },
              "custDetails": {
                "custEmail": "'. $this->custEmail .'",
                "custMobile": "'. $this->custMobile .'"
              },
              "extras": {
                "udf1": "'. $this->udf1 .'",
                "udf2": "'. $this->udf2 .'",
                "udf3": "'. $this->udf3 .'",
                "udf4": "'. $this->udf4 .'",
                "udf5": "'. $this->udf5 .'"
              }
            }
          }';

          $atomenc = new AtomAES();
          $curl = curl_init();
          $encData = $atomenc->encrypt($jsondata, $this->requestEncypritonKey, $this->requestEncypritonKey );
          curl_setopt_array($curl, array(
            CURLOPT_URL => $this->auth_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_CAINFO => getcwd() . '\vendor\ndps\aipay-corephp\src\NDPS\cacert.pem',
            //CURLOPT_CAINFO => getcwd() . '/cacert.pem',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "encData=".$encData."&merchId=". $this->merchId ."",
            CURLOPT_HTTPHEADER => array(
              "Content-Type: application/x-www-form-urlencoded"
            ),
          ));
          $atomTokenId = null;
          $response = curl_exec($curl);  
          echo"<br>response:". $response;
          $getresp = explode("&", $response); 
          $encresp = substr($getresp[1], strpos($getresp[1], "=") + 1);  
          $decData = $atomenc->decrypt($encresp, $this->responseEncryptionKey, $this->responseEncryptionKey);

          if(curl_errno($curl)) 
          {
            $error_msg = curl_error($curl);
            echo "error = ".$error_msg;
          } 
          if(isset($error_msg)) 
          {
                // TODO - Handle cURL error accordingly
                echo "error = ".$error_msg;
          }  
          curl_close($curl);
          $res = json_decode($decData, true);
          if($res){
            if($res['responseDetails']['txnStatusCode'] == 'OTS0000'){
              $atomTokenId = $res['atomTokenId'];
            }else{
              echo "Error getting data";
               $atomTokenId = null;
            }
          } 

           return $atomTokenId;
    }






      
}

?>
