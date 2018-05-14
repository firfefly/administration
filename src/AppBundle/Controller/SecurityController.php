<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Form\SecurityType;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('Templates/security/connection.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
        ));
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscriptionUser(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setRoles(array('ROLE_USER'));
        $user->setIsActive(1);

        $form = $this->createForm(SecurityType::class, null, array());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user = $form->getData();
            $user->setPassword($encoded);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');
            return $this->redirectToRoute('index');
        }

        return $this->render('Templates/security/inscription.html.twig', array(
            'form' => $form->createView()
        ));
    }

}