<?php

namespace App\Async\Handler;

use App\Async\Message\SimpleEmail;
use App\Service\EmailSenderManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Twig\Environment;

/**
 * Class SimpleEmailHandler
 */
class SimpleEmailHandler implements MessageHandlerInterface
{
    /**
     * @var Environment
     */
    private $templating;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EmailSenderManager
     */
    private $emailSenderManager;

    /**
     * SimpleEmailHandler constructor.
     *
     * @param Environment $templating
     * @param LoggerInterface $logger
     * @param EmailSenderManager $emailSenderManager
     */
    public function __construct(Environment $templating, LoggerInterface $logger, EmailSenderManager $emailSenderManager)
    {
        $this->templating = $templating;
        $this->logger = $logger;
        $this->emailSenderManager = $emailSenderManager;
    }

    /**
     * @param SimpleEmail $message
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(SimpleEmail $message)
    {
        $this->logger->debug(sprintf('Send Email in progress for %s', $message->getEmailAddress()));
        $body = $this->templating->render('email/send-email.html.twig', [
            'addressEmail' => $message->getEmailAddress(),
            'bodyContent' => $message->getEmailBody(),
        ]);

        if (rand(0,1) == 1) {
            // exception to avoid retrying
            throw new UnrecoverableMessageHandlingException();
        }

        $swiftMessage = (new \Swift_Message($message->getEmailSubject()))
            ->setFrom('symfony@rabbitmq.com')
            ->setTo($message->getEmailAddress())
            ->setBody($body)
        ;

        $isEmailSent = $this->emailSenderManager->sendEmail($swiftMessage);

        if ($isEmailSent) {
            $this->logger->info('Email sent with success!');
        } else {
            throw new \LogicException("this exception is not handled");
        }
    }
}
