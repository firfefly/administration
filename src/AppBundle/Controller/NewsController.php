<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\News;
use AppBundle\Entity\Departments;
use AppBundle\Services\ImageUpload;
use AppBundle\Form\NewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class NewsController extends Controller
{
    /**
    * @Route("/news/", name="news")
    */
    public function displayAllNewsAction(Request $request)
    {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        $news = $this->getDoctrine()
                    ->getManager($brand->getName())
                    ->getRepository(News::class)
                    ->findAll();

        return $this->render('Templates/News/newsManagement.html.twig', array(
            'newsList' => $news,
        ));
    }

    /**
    * @Route("/newDetails/{newIdSlug}", name="newDetails")
    */
    public function newDetailsAction(Request $request, $newIdSlug)
    {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        if ((int) $newIdSlug > 0) {
            $new = $this->getDoctrine()
                    ->getManager($brand->getName())
                    ->getRepository(News::class)
                    ->find($newIdSlug);
        } else {
            $new = new News();
        }

        $departmentsList = $this->getDoctrine()
                    ->getManager($brand->getName())
                    ->getRepository(Departments::class)
                    ->findBy(array('active' => '1'));

        $retrieveDepartmentsIdAndName = [];

        foreach($departmentsList as $department) {
            $retrieveDepartmentsIdAndName[$department->getName() . '(' . $department->getCode() . ')'] = $department->getCode();
        }

        $form = $this->createForm(NewType::class, $new, array(
               'departmentsIdAndName'   => $retrieveDepartmentsIdAndName
                ));

        $lastImage = $new->getImage();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $new = $form->getData();
            $file = $new->getImage();

            if($file === null) {
                if($lastImage === null) {
                    $errors = "Veuillez choisir une image !";
                    return $this->render("Templates/News/newDetails.html.twig", array(
                        'form' => $form->createView(),
                        'new' => $new,
                        'errors' => $errors,
                    ));
                } else {
                    $new->setImage($lastImage);
                }

            } else {
                $dir = new ImageUpload('/img/news/');
                $fileName = $dir->upload($brand, $file);
                $new->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager($brand->getName());
            $em->persist($new);
            $em->flush();
            return $this->redirectToRoute('news');
        }

        return $this->render('Templates/News/newDetails.html.twig', array(
            'form' => $form->createView(),
            'new' => $new,
s        ));
    }


    /**
    * @Route("/newRemove/{newId}", name="newRemove")
    */
    public function removeNewsAction(Request $request, $newId)
    {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()
            ->getManager($brand->getName());

        $new = $em->getRepository(News::class)
            ->find($newId);

        $em->remove($new);
        $em->flush();

        return $this->redirectToRoute('news');
    }


}