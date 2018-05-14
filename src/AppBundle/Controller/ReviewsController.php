<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Reviews;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\ReviewType;
use AppBundle\Services\ImageUpload;

class ReviewsController extends Controller
{
    /**
    * @Route("/reviews/", name="reviews")
    */
    public function displayReviewsAction(Request $request)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        $reviewsList = $this->getDoctrine()
                        ->getManager($brand->getName())
                        ->getRepository(Reviews::class)
                        ->findAll();

        return $this->render('Templates/Reviews/reviewsManagement.html.twig', array(
            'reviewsList' => $reviewsList,
            'brand' => $brand,
        ));
    }

    /**
    * @Route("/reviewDetails/{reviewIdSlug}", name="reviewDetails")
    */
    public function reviewDetailsAction(Request $request, $reviewIdSlug, ImageUpload $fileUploader)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        if ((int) $reviewIdSlug > 0) {
        $review = $this->getDoctrine()
                        ->getManager($brand->getName())
                        ->getRepository(Reviews::class)
                        ->find($reviewIdSlug);
        } else {
            $review = new Reviews();
        }

        $form = $this->createForm(ReviewType::class, $review);

        $image1 = $review->getImage1();
        $image2 = $review->getImage2();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $review = $form->getData();
            $file1 = $review->getImage1();
            $file2 = $review->getImage2();

            if($file1 === null) {
                $review->setImage1($image1);
            } else {
                $fileName1 = $fileUploader->upload($brand, $file1);
                $review->setImage1($fileName1);
            }

            if($file2 === null) {
                $review->setImage2($image2);
            } else {
                $fileName2 = $fileUploader->upload($brand, $file2);
                $review->setImage2($fileName2);
            }

            $em = $this->getDoctrine()->getManager($brand->getName());
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('reviews');

        }

        return $this->render('Templates/Reviews/reviewDetails.html.twig', array(
            'form' => $form->createView(),
            'brand' => $brand,
        ));
    }

    /**
    * @Route("/reviewRemove/{reviewId}", name="reviewRemove")
    */
    public function removeNewsAction(Request $request, $reviewId)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()
            ->getManager($brand->getName());

        $review = $em->getRepository(Reviews::class)
            ->find($reviewId);

        $em->remove($review);
        $em->flush();

        return $this->redirectToRoute('reviews');
    }
}