<?php

namespace Navigation;

class Module {


    public function getConfig(){
         /** @var array $config */
         $config = include __DIR__ . '/../config/module.config.php';
         return $config;
    }
}