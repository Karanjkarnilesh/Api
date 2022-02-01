<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class BaseController extends AbstractController
{
    protected $serializer;
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function responsiveJson($responseobj)
    {

        $responseobj = $this->serializer->serialize($responseobj, 'json');
        $response = new Response($responseobj);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
