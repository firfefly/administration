<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Departments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\DepartmentSelectType;
use AppBundle\Form\DepartmentEditType;
use AppBundle\Services\ImageUpload;

class DepartmentsController extends Controller
{
    /**
    * @Route("/departments/", name="departments")
    */
    public function selectDepartmentAction(Request $request)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        $activeDepartmentsList = $this->getDoctrine()
                                ->getManager($brand->getName())
                                ->getRepository(Departments::class)
                                ->findBy(array('active' => '1'), array('code' => 'ASC'));

        $retrieveActiveDepartmentsNameAndCode = [];

        foreach($activeDepartmentsList as $department) {
            $retrieveActiveDepartmentsNameAndCode[$department->getName() . '(' . $department->getCode() . ')'] = $department->getCode();
        }

        $inactiveDepartmentsList = $this->getDoctrine()
                                    ->getManager($brand->getName())
                                    ->getRepository(Departments::class)
                                    ->findBy(array('active' => '0'),array('code' => 'ASC'));

        $retrieveInactiveDepartmentsNameAndCode = [];

        foreach($inactiveDepartmentsList as $department) {
            $retrieveInactiveDepartmentsNameAndCode[$department->getName() . '(' . $department->getCode() . ')'] = $department->getCode();
        }

        $form = $this->createForm(DepartmentSelectType::class, null, array(
                'retrieveActiveDepartmentsNameAndCode'   => $retrieveActiveDepartmentsNameAndCode,
                'retrieveInactiveDepartmentsNameAndCode'   => $retrieveInactiveDepartmentsNameAndCode,
                ));

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $selectedDepartmentCode = $form->getData()['code'];
            $department = $this->getDoctrine()
                        ->getManager($brand->getName())
                        ->getRepository(Departments::class)
                        ->findOneByCode($selectedDepartmentCode);

            return $this->redirectToRoute('departmentDetails',array('codeDpt' => $selectedDepartmentCode));
        }

        return $this->render('Templates/Departments/departmentsManagement.html.twig', array(
            'form' => $form->createView(),
            'brand' => $brand,
        ));
    }


    /**
    * @Route("/departmentDetails/{codeDpt}", name="departmentDetails")
    */
    public function departmentDetailsAction(Request $request, $codeDpt)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        $department = $this->getDoctrine()
                        ->getManager($brand->getName())
                        ->getRepository(Departments::class)
                        ->findOneByCode($codeDpt);


        $form = $this->createForm(DepartmentEditType::class, $department);

        $lastImage = $department->getImage();

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $department = $form->getData();
            $file = $department->getImage();

            if ($file !== null) {
                $dir = new ImageUpload('/img/departments/');
                $fileName = $dir->upload($brand, $file);
                $department->setImage($fileName);
            } elseif ($file === null && $lastImage !== null) {
                $department->setImage($lastImage);
            }

            $em = $this->getDoctrine()->getManager($brand->getName());
            $em->persist($department);
            $em->flush();
            return $this->redirectToRoute('departments');
        }

        return $this->render('Templates/Departments/departmentDetails.html.twig', array(
            'form' => $form->createView(),
            'department' => $department,
            'brand' => $brand,
        ));


    }



}