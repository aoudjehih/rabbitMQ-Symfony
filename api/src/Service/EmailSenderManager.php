<?php


namespace App\Service;

use \Swift_Mailer;

/**
 * Class EmailSenderManager
 */
class EmailSenderManager
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * EmailSenderManager constructor.
     *
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param \Swift_Message $message
     *
     * @return int
     */
    public function sendEmail(\Swift_Message $message): int
    {
        return $this->mailer->send($message);
    }
}
