<?php


namespace Authentication\Service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\ValidAt;

class JWTIssuer {

    /**
     * @var Configuration
     */
    private $config;

    /**
     * @var array
     */
    private $systemConfig;


    public function __construct()
    {
       
    }

    public function issueToken($data)
    {
        $now   = new \DateTimeImmutable();
        return  $this->config->builder()
         ->issuedBy($this->systemConfig["jwt"]["url"])
         ->permittedFor($this->systemConfig["jwt"]["url"])
         ->identifiedBy(bin2hex(random_bytes(16)))
         ->relatedTo($data)->withClaim("uid", $data)
         ->issuedAt($now)
         ->expiresAt($now->modify("+720 minute"))
         ->getToken($this->config->signer(), $this->config->signingKey());
    }

    public function parseToken($jwt)
    {
        try {
            $config = $this->config;
            
            if (! isset($jwt)) {
                throw new \Exception("No token provided");
                // exit();
            }

            /**
             * @var Token
             */
            $token = $config->parser()->parse($jwt);
            assert($token instanceof UnencryptedToken);

            // var_dump($token->claims());
            // exit();
            // var_dump($this->systemConfig["jwt"]["url"]);
            // exit();
            $config->setValidationConstraints(new IdentifiedBy($token->claims()->get("jti")));
            $clock = new JWTClock();
            $config->setValidationConstraints(new IssuedBy($this->systemConfig["jwt"]["url"]));
            $config->setValidationConstraints(new ValidAt($clock));
            // $config->setValidationConstraints(new LooseValidAt($clock));
            // $config->setValidationConstraints(new Expires);
            if($token instanceof UnencryptedToken){
                $constraints = $config->validationConstraints();
                if ($config->validator()->validate($token, ...$constraints)) {
                    return $token;
                } else {
                    return null;
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            return new $th->getMessage();
        }
            
    
    }


    /**
     * Get the value of config
     *
     * @return  Configuration
     */ 
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the value of config
     *
     * @param  Configuration  $config
     *
     * @return  self
     */ 
    public function setConfig(Configuration $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the value of systemConfig
     *
     * @return  array
     */ 
    public function getSystemConfig()
    {
        return $this->systemConfig;
    }

    /**
     * Set the value of systemConfig
     *
     * @param  array  $systemConfig
     *
     * @return  self
     */ 
    public function setSystemConfig(array $systemConfig)
    {
        $this->systemConfig = $systemConfig;

        return $this;
    }
}