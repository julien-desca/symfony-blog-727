<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController {

    /**
     * @Route("/test", name="test_route")
     */
    public function test(){
        return new Response("Hello world");
    }

    /**
     * @Route("/test/{id}", name="test_route_2", requirements={"id"="\d+"})
     */
    public function test2(int $id){
        return new Response("Hello test n° $id");
    }


    /**
     * @Route("/test/test3", name="test_route_3")
     */
    public function test3(){
        return new Response("Ceci est la page test/test3");
    }

    /**
     * @Route("/test/twig", name="test_twig")
     */
    public function testTwig(){
        $person = [
            "nom" => "Julien D.",
            "age" => 32,
            "telephone" => ["06.00.00.00.00", "03.20.00.00.00"]
        ];

        return $this->render("test.html.twig", ["person" => $person]);
    }

}