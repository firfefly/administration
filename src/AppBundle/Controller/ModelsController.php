<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Models;
use AppBundle\Form\ModelType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use AppBundle\Services\ImageUpload;
use Symfony\Component\HttpFoundation\Session\Session;

class ModelsController extends Controller {

    /**
     * @Route("/models/", name="models")
     */
    public function displayModelsAction(Request $request) {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        $modelsList = $this->getDoctrine()
                ->getManager($brand->getName())
                ->getRepository(Models::class)
                ->findAll();

        return $this->render('Templates/Models/modelsManagement.html.twig', array(
                    'modelsList' => $modelsList,
        ));
    }

    /**
     * @Route("/models/modelDetails/{modelIdSlug}", name="modelDetails")
     */
    public function modelDetailsAction(Request $request, $modelIdSlug) {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        if ((int) $modelIdSlug > 0) {
            $model = $this->getDoctrine()
                    ->getManager($brand->getName())
                    ->getRepository(Models::class)
                    ->find($modelIdSlug);
        } else {
            $model = new Models();
        }

        $form = $this->createForm(ModelType::class, $model);
        $previousModelTitle = strtolower($model->getTitle());

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $fileSystem = new Filesystem();
            $model = $form->getData();
            $file = $form['imageindir']->getData();


            $newModelTitle = strtolower($model->getTitle());
            $newDir = '../../' . $brand->getDir() . '/img/models/' . $newModelTitle . '/';
            $previousDir = '../../' . $brand->getDir() . '/img/models/' . $previousModelTitle . '/';
            $isEmpty = FALSE;
            $exists = $fileSystem->exists($newDir);

            if ($previousModelTitle !== $newModelTitle) {
                if ($exists === true) {
                    return $this->render('Templates/Models/modelDetails.html.twig', array(
                                'form' => $form->createView(),
                                'error' => 'Ce dossier existe déjà. Changez le titre',
                    ));
                } else {
                    if ($previousModelTitle !== '') {
                        $isEmpty = TRUE;
                        $fileSystem->mkdir($newDir, 0777);
                        $this->moveFiles($previousDir, $newDir);
                        $fileSystem->remove($previousDir);
                    } else {
                        $fileSystem->mkdir($newDir, 0777);
                    }
                }
            }

            if ($file !== null) {
                $this->suppFilesInDir($newDir);
                $dir = new ImageUpload('/img/models/' . $newModelTitle . '/');
                $dir->upload($brand, $file);
            } elseif ($isEmpty !== TRUE) {
                $fileSystem->remove($newDir);
                return $this->render('Templates/Models/modelDetails.html.twig', array(
                            'form' => $form->createView(),
                            'error' => 'Vous devez choisir une image lorsque vous créez un nouveau model',
                ));
            }

            $em = $this->getDoctrine()->getManager($brand->getName());
            $em->persist($model);
            $em->flush();

            return $this->redirectToRoute('models');
        }

        return $this->render('Templates/Models/modelDetails.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function moveFiles($directory, $newDirectory) {
        $rep = opendir($directory);
        while ($file = readdir($rep)) {
            if ($file != '..' && $file != '.' && $file != '') {
                if (!is_dir($file)) {
                    copy($directory . $file, $newDirectory . $file);
                }
            }
        }
        closedir($rep);
    }

    public function displayFilesByDirectory($directory) {
        $rep = opendir($directory);
        while ($file = readdir($rep)) {
            if ($file != '..' && $file != '.' && $file != '') {
                if (!is_dir($file)) {
                    closedir($rep);
                    return $file;
                }
            }
        }
    }

    public function suppFilesInDir($directory) {
        $dir = $directory;
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    @unlink($dir . $file);
                }
                closedir($dh);
            }
        }
    }

    /**
     * @Route("/models/modelRemove/{modelId}", name="modelRemove")
     */
    public function removeModelsAction(Request $request, $modelId) {
        $session = new Session();
        $brand = $session->get('choosenBrand');
        if ($brand === null) {
            return $this->redirectToRoute('index');
        }

        $em = $this->getDoctrine()
                ->getManager($brand->getName());

        $model = $em->getRepository(Models::class)
                ->find($modelId);

        $em->remove($model);
        $em->flush();

        return $this->redirectToRoute('models');
    }

}
