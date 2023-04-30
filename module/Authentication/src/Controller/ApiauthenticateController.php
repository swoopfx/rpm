<?php

namespace Authentication\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Authentication\Form\InputFilter\RegisterInputfilter;
use Authentication\Form\InputFilter\LoginInputFilter;
use Authentication\Service\ApiAuthenticateService;
use General\Service\GeneralService;
use Authentication\Service\RegisterService;
use Doctrine\ORM\EntityManager;
use Laminas\InputFilter\InputFilter;

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

    /**
     * Register Service
     *
     * @var RegisterService
     */
    private $registerService;


    public function indexAction()
    {
    }

    /**
     * This API is used to authenticate the user 
     * @OA\POST( path="/auth/api/login", tags={"Authentication"}, description="The  authenticate connecting entities.You need to be authenticated and be authorized to access the rest endpoints for integration. To authenticate, need to make a request for a token.This token is then added to the authorization header of the request you send to the api endpoint. the granst_type must be client_credentials",
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"username", "password", "userAgent", "userIp"},
     * @OA\Property(property="username", type="string", example="ezekiel_a@yahoo.com or 07089898989"),
     * @OA\Property(property="password", type="string", example="Oluwaseun1"),
     * @OA\Property(property="userAgent", type="string", example="AppleWebKit/535.19 (KHTML, like Gecko)"),
     * @OA\Property(property="userIp", type="string", example="127.0.0.1"),
     * 
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
            $postData = json_decode($json, true);
            // $postData = (array) $postData;
            // $this->loginInputFilter->setData($postData);
            try {
                // Authenticate here 
                /**
                 * @var ApiAuthenticateService
                 */
                $authResponse = $this->apiAuthService->setPost($postData)->authenticate();
                $response->getHeaders()->addHeader($authResponse["cookie"]);
                $response->setSatausCode(200);
                $jsonModel->setVariables([
                    "success" => true,
                    "schema" => "Bearer",
                    "expires_in" => $authResponse["expire"],
                    "token" => $authResponse["token"],
                    "id_token" => $authResponse["refresh_uid"], // luhn algorithm value
                    "device_id" => $authResponse["aud"],
                ]);
            } catch (\Throwable $th) {
                $jsonModel->setVariables([
                    "success" => false,
                    "description" => $th->getMessage()
                ]);
                $response = $this->getResponse();
                $response->setStatusCode(400);
            }
        }
        $response = $this->getResponse();
        $response->setStatusCode(400);
        // $jsonModel  = new JsonModel();

        return $jsonModel;
    }


    /**
     * Registers a Customer 
     * 
     * @OA\POST( path="/auth/api/register", tags={"Authentication"}, description="This registeres a user",
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"fullname", "username", "email",  "password", "comfirm_password", "userAgent", "userIp", "device_type"},
     * @OA\Property(property="fullame", type="string", example="Idowu Yusuf Chukwuma"),
     * @OA\Property(property="username", type="string", example="09012121212"),
     * @OA\Property(property="email", type="string", example="ezekiel_a@yahoo.com"),
     * @OA\Property(property="password", type="string", example="Oluwaseun1"),
     * @OA\Property(property="confirm_password", type="string", example="Oluwaseun1"),
     * @OA\Property(property="userIp", type="string", example="127.0.0.1"),
     * @OA\Property(property="device_type", type="string", example="mobile or web or others", description="<p><ul><li>web</li> <li>mobile</li> <li>others</li></ul></p> "),
     * )
     * ),
     * ),
     * @OA\Response(response="201", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted")
     * )
     *
     * @return void
     */


    public function registerAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $json = file_get_contents('php://input');

            // Converts it into a PHP object
            $postData = json_decode($json, true);

            try {
                //code...
                $responseData = $this->registerService->register($postData);
                if (!is_null($responseData)) {
                    $response->setStatusCode(201);
                    $jsonModel->setVariables([
                        "success" => true,
                        "data" => [
                            "fullname" => $responseData["fullname"],
                            "email" => $responseData["email"],
                        ],
                        "description" => "Successfully Created {$responseData['fullname']},  profile, please vist Email to confirm email"
                    ]);
                }
            } catch (\Throwable $th) {
                //throw $th;
                $jsonModel->setVariables([
                    "success" => false,
                    "description" => $th->getMessage(),
                    // "errors" => $
                ]);

                $response->setStatusCode(400);
            }
        }

        return $jsonModel;
    }

    /**
     * This API is used to verity users email
     * @OA\POST( path="/auth/api/verify", tags={"Authentication"}, description="Verify user Email",
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"code"},
     * @OA\Property(property="username", type="string", example="ezekiel_a@yahoo.com or 07089898989"),
     * 
     * 
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
    public function verifyAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $json = file_get_contents('php://input');
            $postData = json_decode($json, true);
            $inputFilter = new InputFilter();
            $inputFilter->setData($postData);
            $inputFilter->add([
                'name' => 'code',
                'required' => true,
                'allow_empty' => false,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Code is required'
                            )
                        )
                    )
                )
            ]);
            if ($inputFilter->isValid()) {
            } else {
                $jsonModel->setVariables([
                    "error" => "Validation",
                    "" => $inputFilter->getMessages()
                ]);
                $response = $this->getResponse();
                $response->setStatusCode(400);
            }
        }
        return $jsonModel;
    }

   


    /**
     * This action refreshes the token 
     * @OA\POST( path="/auth/api/refresh-token", tags={"Authentication"}, description="Verify user Email",
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"id_"},
     * @OA\Property(property="username", type="string", example="ezekiel_a@yahoo.com or 07089898989"),
     * 
     * 
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
    public function refreshTokenAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        if ($request->isPost()) {
            // retrieve cookie refresh token from header 
            // Verify Cooki from 
        }
        return $jsonModel;
    }


    public function resetPaswordAction()
    {
    }

    // /**
    //  * Verifies Email of the User 
    //  *
    //  * @return void
    //  */
    // public function verifyAction()
    // {
    //     $jsonModel = new JsonModel();
    //     return $jsonModel;
    // }


    public function forgotAction()
    {
    }


    public function revokeToken()
    {
    }


    public function logoutAction()
    {
        $jsonModel = new JsonModel();
        return $jsonModel;
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

    /**
     * Get register Service
     *
     * @return  RegisterService
     */
    public function getRegisterService()
    {
        return $this->registerService;
    }

    /**
     * Set register Service
     *
     * @param  RegisterService  $registerService  Register Service
     *
     * @return  self
     */
    public function setRegisterService(RegisterService $registerService)
    {
        $this->registerService = $registerService;

        return $this;
    }

    /**
     * Get api Athentication Service
     *
     * @return  ApiAuthenticateService
     */
    public function getApiAuthService()
    {
        return $this->apiAuthService;
    }

    /**
     * Set api Athentication Service
     *
     * @param  ApiAuthenticateService  $apiAuthService  Api Athentication Service
     *
     * @return  self
     */
    public function setApiAuthService(ApiAuthenticateService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;

        return $this;
    }
}
