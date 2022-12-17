<?php

namespace Wallet\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;

class WalletApiController extends AbstractActionController{

    public function indexAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;

    }

    public function getWalletAction(){
        $jsonModel = new JsonModel();
        return $jsonModel;
    }
}