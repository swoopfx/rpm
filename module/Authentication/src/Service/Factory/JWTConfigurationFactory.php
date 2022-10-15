<?php

namespace Authentication\Service\Factory;

use Authentication\Service\JWTConfiguration;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;

class JWTConfigurationFactory implements FactoryInterface{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
      if(!$container->has("config")){
        throw new InvalidArgumentException("JWT configuration factory cannot retrieve configuration data");
      }

      $config = $container->get("config");
      $key = InMemory::base64Encoded($config["jwt"]["signKey"]);
      $configuration = Configuration::forSymmetricSigner(new Sha256(), $key);
      $configuration->setValidationConstraints(
        new PermittedFor($config["jwt"]["url"])
      );

      
      $xserv = new JWTConfiguration();
      $xserv->setConfiguration($configuration);
      return $xserv;

    }
}