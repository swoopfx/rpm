<?php

namespace Authentication\Service;


class JWTConfiguration
{
    private $configuration;

    private $key;

    private $signer;

    public function setConfiguration($config)
    {
        $this->configuration = $config;
        return $this;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    // public function signer()
    // {
    //     return $this->signer;
    // }

    // public function signingKey()
    // {
    //     return $this->key;
    // }

    // public function setKey($key)
    // {
    //     $this->key = $key;
    //     return $this;
    // }



    // /**
    //  * Get the value of signer
    //  */
    // public function getSigner()
    // {
    //     return $this->signer;
    // }

    // /**
    //  * Set the value of signer
    //  *
    //  * @return  self
    //  */
    // public function setSigner($signer)
    // {
    //     $this->signer = $signer;

    //     return $this;
    // }
}
