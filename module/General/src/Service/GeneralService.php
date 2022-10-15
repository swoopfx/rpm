<?php
namespace General\Service;


class GeneralService {


    private $em;

    private $mail;

    private $authService;

    

    /**
     * Get the value of em
     */ 
    public function getEm()
    {
        return $this->em;
    }

    /**
     * Set the value of em
     *
     * @return  self
     */ 
    public function setEm($em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     * Get the value of mail
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of authService
     */ 
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Set the value of authService
     *
     * @return  self
     */ 
    public function setAuthService($authService)
    {
        $this->authService = $authService;

        return $this;
    }
}