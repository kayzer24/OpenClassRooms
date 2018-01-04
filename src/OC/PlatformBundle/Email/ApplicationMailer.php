<?php
namespace OC\PlatformBundle\Email;


use OC\PlatformBundle\Entity\Application;

class ApplicationMailer
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendNewNotification(Application $application)
    {
        $message = new \Swift_Message(
            'Nouvelle Candidature',
            'Vous avez reçu une nouvelle candidature.'
        );

        $message
            ->addTo($application->getAdvert()->getEmail()) // Ici il faudrait un attribut "email
            ->addFrom('dante2410@hotmail.fr');
        ;

        $this->mailer->send($message);

    }
}