<?php

namespace App\Controller;

use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends AbstractController
{
    /**
     * @Route("/image", name="image")
     */
    public function action(SerializerInterface $serializer): Response
    {
        $image = new Image();
        $image->setUrl("http://google.com");
        $data = $serializer->serialize($image, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    /**
     * @Route("/test", name ="test", methods ="GET")
     */

    public function ajouter( Request $request, SerializerInterface $serializer){
        $data = $request->getContent();

        $image = $serializer->deserialize($data, Image::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($image);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }
}
