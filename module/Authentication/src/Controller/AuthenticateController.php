<?php

namespace Authentication\Controller;

use Authentication\Entity\User;
use Laminas\Http\Response;
use Laminas\InputFilter\InputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\SessionManager;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class AuthenticateController extends AbstractActionController
{

    private  $authenticateService;

    private $em;

    private $loginForm;

    private $rabbitProducer;

    public function loginAction()
    {
        $viewModel = new ViewModel();

        $jsonModel = new JsonModel();

        $response = $this->getResponse();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new  InputFilter();
            $inputFilter->add(array(
                'name' => 'phoneOrEmail',
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
                                'isEmpty' => 'Phone Number or email is required'
                            )
                        )
                    )
                )
            ));

            $inputFilter->add(array(
                'name' => 'password',
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
                                'isEmpty' => 'Password is required'
                            )
                        )
                    )
                )
            ));
            $rememberme = filter_var($this->params()->fromPost('rememberme'), FILTER_VALIDATE_BOOLEAN);

            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();

                $authService = $this->authService;
                $adapter = $authService->getAdapter();
                $phoneOrEmail = $data["phoneOrEmail"];

                try {
                    $user = $this->entityManager->createQuery("SELECT u FROM CsnUser\Entity\User u WHERE u.email = '$phoneOrEmail' OR u.phoneNumber = '$phoneOrEmail'")->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);

                    // $user = $this->user->selectUserDQL($phoneOrEmail);
                    if (count($user) == 0) {
                        $response->setStatusCode(498);
                        $response->setReasonPhrase('Invalid token!');
                        return $jsonModel->setVariables([
                            "messages" => "The username or email is not valid!"
                        ]);
                    } else {
                        $user = $user[0];
                    }


                    if (!$user->getEmailConfirmed() == 1) {
                        $messages = $this->translatorHelper->translate('You are yet to confirm your account, please go to the registered email to confirm your account');
                        $response->setStatusCode(Response::STATUS_CODE_422);
                        return $jsonModel->setVariables([
                            "messages" => $messages
                        ]);
                    }
                    if ($user->getState()->getId() < 2) {
                        $messages = $this->translatorHelper->translate('Your username is disabled. Please contact an administrator.');
                        $response->setStatusCode(Response::STATUS_CODE_422);
                        return $jsonModel->setVariables([
                            "messages" => $messages
                        ]);
                    }

                    $adapter->setIdentity($user->getPhoneNumber());
                    $adapter->setCredential($data["password"]);

                    $authResult = $authService->authenticate();
                    // $class_methods = get_class_methods($adapter);
                    // echo "<pre>";print_r($class_methods);exit;

                    if ($authResult->isValid()) {
                        $identity = $authResult->getIdentity();
                        $authService->getStorage()->write($identity);

                        // Last Login Date
                        $this->lastLogin($this->identity());
                        $userEntity = $this->identity();
                        if ($rememberme) {
                            $time = 1209600; // 14 days (1209600/3600 = 336 hours => 336/24 = 14 days)
                            $sessionManager = new SessionManager();
                            $sessionManager->rememberMe($time);
                        }


                        /**
                         * At this region check if the user varible isProfiled is true
                         * If it is true make sure continue with the login
                         * If it is false branch into the condition get the user role mand seed it to
                         * the userProfile Sertvice
                         * to display the required form to fill the profile
                         * if required redirect to the copletinfg profile Page
                         */
                        // $redirect = $fullUrl . "/" . UserService::routeManager($userEntity);

                        $response->setStatusCode(201);
                        $jsonModel->setVariables([
                            "redirect" => $redirect
                        ]);
                        $jsonModel->setVariables([]);
                        return $jsonModel;
                        // return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
                    } else {
                        $messages = $this->translatorHelper->translate('Invalid Credentials');
                        $response->setStatusCode(Response::STATUS_CODE_422);
                        return $jsonModel->setVariables([
                            "messages" => $messages
                        ]);
                    }

                    foreach ($authResult->getMessages() as $message) {
                        $messages .= "$message\n";
                    }
                } catch (\Exception $e) {
                    // echo "Something went wrong";
                    // return $this->errorView->createErrorView($this->translatorHelper->translate('Something went wrong during login! Please, try again later.'), $e, $this->options->getDisplayExceptions(), $this->options);
                    // ->getNavMenu();
                    $response->setStatusCode(Response::STATUS_CODE_400);
                    return $jsonModel->setVariables([
                        "messages" => $this->translatorHelper->translate('Something went wrong during login! Please, try again later.'),
                        "data" => $e->getTrace(),
                    ]);
                }
            } else {
                $response->setStatusCode(498);
                $response->setReasonPhrase('Invalid token!');
                return $jsonModel->setVariables([
                    "messages" => "The username or email is not valid!"
                ]);
            }
        }

        // $response->setStatusCode(Response::STATUS_CODE_500);
        // $jsonModel->setVariables([
        //     'messages' => "Some thing went wrong"
        // ]);
        $this->layout()->setTemplate("login-layout");

        return  $viewModel;
    }

    public function registerAction()
    {
        $response = $this->getResponse();
        // $viewModel = new ViewModel();
        // $jsonModel = new JsonModel();
        // $user = new User();
        // // $form = $this->registerForm->createUserForm($user, 'SignUp');
        // $request = $this->getRequest();
        // if ($request->isPost()) {

        //     $post = $request->getPost()->toArray();

        //     $inputFilter = new InputFilter();
        //     $inputFilter->add(array(
        //         'name' => 'phoneNumber',
        //         'required' => true,
        //         'allow_empty' => false,
        //         'filters' => array(
        //             array(
        //                 'name' => 'StripTags'
        //             ),
        //             array(
        //                 'name' => 'StringTrim'
        //             )
        //         ),
        //         'validators' => array(
        //             array(
        //                 'name' => 'NotEmpty',
        //                 'options' => array(
        //                     'messages' => array(
        //                         'isEmpty' => 'Phone number  is required'
        //                     )
        //                 )
        //             )
        //         )
        //     ));

        //     $inputFilter->add(array(
        //         'name' => 'email',
        //         'required' => true,
        //         'allow_empty' => false,
        //         'filters' => array(
        //             array(
        //                 'name' => 'StripTags'
        //             ),
        //             array(
        //                 'name' => 'StringTrim'
        //             )
        //         ),
        //         'validators' => array(
        //             array(
        //                 'name' => 'NotEmpty',
        //                 'options' => array(
        //                     'messages' => array(
        //                         'isEmpty' => 'Email is required'
        //                     )
        //                 )
        //             )
        //         )
        //     ));

        //     $inputFilter->add(array(
        //         'name' => 'fullname',
        //         'required' => true,
        //         'allow_empty' => false,
        //         'filters' => array(
        //             array(
        //                 'name' => 'StripTags'
        //             ),
        //             array(
        //                 'name' => 'StringTrim'
        //             )
        //         ),
        //         'validators' => array(
        //             array(
        //                 'name' => 'NotEmpty',
        //                 'options' => array(
        //                     'messages' => array(
        //                         'isEmpty' => 'Your Full Name is required'
        //                     )
        //                 )
        //             )
        //         )
        //     ));

        //     $inputFilter->add(array(
        //         'name' => 'password',
        //         'required' => true,
        //         'allow_empty' => false,
        //         'filters' => array(
        //             array(
        //                 'name' => 'StripTags'
        //             ),
        //             array(
        //                 'name' => 'StringTrim'
        //             )
        //         ),
        //         'validators' => array(
        //             array(
        //                 'name' => 'NotEmpty',
        //                 'options' => array(
        //                     'messages' => array(
        //                         'isEmpty' => 'Password is required'
        //                     )
        //                 )
        //             )
        //         )
        //     ));
        //     // $form->setValidationGroup('username', 'email', 'password', 'passwordVerify', 'question', 'answer', 'csrf');
        //     // $post = $request->getPost()->toArray();
        //     $inputFilter->setData($post);

        //     if ($inputFilter->isValid()) {

        //         $data = $inputFilter->getValues();
        //         $entityManager = $this->entityManager;
        //         $user->setState($entityManager->find('CsnUser\Entity\State', UserService::USER_STATE_ENABLED));
        //         $user->setUsername(str_replace("-", "", $data["phoneNumber"]));
        //         $user->setPassword(UserService::encryptPassword($data["password"]));
        //         $user->setRegistrationToken(md5(uniqid(mt_rand(), true)));
        //         $user->setUid(UserService::createUserUid());
        //         $user->setFullName($data["fullname"]);
        //         $user->setEmail($data['email']);
        //         $user->setRole($entityManager->find("CsnUser\Entity\Role", UserService::USER_ROLE_CUSTOMER));
        //         $user->setRegistrationDate(new \DateTime());
        //         $user->setUpdatedOn(new \DateTime());
        //         $user->setEmailConfirmed(false);
        //         // var_dump("LLLa");

        //         try {
        //             $fullLink = $this->url()->fromRoute('user-register', array(
        //                 'action' => 'confirm-email',
        //                 'id' => $user->getRegistrationToken()
        //             ), array(
        //                 'force_canonical' => true
        //             ));

        //             $logo = $this->url()->fromRoute('home', array(), array(
        //                 'force_canonical' => true
        //             )) . "assets/img/logo.png";

        //             // $mailer = $this->mail;

        //             $var = [
        //                 'logo' => $logo,
        //                 'confirmLink' => $fullLink
        //             ];

        //             $template['template'] = "email-app-user-registration";
        //             $template['var'] = $var;

        //             $messagePointer['to'] = $user->getEmail();
        //             $messagePointer['fromName'] = "BAU CARS";
        //             $messagePointer['subject'] = "BAU CARS: Confirm Email";

        //             $entityManager->persist($user);
        //             $entityManager->flush();


        //             $response->setStatusCode(Response::STATUS_CODE_201);



        //             $this->generalService->sendMails($messagePointer, $template);
        //             return $jsonModel;
        //         } catch (\Exception $e) {
        //             $response->setStatusCode(Response::STATUS_CODE_400);
        //             $jsonModel->setVariables([
        //                 "messages" => "Something went wrong, please try again later"
        //             ]);
        //             return $jsonModel;
        //             // retguter an error log report
        //             // return $this->errorView->createErrorView('Something went wrong when trying to send activation email! Please, try again later.', $e, $this->options->getDisplayExceptions());
        //             // $this->options->getNavMenu()
        //         }
        //     }
        // } else {
        //     $response->setStatusCode(Response::STATUS_CODE_422);
        //     $jsonModel->setVariables([
        //         "messages" => $inputFilter->getMessages()
        //     ]);
        // }

        // return $viewModel;
    }

    /**
     * used to reset password from a web View 
     *
     * @return void
     */
    public function forgotPasswordAction()
    {
        $viewModel = new ViewModel();
        $this->layout()->setTemplate("login-layout");
        return $viewModel;
    }

    public function confirmEmailAction()
    {
        // $token = $this->params()->fromRoute('id');

        // try {
        //     $entityManager = $this->entityManager;
        //     if ($token !== '' && $user = $entityManager->getRepository('CsnUser\Entity\User')->findOneBy(array(
        //         'registrationToken' => $token
        //     ))) {
        //         if ($user->getEmailConfirmed() == TRUE) {
        //             $this->flashmessenger()->addErrorMessage("This email has been confirmed already");
        //             $this->redirect()->toRoute("login");
        //         }
        //         $user->setRegistrationToken(md5(uniqid(mt_rand(), true)));
        //         $user->setState($entityManager->find('CsnUser\Entity\State', UserService::USER_STATE_ENABLED));
        //         $user->setEmailConfirmed(1);
        //         $entityManager->persist($user);
        //         $entityManager->flush();

        //         $this->flashmessenger()->addSuccessMessage("Email successfully confirmed and registration completed");
        //         $this->redirect()->toRoute("user-index");
        //         // $viewModel = new ViewModel(array(
        //         // 'navMenu' => $this->options->getNavMenu()
        //         // ));

        //         // $viewModel->setTemplate('csn-user/registration/confirm-email-success');
        //         // return $viewModel;
        //         return $this;
        //     } else {
        //         $this->flashmessenger()->addErrorMessage("There was a problem consfirming your email");
        //         return $this->redirect()->toRoute('user-index', array(
        //             'action' => 'login'
        //         ));
        //     }
        // } catch (\Exception $e) {
        //     // return $this->getServiceLocator()->get('csnuser_error_view')->createErrorView(
        //     // $this->getTranslatorHelper()->translate('Something went wrong during the activation of your account! Please, try again later.'),
        //     // $e,
        //     // $this->options->getDisplayExceptions(),
        //     // $this->options->getNavMenu()
        //     // );
        // }
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

    /**
     * Get the value of rabbitProducer
     */
    public function getRabbitProducer()
    {
        return $this->rabbitProducer;
    }

    /**
     * Set the value of rabbitProducer
     *
     * @return  self
     */
    public function setRabbitProducer($rabbitProducer)
    {
        $this->rabbitProducer = $rabbitProducer;

        return $this;
    }
}
