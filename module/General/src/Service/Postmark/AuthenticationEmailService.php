<?php

namespace General\Service\Postmark;

use Application\Service\ApplicationService;
use Postmark\PostmarkClient;

class AuthenticationEmailService implements PostmarkEmailInterface
{

    private $postmarkConfig;

    private $sender;

    private $data;

    private $apiToken;

    /**
     * Sends a confirmation Email vis postmark on web UI
     *
     * @return void
     */
    public function confirmEmailWeb()
    {
        if ($this->data == null){
            throw new \Exception("SetData must be set before calling Mail function ");
        }

        $client = new PostmarkClient($this->apiToken);
        $data = $this->data;
        // Send an email:
        $sendResult = $client->sendEmailWithTemplate(
            $this->sender,
            $data["email"],
            30048183,
            [
                "product_url" => "",
                "product_name" => ApplicationService::APP_NAME,
                "name" => $data["fullname"],
                "invite_sender_name" => ApplicationService::APP_NAME,
                "invite_sender_organization_name" => ApplicationService::APP_COMPANY_NAME,
                "action_url" => $data["url"],
                "support_email" => $this->postmarkConfig["support_email"],
                "live_chat_url" => "",
                "help_url" => "",
                "company_name" => ApplicationService::APP_COMPANY_NAME,
                "company_address" => ApplicationService::APP_COMPANY_ADDRESS,
            ]
        );
    }


    /**
     * Sends a confirmation Email vis postmark on web UI
     *
     * @return void
     */
    public function confirmEmailMobile()
    { 
        if ($this->data == null){
            throw new \Exception("SetData must be set before calling Mail function ");
        }

        $client = new PostmarkClient($this->apiToken);
        $data = $this->data;
        // Send an email:
        $sendResult = $client->sendEmailWithTemplate(
            $this->sender,
            $data["email"],
            30052990,
            [
                "product_url" => " ",
                "product_name" => ApplicationService::APP_NAME,
                "name" => $data["fullname"],
                "confirm_code" => $data["code"],
                "name" => $data["fullname"],
                "invite_sender_name" => ApplicationService::APP_NAME,
                "invite_sender_organization_name" => ApplicationService::APP_COMPANY_NAME,
                "support_email" => $this->postmarkConfig["support_email"],
                "live_chat_url" => "",
                "help_url" => "",
                "company_name" => ApplicationService::APP_COMPANY_NAME,
                "company_address" => ApplicationService::APP_COMPANY_ADDRESS,
            ]
        );
    }

    public function welcome()
    {
    }

    public function resetpassword()
    {
    }


    public function execute()
    {
    }

    public function getApiToken()
    {
        return $this->apiToken;
    }

    public function setApiToken($token)
    {
        $this->apiToken = $token;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get the value of postmarkConfig
     */
    public function getPostmarkConfig()
    {
        return $this->postmarkConfig;
    }

    /**
     * Set the value of postmarkConfig
     *
     * @return  self
     */
    public function setPostmarkConfig($postmarkConfig)
    {
        $this->postmarkConfig = $postmarkConfig;

        return $this;
    }

    /**
     * Get the value of sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set the value of sender
     *
     * @return  self
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }
}
