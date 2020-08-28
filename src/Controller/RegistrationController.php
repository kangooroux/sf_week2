<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\EmailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EmailSender $emailSender): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des donnés de formulaire (enttité User + Mot de passe)
            $user = $form->getData();
            $password = $form->get('plainPassword')->getData(); // On peut utiliser l'objet comme un tableau $form['plainPassword']->getData()

            // encode the plain password
            $user
                ->setPassword($passwordEncoder->encodePassword($user, $password))
                ->renewToken()
            ;

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // do anything else you need here, like send an email
            // Envoie d'un Email
            $emailSender->sendAccountConfirmationEmail($user);

            // message flash
            $this->addFlash('success', 'Vous êtes désormais inscrit !');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Confirmation du compte via un lien envoyé par Email
     * @Route("/comfirm-account/{id<\d+>}/{token}", name="account_confirmation")
     */
    public function confirmAccount($id, $token, UserRepository $repository)
    {
        $user = $repository->findOneBy([
            'id' => $id,
            'token' => $token,
        ]);

        if ($user === null) {
            $this->addFlash('danger', 'Utilisateur ou jeton invalide');
            return $this->redirectToRoute('app_login');
        }

        // Utilisateur trouvé: confirmation du compte
        $user
            ->confirmAccount()
            ->renewToken()
        ;

        $this->entityManager->flush();

        $this->addFlash('success', 'Votre compte est comfirmé');
        return $this->redirectToRoute('app_login');
        
    }
}
