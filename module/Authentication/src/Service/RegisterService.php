<?php
namespace Authentication\Service;

use Exception;

class RegisterService {

    private $postmarkAuthMailService;

    private $generalService;

    private $post;

    private $registerInputFilter;

    public function register(){
        $post = $this->post;
        if($post == null){
            throw new \Exception("Post data is required");
        }

        
    }


    private function webMailNotifier(){

    }

    private function mobileMailNotifer(){

    }


    /**
     * Get the value of generalService
     */ 
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * Set the value of generalService
     *
     * @return  self
     */ 
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;

        return $this;
    }

    /**
     * Get the value of postmarkAuthMailService
     */ 
    public function getPostmarkAuthMailService()
    {
        return $this->postmarkAuthMailService;
    }

    /**
     * Set the value of postmarkAuthMailService
     *
     * @return  self
     */ 
    public function setPostmarkAuthMailService($postmarkAuthMailService)
    {
        $this->postmarkAuthMailService = $postmarkAuthMailService;

        return $this;
    }
}