<?php

namespace App\Controller;

use App\Async\Message\SimpleEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\AmqpExt\AmqpStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SimpleController
 */
class SimpleController extends AbstractController
{
    /**
     * @param Request $request
     * @param MessageBusInterface $bus
     *
     * @return JsonResponse
     *
     * @Route("/emailsender", name="app_email_sender", methods={"POST"})
     */
    public function number(Request $request, MessageBusInterface $bus)
    {
        $req = json_decode($request->getContent(), true);
        $bus->dispatch(new SimpleEmail($req['email'], $req['body'], $req['subject']), [new AmqpStamp('email')]);

        return $this->json('ok');
    }
}
