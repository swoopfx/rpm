<?php
namespace Authentication\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class AuthenticateController extends AbstractActionController{

    private  $authenticateService ;

    private $em;

    private $loginForm;

    public function loginAction(){

        // check if there is a referal 
        $viewModel = new ViewModel();
        $jsonModel = new JsonModel();
        // $user = $this->identity();
        $request = $this->getRequest();
        $referer = $request->getHeader('referer');


        if($request->isPost()){
            

            // if referer is not null, 
            // Redirect to referer else redirect to dashboard

        }
        
        // return $jsonModel;
        $viewModel = new ViewModel();
        $this->layout()->setTemplate("login-layout");
        return  $viewModel;

    }

    // public function registerAction(){
    //     $viewModel = new ViewModel();
    //     return $viewModel;
    // }



    public function forgotPasswordAction(){

    }

    public function confirmEmailAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }

    /**
     * Get the value of authenticateService
     */ 
    public function getAuthenticateService()
    {
        return $this->authenticateService;
    }

    /**
     * Set the value of authenticateService
     *
     * @return  self
     */ 
    public function setAuthenticateService($authenticateService)
    {
        $this->authenticateService = $authenticateService;

        return $this;
    }

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
}