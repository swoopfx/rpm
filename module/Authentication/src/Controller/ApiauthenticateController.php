<?php

namespace Authentication\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Authentication\Form\InputFilter\RegisterInputfilter;
use Authentication\Form\InputFilter\LoginInputFilter;
use Authentication\Service\ApiAuthenticateService;
use General\Service\GeneralService;
use Doctrine\ORM\EntityManager;


class ApiauthenticateController extends AbstractActionController
{

    /**
     * Doctrine ORM EntityManager
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * GeneralSerive Class
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     * Api Athentication Service
     *
     * @var ApiAuthenticateService
     */
    private $apiAuthService;


    public function indexAction()
    {
    }

    /**
     * Undocumented function
     * @OA\POST( path="/api/login", tags={"Authentication"}, description="The  authenticate connecting entities.You need to be authenticated and be authorized to access the rest endpoints for integration. To authenticate, need to make a request for a token.This token is then added to the authorization header of the request you send to the api endpoint. the granst_type must be client_credentials",
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"username", "password", "userAgent", "userIp"},
     * @OA\Property(property="phoneOrEmail", type="string", example="ezekiel_a@yahoo.com or 07089898989"),
     * @OA\Property(property="password", type="string", example="Oluwaseun1"),
     * @OA\Property(property="userAgent", type="string", example="AppleWebKit/535.19 (KHTML, like Gecko)"),
     * @OA\Property(property="userIp", type="string", example="127.0.0.1"),
     * )
     * ),
     * ),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted")
     * )
     *
     * @return void
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $json = file_get_contents('php://input');

            // Converts it into a PHP object
            $postData = json_decode($json);
            $postData = (array) $postData;
            $this->loginInputFilter->setData($postData);
            try {

            } catch (\Throwable $th) {
                $jsonModel->setVariables([
                    "success" => false,
                    "description" => $th->getMessage()
                ]);
                $response = $this->getResponse();
                $response->setStatusCode(201);
            }
        }
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $jsonModel  = new JsonModel();
        return $jsonModel;
    }


    public function registerAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $json = file_get_contents('php://input');

            // Converts it into a PHP object
            $postData = json_decode($json);
            $postData = (array) $postData;
            try {
                //code...
            } catch (\Throwable $th) {
                //throw $th;
                $jsonModel->setVariables([
                    "success" => false,
                    "description" => $th->getMessage(),
                    // "errors" => $
                ]);
                $response = $this->getResponse();
                $response->setStatusCode(201);
            }

            // $this->registerInputFilter->setData($postData);
            // if ($this->registerInputFilter->isValid()) {
            //     $data = $this->registerInputFilter->getValues();

            //     // do all processing and trigering of mail here 
            //     $jsonModel->setVariables([
            //         "success" => true,
            //         "user" => ""
            //     ]);
            //     $response = $this->getResponse();
            //     $response->setStatusCode(201);
            // } else {
            //     $jsonModel->setVariables([
            //         "success" => false,
            //         "description" => "There are validation error(s) in the request.Please see below",
            //         "errors" => $this->registerInputFilter->getMessages(),
            //     ]);
            //     $response = $this->getResponse();
            //     $response->setStatusCode(201);
            // }
        }

        return $jsonModel;
    }

    // public function 


    public function refreshTokenAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
    }

    public function verifyEmailAction(){
        $jsonModel = new JsonModel();
        return $jsonModel;
    }


    public function forgotAction()
    {
    }


    public function revokeToken()
    {
    }


    public function logoutAction()
    {
    }

    /**
     * Get doctrine ORM EntityManager
     *
     * @return  EntityManager
     */ 
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set doctrine ORM EntityManager
     *
     * @param  EntityManager  $entityManager  Doctrine ORM EntityManager
     *
     * @return  self
     */ 
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Get generalSerive Class
     *
     * @return  GeneralService
     */ 
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * Set generalSerive Class
     *
     * @param  GeneralService  $generalService  GeneralSerive Class
     *
     * @return  self
     */ 
    public function setGeneralService(GeneralService $generalService)
    {
        $this->generalService = $generalService;

        return $this;
    }
}
