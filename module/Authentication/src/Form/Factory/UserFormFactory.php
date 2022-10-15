<?php

namespace Authentication\Form\Factory;

use Authentication\Form\UserForm;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserFormFactory implements FactoryInterface{

    public function __invoke(){
        $form = new UserForm();

        return $form;
    }
}