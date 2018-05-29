<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Departments;
use AppBundle\Entity\Agencies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\AgencyType;
use Symfony\Component\HttpFoundation\Session\Session;

class AgenciesController extends Controller {

    /**
     * @Route("/agencies/", name="agencies")
     */
    public function displayAllAgenciesAction() {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        $agencies = $this->getDoctrine()
                ->getManager($brand->getName())
                ->getRepository(Agencies::class)
                ->findAll();

        return $this->render('Templates/Agencies/agenciesManagement.html.twig', array(
                    'agenciesList' => $agencies,
        ));
    }

    /**
     * @Route("/agencies/agencyDetails/{agencyIdSlug}", name="agencyDetails")
     */
    public function agencyDetailsAction(Request $request, $agencyIdSlug) {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        if ((int) $agencyIdSlug > 0) {
            $agency = $this->getDoctrine()
                    ->getManager($brand->getName())
                    ->getRepository(Agencies::class)
                    ->find($agencyIdSlug);
        } else {
            $agency = new Agencies();
        }

        $departmentsList = $this->getDoctrine()
                ->getManager($brand->getName())
                ->getRepository(Departments::class)
                ->findBy(array('active' => '1'));

        $retrieveDepartmentsIdAndName = [];

        $retrieveDepartmentsIdAndName[''] = ' ';
        foreach ($departmentsList as $department) {
            $retrieveDepartmentsIdAndName[$department->getName() . '(' . $department->getCode() . ')'] = $department->getCode();
        }

        $selected = ($agency->getDepartmentCode() === null) ? ' ' : $agency->getDepartmentCode();

        $form = $this->createForm(AgencyType::class, $agency, array(
            'retrieveDepartmentsIdAndName' => $retrieveDepartmentsIdAndName,
            'selected' => $selected,
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agency = $form->getData();
            $em = $this->getDoctrine()->getManager($brand->getName());
            $em->persist($agency);
            $em->flush();
            return $this->redirectToRoute('agencies');
        }

        return $this->render('Templates/Agencies/agencyDetails.html.twig', array(
                    'form' => $form->createView(),
                    'agencyIdSlug' => $agencyIdSlug,
                    'agency' => $agency,
        ));
    }

    /**
     * @Route("/agencies/agencyRemove/{agencyId}", name="agencyRemove")
     */
    public function removeAgenciesAction($agencyId) {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()
                ->getManager($brand->getName());

        $agency = $em->getRepository(Agencies::class)
                ->find($agencyId);

        $em->remove($agency);
        $em->flush();

        return $this->redirectToRoute('agencies');
    }

}
