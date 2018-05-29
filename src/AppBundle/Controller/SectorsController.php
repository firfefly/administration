<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Sectors;
use AppBundle\Entity\Agencies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\SectorType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Filesystem\Filesystem;

class SectorsController extends Controller {

    /**
     * @Route("/sectors/", name="sectors")
     */
    public function displayAllSectorsAction() {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }
        $fileSystem = new Filesystem();
        $directory = '../../' . $brand->getDir() . '/import/files/';

        $sectors = $this->getDoctrine()
                ->getManager($brand->getName())
                ->getRepository(Sectors::class)
                ->findAll();

        $agenciesList = $this->getDoctrine()
                ->getManager($brand->getName())
                ->getRepository(Agencies::class)
                ->findAll();

        $retrieveAgenciesNameById = [];
        $retrieveAgenciesZipFile = [];

        foreach ($agenciesList as $agency) {
            $retrieveAgenciesNameById[$agency->getId()] = $agency->getName();
        }

        foreach ($sectors as $sector) {
            if ($fileSystem->exists($directory . $sector->getCode() . '.zip') === true) {
                $retrieveAgenciesZipFile[$sector->getId()] = 'true';
            } else {
                $retrieveAgenciesZipFile[$sector->getId()] = 'false';
            }
        }

        return $this->render('Templates/Sectors/sectorsManagement.html.twig', array(
                    'sectorsList' => $sectors,
                    'retrieveAgenciesNameById' => $retrieveAgenciesNameById,
                    'retrieveAgenciesZipFile' => $retrieveAgenciesZipFile,
        ));
    }

    /**
     * @Route("/sectors/sectorDetails/{sectorIdSlug}", name="sectorDetails")
     */
    public function sectorDetailsAction(Request $request, $sectorIdSlug) {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        if ((int) $sectorIdSlug > 0) {
            $sector = $this->getDoctrine()
                    ->getManager($brand->getName())
                    ->getRepository(Sectors::class)
                    ->find($sectorIdSlug);
        } else {
            $sector = new Sectors();
        }

        $agenciesList = $this->getDoctrine()
                ->getManager($brand->getName())
                ->getRepository(Agencies::class)
                ->findAll();

        $retrieveAgenciesIdAndName = [];
        $retrieveAgenciesIdAndName[''] = ' ';
        foreach ($agenciesList as $agency) {
            $retrieveAgenciesIdAndName[$agency->getName() . '(' . $agency->getZipCode() . ')'] = $agency->getId();
        }

        $selected = ($sector->getAgencyId() === null) ? ' ' : (string) $sector->getAgencyId();

        $form = $this->createForm(SectorType::class, $sector, array(
            'retrieveAgenciesIdAndName' => $retrieveAgenciesIdAndName,
            'selected' => $selected,
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sector = $form->getData();
            $em = $this->getDoctrine()->getManager($brand->getName());
            $em->persist($sector);
            $em->flush();
            return $this->redirectToRoute('sectors');
        }

        return $this->render('Templates/Sectors/sectorDetails.html.twig', array(
                    'form' => $form->createView(),
                    'sectorIdSlug' => $sectorIdSlug,
                    'sector' => $sector,
        ));
    }

    /**
     * @Route("/sectors/sectorRemove/{sectorId}", name="sectorRemove")
     */
    public function removeSectorAction($sectorId) {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()
                ->getManager($brand->getName());

        $sector = $em->getRepository(Sectors::class)
                ->find($sectorId);

        $em->remove($sector);
        $em->flush();

        return $this->redirectToRoute('sectors');
    }

}
