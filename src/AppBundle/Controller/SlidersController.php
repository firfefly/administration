<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Sliders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\SliderType;
use AppBundle\Services\ImageUpload;

class SlidersController extends Controller
{
    /**
    * @Route("/sliders/", name="sliders")
    */
    public function displaySlidersAction(Request $request)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        $slidersList = $this->getDoctrine()
                        ->getManager($brand->getName())
                        ->getRepository(Sliders::class)
                        ->findAll();

        return $this->render('Templates/Sliders/slidersManagement.html.twig', array(
            'slidersList' => $slidersList,
            'brand' => $brand,
        ));
    }

    /**
    * @Route("/sliderDetails/{sliderIdSlug}", name="sliderDetails")
    */
    public function sliderDetailsAction(Request $request, $sliderIdSlug, ImageUpload $fileUploader)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        if ((int) $sliderIdSlug > 0) {
            $slider = $this->getDoctrine()
                        ->getManager($brand->getName())
                        ->getRepository(Sliders::class)
                        ->find($sliderIdSlug);
        } else {
            $slider = new Sliders();
        }

        $form = $this->createForm(SliderType::class, $slider);

        $image = $slider->getImage();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $slider = $form->getData();
            $file = $slider->getImage();

            if($file === null) {
                $slider->setImage($image);
            } else {
                $dir = new ImageUpload('/img/slider/');
                $fileName = $dir->upload($brand, $file);
                $slider->setImage($fileName);
            }
            $em = $this->getDoctrine()->getManager($brand->getName());
            $em->persist($slider);
            $em->flush();

            return $this->redirectToRoute('sliders');

        }

        return $this->render('Templates/Sliders/sliderDetails.html.twig', array(
            'form' => $form->createView(),
            'brand' => $brand,
        ));
    }

    /**
    * @Route("/sliderRemove/{sliderId}", name="sliderRemove")
    */
    public function removeSlidersAction(Request $request, $sliderId)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()
            ->getManager($brand->getName());

        $slider = $em->getRepository(Sliders::class)
            ->find($sliderId);

        $em->remove($slider);
        $em->flush();

        return $this->redirectToRoute('sliders');
    }
}