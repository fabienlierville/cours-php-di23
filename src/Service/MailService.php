<?php
namespace src\Service;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class MailService
{

    private Mailer $mailer;

    public function __construct()
    {
        $transport = Transport::fromDsn("smtp://3dd84281bc8679:8a9180301c670a@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login");
        $this->mailer = new Mailer($transport);
    }

    // $from pourra être simple "fabien@fabien.com" ou bien ["Fabien LIERVILLE" => "fabien@fabien.com"]
    // $to peut être soit un mail (String) ou un ensemble de mail (array)
    public function send(array|String $from, array|String $to, String $subjet, String $html){
        //Concevoir le message
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subjet)
            ->html($html);

        //Envoyer le message
        $this->mailer->send($email);

    }

}
