<?php

namespace Authentication\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;

class ApiauthenticateController extends AbstractActionController{

    public function indexAction()
    {
        
    }

    public function loginAction(){

        $jsonModel  = new JsonModel();
        return $jsonModel;

    }


    public function registerAction(){

    }


    public function refreshTokenAction(){

    }


    public function revokeToken(){

    }


    public function logoutAction(){
        
    }
}