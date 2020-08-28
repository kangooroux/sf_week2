<?php


namespace App\Service;


use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Service chargé de créer et d'envoyer des Emails
 */
class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Créer un email préconfiguré
     * @param string $subject Le sujet du mail
     * @return TemplatedEmail
     */

    private function createTemplatedEmail(string $subject) :TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from(new Address('bousquetalexandrepro@gmail.com', 'Alexandre'))       # éxpéditeur
            ->subject("\u{1F3A7} Ktest | $subject")                                        # Objet de l'Email
        ;
    }

    /**
     * Enovoyer un Email de confirmation de compte suite à l'inscription
     * @param User $user L'uttilisateur devant confirmer son compte
     */
    public function sendAccountConfirmationEmail(User $user): void
    {
        $email = $this->createTemplatedEmail('Confirmation compte')
            ->to(new Address($user->getEmail(), $user->getPseudo()))            # Destination
            ->htmlTemplate('email/account_confirmation.html.twig')      # Template twig du message
            ->context([                                                         # Variable du template
                'user' => $user,
            ])
        ;

        $this->mailer->send($email);
    }

}