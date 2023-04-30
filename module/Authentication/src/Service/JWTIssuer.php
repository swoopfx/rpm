<?php


namespace Authentication\Service;

use Authentication\Entity\User;
use Authentication\Entity\UserRefreshToken;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Doctrine\ORM\EntityManager;
use Exception;
use Laminas\Db\Sql\Ddl\Column\Datetime;
use Laminas\Mvc\Plugin\Identity\Identity;

class JWTIssuer
{

    /**
     * @var Configuration
     */
    private $config;

    /**
     * @var array
     */
    private $systemConfig;

    /**
     * ORM EntityManager
     *
     * @var EntityManager
     */
    private $entityManager;


    public function __construct()
    {
    }

    public function issueToken($data)
    {
        $now   = new \DateTimeImmutable();
        return  $this->config->builder()
            ->issuedBy($this->systemConfig["jwt"]["url"])
            ->permittedFor($data["aud"])
            ->identifiedBy($data["email"]) // device ID
            ->relatedTo($data["email"])->withClaim("coded", $data)
            ->issuedAt($now)
            ->expiresAt($now->modify($this->systemConfig["jwt"]["expiry"]))
            ->getToken($this->config->signer(), $this->config->signingKey());
    }


    public function generateRefreshToken($data)
    {
        try {
            // generate refresh token 
            $now   = new \DateTimeImmutable();
            $expiresOn = $now->modify($this->systemConfig["jwt"]["refreshExpire"]);
            $refreshToken = $this->config->builder()
                ->issuedBy($this->systemConfig["jwt"]["url"])
                ->permittedFor($data["data"]["aud"])
                ->identifiedBy($data["data"]["email"])
                ->relatedTo($data)->withClaim("uid", $data["data"]["uid"])
                ->issuedAt($now)
                ->expiresAt($expiresOn)
                ->getToken($this->config->signer(), $this->config->signingKey());

            // Hydrate  into data base 

            $datetime = new \Datetime();
            $userRefreshTokenEntity = new UserRefreshToken();
            $userRefreshTokenEntity->setCreatedOn(new \DateTime())
                ->setUserAgent($data["user_agent"])
                ->setExpiresOn(\Datetime::createFromImmutable($expiresOn))
                ->setUserId($this->entityManager->find(User::class, $data["user_id"]))
                ->setUuid($data["data"]["aud"])
                ->setRefreshUid(AuthenticationService::encryptPassword($data["refresh_uid"]))
                ->setRefreshToken($refreshToken->toString())->setUserIp($data["ip"]);

            $this->entityManager->persist($userRefreshTokenEntity);
            $this->entityManager->flush();

            return $refreshToken->toString();
        } catch (\Throwable $th) {
            //throw $th;
            throw new \Exception($th->getMessage());
        }
    }

    public function parseToken($jwt)
    {
        try {
            $config = $this->config;

            if (!isset($jwt)) {
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
            $config->setValidationConstraints(new PermittedFor($token->claims()->get("aud")));
            
            // $config->setValidationConstraints(new LooseValidAt($clock));
            // $config->setValidationConstraints(new Expires);
            if ($token instanceof UnencryptedToken) {
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
     * @param   $config
     *
     * @return  self
     */
    public function setConfig($config)
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
