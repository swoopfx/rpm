<?php

namespace Customer\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class DoriHostController extends AbstractActionController {

    public function indexAction(){
        $viewModel = new ViewModel();
        return $viewModel;
    }


    public function requestPickUpAction(){
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

}