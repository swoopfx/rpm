<?php

namespace Application\Controller;

/**
 *
 * @OA\Info(title="IMAPP2.0 documentation", version="2.0", description="This API is used for the implemetation of BAUCARS mobile app ")
 * @OA\SecurityScheme(
 * type="http",
 * description="use jwt/api/login to get jwt key",
 * name="Authorization",
 * in="header",
 * scheme="bearer",
 * bearerFormat="JWT",
 * securityScheme="bearerAuth"
 * )
 *
 *
 * @author mac
 *        
 */


use Laminas\Mvc\Controller\AbstractActionController;

class ApiController extends AbstractActionController{

}