<?php

namespace App\Controller;

use App\AutoMapping;
use App\Form\MapPlaceForm;
use App\Request\MapPlaceAutoCompleteRequest;
use App\Service\UserService;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends BaseController
{
    private $autoMapping;
    private $userService;

    public function __construct(SerializerInterface $serializer, AutoMapping $autoMapping, UserService $userService)
    {
        parent::__construct($serializer);
        $this->autoMapping = $autoMapping;
        $this->userService = $userService;
    }

    /**
     * @Route("mytestmap", name="getMyTestMap")
     */
    public function getMapPlace(Request $request)
    {
        $form = $this->createForm(MapPlaceForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $request = $this->autoMapping->map(stdClass::class, MapPlaceAutoCompleteRequest::class, (object)$form->getData());

            $response = $this->userService->getMapPlace($request);

            //dd($response['status']);

            return $this->render('result/new.html.twig',[
                'status'=>$response['status']]);

        }

        return $this->render('map_place/new.html.twig',[
            'mapPlaceForm'=>$form->createView(),]
        );

//        $data = json_decode($request->getContent(), true);
//
//        $request = $this->autoMapping->map(stdClass::class, MapPlaceAutoCompleteRequest::class, (object)$data);
//
//        $response = $this->userService->getMapPlace($request);
//
//        return $this->response($response,self::FETCH);
    }
}
