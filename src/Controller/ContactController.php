<?php
namespace src\Controller;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController {

    public function form(){
        return $this->twig->render('Contact/form.html.twig');
    }

    public function send(){
        // Instancier / configurer Symfony Mailer
        $transport = Transport::fromDsn("smtp://3dd84281bc8679:8a9180301c670a@sandbox.smtp.mailtrap.io:2525");
        $mailer = new Mailer($transport);
        // Concevoir & envoyer le message
        $email = (new Email())
            ->from($_POST["mail"])
            ->to("admin@blogcesi.fr")
            ->subject("Nouveau message de contact")
            ->html("<h1>Nouveau message de contact</h1> {$_POST["message"]}");
        $mailer->send($email);
        header("location:/Contact/form");
    }
}