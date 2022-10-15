<?php

namespace Authorization;

use Authorization\Acl\Acl;
use Exception;
use Laminas\Mvc\MvcEvent;

class Module {

    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }


    public function onBootstrap(MvcEvent $e){
        $application = $e->getApplication();
        $eventManager = $application->getEventManager();
        $eventManager->attach("route", array($this, 'onRoute'), -100);
    }

    public function onRoute(MvcEvent $e){
        $application = $e->getApplication();
        $routeMatch = $e->getRouteMatch();
        $sm = $application->getServiceManager(); // service Manager

        $auth = $sm->get("Laminas\Authentication\AuthenticationService");
        /**
         * @var Acl
         */
        $acl = $sm->get("Authorization\Acl\Acl");

        $role = Acl::DEFAULT_ROLE;

        if ($auth->hasIdentity()) {
            $user = $auth->getIdentity();
            $role = $user->getRole()->getName();
        }


        $controller = $routeMatch->getParam("controller");
        $action = $routeMatch->getParam("action");


        // if(!$acl->hasResource($controller)){
        //     throw new \Exception("Resource {$controller} not found");
        // }

        if($acl->isAllowed($role, $controller, $action)){
            $response = $e->getResponse();
            $config = $sm->get("config");

            $redirect_route = $config["acl"]["redirect_rou"];
            if(!empty($redirect_route)){
                $url = $e->getRouter()->assemble($redirect_route["params"], $redirect_route["options"]);
                // $response->getHeaders()->addHeaderLine("Location", $url);
                $response->setRedirect($url, 302);

                $response->setStatusCode(302);
                // $response->sendHeaders();
                return $response;

            }else{

                $response->setStatusCode(403);
                $response->setContent('
                    <html>
                        <head>
                            <title>403 Forbidden</title>
                        </head>
                        <body>
                            <h1>403 Forbidden</h1>
                        </body>
                    </html>'
                );
                return $response;
            }

            
        }
    }
    
}