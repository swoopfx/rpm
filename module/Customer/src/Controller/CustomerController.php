<?php

namespace Customer\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use General\Entity\WasteRequestType;
use Laminas\View\Model\ViewModel;

class CustomerController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

     /**
     *
     * This function post a series of data for the customer to make a request for pick up or drop of waste
     *
     * @OA\POST( path="/customer/api/request-waste-collection", tags={"Customer"}, description="Used to get Statistics inforamtion about the package about to be delivered this information is only required to be displayed only, once this is successfully acquired, a call to flutterwave payment gateway should be made, the",
     *
     * @OA\RequestBody(
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(required={"destinationPlaceId", "pickUpPlaceId", "destinationAddress", "pickAddress", "pickupLong", "pickupLat", "destinationLat", "destinationLong", "quantity", "iten_name"},
     * @OA\Property(property="destinationPlaceId", type="string", example="EjFJbnQnbCBBaXJwb3J0IFJkLCBNYWZvbHVrdSBPc2hvZGksIExhZ29zLCBOaWdlcmlhIi4qLAoUChIJjagx-h6OOxARwyZNkX_GTysSFAoSCZk5KvookjsQEfChu91LMqjX", description="Google Place id (Unique) of the Destination"),
     * @OA\Property(property="pickUpPlaceId", type="string", example="ChIJS9Q72lL0OxARKJ3cGrQfM0c", description="Google Place id (Unique) of the pickup"),
     * @OA\Property(property="pickAddress", type="string", example="Kola Oyewo street surulere, lagos Nigeria", description="Pick up Address"),
     * @OA\Property(property="destinationAddress", type="string", example="Fatai Abduwahid street Ijegun, lagos Nigeria", description="Destination Address"),
     * @OA\Property(property="pickupLat", type="string", example="3.4723495", description="The latitude of the pickup address"),
     * @OA\Property(property="pickupLong", type="string", example="3.4723495", description="The longitude of the pickup address"),
     * @OA\Property(property="destinationLat", type="string", example="3.4723495", description="The latitude of the destination address "),
     * @OA\Property(property="destinationLong", type="string", example="3.4723495", description="The longitude of the destination address "),
     * @OA\Property(property="quantity", type="integer", example=2, description="The qauntity of the item"),
     * @OA\Property(property="item_name", type="string", example="Bag of oranges", description="Identifier description of tha package"),
     * @OA\Property(property="service_type", type="integer", example=10, description="This is an id referenced from the logistics/logistics/service-type url"),
     * @OA\Property(property="delivery_type", type="integer", example=10, description="This is an id referenced from the logistics/logistics/delivery-type url"),
     * @OA\Property(property="note", type="string", example="I want this package delivered before 10am ", description="Additional information for the package"),
     *
     * )
     * ),
     * ),
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Not permitted"),
     *
     * security={{"bearerAuth":{}}}
     *
     * )
     *
     * requires
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function requestWasteCollectionAction()
    {
        $jsonModel = new JsonModel();
        // return ne
    }

    public function getRequestWasteCollectionAction(){
        $jsonModel = new JsonModel();
        // return
    }

   

    /**
     * @OA\GET( path="/customer/api/get-waste-request-type", tags={"Customer"}, description="Retrieve waste request Type",
     * @OA\Response(response="200", description="Success"),
     * @OA\Response(response="401", description="Not Authorized"),
     * @OA\Response(response="403", description="Error"),
     * security={{"bearerAuth":{}}}
     * )
     *
     * @return \Laminas\View\Model\JsonModel
     */
    public function getWasteRequestTypeAction()
    {
        $jsonModel = new JsonModel();
        $data = $this->entityManager->getRepository(WasteRequestType::class)->createQueryBuilder("a")
            ->select(["a"])
            ->getQuery()->getArrayResult();
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    // public function 

    /**
     * Get the value of entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set the value of entityManager
     *
     * @return  self
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
