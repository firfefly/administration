<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Brands;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\BrandType;
use Symfony\Component\HttpFoundation\Session\Session;

class BrandsController extends Controller
{
    /**
    * @Route("/", name="index")
    */
    public function SelectABrandAction(Request $request)
    {
        $session = new Session();

        $form = $this->createForm(BrandType::class, null, array(
                ));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $choosenBrand = ($form->getData()['brands']);
            $brand = $this->getDoctrine()
                    ->getManager('default')
                    ->getRepository(Brands::class)
                    ->find($choosenBrand);
            $session->set('choosenBrand', $brand);
            
            return $this->render('Templates/Index/index.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        return $this->render('Templates/Index/index.html.twig', array(
                'form' => $form->createView(),
            ));

    }
}