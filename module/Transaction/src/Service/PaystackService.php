<?php


namespace Transaction\Service;

use Laminas\Http\Client;

class PaystackService
{

    const PAYSTACK_BASE_URL = "https://api.paystack.co/";

    private $paystackSecret;


    public function verifyTransaction($ref)
    {

        $url = self::PAYSTACK_BASE_URL . "transaction/verify/{$ref}";
        $client = new Client();
        $client->setMethod("GET");
        $client->setHeaders([
            "Authorization" => "Bearer {$this->paystackSecret}"
        ]);
        $response = $client->send();
        if ($response->isSuccess()) {
            $body = json_decode($response->getBody());
            if ($body->status) {
                 // Get Parameters
                if ($body->data->status == "success") {
                   
                    // Alter Invoice Status
                    // Create Transaction
                }elseif ($body->data->status == "failed") {
                    # code...
                    // Alter invpoice to failed transaction
                }else{

                }
            }elseif ($body->status == false) {
                # co
            }
        }
    }
}
