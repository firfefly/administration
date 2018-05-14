<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Models;
use AppBundle\Form\ModelType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use AppBundle\Services\ImageUpload;

class ModelsController extends Controller
{
    /**
    * @Route("/models/", name="models")
    */
    public function displayModelsAction(Request $request)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
            return $this->redirectToRoute('index');
        }

        $modelsList = $this->getDoctrine()
                        ->getManager($brand->getName())
                        ->getRepository(Models::class)
                        ->findAll();

        return $this->render('Templates/Models/modelsManagement.html.twig', array(
            'modelsList' => $modelsList,
            'brand' => $brand,
        ));
    }


    /**
    * @Route("/modelDetails/{modelIdSlug}", name="modelDetails")
    */
    public function modelDetailsAction(Request $request, $modelIdSlug)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
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

        if ($form->isSubmitted())
        {
            $fileSystem = new Filesystem();
            $model = $form->getData();
            $file = $form['imageindir']->getData();


            $newModelTitle = strtolower($model->getTitle());
            $newDir = '../../'.$brand->getDir().'/img/models/'.$newModelTitle.'/';
            $previousDir = '../../'.$brand->getDir().'/img/models/'.$previousModelTitle.'/';
            $test=0;
            $exists = $fileSystem->exists($newDir);

                if ($previousModelTitle !== $newModelTitle) {
                    if ($exists === true) {
                        return $this->render('Templates/Models/modelDetails.html.twig', array(
                            'form' => $form->createView(),
                            'brand' => $brand,
                            'error' => 'Ce dossier existe déjà. Changez le titre',
                        ));
                    } else {
                        if ($previousModelTitle !== '') {
                            $test = 1;
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
                    $dir = new ImageUpload('/img/models/'.$newModelTitle.'/');
                    $dir->upload($brand, $file);
                } elseif ($test !='1') {
                    $fileSystem->remove($newDir);
                    return $this->render('Templates/Models/modelDetails.html.twig', array(
                            'form' => $form->createView(),
                            'brand' => $brand,
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
            'brand' => $brand,
        ));
    }

    public function moveFiles($directory, $newDirectory)
    {
       $rep=opendir($directory);
        while ($file = readdir($rep)) {
            if($file != '..' && $file !='.' && $file !='') {
                if(!is_dir($file)) {
                    copy($directory.$file, $newDirectory.$file);
                }
            }
        }
        closedir($rep);
    }

    public function displayFilesByDirectory($directory)
    {
        $rep=opendir($directory);
        while ($file = readdir($rep)) {
            if($file != '..' && $file !='.' && $file !='') {
                if(!is_dir($file)) {
                    closedir($rep);
                    return $file;
                }
            }
        }
    }

    public function suppFilesInDir($directory)
    {
        $dir = $directory;
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    @unlink($dir.$file);
                }
                closedir($dh);
            }
        }
    }


    /**
    * @Route("/modelRemove/{modelId}", name="modelRemove")
    */
    public function removeModelsAction(Request $request, $modelId)
    {
        $bag = new \AppBundle\Services\Bag('choosenBrand');
        $brand = $bag->get('brand');

        if ($brand === null || $brand->getName() === null) {
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