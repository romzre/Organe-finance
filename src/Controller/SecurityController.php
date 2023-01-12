<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setRoles(['ROLE_USER']);
            $user->setIsVerify(1)
                ->setToken("balbalbrlbalrlbalrbalrblarlbar");

            $hashedPassword = $hasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
            $manager->flush($user);

            $this->addFlash("success", "Votre inscription a bien été réalisé");
        }

        return $this->render('security/registration.html.twig', [
            'controller_name' => 'SecurityController',
            'registration_form' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/connexion" , name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils )
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error instanceof BadCredentialsException) {
            $error= [];
            $error["message"] = "Mot de passe et/ou adresse email incorrect";
        }
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            "error" => $error,
            "lastUsername" => $lastUsername
        ]);
    }


    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
