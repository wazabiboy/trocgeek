<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\UsersAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UsersAuthenticator $authenticator): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);


        // if ($form->isSubmitted() && $form->isValid()) {
        //     //On vérifie si le champ "recaptcha-response" contient une valeur
        //    $key_secret = '6LdB3AsbAAAAAO0QvB-hH46MciNIr_mmCOpmpntG';
        //    $g_response = $_POST['recaptcha-response'];
        //    $url = 'https://www.google.com/recaptcha/api/siteverify';
        //    $verifyResponse = file_get_contents($url.'?secret='.$key_secret.'&response='.$g_response);

        //    $response_final = json_decode($verifyResponse);

        
   // That's all !
   $register = new RegistrationFormType();
  
   
        


        if ($form->isSubmitted() && $form->isValid()) {
            //On vérifie si le champ "recaptcha-response" contient une valeur
           $key_secret = '6LcdSL0aAAAAAMtHXM3MR_ebvo-y3LMmCl6GASkT';
           $g_response = $_POST['recaptcha-response'];
           $url = 'https://www.google.com/recaptcha/api/siteverify';
           $verifyResponse = file_get_contents($url.'?secret='.$key_secret.'&response='.$g_response);

           $response_final = json_decode($verifyResponse);

           if($response_final->success){

             $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($register);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('main');

           } else {
            echo "Error";
            
           }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@petitesannonces.test', 'PetitesAnnonces.test'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }



    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');



        

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_home');
    }

}